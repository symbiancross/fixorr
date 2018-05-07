<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Tukang;
use Mail;
use App\Events\TukangRegistered;
use App\Providers\Event;

class TukangEloquentEventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Tukang::created(function($user) {
 
            $token = $user->verificationToken()->create([
                'token' => bin2hex(random_bytes(32))
            ]);
     
            event(new TukangRegistered($user));
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
