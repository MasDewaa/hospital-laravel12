<?php

use App\Http\Controllers\Auth\JWTAuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::group(['prefix' => 'auth'], function () {
    // Staff/Doctor authentication
    Route::post('/login', [JWTAuthController::class, 'login']);
    Route::post('/register', [JWTAuthController::class, 'register']);
    
    // Patient authentication
    Route::post('/patient/login', [JWTAuthController::class, 'patientLogin']);
    Route::post('/patient/register', [JWTAuthController::class, 'patientRegister']);
});

// Protected routes
Route::group(['middleware' => 'auth:api'], function () {
    // Authentication routes
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/logout', [JWTAuthController::class, 'logout']);
        Route::post('/refresh', [JWTAuthController::class, 'refresh']);
        Route::get('/user-profile', [JWTAuthController::class, 'userProfile']);
    });

    // Admin/Staff routes
    Route::group(['middleware' => 'role:admin'], function () {
        Route::apiResource('patients', PatientController::class);
        Route::apiResource('doctors', DoctorController::class);
        Route::apiResource('appointments', AppointmentController::class);
    });

    // Doctor routes
    Route::group(['middleware' => 'role:doctor'], function () {
        Route::get('/my-appointments', [AppointmentController::class, 'index']);
    });

    // Patient routes
    Route::group(['middleware' => 'role:patient'], function () {
        Route::get('/patient-dashboard', [PatientDashboardController::class, 'index']);
    });
});

// Chat API routes
Route::prefix('chat')->group(function () {
    Route::get('/history', [App\Http\Controllers\ChatController::class, 'getHistory']);
    Route::post('/send', [App\Http\Controllers\ChatController::class, 'sendMessage']);
    Route::get('/stats', [App\Http\Controllers\ChatController::class, 'getStats']);
});

// Test route
Route::get('/test', function () {
    return response()->json([
        'message' => 'Hospital Management System API is working!',
        'version' => '1.0.0',
        'timestamp' => now()
    ]);
});
