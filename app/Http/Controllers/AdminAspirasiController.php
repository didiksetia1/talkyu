<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Exports\AspirasiExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AdminAspirasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspirasi::with(['user', 'event']);

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('judul', 'like', '%' . $keyword . '%')
                    ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $aspirasis = $query->latest()->paginate(15)->withQueryString();

        // Get stats
        $stats = [
            'total' => Aspirasi::count(),
            'submitted' => Aspirasi::where('status', 'submitted')->count(),
            'being_considered' => Aspirasi::where('status', 'being_considered')->count(),
            'realized' => Aspirasi::where('status', 'realized')->count(),
        ];

        return view('admin.aspirasi.index', compact('aspirasis', 'stats'));
    }

    public function respond(Request $request, $id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:submitted,being_considered,realized',
            'bem_response' => 'required|string|max:2000',
        ]);

        $aspirasi->update([
            'status' => $validated['status'],
            'bem_response' => $validated['bem_response'],
            'responded_by' => auth()->id(),
        ]);

        return response()->json(['success' => true, 'message' => 'Response saved successfully']);
    }

    /**
     * Hapus aspirasi beserta file lampiran dan data terkait.
     */
    public function destroy()
    {
         = Aspirasi::findOrFail();

        // Hapus file lampiran jika ada
        if (->lampiran && Storage::disk("public")->exists(->lampiran)) {
            Storage::disk("public")->delete(->lampiran);
        }

        // Hapus votes terkait
        DB::table("aspirasi_votes")->where("aspirasi_id", )->delete();

        // Hapus comments terkait
        DB::table("aspirasi_comments")->where("aspirasi_id", )->delete();

        // Hapus aspirasi
        ->delete();

        return redirect()->route("admin.aspirasi.index")->with("success", "Aspirasi berhasil dihapus.");
    }

    public function exportExcel(Request $request)
    {
        $filename = 'aspirasi_' . now()->format('Y-m-d') . '.xlsx';

        return Excel::download(
            new AspirasiExport(
                $request->status,
                $request->kategori,
                $request->q
            ),
            $filename
        );
    }

    // === Comment Management ===

    public function comments($id)
    {
        $aspirasi = Aspirasi::withCount('comments')->findOrFail($id);
        $comments = DB::table('aspirasi_comments')
            ->leftJoin('users', 'aspirasi_comments.user_id', '=', 'users.id')
            ->select('aspirasi_comments.*', 'users.name as user_name')
            ->where('aspirasi_comments.aspirasi_id', $id)
            ->latest('aspirasi_comments.created_at')
            ->paginate(20);

        return view('admin.aspirasi.comments', compact('aspirasi', 'comments'));
    }

    public function destroyComment($id, $commentId)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        $comment = DB::table('aspirasi_comments')
            ->where('aspirasi_id', $aspirasi->id)
            ->where('id', $commentId)
            ->first();

        if ($comment) {
            DB::table('aspirasi_comments')->where('id', $commentId)->delete();
            $aspirasi->decrement('comments_count');
        }

        return redirect()->route('admin.aspirasi.comments', $id)
            ->with('success', 'Komentar berhasil dihapus.');
    }
}
