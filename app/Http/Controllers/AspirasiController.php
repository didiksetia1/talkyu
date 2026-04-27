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

        if (!$event) {
            return redirect()->route('aspirasi.home')->with('error', 'Belum ada form aspirasi yang aktif saat ini.');
        }

        return redirect()->route('aspirasi.show', $event->id);
    }

    // List all active aspirasi events (for form submission)
    public function index()
    {
        return redirect()->route('aspirasi.home');
    }

    // Show form for specific event
    public function show($id)
    {
        $event = AspirasiEvent::where('is_active', true)->findOrFail($id);
        return view('aspirasi.show', compact('event'));
    }

    // Store new aspirasi submission
    public function store(Request $request, $id)
    {
        $event = AspirasiEvent::where('is_active', true)->findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:' . implode(',', array_keys(Aspirasi::CATEGORIES)),
            'deskripsi' => 'required|string',
            'tujuan_manfaat' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('lampiran')) {
            $path = $request->file('lampiran')->store('aspirasi_lampiran', 'public');
            $validated['lampiran'] = $path;
        }

        $validated['is_anonim'] = $request->has('anonim');
        $validated['aspirasi_event_id'] = $event->id;
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
}
