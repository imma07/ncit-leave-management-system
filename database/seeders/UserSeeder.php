<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'id' => 1,
            'name' => 'Ali',
            'email' => 'Ali@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
            'department' => 'IT',
            'designation' => 'Manager',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::updateOrCreate([
            'id' => 2,
            'name' => 'Ahmed',
            'email' => 'Ahmed@example.com',
            'role' => 'user',
            'password' => bcrypt('password'),
            'department' => 'IT',
            'designation' => 'Developer',
            'phone' => '9668854',
            'address' => 'Lot 10170',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::updateOrCreate([
            'id' => 3,
            'name' => 'ismail',
            'email' => 'ismail@example.com',
            'role' => 'user',
            'password' => bcrypt('password'),
            'department' => 'IT',
            'designation' => 'Designer',
            'phone' => '9668810',
            'address' => 'Lot 11150',
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);


    }
}
