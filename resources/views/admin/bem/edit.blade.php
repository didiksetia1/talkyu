@extends('layouts.app')

@section('title', 'Admin - Edit BEM')
@section('page_title', 'Edit Akun BEM')

@section('styles')
<style>
    .admin-container {
        max-width: 540px;
        margin: 0 auto;
        padding: 20px;
        margin-top: 30px;
    }

    .page-header {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e5e7eb;
    }

    .page-header h1 {
        font-size: 24px;
        color: #1f2937;
        margin: 0;
        font-weight: 600;
    }

    .form-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 24px;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #374151;
        margin-bottom: 5px;
    }

    .form-group input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-size: 14px;
        font-family: inherit;
    }

    .form-group input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-error {
        color: #ef4444;
        font-size: 12px;
        margin-top: 4px;
    }

    .form-hint {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 3px;
    }

    .form-buttons {
        display: flex;
        gap: 8px;
        margin-top: 24px;
    }

    .btn-submit {
        background: #3b82f6;
        color: white;
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        transition: background 0.2s;
    }

    .btn-submit:hover {
        background: #2563eb;
    }

    .btn-back {
        background: #e5e7eb;
        color: #374151;
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
    }

    .btn-back:hover {
        background: #d1d5db;
    }
</style>
@endsection

@section('content')
<div class="admin-container">

    <div class="page-header">
        <h1>Edit Akun BEM</h1>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.bem.update', $bem->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Lengkap *</label>
                <input type="text" name="name" id="name" value="{{ old('name', $bem->name) }}" required>
                @error('name')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="nim">NIM *</label>
                <input type="text" name="nim" id="nim" value="{{ old('nim', $bem->nim) }}" required>
                @error('nim')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email', $bem->email) }}" required>
                @error('email')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="jurusan">Jurusan</label>
                <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan', $bem->jurusan) }}">
                @error('jurusan')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="prodi">Prodi</label>
                <input type="text" name="prodi" id="prodi" value="{{ old('prodi', $bem->prodi) }}">
                @error('prodi')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" name="password" id="password">
                <div class="form-hint">Kosongkan jika tidak ingin mengubah password</div>
                @error('password')<div class="form-error">{{ $message }}</div>@enderror
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
                <a href="{{ route('admin.bem.index') }}" class="btn-back">Kembali</a>
            </div>
        </form>
    </div>

</div>
@endsection
