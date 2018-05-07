<?php

namespace App\Listeners;

use Mail;
use App\Mail\SendVerificationTokenTukang;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerificationEmailTukang
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TukangRequestedVerificationEmail  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->user)->send(new SendVerificationTokenTukang($event->user->verificationToken));
    }
}
