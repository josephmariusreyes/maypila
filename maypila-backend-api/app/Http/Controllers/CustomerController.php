<?php

namespace App\Http\Controllers;

use App\DTO\Customer\AddCustomerToQueDto;
use App\DTO\Customer\UpdateCustomerDto;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\Customer\CustomerResource;
use App\Services\Customer\ICustomerService;

class CustomerController extends Controller
{
    private ICustomerService $customerService;

    public function __construct(ICustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        return CustomerResource::collection(
            $this->customerService->getAllCustomer()
        );
    }

    public function show(int $id)
    {
        return new CustomerResource(
            $this->customerService->getCustomerById((int) $id)
        );
    }

    public function store(StoreCustomerRequest $request)
    {
        $validated = $request->validated();

        $addCustomerToQueDto = new AddCustomerToQueDto(
            firstName: $validated['firstName'],
            lastName: $validated['lastName'],
            mobileNumber: $validated['mobileNumber'],
        );

        return new CustomerResource(
            $this->customerService->addCustomerToQue($addCustomerToQueDto, $request->user())
        );
    }

    public function update(UpdateCustomerRequest $request)
    {
        $validated = $request->validated();

        $updateCustomerDto = new UpdateCustomerDto(
            id: (int) $validated['id'],
            customerStatus:$validated['customerStatus'],
        );

        return new CustomerResource(
            $this->customerService->updateCustomer($updateCustomerDto, $request->user())
        );
    }

}