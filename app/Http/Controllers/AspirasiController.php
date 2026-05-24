<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AspirasiEvent;
use App\Models\Aspirasi;
use Illuminate\Support\Facades\DB;

class AspirasiController extends Controller
{
    // Open aspirasi form directly (uses first active event)
    public function create()
    {
        $event = AspirasiEvent::where('is_active', true)->latest()->first();
        return view('aspirasi.show', compact('event'));
    }

    // List all active aspirasi events (for form submission)
    public function index()
    {
        return redirect()->route('aspirasi.home');
    }

    // Show form for specific event
    public function show($id)
    {
        $event = AspirasiEvent::findOrFail($id);
        return view('aspirasi.show', compact('event'));
    }

    // Store new aspirasi submission
    public function store(Request $request, $id = null)
    {
        $event = null;

        if ($id) {
            $event = AspirasiEvent::findOrFail($id);
        } else {
            $event = AspirasiEvent::where('is_active', true)->latest()->first();
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:' . implode(',', array_keys(Aspirasi::CATEGORIES)),
            'deskripsi' => 'required|string',
            'tujuan_manfaat' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        // AI Spam Filtering (Gemini Fallback ke Manual)
        $inputText = $validated['judul'] . ' ' . $validated['deskripsi'] . ' ' . ($validated['tujuan_manfaat'] ?? '');
        if ($this->isSpamWithAI($inputText)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'deskripsi' => 'Sistem AI mendeteksi aspirasi Anda terindikasi spam atau mengandung kata-kata yang tidak pantas.',
            ]);
        }


        if ($request->hasFile('lampiran')) {
            $path = $request->file('lampiran')->store('aspirasi_lampiran', 'public');
            $validated['lampiran'] = $path;
        }

        $validated['is_anonim'] = $request->has('anonim');
        $validated['aspirasi_event_id'] = $event?->id;
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'submitted';

        Aspirasi::create($validated);

        return redirect()->route('aspirasi.home')->with('success', 'Terima kasih! Aspirasi Anda berhasil dikirim.');
    }

    // List all aspirasi submissions (public view with voting)
    public function list(Request $request)
    {
        $query = Aspirasi::with(['user', 'event'])->latest();

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', '%' . $keyword . '%')
                    ->orWhere('deskripsi', 'like', '%' . $keyword . '%')
                    ->orWhere('tujuan_manfaat', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sortBy = $request->get('sort', 'newest');
        if ($sortBy === 'votes') {
            $query->orderByDesc('votes_count');
        } elseif ($sortBy === 'comments') {
            $query->orderByDesc('comments_count');
        }

        $aspirasis = $query->paginate(10)->withQueryString();

        return view('aspirasi.list', compact('aspirasis'));
    }

    // View detail aspirasi with comments
    public function detail($id)
    {
        $aspirasi = Aspirasi::with(['user', 'event'])->findOrFail($id);
        $comments = DB::table('aspirasi_comments')
            ->join('users', 'aspirasi_comments.user_id', '=', 'users.id')
            ->select('aspirasi_comments.*', 'users.name as user_name')
            ->where('aspirasi_comments.aspirasi_id', $id)
            ->latest('aspirasi_comments.created_at')
            ->get();

        return view('aspirasi.detail', compact('aspirasi', 'comments'));
    }

    // Vote on aspirasi
    public function vote(Request $request, $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        $userId = auth()->id();

        // Check if user already voted
        $existingVote = DB::table('aspirasi_votes')
            ->where('aspirasi_id', $id)
            ->where('user_id', $userId)
            ->first();

        if ($existingVote) {
            // Remove vote
            DB::table('aspirasi_votes')
                ->where('aspirasi_id', $id)
                ->where('user_id', $userId)
                ->delete();
            $aspirasi->decrement('votes_count');
            return response()->json(['success' => true, 'message' => 'Vote removed']);
        } else {
            // Add vote
            DB::table('aspirasi_votes')->insert([
                'aspirasi_id' => $id,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $aspirasi->increment('votes_count');
            return response()->json(['success' => true, 'message' => 'Vote added']);
        }
    }

    // Comment on aspirasi
    public function comment(Request $request, $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        $validated = $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // AI Spam Filtering (Gemini Fallback ke Manual)
        if ($this->isSpamWithAI($validated['comment'])) {
            return response()->json(['success' => false, 'message' => 'Sistem AI mendeteksi komentar Anda terindikasi spam atau tidak pantas.']);
        }


        DB::table('aspirasi_comments')->insert([
            'aspirasi_id' => $id,
            'user_id' => auth()->id(),
            'text' => $validated['comment'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $aspirasi->increment('comments_count');

        return response()->json(['success' => true, 'message' => 'Comment added']);
    }

    private function isSpamWithAI($text)
    {
        // Fungsi manual fallback
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

            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Content-Type' => 'application/json'
            ])->timeout(10)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=' . $apiKey, [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ]);

            if ($response->successful()) {
                $aiAnswer = trim($response->json('candidates.0.content.parts.0.text') ?? '');
                
                // Jika Gemini mengosongkan jawaban (biasanya karena terkena filter Safety Google akibat kata sangat kotor)
                if (empty($aiAnswer)) {
                    \Illuminate\Support\Facades\Log::warning('Gemini empty answer (Possible safety block) for text: ' . $text);
                    return true; // Asumsikan kata terlalu kasar sehingga diblokir Google
                }

                \Illuminate\Support\Facades\Log::info('Gemini Answer: ' . $aiAnswer . ' for text: ' . $text);
                
                $aiAnswerUpper = strtoupper($aiAnswer);
                if (strpos($aiAnswerUpper, 'YA') !== false) {
                    return true;
                }
                
                // Lapis kedua: Jika AI meloloskan, cek ulang dengan filter manual
                return $manualCheck($text);
            } else {
                \Illuminate\Support\Facades\Log::error('Gemini API Error Response: ' . $response->body());
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gemini API Exception: ' . $e->getMessage());
        }

        // Jika API gagal/error, gunakan manual check sebagai fallback
        return $manualCheck($text);
    }
}
