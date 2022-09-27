<?php

namespace Khaleds\Voucher\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Libraries\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Khaleds\Voucher\Http\Requests\Voucher\SetVoucherRequest;
use Khaleds\Voucher\Interfaces\VoucherAbstract;
use Khaleds\Voucher\Models\UserVoucher;
use Khaleds\Voucher\Models\Voucher;
use Khaleds\Voucher\Services\VoucherFactory;

class VoucherController extends Controller
{


    public function test(){

        try {

            return VoucherFactory::get('khaleds',User::find(1))->check()->apply(1)->get();

        }catch(\Exception $e){
            return $e->getMessage();
        }

    }

}
