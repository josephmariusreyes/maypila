<?php

namespace App\Listeners\CustomerQueue;

use App\Events\CustomerQueue\CustomerQueued;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleCustomerQueued
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
    public function handle(CustomerQueued $event): void
    {
        // Step 1: persist an audit/event-log record for this queue action.
        // \App\Models\EventLog::create([
        //     'user_id' => $event->metadata['queued_by'] ?? null,
        //     'company_id' => $event->customer->queueSession?->company_id,
        //     'event_type' => 'customer_queued',
        //     'event_description' => sprintf(
        //         'Customer %s %s was added to the queue.',
        //         $event->customer->first_name,
        //         $event->customer->last_name,
        //     ),
        //     'metadata' => [
        //         'customer_id' => $event->customer->id,
        //         'queue_session_id' => $event->customer->queue_session_id,
        //         'que_number' => $event->customer->que_number,
        //         'queued_by' => $event->metadata['queued_by'] ?? null,
        //     ],
        // ]);

        // Step 2: dispatch a separate realtime event so the UI can refresh the customer list.
        // This keeps the domain event internal and lets the broadcast event focus on UI payloads.
        // \App\Events\CustomerQueue\CustomerListUpdated::dispatch(
        //     queueSessionId: $event->customer->queue_session_id,
        //     customerId: $event->customer->id,
        //     action: 'queued',
        // );

        // Step 3: if the UI needs the full updated list instead of a lightweight signal,
        // query the latest customers here first, then pass that payload to the broadcast event.
        // $customers = \App\Models\Customer::query()
        //     ->where('queue_session_id', $event->customer->queue_session_id)
        //     ->orderBy('que_number')
        //     ->get();
        //
        // \App\Events\CustomerQueue\CustomerListUpdated::dispatch(
        //     queueSessionId: $event->customer->queue_session_id,
        //     customerId: $event->customer->id,
        //     action: 'queued',
        //     customers: $customers->toArray(),
        // );
    }
}
