<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return redirect()->route('patient.login')->with('error', 'Patient profile not found.');
        }
        
        $todayAppointments = Appointment::where('patient_id', $patient->id)
            ->whereDate('appointment_date', today())
            ->with('doctor')
            ->orderBy('appointment_time')
            ->get();
            
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
            ->whereDate('appointment_date', '>=', today())
            ->with('doctor')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();
            
        $pastAppointments = Appointment::where('patient_id', $patient->id)
            ->whereDate('appointment_date', '<', today())
            ->with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboard.patient', compact(
            'patient',
            'todayAppointments',
            'upcomingAppointments',
            'pastAppointments'
        ));
    }
}
