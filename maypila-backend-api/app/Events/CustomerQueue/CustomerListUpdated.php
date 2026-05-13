<?php

namespace App\Events\CustomerQueue;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerListUpdated
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public int $queueSessionId,
        public int $customerId,
        public string $action,
        public array $customers = [],
    ) {
        // Later, if you want this event to broadcast to the frontend, implement
        // Illuminate\Contracts\Broadcasting\ShouldBroadcast and keep these values
        // as the payload the UI needs to refresh its customer list.
    }

    // Later add something like this:
    // public function broadcastOn(): array
    // {
    //     return [
    //         new \Illuminate\Broadcasting\PrivateChannel(
    //             'queue-session.' . $this->queueSessionId
    //         ),
    //     ];
    // }

    // Later add something like this:
    // public function broadcastAs(): string
    // {
    //     return 'customer.list.updated';
    // }

    // Later add something like this:
    // public function broadcastWith(): array
    // {
    //     return [
    //         'queue_session_id' => $this->queueSessionId,
    //         'customer_id' => $this->customerId,
    //         'action' => $this->action,
    //         'customers' => $this->customers,
    //     ];
    // }
}