<?php

namespace App\Services\UserService;

use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

use App\DTO\User\{
    CreateUserDto,
    UpdateUserDto
};

use App\QueryFilters\UserFilter;
use App\Constants\AppConstants;
use App\Enum\UserRole;

class UserService
{
    public function createUser(CreateUserDto $createUserDto, User $actor): User
    {
        $loggedInUser = User::with(['roles:id,name', 'companies:id,name'])->findOrFail($actor->id);

        return DB::transaction(function () use ($createUserDto, $loggedInUser) {
            $user = User::create([
                'name' => $createUserDto->name,
                'email' => $createUserDto->email,
                'password' => Hash::make($createUserDto->password),
                'mobile_number' => $createUserDto->mobileNumber,
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
                'mobileNumber' => $dto->mobileNumber,
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

        //retrieve role by name
        $roleRecord = Role::where('name', $roleName)->firstOrFail();

        if (Gate::forUser($actor)->allows('assignToAnyCompany', User::class)) {
            //Only 'SuperAdmin' role can assign a user to any company 
            //This means that we can assign the companyId based on the supplied companyId from request
            //else we use the logged in user companyId
            $company = Company::findOrFail($companyId);
        } else {
            $company = $actor->companies->firstOrFail();

            //Check if logged in user can assign a role
            if (!Gate::forUser($actor)->allows('assignRole', [User::class, $roleRecord->name])) {
                throw new \Exception('You do not have permission to assign this role');
            }
        }

        $user->roles()->sync([$roleRecord->id]);
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

    public function getAllUser(array $filters)
    {
        return (new UserFilter($filters))->apply(User::query())->get();
    }

    public function getUserByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }

    public function getAppMenu(User $actor): array
    {
        $actor->loadMissing('roles:id,name');

        $roleName = $actor->roles->first()?->name;

        $menuKeysByRole = [
            UserRole::SuperAdmin->value => [
                'createNewCompany',
            ],
            UserRole::CompanyAdmin->value => [
                'startQueueSession',
                'manageUsers',
                'dashboard',
                'addUsers',
            ],
            UserRole::QueAdmin->value => [
                'dashboard',
            ],
            UserRole::QueEncoder->value => [
                'dashboard',
            ],
        ];

        $allowedMenus = $menuKeysByRole[$roleName] ?? [];

        return array_values(
            array_filter(
                AppConstants::Menu,
                fn(array $menuItem): bool => in_array($menuItem['key'], $allowedMenus, true)
            )
        );
    }

    public function loginUser(array $validatedData)
    {
        $user = $this->getUserByEmail($validatedData['email']);
        $user->companies;
        $user->roles;
        $user->queueSession;

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            throw new AuthorizationException('The provided credentials are incorrect.');
        }

        $tokenName = $validatedData['device_name'] ?? 'api-token';
        $token = $user->createToken($tokenName)->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
            'tokenName' => $tokenName
        ];
    }
}
