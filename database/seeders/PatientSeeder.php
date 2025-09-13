<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = [
            [
                'name' => 'Alice Johnson',
                'email' => 'alice.johnson@email.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '1985-03-15',
                'phone' => '+1-555-0201',
                'address' => '123 Main Street, City, State 12345',
                'medical_history' => 'Allergic to penicillin. History of asthma.',
            ],
            [
                'name' => 'Bob Smith',
                'email' => 'bob.smith@email.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '1978-07-22',
                'phone' => '+1-555-0202',
                'address' => '456 Oak Avenue, City, State 12345',
                'medical_history' => 'Diabetes type 2. Regular medication.',
            ],
            [
                'name' => 'Carol Davis',
                'email' => 'carol.davis@email.com',
                'password' => Hash::make('password'),
                'date_of_birth' => '1992-11-08',
                'phone' => '+1-555-0203',
                'address' => '789 Pine Road, City, State 12345',
                'medical_history' => 'No known allergies. Regular checkups.',
            ],
        ];

        foreach ($patients as $patientData) {
            // Create user account
            $user = User::create([
                'name' => $patientData['name'],
                'email' => $patientData['email'],
                'password' => $patientData['password'],
                'role' => 'patient',
            ]);

            // Create patient profile
            Patient::create([
                'patient_id' => Patient::generatePatientId(),
                'name' => $patientData['name'],
                'date_of_birth' => $patientData['date_of_birth'],
                'address' => $patientData['address'],
                'phone' => $patientData['phone'],
                'medical_history' => $patientData['medical_history'],
                'email' => $patientData['email'],
                'user_id' => $user->id,
            ]);
        }
    }
}
