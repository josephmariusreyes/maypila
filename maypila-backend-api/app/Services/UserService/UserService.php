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
use Illuminate\Support\Facades\Gate;

// all methods in this service will do CRUD on the userModel
class UserService implements IUserService
{
    public function createUser(CreateUserDto $createUserDto, User $actor): User
    {
        $loggedInUser = User::with(['roles:id,name', 'companies:id,name'])->find($actor->id);

        return DB::transaction(function () use ($createUserDto, $loggedInUser) {

            //jephtodo > validate for mobile number duplicate
            //validate for email duplicate
            
            $user = User::create([
                'name' => $createUserDto->name,
                'email' => $createUserDto->email,
                'password' => Hash::make($createUserDto->password),
                'mobile_number' => $createUserDto->mobile_number
            ]);

            if (Gate::forUser($loggedInUser)->allows('assignToAnyCompany', User::class)) {
                // SuperAdmin: use DTO values
                $role = Role::where('name', $createUserDto->role)->firstOrFail();
                $company = Company::findOrFail($createUserDto->companyId);
            } else {
                // Non-SuperAdmin: inherit from logged-in user
                $role = $loggedInUser->roles->first();
                $company = $loggedInUser->companies->first();

                // Check if they can assign this role
                if (!Gate::forUser($loggedInUser)->allows('assignRole', [User::class, $role->name])) {
                    throw new \Exception('You do not have permission to assign this role');
                }
            }

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
        ], fn($value) => $value !== null);

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

    public function getUserById(int $id): User
    {
        return User::find($id);
    }

    public function getAllUser(GetAllUserDto $getAllUserDto)
    {
        return (new UserFilter($getAllUserDto))->apply(User::query())->get();
    }
}
