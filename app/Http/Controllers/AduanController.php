<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Aduan;

class AduanController extends Controller
{
    public function index()
    {
        return view('aduan.index');
    }

    public function create()
    {
        return view('aduan.create');
    }

    public function history()
    {
        $aduans = Aduan::where('user_id', auth()->id())->latest()->get();
        return view('aduan.history', compact('aduans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|string',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('aduans', 'public');
            $validated['gambar'] = $path;
        }

        Aduan::create($validated);

        return redirect()->route('aduan.history')->with('success', 'Aduan berhasil dikirim!');
    }
}
