@extends('layouts.app')

@section('title', 'Pusat Layanan Aspirasi - Talkyu')

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
        max-width: 600px;
        margin: 0 auto;
    }

    .cards-container {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 40px;
        flex-wrap: wrap;
    }

    .action-card {
        background: #fff;
        border-radius: 20px;
        padding: 40px 30px;
        width: 100%;
        max-width: 350px;
        text-align: center;
        text-decoration: none;
        color: inherit;
        border: 1px solid rgba(220, 38, 38, 0.1);
        box-shadow: 0 10px 25px rgba(185, 28, 28, 0.05);
        transition: all 0.3s ease;
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(185, 28, 28, 0.1);
        border-color: rgba(220, 38, 38, 0.3);
    }

    .icon-circle {
        width: 80px;
        height: 80px;
        background: #fef2f2;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: #b91c1c;
        font-size: 32px;
    }

    .action-card h3 {
        font-size: 22px;
        font-weight: 700;
        color: #7f1d1d;
        margin-bottom: 15px;
    }

    .action-card p {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.5;
    }
</style>
@endsection

@section('content')
<div class="container" style="padding: 40px 0;">
    <div class="page-header">
        <h1>Pusat Layanan Aspirasi</h1>
        <p>Pilih menu di bawah ini untuk mengirim aspirasi baru atau melihat aspirasi yang sudah masuk.</p>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; border: 1px solid #34d399; max-width: 600px; margin: 0 auto;">
            {{ session('success') }}
        </div>
    @endif

    <div class="cards-container">
        <a href="{{ route('aspirasi.create') }}" class="action-card">
            <div class="icon-circle">
                <i class="fas fa-plus"></i>
            </div>
            <h3>Buat Aspirasi Baru</h3>
            <p>Sampaikan kritik, saran, dan masukan Anda melalui form aspirasi.</p>
        </a>

        <a href="{{ route('aspirasi.list') }}" class="action-card">
            <div class="icon-circle">
                <i class="fas fa-list-ul"></i>
            </div>
            <h3>Lihat Aspirasi</h3>
            <p>Lihat aspirasi yang sudah masuk, termasuk vote, komentar, dan status tindak lanjut.</p>
        </a>
    </div>
</div>
@endsection
