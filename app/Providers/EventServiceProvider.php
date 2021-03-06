<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\WebUserLogin' => [
            'App\Listeners\WebUserLoginListener',
        ],
        'App\Events\AdminUserLogin' => [
            'App\Listeners\AdminUserLoginListener',
        ],
        'App\Events\SendSms' => [
            'App\Listeners\SendSmsListener',
        ],
        'App\Events\SellerUserLogin' => [
            'App\Listeners\SellerUserLoginListener'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
