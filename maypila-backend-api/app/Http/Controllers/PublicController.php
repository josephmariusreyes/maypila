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

    public function getQueStatus(int $mobileNumber) {

        $this->customerService->getCustomeQueStatus($mobileNumber);

		return ApiBaseResponse::success(
			data: [
                'queueNumber' => 0,
                'currentlyService' => [],
                'estimatedWaitingTime' => 0 
            ],
			message: 'User deleted successfully'
		);
    }

    public function unHashPw(string $pw) {
        $unhashedPw = '';
        return $unhashedPw;
    }
}
