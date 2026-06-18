<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\ApiBaseResponseResource;
use App\Http\Resources\UserResponseResource;
use Illuminate\Auth\Access\AuthorizationException;

use Knuckles\Scribe\Attributes\ResponseFromApiResource;


class AuthController extends Controller
{
	#[ResponseFromApiResource(
		ApiBaseResponseResource::class,
		User::class
	)]
	public function login(LoginAuthRequest $request): ApiBaseResponseResource
	{
		$credentials = $request->validated();
		$user = User::where('email', $credentials['email'])->first();
		$companies = $user->companies;
		$roles = $user->roles;

		if (!$user || !Hash::check($credentials['password'], $user->password)) {
			throw new AuthorizationException('The provided credentials are incorrect.');
		}

		$tokenName = $credentials['device_name'] ?? 'api-token';
		$token = $user->createToken($tokenName)->plainTextToken;


		return new ApiBaseResponseResource(
			resource: UserResource::make($user),
			success: true,
			message:'Login successful.',
			meta: [
				'token_name' => $tokenName,
				'token' => $token
			]
		);
	}

	#[ResponseFromApiResource(
		ApiBaseResponseResource::class
	)]
	public function logout(Request $request): ApiBaseResponseResource
	{
		$request->user()->currentAccessToken()?->delete();

		return new ApiBaseResponseResource(
			resource: [],
			success: true,
			message: 'Logout successful.'
		);
	}
}
