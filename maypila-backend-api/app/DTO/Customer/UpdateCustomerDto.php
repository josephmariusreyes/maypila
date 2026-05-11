<?php

namespace App\DTO\Customer;

class UpdateCustomerDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $customerStatus,
    ) {
    }
}
