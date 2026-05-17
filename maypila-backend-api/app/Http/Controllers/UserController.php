<?php

namespace App\Http\Controllers;

use App\Services\UserService\UserService;
use App\Http\Resources\ApiBaseResponse;
use App\Http\Resources\User\UserResource;

use App\DTO\User\{
	CreateUserDto,
	UpdateUserDto
};

use App\Http\Requests\User\{
    ShowUserRequest,
    StoreUserRequest,
    IndexUserRequest
};
/**
 * Class UserController
 *
 * Responsible for handling HTTP requests related to application users.
 * Provides endpoints for listing, retrieving, creating, updating, and deleting users.
 * Delegates business logic to the UserService layer and ensures request validation.
 */
class UserController extends Controller
{

	public function __construct(private UserService $userService)
	{
	}
	
	public function index(IndexUserRequest $request)
	{
		$users = $this->userService->getAllUser($request->validated());
		return ApiBaseResponse::success(
			data:UserResource::collection($users),
			message:'Users fetched successfully'
		);
	}

	public function show(ShowUserRequest $request)
	{
		$validated = $request->validated();
		$user = $this->userService->getUserById($validated['id']);

		//NOTE
		//If you want roles, companies, and queue_sessions to appear, you need to load those relations before wrapping the model, because your resource uses whenLoaded(...):
		//$user = User::with(['roles', 'companies', 'queueSession'])->findOrFail($id);

		// NOTE: sample of how to use the base response with meta data
		// return ApiResponse::success(
		//     UserResource::collection($users),
		//     'Users retrieved successfully',
		//     200,
		//     [
		//         'total' => $users->total(),
		//         'page' => $users->currentPage(),
		//     ]
		// );
		
		return ApiBaseResponse::success(
			data:new UserResource($user),
			message:'User fetched successfully'
		);
	}

	// Store a new user
	public function store(StoreUserRequest $request)
	{
		$validated = $request->validated();
		$loggedInUser = $request->user();

		$createdUserDto = new CreateUserDto(
			name: $validated['name'],
			email: $validated['email'],
			password: $validated['password'],
			mobileNumber:$validated['mobileNumber'],
			role: $validated['role'],
			companyId:$validated['company_id']
		);

		$createdUser = $this->userService->createUser($createdUserDto, $loggedInUser);

		return ApiBaseResponse::success(
			data: new UserResource($createdUser),
			message: 'User created successfully',
			status: 201
		);
	}
	

	// Update an existing user
	public function update(StoreUserRequest $request, int $id)
	{
		$validated = $request->validated();
		$updateUserDto = new UpdateUserDto(
			id: $id,
			name: $validated['name'],
			email: $validated['email'],
			password: $validated['password'],
			mobileNumber: $validated['mobileNumber'],
			role: $validated['role'],
			companyId: $validated['company_id'],
		);
		$updatedUser = $this->userService->updateUser($updateUserDto, $request->user());

		return ApiBaseResponse::success(
			data: new UserResource($updatedUser),
			message: 'User updated successfully'
		);
	}


	// Delete a user
	public function destroy(int $id)
	{
		$result = $this->userService->deleteUser($id);

		return ApiBaseResponse::success(
			data: ['deleted' => $result],
			message: 'User deleted successfully'
		);
	}
}
