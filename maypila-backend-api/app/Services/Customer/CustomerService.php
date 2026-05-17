<?php

namespace App\Services\Customer;

use App\DTO\Customer\Requests\AddCustomerToQueDto;
use App\Enum\CustomerStatus;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Events\CustomerQueue\CustomerQueued;
use App\DTO\Customer\Response\GetCustomeQueStatusResponseDto;

class CustomerService
{
	public function addCustomerToQue(AddCustomerToQueDto $addCustomerDto, User $actor): Customer
	{
		$actor->loadMissing('queue_session');
		$queueSessionId = $actor->queue_session?->id;
		$actorId = $actor->id;

		if (!$queueSessionId) {
			throw new \RuntimeException('Actor has no active queue session.');
		}

		$customerDbTransaction = DB::transaction(function () use ($addCustomerDto, $queueSessionId, $actorId) {
			$nextQueNumber = Customer::where('queue_session_id', $queueSessionId)
				->lockForUpdate()
				->max('que_number');

			$customer = Customer::create([
				'queue_session_id' => $queueSessionId,
				'first_name' => $addCustomerDto->firstName,
				'last_name' => $addCustomerDto->lastName,
				'mobile_number' => $addCustomerDto->mobileNumber,
				'customer_status' => CustomerStatus::Pending->value,
				'que_number' => ($nextQueNumber ?? 0) + 1,
			]);

			DB::afterCommit(function () use ($customer, $actorId) {
				CustomerQueued::dispatch(
					customer: $customer,
					metadata: [
						'queued_by' => $actorId,
					]
				);
			});

			return $customer;
		});

		return $customerDbTransaction;
	}

	public function updateCustomer(array $validatedCustomerData, User $actor): Customer
	{
		$customer = Customer::findOrFail($validatedCustomerData['id']);
		$customer->customer_status = CustomerStatus::from($validatedCustomerData['customerStatus'])->value;
		$customer->save();

		//i will use $actor for event logging
		
		return $customer->refresh();
	}

	public function getCustomerById(int $id): Customer
	{
    	return Customer::findOrFail($id);
	}

	public function getCustomeQueStatus(int $mobileNumber): GetCustomeQueStatusResponseDto
	{
		return new GetCustomeQueStatusResponseDto(
			queueNumber:0,
			currentlyService:[],
			estimatedWaitingTime:0
		);
	}

	public function getAllCustomer(): Collection
	{
    	return Customer::all();
	}
}
