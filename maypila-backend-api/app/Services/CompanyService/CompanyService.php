<?php

namespace App\Services\CompanyService;

use App\DTO\Company\CreateCompanyDto;
use App\DTO\Company\UpdateCompanyDto;
use App\DTO\User\CreateUserDto;
use App\Enum\UserRole;
use App\Models\Company;
use App\Models\User;
use App\Services\UserService\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public function __construct(private UserService $userService)
    {
    }

    public function createCompany(CreateCompanyDto $createCompanyDto, User $actor): Company
    {
        return DB::transaction(function () use ($createCompanyDto, $actor) {

            $company = new Company();
            $company->name = $createCompanyDto->name;
            $company->company_email = $createCompanyDto->company_email;
            $company->description = $createCompanyDto->description;
            $company->save();

            $this->userService->createUser(new CreateUserDto(
                name: 'Company Admin',
                email: $company->company_email,
                password: 'Password123!',
                role: UserRole::CompanyAdmin->value,
                companyId: $company->id,
                mobileNumber: '09123456789'
            ), $actor);

            return $company->refresh();
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
