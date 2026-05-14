<?php

namespace App\Services\UserService;

use App\DTO\User\{
	CreateUserDto,
    UpdateUserDto
};
use App\Models\User;

interface IUserService
{
    public function createUser(CreateUserDto $createUserDto, User $actor): User;
    public function updateUser(UpdateUserDto $updateUserDto, User $actor): User;
    public function deleteUser(int $id);
    public function getUserById(int $id) : User;
    public function getAllUser(array $filters);
}
