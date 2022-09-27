<?php


namespace Khaleds\Voucher\Interfaces;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Khaleds\Voucher\Models\UserVoucher;
use Khaleds\Voucher\Models\Voucher;


abstract class VoucherAbstract
    implements VoucherInterface
//    implements VoucherAudienceInterface
{

    public ?Voucher $voucher;

    public function __construct(
        protected string $code,
        protected Model $model
    )
    {}


    public function check(): self
    {

        $this->voucher = Voucher::
        where('is_available', 1)
            ->where('code', $this->code)
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>=', now())
            ->whereRaw('uses < max_uses')
            ->withCount(['Users' => function ($query)  {
                $query->where('applicable_type', $this->model->getTable())
                    ->where('applicable_id', $this->model->getAttribute('id'))
                    ->where('is_used', 1);

            }])
            ->having('users_count', '<', DB::raw('max_uses_user'))
            ->first();

        return $this;

    }

    public function apply(bool $is_used, string $voucher = null, Model $model = null): self
    {

        if ($voucher && $model) {

            $this->voucher = Voucher::where('code',$voucher)->first();
            $this->model = $model;

        }
        if ($this->voucher) {
            UserVoucher::updateOrCreate(
                [
                    'applicable_type' => $this->model->getTable(),
                    'applicable_id' => $this->model->getAttribute('id'),
                    'voucher_id' => $this->voucher->id,
                    'is_used' => 0,
                ]
                ,
                [
                    'amount' => $this->voucher->amount,
                    'is_fixed_amount' => $this->voucher->is_fixed,
                    'is_used' => $is_used,
                ]);

            if ($is_used)
                $this->voucher->increment('uses');
        }

        return $this;

    }

    public function get():Voucher
    {

        if ($this->voucher)
            return $this->voucher;

        throw new \Exception("Voucher Has Limit");
    }

    abstract public function append(array $arguments):mixed;


}
