<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatException extends Exception
{
    protected $errorCode;
    protected $context;

    public function __construct(string $message = '', string $errorCode = 'CHAT_ERROR', array $context = [], int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errorCode = $errorCode;
        $this->context = $context;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'success' => false,
            'error' => [
                'code' => $this->errorCode,
                'message' => $this->getMessage(),
                'context' => $this->context,
            ],
            'timestamp' => now()->toISOString(),
        ], $this->getCode() ?: 500);
    }

    /**
     * Create a new ChatException instance for API errors.
     */
    public static function apiError(string $message, array $context = []): self
    {
        return new self($message, 'API_ERROR', $context, 500);
    }

    /**
     * Create a new ChatException instance for validation errors.
     */
    public static function validationError(string $message, array $context = []): self
    {
        return new self($message, 'VALIDATION_ERROR', $context, 422);
    }

    /**
     * Create a new ChatException instance for rate limit errors.
     */
    public static function rateLimitExceeded(string $message = 'Rate limit exceeded', array $context = []): self
    {
        return new self($message, 'RATE_LIMIT_EXCEEDED', $context, 429);
    }

    /**
     * Create a new ChatException instance for Gemini API errors.
     */
    public static function geminiError(string $message, array $context = []): self
    {
        return new self($message, 'GEMINI_API_ERROR', $context, 502);
    }

    /**
     * Create a new ChatException instance for RAG service errors.
     */
    public static function ragError(string $message, array $context = []): self
    {
        return new self($message, 'RAG_SERVICE_ERROR', $context, 500);
    }
}