<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_implementations', function (Blueprint $table) {
            $table->id();

            $table->json('name');

            $table->string(('class'));
            // value name like service, area,category,company, this object will show the audience table to choose per key
            //usable_type and name
            // default mean model and id to check
            // or array of [vouchers,model type]
            $table->json('value');
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
        Schema::dropIfExists('voucher_implementations');
    }
};
