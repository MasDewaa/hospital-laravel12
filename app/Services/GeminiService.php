<?php

namespace App\Services;

use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class GeminiService
{
    protected $model;
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->model = Config::get('gemini.model');
        $this->apiKey = Config::get('gemini.api_key');
        $this->baseUrl = Config::get('gemini.base_url');
    }

    /**
     * Generate response using Gemini AI with context
     */
    public function generateResponse(string $message, ?array $context = null): string
    {
        try {
            // Build the prompt with context
            $prompt = $this->buildPrompt($message, $context);
            
            // Configure generation parameters
            $generationConfig = [
                'temperature' => 0.7,
                'topK' => 40,
                'topP' => 0.95,
                'maxOutputTokens' => 1024,
            ];

            // Use Gemini facade to call the generative model
            $result = Gemini::generativeModel(model: $this->model)
                ->generateContent($prompt, $generationConfig);

            // Get text from response
            $response = $result->text();
            
            // Log successful generation
            Log::info('Gemini response generated successfully', [
                'message_length' => strlen($message),
                'context_items' => $context ? count($context) : 0,
                'response_length' => strlen($response)
            ]);

            return $response;
        } catch (\Exception $e) {
            Log::error('Gemini API error: ' . $e->getMessage(), [
                'message' => $message,
                'context' => $context,
                'error_code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Return fallback response based on context
            return $this->getFallbackResponse($message, $context);
        }
    }

    /**
     * Test Gemini API connection
     */
    public function testConnection(): array
    {
        try {
            $testMessage = "Hello, this is a test message.";
            $response = $this->generateResponse($testMessage, null);
            
            return [
                'success' => true,
                'message' => 'Gemini API connected successfully',
                'test_response' => $response,
                'model' => $this->model,
                'timestamp' => now()->toISOString()
            ];
        } catch (\Exception $e) {
            Log::error('Gemini connection test failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Gemini API connection failed',
                'error' => $e->getMessage(),
                'timestamp' => now()->toISOString()
            ];
        }
    }

    /**
     * Build prompt with context for better responses
     */
    private function buildPrompt(string $userMessage, ?array $context = null): string
    {
        $systemPrompt = "Anda adalah AI Assistant untuk Rumah Sakit Sehat Sentosa. ";
        $systemPrompt .= "Tugas Anda adalah membantu pasien dan pengunjung dengan informasi tentang layanan rumah sakit, ";
        $systemPrompt .= "janji temu, dokter, dan pertanyaan umum lainnya. ";
        $systemPrompt .= "Jawablah dengan ramah, informatif, dan profesional dalam bahasa Indonesia.\n\n";

        // Add context information if available
        if ($context && !empty($context)) {
            $systemPrompt .= "INFORMASI KONTEKS:\n";
            
            if (isset($context['hospital_info'])) {
                $hospital = $context['hospital_info'];
                $systemPrompt .= "Informasi Rumah Sakit:\n";
                $systemPrompt .= "- Nama: {$hospital['name']}\n";
                $systemPrompt .= "- Alamat: {$hospital['address']}\n";
                $systemPrompt .= "- Telepon: {$hospital['phone']}\n";
                $systemPrompt .= "- Emergency: {$hospital['emergency']}\n";
                $systemPrompt .= "- Email: {$hospital['email']}\n\n";
            }

            if (isset($context['services'])) {
                $systemPrompt .= "Layanan yang Tersedia:\n";
                foreach ($context['services'] as $service => $description) {
                    $systemPrompt .= "- {$service}: {$description}\n";
                }
                $systemPrompt .= "\n";
            }

            if (isset($context['doctors']) && !empty($context['doctors'])) {
                $systemPrompt .= "Dokter yang Tersedia:\n";
                foreach ($context['doctors'] as $doctor) {
                    $systemPrompt .= "- {$doctor['name']} ({$doctor['specialization']})\n";
                }
                $systemPrompt .= "\n";
            }

            if (isset($context['user_appointments']) && !empty($context['user_appointments'])) {
                $systemPrompt .= "Janji Temu Pasien:\n";
                foreach ($context['user_appointments'] as $appointment) {
                    $systemPrompt .= "- {$appointment['date']} {$appointment['time']} dengan Dr. {$appointment['doctor']} ({$appointment['specialization']}) - Status: {$appointment['status']}\n";
                }
                $systemPrompt .= "\n";
            }

            if (isset($context['patient_info'])) {
                $patient = $context['patient_info'];
                $systemPrompt .= "Informasi Pasien:\n";
                $systemPrompt .= "- Nama: {$patient['name']}\n";
                $systemPrompt .= "- ID Pasien: {$patient['patient_id']}\n";
                $systemPrompt .= "- Umur: {$patient['age']} tahun\n";
                $systemPrompt .= "- Telepon: {$patient['phone']}\n\n";
            }

            if (isset($context['chat_history']) && !empty($context['chat_history'])) {
                $systemPrompt .= "Riwayat Percakapan Terbaru:\n";
                foreach (array_slice($context['chat_history'], 0, 5) as $chat) {
                    $sender = $chat['sender'] === 'user' ? 'Pasien' : 'AI';
                    $systemPrompt .= "- {$sender}: {$chat['message']}\n";
                }
                $systemPrompt .= "\n";
            }
        }

        $systemPrompt .= "PERTANYAAN PASIEN: {$userMessage}\n\n";
        $systemPrompt .= "Jawablah pertanyaan di atas dengan informasi yang relevan dan akurat. ";
        $systemPrompt .= "Jika tidak yakin dengan informasi tertentu, sarankan untuk menghubungi rumah sakit langsung.";

        return $systemPrompt;
    }

    /**
     * Get fallback response when Gemini API fails
     */
    private function getFallbackResponse(string $message, ?array $context = null): string
    {
        $message = strtolower(trim($message));
        
        // Simple keyword-based responses
        if (strpos($message, 'layanan') !== false || strpos($message, 'service') !== false) {
            return "Rumah Sakit Sehat Sentosa menyediakan berbagai layanan termasuk Poli Umum, Poli Gigi, Poli Jantung, Poli Anak, Emergency 24/7, Rawat Inap, Laboratorium, Radiologi, dan Apotek. Untuk informasi lebih detail, silakan hubungi (021) 1234-5678.";
        }
        
        if (strpos($message, 'janji') !== false || strpos($message, 'appointment') !== false) {
            return "Untuk membuat janji temu, Anda bisa login ke sistem di website, pilih menu Buat Janji Temu, pilih dokter dan waktu yang tersedia. Atau hubungi (021) 1234-5678 untuk bantuan booking.";
        }
        
        if (strpos($message, 'dokter') !== false || strpos($message, 'doctor') !== false) {
            return "Kami memiliki dokter spesialis di berbagai bidang. Untuk melihat daftar dokter dan jadwal praktik, silakan kunjungi halaman dokter di website atau hubungi (021) 1234-5678.";
        }
        
        if (strpos($message, 'kontak') !== false || strpos($message, 'telepon') !== false) {
            return "Kontak Rumah Sakit Sehat Sentosa:\n- Telepon: (021) 1234-5678\n- Emergency: (021) 9999-8888\n- Email: info@rssehatsentosa.com\n- Alamat: Jl. Kesehatan No. 123, Jakarta Selatan 12345";
        }
        
        if (strpos($message, 'bpjs') !== false) {
            return "Ya, kami menerima BPJS Kesehatan, asuransi swasta, pembayaran tunai, transfer bank, dan kartu kredit/debit.";
        }
        
        if (strpos($message, 'jam') !== false || strpos($message, 'operasional') !== false) {
            return "Jam operasional:\n- Poli umum: 08:00-20:00 (Senin-Jumat)\n- Emergency: 24 jam setiap hari\n- Apotek: 08:00-22:00\n- Untuk jadwal lengkap silakan hubungi kami.";
        }
        
        // Default response
        return "Maaf, saya mengalami gangguan teknis. Silakan hubungi Rumah Sakit Sehat Sentosa di (021) 1234-5678 untuk bantuan langsung, atau coba lagi nanti.";
    }

    /**
     * Check if API key is configured
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiKey);
    }

    /**
     * Get current configuration
     */
    public function getConfig(): array
    {
        return [
            'model' => $this->model,
            'api_key_configured' => $this->isConfigured(),
            'base_url' => $this->baseUrl
        ];
    }
}

