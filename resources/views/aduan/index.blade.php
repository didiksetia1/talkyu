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
        <p>Pilih menu di bawah ini untuk membuat aduan baru atau melihat aduan yang sudah masuk.</p>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; border: 1px solid #34d399; max-width: 600px; margin: 0 auto;">
            {{ session('success') }}
        </div>
    @endif

    <div class="cards-container">
        <a href="{{ route('aduan.create') }}" class="action-card">
            <div class="icon-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="40" height="40">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                </svg>
            </div>
            <h3>Buat Aduan Baru</h3>
            <p>Sampaikan keluhan, kritik, atau saran terkait perkuliahan dan administrasi akademik.</p>
        </a>

        <a href="{{ route('aduan.history') }}" class="action-card">
            <div class="icon-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="40" height="40">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                </svg>
            </div>
            <h3>Riwayat Aduan Saya</h3>
            <p>Pantau status perkembangan dan penyelesaian dari aduan-aduan yang telah Anda kirimkan.</p>
        </a>
    </div>
</div>
@endsection
