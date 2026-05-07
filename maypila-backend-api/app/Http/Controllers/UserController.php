<?php

namespace App\Http\Controllers;

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
	
	public function index(IndexUserRequest $request)
	{
		$validated = $request->validated();
		$getAllUserDto = new GetAllUserDto(
			companyId:$validated['companyId'],
			role:$validated['role'] ?? null
		);
		$users = $this->userService->getAllUser($getAllUserDto);
		return ApiBaseResponse::success(
			UserResource::collection($users),
			'Users fetched successfully'
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
			new UserResource($user),
			'User fetched successfully'
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
			mobile_number:$validated['mobile_number'],
			role: $validated['role'],
			companyId:$validated['company_id']
		);

		return response()->json($this->userService->createUser($createdUserDto, $loggedInUser));
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
			mobile_number: $validated['mobile_number'],
			role: $validated['role'],
			companyId: $validated['company_id'],
		);
		$updatedUser = $this->userService->updateUser($updateUserDto, $request->user());
		return response()->json($updatedUser);
	}


	// Delete a user
	public function destroy(int $id)
	{
		$result = $this->userService->deleteUser($id);
		return response()->json(['success' => $result]);
	}
}
