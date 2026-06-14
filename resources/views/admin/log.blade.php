@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('page_title', 'Log Aktivitas')

@section('styles')
<style>
    .log-page {
        width: 100%;
        padding: 30px 24px 24px;
        margin-top: 64px;
    }

    .log-header {
        margin-bottom: 24px;
    }

    .log-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .log-header p {
        font-size: 14px;
        color: #9ca3af;
        margin: 6px 0 0 0;
    }

    .log-card {
        background: white;
        border: 1px solid #f3f4f6;
        border-radius: 12px;
        overflow: hidden;
    }

    .log-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        border-bottom: 1px solid #f3f4f6;
    }

    .log-card-header h2 {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .log-card-header h2 svg {
        width: 18px;
        height: 18px;
        stroke: #9ca3af;
        flex-shrink: 0;
    }

    .log-card-header a {
        font-size: 12px;
        color: #991b1b;
        text-decoration: none;
        font-weight: 500;
    }

    .log-card-header a:hover {
        color: #7f1d1d;
        text-decoration: underline;
    }

    .log-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 18px;
        border-bottom: 1px solid #f9fafb;
    }

    .log-item:last-child {
        border-bottom: none;
    }

    .log-dot {
        flex-shrink: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-top: 5px;
    }

    .log-dot.dot-agenda   { background: #991b1b; }
    .log-dot.dot-aduan    { background: #dc2626; }
    .log-dot.dot-aspirasi { background: #f59e0b; }

    .log-content {
        flex: 1;
        min-width: 0;
    }

    .log-title {
        font-size: 13px;
        font-weight: 600;
        color: #1f2937;
        margin: 0 0 3px 0;
        line-height: 1.4;
    }

    .log-meta {
        font-size: 11px;
        color: #9ca3af;
        margin: 0;
    }

    .log-type {
        flex-shrink: 0;
        display: inline-block;
        font-size: 10px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 99px;
        white-space: nowrap;
    }

    .log-type.type-agenda   { background: #f3f4f6; color: #374151; }
    .log-type.type-aduan    { background: #fef2f2; color: #991b1b; }
    .log-type.type-aspirasi { background: #f3e8ff; color: #6b21a8; }

    .log-time {
        flex-shrink: 0;
        font-size: 11px;
        color: #9ca3af;
        white-space: nowrap;
        padding-top: 2px;
    }

    .empty-state {
        padding: 48px 18px;
        text-align: center;
        font-size: 13px;
        color: #d1d5db;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 14px 18px;
        border-top: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .pagination-info {
        font-size: 12px;
        color: #9ca3af;
    }

    .pagination {
        display: flex;
        gap: 4px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .pagination li a,
    .pagination li span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        font-size: 12px;
        border-radius: 6px;
        text-decoration: none;
        border: 1px solid #e5e7eb;
        color: #374151;
        background: white;
    }

    .pagination li.active span {
        background: #991b1b;
        color: white;
        border-color: #991b1b;
    }

    .pagination li.disabled span {
        color: #d1d5db;
        cursor: not-allowed;
    }

    .pagination li a:hover {
        background: #f9fafb;
        color: #111827;
    }
</style>
@endsection

@section('content')
<div class="log-page">

    <div class="log-card">
        <div class="log-card-header">
            <h2>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18"/>
                    <path d="M7 14l4-4 4 4 5-5"/>
                </svg>
                Semua Aktivitas
            </h2>
            <a href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
        </div>

        @if ($activities->count() > 0)
            @foreach ($activities as $item)
                <div class="log-item">
                    <div class="log-dot dot-{{ $item['type'] }}"></div>
                    <div class="log-content">
                        <p class="log-title">{{ $item['title'] }}</p>
                        <p class="log-meta">{{ $item['meta'] }}</p>
                    </div>
                    <span class="log-type type-{{ $item['type'] }}">{{ ucfirst($item['type']) }}</span>
                    <span class="log-time">{{ \Carbon\Carbon::parse($item['date'])->diffForHumans() }}</span>
                </div>
            @endforeach

            <div class="pagination-wrapper">
                <span class="pagination-info">
                    Menampilkan {{ $activities->firstItem() }} - {{ $activities->lastItem() }} dari {{ $activities->total() }} aktivitas
                </span>
                {{ $activities->links() }}
            </div>
        @else
            <div class="empty-state">Belum ada aktivitas</div>
        @endif
    </div>

</div>
@endsection
