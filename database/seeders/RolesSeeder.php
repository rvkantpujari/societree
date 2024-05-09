<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'View Users']);
        Permission::create(['name' => 'Add User']);
        Permission::create(['name' => 'Update User']);
        Permission::create(['name' => 'Delete User']);

        $super_admin = Role::create(['name' => 'Super Admin']);
        $super_admin->givePermissionTo(Permission::all());

        Role::create(['name' => 'Owner']);
        Role::create(['name' => 'Tenant']);
    }
}
