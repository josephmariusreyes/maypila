<?php 
namespace App\DTO\Company;

class UpdateCompanyDto {

    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $description
    )
    { }    
}