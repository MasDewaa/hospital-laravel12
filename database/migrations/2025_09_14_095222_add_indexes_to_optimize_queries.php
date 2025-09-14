<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add indexes to users table
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'created_at'], 'users_role_created_index');
            $table->index('email', 'users_email_index');
        });

        // Add indexes to patients table
        Schema::table('patients', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'patients_user_created_index');
            $table->index('patient_id', 'patients_patient_id_index');
            $table->index('phone', 'patients_phone_index');
            $table->index('email', 'patients_email_index');
        });

        // Add indexes to doctors table
        Schema::table('doctors', function (Blueprint $table) {
            $table->index(['user_id', 'created_at'], 'doctors_user_created_index');
            $table->index('specialization', 'doctors_specialization_index');
            $table->index('phone', 'doctors_phone_index');
            $table->index('email', 'doctors_email_index');
        });

        // Add indexes to appointments table
        Schema::table('appointments', function (Blueprint $table) {
            $table->index(['patient_id', 'appointment_date'], 'appointments_patient_date_index');
            $table->index(['doctor_id', 'appointment_date'], 'appointments_doctor_date_index');
            $table->index(['appointment_date', 'appointment_time'], 'appointments_datetime_index');
            $table->index('status', 'appointments_status_index');
            $table->index('created_at', 'appointments_created_at_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_role_created_index');
            $table->dropIndex('users_email_index');
        });

        // Drop indexes from patients table
        Schema::table('patients', function (Blueprint $table) {
            $table->dropIndex('patients_user_created_index');
            $table->dropIndex('patients_patient_id_index');
            $table->dropIndex('patients_phone_index');
            $table->dropIndex('patients_email_index');
        });

        // Drop indexes from doctors table
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropIndex('doctors_user_created_index');
            $table->dropIndex('doctors_specialization_index');
            $table->dropIndex('doctors_phone_index');
            $table->dropIndex('doctors_email_index');
        });

        // Drop indexes from appointments table
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex('appointments_patient_date_index');
            $table->dropIndex('appointments_doctor_date_index');
            $table->dropIndex('appointments_datetime_index');
            $table->dropIndex('appointments_status_index');
            $table->dropIndex('appointments_created_at_index');
        });
    }
};