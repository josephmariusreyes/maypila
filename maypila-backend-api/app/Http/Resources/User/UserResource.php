<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'mobile_number' => $this->mobile_number,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'roles' => $this->whenLoaded('roles', fn () => $this->roles->map(fn ($role) => [
                'id' => $role->id,
                'name' => $role->name,
                'created_at' => $role->created_at,
                'updated_at' => $role->updated_at,
            ])->values()->all()),
            'companies' => $this->whenLoaded('companies', fn () => $this->companies->map(fn ($company) => [
                'id' => $company->id,
                'name' => $company->name,
                'description' => $company->description,
                'created_at' => $company->created_at,
                'updated_at' => $company->updated_at,
            ])->values()->all()),
            'queue_sessions' => $this->whenLoaded('queueSession', fn () => $this->queueSession->map(fn ($queueSession) => [
                'id' => $queueSession->id,
                'created_by' => $queueSession->created_by,
                'company_id' => $queueSession->company_id,
                'name' => $queueSession->name ?? null,
                'description' => $queueSession->description ?? null,
                'queue_status' => $queueSession->queue_status ?? null,
                'created_at' => $queueSession->created_at,
                'updated_at' => $queueSession->updated_at,
            ])->values()->all()),
        ];
    }
}
