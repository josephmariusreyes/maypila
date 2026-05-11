<?php

namespace App\DTO\Customer;

class AddCustomerToQueDto
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $mobileNumber,
    ) {
    }
}
