<?php

namespace App\Services\Customer;
use App\DTO\Customer\{
    AddCustomerToQueDto,
    UpdateCustomerDto
};
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface ICustomerService
{
    public function addCustomerToQue(AddCustomerToQueDto $addCustomerDto, User $actor): Customer;
    public function updateCustomer(UpdateCustomerDto $updateCustomerDto, User $actor): Customer;
    public function getCustomerById(int $id): Customer;
    public function getAllCustomer(): Collection;
}
