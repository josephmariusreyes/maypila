<?php
namespace App\DTO\User;

class CreateUserDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {}
}