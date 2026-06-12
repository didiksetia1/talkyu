<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nim' => ['required', 'string', 'regex:/^(admin|bem|\d+)$/'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt(['nim' => $credentials['nim'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/aduan');
            }

            if (Auth::user()->role === 'bem') {
                return redirect()->intended('/admin');
            }

            return redirect()->intended('/home');
        }

        return back()->withErrors([
            'nim' => 'NIM atau Password salah.',
        ])->onlyInput('nim');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'regex:/^(admin|bem|\d+)$/', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'jurusan' => ['required', 'string', 'max:255'],
            'prodi' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'jurusan' => $request->jurusan,
            'prodi' => $request->prodi,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password', ['sent' => false]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return view('auth.forgot-password', ['sent' => true]);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($token), 'created_at' => now()]
        );

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
            \Illuminate\Support\Facades\Log::error('Gagal kirim email reset password: ' . $e->getMessage());
        }

        return view('auth.forgot-password', ['sent' => true]);
    }

    public function showResetPasswordForm(Request $request)
    {
        $email = $request->query('email', '');
        $token = $request->query('token', '');

        return view('auth.reset-password', [
            'email' => $email,
            'token' => $token,
            'resetSuccess' => false,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord) {
            return back()->with('error', 'Token reset password tidak valid.');
        }

        if (!Hash::check($request->token, $resetRecord->token)) {
            return back()->with('error', 'Token reset password tidak valid.');
        }

        if (now()->subMinutes(60)->greaterThan($resetRecord->created_at)) {
            return back()->with('error', 'Token reset password sudah expired.');
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return view('auth.reset-password', [
            'email' => $request->email,
            'token' => $request->token,
            'resetSuccess' => true,
        ]);
    }
}
