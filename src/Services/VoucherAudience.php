<?php


namespace Khaleds\Voucher\Services;


use Illuminate\Support\Facades\DB;
use Khaleds\Voucher\Models\Voucher;
use Khaleds\Voucher\Models\VoucherImplementation;

class VoucherAudience
{

    private static array $response=['status'=>true,'message'=>"","data"=>[]];

    public static function getTypes(int $voucherId){

        $voucher=Voucher::find($voucherId);

        if (!$voucher) {
            self::$response['status'] = false;
            self::$response['messagae'] = "not Found";

            return self::$response;
        }

        self::$response['data']=json_decode($voucher->implementation->value);

        return self::$response;
    }

    public static function getUsersTable(string $table){

        try {

            $users=DB::table($table)->select('*')->get();
            self::$response['data']=$users;

            return self::$response;

        }catch (\PDOException $e) {

            self::$response['status']=false;
            self::$response['messagae']=$e->getMessage();
            return self::$response;
        }


    }
}
