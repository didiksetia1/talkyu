<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
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
                'email' => $user->email,
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
            'email' => 'required|string|email|max:255|unique:users',
            'jurusan' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['nama'],
            'nim' => $validated['nim'],
            'email' => $validated['email'],
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
                'email' => $user->email,
                'jurusan' => $user->jurusan,
                'prodi' => $user->prodi,
                'role' => $user->role,
            ]
        ], 201);
    }

    /**
     * Kirim link reset password ke email.
     * Input: email
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Return sukses jaga-jaga biar tidak bocorkan info email mana yang terdaftar
            return response()->json([
                'message' => 'Jika email terdaftar, link reset password telah dikirim.',
            ], 200);
        }

        $token = Str::random(64);

        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

        // Kirim email
        $resetUrl = url("/reset-password?email=" . urlencode($user->email) . "&token=" . urlencode($token));

        try {
            \Illuminate\Support\Facades\Mail::send('emails.reset-password', [
                'user' => $user,
                'resetUrl' => $resetUrl,
            ], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Reset Password - Talkyu');
            });
        } catch (\Exception $e) {
            // Log error tapi tetap return sukses ke user
            \Illuminate\Support\Facades\Log::error('Gagal kirim email reset password: ' . $e->getMessage());
        }

        return response()->json([
            'message' => 'Jika email terdaftar, link reset password telah dikirim.',
        ], 200);
    }

    /**
     * Reset password dengan token.
     * Input: email, token, password, password_confirmation
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetRecord = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            throw ValidationException::withMessages([
                'email' => ['Token reset password tidak valid.'],
            ]);
        }

        // Cek token cocok
        if (!Hash::check($request->token, $resetRecord->token)) {
            throw ValidationException::withMessages([
                'token' => ['Token reset password tidak valid.'],
            ]);
        }

        // Cek expired (60 menit)
        if (now()->subMinutes(60)->greaterThan($resetRecord->created_at)) {
            throw ValidationException::withMessages([
                'token' => ['Token reset password sudah expired.'],
            ]);
        }

        // Update password
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Hapus token yang sudah dipakai
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return response()->json([
            'message' => 'Password berhasil direset.',
        ], 200);
    }
}
