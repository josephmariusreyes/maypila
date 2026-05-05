<?php

namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use App\DTO\User\{
	GetAllUserDto
};

class UserFilter
{
    public function __construct(private GetAllUserDto $dto) {}

    public function apply(Builder $query)
    {
        if ($this->dto->companyId) {
            $this->company($query);
        }

        if ($this->dto->role) {
            $this->role($query);
        }

        return $query;
    }

    private function company(Builder $query)
    {
        $query->whereHas('companies', function ($q) {
            $q->whereKey($this->dto->companyId);
        });
    }

    private function role(Builder $query)
    {
        $query->whereHas('roles', function ($q) {
            $q->where('roles.name', $this->dto->role);
        });
    }
}