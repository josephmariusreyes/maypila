<?php
namespace App\Services\UserService;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\DTO\User\{
	CreateUserDto,
	UpdateUserDto,
	GetAllUserDto
};

use App\QueryFilters\UserFilter;

// all methods in this service will do CRUD on the userModel
class UserService implements IUserService
{
    public function createUser(CreateUserDto $createUserDto, User $actor): User
    {
        $loggedInUser = User::with(['roles:id,name', 'companies:id,name'])->find($actor->user()->id);

        return DB::transaction(function () use ($createUserDto) {
            $user = User::create([
                'name' => $createUserDto->name,
                'email' => $createUserDto->email,
                'password' => Hash::make($createUserDto->password),
                'mobile_number' => $createUserDto->mobile_number
            ]);

            $role = Role::where('name', $createUserDto->role)->firstOrFail();
            $company = Company::findOrFail($createUserDto->companyId);

            $user->roles()->syncWithoutDetaching([$role->id]);
            $user->companies()->syncWithoutDetaching([$company->id]);

            return $user->load(['roles', 'companies']);
        });
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
