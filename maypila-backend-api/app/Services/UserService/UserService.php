<?php
namespace App\Services\UserService;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\DTO\User\{
	CreateUserDto,
	UpdateUserDto,
	GetAllUserDto
};

use App\QueryFilters\UserFilter;

// all methods in this service will do CRUD on the userModel
class UserService implements IUserService
{
    public function createUser(CreateUserDto $createUserDto): User
    {
        return User::create([
            'name' => $createUserDto->name,
            'email' => $createUserDto->email,
            'password' => $createUserDto->password,
        ]);
    }

    public function updateUser(UpdateUserDto $dto): User
    {
        $user = User::findOrFail($dto->id);
        $data = array_filter([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ], fn ($value) => $value !== null);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $user->refresh();
    }

    public function deleteUser(int $id)
    {
        $user = User::findOrFail($id);
        return $user->delete();
    }

    public function getUserById(int $id) : User
    {
        return User::find($id);
    }

    public function getAllUser(GetAllUserDto $getAllUserDto)
    {
        return (new UserFilter($getAllUserDto))->apply(User::query())->get();
    }
}
