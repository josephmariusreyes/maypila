<?php

namespace App\Exceptions;

use Exception;

class AppBaseException extends Exception
{
    protected array $meta;

    public function __construct(
        string $message = 'Error',
        int $code = 400,
        array $meta = []
    ) {
        parent::__construct($message, $code);

        $this->meta = $meta;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }
}