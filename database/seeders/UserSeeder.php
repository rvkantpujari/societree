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
        $admin = new User();

        $admin->first_name = 'Ravi Kant';
        $admin->last_name = 'Pujari';
        $admin->email = 'societree@gmail.com';
        $admin->password = Hash::make('admin');
        $admin->save();
    }
}
