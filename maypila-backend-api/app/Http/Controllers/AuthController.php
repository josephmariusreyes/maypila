<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Auth\Access\AuthorizationException;
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
		$credentials = $request->validated();
		$user = $this->userService->getUserByEmail($credentials['email']);
		$companies = $user->companies;
		$roles = $user->roles;

		if (!$user || !Hash::check($credentials['password'], $user->password)) {
			throw new AuthorizationException('The provided credentials are incorrect.');
		}

		$tokenName = $credentials['device_name'] ?? 'api-token';
		$token = $user->createToken($tokenName)->plainTextToken;

		return ApiBaseResponse::success(
			data: UserResource::make($user),
			message: 'Login successful.',
			meta: [
				'companies' => $companies,
				'roles' => $roles,
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
