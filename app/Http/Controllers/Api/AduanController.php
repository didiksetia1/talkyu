<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Aduan;
use Illuminate\Http\Request;

class AduanController extends Controller
{
    public function index()
    {
        $aduans = Aduan::with('user')->where('user_id', auth()->id())->latest()->get();

        return response()->json(['data' => $aduans], 200);
    }

    public function history()
    {
        return $this->index();
    }

    public function show($id)
    {
        $aduan = Aduan::with('user')->where('user_id', auth()->id())->findOrFail($id);

        return response()->json(['data' => $aduan], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('aduans', 'public');
        }

        $aduan = Aduan::create($validated);

        return response()->json([
            'message' => 'Aduan berhasil dikirim.',
            'data' => $aduan,
        ], 201);
    }
}
