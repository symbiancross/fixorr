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
        'App\Events\UserRegistered' => [
            'App\Listeners\SendVerificationEmail',
        ],
        'App\Events\UserRequestedVerificationEmail' => [
            'App\Listeners\SendVerificationEmail',
        ],
        'App\Events\TukangRegistered' => [
        'App\Listeners\SendVerificationEmailTukang',
        ],
        'App\Events\TukangRequestedVerificationEmail' => [
            'App\Listeners\SendVerificationEmailTukang',
        ],
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
