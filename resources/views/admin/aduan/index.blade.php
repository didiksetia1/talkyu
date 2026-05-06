@extends('layouts.app')

@section('title', 'Admin - Kelola Aduan')
@section('page_title', 'Kelola Aduan')

@section('styles')
<style>
    .admin-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        margin-top: 100px;
    }

    .stats-overview {
        display: flex;
        gap: 20px;
        /* space from navbar */
        margin: 32px 0 20px 0;
        flex-wrap: wrap;
    }

    .stat-item {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 12px 16px;
        flex: 1;
        min-width: 120px;
        text-align: center;
    }

    .stat-value {
        font-size: 20px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 2px;
    }

    .stat-label {
        font-size: 12px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-section {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 12px 16px;
        margin-bottom: 15px;
    }

    .filter-section form {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .filter-group label {
        font-size: 12px;
        font-weight: 500;
        color: #374151;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-group select,
    .filter-group input {
        padding: 6px 10px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-size: 14px;
        min-width: 120px;
    }

    .aspirasi-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 16px;
        margin-bottom: 12px;
    }

    .aspirasi-card:hover {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .aspirasi-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }

    .aspirasi-title {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .aspirasi-meta {
        display: flex;
        gap: 12px;
        margin-bottom: 8px;
        font-size: 12px;
        color: #6b7280;
        flex-wrap: wrap;
    }

    .aspirasi-content {
        margin-bottom: 12px;
        padding: 10px;
        background: #f9fafb;
        border-radius: 4px;
        font-size: 14px;
        line-height: 1.4;
        color: #374151;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-submitted {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-being_considered {
        background: #fef3c7;
        color: #92400e;
    }

    .status-realized {
        background: #d1fae5;
        color: #065f46;
    }

    .status-dikirim {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-ditinjau {
        background: #fef3c7;
        color: #92400e;
    }

    .status-diproses {
        background: #fef3c7;
        color: #92400e;
    }

    .status-selesai {
        background: #d1fae5;
        color: #065f46;
    }

    .bem-response-section {
        background: #f0fdf4;
        border-left: 2px solid #10b981;
        padding: 10px;
        border-radius: 4px;
        margin-bottom: 12px;
        font-size: 13px;
        color: #065f46;
    }

    .bem-response-title {
        font-weight: 600;
        margin-bottom: 4px;
    }

    .action-buttons {
        display: flex;
        gap: 8px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 6px 12px;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 500;
        transition: background 0.2s;
    }

    .btn-action:hover {
        background: #2563eb;
    }

    .btn-secondary {
        background: #6b7280;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .form-modal {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 16px;
        margin-top: 12px;
    }

    .form-group {
        margin-bottom: 12px;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        margin-bottom: 6px;
        color: #1f2937;
        font-size: 14px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 8px 10px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-family: inherit;
        font-size: 14px;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-buttons {
        display: flex;
        gap: 8px;
    }

    .btn-submit {
        background: #10b981;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: background 0.2s;
    }

    .btn-submit:hover {
        background: #059669;
    }

    .btn-cancel {
        background: #e5e7eb;
        color: #1f2937;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
    }

    .empty-state {
        text-align: center;
        padding: 30px 20px;
        color: #6b7280;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="admin-container">

    <!-- Stats -->
    <div class="stats-overview">
        <div class="stat-item">
            <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
            <div class="stat-label">Total</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $stats['dikirim'] ?? 0 }}</div>
            <div class="stat-label">Dikirim</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $stats['ditinjau'] ?? 0 }}</div>
            <div class="stat-label">Ditinjau</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $stats['diproses'] ?? 0 }}</div>
            <div class="stat-label">Diproses</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $stats['selesai'] ?? 0 }}</div>
            <div class="stat-label">Selesai</div>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-section">
        <form method="GET" class="filter-form">
            <div class="filter-group">
                <label for="kategori">Kategori</label>
                <select name="kategori" id="kategori">
                    <option value="">Semua</option>
                    @foreach($categories as $kategori)
                    <option value="{{ $kategori }}" @if(request('kategori') === $kategori) selected @endif>{{ ucfirst($kategori) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="">Semua</option>
                    <option value="dikirim" @if(request('status') === 'dikirim') selected @endif>Dikirim</option>
                    <option value="ditinjau" @if(request('status') === 'ditinjau') selected @endif>Ditinjau</option>
                    <option value="diproses" @if(request('status') === 'diproses') selected @endif>Diproses</option>
                    <option value="selesai" @if(request('status') === 'selesai') selected @endif>Selesai</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="search">Cari</label>
                <input type="text" name="q" id="search" placeholder="Judul, deskripsi..." value="{{ request('q') }}">
            </div>
            <div class="filter-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn-action">Filter</button>
            </div>
        </form>
    </div>

    <!-- Aduan List -->
    @if($aduans->count() > 0)
        @foreach($aduans as $aduan)
        <div class="aspirasi-card">
            <div class="aspirasi-header">
                <div>
                    <h3 class="aspirasi-title">{{ $aduan->judul ?? 'Aduan Tanpa Judul' }}</h3>
                    <div class="aspirasi-meta">
                        <span>{{ ucfirst($aduan->kategori ?? 'Umum') }}</span>
                        <span>{{ $aduan->user?->name ?? 'Anonim' }}</span>
                        <span>{{ $aduan->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                <span class="status-badge status-{{ $aduan->status }}">
                    @switch($aduan->status)
                        @case('dikirim')
                            Dikirim
                            @break
                        @case('ditinjau')
                            Ditinjau
                            @break
                        @case('diproses')
                            Diproses
                            @break
                        @case('selesai')
                            Selesai
                            @break
                        @default
                            {{ ucfirst(str_replace('_', ' ', $aduan->status)) }}
                    @endswitch
                </span>
            </div>

            <div class="aspirasi-content">
                <strong>Deskripsi:</strong> {{ Str::limit($aduan->deskripsi, 150) }}
                @if(strlen($aduan->deskripsi) > 150) ... @endif
            </div>

            @if($aduan->tanggapan)
            <div class="bem-response-section">
                <div class="bem-response-title">Tanggapan Admin:</div>
                {{ Str::limit($aduan->tanggapan, 150) }}
                @if(strlen($aduan->tanggapan) > 150) ... @endif
            </div>
            @endif

            <div class="action-buttons">
                <a href="{{ route('admin.aduan.show', $aduan->id) }}" class="btn-action">Lihat & Kelola</a>
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <div style="margin-top: 30px;">
            {{ $aduans->links() }}
        </div>
    @else
        <div class="empty-state">
            <p>Belum ada aduan masuk.</p>
        </div>
    @endif
</div>
@endsection
