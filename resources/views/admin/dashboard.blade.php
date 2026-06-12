@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Admin Dashboard')

@section('styles')
<style>

    /* ---- Layout ---- */

    .admin-dashboard {
        width: 100%;
        padding: 30px 24px 24px;
        margin-top: 64px;
    }

    .content-grid,
    .bottom-grid {
        margin-top: 24px;
    }


    /* ---- Header ---- */

    .dashboard-header {
        margin-bottom: 24px;
    }

    .dashboard-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }


    /* ---- Stat Cards ---- */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
        margin-top: 20px;
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
        margin-bottom: 14px;
    }

    .stat-card-icon svg {
        width: 40px;
        height: 40px;
        display: block;
    }

    .agenda-card .stat-card-icon svg   { color: #991b1b; }
    .aduan-card .stat-card-icon svg    { color: #dc2626; }
    .user-card .stat-card-icon svg     { color: #10b981; }
    .aspirasi-card .stat-card-icon svg { color: #f59e0b; }
    .event-card .stat-card-icon svg    { color: #8b5cf6; }

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

    .stat-card.agenda-card   { border-top: 3px solid #991b1b; }
    .stat-card.aduan-card    { border-top: 3px solid #dc2626; }
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
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-header h2 svg {
        width: 18px;
        height: 18px;
        stroke: #9ca3af;
        flex-shrink: 0;
    }

    .card-header a {
        font-size: 12px;
        color: #991b1b;
        text-decoration: none;
        font-weight: 500;
    }

    .card-header a:hover {
        color: #7f1d1d;
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
    .badge-ditinjau { background: #fef3c7; color: #92400e; }
    .badge-diproses { background: #fef2f2; color: #991b1b; }
    .badge-selesai  { background: #f0fdf4; color: #166534; }
    .badge-aspirasi { background: #f3e8ff; color: #6b21a8; }
    .badge-pending  { background: #fef3c7; color: #92400e; }


    /* ---- Bar Chart Distribution ---- */

    .chart-container {
        padding: 20px 18px;
    }

    .chart-bars {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        gap: 12px;
        height: 120px;
        margin-bottom: 16px;
    }

    .chart-bar-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
        gap: 8px;
    }

    .chart-bar {
        width: 100%;
        background: linear-gradient(180deg, #dc2626 0%, #991b1b 100%);
        border-radius: 6px 6px 0 0;
        min-height: 8px;
        transition: opacity 0.2s;
    }

    .chart-bar:hover {
        opacity: 0.8;
    }

    .chart-label {
        font-size: 11px;
        font-weight: 500;
        color: #374151;
        text-align: center;
        width: 100%;
    }

    .chart-value {
        font-size: 12px;
        font-weight: 700;
        color: #1f2937;
    }


    /* ---- Aksi Cepat ---- */

    .action-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        padding: 16px 18px;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
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

    .btn-action svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
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

    {{-- ---- Stat Cards ---- --}}
    <div class="stats-grid">

        <div class="stat-card agenda-card">
            <div class="stat-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <path d="M3 10h18"/>
                    <path d="M8 2v4M16 2v4"/>
                </svg>
            </div>
            <div class="stat-card-label">Total Agenda</div>
            <div class="stat-card-value">{{ $totalAgenda }}</div>
        </div>

        <div class="stat-card aduan-card">
            <div class="stat-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9"/>
                    <path d="M5 7h14M5 11h10M5 15h8"/>
                </svg>
            </div>
            <div class="stat-card-label">Total Aduan</div>
            <div class="stat-card-value">{{ $totalAduan }}</div>
        </div>

        <div class="stat-card user-card">
            <div class="stat-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-card-label">Total Pengguna</div>
            <div class="stat-card-value">{{ $totalUsers }}</div>
        </div>

        <div class="stat-card aspirasi-card">
            <div class="stat-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    <circle cx="9" cy="10" r="1" fill="currentColor"/>
                    <circle cx="12" cy="10" r="1" fill="currentColor"/>
                    <circle cx="15" cy="10" r="1" fill="currentColor"/>
                </svg>
            </div>
            <div class="stat-card-label">Total Aspirasi</div>
            <div class="stat-card-value">{{ $totalAspirasi }}</div>
        </div>

        <div class="stat-card event-card">
            <div class="stat-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 2v20M2 12h20"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </div>
            <div class="stat-card-label">Event Aktif</div>
            <div class="stat-card-value">{{ $activeEvents }}</div>
        </div>

    </div>


    {{-- ---- Content Grid ---- --}}
    <div class="content-grid">

        {{-- Agenda Terbaru --}}
        <div class="card">
            <div class="card-header">
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M3 10h18"/>
                        <path d="M8 2v4M16 2v4"/>
                    </svg>
                    Agenda Terbaru
                </h2>
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
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9"/>
                        <path d="M5 7h14M5 11h10M5 15h8"/>
                    </svg>
                    Aduan Terbaru
                </h2>
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
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        <circle cx="9" cy="10" r="1" fill="currentColor"/>
                        <circle cx="12" cy="10" r="1" fill="currentColor"/>
                        <circle cx="15" cy="10" r="1" fill="currentColor"/>
                    </svg>
                    Aspirasi Terbaru
                </h2>
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
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v18h18"/>
                        <rect x="5" y="11" width="2" height="8"/>
                        <rect x="10" y="8" width="2" height="11"/>
                        <rect x="15" y="5" width="2" height="14"/>
                    </svg>
                    Distribusi Status Aduan
                </h2>
            </div>
            <div class="chart-container">
                @if ($aduanStatusDistribution && count($aduanStatusDistribution) > 0)
                    <div class="chart-bars">
                        @php
                            $maxCount = max(array_values($aduanStatusDistribution));
                            $colors = ['#dc2626', '#f59e0b', '#10b981', '#3b82f6'];
                            $colorIndex = 0;
                        @endphp
                        @forelse ($aduanStatusDistribution as $status => $count)
                            @php
                                $percentage = $maxCount > 0 ? ($count / $maxCount) * 100 : 0;
                                $color = $colors[$colorIndex % count($colors)];
                                $colorIndex++;
                            @endphp
                            <div class="chart-bar-wrapper">
                                <div class="chart-value">{{ $count }}</div>
                                <div class="chart-bar" style="height: {{ max($percentage, 15) }}%; background: linear-gradient(180deg, {{ $color }} 0%, rgba(153, 27, 27, 0.6) 100%);"></div>
                                <div class="chart-label">{{ $status }}</div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                @else
                    <div class="empty-state">Belum ada data</div>
                @endif
            </div>
        </div>


        {{-- Aksi Cepat --}}
        <div class="card">
            <div class="card-header">
                <h2>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="8"/>
                        <path d="M12 6v6l4 2"/>
                    </svg>
                    Aksi Cepat
                </h2>
            </div>
            <div class="action-row">
                <a href="{{ route('admin.agenda.create') }}" class="btn-action primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Buat Agenda Baru
                </a>
                <a href="{{ route('admin.agenda.index') }}" class="btn-action">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <path d="M3 10h18"/>
                        <path d="M8 2v4M16 2v4"/>
                    </svg>
                    Kelola Agenda
                </a>
                <a href="{{ route('admin.aduan.index') }}" class="btn-action">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V9"/>
                        <path d="M5 7h14M5 11h10M5 15h8"/>
                    </svg>
                    Kelola Aduan
                </a>
            </div>
        </div>

    </div>

</div>
@endsection
