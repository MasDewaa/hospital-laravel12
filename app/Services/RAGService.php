<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class RagService
{
    private GeminiService $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function ask(string $query): string
    {
        // Step 1: cek apakah query cocok dengan gejala
        $symptomResponse = $this->checkSymptoms($query);
        if ($symptomResponse) {
            return $symptomResponse;
        }

        // Step 2: ambil context dari DB (dokter/staff)
        $context = $this->retrieveContext($query);

        // Step 3: minta Gemini jawab dengan context
        $response = $this->gemini->generateResponse($query, $context);

        return $response ?: "Maaf, saya mengalami gangguan teknis. Silakan hubungi Rumah Sakit Sehat Sentosa di (021) 1234-5678 untuk bantuan langsung.";
    }

    private function checkSymptoms(string $query): ?string
    {
        $symptoms = config('symptoms_knowledge');

        foreach ($symptoms as $keyword => $info) {
            if (stripos($query, $keyword) !== false) {
                return $info['response'];
            }
        }

        return null;
    }

    private function retrieveContext(string $query): ?string
    {
        $contexts = [];

        if (stripos($query, 'dokter') !== false || stripos($query, 'spesialis') !== false) {
            $doctorMatches = DB::table('doctors')
                ->where('name', 'like', "%$query%")
                ->orWhere('specialization', 'like', "%$query%")
                ->limit(3)
                ->get();

            foreach ($doctorMatches as $doc) {
                $contexts[] = "{$doc->name} adalah dokter spesialis {$doc->specialization}. Kontak: {$doc->phone}, email: {$doc->email}.";
            }
        }

        if (stripos($query, 'admin') !== false || stripos($query, 'staff') !== false) {
            $userMatches = DB::table('users')
                ->where('role', '!=', 'patient')
                ->limit(3)
                ->get();

            foreach ($userMatches as $usr) {
                $contexts[] = "User {$usr->name} memiliki peran {$usr->role}.";
            }
        }

        return $contexts ? implode("\n\n", $contexts) : null;
    }
}
