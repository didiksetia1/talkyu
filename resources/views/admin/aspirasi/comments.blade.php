@extends('layouts.app')

@section('title', 'Admin - Komentar Aspirasi')
@section('page_title', 'Komentar Aspirasi')

@section('styles')
<style>
    .admin-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        margin-top: 64px;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h1 {
        font-size: 22px;
        color: #1f2937;
        margin: 0;
    }
    .btn-back {
        background: #6b7280;
        color: #fff;
        text-decoration: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
    }
    .btn-back:hover { background: #4b5563; }
    .aspirasi-info {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 14px 18px;
        margin-bottom: 20px;
    }
    .aspirasi-info h3 {
        margin: 0 0 6px 0;
        font-size: 16px;
        color: #1e40af;
    }
    .aspirasi-info p {
        margin: 0;
        font-size: 13px;
        color: #1e3a8a;
    }
    .comment-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 14px 18px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }
    .comment-card:hover {
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    .comment-content {
        flex: 1;
    }
    .comment-meta {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 6px;
    }
    .comment-meta strong {
        color: #1f2937;
    }
    .comment-text {
        font-size: 14px;
        color: #374151;
        line-height: 1.5;
    }
    .btn-delete {
        background: #fee2e2;
        color: #b91c1c;
        border: none;
        border-radius: 6px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        text-decoration: none;
    }
    .btn-delete:hover {
        background: #fecaca;
    }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
        font-size: 14px;
    }
    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 16px;
        border: 1px solid #bbf7d0;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <div class="page-header">
        <h1>Komentar Aspirasi</h1>
        <a href="{{ route('admin.aspirasi.index') }}" class="btn-back">&larr; Kembali ke Aspirasi</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="aspirasi-info">
        <h3>{{ $aspirasi->judul ?? 'Aspirasi Tanpa Judul' }}</h3>
        <p>Kategori: {{ App\Models\Aspirasi::CATEGORIES[$aspirasi->kategori] ?? $aspirasi->kategori }} &middot; Total Komentar: {{ $aspirasi->comments_count }}</p>
    </div>

    @forelse($comments as $comment)
    <div class="comment-card">
        <div class="comment-content">
            <div class="comment-meta">
                <strong>{{ $comment->user_name ?? 'User Dihapus' }}</strong>
                &middot; {{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y, H:i') }}
            </div>
            <div class="comment-text">{{ $comment->text }}</div>
        </div>
        <form action="{{ route('admin.aspirasi.comments.destroy', ['id' => $aspirasi->id, 'commentId' => $comment->id]) }}" method="POST" onsubmit="return confirm('Hapus komentar ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">Hapus</button>
        </form>
    </div>
    @empty
    <div class="empty-state">
        <p>Belum ada komentar pada aspirasi ini.</p>
    </div>
    @endforelse

    @if($comments->hasPages())
    <div class="pagination-wrapper">
        {{ $comments->links() }}
    </div>
    @endif
</div>
@endsection
