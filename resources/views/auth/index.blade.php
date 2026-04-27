<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register - Talkyu</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #fffdfd 0%, #ffecec 100%);
            overflow: hidden;
            color: #7a0f0f;
        }

        /* Ambient background circles */
        .ambient-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: -1;
        }
        .circle-1 {
            width: 400px;
            height: 400px;
            background: rgba(220, 38, 38, 0.16);
            top: -100px;
            left: -100px;
        }
        .circle-2 {
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.7);
            bottom: -50px;
            right: -50px;
        }

        .container {
            position: relative;
            width: 900px;
            height: 600px;
            background: rgba(255, 255, 255, 0.92);
            border-radius: 30px;
            box-shadow: 0 18px 45px rgba(185, 28, 28, 0.18);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(220, 38, 38, 0.12);
            overflow: hidden;
        }

        .form-box {
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 50px;
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .login-box {
            left: 0;
            opacity: 1;
            z-index: 2;
        }

        .register-box {
            left: 0;
            opacity: 0;
            z-index: 1;
            transform: translateX(100%);
        }

        .container.active .login-box {
            transform: translateX(-100%);
            opacity: 0;
            z-index: 1;
        }

        .container.active .register-box {
            transform: translateX(0);
            opacity: 1;
            z-index: 5;
            left: 50%;
        }

        .form-box h2 {
            font-size: 32px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: 700;
            background: linear-gradient(to right, #b91c1c, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group input, .input-group select {
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(220, 38, 38, 0.18);
            outline: none;
            border-radius: 12px;
            font-size: 15px;
            color: #7f1d1d;
            transition: all 0.3s ease;
        }

        .input-group input::placeholder {
            color: rgba(127, 29, 29, 0.5);
        }

        .input-group select option {
            background: #ffffff;
            color: #7f1d1d;
        }

        .input-group input:focus, .input-group select:focus {
            background: #ffffff;
            border-color: #dc2626;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12);
        }

        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
            letter-spacing: 1px;
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.28);
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn:hover::after {
            left: 100%;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.36);
        }

        .toggle-panel {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: #fff;
            text-align: center;
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 10;
        }

        .container.active .toggle-panel {
            transform: translateX(-100%);
            border-radius: 0 30% 30% 0 / 0 50% 50% 0;
        }

        .toggle-panel h2 {
            font-size: 36px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .toggle-panel p {
            font-size: 15px;
            margin-bottom: 30px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.8);
        }

        .toggle-btn {
            padding: 12px 35px;
            background: transparent;
            border: 2px solid #fff;
            color: #fff;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .toggle-btn:hover {
            background: #fff;
            color: #b91c1c;
            transform: scale(1.05);
        }

        /* Glassmorphism shape inside panel */
        .panel-shape {
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 50%;
            top: -50px;
            right: -50px;
            backdrop-filter: blur(5px);
        }

        .panel-shape-2 {
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 50%;
            bottom: 50px;
            left: 20px;
            backdrop-filter: blur(5px);
        }

        /* Toggle Content Wrappers */
        .toggle-content {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: 0.6s;
            width: 80%;
        }

        .login-content {
            opacity: 1;
            transform: translateX(0);
        }

        .register-content {
            opacity: 0;
            transform: translateX(200px);
            pointer-events: none;
        }

        .container.active .login-content {
            opacity: 0;
            transform: translateX(-200px);
            pointer-events: none;
        }

        .container.active .register-content {
            opacity: 1;
            transform: translateX(0);
            pointer-events: all;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                height: 700px;
                display: flex;
                flex-direction: column;
                overflow-y: auto;
            }
            .form-box {
                width: 100%;
                height: auto;
                position: relative;
                padding: 40px 20px;
            }
            .toggle-panel {
                width: 100%;
                height: auto;
                position: relative;
                padding: 40px 20px;
                transform: none !important;
                border-radius: 0 !important;
            }
            .container.active .register-box {
                left: 0;
                transform: none;
            }
            .login-box, .register-box {
                transform: none !important;
                opacity: 1 !important;
                position: relative;
                display: block;
            }
            .container.active .login-box {
                display: none;
            }
            .container .register-box {
                display: none;
            }
            .container.active .register-box {
                display: flex;
            }

            .toggle-content {
                position: relative;
                width: 100%;
                transform: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="ambient-circle circle-1"></div>
    <div class="ambient-circle circle-2"></div>

    <div class="container" id="container">
        <!-- Register Form -->
        <div class="form-box register-box">
            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                <h2>Buat Akun</h2>

                @if ($errors->any())
                    <div style="color: #ff6b6b; margin-bottom: 10px; font-size: 14px; text-align: center;">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="input-group">
                    <input type="text" name="nama" placeholder="Nama Lengkap" required value="{{ old('nama') }}">
                </div>
                <div class="input-group">
                    <input type="text" name="nim" placeholder="NIM" required value="{{ old('nim') }}">
                </div>
                <div class="input-group">
                    <select name="jurusan" id="fakultas-select" required>
                        <option value="" disabled selected>Pilih Fakultas</option>
                        <option value="Fakultas Teknik Telekomunikasi dan Elektro (FTTE)">Fakultas Teknik Telekomunikasi dan Elektro (FTTE)</option>
                        <option value="Fakultas Informatika (FIF)">Fakultas Informatika (FIF)</option>
                        <option value="Fakultas Rekayasa Industri dan Desain (FRID)">Fakultas Rekayasa Industri dan Desain (FRID)</option>
                    </select>
                </div>
                <div class="input-group">
                    <select name="prodi" id="prodi-select" required>
                        <option value="" disabled selected>Pilih Program Studi</option>
                    </select>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn">Daftar Sekarang</button>
            </form>
        </div>

        <!-- Login Form -->
        <div class="form-box login-box">
            <form method="POST" action="{{ route('login.post') }}">
                @csrf
                <h2>Selamat Datang</h2>

                @if ($errors->any())
                    <div style="color: #ff6b6b; margin-bottom: 10px; font-size: 14px; text-align: center;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="input-group">
                    <input type="text" name="nim" placeholder="NIM" required value="{{ old('nim') }}">
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn">Masuk</button>
            </form>
        </div>

        <!-- Toggle Panel -->
        <div class="toggle-panel">
            <div class="panel-shape"></div>
            <div class="panel-shape-2"></div>

            <div class="toggle-content login-content">
                <h2>Baru di Sini?</h2>
                <p>Jelajahi berbagai kemudahan dengan mendaftarkan akun Anda. Lengkapi data seperti Nama, NIM, Jurusan, dan Prodi.</p>
                <button class="toggle-btn" id="btn-register">Buat Akun</button>
            </div>

            <div class="toggle-content register-content">
                <h2>Sudah Punya Akun?</h2>
                <p>Silakan masuk kembali dengan menggunakan NIM dan Password Anda untuk melanjutkan.</p>
                <button class="toggle-btn" id="btn-login">Masuk Kembali</button>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('container');
        const btnRegister = document.getElementById('btn-register');
        const btnLogin = document.getElementById('btn-login');

        btnRegister.addEventListener('click', () => {
            container.classList.add('active');
        });

        btnLogin.addEventListener('click', () => {
            container.classList.remove('active');
        });

        // Cascading Dropdown Logic
        const prodiData = {
            "Fakultas Teknik Telekomunikasi dan Elektro (FTTE)": [
                "D3 Teknik Telekomunikasi",
                "S1 Teknik Telekomunikasi",
                "S1 Teknik Elektro",
                "S1 Teknik Biomedis"
            ],
            "Fakultas Informatika (FIF)": [
                "S1 Teknik Informatika",
                "S1 Software Engineering (Rekayasa Perangkat Lunak)",
                "S1 Sistem Informasi",
                "S1 Sains Data"
            ],
            "Fakultas Rekayasa Industri dan Desain (FRID)": [
                "S1 Teknik Industri",
                "S1 Teknik Logistik",
                "S1 Desain Komunikasi Visual (DKV)"
            ]
        };

        const fakultasSelect = document.getElementById('fakultas-select');
        const prodiSelect = document.getElementById('prodi-select');

        if(fakultasSelect && prodiSelect) {
            fakultasSelect.addEventListener('change', function() {
                const selectedFakultas = this.value;

                // Clear existing options
                prodiSelect.innerHTML = '<option value="" disabled selected>Pilih Program Studi</option>';

                // Populate new options if valid
                if (prodiData[selectedFakultas]) {
                    prodiData[selectedFakultas].forEach(function(prodi) {
                        const option = document.createElement('option');
                        option.value = prodi;
                        option.textContent = prodi;
                        prodiSelect.appendChild(option);
                    });
                }
            });
        }
    </script>
</body>
</html>
