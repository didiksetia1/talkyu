@extends('layouts.app')

@section('title', 'Buat Pengaduan Baru - Talkyu')

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

    .page-header p {
        color: rgba(127, 29, 29, 0.78);
        font-size: 16px;
    }

    .form-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .aduan-form-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 30px;
        border: 1px solid rgba(220, 38, 38, 0.12);
        backdrop-filter: blur(10px);
        box-shadow: 0 10px 25px rgba(185, 28, 28, 0.05);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #7f1d1d;
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border-radius: 10px;
        border: 1px solid rgba(220, 38, 38, 0.2);
        background: rgba(255, 255, 255, 0.8);
        color: #7f1d1d;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        outline: none;
        border-color: #dc2626;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
        background: #fff;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .btn-submit {
        background: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%);
        color: white;
        border: none;
        padding: 14px 24px;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(220, 38, 38, 0.2);
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
        <h1>Buat Pengaduan</h1>
        <p>Sampaikan keluhan dan aduan Anda secara rinci agar segera dapat diproses.</p>
    </div>

    <div class="form-container">
        <div class="aduan-form-card">
            <form action="{{ route('aduan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Perkuliahan">Perkuliahan</option>
                        <option value="Penilaian & Nilai">Penilaian & Nilai</option>
                        <option value="Dosen & Pengajar">Dosen & Pengajar</option>
                        <option value="Administrasi Akademik">Administrasi Akademik</option>
                        <option value="Etika & Pelanggaran akademik">Etika & Pelanggaran akademik</option>
                        <option value="Bimbingan & Skripsi">Bimbingan & Skripsi</option>
                    </select>
                    @error('kategori') <span style="color:#dc2626; font-size:13px">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="judul">Topik / Judul Aduan</label>
                    <input type="text" id="judul" name="judul" class="form-control" required placeholder="Contoh: AC Kelas Rusak">
                    @error('judul') <span style="color:#dc2626; font-size:13px">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi Detail</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" required placeholder="Jelaskan secara detail mengenai aduan Anda..."></textarea>
                    @error('deskripsi') <span style="color:#dc2626; font-size:13px">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="gambar">Bukti Foto (Opsional)</label>
                    <input type="file" id="gambar" name="gambar" class="form-control" accept="image/*">
                    @error('gambar') <span style="color:#dc2626; font-size:13px">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-submit">Kirim Pengaduan</button>
            </form>
        </div>
    </div>
</div>
@endsection
