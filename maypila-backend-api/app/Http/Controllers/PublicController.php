<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiBaseResponse;
use App\Services\Customer\CustomerService;
use Knuckles\Scribe\Attributes\Response;

class PublicController extends Controller
{
    public function __construct(
        private CustomerService $customerService
    ) {}

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => new \stdClass(),
        'meta' =>  new \stdClass()
    ])]
    public function getQueStatus(string $mobileNumber)
    {
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
