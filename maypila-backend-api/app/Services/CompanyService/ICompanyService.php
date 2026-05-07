<?php

namespace App\Services\CompanyService;

use App\DTO\Company\ {
    CreateCompanyDto,
    UpdateCompanyDto
};
use App\Models\User;

interface ICompanyService
{
    public function createCompany(CreateCompanyDto $createCompanyDto, User $actor);
    public function updateCompany(UpdateCompanyDto $createCompanyDto, User $actor);
    public function getCompanyById(int $id);
    public function getAllCompany();
}
