@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('styles')
<style>
    .admin-dashboard {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .dashboard-header {
        margin-bottom: 30px;
    }

    .dashboard-header h1 {
        font-size: 32px;
        color: #7f1d1d;
        margin: 0 0 10px 0;
    }

    .dashboard-header p {
        color: #666;
        margin: 0;
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .stat-card-icon {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .stat-card-label {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .stat-card-value {
        font-size: 28px;
        font-weight: bold;
        color: #1f2937;
    }

    .stat-card.agenda-card {
        border-top: 3px solid #3b82f6;
    }

    .stat-card.aduan-card {
        border-top: 3px solid #ef4444;
    }

    .stat-card.user-card {
        border-top: 3px solid #10b981;
    }

    .stat-card.aspirasi-card {
        border-top: 3px solid #f59e0b;
    }

    .stat-card.event-card {
        border-top: 3px solid #8b5cf6;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: #f9fafb;
        padding: 15px 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h2 {
        font-size: 18px;
        margin: 0;
        color: #1f2937;
    }

    .card-header a {
        color: #3b82f6;
        text-decoration: none;
        font-size: 12px;
    }

    .card-header a:hover {
        text-decoration: underline;
    }

    .card-body {
        padding: 20px;
    }

    .list-item {
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .item-info {
        flex: 1;
    }

    .item-title {
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 4px 0;
    }

    .item-meta {
        font-size: 12px;
        color: #6b7280;
        margin: 0;
    }

    .item-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge-urgent {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .badge-aspirasi {
        background: #f3e8ff;
        color: #6b21a8;
    }

    .empty-state {
        text-align: center;
        padding: 20px;
        color: #6b7280;
    }

    .status-distribution {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .dist-item {
        flex: 1;
        min-width: 120px;
        text-align: center;
        padding: 15px;
        background: #f9fafb;
        border-radius: 6px;
    }

    .dist-value {
        font-size: 24px;
        font-weight: bold;
        color: #1f2937;
    }

    .dist-label {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
        text-transform: capitalize;
    }

    .quick-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-action {
        display: inline-block;
        padding: 10px 15px;
        background: #3b82f6;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 13px;
        transition: background 0.2s;
    }

    .btn-action:hover {
        background: #2563eb;
    }

    .btn-action.secondary {
        background: #6b7280;
    }

    .btn-action.secondary:hover {
        background: #4b5563;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .content-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-header h1 {
            font-size: 24px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-dashboard">
    <!-- Header -->
    <div class="dashboard-header">
        <h1>📊 Admin Dashboard</h1>
        <p>Selamat datang, {{ Auth::user()->name }}! Berikut adalah ringkasan sistem Talkyu.</p>
    </div>

    <!-- Statistics Cards -->
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

        <div class="stat-card event-card">
            <div class="stat-card-icon">🎯</div>
            <div class="stat-card-label">Event Aktif</div>
            <div class="stat-card-value">{{ $activeEvents }}</div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Agenda Terbaru -->
        <div class="card">
            <div class="card-header">
                <h2>📅 Agenda Terbaru</h2>
                <a href="{{ route('admin.agenda.index') }}">Lihat Semua →</a>
            </div>
            <div class="card-body">
                @if($recentAgendas->count() > 0)
                    @foreach($recentAgendas as $agenda)
                    <div class="list-item">
                        <div class="item-info">
                            <p class="item-title">{{ $agenda->title }}</p>
                            <p class="item-meta">
                                📌 {{ $agenda->category }} • 💬 {{ $agenda->comments_count }} • 👍 {{ $agenda->likes_count }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">Belum ada agenda</div>
                @endif
            </div>
        </div>

        <!-- Aduan Terbaru -->
        <div class="card">
            <div class="card-header">
                <h2>📋 Aduan Terbaru</h2>
                <a href="{{ route('admin.aduan.index') }}">Lihat Semua →</a>
            </div>
            <div class="card-body">
                @if($recentAduans->count() > 0)
                    @foreach($recentAduans as $aduan)
                    <div class="list-item">
                        <div class="item-info">
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
        </div>

        <!-- Aspirasi Terbaru -->
        <div class="card">
            <div class="card-header">
                <h2>💡 Aspirasi Terbaru</h2>
            </div>
            <div class="card-body">
                @if($recentAspirasis->count() > 0)
                    @foreach($recentAspirasis as $aspirasi)
                    <div class="list-item">
                        <div class="item-info">
                            <p class="item-title">{{ $aspirasi->nama ?? 'Aspirasi Tanpa Nama' }}</p>
                            <p class="item-meta">
                                👤 {{ $aspirasi->user?->name ?? 'Anonymous' }} • {{ $aspirasi->created_at->format('d M Y') }}
                            </p>
                        </div>
                        <span class="item-badge badge-aspirasi">
                            ⭐ {{ $aspirasi->rating }}
                        </span>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">Belum ada aspirasi</div>
                @endif
            </div>
        </div>

        <!-- Status Aduan Distribution -->
        <div class="card full-width">
            <div class="card-header">
                <h2>📊 Distribusi Status Aduan</h2>
            </div>
            <div class="card-body">
                <div class="status-distribution">
                    @forelse($aduanStatusDistribution as $status => $count)
                    <div class="dist-item">
                        <div class="dist-value">{{ $count }}</div>
                        <div class="dist-label">{{ $status }}</div>
                    </div>
                    @empty
                    <div class="empty-state" style="width: 100%;">Belum ada data</div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card full-width">
            <div class="card-header">
                <h2>⚡ Aksi Cepat</h2>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="{{ route('admin.agenda.create') }}" class="btn-action">➕ Buat Agenda Baru</a>
                    <a href="{{ route('admin.agenda.index') }}" class="btn-action secondary">📅 Kelola Agenda</a>
                    <a href="{{ route('admin.aduan.index') }}" class="btn-action secondary">📋 Kelola Aduan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
