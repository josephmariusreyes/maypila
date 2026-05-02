<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Enum\UserRole;
use App\Models\User;

// To run this seeder individually, use:
// php artisan db:seed --class=RoleSeeder
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            UserRole::SuperAdmin,
            UserRole::CompanyAdmin,
            UserRole::QueAdmin,
            UserRole::QueEncoder,
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role
            ]);
        }
    }
}