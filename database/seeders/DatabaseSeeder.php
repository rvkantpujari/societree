<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'first_name' => 'Ravi Kant',
            'last_name' => 'Pujari',
            'email' => 'rvkantpujari@gmail.com',
            'password' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->call(CountriesSeeder::class);
        $this->call(StatesSeeder::class);
    }
}
