@extends('layouts.app')

@section('title', 'Detail Pengaduan - Admin')

@section('styles')
<style>
    .admin-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }

    .btn-back {
        display: inline-block;
        margin-bottom: 20px;
        color: #b91c1c;
        text-decoration: none;
        font-weight: 600;
    }

    .detail-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border: 1px solid rgba(220, 38, 38, 0.1);
        margin-bottom: 30px;
    }

    .detail-header {
        border-bottom: 1px solid #f3f4f6;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .detail-title {
        font-size: 24px;
        color: #7f1d1d;
        margin-bottom: 10px;
    }

    .meta-data {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .aduan-desc {
        background: #f9fafb;
        padding: 20px;
        border-radius: 8px;
        line-height: 1.6;
        color: #374151;
        margin-bottom: 20px;
        white-space: pre-wrap;
    }

    .aduan-gambar {
        max-width: 100%;
        border-radius: 8px;
        margin-top: 15px;
        border: 1px solid #e5e7eb;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #374151;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background: #fff;
    }

    .form-control:focus {
        outline: none;
        border-color: #b91c1c;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .btn-submit {
        background: #ef4444;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-submit:hover {
        background: #dc2626;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #bbf7d0;
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <a href="{{ route('admin.aduan.index') }}" class="btn-back">← Kembali ke Daftar Aduan</a>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="detail-card">
        <div class="detail-header">
            <h1 class="detail-title">{{ $aduan->judul }}</h1>
            <div class="meta-data"><strong>Pengirim:</strong> {{ $aduan->user ? $aduan->user->name : 'Anonim' }}</div>
            <div class="meta-data"><strong>Kategori:</strong> {{ $aduan->kategori }}</div>
            <div class="meta-data"><strong>Tanggal Kirim:</strong> {{ $aduan->created_at->format('d M Y, H:i') }}</div>
        </div>

        <h4>Deskripsi Keluhan:</h4>
        <div class="aduan-desc">{{ $aduan->deskripsi }}</div>

        @if($aduan->gambar)
            <h4>Bukti Lampiran:</h4>
            <img src="{{ asset('storage/' . $aduan->gambar) }}" alt="Bukti Foto" class="aduan-gambar">
        @endif
    </div>

    <!-- Form Update Status & Tanggapan -->
    <div class="detail-card">
        <h3 style="color:#7f1d1d; margin-bottom: 20px;">Tindak Lanjut & Tanggapan</h3>
        <form action="{{ route('admin.aduan.update', $aduan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="status">Ubah Status Aduan</label>
                <select id="status" name="status" class="form-control">
                    <option value="dikirim" {{ $aduan->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                    <option value="ditinjau" {{ $aduan->status == 'ditinjau' ? 'selected' : '' }}>Ditinjau</option>
                    <option value="diproses" {{ $aduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ $aduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="form-group">
                <label for="tanggapan">Balasan / Tanggapan Admin (Disampaikan ke Pengirim)</label>
                <textarea id="tanggapan" name="tanggapan" class="form-control" placeholder="Tuliskan jawaban resmi terkait aduan ini...">{{ $aduan->tanggapan }}</textarea>
            </div>

            <button type="submit" class="btn-submit">Simpan Pembaruan</button>
        </form>
    </div>
</div>
@endsection
