<?php

namespace  Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        Permission::create(['name' => 'role view']);
        Permission::create(['name' => 'role create']);
        Permission::create(['name' => 'role update']);
        Permission::create(['name' => 'role delete']);

        Permission::create(['name' => 'permission view']);
        Permission::create(['name' => 'permission create']);
        Permission::create(['name' => 'permission update']);
        Permission::create(['name' => 'permission delete']);

        Permission::create(['name' => 'user view']);
        Permission::create(['name' => 'user create']);
        Permission::create(['name' => 'user update']);
        Permission::create(['name' => 'user delete']);

        Permission::create(['name' => 'onlineorder view']);
        Permission::create(['name' => 'checkstockrsa view']);
        Permission::create(['name' => 'checkstockrsa import']);
        Permission::create(['name' => 'hthemployee view']);
        Permission::create(['name' => 'hthemployee import']);
        Permission::create(['name' => 'itasset view']);
        Permission::create(['name' => 'usermanagement view']);
        Permission::create(['name' => 'dashboard view']);

        // Create Roles
        $superAdminRole = Role::create(['name' => 'super-admin']); //as super-admin
        $adminRole = Role::create(['name' => 'admin']);
        $staffRole = Role::create(['name' => 'staff']);
        $userRole = Role::create(['name' => 'user']);

        // Lets give all permission to super-admin role.
        $allPermissionNames = Permission::pluck('name')->toArray();

        $superAdminRole->givePermissionTo($allPermissionNames);

        // Let's give few permissions to admin role.
        $adminRole->givePermissionTo(['role create', 'role view', 'role update']);
        $adminRole->givePermissionTo(['permission create', 'permission view']);
        $adminRole->givePermissionTo(['user create', 'user view', 'user update']);


        // Let's Create User and assign Role to it.

        $superAdminUser = User::firstOrCreate([
            'email' => 'superadmin@gmail.com',
        ], [
            'username' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => '12345678',
        ]);

        $superAdminUser->assignRole($superAdminRole);

        $adminUser = User::firstOrCreate([
            'email' => 'admin@gmail.com'
        ], [
            'username' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
        ]);

        $adminUser->assignRole($adminRole);

        $staffUser = User::firstOrCreate([
            'email' => 'staff@gmail.com',
        ], [
            'username' => 'Staff',
            'email' => 'staff@gmail.com',
            'password' => '12345678',
        ]);

        $staffUser->assignRole($staffRole);
    }
}
