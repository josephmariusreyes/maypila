<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiBaseResponse;
use App\Services\UserService\UserService;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Response;

class AccessControlController extends Controller
{
    public function __construct(private UserService $userService) {}

    #[Response([
        'success' => true,
        'message' => 'Success',
        'data' => new \stdClass(),
        'meta' =>  new \stdClass()
    ])]
    public function getAppMenu(Request $request)
    {
        $menu = $this->userService->getAppMenu($request->user());
        return ApiBaseResponse::success(
            data: $menu,
            message: 'App menu fetched successfully'
        );
    }
}
