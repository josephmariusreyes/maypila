<?php

namespace App\Services\CompanyService;

use App\DTO\Company\CreateCompanyDto;
use App\DTO\Company\UpdateCompanyDto;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CompanyService implements ICompanyService
{
    public function createCompany(CreateCompanyDto $createCompanyDto, User $actor): Company
    {
        return DB::transaction(function () use ($createCompanyDto) {
            return Company::create([
                'name' => $createCompanyDto->name,
                'description' => $createCompanyDto->description,
            ])->refresh();
        });
    }

    public function updateCompany(UpdateCompanyDto $updateCompanyDto, User $actor): Company
    {
        return DB::transaction(function () use ($updateCompanyDto) {
            $company = Company::findOrFail((int) $updateCompanyDto->id);

            $company->update([
                'name' => $updateCompanyDto->name,
                'description' => $updateCompanyDto->description,
            ]);

            return $company->refresh();
        });
    }

    public function getCompanyById(int $id): ?Company
    {
        return Company::find($id);
    }

    public function getAllCompany(): Collection
    {
        return Company::query()->get();
    }
}
