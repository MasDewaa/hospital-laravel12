<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RAGService
{
    /**
     * Retrieve relevant context from database based on user query
     */
    public function retrieveContext(string $query, int $userId = null): array
    {
        $context = [];
        $query = strtolower(trim($query));

        // Extract keywords from query
        $keywords = $this->extractKeywords($query);

        // Get relevant data based on keywords
        $context = array_merge($context, $this->getHospitalInfo($keywords));
        $context = array_merge($context, $this->getServicesInfo($keywords));
        $context = array_merge($context, $this->getDoctorsInfo($keywords));
        $context = array_merge($context, $this->getAppointmentsInfo($keywords, $userId));
        $context = array_merge($context, $this->getPatientInfo($keywords, $userId));
        $context = array_merge($context, $this->getChatHistory($keywords, $userId));

        return $context;
    }

    /**
     * Extract keywords from user query
     */
    private function extractKeywords(string $query): array
    {
        // Remove common stop words
        $stopWords = ['saya', 'anda', 'kita', 'mereka', 'ini', 'itu', 'yang', 'dengan', 'untuk', 'dari', 'ke', 'di', 'pada', 'adalah', 'akan', 'sudah', 'belum', 'tidak', 'bukan', 'atau', 'dan', 'tetapi', 'jika', 'karena', 'sehingga'];
        
        $words = preg_split('/\s+/', $query);
        $keywords = array_filter($words, function($word) use ($stopWords) {
            return strlen($word) > 2 && !in_array($word, $stopWords);
        });

        return array_values($keywords);
    }

    /**
     * Get hospital information
     */
    private function getHospitalInfo(array $keywords): array
    {
        $context = [];

        if ($this->hasKeyword($keywords, ['rumah sakit', 'hospital', 'alamat', 'kontak', 'telepon'])) {
            $context['hospital_info'] = [
                'name' => 'Rumah Sakit Sehat Sentosa',
                'address' => 'Jl. Kesehatan No. 123, Jakarta Selatan 12345',
                'phone' => '(021) 1234-5678',
                'emergency' => '(021) 9999-8888',
                'email' => 'info@rssehatsentosa.com',
                'website' => 'https://rssehatsentosa.com'
            ];
        }

        return $context;
    }

    /**
     * Get services information
     */
    private function getServicesInfo(array $keywords): array
    {
        $context = [];

        if ($this->hasKeyword($keywords, ['layanan', 'service', 'poli', 'klinik', 'rawat', 'inap'])) {
            $context['services'] = [
                'poli_umum' => 'Konsultasi kesehatan umum - 08:00-20:00 (Senin-Jumat)',
                'poli_gigi' => 'Perawatan gigi dan mulut - 08:00-17:00 (Senin-Jumat)',
                'poli_jantung' => 'Pemeriksaan dan perawatan jantung - 08:00-17:00 (Senin-Jumat)',
                'poli_anak' => 'Perawatan khusus anak-anak - 08:00-17:00 (Senin-Jumat)',
                'emergency' => 'Pelayanan darurat 24 jam setiap hari',
                'rawat_inap' => 'Kamar VIP, VVIP, Kelas 1, 2, 3',
                'laboratorium' => 'Pemeriksaan darah, urine, dan tes medis lainnya',
                'radiologi' => 'X-Ray, CT Scan, MRI',
                'apotek' => 'Obat-obatan dan resep - 08:00-22:00'
            ];
        }

        return $context;
    }

    /**
     * Get doctors information
     */
    private function getDoctorsInfo(array $keywords): array
    {
        $context = [];

        if ($this->hasKeyword($keywords, ['dokter', 'doctor', 'spesialis', 'medis', 'dr'])) {
            $doctors = Doctor::with('user')->get();
            
            $context['doctors'] = $doctors->map(function($doctor) {
                return [
                    'name' => $doctor->name,
                    'specialization' => $doctor->specialization,
                    'phone' => $doctor->phone,
                    'email' => $doctor->email
                ];
            })->toArray();
        }

        return $context;
    }

    /**
     * Get appointments information
     */
    private function getAppointmentsInfo(array $keywords, int $userId = null): array
    {
        $context = [];

        if ($this->hasKeyword($keywords, ['janji', 'appointment', 'booking', 'jadwal', 'waktu'])) {
            if ($userId) {
                // Get user's appointments
                $user = \App\Models\User::find($userId);
                if ($user && $user->isPatient()) {
                    $patient = Patient::where('user_id', $userId)->first();
                    if ($patient) {
                        $appointments = Appointment::where('patient_id', $patient->id)
                            ->with(['doctor', 'patient'])
                            ->orderBy('appointment_date', 'desc')
                            ->take(5)
                            ->get();

                        $context['user_appointments'] = $appointments->map(function($appointment) {
                            return [
                                'date' => $appointment->appointment_date->format('Y-m-d'),
                                'time' => $appointment->appointment_time,
                                'doctor' => $appointment->doctor->name,
                                'specialization' => $appointment->doctor->specialization,
                                'status' => $appointment->status
                            ];
                        })->toArray();
                    }
                }
            }

            // Get general appointment info
            $context['appointment_info'] = [
                'how_to_book' => 'Login ke sistem, pilih menu Buat Janji Temu, pilih dokter dan waktu',
                'contact_booking' => 'Hubungi (021) 1234-5678 untuk bantuan booking',
                'cancellation' => 'Bisa dibatalkan minimal 2 jam sebelum jadwal',
                'reschedule' => 'Bisa diubah jadwal dengan menghubungi rumah sakit'
            ];
        }

        return $context;
    }

    /**
     * Get patient information
     */
    private function getPatientInfo(array $keywords, int $userId = null): array
    {
        $context = [];

        if ($userId && $this->hasKeyword($keywords, ['saya', 'profil', 'data', 'riwayat', 'medical'])) {
            $user = \App\Models\User::find($userId);
            if ($user && $user->isPatient()) {
                $patient = Patient::where('user_id', $userId)->first();
                if ($patient) {
                    $context['patient_info'] = [
                        'name' => $patient->name,
                        'patient_id' => $patient->patient_id,
                        'date_of_birth' => $patient->date_of_birth->format('Y-m-d'),
                        'age' => $patient->date_of_birth->age,
                        'phone' => $patient->phone,
                        'email' => $patient->email,
                        'address' => $patient->address,
                        'medical_history' => $patient->medical_history
                    ];
                }
            }
        }

        return $context;
    }

    /**
     * Get relevant chat history
     */
    private function getChatHistory(array $keywords, int $userId = null): array
    {
        $context = [];

        if ($userId) {
            // Get recent chat history for context
            $recentChats = Chat::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            if ($recentChats->count() > 0) {
                $context['chat_history'] = $recentChats->map(function($chat) {
                    return [
                        'sender' => $chat->sender,
                        'message' => Str::limit($chat->message, 100),
                        'time' => $chat->created_at->format('H:i')
                    ];
                })->toArray();
            }
        }

        return $context;
    }

    /**
     * Check if keywords contain specific terms
     */
    private function hasKeyword(array $keywords, array $terms): bool
    {
        foreach ($terms as $term) {
            foreach ($keywords as $keyword) {
                if (strpos($keyword, $term) !== false || strpos($term, $keyword) !== false) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Get similar questions from chat history
     */
    public function getSimilarQuestions(string $query, int $limit = 5): array
    {
        $keywords = $this->extractKeywords($query);
        
        $similarChats = Chat::where('sender', 'user')
            ->where(function($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('message', 'like', "%{$keyword}%");
                }
            })
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();

        return $similarChats->map(function($chat) {
            return [
                'question' => $chat->message,
                'time' => $chat->created_at->format('M d, H:i')
            ];
        })->toArray();
    }

    /**
     * Get FAQ data
     */
    public function getFAQ(): array
    {
        return [
            [
                'question' => 'Apa saja layanan yang tersedia di rumah sakit?',
                'answer' => 'Rumah Sakit Sehat Sentosa menyediakan Poli Umum, Poli Gigi, Poli Jantung, Poli Anak, Emergency 24/7, Rawat Inap, Laboratorium, Radiologi, dan Apotek.'
            ],
            [
                'question' => 'Bagaimana cara membuat janji temu?',
                'answer' => 'Anda bisa login ke sistem di website, pilih menu Buat Janji Temu, pilih dokter dan waktu yang tersedia, atau hubungi (021) 1234-5678.'
            ],
            [
                'question' => 'Apakah rumah sakit menerima BPJS?',
                'answer' => 'Ya, kami menerima BPJS Kesehatan, asuransi swasta, pembayaran tunai, transfer bank, dan kartu kredit/debit.'
            ],
            [
                'question' => 'Jam operasional rumah sakit?',
                'answer' => 'Poli umum 08:00-20:00 (Senin-Jumat), Emergency 24 jam, Apotek 08:00-22:00. Untuk jadwal lengkap silakan hubungi kami.'
            ],
            [
                'question' => 'Bagaimana cara menghubungi rumah sakit?',
                'answer' => 'Telepon: (021) 1234-5678, Emergency: (021) 9999-8888, Email: info@rssehatsentosa.com'
            ]
        ];
    }
}
