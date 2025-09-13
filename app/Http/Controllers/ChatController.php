<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Get chat history for a session
     */
    public function getHistory(Request $request)
    {
        $sessionId = $request->get('session_id');
        
        if (!$sessionId) {
            return response()->json(['error' => 'Session ID required'], 400);
        }

        $chats = Chat::session($sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $chats
        ]);
    }

    /**
     * Send a message and get AI response
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string',
        ]);

        $sessionId = $request->get('session_id') ?: Str::uuid()->toString();
        $message = $request->get('message');
        $userId = Auth::id();

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

        // Generate AI response
        $aiResponse = $this->generateAIResponse($message, $sessionId);

        // Save AI response
        $aiChat = Chat::create([
            'session_id' => $sessionId,
            'user_id' => $userId,
            'sender' => 'ai',
            'message' => $aiResponse,
            'metadata' => [
                'timestamp' => now()->toISOString(),
                'response_time' => microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
            ]
        ]);

        return response()->json([
            'success' => true,
            'session_id' => $sessionId,
            'user_message' => $userChat,
            'ai_response' => $aiChat,
        ]);
    }

    /**
     * Generate AI response based on user message
     */
    private function generateAIResponse(string $message, string $sessionId): string
    {
        $message = strtolower(trim($message));
        
        // Get recent chat history for context
        $recentChats = Chat::session($sessionId)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->reverse();

        // Simple AI responses based on keywords and context
        $responses = [
            // Greetings
            'greeting' => [
                'Halo! Saya AI Assistant Rumah Sakit Sehat Sentosa. Bagaimana saya bisa membantu Anda hari ini?',
                'Selamat datang! Saya siap membantu Anda dengan informasi tentang layanan rumah sakit kami.',
                'Hai! Ada yang bisa saya bantu terkait kesehatan atau layanan rumah sakit?'
            ],
            
            // Hospital services
            'layanan' => [
                'Rumah Sakit Sehat Sentosa menyediakan berbagai layanan kesehatan:',
                '• Poli Umum - Konsultasi kesehatan umum',
                '• Poli Gigi - Perawatan gigi dan mulut',
                '• Poli Jantung - Pemeriksaan dan perawatan jantung',
                '• Poli Anak - Perawatan khusus anak-anak',
                '• Emergency 24/7 - Pelayanan darurat',
                'Apakah ada layanan khusus yang ingin Anda ketahui lebih detail?'
            ],
            
            // Appointment booking
            'janji' => [
                'Untuk membuat janji temu, Anda bisa:',
                '1. Login ke sistem dan pilih "Buat Janji Temu"',
                '2. Pilih dokter dan waktu yang tersedia',
                '3. Isi informasi yang diperlukan',
                '4. Konfirmasi janji temu',
                'Apakah Anda sudah memiliki akun di sistem kami?'
            ],
            
            // Contact information
            'kontak' => [
                'Informasi kontak Rumah Sakit Sehat Sentosa:',
                '📞 Telepon: (021) 1234-5678',
                '🚨 Emergency: (021) 9999-8888',
                '📧 Email: info@rssehatsentosa.com',
                '📍 Alamat: Jl. Kesehatan No. 123, Jakarta Selatan',
                'Jam operasional: 24 jam untuk emergency, 08:00-20:00 untuk layanan umum'
            ],
            
            // Emergency
            'darurat' => [
                'Untuk keadaan darurat, segera hubungi:',
                '🚨 Emergency: (021) 9999-8888',
                'Atau datang langsung ke IGD (Instalasi Gawat Darurat)',
                'IGD kami buka 24 jam dan siap melayani pasien darurat.',
                'Apakah ini keadaan darurat yang memerlukan pertolongan segera?'
            ],
            
            // Doctor information
            'dokter' => [
                'Kami memiliki tim dokter spesialis berpengalaman:',
                '• Dr. John Smith - Spesialis Jantung',
                '• Dr. Sarah Wilson - Spesialis Gigi',
                '• Dr. Michael Brown - Spesialis Anak',
                '• Dr. Lisa Davis - Dokter Umum',
                'Untuk melihat jadwal dokter, silakan login ke sistem atau hubungi kami.'
            ],
            
            // Payment
            'bayar' => [
                'Informasi pembayaran:',
                '• Kami menerima BPJS Kesehatan',
                '• Asuransi swasta (Allianz, Prudential, dll)',
                '• Pembayaran tunai',
                '• Transfer bank',
                '• Kartu kredit/debit',
                'Apakah Anda memiliki asuransi atau ingin informasi lebih detail?'
            ],
            
            // Default responses
            'default' => [
                'Maaf, saya belum memahami pertanyaan Anda dengan baik.',
                'Bisa Anda jelaskan lebih detail? Saya bisa membantu dengan:',
                '• Informasi layanan rumah sakit',
                '• Cara membuat janji temu',
                '• Informasi kontak',
                '• Informasi dokter',
                '• Informasi pembayaran',
                '• Keadaan darurat'
            ]
        ];

        // Check for keywords and generate appropriate response
        if (preg_match('/\b(halo|hai|selamat|pagi|siang|sore|malam)\b/', $message)) {
            return $this->getRandomResponse($responses['greeting']);
        }
        
        if (preg_match('/\b(layanan|service|poli|klinik|rawat|inap)\b/', $message)) {
            return implode("\n", $responses['layanan']);
        }
        
        if (preg_match('/\b(janji|appointment|booking|daftar|reservasi)\b/', $message)) {
            return implode("\n", $responses['janji']);
        }
        
        if (preg_match('/\b(kontak|telepon|alamat|email|hubung)\b/', $message)) {
            return implode("\n", $responses['kontak']);
        }
        
        if (preg_match('/\b(darurat|emergency|urgent|gawat|sakit|parah)\b/', $message)) {
            return implode("\n", $responses['darurat']);
        }
        
        if (preg_match('/\b(dokter|doctor|spesialis|dokter|medis)\b/', $message)) {
            return implode("\n", $responses['dokter']);
        }
        
        if (preg_match('/\b(bayar|pembayaran|harga|biaya|asuransi|bpjs)\b/', $message)) {
            return implode("\n", $responses['bayar']);
        }

        // Check recent context for better responses
        $context = $this->analyzeContext($recentChats);
        if ($context) {
            return $context;
        }

        return implode("\n", $responses['default']);
    }

    /**
     * Analyze chat context for better responses
     */
    private function analyzeContext($recentChats): ?string
    {
        $lastAiMessage = $recentChats->where('sender', 'ai')->last();
        
        if (!$lastAiMessage) {
            return null;
        }

        $lastMessage = strtolower($lastAiMessage->message);
        
        // If last AI message was about appointments, provide more details
        if (strpos($lastMessage, 'janji') !== false) {
            return "Apakah Anda ingin saya bantu memandu proses pembuatan janji temu? Atau ada pertanyaan lain tentang layanan kami?";
        }
        
        // If last AI message was about services, ask for specific service
        if (strpos($lastMessage, 'layanan') !== false) {
            return "Layanan mana yang paling Anda minati? Saya bisa memberikan informasi lebih detail tentang layanan tersebut.";
        }

        return null;
    }

    /**
     * Get random response from array
     */
    private function getRandomResponse(array $responses): string
    {
        return $responses[array_rand($responses)];
    }

    /**
     * Get chat statistics
     */
    public function getStats()
    {
        $totalChats = Chat::count();
        $userChats = Chat::userMessages()->count();
        $aiChats = Chat::aiMessages()->count();
        $uniqueSessions = Chat::distinct('session_id')->count('session_id');

        return response()->json([
            'success' => true,
            'data' => [
                'total_chats' => $totalChats,
                'user_messages' => $userChats,
                'ai_messages' => $aiChats,
                'unique_sessions' => $uniqueSessions,
            ]
        ]);
    }
}