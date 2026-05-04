@extends('layouts.app')

@section('title', 'Pusat Layanan Pengaduan - Talkyu')

@section('styles')
<style>
    .page-header {
        margin-bottom: 50px;
        text-align: center;
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 200px;
        width: 100%;
    }

    .page-header h1 {
        font-size: 42px;
        font-weight: 800;
        margin-bottom: 15px;
        background: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        width: 100%;
        text-align: center;
    }

    .page-header p {
        color: #4b5563;
        font-size: 18px;
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
        width: 100%;
    }

    .action-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        max-width: 900px;
        margin: 0 auto;
    }

    @media (max-width: 640px) {
        .action-cards {
            grid-template-columns: 1fr;
        }
    }

    .action-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 40px 30px;
        text-align: center;
        border: 1px solid rgba(220, 38, 38, 0.1);
        box-shadow: 0 10px 30px rgba(185, 28, 28, 0.05);
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .action-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(220, 38, 38, 0.12);
        border-color: rgba(220, 38, 38, 0.3);
    }

    .action-icon {
        font-size: 50px;
        margin-bottom: 20px;
        background: #fee2e2;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b91c1c;
    }

    .action-title {
        font-size: 24px;
        font-weight: 700;
        color: #7f1d1d;
        margin-bottom: 10px;
    }

    .action-desc {
        color: #6b7280;
        font-size: 15px;
        line-height: 1.5;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="page-header">
        <h1>Pusat Layanan Pengaduan</h1>
        <p>Selamat datang di layanan pengaduan. Silakan pilih menu di bawah ini untuk membuat aduan baru atau mengecek status aduan Anda.</p>
    </div>

    <div class="action-cards">
        <a href="{{ route('aduan.create') }}" class="action-card">
            <div class="action-icon">
                <svg xmlns="http://www.w3.org/-2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="50" height="50">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <h2 class="action-title">Buat Aduan Baru</h2>
            <p class="action-desc">Sampaikan keluhan, kritik, atau saran terkait perkuliahan dan administrasi akademik.</p>
        </a>

        <a href="{{ route('aduan.history') }}" class="action-card">
            <div class="action-icon">
                <svg xmlns="http://www.w3.org/-2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="50" height="50">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </div>
            <h2 class="action-title">Riwayat Aduan Saya</h2>
            <p class="action-desc">Pantau status perkembangan dan penyelesaian dari aduan-aduan yang telah Anda kirimkan.</p>
        </a>
    </div>
</div>
@endsection
