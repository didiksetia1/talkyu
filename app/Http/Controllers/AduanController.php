<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Aduan;

class AduanController extends Controller
{
    public function index()
    {
        return view('aduan.index');
    }

    public function create()
    {
        return view('aduan.create');
    }

    public function history()
    {
        $aduans = Aduan::where('user_id', auth()->id())->latest()->get();
        return view('aduan.history', compact('aduans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:2048'
        ]);

        // AI Spam & Badword Filtering
        $inputText = $validated['judul'] . ' ' . $validated['deskripsi'];
        if ($this->isSpamWithAI($inputText)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'deskripsi' => 'Sistem AI mendeteksi aduan Anda terindikasi spam atau mengandung kata-kata yang tidak pantas.',
            ]);
        }

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('aduans', 'public');
            $validated['gambar'] = $path;
        }

        Aduan::create($validated);

        return redirect()->route('aduan.history')->with('success', 'Aduan berhasil dikirim!');
    }

    private function isSpamWithAI($text)
    {
        $manualCheck = function($t) {
            $badWords = ['gratis', 'spam', 'judi', 'judol', 'pinjol', 'slot', 'promo', 'jembut', 'kasar', 'porno', 'kontol', 'memek', 'bangsat', 'anjing', 'babi'];
            $textLower = strtolower($t);
            foreach ($badWords as $word) {
                if (strpos($textLower, $word) !== false) {
                    return true;
                }
            }
            return false;
        };

        $apiKey = env('GEMINI_API_KEY');
        if (empty($apiKey) || strpos($apiKey, 'contoh_api_key') !== false) {
            return $manualCheck($text);
        }

        try {
            $prompt = "Tugas Anda adalah mendeteksi apakah teks berikut adalah spam, promosi, atau mengandung kata-kata tidak pantas/kasar (seperti judi online, pinjol) dalam konteks aplikasi pengaduan kampus. Jawab HANYA dengan 'YA' jika teks tersebut adalah spam/tidak pantas, dan 'TIDAK' jika teks tersebut wajar atau bersih. Teks: " . $text;

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->timeout(10)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=' . $apiKey, [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ]);

            if ($response->successful()) {
                $aiAnswer = trim($response->json('candidates.0.content.parts.0.text') ?? '');

                if (empty($aiAnswer)) {
                    Log::warning('Gemini empty answer (Possible safety block) for text: ' . $text);
                    return true;
                }

                Log::info('Gemini Answer: ' . $aiAnswer . ' for text: ' . $text);

                $aiAnswerUpper = strtoupper($aiAnswer);
                if (strpos($aiAnswerUpper, 'YA') !== false) {
                    return true;
                }

                return $manualCheck($text);
            } else {
                Log::error('Gemini API Error Response: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Gemini API Exception: ' . $e->getMessage());
        }

        return $manualCheck($text);
    }
}
