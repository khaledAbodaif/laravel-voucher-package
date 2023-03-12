<?php

namespace Khaleds\Voucher\Seeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends \Database\Seeders\DatabaseSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(VoucherImplementaionSeeder::class);
    }
}