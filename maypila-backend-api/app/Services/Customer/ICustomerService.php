<?php

namespace App\Services\Customer;
use App\Models\User;

use app\DTO\customer\{
    CreateCustomerDto,
    UpdateCUstomerDto
};

interface ICustomerService
{
    public function createCustomer(CreateCustomerDto $createCustomerDto, User $actor);
    public function updateCustomer(UpdateCUstomerDto $updateCustomerDto, User $actor);
    public function getCustomerById(int $id);
    public function getAllCustomer();
}
