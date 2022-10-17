<?php


namespace Khaleds\Voucher\Services;


use Khaleds\Voucher\Models\Voucher;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VoucherFactory
{


// if voucher model take id retuen object
    public static function get($voucher,$model,$amount)
    {

        $voucher=Voucher::with('implementation')->where('code',$voucher)->first();

        if(!$voucher)
            throw new \Exception("Invalid Voucher");

        $className= $voucher->implementation->class;

        return new $className($voucher->code,$model,$amount);


    }

}
