<?php 
namespace App\DTO\Company;

class CreateCompanyDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $company_email,
        public readonly string $description
    )
    {
    }
}