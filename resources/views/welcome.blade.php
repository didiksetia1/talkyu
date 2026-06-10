<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Talkyu - Suarakan Aspirasimu</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #fffdfd 0%, #ffecec 100%);
            color: #7a0f0f;
            overflow-x: hidden;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            position: relative;
            z-index: 10;
        }

        .navbar .logo {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(to right, #b91c1c, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .navbar .nav-links {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .navbar .nav-links a {
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .navbar .nav-links .btn-login {
            color: #b91c1c;
            border: 2px solid #b91c1c;
            background: transparent;
        }

        .navbar .nav-links .btn-login:hover {
            background: #b91c1c;
            color: #fff;
        }

        .navbar .nav-links .btn-register {
            color: #fff;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            border: 2px solid transparent;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        .navbar .nav-links .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
        }

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 60px 50px;
            min-height: calc(100vh - 80px);
            position: relative;
        }

        /* Ambient circles */
        .ambient-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
        }
        .circle-1 {
            width: 500px;
            height: 500px;
            background: rgba(220, 38, 38, 0.10);
            top: -150px;
            left: -150px;
        }
        .circle-2 {
            width: 350px;
            height: 350px;
            background: rgba(255, 255, 255, 0.6);
            bottom: -80px;
            right: -80px;
        }
        .circle-3 {
            width: 250px;
            height: 250px;
            background: rgba(220, 38, 38, 0.06);
            top: 40%;
            right: 20%;
        }

        .hero-content {
            flex: 1;
            max-width: 550px;
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 48px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px;
            background: linear-gradient(to right, #7f1d1d, #b91c1c, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-content p {
            font-size: 17px;
            line-height: 1.7;
            color: #991b1b;
            margin-bottom: 32px;
            opacity: 0.85;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
        }

        .hero-buttons a {
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            padding: 14px 32px;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .hero-buttons .btn-primary {
            color: #fff;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.3);
        }

        .hero-buttons .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 38, 38, 0.4);
        }

        .hero-buttons .btn-secondary {
            color: #b91c1c;
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid rgba(220, 38, 38, 0.2);
            backdrop-filter: blur(10px);
        }

        .hero-buttons .btn-secondary:hover {
            border-color: #dc2626;
            background: #fff;
        }

        /* Hero Card / Illustration */
        .hero-card {
            flex: 1;
            max-width: 480px;
            position: relative;
            z-index: 1;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(220, 38, 38, 0.12);
            box-shadow: 0 20px 50px rgba(185, 28, 28, 0.15);
            padding: 40px;
            text-align: center;
        }

        .glass-card .icon-wrapper {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 10px 25px rgba(220, 38, 38, 0.3);
        }

        .glass-card .icon-wrapper svg {
            width: 40px;
            height: 40px;
            fill: #fff;
        }

        .glass-card h3 {
            font-size: 22px;
            font-weight: 700;
            color: #7f1d1d;
            margin-bottom: 12px;
        }

        .glass-card p {
            font-size: 14px;
            color: #991b1b;
            line-height: 1.6;
            opacity: 0.75;
            margin-bottom: 28px;
        }

        .glass-card .stats {
            display: flex;
            justify-content: space-around;
            padding-top: 20px;
            border-top: 1px solid rgba(220, 38, 38, 0.1);
        }

        .glass-card .stat-item {
            text-align: center;
        }

        .glass-card .stat-item .number {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(to right, #b91c1c, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .glass-card .stat-item .label {
            font-size: 12px;
            color: #991b1b;
            opacity: 0.6;
            margin-top: 4px;
        }

        /* Features Section */
        .features {
            padding: 80px 50px;
            position: relative;
            z-index: 1;
        }

        .features h2 {
            text-align: center;
            font-size: 32px;
            font-weight: 700;
            color: #7f1d1d;
            margin-bottom: 50px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(220, 38, 38, 0.1);
            padding: 32px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(185, 28, 28, 0.08);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(185, 28, 28, 0.15);
        }

        .feature-card .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.1) 0%, rgba(239, 68, 68, 0.1) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .feature-card .feature-icon svg {
            width: 28px;
            height: 28px;
            stroke: #dc2626;
        }

        .feature-card h4 {
            font-size: 17px;
            font-weight: 700;
            color: #7f1d1d;
            margin-bottom: 10px;
        }

        .feature-card p {
            font-size: 13px;
            color: #991b1b;
            line-height: 1.6;
            opacity: 0.7;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 30px 50px;
            position: relative;
            z-index: 1;
        }

        .footer p {
            font-size: 13px;
            color: #991b1b;
            opacity: 0.5;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .navbar {
                padding: 16px 24px;
            }
            .hero {
                flex-direction: column;
                padding: 40px 24px;
                text-align: center;
            }
            .hero-content h1 {
                font-size: 32px;
            }
            .hero-buttons {
                justify-content: center;
                flex-wrap: wrap;
            }
            .hero-card {
                max-width: 100%;
                margin-top: 40px;
            }
            .features {
                padding: 50px 24px;
            }
            .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Background Circles -->
    <div class="ambient-circle circle-1"></div>
    <div class="ambient-circle circle-2"></div>
    <div class="ambient-circle circle-3"></div>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="logo">Talkyu</a>
        <div class="nav-links">
            <a href="{{ route('login') }}" class="btn-login">Masuk</a>
            <a href="{{ route('login') }}" class="btn-register">Daftar</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Suarakan Aspirasimu untuk Kampus yang Lebih Baik</h1>
            <p>Talkyu adalah platform aspirasi mahasiswa yang memungkinkan kamu menyampaikan pendapat, mengajukan aduan, dan berpartisipasi dalam agenda kampus secara transparan dan mudah.</p>
            <div class="hero-buttons">
                <a href="{{ route('login') }}" class="btn-primary">Mulai Sekarang</a>
                <a href="#features" class="btn-secondary">Pelajari Lebih</a>
            </div>
        </div>

        <div class="hero-card">
            <div class="glass-card">
                <div class="icon-wrapper">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Aspirasi & Aduan</h3>
                <p>Sampaikan aspirasi dan aduan kamu kepada pihak kampus dengan mudah, aman, dan transparan.</p>
                <div class="stats">
                    <div class="stat-item">
                        <div class="number">100+</div>
                        <div class="label">Aspirasi</div>
                    </div>
                    <div class="stat-item">
                        <div class="number">50+</div>
                        <div class="label">Aduan</div>
                    </div>
                    <div class="stat-item">
                        <div class="number">25+</div>
                        <div class="label">Agenda</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <h2>Fitur Unggulan Talkyu</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                </div>
                <h4>Kirim Aspirasi</h4>
                <p>Sampaikan aspirasi kamu untuk perbaikan kampus. Bisa anonim atau terbuka.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </div>
                <h4>Ajukan Aduan</h4>
                <p>Laporkan masalah atau keluhan kamu kepada pihak berwenang kampus.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <h4>Agenda Kampus</h4>
                <p>Ikuti dan berpartisipasi dalam berbagai agenda dan event kampus.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2026 Talkyu. Platform Aspirasi Mahasiswa.</p>
    </footer>

</body>
</html>
