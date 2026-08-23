<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    /**
     * Generate narasi hasil asesmen menggunakan Gemini API.
     * Mengembalikan array berisi 'summary', 'explanation', dan 'reasons'.
     *
     * @param array $assessmentData Data hasil dari AssessmentController
     * @return array Narasi yang di-generate oleh AI
     */
    public function generateAssessmentSummary(array $assessmentData): array
    {
        $apiKey = env('GEMINI_API_KEY');
        
        $default = [
            'summary' => 'Gagal memuat ringkasan otomatis.',
            'explanation' => 'Penjelasan mendalam tidak tersedia saat ini.',
            'reasons' => ['Kecocokan minat', 'Karakter pendukung']
        ];

        if (empty($apiKey) || $apiKey === 'masukkan_api_key_gemini_anda_disini') {
            Log::warning('GEMINI_API_KEY belum dikonfigurasi.');
            return $default;
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}";

        $prompt = $this->buildPrompt($assessmentData);

        try {
            $response = Http::timeout(20)->withoutVerifying()->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 1000,
                    'responseMimeType' => 'application/json',
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                if ($text) {
                    $json = json_decode($text, true);
                    return is_array($json) ? $json : $default;
                }
            }

            Log::error('Gemini API Error: ' . $response->body());
            return $default;

        } catch (\Exception $e) {
            Log::error('Gemini Request Exception: ' . $e->getMessage());
            return $default;
        }
    }

    /**
     * Menyusun prompt berdasarkan data dari Engine dengan Mapping Label
     */
    private function buildPrompt(array $data): string
    {
        $riasecLabels = ['Realistic', 'Investigative', 'Artistic', 'Social', 'Enterprising', 'Conventional'];
        $traitLabels = ['Openness', 'Conscientiousness', 'Extraversion', 'Agreeableness', 'Emotional Stability'];
        $envLabels = ['Terstruktur', 'Kolaboratif', 'Dinamis', 'High Pressure', 'Formal', 'Outdoor'];

        $mappedRiasec = [];
        foreach ($data['riasec'] ?? [] as $key => $val) {
            $label = $riasecLabels[(int)$key] ?? $key;
            $mappedRiasec[$label] = $val;
        }

        $mappedTrait = [];
        foreach ($data['trait'] ?? [] as $key => $val) {
            $label = $traitLabels[(int)$key] ?? $key;
            $mappedTrait[$label] = $val;
        }

        $mappedEnv = [];
        foreach ($data['environment'] ?? [] as $key => $val) {
            $label = $envLabels[(int)$key] ?? $key;
            $mappedEnv[$label] = $val;
        }

        $profList = "";
        foreach (array_slice($data['professions'] ?? [], 0, 10) as $p) {
            $profList .= "- {$p['name']} ({$p['score']}%)\n";
        }

        return "Kamu adalah seorang pakar psikologi karir dan konselor profesional.
Tugasmu adalah menganalisis data asesmen user dan memberikan narasi yang humanis, personal, dan motivasional untuk Gen-Z.

Data User:
1. Rekomendasi Profesi:
{$profList}
2. Profil Minat (RIASEC): " . json_encode($mappedRiasec) . "
3. Profil Kepribadian (Big Five): " . json_encode($mappedTrait) . "
4. Preferensi Lingkungan Kerja: " . json_encode($mappedEnv) . "

Berikan output dalam format JSON dengan key berikut:
- 'summary': Paragraf ringkas (max 3 kalimat) tentang mengapa dia cocok di profesi teratas.
- 'explanation': Paragraf mendalam tentang kombinasi karakter dan minatnya yang membentuk profil uniknya.
- 'reasons': Array of string (minimal 3) berisi alasan spesifik mengapa profesi tersebut direkomendasikan.

Ketentuan:
- Gunakan Bahasa Indonesia yang luwes dan tidak kaku (Gaya Gen-Z yang sopan tapi asik).
- Jangan gunakan sapaan 'Halo' atau 'Selamat'.
- Jangan sebutkan angka skor secara mentah dalam narasi, gunakan deskripsi kualitatif (misal: sangat menonjol, seimbang, dll).
- Fokus pada 'WHY' (Mengapa profilnya nyambung banget sama profesi itu).";
    }
}
