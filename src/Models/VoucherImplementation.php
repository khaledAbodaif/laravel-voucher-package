<?php

namespace Khaleds\Voucher\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherImplementation extends Model
{
    use HasFactory;
    
    protected $casts=["value"=>"array",'name'=>'array'];
    protected $guarded=['id'];
}
