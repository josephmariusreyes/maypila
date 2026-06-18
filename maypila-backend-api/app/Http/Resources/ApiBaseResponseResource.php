<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiBaseResponseResource extends JsonResource
{
    protected bool $success;
    protected string $message;
    protected ?array $meta;

    public function __construct(
        mixed $resource = null,
        bool $success = true,
        string $message = 'Success',
        ?array $meta = null
    ) {
        parent::__construct($resource);

        $this->success = $success;
        $this->message = $message;
        $this->meta = $meta;
    }

    public function toArray($request): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data' => $this->resource,
            'meta' => $this->meta,
        ];
    }
}