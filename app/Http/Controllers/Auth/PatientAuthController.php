<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PatientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.patient-login');
    }

    public function showRegisterForm()
    {
        return view('auth.patient-register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();
            
            if ($user->isPatient()) {
                $request->session()->regenerate();
                return redirect()->intended(route('patient.dashboard'));
            } else {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'This account is not registered as a patient.',
                ]);
            }
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'medical_history' => 'nullable|string',
        ]);

        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
        ]);

        // Create patient profile
        $patient = Patient::create([
            'patient_id' => Patient::generatePatientId(),
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'phone' => $request->phone,
            'medical_history' => $request->medical_history,
            'email' => $request->email,
            'user_id' => $user->id,
        ]);

        Auth::login($user);

        return redirect()->route('patient.dashboard')->with('success', 'Account created successfully! Welcome to the patient portal.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('patient.login');
    }
}
