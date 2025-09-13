<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use App\Services\JWTService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class JWTAuthController extends Controller
{
    protected $jwtService;

    /**
     * Create a new AuthController instance.
     */
    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
        $this->middleware('jwt.auth', ['except' => ['login', 'register', 'patientLogin', 'patientRegister']]);
    }

    /**
     * Get a JWT via given credentials.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Auth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        
        // Check if user is not a patient (staff/doctor only)
        if ($user->isPatient()) {
            Auth::logout();
            return response()->json(['error' => 'Please use patient login endpoint'], 401);
        }

        $token = $this->jwtService->generateToken($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 3600,
            'user' => $user
        ]);
    }

    /**
     * Register a new staff/doctor user.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|string|in:admin,doctor',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => Hash::make($request->password)]
        ));

        $token = $this->jwtService->generateToken($user);

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 3600
        ], 201);
    }

    /**
     * Patient login endpoint.
     */
    public function patientLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!Auth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        
        // Check if user is a patient
        if (!$user->isPatient()) {
            Auth::logout();
            return response()->json(['error' => 'Please use staff login endpoint'], 401);
        }

        $token = $this->jwtService->generateToken($user);

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 3600,
            'user' => $user
        ]);
    }

    /**
     * Patient registration endpoint.
     */
    public function patientRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'date_of_birth' => 'required|date',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'medical_history' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

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

        $token = $this->jwtService->generateToken($user);

        return response()->json([
            'message' => 'Patient successfully registered',
            'user' => $user,
            'patient' => $patient,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 3600
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     */
    public function refresh(Request $request)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $newToken = $this->jwtService->refreshToken($token);
        
        if (!$newToken) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        return response()->json([
            'access_token' => $newToken,
            'token_type' => 'bearer',
            'expires_in' => 3600
        ]);
    }

    /**
     * Get the authenticated User.
     */
    public function userProfile(Request $request)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $user = $this->jwtService->getUserFromToken($token);
        
        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
        
        // Add role-specific data
        $response = [
            'user' => $user,
        ];

        if ($user->isPatient()) {
            $patient = Patient::where('user_id', $user->id)->first();
            $response['patient'] = $patient;
        } elseif ($user->isDoctor()) {
            $doctor = \App\Models\Doctor::where('user_id', $user->id)->first();
            $response['doctor'] = $doctor;
        }

        return response()->json($response);
    }
}
