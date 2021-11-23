<?php

namespace App\Providers;

use App\Events\Users\Auth\Registered;
use App\Listeners\Users\Auth\EmailVerificationHandler;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
            Registered::class => [
                    EmailVerificationHandler::class,
            ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
