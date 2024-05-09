<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super_admin = new User();

        $super_admin->first_name = 'Ravi Kant';
        $super_admin->last_name = 'Pujari';
        $super_admin->email = 'rvkantpujari@gmail.com';
        $super_admin->password = Hash::make('admin');
        $super_admin->status = 'approved';
        $super_admin->save();

        $super_admin->assignRole('Super Admin');
    }
}
