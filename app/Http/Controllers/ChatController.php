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

    /**
     * Test Gemini API connection
     */
    public function testGemini()
    {
        try {
            $testMessage = "Hello, this is a test message.";
            $response = $this->geminiService->generateResponse($testMessage, null);
            
            return response()->json([
                'success' => true,
                'message' => 'Gemini API connected successfully',
                'test_response' => $response,
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            Log::error('Gemini test failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gemini API connection failed',
                'error' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ], 500);
        }
    }

    /**
     * Get FAQ data
     */
    public function getFAQ()
    {
        try {
            $faq = $this->ragService->getFAQ();
            
            return response()->json([
                'success' => true,
                'data' => $faq,
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting FAQ: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve FAQ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get similar questions based on query
     */
    public function getSimilarQuestions(Request $request)
    {
        $validated = $request->validate([
            'query' => 'required|string|max:255',
            'limit' => 'nullable|integer|min:1|max:20'
        ]);

        try {
            $limit = $validated['limit'] ?? 5;
            $similarQuestions = $this->ragService->getSimilarQuestions($validated['query'], $limit);
            
            return response()->json([
                'success' => true,
                'data' => $similarQuestions,
                'query' => $validated['query'],
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting similar questions: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve similar questions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get chat history for a user
     */
    public function getHistory(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'nullable|string',
            'limit' => 'nullable|integer|min:1|max:100',
            'offset' => 'nullable|integer|min:0'
        ]);

        try {
            $userId = Auth::id();
            $limit = $validated['limit'] ?? 50;
            $offset = $validated['offset'] ?? 0;
            
            $query = Chat::where('user_id', $userId)
                ->orderBy('created_at', 'desc');
            
            if (!empty($validated['session_id'])) {
                $query->where('session_id', $validated['session_id']);
            }
            
            $chats = $query->skip($offset)
                ->take($limit)
                ->get()
                ->map(function($chat) {
                    return [
                        'id' => $chat->id,
                        'session_id' => $chat->session_id,
                        'sender' => $chat->sender,
                        'message' => $chat->message,
                        'created_at' => $chat->created_at->toISOString(),
                        'metadata' => $chat->metadata
                    ];
                });
            
            return response()->json([
                'success' => true,
                'data' => $chats,
                'pagination' => [
                    'limit' => $limit,
                    'offset' => $offset,
                    'total' => $query->count()
                ],
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting chat history: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve chat history',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get chat statistics
     */
    public function getStats(Request $request)
    {
        try {
            $userId = Auth::id();
            $sessionId = $request->get('session_id');
            
            $query = Chat::where('user_id', $userId);
            
            if ($sessionId) {
                $query->where('session_id', $sessionId);
            }
            
            $totalMessages = $query->count();
            $userMessages = $query->where('sender', 'user')->count();
            $aiMessages = $query->where('sender', 'ai')->count();
            
            $sessions = Chat::where('user_id', $userId)
                ->select('session_id')
                ->distinct()
                ->count();
            
            $recentActivity = Chat::where('user_id', $userId)
                ->where('created_at', '>=', now()->subDays(7))
                ->count();
            
            $stats = [
                'total_messages' => $totalMessages,
                'user_messages' => $userMessages,
                'ai_messages' => $aiMessages,
                'total_sessions' => $sessions,
                'recent_activity_7_days' => $recentActivity,
                'average_messages_per_session' => $sessions > 0 ? round($totalMessages / $sessions, 2) : 0
            ];
            
            return response()->json([
                'success' => true,
                'data' => $stats,
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting chat stats: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve chat statistics',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}