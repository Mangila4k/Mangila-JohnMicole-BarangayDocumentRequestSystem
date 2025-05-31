<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);

        // Find users by email or ID and assign roles
        $adminUser = User::where('email', 'admin@example.com')->first();
        if ($adminUser) {
            $adminUser->assignRole($adminRole);
        }

        $superAdminUser = User::where('email', 'superadmin@example.com')->first();
        if ($superAdminUser) {
            $superAdminUser->assignRole($superAdminRole);
        }

        // Example to assign user role to a normal user
        $normalUser = User::where('email', 'user@example.com')->first();
        if ($normalUser) {
            $normalUser->assignRole($userRole);
        }
    }
}
