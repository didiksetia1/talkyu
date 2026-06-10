<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\AspirasiEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AspirasiController extends Controller
{
    public function events()
    {
        $events = AspirasiEvent::where('is_active', true)->latest()->get();

        return response()->json(['data' => $events], 200);
    }

    public function index(Request $request)
    {
        $query = Aspirasi::with(['user', 'event'])->latest();

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('deskripsi', 'like', "%{$keyword}%")
                    ->orWhere('tujuan_manfaat', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $aspirasis = $query->paginate(10)->withQueryString();

        return response()->json($aspirasis, 200);
    }

    public function show($id)
    {
        $aspirasi = Aspirasi::with(['user', 'event'])->findOrFail($id);
        $comments = DB::table('aspirasi_comments')
            ->join('users', 'aspirasi_comments.user_id', '=', 'users.id')
            ->select('aspirasi_comments.*', 'users.name as user_name')
            ->where('aspirasi_comments.aspirasi_id', $id)
            ->latest('aspirasi_comments.created_at')
            ->get();

        return response()->json([
            'data' => $aspirasi,
            'comments' => $comments,
        ], 200);
    }

    public function store(Request $request, $id)
    {
        $event = AspirasiEvent::where('is_active', true)->findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:' . implode(',', array_keys(Aspirasi::CATEGORIES)),
            'deskripsi' => 'required|string',
            'tujuan_manfaat' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'anonim' => 'nullable|boolean',
        ]);

        // AI Spam Filtering
        $inputText = $validated['judul'] . ' ' . $validated['deskripsi'] . ' ' . ($validated['tujuan_manfaat'] ?? '');
        if ($this->isSpamWithAI($inputText)) {
            return response()->json([
                'message' => 'Sistem AI mendeteksi aspirasi Anda terindikasi spam atau mengandung kata-kata yang tidak pantas.',
            ], 422);
        }

        if ($request->hasFile('lampiran')) {
            $validated['lampiran'] = $request->file('lampiran')->store('aspirasi_lampiran', 'public');
        }

        $validated['is_anonim'] = $request->boolean('anonim');
        $validated['aspirasi_event_id'] = $event->id;
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'submitted';
        $validated['votes_count'] = 0;
        $validated['comments_count'] = 0;

        $aspirasi = Aspirasi::create($validated);

        return response()->json([
            'message' => 'Aspirasi berhasil dikirim.',
            'data' => $aspirasi,
        ], 201);
    }

    public function vote($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        $userId = auth()->id();

        $existingVote = DB::table('aspirasi_votes')
            ->where('aspirasi_id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($existingVote) {
            DB::table('aspirasi_votes')
                ->where('aspirasi_id', $id)
                ->where('user_id', $userId)
                ->delete();

            $aspirasi->decrement('votes_count');

            return response()->json(['message' => 'Vote dihapus.', 'voted' => false], 200);
        }

        DB::table('aspirasi_votes')->insert([
            'aspirasi_id' => $id,
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $aspirasi->increment('votes_count');

        return response()->json(['message' => 'Vote ditambahkan.', 'voted' => true], 201);
    }

    public function comment(Request $request, $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // AI Spam Filtering
        if ($this->isSpamWithAI($validated['comment'])) {
            return response()->json([
                'message' => 'Sistem AI mendeteksi komentar Anda terindikasi spam atau tidak pantas.',
            ], 422);
        }

        DB::table('aspirasi_comments')->insert([
            'aspirasi_id' => $id,
            'user_id' => auth()->id(),
            'text' => $validated['comment'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $aspirasi->increment('comments_count');

        return response()->json(['message' => 'Komentar berhasil ditambahkan.'], 201);
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
            $prompt = "Tugas Anda adalah mendeteksi apakah teks berikut adalah spam, promosi, atau mengandung kata-kata tidak pantas/kasar (seperti judi online, pinjol) dalam konteks aplikasi penyampaian aspirasi kampus. Jawab HANYA dengan 'YA' jika teks tersebut adalah spam/tidak pantas, dan 'TIDAK' jika teks tersebut wajar atau bersih. Teks: " . $text;

            $response = Http::withHeaders([
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
