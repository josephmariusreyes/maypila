<?php

namespace App\Http\Controllers;

use App\DTO\Customer\Requests\AddCustomerToQueDto;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\ApiBaseResponse;
use App\Http\Resources\Customer\CustomerResource;
use App\Services\Customer\CustomerService;

class CustomerController extends Controller
{

    public function __construct( private CustomerService $customerService)
    {
    }

    public function index()
    {
        return ApiBaseResponse::success(
            data: CustomerResource::collection(
                $this->customerService->getAllCustomer()
            ),
            message: 'Customers fetched successfully'
        );
    }

    public function show(int $id)
    {
        //jephnote: for now i am just passing ID here but this can potentially grow
        //when it does thats when i will use a request OBJ
        return ApiBaseResponse::success(
            data: new CustomerResource(
                $this->customerService->getCustomerById((int) $id)
            ),
            message: 'Customer fetched successfully'
        );
    }

    public function store(StoreCustomerRequest $request)
    {
        $validated = $request->validated();

        //jephnote: customer will likely grow, opting to use DTOs here for now
        $addCustomerToQueDto = new AddCustomerToQueDto(
            firstName: $validated['firstName'],
            lastName: $validated['lastName'],
            mobileNumber: $validated['mobileNumber'],
        );

        return ApiBaseResponse::success(
            data: new CustomerResource(
                $this->customerService->addCustomerToQue($addCustomerToQueDto, $request->user())
            ),
            message: 'Customer created successfully',
            status: 201
        );
    }

    public function update(UpdateCustomerRequest $request)
    {
        $validated = $request->validated();

        return ApiBaseResponse::success(
            data: new CustomerResource(
                $this->customerService->updateCustomer(
                    $validated,
                    $request->user()
                )
            ),
            message: 'Customer updated successfully'
        );
    }

}