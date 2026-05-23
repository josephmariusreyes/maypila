<?php

namespace App\DTO\Customer\Response;

class GetCustomeQueStatusResponseDto
{
    public function __construct(
        public readonly int $queueNumber,
        public readonly array $currentlyServing,
        public readonly int $estimatedWaitingTime
    )
    {
    }
}