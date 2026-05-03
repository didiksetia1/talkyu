@extends('layouts.app')

@section('title', 'Detail Pengaduan - Admin')


{{-- ======================== STYLES ======================== --}}
@section('styles')
<style>

    /* ---- Layout ---- */

    .admin-wrap {
        min-height: 100vh;
        background: #f5f5f3;
        padding: 36px 16px 24px;
    }

    .admin-inner {
        max-width: 700px;
        margin: 0 auto;
        padding-top: 14px;
    }


    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        color: #6b7280;
        text-decoration: none;
        transition: color 0.15s;
    }

    .btn-back:hover {
        color: #1f2937;
    }

    .btn-back svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        fill: none;
        stroke-width: 1.8;
    }


    /* ---- Alert ---- */

    .alert-success {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f0fdf4;
        border: 0.5px solid #bbf7d0;
        border-radius: 10px;
        padding: 10px 14px;
        margin-bottom: 14px;
        font-size: 13px;
        color: #166534;
    }

    .alert-success svg {
        width: 15px;
        height: 15px;
        flex-shrink: 0;
        stroke: #16a34a;
        fill: none;
        stroke-width: 2;
    }


    /* ---- Card ---- */

    .card {
        background: #ffffff;
        border: 0.5px solid rgba(0, 0, 0, 0.08);
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 18px;
    }


    /* ---- Aduan Header ---- */

    .aduan-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }

    .aduan-title {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        line-height: 1.4;
    }

    .badge {
        flex-shrink: 0;
        display: inline-block;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 99px;
        letter-spacing: 0.02em;
        white-space: nowrap;
    }

    .badge-dikirim  { background: #f3f4f6; color: #374151; }
    .badge-ditinjau { background: #eff6ff; color: #1d4ed8; }
    .badge-diproses { background: #fef3c7; color: #92400e; }
    .badge-selesai  { background: #f0fdf4; color: #166534; }


    /* ---- Meta Info ---- */

    .meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding-bottom: 16px;
        border-bottom: 0.5px solid #f3f4f6;
        margin-bottom: 16px;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .meta-label {
        font-size: 10px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .meta-value {
        font-size: 13px;
        font-weight: 500;
        color: #1f2937;
    }


    /* ---- Konten Aduan ---- */

    .section-label {
        font-size: 10px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 8px;
    }

    .desc-box {
        background: #f9fafb;
        border-radius: 8px;
        padding: 12px 14px;
        font-size: 13px;
        color: #374151;
        line-height: 1.6;
        white-space: pre-wrap;
    }

    .aduan-gambar {
        display: block;
        max-width: 100%;
        border-radius: 8px;
        margin-top: 14px;
        border: 0.5px solid rgba(0, 0, 0, 0.08);
    }


    /* ---- Form Tindak Lanjut ---- */

    .form-section-title {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 16px;
    }

    .form-group {
        margin-bottom: 14px;
    }

    .form-group label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 9px 12px;
        background: #f9fafb;
        border: 0.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
        color: #1f2937;
        transition: border-color 0.15s, background 0.15s;
        appearance: none;
        -webkit-appearance: none;
    }

    .form-control:focus {
        outline: none;
        border-color: #b91c1c;
        background: #fff;
    }

    select.form-control {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 16 16' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpath d='M4 6l4 4 4-4'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 32px;
        cursor: pointer;
    }

    textarea.form-control {
        min-height: 90px;
        resize: vertical;
        line-height: 1.5;
    }


    /* ---- Form Actions ---- */

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 16px;
    }

    .btn-cancel {
        padding: 8px 16px;
        background: transparent;
        border: 0.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        color: #6b7280;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: background 0.15s, color 0.15s;
    }

    .btn-cancel:hover {
        background: #f9fafb;
        color: #374151;
    }

    .btn-submit {
        padding: 8px 18px;
        background: #991b1b;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #ffffff;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s;
    }

    .btn-submit:hover {
        background: #7f1d1d;
    }

    .btn-submit svg {
        width: 13px;
        height: 13px;
        stroke: white;
        fill: none;
        stroke-width: 2;
    }

</style>
@endsection


{{-- ======================== CONTENT ======================== --}}
@section('content')
<div class="admin-wrap">
<div class="admin-inner">



    {{-- Alert --}}
    @if (session('success'))
        <div class="alert-success">
            <svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ---- Card: Detail Aduan ---- --}}
    <div class="card">

        <div class="aduan-header">
            <h2 class="aduan-title">{{ $aduan->judul }}</h2>

            @php
                $badgeClass = match($aduan->status) {
                    'ditinjau' => 'badge-ditinjau',
                    'diproses' => 'badge-diproses',
                    'selesai'  => 'badge-selesai',
                    default    => 'badge-dikirim',
                };
                $badgeLabel = match($aduan->status) {
                    'dikirim'  => 'Dikirim',
                    'ditinjau' => 'Ditinjau',
                    'diproses' => 'Diproses',
                    'selesai'  => 'Selesai',
                    default    => ucfirst($aduan->status),
                };
            @endphp

            <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
        </div>

        <div class="meta-row">
            <div class="meta-item">
                <span class="meta-label">Pengirim</span>
                <span class="meta-value">{{ $aduan->user ? $aduan->user->name : 'Anonim' }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Kategori</span>
                <span class="meta-value">{{ $aduan->kategori }}</span>
            </div>
            <div class="meta-item">
                <span class="meta-label">Tanggal</span>
                <span class="meta-value">{{ $aduan->created_at->format('d M Y, H:i') }}</span>
            </div>
        </div>

        <div class="section-label">Deskripsi Keluhan</div>
        <div class="desc-box">{{ $aduan->deskripsi }}</div>

        @if ($aduan->gambar)
            <div class="section-label" style="margin-top: 16px;">Bukti Lampiran</div>
            <img src="{{ asset('storage/' . $aduan->gambar) }}" alt="Bukti Foto" class="aduan-gambar">
        @endif

    </div>


    {{-- ---- Card: Tindak Lanjut ---- --}}
    <div class="card">

        <p class="form-section-title">Tindak Lanjut & Tanggapan</p>

        <form action="{{ route('admin.aduan.update', $aduan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="status">Status Aduan</label>
                <select id="status" name="status" class="form-control">
                    <option value="dikirim"  {{ $aduan->status == 'dikirim'  ? 'selected' : '' }}>Dikirim</option>
                    <option value="ditinjau" {{ $aduan->status == 'ditinjau' ? 'selected' : '' }}>Ditinjau</option>
                    <option value="diproses" {{ $aduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai"  {{ $aduan->status == 'selesai'  ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tanggapan">Tanggapan Admin</label>
                <textarea id="tanggapan" name="tanggapan" class="form-control"
                    placeholder="Tuliskan jawaban resmi terkait aduan ini...">{{ $aduan->tanggapan }}</textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.aduan.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">
                    <svg viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>
</div>
@endsection