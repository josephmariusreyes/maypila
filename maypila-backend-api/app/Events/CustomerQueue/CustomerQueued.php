<?php

namespace App\Events\CustomerQueue;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;

class CustomerQueued
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Customer $customer,
        public array $metadata = []
    ) {}
}