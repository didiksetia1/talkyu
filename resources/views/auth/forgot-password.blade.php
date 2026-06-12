<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Talkyu</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body {
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #fffdfd 0%, #ffecec 100%);
            overflow: hidden; color: #7a0f0f;
        }
        .ambient-circle { position: absolute; border-radius: 50%; filter: blur(80px); z-index: -1; }
        .circle-1 { width: 400px; height: 400px; background: rgba(220, 38, 38, 0.16); top: -100px; left: -100px; }
        .circle-2 { width: 300px; height: 300px; background: rgba(255, 255, 255, 0.7); bottom: -50px; right: -50px; }

        .card {
            position: relative; width: 440px; max-width: 95vw;
            background: rgba(255, 255, 255, 0.92);
            border-radius: 30px;
            box-shadow: 0 18px 45px rgba(185, 28, 28, 0.18);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(220, 38, 38, 0.12);
            padding: 40px 36px;
        }

        .card h2 {
            font-size: 28px; margin-bottom: 8px; text-align: center; font-weight: 700;
            background: linear-gradient(to right, #b91c1c, #ef4444);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .card .subtitle {
            text-align: center; font-size: 14px; color: rgba(127, 29, 29, 0.55);
            margin-bottom: 28px; line-height: 1.5;
        }

        .input-group { margin-bottom: 18px; }
        .input-group input {
            width: 100%; padding: 15px 20px;
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(220, 38, 38, 0.18);
            outline: none; border-radius: 12px; font-size: 15px; color: #7f1d1d;
            transition: all 0.3s ease;
        }
        .input-group input::placeholder { color: rgba(127, 29, 29, 0.45); }
        .input-group input:focus {
            background: #fff; border-color: #dc2626;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12);
        }
        .input-group .error-msg { color: #dc2626; font-size: 12px; margin-top: 4px; }

        .btn {
            width: 100%; padding: 15px;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: #fff; border: none; border-radius: 12px;
            font-size: 16px; font-weight: 600; cursor: pointer;
            transition: 0.3s; letter-spacing: 1px;
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.28);
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(220, 38, 38, 0.36); }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        .back-link {
            display: block; text-align: center; margin-top: 20px;
            color: rgba(127, 29, 29, 0.6); font-size: 14px; text-decoration: none;
        }
        .back-link:hover { color: #b91c1c; }

        .success-icon {
            text-align: center; font-size: 56px; margin-bottom: 16px;
        }
        .success-text {
            text-align: center; font-size: 14px; color: rgba(127, 29, 29, 0.6);
            line-height: 1.6; margin-bottom: 24px;
        }

        .alert {
            padding: 12px 16px; border-radius: 10px; font-size: 14px; margin-bottom: 20px;
        }
        .alert-danger { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .alert-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    </style>
</head>
<body>
    <div class="ambient-circle circle-1"></div>
    <div class="ambient-circle circle-2"></div>

    <div class="card">
        @if($sent ?? false)
            <!-- Success State -->
            <div class="success-icon">📧</div>
            <h2>Email Terkirim</h2>
            <p class="success-text">
                Jika email terdaftar, link reset password telah dikirim.<br>
                Silakan cek inbox atau folder spam Anda.
            </p>
            <a href="{{ url('/login') }}" class="btn" style="display:block;text-align:center;text-decoration:none;line-height:48px;">Kembali ke Login</a>
        @else
            <!-- Form State -->
            <h2>Lupa Password</h2>
            <p class="subtitle">Masukkan email Anda untuk menerima link reset password</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                </div>
                <button type="submit" class="btn">Kirim Link Reset</button>
            </form>

            <a href="{{ url('/login') }}" class="back-link">← Kembali ke Login</a>
        @endif
    </div>
</body>
</html>
