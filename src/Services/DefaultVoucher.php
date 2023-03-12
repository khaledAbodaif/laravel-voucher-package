<?php


namespace Khaleds\Voucher\Services;


use Illuminate\Database\Eloquent\Model;
use Khaleds\Voucher\Interfaces\VoucherAbstract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Khaleds\Voucher\Models\VoucherAudience;

class DefaultVoucher extends VoucherAbstract
{



    public function check():self{

        parent::check();

        if ($this->voucher && count($this->voucher->audience)) {

            $pass = 0;
            foreach ($this->voucher->audience as $audience) {
                if ($audience->usable_type == $this->model->getTable() && $audience->is_all == 1) {
                    $pass = 1;
                    break;
                }
                if ($audience->usable_id == $this->model->getAttribute('id') && $audience->usable_type == $this->model->getTable()) {
                    $pass = 1;
                    break;
                }
            }

            if (!$pass)
                $this->voucher=null;

        }

        return $this;

    }

    public function append(array $arguments): mixed
    {

        if ($this->voucher) {

            $tables = $this->voucher->audience->pluck('usable_type')->unique();
            $validated = [];


            foreach ($tables as $table) {
                if (array_key_exists($table, $arguments))
                    $validated[$table] = $arguments[$table];
            }
            $arr = [];
            foreach ($validated as $key => $argument) {

                $arr[] = VoucherAudience::
                where('voucher_id', $this->voucher->id)
                    ->where(function ($query) use ($argument, $key) {
                        $query->where(function ($query) use ($argument, $key) {
                            $query->where('usable_type', $key)->where('is_all', 1);
                        })->orWhere(function ($query) use ($argument, $key) {
                            $query->where('usable_type', $key)->whereIn('usable_id', $argument);
                        });
                    })
                    ->count();
            }


            if (in_array(0, $arr) || empty($arr))
                $this->voucher = null;
        }

        return $this;
    }
}
