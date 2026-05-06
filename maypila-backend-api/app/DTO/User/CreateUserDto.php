<?php
namespace App\DTO\User;

class CreateUserDto
{
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?string $password,
        public readonly ?string $role,
        public readonly int $companyId,
        public readonly int $mobile_number
    ) {}
}