<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gemini AI Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for Google Gemini AI integration.
    | You can customize the model, API settings, and response parameters here.
    |
    */

    'api_key' => env('GEMINI_API_KEY'),
    'model' => env('GEMINI_MODEL', 'gemini-2.0-flash'),
    'base_url' => env('GEMINI_BASE_URL', 'https://generativelanguage.googleapis.com/v1beta'),

    /*
    |--------------------------------------------------------------------------
    | Generation Configuration
    |--------------------------------------------------------------------------
    |
    | These settings control how the AI generates responses.
    |
    */

    'generation' => [
        'temperature' => env('GEMINI_TEMPERATURE', 0.7),
        'top_k' => env('GEMINI_TOP_K', 40),
        'top_p' => env('GEMINI_TOP_P', 0.95),
        'max_output_tokens' => env('GEMINI_MAX_OUTPUT_TOKENS', 1024),
        'candidate_count' => env('GEMINI_CANDIDATE_COUNT', 1),
    ],

    /*
    |--------------------------------------------------------------------------
    | Safety Settings
    |--------------------------------------------------------------------------
    |
    | Configure safety filters for content generation.
    |
    */

    'safety_settings' => [
        'harassment' => env('GEMINI_SAFETY_HARASSMENT', 'BLOCK_MEDIUM_AND_ABOVE'),
        'hate_speech' => env('GEMINI_SAFETY_HATE_SPEECH', 'BLOCK_MEDIUM_AND_ABOVE'),
        'sexually_explicit' => env('GEMINI_SAFETY_SEXUALLY_EXPLICIT', 'BLOCK_MEDIUM_AND_ABOVE'),
        'dangerous_content' => env('GEMINI_SAFETY_DANGEROUS_CONTENT', 'BLOCK_MEDIUM_AND_ABOVE'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Hospital Information
    |--------------------------------------------------------------------------
    |
    | Default hospital information used in AI responses.
    |
    */

    'hospital' => [
        'name' => env('HOSPITAL_NAME', 'Rumah Sakit Sehat Sentosa'),
        'address' => env('HOSPITAL_ADDRESS', 'Jl. Kesehatan No. 123, Jakarta Selatan 12345'),
        'phone' => env('HOSPITAL_PHONE', '(021) 1234-5678'),
        'emergency' => env('HOSPITAL_EMERGENCY', '(021) 9999-8888'),
        'email' => env('HOSPITAL_EMAIL', 'info@rssehatsentosa.com'),
        'website' => env('HOSPITAL_WEBSITE', 'https://rssehatsentosa.com'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Chat Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for chat functionality and AI responses.
    |
    */

    'chat' => [
        'max_message_length' => env('CHAT_MAX_MESSAGE_LENGTH', 1000),
        'session_timeout' => env('CHAT_SESSION_TIMEOUT', 1800), // 30 minutes
        'rate_limit' => env('CHAT_RATE_LIMIT', 10),
        'rate_limit_window' => env('CHAT_RATE_LIMIT_WINDOW', 60), // 1 minute
        'enable_context' => env('CHAT_ENABLE_CONTEXT', true),
        'context_history_limit' => env('CHAT_CONTEXT_HISTORY_LIMIT', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching Configuration
    |--------------------------------------------------------------------------
    |
    | Cache settings for AI responses and FAQ data.
    |
    */

    'cache' => [
        'enabled' => env('CACHE_CHAT_RESPONSES', true),
        'ttl' => env('CACHE_CHAT_TTL', 300), // 5 minutes
        'faq_ttl' => env('CACHE_FAQ_TTL', 3600), // 1 hour
        'prefix' => 'gemini_chat_',
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for fallback responses when AI is unavailable.
    |
    */

    'fallback' => [
        'enabled' => env('GEMINI_FALLBACK_ENABLED', true),
        'use_keyword_matching' => env('GEMINI_FALLBACK_KEYWORDS', true),
        'default_response' => 'Maaf, saya mengalami gangguan teknis. Silakan hubungi Rumah Sakit Sehat Sentosa di (021) 1234-5678 untuk bantuan langsung, atau coba lagi nanti.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Logging settings for debugging and monitoring.
    |
    */

    'logging' => [
        'enabled' => env('LOG_CHAT_INTERACTIONS', true),
        'log_requests' => env('LOG_GEMINI_REQUESTS', true),
        'log_responses' => env('LOG_GEMINI_RESPONSES', false),
        'log_errors' => env('LOG_GEMINI_ERRORS', true),
        'log_context' => env('LOG_GEMINI_CONTEXT', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Development Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for development and debugging.
    |
    */

    'debug' => [
        'enabled' => env('DEBUG_GEMINI_API', false),
        'log_prompts' => env('DEBUG_GEMINI_PROMPTS', false),
        'log_context' => env('DEBUG_GEMINI_CONTEXT', false),
        'mock_responses' => env('GEMINI_MOCK_RESPONSES', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Timeout Configuration
    |--------------------------------------------------------------------------
    |
    | Timeout settings for API requests.
    |
    */

    'timeout' => [
        'connection' => env('GEMINI_TIMEOUT_CONNECTION', 30),
        'request' => env('GEMINI_TIMEOUT_REQUEST', 60),
        'response' => env('GEMINI_TIMEOUT_RESPONSE', 120),
    ],
];
