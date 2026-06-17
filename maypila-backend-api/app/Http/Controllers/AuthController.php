<?php

namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\Auth\LoginAuthRequest;
use App\Http\Resources\Customer\CustomerResource;

class AuthController extends Controller
{
	/**
	 * Login user
	 *
	 * @response 200 {
	 *   "message": "Login successful.",
	 *   "token": "1|abcdef1234567890",
	 *   "user": {
	 *     "id": 1,
	 *     "name": "John Doe",
	 *     "email": "john@example.com",
	 *     "created_at": "2026-06-16T10:00:00.000000Z",
	 *     "updated_at": "2026-06-16T10:00:00.000000Z"
	 *   }
	 * }
	 */	
	public function login(LoginAuthRequest $request): JsonResponse
	{
		//todojeph: move this logic to service
		
		$credentials = $request->validated();
		$user = User::where('email', $credentials['email'])->first();
		$companies = $user->companies;
		$roles = $user->roles;

		if (!$user || !Hash::check($credentials['password'], $user->password)) {
			return response()->json([
				'message' => 'The provided credentials are incorrect.',
			], 401);
		}

		$tokenName = $credentials['device_name'] ?? 'api-token';
		$token = $user->createToken($tokenName)->plainTextToken;

		return response()->json([
			'message' => 'Login successful.',
			'token' => $token,
			'user' =>new CustomerResource(
               $user
            )
		]);
	}

	public function logout(Request $request): JsonResponse
	{
		$request->user()->currentAccessToken()?->delete();

		return response()->json([
			'message' => 'Logout successful.',
		]);
	}
}
