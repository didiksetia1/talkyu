<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use App\Models\AspirasiEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
