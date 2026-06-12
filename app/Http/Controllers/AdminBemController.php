<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminBemController extends Controller
{
    public function index()
    {
        $bems = User::where('role', 'bem')->latest()->paginate(15);
        return view('admin.bem.index', compact('bems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'nim'      => 'required|string|max:20|unique:users,nim',
            'email'    => 'required|email|max:255|unique:users,email',
            'jurusan'  => 'nullable|string|max:255',
            'prodi'    => 'nullable|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $validated['role'] = 'bem';
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.bem.index')
                         ->with('success', 'Akun BEM berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $bem = User::where('role', 'bem')->findOrFail($id);
        return view('admin.bem.edit', compact('bem'));
    }

    public function update(Request $request, $id)
    {
        $bem = User::where('role', 'bem')->findOrFail($id);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'nim'      => 'required|string|max:20|unique:users,nim,' . $id,
            'email'    => 'required|email|max:255|unique:users,email,' . $id,
            'jurusan'  => 'nullable|string|max:255',
            'prodi'    => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $bem->update($validated);

        return redirect()->route('admin.bem.index')
                         ->with('success', 'Akun BEM berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $bem = User::where('role', 'bem')->findOrFail($id);

        // Cegah hapus diri sendiri
        if ($bem->id === auth()->id()) {
            return redirect()->route('admin.bem.index')
                             ->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $bem->delete();

        return redirect()->route('admin.bem.index')
                         ->with('success', 'Akun BEM berhasil dihapus!');
    }
}
