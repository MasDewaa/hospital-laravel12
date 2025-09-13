<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            // Admin/Staff Dashboard
            $totalPatients = Patient::count();
            $totalDoctors = Doctor::count();
            $todayAppointments = Appointment::today()->count();
            $upcomingAppointments = Appointment::upcoming()->count();
            
            $recentPatients = Patient::latest()->take(5)->get();
            $todayAppointmentsList = Appointment::today()
                ->with(['patient', 'doctor'])
                ->orderBy('appointment_time')
                ->get();
            
            return view('dashboard.admin', compact(
                'totalPatients',
                'totalDoctors', 
                'todayAppointments',
                'upcomingAppointments',
                'recentPatients',
                'todayAppointmentsList'
            ));
        } elseif ($user->isPatient()) {
            // Patient Dashboard - redirect to patient dashboard
            return redirect()->route('patient.dashboard');
        } else {
            // Doctor Dashboard
            $doctor = Doctor::where('user_id', $user->id)->first();
            
            if (!$doctor) {
                return redirect()->route('login')->with('error', 'Doctor profile not found.');
            }
            
            $todayAppointments = Appointment::where('doctor_id', $doctor->id)
                ->today()
                ->with('patient')
                ->orderBy('appointment_time')
                ->get();
                
            $upcomingAppointments = Appointment::where('doctor_id', $doctor->id)
                ->upcoming()
                ->with('patient')
                ->orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->take(10)
                ->get();
            
            return view('dashboard.doctor', compact(
                'doctor',
                'todayAppointments',
                'upcomingAppointments'
            ));
        }
    }
}
