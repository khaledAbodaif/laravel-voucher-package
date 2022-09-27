<?php

namespace Khaleds\Voucher\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    use HasFactory;

    protected $table='user_voucher';

    protected $guarded=['id'];

}
