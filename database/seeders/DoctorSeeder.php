<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Dr. John Smith',
                'specialization' => 'General Medicine',
                'phone' => '+1-555-0101',
                'email' => 'john.smith@hospital.com',
                'user_id' => User::where('email', 'john.smith@hospital.com')->first()->id,
            ],
            [
                'name' => 'Dr. Sarah Johnson',
                'specialization' => 'Cardiology',
                'phone' => '+1-555-0102',
                'email' => 'sarah.johnson@hospital.com',
                'user_id' => User::where('email', 'sarah.johnson@hospital.com')->first()->id,
            ],
            [
                'name' => 'Dr. Michael Brown',
                'specialization' => 'Dermatology',
                'phone' => '+1-555-0103',
                'email' => 'michael.brown@hospital.com',
                'user_id' => User::where('email', 'michael.brown@hospital.com')->first()->id,
            ],
        ];

        foreach ($doctors as $doctorData) {
            Doctor::create($doctorData);
        }
    }
}
