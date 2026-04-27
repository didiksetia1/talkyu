@extends('layouts.app')

@section('title', 'Admin - Edit Agenda')

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

    .form-card {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(220, 38, 38, 0.1);
    }

    .form-title {
        font-size: 24px;
        color: #7f1d1d;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 18px;
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
        font-size: 14px;
    }

    .form-control:focus {
        outline: none;
        border-color: #b91c1c;
    }

    textarea.form-control {
        min-height: 180px;
        resize: vertical;
    }

    .error-text {
        color: #dc2626;
        font-size: 13px;
        margin-top: 6px;
    }

    .btn-submit {
        background: #ef4444;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 12px 24px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-submit:hover {
        background: #dc2626;
    }

    .preview {
        margin-top: 15px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        max-height: 220px;
        object-fit: cover;
        width: 100%;
    }
</style>
@endsection

@section('content')
<div class="admin-container">
    <a href="{{ route('admin.agenda.index') }}" class="btn-back">← Kembali ke Daftar Agenda</a>

    <div class="form-card">
        <h1 class="form-title">Edit Postingan Agenda</h1>

        <form action="{{ route('admin.agenda.update', $agenda->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $agenda->title) }}" required>
                @error('title')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Kategori</label>
                <select id="category" name="category" class="form-control" required>
                    <option value="">Pilih kategori agenda</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ old('category', $agenda->category) === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                @error('category')
                    <div class="error-text">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group">
                <label for="image">Upload Gambar Baru (Opsional)</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/png,image/jpeg,image/jpg,image/webp">
                @error('image')
                    <div class="error-text">{{ $message }}</div>
                @enderror

                @if($agenda->image_source)
                    <img src="{{ $agenda->image_source }}" alt="Preview {{ $agenda->title }}" class="preview">
                @endif
            </div>

            <div class="form-group">
                <label for="content">Isi Konten</label>
                <textarea id="content" name="content" class="form-control" required>{{ old('content', $agenda->content) }}</textarea>
                @error('content')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
