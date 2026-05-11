<?php

namespace App\Services\Customer;

use App\DTO\Customer\AddCustomerToQueDto;
use App\DTO\Customer\UpdateCustomerDto;
use App\Enum\CustomerStatus;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CustomerService implements ICustomerService
{
	public function addCustomerToQue(AddCustomerToQueDto $addCustomerDto, User $actor): Customer
	{
		$actor->loadMissing('queue_session');
		$queueSessionId = $actor->queue_session?->id;

		if (!$queueSessionId) {
			throw new \RuntimeException('Actor has no active queue session.');
		}

		return DB::transaction(function () use ($addCustomerDto, $queueSessionId) {
			$nextQueNumber = Customer::where('queue_session_id', $queueSessionId)
				->lockForUpdate()
				->max('que_number');

			return Customer::create([
				'queue_session_id' => $queueSessionId,
				'first_name' => $addCustomerDto->firstName,
				'last_name' => $addCustomerDto->lastName,
				'mobile_number' => $addCustomerDto->mobileNumber,
				'customer_status' => CustomerStatus::Pending->value,
				'que_number' => ($nextQueNumber ?? 0) + 1,
			]);

			//todojeph: log an event here, i will events
		});
	}

	public function updateCustomer(UpdateCustomerDto $updateCustomerDto, User $actor): Customer
	{
		$customer = Customer::findOrFail($updateCustomerDto->id);

		$customer->customer_status = CustomerStatus::from($updateCustomerDto->customerStatus)->value;
		$customer->save();

		return $customer->refresh();
	}

	public function getCustomerById(int $id): Customer
	{
    	return Customer::findOrFail($id);
	}

	public function getAllCustomer(): Collection
	{
    	return Customer::all();
	}
}
