@extends('layouts.app')

@section('title', 'Admin - Kelola Aspirasi')
@section('page_title', 'Kelola Aspirasi')

@section('styles')
<style>
    .admin-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }

    .stats-overview {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
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
            <div class="stat-value">{{ $stats['submitted'] ?? 0 }}</div>
            <div class="stat-label">Belum Ditinjau</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $stats['being_considered'] ?? 0 }}</div>
            <div class="stat-label">Diproses</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">{{ $stats['realized'] ?? 0 }}</div>
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
                    @foreach(App\Models\Aspirasi::CATEGORIES as $key => $label)
                    <option value="{{ $key }}" @if(request('kategori') === $key) selected @endif>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="status">Status</label>
                <select name="status" id="status">
                    <option value="">Semua</option>
                    <option value="submitted" @if(request('status') === 'submitted') selected @endif>Belum Ditinjau</option>
                    <option value="being_considered" @if(request('status') === 'being_considered') selected @endif>Diproses</option>
                    <option value="realized" @if(request('status') === 'realized') selected @endif>Selesai</option>
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

    <!-- Aspirasi List -->
    @if($aspirasis->count() > 0)
        @foreach($aspirasis as $aspirasi)
        <div class="aspirasi-card">
            <div class="aspirasi-header">
                <div>
                    <h3 class="aspirasi-title">{{ $aspirasi->judul ?? 'Aspirasi Tanpa Judul' }}</h3>
                    <div class="aspirasi-meta">
                        <span>{{ App\Models\Aspirasi::CATEGORIES[$aspirasi->kategori] ?? $aspirasi->kategori }}</span>
                        <span>{{ $aspirasi->user?->name ?? 'Anonymous' }}</span>
                        <span>{{ $aspirasi->created_at->format('d M Y') }}</span>
                        <span>{{ $aspirasi->votes_count }} vote</span>
                        <span>{{ $aspirasi->comments_count }} komentar</span>
                    </div>
                </div>
                <span class="status-badge status-{{ $aspirasi->status }}">
                    @switch($aspirasi->status)
                        @case('submitted')
                            Belum Ditinjau
                            @break
                        @case('being_considered')
                            Diproses
                            @break
                        @case('realized')
                            Selesai
                            @break
                        @default
                            {{ ucfirst(str_replace('_', ' ', $aspirasi->status)) }}
                    @endswitch
                </span>
            </div>

            <div class="aspirasi-content">
                <strong>Deskripsi:</strong> {{ Str::limit($aspirasi->deskripsi, 150) }}
                @if(strlen($aspirasi->deskripsi) > 150) ... @endif
            </div>

            @if($aspirasi->bem_response)
            <div class="bem-response-section">
                <div class="bem-response-title">Response BEM:</div>
                {{ Str::limit($aspirasi->bem_response, 150) }}
                @if(strlen($aspirasi->bem_response) > 150) ... @endif
            </div>
            @endif

            <div class="action-buttons">
                <button class="btn-action" onclick="openResponseForm({{ $aspirasi->id }})">
                    Beri Response
                </button>
                <button class="btn-action btn-secondary" onclick="updateStatus({{ $aspirasi->id }})">
                    Update Status
                </button>
            </div>

            <!-- Response Form (Hidden by default) -->
            <div id="form-{{ $aspirasi->id }}" class="form-modal" style="display: none;">
                <form onsubmit="submitResponse(event, {{ $aspirasi->id }})">
                    @csrf
                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status" required>
                            <option value="submitted" @if($aspirasi->status === 'submitted') selected @endif>Belum Ditinjau</option>
                            <option value="being_considered" @if($aspirasi->status === 'being_considered') selected @endif>Diproses</option>
                            <option value="realized" @if($aspirasi->status === 'realized') selected @endif>Selesai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Response dari BEM:</label>
                        <textarea name="bem_response" placeholder="Tulis response Anda di sini..." required>{{ $aspirasi->bem_response ?? '' }}</textarea>
                    </div>
                    <div class="form-buttons">
                        <button type="submit" class="btn-submit">Simpan</button>
                        <button type="button" class="btn-cancel" onclick="closeResponseForm({{ $aspirasi->id }})">Batal</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach

        <!-- Pagination -->
        <div style="margin-top: 30px;">
            {{ $aspirasis->links() }}
        </div>
    @else
        <div class="empty-state">
            <p>Belum ada aspirasi masuk.</p>
        </div>
    @endif
</div>

<script>
function openResponseForm(id) {
    document.getElementById(`form-${id}`).style.display = 'block';
}

function closeResponseForm(id) {
    document.getElementById(`form-${id}`).style.display = 'none';
}

function submitResponse(event, aspirasi_id) {
    event.preventDefault();
    const formData = new FormData(event.target);

    fetch(`/admin/aspirasi/${aspirasi_id}/respond`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Gagal menyimpan response');
        }
    })
    .catch(err => console.error(err));
}

function updateStatus(aspirasi_id) {
    openResponseForm(aspirasi_id);
}
</script>
@endsection