<?php


namespace Khaleds\Voucher\Services;


use App\Models\Cart;
use App\Models\CartHeader;
use App\Models\OrderHeader;
use App\Models\OrderLine;
use Khaleds\Voucher\Models\UserVoucher;
use Khaleds\Voucher\Models\Voucher;

class VoucherNew
{

    private $voucher;
    public $user_id;
    public $createdForUserId;
    public $code;

    public function checkVoucher() {

        $voucher=$this->getVoucher();

        if(empty($voucher)||$voucher->is_available != 1 || $voucher->starts_at > now() ||
            $voucher->expires_at < now() ||$voucher->uses == $voucher->max_uses ||$voucher->max_uses_user == $voucher->users_count)
            return false;

        $this->voucher = $voucher;
        return true;
    }

    public function getVoucher(){

        return Voucher::where('code',$this->code)
            ->withCount(['Users' => function ($query)  {
            $query->where('user_id', $this->user_id);

        }])->first();
    }


    public function setVoucher(){



        $orderHeader=CartHeader::where('user_id', $this->user_id)->where('created_for_user_id',$this->createdForUserId)->first();
        $orderLines=Cart::where('user_id', $this->user_id)->where('created_for_user_id',$this->createdForUserId)->get();

        if (!empty($orderHeader)) {
            if ($this->voucher->discount_type == 'Fixed') {
                $orderHeader->total_products_after_discount -= $this->voucher->discount_amount;
                foreach ($orderLines as $orderLine) {
                    $orderLine->price -= $this->voucher->discount_amount;
                    $orderLine->save();
                }
            }
            elseif ($this->voucher->discount_type == 'Percent') {
                $orderHeader->total_products_after_discount -= ($orderHeader->total_products_after_discount * ($this->voucher->discount_amount / 100));
                foreach ($orderLines as $orderLine) {
                    $orderLine->price -= ($orderLine->price * ($this->voucher->discount_amount / 100));
                    $orderLine->save();
                }
            }


            $orderHeader->discount_amount = $this->voucher->discount_amount;
            $orderHeader->discount_type = $this->voucher->discount_type;

            $orderHeader->save();

            $this->addUserToVoucher();
            $this->updateVoucher();

        }

    }

        private function addUserToVoucher(){

        UserVoucher::create([
           'user_id' => $this->user_id,
            'voucher_id' => $this->voucher->id,
            'status' =>'Used'
        ]);

        }

        private function updateVoucher(){

        $this->voucher->uses +=1;
        $this->voucher->save();
        }



}
