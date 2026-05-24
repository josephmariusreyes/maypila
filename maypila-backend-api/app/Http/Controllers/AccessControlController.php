<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiBaseResponse;
use App\Services\UserService\UserService;
use Illuminate\Http\Request;

class AccessControlController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function getAppMenu(Request $request)
    {
        $menu = $this->userService->getAppMenu($request->user());

        return ApiBaseResponse::success(
            data: $menu,
            message: 'App menu fetched successfully'
        );
    }
}