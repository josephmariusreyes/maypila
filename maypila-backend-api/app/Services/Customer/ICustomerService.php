<?php

namespace App\Services\Customer;
use App\DTO\Customer\{
    AddCustomerToQueDto
};
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface ICustomerService
{
    public function addCustomerToQue(AddCustomerToQueDto $addCustomerDto, User $actor): Customer;
    public function updateCustomer(array $validatedCustomerData, User $actor): Customer;
    public function getCustomerById(int $id): Customer;
    public function getAllCustomer(): Collection;
}
