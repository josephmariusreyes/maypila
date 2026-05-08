<?php

namespace App\DTO\Customer;

class UpdateCustomerDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $mobileNumber,
    ) {
    }
}
