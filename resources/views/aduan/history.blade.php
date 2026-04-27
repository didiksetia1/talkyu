@extends('layouts.app')

@section('title', 'Riwayat Pengaduan Saya - Talkyu')

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
        background: linear-gradient(to right, #b91c1c, #ef4444);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Timeline Styles */
    .aduan-list-card {
        background: rgba(255, 255, 255, 0.7);
        border-radius: 20px;
        padding: 30px 26px;
        border: 1px solid rgba(220, 38, 38, 0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    .timeline {
        position: relative;
        padding-left: 28px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 9px;
        top: 4px;
        bottom: 4px;
        width: 2px;
        background: linear-gradient(to bottom, rgba(239, 68, 68, 0.4), rgba(239, 68, 68, 0.15));
    }

    .timeline-item {
        position: relative;
        margin-bottom: 18px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -28px;
        top: 20px;
        width: 12px;
        height: 12px;
        border-radius: 999px;
        background: #ef4444;
        border: 2px solid #fff;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
    }

    .aduan-item {
        background: white;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(220, 38, 38, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .aduan-item:hover {
        transform: translateX(5px);
        box-shadow: 0 10px 28px rgba(127, 29, 29, 0.08);
    }

    .aduan-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 5px;
    }

    .aduan-title {
        font-weight: 600;
        font-size: 18px;
        color: #b91c1c;
    }

    .aduan-category {
        font-size: 13px;
        font-weight: 600;
        color: #4b5563;
        background: #f3f4f6;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
        margin-bottom: 10px;
    }

    .aduan-status {
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* New Statuses */
    .status-dikirim { background: #e0f2fe; color: #0284c7; }
    .status-ditinjau { background: #fef08a; color: #854d0e; }
    .status-diproses { background: #fed7aa; color: #c2410c; }
    .status-selesai { background: #dcfce7; color: #166534; }

    .aduan-desc {
        color: rgba(127, 29, 29, 0.8);
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .status-progress {
        background: #fff7f7;
        border: 1px solid rgba(220, 38, 38, 0.12);
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 14px;
    }

    .status-progress-title {
        display: block;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #9f1239;
        margin-bottom: 10px;
    }

    .status-step-row {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
        padding-bottom: 10px;
    }

    .status-step-row:last-child {
        padding-bottom: 0;
    }

    .status-step-row:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 6px;
        top: 16px;
        width: 2px;
        height: calc(100% - 2px);
        background: #e5e7eb;
    }

    .status-step-row.done:not(:last-child)::after,
    .status-step-row.current:not(:last-child)::after {
        background: #fb7185;
    }

    .step-dot {
        width: 14px;
        height: 14px;
        border-radius: 999px;
        border: 2px solid #d1d5db;
        background: #ffffff;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .status-step-row.done .step-dot {
        border-color: #e11d48;
        background: #e11d48;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.15);
    }

    .status-step-row.current .step-dot {
        border-color: #e11d48;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.2);
    }

    .step-label {
        font-size: 13px;
        color: #6b7280;
        font-weight: 600;
    }

    .step-text {
        display: flex;
        flex-direction: column;
        gap: 1px;
    }

    .step-date {
        font-size: 11px;
        color: #9ca3af;
    }

    .status-step-row.done .step-date,
    .status-step-row.current .step-date {
        color: #be123c;
    }

    .step-date-missing {
        font-style: italic;
    }

    .status-step-row.done .step-label,
    .status-step-row.current .step-label {
        color: #9f1239;
    }

    .aduan-tanggapan {
        background: #fdf2f8;
        border-left: 4px solid #db2777;
        padding: 12px 15px;
        border-radius: 4px;
        margin-bottom: 15px;
    }

    .tanggapan-label {
        font-weight: 700;
        font-size: 12px;
        color: #be185d;
        margin-bottom: 5px;
        display: block;
        text-transform: uppercase;
    }

    .tanggapan-text {
        font-size: 14px;
        color: #374151;
        line-height: 1.5;
    }

    .aduan-meta {
        font-size: 12px;
        color: rgba(127, 29, 29, 0.5);
    }

    @media (max-width: 640px) {
        .aduan-list-card {
            padding: 20px 16px;
        }

        .timeline {
            padding-left: 22px;
        }

        .timeline-dot {
            left: -22px;
        }

        .aduan-header {
            align-items: flex-start;
            flex-direction: column;
            gap: 8px;
        }
    }

    .btn-back {
        display: inline-block;
        margin-bottom: 20px;
        color: #b91c1c;
        text-decoration: none;
        font-weight: 600;
    }

    .btn-back:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="container">
    <a href="{{ route('aduan.index') }}" class="btn-back">← Kembali ke Halaman Utama Aduan</a>

    <div class="page-header">
        <h1>Riwayat Pengaduan Saya</h1>
    </div>

    <div class="aduan-list-card">
        @forelse($aduans as $aduan)
            @if($loop->first)
                <div class="timeline">
            @endif

            <div class="timeline-item">
                <span class="timeline-dot" aria-hidden="true"></span>
                <div class="aduan-item">
                    <div class="aduan-header">
                        <span class="aduan-title">{{ $aduan->judul }}</span>
                        <span class="aduan-status status-{{ $aduan->status }}">{{ $aduan->status }}</span>
                    </div>
                    <div>
                        <span class="aduan-category">{{ $aduan->kategori }}</span>
                    </div>

                    @php
                        $statusFlow = ['dikirim', 'ditinjau', 'diproses', 'selesai'];
                        $currentStatusIndex = array_search($aduan->status, $statusFlow, true);
                        $statusDates = [
                            'dikirim' => $aduan->created_at,
                            'ditinjau' => $aduan->ditinjau_at,
                            'diproses' => $aduan->diproses_at,
                            'selesai' => $aduan->selesai_at,
                        ];
                        if ($currentStatusIndex === false) {
                            $currentStatusIndex = 0;
                        }
                    @endphp

                    <div class="status-progress" aria-label="Timeline status aduan">
                        <span class="status-progress-title">Timeline Status</span>
                        @foreach($statusFlow as $step)
                            @php
                                $stepIndex = $loop->index;
                                $stepState = $stepIndex < $currentStatusIndex
                                    ? 'done'
                                    : ($stepIndex === $currentStatusIndex ? 'current' : 'todo');
                            @endphp
                            <div class="status-step-row {{ $stepState }}">
                                <span class="step-dot" aria-hidden="true"></span>
                                <div class="step-text">
                                    <span class="step-label">{{ ucfirst($step) }}</span>
                                    @if(!empty($statusDates[$step]))
                                        <span class="step-date">{{ $statusDates[$step]->format('d M Y, H:i') }}</span>
                                    @elseif($stepIndex <= $currentStatusIndex)
                                        <span class="step-date step-date-missing">Tanggal belum tercatat</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <p class="aduan-desc">{{ $aduan->deskripsi }}</p>

                    @if($aduan->tanggapan)
                    <div class="aduan-tanggapan">
                        <span class="tanggapan-label">Tanggapan dari Akademik:</span>
                        <div class="tanggapan-text">{{ $aduan->tanggapan }}</div>
                    </div>
                    @endif

                    <div class="aduan-meta">
                        Dikirim pada: {{ $aduan->created_at->format('d M Y, H:i') }}
                    </div>
                </div>
            </div>

            @if($loop->last)
                </div>
                @endif
        @empty
            <div style="text-align: center; color: rgba(127, 29, 29, 0.6); padding: 30px;">
                Anda belum mengirimkan aduan apapun.
            </div>
        @endforelse
    </div>
</div>
@endsection
