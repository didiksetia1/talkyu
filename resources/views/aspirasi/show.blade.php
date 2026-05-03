@extends('layouts.app')

@section('title', 'Buat Aspirasi Baru - Talkyu')

@section('styles')
<style>
    .page-header {
        margin: 0 auto 40px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        max-width: 800px;
        width: 100%;
    }

    .page-header h1 {
        font-size: 36px;
        font-weight: 700;
        margin: 0;
        background: linear-gradient(to right, #b91c1c, #ef4444);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        width: 100%;
        text-align: center;
    }

    .page-header p {
        color: rgba(127, 29, 29, 0.78);
        font-size: 16px;
        max-width: 640px;
        margin: 0 auto;
        width: 100%;
        text-align: center;
    }

    .form-container {
        max-width: 800px;
        margin: 30px auto 0;
        padding-top: 0;
    }

    .aspirasi-form-card {
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

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }

    .checkbox-group input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
        accent-color: #b91c1c;
    }

    .checkbox-group label {
        margin-bottom: 0;
        cursor: pointer;
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
<div class="container" style="padding: 40px 0;">
    <a href="{{ route('aspirasi.home') }}" class="btn-back">← Kembali ke Pusat Layanan</a>

    <div class="page-header">
        <h1>Buat Aspirasi</h1>
        <p>Sampaikan aspirasi Anda secara detail agar segera dapat diproses.</p>
    </div>

    <div class="form-container">
        <div class="aspirasi-form-card">
            


            <form action="{{ route('aspirasi.store', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="judul">Judul</label>
                    <input type="text" id="judul" name="judul" class="form-control" value="{{ old('judul') }}" required placeholder="Contoh: Penambahan WiFi di parkiran">
                    @error('judul') <span style="color:#dc2626; font-size:13px">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach(\App\Models\Aspirasi::CATEGORIES as $key => $label)
                            <option value="{{ $key }}" {{ old('kategori') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <span style="color:#dc2626; font-size:13px">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control" required placeholder="Jelaskan aspirasi Anda secara detail...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <span style="color:#dc2626; font-size:13px">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="tujuan_manfaat">Tujuan/Manfaat</label>
                    <textarea id="tujuan_manfaat" name="tujuan_manfaat" class="form-control" placeholder="Jelaskan tujuan atau manfaat dari aspirasi ini...">{{ old('tujuan_manfaat') }}</textarea>
                    @error('tujuan_manfaat') <span style="color:#dc2626; font-size:13px">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="lampiran">Lampiran (Opsional)</label>
                    <input type="file" id="lampiran" name="lampiran" class="form-control" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                    <small style="color:#6b7280; display:block; margin-top:5px;">Maksimal ukuran file 5MB.</small>
                    @error('lampiran') <span style="color:#dc2626; font-size:13px">{{ $message }}</span> @enderror
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="anonim" name="anonim" value="1" {{ old('anonim') ? 'checked' : '' }}>
                    <label for="anonim">Kirim sebagai Anonim</label>
                </div>

                <button type="submit" class="btn-submit">Kirim Aspirasi</button>
            </form>
        </div>
    </div>
</div>
@endsection
