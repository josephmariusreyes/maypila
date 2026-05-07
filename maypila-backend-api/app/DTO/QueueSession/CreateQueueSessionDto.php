<?php
namespace App\DTO\QueueSession;

class CreateQueueSessionDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {}
}