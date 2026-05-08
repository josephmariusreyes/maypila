<?php
namespace App\DTO\User;

class UpdateUserDto
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $name,
        public readonly ?string $email,
        public readonly ?string $password,
        public readonly ?string $role,
        public readonly ?int $companyId,
        public readonly ?string $mobileNumber,
    ) {}


}