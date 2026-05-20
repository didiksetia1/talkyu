@extends('layouts.app')

@section('title', 'Admin Dashboard')


{{-- ======================== STYLES ======================== --}}
@section('styles')
<style>

    /* ---- Layout ---- */

    .admin-dashboard {
        width: 100%;
        padding: 30px 24px 24px;
    }


    /* ---- Header ---- */

    .dashboard-header {
        margin-bottom: 24px;
    }

    .dashboard-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: #7f1d1d;
        margin: 0;
    }


    /* ---- Stat Cards ---- */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border: 1px solid #f3f4f6;
        border-radius: 12px;
        padding: 20px;
        transition: transform 0.15s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-card-icon {
        font-size: 22px;
        margin-bottom: 14px;
    }

    .stat-card-label {
        font-size: 10px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        margin-bottom: 6px;
    }

    .stat-card-value {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .stat-card.agenda-card   { border-top: 3px solid #3b82f6; }
    .stat-card.aduan-card    { border-top: 3px solid #ef4444; }
    .stat-card.user-card     { border-top: 3px solid #10b981; }
    .stat-card.aspirasi-card { border-top: 3px solid #f59e0b; }
    .stat-card.event-card    { border-top: 3px solid #8b5cf6; }


    /* ---- Content Grid ---- */

    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 20px;
    }


    /* ---- Card ---- */

    .card {
        background: white;
        border: 1px solid #f3f4f6;
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        border-bottom: 1px solid #f3f4f6;
    }

    .card-header h2 {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .card-header a {
        font-size: 12px;
        color: #3b82f6;
        text-decoration: none;
    }

    .card-header a:hover {
        text-decoration: underline;
    }


    /* ---- List Items ---- */

    .list-item {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 18px;
        border-bottom: 1px solid #f9fafb;
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .item-title {
        font-size: 13px;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 4px 0;
        line-height: 1.4;
    }

    .item-meta {
        font-size: 11px;
        color: #9ca3af;
        margin: 0;
    }

    .empty-state {
        padding: 32px 18px;
        text-align: center;
        font-size: 13px;
        color: #d1d5db;
    }


    /* ---- Badge ---- */

    .item-badge {
        flex-shrink: 0;
        display: inline-block;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 99px;
        white-space: nowrap;
    }

    .badge-dikirim  { background: #f3f4f6; color: #374151; }
    .badge-ditinjau { background: #eff6ff; color: #1d4ed8; }
    .badge-diproses { background: #fef3c7; color: #92400e; }
    .badge-selesai  { background: #f0fdf4; color: #166534; }
    .badge-aspirasi { background: #f3e8ff; color: #6b21a8; }
    .badge-pending  { background: #fef3c7; color: #92400e; }


    /* ---- Distribusi Status ---- */

    .dist-row {
        display: flex;
        gap: 10px;
        padding: 16px 18px;
    }

    .dist-item {
        flex: 1;
        background: #f9fafb;
        border-radius: 8px;
        padding: 14px 8px;
        text-align: center;
    }

    .dist-num {
        font-size: 22px;
        font-weight: 700;
        color: #1f2937;
    }

    .dist-label {
        font-size: 10px;
        color: #9ca3af;
        margin-top: 4px;
        text-transform: capitalize;
    }


    /* ---- Aksi Cepat ---- */

    .action-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        padding: 16px 18px;
    }

    .btn-action {
        display: inline-block;
        font-size: 12px;
        font-weight: 500;
        padding: 8px 14px;
        border-radius: 8px;
        text-decoration: none;
        border: 1px solid #e5e7eb;
        color: #374151;
        background: white;
        transition: background 0.15s, color 0.15s;
    }

    .btn-action:hover {
        background: #f9fafb;
        color: #111827;
    }

    .btn-action.primary {
        background: #991b1b;
        color: white;
        border-color: #991b1b;
    }

    .btn-action.primary:hover {
        background: #7f1d1d;
    }


    /* ---- Responsive ---- */

    @media (max-width: 900px) {
        .bottom-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .content-grid {
            grid-template-columns: 1fr;
        }
    }

</style>
@endsection


{{-- ======================== CONTENT ======================== --}}
@section('content')
<div class="admin-dashboard">

    {{-- Header --}}
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
    </div>


    {{-- ---- Stat Cards ---- --}}
    <div class="stats-grid">

        <div class="stat-card agenda-card">
            <div class="stat-card-icon">📅</div>
            <div class="stat-card-label">Total Agenda</div>
            <div class="stat-card-value">{{ $totalAgenda }}</div>
        </div>

        <div class="stat-card aduan-card">
            <div class="stat-card-icon">📋</div>
            <div class="stat-card-label">Total Aduan</div>
            <div class="stat-card-value">{{ $totalAduan }}</div>
        </div>

        <div class="stat-card user-card">
            <div class="stat-card-icon">👥</div>
            <div class="stat-card-label">Total Pengguna</div>
            <div class="stat-card-value">{{ $totalUsers }}</div>
        </div>

        <div class="stat-card aspirasi-card">
            <div class="stat-card-icon">💡</div>
            <div class="stat-card-label">Total Aspirasi</div>
            <div class="stat-card-value">{{ $totalAspirasi }}</div>
        </div>

        {{-- <div class="stat-card event-card">
            <div class="stat-card-icon">🎯</div>
            <div class="stat-card-label">Event Aktif</div>
            <div class="stat-card-value">{{ $activeEvents }}</div>
        </div> --}}

    </div>


    {{-- ---- Content Grid ---- --}}
    <div class="content-grid">

        {{-- Agenda Terbaru --}}
        <div class="card">
            <div class="card-header">
                <h2>📅 Agenda Terbaru</h2>
                <a href="{{ route('admin.agenda.index') }}">Lihat Semua →</a>
            </div>

            @if ($recentAgendas->count() > 0)
                @foreach ($recentAgendas as $agenda)
                    <div class="list-item">
                        <div>
                            <p class="item-title">{{ $agenda->title }}</p>
                            <p class="item-meta">{{ $agenda->category }} &middot; {{ $agenda->comments_count }} komentar &middot; {{ $agenda->likes_count }} suka</p>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">Belum ada agenda</div>
            @endif
        </div>


        {{-- Aduan Terbaru --}}
        <div class="card">
            <div class="card-header">
                <h2>📋 Aduan Terbaru</h2>
                <a href="{{ route('admin.aduan.index') }}">Lihat Semua →</a>
            </div>

            @if ($recentAduans->count() > 0)
                @foreach ($recentAduans as $aduan)
                    <div class="list-item">
                        <div>
                            <p class="item-title">{{ $aduan->judul }}</p>
                            <p class="item-meta">{{ $aduan->created_at->format('d M Y') }}</p>
                        </div>
                        <span class="item-badge badge-{{ $aduan->status ?? 'pending' }}">
                            {{ ucfirst($aduan->status ?? 'pending') }}
                        </span>
                    </div>
                @endforeach
            @else
                <div class="empty-state">Belum ada aduan</div>
            @endif
        </div>


        {{-- Aspirasi Terbaru --}}
        <div class="card">
            <div class="card-header">
                <h2>💡 Aspirasi Terbaru</h2>
            </div>

            @if ($recentAspirasis->count() > 0)
                @foreach ($recentAspirasis as $aspirasi)
                    <div class="list-item">
                        <div>
                            <p class="item-title">{{ $aspirasi->nama ?? 'Aspirasi Tanpa Nama' }}</p>
                            <p class="item-meta">{{ $aspirasi->user?->name ?? 'Anonymous' }} &middot; {{ $aspirasi->created_at->format('d M Y') }}</p>
                        </div>
                        <span class="item-badge badge-aspirasi">{{ $aspirasi->rating }} bintang</span>
                    </div>
                @endforeach
            @else
                <div class="empty-state">Belum ada aspirasi</div>
            @endif
        </div>

    </div>


    {{-- ---- Bottom Grid ---- --}}
    <div class="bottom-grid">

        {{-- Distribusi Status Aduan --}}
        <div class="card">
            <div class="card-header">
                <h2>📊 Distribusi Status Aduan</h2>
            </div>
            <div class="dist-row">
                @forelse ($aduanStatusDistribution as $status => $count)
                    <div class="dist-item">
                        <div class="dist-num">{{ $count }}</div>
                        <div class="dist-label">{{ $status }}</div>
                    </div>
                @empty
                    <div class="empty-state" style="width: 100%;">Belum ada data</div>
                @endforelse
            </div>
        </div>


        {{-- Aksi Cepat --}}
        <div class="card">
            <div class="card-header">
                <h2>⚡ Aksi Cepat</h2>
            </div>
            <div class="action-row">
                <a href="{{ route('admin.agenda.create') }}" class="btn-action primary">Buat Agenda Baru</a>
                <a href="{{ route('admin.agenda.index') }}" class="btn-action">Kelola Agenda</a>
                <a href="{{ route('admin.aduan.index') }}" class="btn-action">Kelola Aduan</a>
            </div>
        </div>

    </div>

</div>
@endsection
