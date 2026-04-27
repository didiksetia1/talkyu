@extends('layouts.app')

@section('title', 'Admin - Kelola Aspirasi')

@section('styles')
<style>
    .admin-container {
        max-width: 1200px;
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

    .filter-section {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .filter-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .filter-group select,
    .filter-group input {
        padding: 8px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 14px;
    }

    .aspirasi-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.2s;
    }

    .aspirasi-card:hover {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .aspirasi-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .aspirasi-title {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .aspirasi-meta {
        display: flex;
        gap: 15px;
        margin-bottom: 12px;
        font-size: 13px;
        color: #6b7280;
        flex-wrap: wrap;
    }

    .aspirasi-content {
        margin-bottom: 15px;
        padding: 12px;
        background: #f9fafb;
        border-radius: 6px;
        font-size: 14px;
        line-height: 1.5;
        color: #374151;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
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
        border-left: 3px solid #10b981;
        padding: 12px;
        border-radius: 4px;
        margin-bottom: 15px;
        font-size: 13px;
        color: #065f46;
    }

    .bem-response-title {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 15px;
        flex-wrap: wrap;
    }

    .btn-action {
        padding: 10px 15px;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
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
        border-radius: 8px;
        padding: 20px;
        margin-top: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #1f2937;
        font-size: 14px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-family: inherit;
        font-size: 14px;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
    }

    .form-buttons {
        display: flex;
        gap: 10px;
    }

    .btn-submit {
        background: #10b981;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s;
    }

    .btn-submit:hover {
        background: #059669;
    }

    .btn-cancel {
        background: #e5e7eb;
        color: #1f2937;
        padding: 10px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
    }

    .stat-value {
        font-size: 24px;
        font-weight: bold;
        color: #1f2937;
    }

    .stat-label {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="page-header">
        <h1>💡 Kelola Aspirasi</h1>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
            <div class="stat-label">Total Aspirasi</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['submitted'] ?? 0 }}</div>
            <div class="stat-label">Belum Ditinjau</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['being_considered'] ?? 0 }}</div>
            <div class="stat-label">Sedang Dipertimbangkan</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $stats['realized'] ?? 0 }}</div>
            <div class="stat-label">Direalisasikan</div>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-section">
        <form method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: center; width: 100%;">
            <div class="filter-group">
                <label>Kategori:</label>
                <select name="kategori">
                    <option value="">Semua</option>
                    @foreach(App\Models\Aspirasi::CATEGORIES as $key => $label)
                    <option value="{{ $key }}" @if(request('kategori') === $key) selected @endif>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label>Status:</label>
                <select name="status">
                    <option value="">Semua</option>
                    <option value="submitted" @if(request('status') === 'submitted') selected @endif>Submitted</option>
                    <option value="being_considered" @if(request('status') === 'being_considered') selected @endif>Being Considered</option>
                    <option value="realized" @if(request('status') === 'realized') selected @endif>Realized</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Cari:</label>
                <input type="text" name="q" placeholder="Nama, saran..." value="{{ request('q') }}">
            </div>
            <button type="submit" class="btn-action">Filter</button>
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
                        <span>� {{ App\Models\Aspirasi::CATEGORIES[$aspirasi->kategori] ?? $aspirasi->kategori }}</span>
                        <span>�👤 {{ $aspirasi->user?->name ?? 'Anonymous' }}</span>
                        <span>📅 {{ $aspirasi->created_at->format('d M Y') }}</span>
                        <span>👍 {{ $aspirasi->votes_count }} votes</span>
                        <span>💬 {{ $aspirasi->comments_count }} comments</span>
                    </div>
                </div>
                <span class="status-badge status-{{ $aspirasi->status }}">{{ ucfirst(str_replace('_', ' ', $aspirasi->status)) }}</span>
            </div>

            <div class="aspirasi-content">
                <strong>Deskripsi:</strong> {{ Str::limit($aspirasi->deskripsi, 150) }}
                @if(strlen($aspirasi->deskripsi) > 150) ... @endif
            </div>

            @if($aspirasi->bem_response)
            <div class="bem-response-section">
                <div class="bem-response-title">📢 Response BEM:</div>
                {{ Str::limit($aspirasi->bem_response, 150) }}
                @if(strlen($aspirasi->bem_response) > 150) ... @endif
            </div>
            @endif

            <div class="action-buttons">
                <button class="btn-action" onclick="openResponseForm({{ $aspirasi->id }})">
                    ✉️ Beri Response
                </button>
                <button class="btn-action btn-secondary" onclick="updateStatus({{ $aspirasi->id }})">
                    🔄 Update Status
                </button>
            </div>

            <!-- Response Form (Hidden by default) -->
            <div id="form-{{ $aspirasi->id }}" class="form-modal" style="display: none;">
                <form onsubmit="submitResponse(event, {{ $aspirasi->id }})">
                    @csrf
                    <div class="form-group">
                        <label>Status:</label>
                        <select name="status" required>
                            <option value="submitted" @if($aspirasi->status === 'submitted') selected @endif>Submitted</option>
                            <option value="being_considered" @if($aspirasi->status === 'being_considered') selected @endif>Sedang Dipertimbangkan</option>
                            <option value="realized" @if($aspirasi->status === 'realized') selected @endif>Direalisasikan</option>
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
            <p>Belum ada aspirasi masuk. 📭</p>
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
