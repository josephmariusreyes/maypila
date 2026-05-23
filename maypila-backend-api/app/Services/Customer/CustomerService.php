<?php

namespace App\Services\Customer;

use App\DTO\Customer\Requests\AddCustomerToQueDto;
use App\Enum\CustomerStatus;
use App\Exceptions\AppBaseException;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Events\CustomerQueue\CustomerQueued;
use App\DTO\Customer\Response\GetCustomeQueStatusResponseDto;
use App\Models\QueueSession;

class CustomerService
{
	public function addCustomerToQue(AddCustomerToQueDto $addCustomerDto, User $actor): Customer
	{
		$queueSessionId = $actor->queue_session_id;
		$actorId = $actor->id;

		if (!$queueSessionId) {
			throw new AppBaseException('Actor has no active queue session.');
		}

		$existingCustomerQueue = Customer::query()
			->select('queue_session_id')
			->with('queueSession:id,name')
			->where('mobile_number', $addCustomerDto->mobileNumber)
			->firstOrFail();

		if ($existingCustomerQueue !== null) {

			if ((int) $existingCustomerQueue->queue_session_id === (int) $queueSessionId) {
				throw new AppBaseException(
					message:'Customer is already added in the que.',
					code:409
				);
			}
			
			$existingQueueSessionName = $existingCustomerQueue->queueSession?->name;
			throw new AppBaseException(
				message: 'Customer is in another.',
				code: 409,
				meta: [
					'customerId' => $existingCustomerQueue->customer_id,
					'queueSessionName' => $existingQueueSessionName,
					'existing_queue_number' => $existingCustomerQueue->queue_number,
				]
			);
		}

		//determine the next que number
		$nextQueNumber = Customer::where('queue_session_id', $queueSessionId)->max('que_number');

		$customerDbTransaction = DB::transaction(function () use (
			$addCustomerDto, 
			$queueSessionId, 
			$actorId, 
			$nextQueNumber
			) {
			$customer = new Customer();
			$customer->queue_session_id = $queueSessionId;
			$customer->first_name = $addCustomerDto->firstName;
			$customer->last_name = $addCustomerDto->lastName;
			$customer->mobile_number = $addCustomerDto->mobileNumber;
			$customer->customer_status = CustomerStatus::Pending->value;
			$customer->que_number = ($nextQueNumber ?? 0) + 1;
			$customer->save();

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

	public function getCustomeQueStatus(string $mobileNumber): GetCustomeQueStatusResponseDto
	{
		//select que_number, queue_session_id field only from this query
		$customer = Customer::query()
			->select(['que_number', 'queue_session_id'])
			->where('mobile_number', $mobileNumber)
			->firstOrFail();

		if ($customer === null) {
			throw new AppBaseException(
				message:'Customer was not found using mobile number.',
				code:302,
				meta:[
					'mobileNumber' => $mobileNumber
				]
			);
		}

		//query all the customer where queue_session_id is equal to $customer->queue_session_id and customer_status is equal to CustomerStatus::inprogress
		//select only the que_number from this query and assign it to array named $currentlyServing
		$currentlyServing = Customer::query()
			->where('queue_session_id', $customer->queue_session_id)
			->where('customer_status', CustomerStatus::InProgress->value)
			->pluck('que_number')
			->all();

		return new GetCustomeQueStatusResponseDto(
			//assigned que_number here from $customer result
			queueNumber: (int) $customer->que_number,
			//assign $currentlyServing here
			currentlyServing: $currentlyServing,
			//leave this as is for now i will implement this later
			estimatedWaitingTime: 0
		);
	}

	public function getAllCustomer(): Collection
	{
		return Customer::all();
	}
}
