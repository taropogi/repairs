<?php

namespace App\Providers;

use App\Events\CpoDeleted;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\CpoUpdated;
use App\Listeners\UpdateCpoTotal;
use App\Listeners\UpdateRmaNumberCpoDeleted;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CpoUpdated::class => [
            UpdateCpoTotal::class,
        ],
        CpoDeleted::class => [
            UpdateRmaNumberCpoDeleted::class
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
    }
}
