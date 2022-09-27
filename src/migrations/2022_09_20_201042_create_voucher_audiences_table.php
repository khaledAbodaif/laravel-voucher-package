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
        Schema::create('voucher_audiences', function (Blueprint $table) {
            $table->id();

            //morph relation if the audience user ,vendor
            // contribute category,service,product
            $table->morphs('usable');

            $table->foreignId('voucher_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            // all id's in this table all users,vendors etc
            $table->boolean('is_all')->default(1);

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
        Schema::dropIfExists('voucher_audiences');
    }
};
