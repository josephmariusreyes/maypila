<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateUserRequest;

use App\Services\UserService\IUserService;
use App\Http\Resources\ApiBaseResponse;
use App\Http\Resources\User\UserResource;

use App\DTO\User\{
	CreateUserDto,
	UpdateUserDto,
	GetAllUserDto
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
	private IUserService $userService;

	public function __construct(IUserService $userService)
	{
		$this->userService = $userService;
	}

	public function show(ShowUserRequest $request)
	{
		$validated = $request->validated();
		return ApiBaseResponse::success(
			new UserResource($this->userService->getUserById($validated['id'])),
			'User fetched successfully'
		);

		// note: sample of how to use the base response with meta data
		// return ApiResponse::success(
		//     UserResource::collection($users),
		//     'Users retrieved successfully',
		//     200,
		//     [
		//         'total' => $users->total(),
		//         'page' => $users->currentPage(),
		//     ]
		// );
	}

	public function index(IndexUserRequest $request)
	{
		$validated = $request->validated();
		$getAllUserDto = new GetAllUserDto(
			companyId:'',
			role:''
		);
		return response()->json($this->userService->getAllUser($getAllUserDto));
	}


	// Store a new user
	public function store(StoreUserRequest $request)
	{
		$validated = $request->validated();
		$createdUserDto = new CreateUserDto(
			name: $validated['name'],
			email: $validated['email'],
			password: $validated['password'],
		);

		//jephtodo: add role

		//jephtodo: add capability for superadmin to associate a different company

		return response()->json($this->userService->createUser($createdUserDto));
	}


	// Update an existing user
	public function update(StoreUserRequest $request, int $id)
	{
		$validated = $request->validated();
		$updateUserDto = new UpdateUserDto(
			id:$id,
			name: $validated['name'],
			email: $validated['email'],
			password: $validated['password'],
		);
		$updatedUser = $this->userService->updateUser($updateUserDto);
		return response()->json($updatedUser);
	}


	// Delete a user
	public function destroy(int $id)
	{
		$result = $this->userService->deleteUser($id);
		return response()->json(['success' => $result]);
	}
}
