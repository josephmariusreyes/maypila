<?php

namespace App\Services\UserService;

use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use App\DTO\User\{
    CreateUserDto,
    UpdateUserDto,
    GetAllUserDto
};

use App\QueryFilters\UserFilter;

class UserService implements IUserService
{
    public function createUser(CreateUserDto $createUserDto, User $actor): User
    {
        
        $loggedInUser = User::with(['roles:id,name', 'companies:id,name'])->findOrFail($actor->id);

        return DB::transaction(function () use ($createUserDto, $loggedInUser) {
            $user = User::create([
                'name' => $createUserDto->name,
                'email' => $createUserDto->email,
                'password' => Hash::make($createUserDto->password),
                'mobile_number' => $createUserDto->mobile_number,
            ]);

            $this->syncRoleAndCompany(
                user: $user,
                actor: $loggedInUser,
                roleName: $createUserDto->role,
                companyId: $createUserDto->companyId,
            );

            return $user->load(['roles', 'companies']);
        });
    }

    public function updateUser(UpdateUserDto $dto, User $actor): User
    {
        $loggedInUser = User::with(['roles:id,name', 'companies:id,name'])->findOrFail($actor->id);

        return DB::transaction(function () use ($dto, $loggedInUser) {
            $user = User::findOrFail($dto->id);

            $data = array_filter([
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => $dto->password,
                'mobile_number' => $dto->mobile_number,
            ], fn($value) => $value !== null);

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user->update($data);

            $this->syncRoleAndCompany(
                user: $user,
                actor: $loggedInUser,
                roleName: $dto->role,
                companyId: $dto->companyId,
            );

            return $user->load(['roles', 'companies'])->refresh();
        });
    }

    private function syncRoleAndCompany(
        User $user,
        User $actor,
        ?string $roleName,
        ?int $companyId
    ): void {
        if (Gate::forUser($actor)->allows('assignToAnyCompany', User::class)) {
            $role = Role::where('name', $roleName)->firstOrFail();
            $company = Company::findOrFail($companyId);
        } else {
            $role = $actor->roles->firstOrFail();
            $company = $actor->companies->firstOrFail();

            if (! Gate::forUser($actor)->allows('assignRole', [User::class, $role->name])) {
                throw new \Exception('You do not have permission to assign this role');
            }
        }

        $user->roles()->sync([$role->id]);
        $user->companies()->sync([$company->id]);
    }

    public function deleteUser(int $id)
    {
        return DB::transaction(function () use ($id) {
            $user = User::findOrFail($id);

            $passwordResetTable = config('auth.passwords.users.table', 'password_reset_tokens');

            // Explicit cleanup for tables that do not cascade from users.
            $user->tokens()->delete();

            DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();

            DB::table($passwordResetTable)
                ->where('email', $user->email)
                ->delete();

            // This deletes the user row.
            // Pivot rows and other FK-cascaded records are removed by the database.
            return $user->delete();
        });
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
