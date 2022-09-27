<?php


namespace Khaleds\Voucher\Services;


use Illuminate\Support\Facades\DB;
use Khaleds\Voucher\Interfaces\VoucherAudienceInterface;
use Khaleds\Voucher\Models\Voucher;

class VoucherAudience implements VoucherAudienceInterface
{

    private static array $response=['status'=>true,'message'=>"","data"=>[]];

    public static function types(int $voucherId):static{

        $voucher=Voucher::find($voucherId);

        if (!$voucher) {
            self::$response['status'] = false;
            self::$response['messagae'] = "not Found";

        }

        self::$response['data']=json_decode($voucher->implementation->value);

        return new static();
    }

    public static function usersTable(string $table):static{

        try {

            $users=DB::table($table)->select('*')->get();
            self::$response['data']=$users;


        }catch (\PDOException $e) {

            self::$response['status']=false;
            self::$response['messagae']=$e->getMessage();
        }

        return new static();

    }

    public static function get():array {
        return self::$response;
    }
}
