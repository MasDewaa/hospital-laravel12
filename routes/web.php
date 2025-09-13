<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PatientAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', fn() => view('welcome'))->name('welcome');

// Portal page (moved from welcome)
Route::get('/login', fn() => view('auth.portal'))->name('login');

// Staff/Doctor Auth
Route::get('/staff-login', [LoginController::class, 'showLoginForm'])->name('staff.login');
Route::post('/staff-login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Patient Auth
Route::prefix('patient')->group(function () {
    Route::get('/login', [PatientAuthController::class, 'showLoginForm'])->name('patient.login');
    Route::post('/login', [PatientAuthController::class, 'login']);
    Route::get('/register', [PatientAuthController::class, 'showRegisterForm'])->name('patient.register');
    Route::post('/register', [PatientAuthController::class, 'register']);
    Route::post('/logout', [PatientAuthController::class, 'logout'])->name('patient.logout');
});

// Redirect /home dan /admin ke dashboard
Route::get('/home', fn() => redirect()->route('dashboard'))->middleware('auth');
Route::get('/admin', fn() => redirect()->route('dashboard'))->middleware(['auth', 'role:admin'])->name('admin.dashboard');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Universal dashboard (redirect by role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin/Staff
    Route::middleware('role:admin')->group(function () {
        Route::resource('patients', PatientController::class);
        Route::resource('doctors', DoctorController::class);
        Route::resource('appointments', AppointmentController::class);
    });

    // Doctor
    Route::middleware('role:doctor')->group(function () {
        Route::get('/my-appointments', [AppointmentController::class, 'index'])->name('doctor.appointments');
    });

    // Patient
    Route::middleware('role:patient')->group(function () {
        Route::get('/patient-dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
    });
});

// Chat routes
Route::prefix('chat')->group(function () {
    Route::get('/history', [App\Http\Controllers\ChatController::class, 'getHistory'])->name('chat.history');
    Route::post('/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/stats', [App\Http\Controllers\ChatController::class, 'getStats'])->name('chat.stats');
});

// Fallback untuk 404
Route::fallback(fn() => redirect()->route('welcome'));
