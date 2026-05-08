<?php

namespace App\Services\Customer;

use App\DTO\Customer\CreateCustomerDto;
use App\DTO\Customer\UpdateCustomerDto;
use App\Models\User;

class CustomerService implements ICustomerService
{
	public function createCustomer(CreateCustomerDto $createCustomerDto, User $actor)
	{
		throw new \BadMethodCallException('Not implemented yet.');
	}

	public function updateCustomer(UpdateCustomerDto $updateCustomerDto, User $actor)
	{
		throw new \BadMethodCallException('Not implemented yet.');
	}

	public function getCustomerById(int $id)
	{
		throw new \BadMethodCallException('Not implemented yet.');
	}

	public function getAllCustomer()
	{
		throw new \BadMethodCallException('Not implemented yet.');
	}
}
