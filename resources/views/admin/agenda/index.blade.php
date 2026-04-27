@extends('layouts.app')

@section('title', 'Admin - Kelola Agenda')

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
        gap: 15px;
    }

    .page-header h1 {
        font-size: 28px;
        color: #7f1d1d;
        margin: 0;
    }

    .btn-add {
        background: #ef4444;
        color: #fff;
        text-decoration: none;
        padding: 10px 16px;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-add:hover {
        background: #dc2626;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #bbf7d0;
    }

    .filter-card {
        background: #fff;
        border: 1px solid rgba(220, 38, 38, 0.1);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 2fr 1.5fr auto;
        gap: 12px;
        align-items: end;
    }

    .filter-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #7f1d1d;
        margin-bottom: 6px;
    }

    .filter-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
    }

    .filter-control:focus {
        outline: none;
        border-color: #ef4444;
    }

    .filter-actions {
        display: flex;
        gap: 8px;
    }

    .btn-filter {
        border: none;
        background: #1f2937;
        color: #fff;
        border-radius: 8px;
        padding: 10px 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-reset {
        display: inline-block;
        text-decoration: none;
        background: #f3f4f6;
        color: #374151;
        border-radius: 8px;
        padding: 10px 14px;
        font-weight: 600;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .admin-table th,
    .admin-table td {
        padding: 15px 20px;
        text-align: left;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: top;
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

    .action-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .btn-action {
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-preview {
        background: #f1f5f9;
        color: #334155;
    }

    .btn-edit {
        background: #fde68a;
        color: #92400e;
    }

    .btn-delete {
        background: #fee2e2;
        color: #b91c1c;
    }

    .category-badge {
        display: inline-block;
        margin-bottom: 6px;
        font-size: 11px;
        font-weight: 700;
        background: #fff1f2;
        color: #be123c;
        border: 1px solid #fecdd3;
        border-radius: 999px;
        padding: 4px 10px;
    }

    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .pagination a,
    .pagination span {
        min-width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #374151;
        font-weight: 600;
        padding: 0 10px;
    }

    .pagination a:hover {
        background: #fff1f2;
        border-color: #fda4af;
        color: #be123c;
    }

    .pagination .active {
        background: #ef4444;
        border-color: #ef4444;
        color: #fff;
    }

    .pagination .disabled {
        background: #f9fafb;
        color: #9ca3af;
        border-color: #f3f4f6;
    }

    @media (max-width: 900px) {
        .filter-form {
            grid-template-columns: 1fr;
        }

        .admin-table th,
        .admin-table td {
            padding: 12px;
        }
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="page-header">
        <h1>Manajemen Agenda & Postingan</h1>
        <a href="{{ route('admin.agenda.create') }}" class="btn-add">+ Tambah Postingan Agenda</a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="filter-card">
        <form action="{{ route('admin.agenda.index') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label for="q">Pencarian</label>
                <input id="q" type="text" name="q" class="filter-control" value="{{ request('q') }}" placeholder="Cari judul atau isi postingan...">
            </div>

            <div class="filter-group">
                <label for="category">Kategori</label>
                <select id="category" name="category" class="filter-control">
                    <option value="">Semua kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-filter">Terapkan</button>
                @if(request()->filled('q') || request()->filled('category'))
                    <a href="{{ route('admin.agenda.index') }}" class="btn-reset">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Tanggal Publish</th>
                <th>Statistik</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($agendas as $agenda)
                <tr>
                    <td>#{{ $agenda->id }}</td>
                    <td>
                        @if($agenda->category)
                            <span class="category-badge">{{ $agenda->category }}</span>
                        @endif
                        <strong>{{ $agenda->title }}</strong>
                        <div style="font-size: 13px; color: #6b7280; margin-top: 5px;">
                            {{ Str::limit($agenda->content, 80) }}
                        </div>
                    </td>
                    <td>{{ $agenda->category ?? '-' }}</td>
                    <td>{{ $agenda->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        ❤️ {{ $agenda->likes_count }} | 💬 {{ $agenda->comments_count }}
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('agenda.show', $agenda->id) }}" class="btn-action btn-preview">Preview</a>
                            <a href="{{ route('admin.agenda.edit', $agenda->id) }}" class="btn-action btn-edit">Edit</a>
                            <form action="{{ route('admin.agenda.destroy', $agenda->id) }}" method="POST" onsubmit="return confirm('Hapus postingan ini? Komentar dan like akan ikut terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">
                        Belum ada postingan agenda. Klik tombol tambah untuk membuat postingan pertama.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($agendas->hasPages())
        <div class="pagination-wrapper">
            <nav class="pagination" aria-label="Pagination">
                @if($agendas->onFirstPage())
                    <span class="disabled">&laquo;</span>
                @else
                    <a href="{{ $agendas->previousPageUrl() }}">&laquo;</a>
                @endif

                @for($page = 1; $page <= $agendas->lastPage(); $page++)
                    @if($page == $agendas->currentPage())
                        <span class="active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $agendas->lastPage() || abs($page - $agendas->currentPage()) <= 1)
                        <a href="{{ $agendas->url($page) }}">{{ $page }}</a>
                    @elseif($page == 2 || $page == $agendas->lastPage() - 1)
                        <span class="disabled">...</span>
                    @endif
                @endfor

                @if($agendas->hasMorePages())
                    <a href="{{ $agendas->nextPageUrl() }}">&raquo;</a>
                @else
                    <span class="disabled">&raquo;</span>
                @endif
            </nav>
        </div>
    @endif
</div>
@endsection
