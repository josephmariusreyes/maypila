<?php

namespace App\Http\Resources\QueueSession;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QueueSessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'created_by' => $this->created_by,
            'company_id' => $this->company_id,
            'queue_status' => $this->queue_status,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}