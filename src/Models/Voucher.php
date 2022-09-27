<?php

namespace Khaleds\Voucher\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $guarded=['id'];


    public function Users(){

        return $this->hasMany(UserVoucher::class)->orderBy('created_at');
    }

    public function implementation(){

        return $this->belongsTo(VoucherImplementation::class,'voucher_implementation_id');
    }

    public function audience(){

        return $this->hasMany(VoucherAudience::class);
    }
}
