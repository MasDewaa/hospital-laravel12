<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'name',
        'date_of_birth',
        'address',
        'phone',
        'medical_history',
        'email',
        'user_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user that owns the patient.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the appointments for the patient.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Generate unique patient ID
     */
    public static function generatePatientId()
    {
        do {
            $patientId = 'P' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (self::where('patient_id', $patientId)->exists());
        
        return $patientId;
    }
}
