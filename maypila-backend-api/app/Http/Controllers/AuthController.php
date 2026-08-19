<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Resources\User\UserResource;
use App\Services\UserService\UserService;
use Knuckles\Scribe\Attributes\Response;
use App\Constants\ApiDocs\UserResourceDocs;

use App\Http\Resources\ApiBaseResponse;

class AuthController extends Controller
{
	public function __construct(private UserService $userService) {}

	#[Response([
		'success' => true,
		'message' => 'Success',
		'data' => UserResourceDocs::USER,
		'meta' =>  new \stdClass()
	])]
	public function login(LoginAuthRequest $request)
	{
		$validatedRequest = $request->validated();
		$loggedInUser = $this->userService->loginUser($validatedRequest);
		$user = $loggedInUser['user'];
		$token = $loggedInUser['token'];
		$tokenName = $loggedInUser['tokenName'];
		$data = UserResource::make($user);

		return ApiBaseResponse::success(
			data: $data,
			message: 'Login successful.',
			meta: [
				//'companies' => $companies,
				//'roles' => $roles,
				'token_name' => $tokenName,
				'token' => $token
			]
		);
	}

	#[Response([
		'success' => true,
		'message' => 'Success',
		'data' => new \stdClass(),
		'meta' =>  new \stdClass()
	])]
	public function logout(Request $request)
	{
		$request->user()->currentAccessToken()?->delete();

		return ApiBaseResponse::success(
			data: [],
			message: 'Login successful.',
			meta: []
		);
	}
}
