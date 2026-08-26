<?php

namespace App\Events\User;

use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserAddedToOnlineQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public User $user,
        public array $metadata = []
    ) {}
}
