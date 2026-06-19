<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\AgendaComment;
use App\Models\AgendaLike;
use App\Traits\SpamFilterTrait;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    use SpamFilterTrait;

    public function index()
    {
        $agendas = Agenda::withCount(['comments', 'likes'])->latest()->get();

        return response()->json(['data' => $agendas], 200);
    }

    public function show($id)
    {
        $agenda = Agenda::with(['comments.user'])->withCount('likes')->findOrFail($id);
        $userLiked = $agenda->likes()->where('user_id', auth()->id())->exists();

        return response()->json([
            'data' => $agenda,
            'user_liked' => $userLiked,
        ], 200);
    }

    public function comment(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // AI Spam Filtering untuk komentar agenda (API)
        if ($this->isSpamWithAI($validated['content'])) {
            return response()->json([
                'message' => 'Sistem AI mendeteksi komentar Anda terindikasi spam atau mengandung kata-kata yang tidak pantas.',
            ], 422);
        }

        $comment = AgendaComment::create([
            'agenda_id' => $agenda->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        return response()->json([
            'message' => 'Komentar berhasil ditambahkan.',
            'data' => $comment,
        ], 201);
    }

    public function toggleLike($id)
    {
        $agenda = Agenda::findOrFail($id);
        $userId = auth()->id();

        $like = AgendaLike::where('agenda_id', $agenda->id)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Like dibatalkan.', 'liked' => false], 200);
        }

        $newLike = AgendaLike::create([
            'agenda_id' => $agenda->id,
            'user_id' => $userId,
        ]);

        return response()->json(['message' => 'Agenda disukai.', 'liked' => true, 'data' => $newLike], 201);
    }


    public function comments($id)
    {
        $agenda = Agenda::findOrFail($id);

        $comments = AgendaComment::with('user')
            ->where('agenda_id', $agenda->id)
            ->latest()
            ->get();

        return response()->json([
            'data' => $comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'comment' => $comment->content,
                    'created_at' => $comment->created_at,
                    'user' => [
                        'name' => $comment->user?->name,
                    ],
                ];
            }),
        ], 200);
    }
}
