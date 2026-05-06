<?php

namespace App\Policies;
use App\Models\User;
use App\Enum\UserRole;

class UserPolicy
{
    public function create(User $user): bool
    {
        // All authenticated users can create users (specific role assignment is checked separately)
        return true;
    }
    
    public function assignRole(User $creator, string $roleToAssign): bool
    {
        $creatorRole = $creator->roles->first()?->name;
        
        // SuperAdmin can assign any role
        if ($creatorRole === UserRole::SuperAdmin->value) {
            return true;
        }
        
        // CompanyAdmin can assign QueAdmin and QueEncoder
        if ($creatorRole === UserRole::CompanyAdmin->value) {
            return in_array($roleToAssign, [
                UserRole::QueAdmin->value,
                UserRole::QueEncoder->value
            ]);
        }
        
        // QueAdmin can assign QueEncoder
        if ($creatorRole === UserRole::QueAdmin->value) {
            return $roleToAssign === UserRole::QueEncoder->value;
        }
        
        return false;
    }
    
    public function assignToAnyCompany(User $user): bool
    {
        return $user->roles->contains('name', UserRole::SuperAdmin->value);
    }
}