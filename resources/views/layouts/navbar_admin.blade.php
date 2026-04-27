<style>
    /* Admin Navbar Styles */
    .admin-nav {
        background: rgba(30, 41, 59, 0.95);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(15, 23, 42, 0.12);
        padding: 20px 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .admin-nav-brand {
        font-size: 24px;
        font-weight: 700;
        background: linear-gradient(to right, #f87171, #fca5a5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-decoration: none;
    }

    .admin-nav-links {
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .admin-nav-links a {
        color: #f1f5f9;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 8px;
    }

    .admin-nav-links a:hover {
        color: #fca5a5;
        background: rgba(248, 113, 113, 0.1);
    }

    .admin-btn-logout {
        background: rgba(248, 113, 113, 0.1);
        color: #fca5a5 !important;
        border: 1px solid rgba(248, 113, 113, 0.3);
        border-radius: 8px;
        padding: 8px 20px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .admin-btn-logout:hover {
        background: rgba(248, 113, 113, 0.2);
        box-shadow: 0 4px 15px rgba(248, 113, 113, 0.2);
        transform: translateY(-2px);
    }
</style>

<nav class="admin-nav">
    <a href="{{ route('admin.dashboard') }}" class="admin-nav-brand">Talkyu Admin</a>
    <div class="admin-nav-links">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.agenda.index') }}">Kelola Agenda</a>
        <a href="{{ route('admin.aduan.index') }}">Kelola Aduan</a>
        <a href="{{ route('admin.aspirasi.index') }}">Kelola Aspirasi</a>
        <form method="POST" action="{{ route('logout') }}" class="logout-form" style="margin:0;">
            @csrf
            <button type="submit" class="admin-btn-logout">Logout</button>
        </form>
    </div>
</nav>
