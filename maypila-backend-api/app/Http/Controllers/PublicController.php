<?php

namespace App\Http\Controllers;
use App\Http\Resources\ApiBaseResponse;
use App\Services\Customer\CustomerService;

class PublicController extends Controller
{
     public function __construct(
        private CustomerService $customerService
        )
    {
    }

    public function getQueStatus(string $mobileNumber) {
        $customerQueStatus = $this->customerService->getCustomeQueStatus($mobileNumber);

		return ApiBaseResponse::success(
			data: [
                'queueNumber' => $customerQueStatus->queueNumber,
                'currentlyService' => $customerQueStatus->currentlyServing,
                'estimatedWaitingTime' => 0 
            ],
			message: 'Successfully retrieve customer status'
		);
    }

}
