<?php

namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter
{
    public function __construct(private array $filters) {}

    public function apply(Builder $query)
    {
        if (!empty($this->filters['companyId'])) {
            $this->company($query);
        }

        if (!empty($this->filters['role'])) {
            $this->role($query);
        }

        return $query;
    }

    private function company(Builder $query)
    {
        $query->whereHas('companies', function ($q) {
            $q->whereKey($this->filters['companyId']);
        });
    }

    private function role(Builder $query)
    {
        $query->whereHas('roles', function ($q) {
            $q->where('roles.name', $this->filters['role']);
        });
    }
}