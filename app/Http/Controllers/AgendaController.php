<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\AgendaComment;
use App\Models\AgendaLike;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::withCount(['comments', 'likes'])->latest()->get();
        return view('agenda.index', compact('agendas'));
    }

    public function show($id)
    {
        $agenda = Agenda::with(['comments.user'])->withCount('likes')->findOrFail($id);
        $userLiked = $agenda->likes()->where('user_id', auth()->id())->exists();
        
        return view('agenda.show', compact('agenda', 'userLiked'));
    }

    public function comment(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);
        
        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        AgendaComment::create([
            'agenda_id' => $agenda->id,
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan.');
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
            $status = 'unliked';
        } else {
            AgendaLike::create([
                'agenda_id' => $agenda->id,
                'user_id' => $userId
            ]);
            $status = 'liked';
        }

        return redirect()->route('agenda.show', $agenda->id)->with('success_like', $status === 'liked' ? 'Anda menyukai agenda ini.' : 'Like dibatalkan.');
    }
}
