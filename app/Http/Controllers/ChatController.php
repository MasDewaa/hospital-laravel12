<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GeminiService;

class ChatController extends Controller
{
    private GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function sendMessage(Request $request)
{
    $request->validate([
        'message' => 'required|string',
    ]);

    $message = $request->input('message');

    // Panggil GeminiService (atau AI service kamu)
    $response = $this->gemini->generateResponse($message);

    return response()->json([
        'success'    => true,
        'session_id' => $request->input('session_id') ?? uniqid("session_", true),
        'ai_response' => [
            'message' => $response,
        ],
    ]);
}

}
