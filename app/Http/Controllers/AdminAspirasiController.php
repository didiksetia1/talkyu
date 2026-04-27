<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAspirasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspirasi::with(['user', 'event']);

        if ($request->filled('q')) {
            $keyword = $request->q;
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', '%' . $keyword . '%')
                    ->orWhere('saran', 'like', '%' . $keyword . '%');
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
        ]);

        return response()->json(['success' => true, 'message' => 'Response saved successfully']);
    }
}
