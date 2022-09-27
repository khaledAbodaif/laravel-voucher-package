<?php

namespace Khaleds\Voucher\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Khaleds\Voucher\Models\Voucher;

interface VoucherInterface
{

    /**
     * check for common voucher checks
     * @return $this
     */
    public function check():self;

    /**
     * apply voucher to user voucher table
     * create or update voucher when user apply
     * take applying status true for default false
     * @param bool $is_used
     * @param string|null $voucher
     * @param Model|null $model
     * @return $this
     */
    public function apply(bool $is_used, string $voucher = null, Model $model = null):self ;

    /**
     * @return Voucher
     */
    public function get():Voucher;


    /**
     * generic function you can use it with your new implementation class
     * @return mixed
     */
    public function append(array $arguments):mixed;

}
