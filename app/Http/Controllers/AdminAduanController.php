<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aduan;

class AdminAduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Aduan::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $aduans = $query->paginate(10)->withQueryString();
        $categories = Aduan::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        $statusCounts = Aduan::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $stats = [
            'total' => Aduan::count(),
            'dikirim' => $statusCounts['dikirim'] ?? 0,
            'ditinjau' => $statusCounts['ditinjau'] ?? 0,
            'diproses' => $statusCounts['diproses'] ?? 0,
            'selesai' => $statusCounts['selesai'] ?? 0,
        ];

        return view('admin.aduan.index', compact('aduans', 'categories', 'stats'));
    }

    public function show($id)
    {
        $aduan = Aduan::with('user')->findOrFail($id);
        return view('admin.aduan.show', compact('aduan'));
    }

    public function update(Request $request, $id)
    {
        $aduan = Aduan::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:dikirim,ditinjau,diproses,selesai',
            'tanggapan' => 'nullable|string'
        ]);

        $statusFlow = ['dikirim', 'ditinjau', 'diproses', 'selesai'];
        $statusColumns = [
            1 => 'ditinjau_at',
            2 => 'diproses_at',
            3 => 'selesai_at',
        ];

        $currentStatusIndex = array_search($aduan->status, $statusFlow, true);
        $newStatusIndex = array_search($validated['status'], $statusFlow, true);

        if ($newStatusIndex !== false) {
            foreach ($statusColumns as $index => $column) {
                if ($index <= $newStatusIndex) {
                    if (empty($aduan->{$column})) {
                        $validated[$column] = now();
                    }
                    continue;
                }

                if ($currentStatusIndex !== false && $index <= $currentStatusIndex) {
                    $validated[$column] = null;
                }
            }
        }

        $aduan->update($validated);

        return redirect()->route('admin.aduan.show', $aduan->id)
                         ->with('success', 'Status dan Tanggapan berhasil diperbarui!');
    }

    public function exportCsv(Request $request)
    {
        $query = Aduan::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $aduans = $query->get();

        $filename = 'aduan_' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($aduans) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, ['No', 'Judul', 'Kategori', 'Deskripsi', 'Pengirim', 'Tanggal', 'Status', 'Tanggapan', 'Tgl Tanggapan']);

            foreach ($aduans as $index => $aduan) {
                fputcsv($file, [
                    $index + 1,
                    $aduan->judul ?? '-',
                    $aduan->kategori ?? '-',
                    $aduan->deskripsi ?? '-',
                    $aduan->user?->name ?? 'Anonim',
                    $aduan->created_at ? $aduan->created_at->format('d/m/Y') : '-',
                    ucfirst(str_replace('_', ' ', $aduan->status)),
                    $aduan->tanggapan ?? '-',
                    $aduan->updated_at ? $aduan->updated_at->format('d/m/Y') : '-',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
