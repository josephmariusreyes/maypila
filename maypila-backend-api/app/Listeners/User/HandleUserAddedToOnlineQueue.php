<?php

namespace App\Listeners\User;

use App\Events\User\UserAddedToOnlineQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class HandleUserAddedToOnlineQueue implements ShouldQueue
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
    public function handle(UserAddedToOnlineQueue $event): void
    {
        Mail::raw(
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. You have been added to an online queue.',
            function (Message $message) use ($event) {
                $message
                    ->to($event->user->email)
                    ->subject('You have been added to a queue');
            }
        );
    }
}
