<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_voucher', function (Blueprint $table) {
            $table->id();

            //morph relation user,customer,vendor
            $table->morphs('applicable');

            $table->foreignId('voucher_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->float('amount')->nullable();
            $table->boolean('is_fixed_amount')->nullable();

            //is user apply the voucher and ner used like client rejected him
            $table->boolean('is_used')->default(0);

            $table->index('voucher_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_voucher');
    }
}
