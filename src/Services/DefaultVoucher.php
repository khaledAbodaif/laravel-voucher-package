<?php


namespace Khaleds\Voucher\Services;


use Illuminate\Database\Eloquent\Model;
use Khaleds\Voucher\Interfaces\VoucherAbstract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultVoucher extends VoucherAbstract
{



    public function check():self{

        parent::check();

        if ($this->voucher) {

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

    public function append(array $data):mixed{

        return [];
    }
}
