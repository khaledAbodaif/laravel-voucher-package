<?php

namespace Khaleds\Voucher;
use App\Events\FreeAccountPaid;
use App\Events\User\GettingInfo;
use App\Events\User\LoggedIn;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Khaleds\Voucher\Listeners\ChangeVoucherStatus;
use Khaleds\Voucher\Listeners\CheckAndApplyVoucher;

class VoucherEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        GettingInfo::class=>[
            CheckAndApplyVoucher::class
        ],
        LoggedIn::class=>[
            CheckAndApplyVoucher::class
        ],
        FreeAccountPaid::class=>[
            ChangeVoucherStatus::class
        ]

    ];
    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
        parent::boot();

    }
}
