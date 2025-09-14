<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoggingService
{
    /**
     * Log chat interactions
     */
    public static function logChatInteraction(string $action, array $data = []): void
    {
        if (!config('gemini.logging.enabled', true)) {
            return;
        }

        $logData = array_merge([
            'action' => $action,
            'user_id' => Auth::id(),
            'timestamp' => now()->toISOString(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ], $data);

        Log::channel('single')->info('Chat Interaction', $logData);
    }

    /**
     * Log Gemini API requests
     */
    public static function logGeminiRequest(string $message, array $context = [], ?string $response = null): void
    {
        if (!config('gemini.logging.log_requests', true)) {
            return;
        }

        $logData = [
            'type' => 'gemini_request',
            'user_id' => Auth::id(),
            'message_length' => strlen($message),
            'context_items' => count($context),
            'timestamp' => now()->toISOString(),
        ];

        if (config('gemini.logging.log_context', false)) {
            $logData['context'] = $context;
        }

        if (config('gemini.logging.log_responses', false) && $response) {
            $logData['response'] = $response;
            $logData['response_length'] = strlen($response);
        }

        Log::channel('single')->info('Gemini API Request', $logData);
    }

    /**
     * Log Gemini API errors
     */
    public static function logGeminiError(\Exception $e, string $message, array $context = []): void
    {
        if (!config('gemini.logging.log_errors', true)) {
            return;
        }

        $logData = [
            'type' => 'gemini_error',
            'user_id' => Auth::id(),
            'error_message' => $e->getMessage(),
            'error_code' => $e->getCode(),
            'message' => $message,
            'context' => $context,
            'timestamp' => now()->toISOString(),
            'trace' => $e->getTraceAsString(),
        ];

        Log::channel('single')->error('Gemini API Error', $logData);
    }

    /**
     * Log RAG service operations
     */
    public static function logRAGOperation(string $operation, array $data = []): void
    {
        if (!config('gemini.logging.enabled', true)) {
            return;
        }

        $logData = array_merge([
            'type' => 'rag_operation',
            'operation' => $operation,
            'user_id' => Auth::id(),
            'timestamp' => now()->toISOString(),
        ], $data);

        Log::channel('single')->info('RAG Operation', $logData);
    }

    /**
     * Log API requests
     */
    public static function logApiRequest(Request $request, array $response = []): void
    {
        if (!config('gemini.logging.log_api_requests', true)) {
            return;
        }

        $logData = [
            'type' => 'api_request',
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'user_id' => Auth::id(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'response_status' => $response['status'] ?? null,
            'response_time' => $response['time'] ?? null,
            'timestamp' => now()->toISOString(),
        ];

        Log::channel('single')->info('API Request', $logData);
    }

    /**
     * Log performance metrics
     */
    public static function logPerformance(string $operation, float $duration, array $metrics = []): void
    {
        if (!config('gemini.logging.enabled', true)) {
            return;
        }

        $logData = array_merge([
            'type' => 'performance',
            'operation' => $operation,
            'duration_ms' => round($duration * 1000, 2),
            'user_id' => Auth::id(),
            'timestamp' => now()->toISOString(),
        ], $metrics);

        Log::channel('single')->info('Performance Metric', $logData);
    }

    /**
     * Log security events
     */
    public static function logSecurityEvent(string $event, array $data = []): void
    {
        $logData = array_merge([
            'type' => 'security_event',
            'event' => $event,
            'user_id' => Auth::id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toISOString(),
        ], $data);

        Log::channel('single')->warning('Security Event', $logData);
    }

    /**
     * Log database queries for debugging
     */
    public static function logDatabaseQuery(string $query, float $duration, array $bindings = []): void
    {
        if (!config('app.debug_sql_queries', false)) {
            return;
        }

        $logData = [
            'type' => 'database_query',
            'query' => $query,
            'duration_ms' => round($duration * 1000, 2),
            'bindings' => $bindings,
            'timestamp' => now()->toISOString(),
        ];

        Log::channel('single')->debug('Database Query', $logData);
    }

    /**
     * Get chat statistics for monitoring
     */
    public static function getChatStats(): array
    {
        $today = now()->startOfDay();
        $yesterday = $today->copy()->subDay();
        $thisWeek = now()->startOfWeek();

        return [
            'today' => [
                'messages' => \App\Models\Chat::whereDate('created_at', $today)->count(),
                'sessions' => \App\Models\Chat::whereDate('created_at', $today)->distinct('session_id')->count(),
            ],
            'yesterday' => [
                'messages' => \App\Models\Chat::whereDate('created_at', $yesterday)->count(),
                'sessions' => \App\Models\Chat::whereDate('created_at', $yesterday)->distinct('session_id')->count(),
            ],
            'this_week' => [
                'messages' => \App\Models\Chat::where('created_at', '>=', $thisWeek)->count(),
                'sessions' => \App\Models\Chat::where('created_at', '>=', $thisWeek)->distinct('session_id')->count(),
            ],
            'total' => [
                'messages' => \App\Models\Chat::count(),
                'sessions' => \App\Models\Chat::distinct('session_id')->count(),
            ],
        ];
    }
}
