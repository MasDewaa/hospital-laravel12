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
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Doctor Users
        User::create([
            'name' => 'Dr. John Smith',
            'email' => 'john.smith@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'sarah.johnson@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        User::create([
            'name' => 'Dr. Michael Brown',
            'email' => 'michael.brown@hospital.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);
    }
}
