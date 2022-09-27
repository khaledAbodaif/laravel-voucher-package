<?php


namespace Khaleds\Voucher\Interfaces;


interface VoucherAudienceInterface
{

    /**
     * find array with names and tables for voucher audience
     * @param int $voucherId
     * @return VoucherAudienceInterface
     */
    public static function  types(int $voucherId):static;

    /**
     * find array with recodes for specific table  and tables for voucher audience
     * @param string $table
     * @return VoucherAudienceInterface
     */
    public static function usersTable(string $table):static;

    /**
     * return response for the class
     * @return array
     */
    public static function get():array;
}
