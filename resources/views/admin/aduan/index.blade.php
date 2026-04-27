@extends('layouts.app')

@section('title', 'Admin - Kelola Pengaduan')

@section('styles')
<style>
    .admin-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(220, 38, 38, 0.1);
    }

    .page-header h1 {
        font-size: 28px;
        color: #7f1d1d;
        margin: 0;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .admin-table th, .admin-table td {
        padding: 15px 20px;
        text-align: left;
        border-bottom: 1px solid #f3f4f6;
    }

    .admin-table th {
        background: #fef2f2;
        color: #991b1b;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
    }

    .admin-table tr:hover {
        background: #fdf2f8;
    }

    .status-badge {
        font-size: 11px;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-dikirim { background: #e0f2fe; color: #0284c7; }
    .status-ditinjau { background: #fef08a; color: #854d0e; }
    .status-diproses { background: #fed7aa; color: #c2410c; }
    .status-selesai { background: #dcfce7; color: #166534; }

    .btn-detail {
        background: #ef4444;
        color: white;
        padding: 6px 14px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        transition: background 0.3s;
    }

    .btn-detail:hover {
        background: #dc2626;
    }

    /* Filter Styles */
    .filter-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.03);
        border: 1px solid rgba(220, 38, 38, 0.08);
    }

    .filter-form {
        display: flex;
        gap: 20px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        min-width: 200px;
    }

    .filter-group label {
        font-size: 13px;
        font-weight: 600;
        color: #7f1d1d;
        margin-bottom: 6px;
    }

    .filter-group select {
        padding: 10px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #f9fafb;
        outline: none;
    }

    .filter-group select:focus {
        border-color: #f87171;
    }

    .btn-filter {
        background: #1e293b;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-filter:hover { background: #0f172a; }

    .btn-reset {
        background: #f1f5f9;
        color: #475569;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        border: 1px solid #e2e8f0;
    }

    .btn-reset:hover { background: #e2e8f0; }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="page-header">
        <h1>Manajemen Layanan Pengaduan (Admin)</h1>
    </div>

    <!-- Filter Section -->
    <div class="filter-container">
        <form action="{{ route('admin.aduan.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label for="status">Filter Berdasarkan Status</label>
                <select name="status" id="status">
                    <option value="">-- Semua Status --</option>
                    <option value="dikirim" {{ request('status') === 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                    <option value="ditinjau" {{ request('status') === 'ditinjau' ? 'selected' : '' }}>Ditinjau</option>
                    <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="kategori">Filter Kategori</label>
                <select name="kategori" id="kategori">
                    <option value="">-- Semua Kategori --</option>
                    <option value="Perkuliahan" {{ request('kategori') === 'Perkuliahan' ? 'selected' : '' }}>Perkuliahan</option>
                    <option value="Penilaian & Nilai" {{ request('kategori') === 'Penilaian & Nilai' ? 'selected' : '' }}>Penilaian & Nilai</option>
                    <option value="Dosen & Pengajar" {{ request('kategori') === 'Dosen & Pengajar' ? 'selected' : '' }}>Dosen & Pengajar</option>
                    <option value="Administrasi Akademik" {{ request('kategori') === 'Administrasi Akademik' ? 'selected' : '' }}>Administrasi Akademik</option>
                    <option value="Etika & Pelanggaran akademik" {{ request('kategori') === 'Etika & Pelanggaran akademik' ? 'selected' : '' }}>Etika & Pelanggaran akademik</option>
                    <option value="Bimbingan & Skripsi" {{ request('kategori') === 'Bimbingan & Skripsi' ? 'selected' : '' }}>Bimbingan & Skripsi</option>
                </select>
            </div>

            <div style="display:flex; gap:10px;">
                <button type="submit" class="btn-filter">Terapkan Filter</button>
                @if(request()->has('status') || request()->has('kategori'))
                    <a href="{{ route('admin.aduan.index') }}" class="btn-reset">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tgl Kirim</th>
                <th>Pengirim</th>
                <th>Kategori</th>
                <th>Judul Aduan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aduans as $aduan)
            <tr>
                <td>#{{ $aduan->id }}</td>
                <td>{{ $aduan->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $aduan->user ? $aduan->user->name : 'Anonim/Dihapus' }}</td>
                <td>{{ $aduan->kategori }}</td>
                <td><strong>{{ Str::limit($aduan->judul, 30) }}</strong></td>
                <td>
                    <span class="status-badge status-{{ $aduan->status }}">{{ $aduan->status }}</span>
                </td>
                <td>
                    <a href="{{ route('admin.aduan.show', $aduan->id) }}" class="btn-detail">Lihat & Proses</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 30px; color: #6b7280;">Bebas tugas! Belum ada aduan yang masuk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
