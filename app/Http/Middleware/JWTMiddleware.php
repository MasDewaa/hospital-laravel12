<?php

namespace App\Http\Middleware;

use App\Services\JWTService;
use Closure;
use Illuminate\Http\Request;

class JWTMiddleware
{
    protected $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json(['error' => 'Token not provided'], 401);
        }

        $user = $this->jwtService->getUserFromToken($token);
        
        if (!$user) {
            return response()->json(['error' => 'Invalid token'], 401);
        }

        if ($this->jwtService->isTokenExpired($token)) {
            return response()->json(['error' => 'Token expired'], 401);
        }

        // Set the authenticated user
        auth()->setUser($user);

        return $next($request);
    }
}
