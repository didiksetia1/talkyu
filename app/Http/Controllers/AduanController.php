<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aduan;
use App\Traits\SpamFilterTrait;

class AduanController extends Controller
{
    use SpamFilterTrait;

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

        // AI Spam & Badword Filtering
        $inputText = $validated['judul'] . ' ' . $validated['deskripsi'];
        if ($this->isSpamWithAI($inputText)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'deskripsi' => 'Sistem AI mendeteksi aduan Anda terindikasi spam atau mengandung kata-kata yang tidak pantas.',
            ]);
        }

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('aduans', 'public');
            $validated['gambar'] = $path;
        }

        Aduan::create($validated);

        return redirect()->route('aduan.history')->with('success', 'Aduan berhasil dikirim!');
    }
}
