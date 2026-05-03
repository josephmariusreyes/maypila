<?php

namespace App\DTO\User;

class GetAllUserDto
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public readonly int $companyId,
        public readonly ?string $role = null)
    {}
}
