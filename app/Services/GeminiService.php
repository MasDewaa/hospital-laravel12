<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    /**
     * Generate response using Gemini AI
     */
    public function generateResponse(string $message, ?string $context): string
    {
        try {
            // Gunakan Gemini facade untuk memanggil model generatif
            $result = Gemini::generativeModel(model: 'gemini-2.0-flash')
                ->generateContent($message);

            // Ambil teks dari respons
            return $result->text();
        } catch (\Exception $e) {
            Log::error('Gemini API error: ' . $e->getMessage());
            return 'Maaf, saya mengalami gangguan teknis. Silakan coba lagi.';
        }
    }
}
