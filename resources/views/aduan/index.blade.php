@extends('layouts.app')

@section('title', 'Pusat Layanan Pengaduan - Talkyu')

@section('styles')
<style>
    .page-header {
        margin-bottom: 40px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
        width: 100%;
    }

    .page-header h1 {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 20px;
        color: #b91c1c;
        letter-spacing: -0.5px;
        width: 100%;
        text-align: center;
    }

    .page-header p {
        color: #4b5563;
        font-size: 16px;
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
        width: 100%;
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
        <h1>Pusat Layanan Pengaduan</h1>
        <p>Selamat datang di layanan pengaduan. Silakan pilih menu di bawah ini untuk membuat aduan baru atau mengecek status aduan Anda.</p>
    </div>

    <div class="cards-container">
        <a href="{{ route('aduan.create') }}" class="action-card">
            <div class="icon-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="40" height="40">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <h3>Buat Aduan Baru</h3>
            <p>Sampaikan keluhan, kritik, atau saran terkait perkuliahan dan administrasi akademik.</p>
        </a>

        <a href="{{ route('aduan.history') }}" class="action-card">
            <div class="icon-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="40" height="40">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <h3>Riwayat Aduan Saya</h3>
            <p>Pantau status perkembangan dan penyelesaian dari aduan-aduan yang telah Anda kirimkan.</p>
        </a>
    </div>
</div>
@endsection