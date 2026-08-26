<?php

namespace App\Jobs;

use App\Mail\UserAddedToQueueEmail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class sendEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public User $user,
        public array $metadata = []
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->user->email)->send(
            new UserAddedToQueueEmail(
                user: $this->user,
                metadata: $this->metadata
            )
        );
    }
}
