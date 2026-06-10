<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('nim', $validated['nim'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'nim' => ['NIM atau password salah.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'nim' => $user->nim,
                'jurusan' => $user->jurusan,
                'prodi' => $user->prodi,
                'role' => $user->role,
            ]
        ], 200);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:255|unique:users',
            'jurusan' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['nama'],
            'nim' => $validated['nim'],
            'jurusan' => $validated['jurusan'],
            'prodi' => $validated['prodi'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'nim' => $user->nim,
                'jurusan' => $user->jurusan,
                'prodi' => $user->prodi,
                'role' => $user->role,
            ]
        ], 201);
    }
}
