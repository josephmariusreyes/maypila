<?php
namespace App\DTO\User;

class UpdateUserDto
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null,
    ) {}


}