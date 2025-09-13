<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Services\GeminiService;
use App\Services\RAGService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    protected $geminiService;
    protected $ragService;

    public function __construct(GeminiService $geminiService, RAGService $ragService)
    {
        $this->geminiService = $geminiService;
        $this->ragService = $ragService;
    }

    /**
     * Handle sending a message and getting AI response.
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string',
        ]);

        $sessionId = $validated['session_id'] ?? Str::uuid()->toString();
        $message = $validated['message'];
        $userId = Auth::id();

        try {
            // Save user message
            $userChat = Chat::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'sender' => 'user',
                'message' => $message,
                'metadata' => [
                    'timestamp' => now()->toISOString(),
                    'ip_address' => $request->ip(),
                ]
            ]);

            // Retrieve context using RAG
            $context = $this->ragService->retrieveContext($message, $userId);

            // Generate AI response using GeminiService
            $aiResponse = $this->geminiService->generateResponse($message, $context);

            // Save AI response
            $aiChat = Chat::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'sender' => 'ai',
                'message' => $aiResponse,
                'metadata' => [
                    'timestamp' => now()->toISOString(),
                ]
            ]);

            return response()->json([
                'success' => true,
                'session_id' => $sessionId,
                'user_message' => $userChat,
                'ai_response' => $aiChat,
            ]);
        } catch (\Exception $e) {
            Log::error('Error processing message: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to process message'], 500);
        }
    }
}