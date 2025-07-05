<?php

namespace App\Listeners;

use App\Events\PasswordResetSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\PasswordResetSuccessMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetSuccessEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PasswordResetSuccess $event): void
    {
        Mail::to($event->user->email)->queue(new PasswordResetSuccessMail($event->user));
    }
}
