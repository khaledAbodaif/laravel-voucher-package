<?php

namespace Khaleds\Voucher;

use Illuminate\Support\ServiceProvider;
use Khaleds\Voucher\Seeder\DatabaseSeeder;

class VoucherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
//        $this->app->register(VoucherEventServiceProvider::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadSeeders('vendor/khaleds/voucher/src/Seeder/VoucherImplementaionSeeder');

    }

    protected function loadSeeders($seed_list){
        $this->callAfterResolving(DatabaseSeeder::class, function ($seeder) use ($seed_list) {
            foreach ((array) $seed_list as $path) {
                $seeder->call($seed_list);
                // here goes the code that will print out in console that the migration was succesful
            }
        });
    }
}
