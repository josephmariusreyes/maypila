<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUpdateUserRequest;

use App\DTO\CreateUserDto;
use App\DTO\UpdateUserDto;
use App\Http\Requests\User\StoreUserRequest;
use App\Services\UserService\IUserService;

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

	// Show a single user (details)
	public function show(int $id)
	{
		return response()->json($this->userService->getUserById($id));
	}


	// List all users
	// params:
	//, RoleId, 
	public function index(int $companyId, ?int $roleId = null)
	{
		return response()->json($this->userService->getAllUser());
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
