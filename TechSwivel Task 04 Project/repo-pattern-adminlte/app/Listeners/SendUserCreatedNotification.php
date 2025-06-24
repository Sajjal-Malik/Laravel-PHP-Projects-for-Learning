<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreatedMail;

class SendUserCreatedNotification
{
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
    public function handle(UserCreated $event): void
    {
        Mail::to('admin@example.com')->send(new UserCreatedMail($event->user));
    }
}
