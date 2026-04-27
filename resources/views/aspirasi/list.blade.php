@extends('layouts.app')

@section('title', 'Daftar Aspirasi - Talkyu')

@section('styles')
<style>
    .page-header {
        margin-bottom: 40px;
        text-align: center;
    }

    .page-header h1 {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #b91c1c;
    }

    .page-header p {
        color: #4b5563;
        font-size: 16px;
    }

    .aspirasi-card {
        background: white;
        border-radius: 12px;
        padding: 25px;
        border: 1px solid rgba(220, 38, 38, 0.1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .aspirasi-title {
        font-size: 20px;
        font-weight: 600;
        color: #7f1d1d;
        margin-bottom: 10px;
    }

    .aspirasi-meta {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 15px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .aspirasi-desc {
        font-size: 14px;
        color: #374151;
        line-height: 1.5;
        background: #f9fafb;
        padding: 15px;
        border-radius: 8px;
    }

    .btn-back {
        display: inline-block;
        margin-bottom: 20px;
        color: #b91c1c;
        text-decoration: none;
        font-weight: 600;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }
</style>
@endsection

@section('content')
<div class="container" style="padding: 40px 0; max-width: 900px; margin: 0 auto;">
    <a href="{{ route('aspirasi.home') }}" class="btn-back">← Kembali ke Pusat Layanan</a>

    <div class="page-header">
        <h1>Daftar Aspirasi</h1>
        <p>Lihat aspirasi yang telah disampaikan oleh mahasiswa.</p>
    </div>

    <form method="GET" style="margin-bottom: 30px; display: flex; gap: 10px;">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul, deskripsi..." style="flex: 1; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px;">
        <button type="submit" style="padding: 10px 20px; background: #b91c1c; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer;">Cari</button>
    </form>

    <div class="aspirasi-list">
        @forelse($aspirasis as $aspirasi)
            <div class="aspirasi-card">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div class="aspirasi-title">{{ $aspirasi->judul ?? 'Tanpa Judul' }}</div>
                    <span class="status-badge" style="background: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5;">{{ str_replace('_', ' ', $aspirasi->status) }}</span>
                </div>
                <div class="aspirasi-meta">
                    <span>📁 Kategori: {{ App\Models\Aspirasi::CATEGORIES[$aspirasi->kategori] ?? $aspirasi->kategori }}</span>
                    <span>👤 {{ $aspirasi->is_anonim ? 'Anonymous' : ($aspirasi->user?->name ?? 'Anonymous') }}</span>
                    <span>📅 {{ $aspirasi->created_at->format('d M Y') }}</span>
                    <span>👍 {{ $aspirasi->votes_count }} Votes</span>
                </div>
                <div class="aspirasi-desc">
                    {{ Str::limit($aspirasi->deskripsi, 200) }}
                </div>
                <div style="margin-top: 15px;">
                    <a href="{{ route('aspirasi.detail', $aspirasi->id) }}" style="color: #b91c1c; font-weight: bold; text-decoration: none;">Lihat Selengkapnya →</a>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px; background: #f9fafb; border-radius: 12px; color: #6b7280;">
                <p>Belum ada aspirasi yang ditemukan.</p>
            </div>
        @endforelse

        <div style="margin-top: 30px;">
            {{ $aspirasis->links() }}
        </div>
    </div>
</div>
@endsection
