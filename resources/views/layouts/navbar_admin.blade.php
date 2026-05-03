<style>
    /* Admin Navbar Styles */
    .admin-nav {
        background: #ffffff;
        border: 1px solid rgba(229, 231, 235, 0.9);
        border-radius: 0;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        padding: 15px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        z-index: 100;
        margin: 0;
    }

    .admin-nav-brand {
        font-size: 20px;
        font-weight: 700;
        color: #b91c1c;
        text-decoration: none;
    }

    .admin-nav-brand-group {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .admin-nav-divider {
        color: #d1d5db;
        font-weight: 300;
        font-size: 20px;
    }

    .admin-nav-page-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
    }

    .admin-nav-links {
        display: flex;
        gap: 24px;
        align-items: center;
    }

    .admin-nav-links a {
        color: #374151;
        text-decoration: none;
        font-size: 15px;
        font-weight: 500;
        transition: color 0.2s ease;
        padding: 8px 12px;
        border-radius: 9999px;
    }

    .admin-nav-links a:hover,
    .admin-nav-links a.active {
        color: #b91c1c;
    }

    .admin-btn-logout {
        background: transparent;
        color: #b91c1c !important;
        border: 1px solid #f87171;
        border-radius: 9999px;
        padding: 8px 18px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .admin-btn-logout:hover {
        background: rgba(248, 113, 113, 0.1);
        color: #991b1b !important;
    }
</style>

<nav class="admin-nav">
    <div class="admin-nav-brand-group">
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-brand">Talkyu Admin</a>
        @hasSection('page_title')
            <span class="admin-nav-divider">|</span>
            <span class="admin-nav-page-title">@yield('page_title')</span>
        @endif
    </div>
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