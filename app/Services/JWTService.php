<?php

namespace App\Services;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Carbon\Carbon;

class JWTService
{
    private $secretKey;
    private $algorithm = 'HS256';
    private $expirationTime = 3600; // 1 hour

    public function __construct()
    {
        $this->secretKey = config('jwt.secret', 'your-secret-key');
    }

    /**
     * Generate JWT token for user
     */
    public function generateToken(User $user): string
    {
        $payload = [
            'iss' => config('app.url'), // Issuer
            'iat' => time(), // Issued at
            'exp' => time() + $this->expirationTime, // Expiration time
            'nbf' => time(), // Not before
            'sub' => $user->id, // Subject
            'jti' => uniqid(), // JWT ID
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ];

        return JWT::encode($payload, $this->secretKey, $this->algorithm);
    }

    /**
     * Verify and decode JWT token
     */
    public function verifyToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, $this->algorithm));
            return (array) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get user from token
     */
    public function getUserFromToken(string $token): ?User
    {
        $payload = $this->verifyToken($token);
        
        if (!$payload || !isset($payload['sub'])) {
            return null;
        }

        return User::find($payload['sub']);
    }

    /**
     * Check if token is expired
     */
    public function isTokenExpired(string $token): bool
    {
        $payload = $this->verifyToken($token);
        
        if (!$payload || !isset($payload['exp'])) {
            return true;
        }

        return $payload['exp'] < time();
    }

    /**
     * Refresh token
     */
    public function refreshToken(string $token): ?string
    {
        $user = $this->getUserFromToken($token);
        
        if (!$user) {
            return null;
        }

        return $this->generateToken($user);
    }
}
