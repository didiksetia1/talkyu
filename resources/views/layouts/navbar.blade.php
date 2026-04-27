<style>
    /* Navbar Styles */
    nav {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(220, 38, 38, 0.12);
        padding: 20px 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .nav-brand {
        font-size: 24px;
        font-weight: 700;
        background: linear-gradient(to right, #b91c1c, #ef4444);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-decoration: none;
    }

    .nav-links {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .nav-links a {
        color: #7f1d1d;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 8px;
    }

    .nav-links a:hover {
        color: #b91c1c;
        background: rgba(220, 38, 38, 0.08);
    }

    .btn-logout {
        background: rgba(220, 38, 38, 0.08);
        color: #b91c1c !important;
        border: 1px solid rgba(220, 38, 38, 0.22);
        border-radius: 8px;
        padding: 8px 20px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-logout:hover {
        background: rgba(220, 38, 38, 0.14);
        box-shadow: 0 4px 15px rgba(220, 38, 38, 0.18);
        transform: translateY(-2px);
    }

    .logout-form {
        margin: 0;
    }
</style>

<nav>
    <a href="{{ route('home') }}" class="nav-brand">Talkyu</a>
    <div class="nav-links">
        <a href="{{ route('aduan.index') }}">Aduan</a>
        <a href="{{ route('aspirasi.home') }}">💡 Aspirasi</a>
        <a href="{{ route('agenda.index') }}">Agenda</a>
        <form method="POST" action="{{ route('logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</nav>
