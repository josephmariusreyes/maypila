<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetUserDetailsRequest;
use App\Http\Requests\CreateUpdateUserRequest;
use App\DTO\CreateUserDto;

use App\Services\UserService\IUserService;

class UserController extends Controller
{
	private IUserService $userService;

	public function __construct(IUserService $userService)
	{
		$this->userService = $userService;
	}

	// Show a single user (details)
	public function show($id)
	{
		return response()->json($this->userService->getUserById($id));
	}


	// List all users
	public function index()
	{
		return response()->json($this->userService->getAllUser());
	}


	// Store a new user
	public function store(CreateUpdateUserRequest $request)
	{
		$validated = $request->validated();
		$createdUserDto = new CreateUserDto(
			name: $validated['name'],
			email: $validated['email'],
			password: $validated['password'],
		);
		return response()->json($this->userService->createUser($createdUserDto));
	}


	// Update an existing user
	public function update(CreateUpdateUserRequest $request, $id)
	{
		$validated = $request->validated();
		$updateUserDto = new CreateUserDto(
			name: $validated['name'],
			email: $validated['email'],
			password: $validated['password'],
		);
		$updatedUser = $this->userService->updateUser($id, $updateUserDto);
		return response()->json($updatedUser);
	}


	// Delete a user
	public function destroy($id)
	{
		$result = $this->userService->deleteUser($id);
		return response()->json(['success' => $result]);
	}
}
