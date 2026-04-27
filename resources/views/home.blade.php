@extends('layouts.app')

@section('title', 'Home - Talkyu')

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #fffdfd 0%, #ffecec 100%);
        color: #7a0f0f;
    }

    .welcome-section {
        background: rgba(255, 255, 255, 0.94);
        border-radius: 20px;
        padding: 40px;
        border: 1px solid rgba(220, 38, 38, 0.12);
        box-shadow: 0 15px 35px rgba(185, 28, 28, 0.12);
        backdrop-filter: blur(10px);
        margin-bottom: 40px;
    }

    .welcome-section h1 {
        font-size: 36px;
        margin-bottom: 10px;
        font-weight: 700;
        background: linear-gradient(to right, #b91c1c, #ef4444);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .welcome-section p {
        color: rgba(127, 29, 29, 0.78);
        font-size: 18px;
        margin-bottom: 20px;
    }

    .user-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-top: 30px;
    }

    .info-card {
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid rgba(220, 38, 38, 0.1);
        padding: 20px;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        background: rgba(255, 245, 245, 1);
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(220, 38, 38, 0.08);
    }

    .info-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #dc2626;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #7f1d1d;
    }

    /* Agenda Widgets Styles */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 30px;
        margin-bottom: 50px;
    }

    @media (max-width: 900px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    .section-title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #7f1d1d;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Latest Agendas grid */
    .latest-agendas {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .agenda-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid rgba(220, 38, 38, 0.12);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .agenda-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(185, 28, 28, 0.1);
        border-color: rgba(220, 38, 38, 0.3);
    }

    .agenda-thumbnail {
        height: 140px;
        width: 100%;
        object-fit: cover;
        background: #fca5a5;
    }

    .agenda-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .agenda-title {
        font-size: 16px;
        font-weight: 600;
        color: #7f1d1d;
        text-decoration: none;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .agenda-title:hover {
        color: #dc2626;
    }

    .agenda-meta {
        font-size: 13px;
        color: rgba(127, 29, 29, 0.6);
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid rgba(220, 38, 38, 0.1);
        padding-top: 12px;
    }

    /* Popular Agenda Widget */
    .popular-widget {
        background: linear-gradient(145deg, #b91c1c, #991b1b);
        border-radius: 20px;
        padding: 25px;
        color: white;
        box-shadow: 0 15px 30px rgba(185, 28, 28, 0.2);
    }

    .popular-widget .section-title {
        color: #fca5a5;
        font-size: 18px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .pop-agenda-title {
        font-size: 20px;
        font-weight: 700;
        color: white;
        text-decoration: none;
        display: block;
        margin-bottom: 15px;
        line-height: 1.4;
    }

    .pop-agenda-title:hover {
        text-decoration: underline;
    }

    .pop-agenda-desc {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .pop-stats {
        display: flex;
        gap: 15px;
        font-size: 14px;
        color: #fca5a5;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="welcome-section">
        <h1>Selamat Datang, {{ auth()->user()->name }}!</h1>
        <p>Anda berada di beranda utama Talkyu. Pantau informasi, agenda terbaru, serta kirim pengaduan dan aspirasi Anda di sini.</p>

        <div class="user-info">
            <div class="info-card">
                <div class="info-label">NIM</div>
                <div class="info-value">{{ auth()->user()->nim }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Fakultas / Jurusan</div>
                <div class="info-value">{{ auth()->user()->jurusan }}</div>
            </div>
            <div class="info-card">
                <div class="info-label">Program Studi</div>
                <div class="info-value">{{ auth()->user()->prodi }}</div>
            </div>
        </div>
    </div>

    <!-- Dashboard Widgets -->
    <div class="dashboard-grid">

        <!-- Left Column: Latest Agendas -->
        <div>
            <h2 class="section-title">📰 Agenda Terkini</h2>
            <div class="latest-agendas">
                @forelse($latestAgendas ?? [] as $agenda)
                    <div class="agenda-card">
                        @if($agenda->image_source)
                            <img src="{{ $agenda->image_source }}" alt="{{ $agenda->title }}" class="agenda-thumbnail">
                        @else
                            <div class="agenda-thumbnail" style="display:flex; align-items:center; justify-content:center; color: #991b1b; font-weight: 500;">No Image</div>
                        @endif
                        <div class="agenda-content">
                            <a href="{{ route('agenda.show', $agenda->id) }}" class="agenda-title">
                                {{ Str::limit($agenda->title, 50) }}
                            </a>
                            <div class="agenda-meta">
                                <span>🗓 {{ $agenda->created_at->format('d M Y') }}</span>
                                <span>❤️ {{ $agenda->likes_count ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="padding: 20px; color: rgba(127, 29, 29, 0.6);">
                        Belum ada agenda terbaru.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Column: Popular & Trending -->
        <div>
            @if(isset($popularAgenda) && $popularAgenda)
            <div class="popular-widget">
                <h2 class="section-title">🔥 Sedang Hangat Dibicarakan</h2>

                <a href="{{ route('agenda.show', $popularAgenda->id) }}" class="pop-agenda-title">
                    {{ $popularAgenda->title }}
                </a>

                <p class="pop-agenda-desc">
                    {{ Str::limit($popularAgenda->content, 100) }}
                </p>

                <div class="pop-stats">
                    <span>❤️ {{ $popularAgenda->likes_count }} Likes</span>
                    <span>💬 {{ $popularAgenda->comments_count }} Komentar</span>
                </div>
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
