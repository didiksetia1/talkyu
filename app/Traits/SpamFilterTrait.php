<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait SpamFilterTrait
{
    /**
     * Cek apakah teks mengandung spam/kata kotor
     * menggunakan Gemini API + manual bad words fallback.
     *
     * @param string $text
     * @return bool true jika terdeteksi spam/tidak pantas
     */
    protected function isSpamWithAI(string $text): bool
    {
        // ========== Manual Bad Words List ==========
        $badWords = [
            'gratis', 'spam', 'judi', 'judol', 'pinjol',
            'slot', 'promo', 'jembut', 'kasar', 'porno',
            'kontol', 'memek', 'bangsat', 'anjing', 'babi'
        ];

        $manualCheck = function ($t) use ($badWords) {
            $textLower = strtolower($t);
            foreach ($badWords as $word) {
                if (strpos($textLower, $word) !== false) {
                    return true;
                }
            }
            return false;
        };

        // ========== Cek API Key ==========
        $apiKey = env('GEMINI_API_KEY');
        if (empty($apiKey) || strpos($apiKey, 'contoh_api_key') !== false) {
            return $manualCheck($text);
        }

        // ========== LAPISAN 1: Gemini AI ==========
        try {
            $prompt = "Tugas Anda adalah mendeteksi apakah teks berikut adalah spam, promosi, atau mengandung kata-kata tidak pantas/kasar (seperti judi online, pinjol) dalam konteks aplikasi pengaduan kampus. Jawab HANYA dengan 'YA' jika teks tersebut adalah spam/tidak pantas, dan 'TIDAK' jika teks tersebut wajar atau bersih. Teks: " . $text;

            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->timeout(10)->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=' . $apiKey,
                [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ]
                ]
            );

            if ($response->successful()) {
                $aiAnswer = trim($response->json('candidates.0.content.parts.0.text') ?? '');

                // Jika Gemini mengosongkan jawaban (safety filter Google)
                if (empty($aiAnswer)) {
                    Log::warning('Gemini empty answer (Possible safety block) for text: ' . $text);
                    return true; // Asumsikan terlalu kotor
                }

                Log::info('Gemini Answer: ' . $aiAnswer . ' for text: ' . $text);

                $aiAnswerUpper = strtoupper($aiAnswer);
                if (strpos($aiAnswerUpper, 'YA') !== false) {
                    return true; // AI bilang spam
                }

                // Gemini bilang TIDAK spam, lanjut cek manual
            } else {
                Log::error('Gemini API Error Response: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Gemini API Exception: ' . $e->getMessage());
        }

        // ========== LAPISAN 2: Manual Bad Words ==========
        return $manualCheck($text);
    }
}
