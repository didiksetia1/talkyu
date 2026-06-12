@extends('layouts.app')

@section('title', 'Admin - Kelola BEM')
@section('page_title', 'Kelola BEM')

@section('styles')
<style>
    .admin-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
        margin-top: 30px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
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

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #10b981;
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-add:hover {
        background: #059669;
    }

    .btn-add svg {
        width: 16px;
        height: 16px;
    }

    /* Table */
    .table-wrapper {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: #f9fafb;
    }

    th {
        padding: 12px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e5e7eb;
    }

    td {
        padding: 12px 16px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover td {
        background: #f9fafb;
    }

    .role-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #dbeafe;
        color: #1e40af;
    }

    .action-btns {
        display: flex;
        gap: 6px;
    }

    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 10px;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 500;
        text-decoration: none;
        transition: background 0.2s;
    }

    .btn-edit:hover {
        background: #2563eb;
    }

    .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 10px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 11px;
        font-weight: 500;
        transition: background 0.2s;
    }

    .btn-delete:hover {
        background: #dc2626;
    }

    .btn-edit svg,
    .btn-delete svg {
        width: 14px;
        height: 14px;
    }

    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal {
        background: white;
        border-radius: 8px;
        padding: 24px;
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-header h2 {
        font-size: 18px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .btn-close {
        background: none;
        border: none;
        font-size: 24px;
        color: #9ca3af;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }

    .btn-close:hover {
        color: #374151;
    }

    .form-group {
        margin-bottom: 14px;
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

    .form-buttons {
        display: flex;
        gap: 8px;
        margin-top: 20px;
    }

    .btn-submit {
        background: #10b981;
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
        background: #059669;
    }

    .btn-cancel {
        background: #e5e7eb;
        color: #374151;
        padding: 8px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 500;
    }

    .btn-cancel:hover {
        background: #d1d5db;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #9ca3af;
        font-size: 14px;
    }

    .alert-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        padding: 10px 16px;
        border-radius: 6px;
        margin-bottom: 16px;
        font-size: 13px;
    }

    .alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 10px 16px;
        border-radius: 6px;
        margin-bottom: 16px;
        font-size: 13px;
    }

    .pagination-wrapper {
        margin-top: 20px;
    }
</style>
@endsection

@section('content')
<div class="admin-container">

    {{-- Header --}}
    <div class="page-header">
        <h1>Kelola Akun BEM</h1>
        <button class="btn-add" onclick="openModal()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Tambah BEM
        </button>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert-error">{{ session('error') }}</div>
    @endif

    {{-- Table --}}
    @if($bems->count() > 0)
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Email</th>
                    <th>Jurusan</th>
                    <th>Prodi</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bems as $index => $bem)
                <tr>
                    <td>{{ $bems->firstItem() + $index }}</td>
                    <td><strong>{{ $bem->name }}</strong></td>
                    <td>{{ $bem->nim }}</td>
                    <td>{{ $bem->email }}</td>
                    <td>{{ $bem->jurusan ?? '-' }}</td>
                    <td>{{ $bem->prodi ?? '-' }}</td>
                    <td><span class="role-badge">{{ strtoupper($bem->role) }}</span></td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.bem.edit', $bem->id) }}" class="btn-edit">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.bem.destroy', $bem->id) }}" method="POST" onsubmit="return confirm('Yakin hapus akun BEM ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-wrapper">
        {{ $bems->links() }}
    </div>
    @else
    <div class="table-wrapper">
        <div class="empty-state">
            <p>Belum ada akun BEM. Klik "Tambah BEM" untuk menambahkan.</p>
        </div>
    </div>
    @endif

    {{-- Modal Tambah BEM --}}
    <div id="modal-add" class="modal-overlay" onclick="closeModalOutside(event)">
        <div class="modal">
            <div class="modal-header">
                <h2>Tambah Akun BEM</h2>
                <button class="btn-close" onclick="closeModal()">&times;</button>
            </div>

            <form action="{{ route('admin.bem.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nama Lengkap *</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                    @error('name')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="nim">NIM *</label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim') }}" required>
                    @error('nim')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                    @error('email')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" value="{{ old('jurusan') }}">
                    @error('jurusan')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="prodi">Prodi</label>
                    <input type="text" name="prodi" id="prodi" value="{{ old('prodi') }}">
                    @error('prodi')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" name="password" id="password" required>
                    @error('password')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn-submit">Simpan</button>
                    <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    function openModal() {
        document.getElementById('modal-add').classList.add('active');
    }

    function closeModal() {
        document.getElementById('modal-add').classList.remove('active');
    }

    function closeModalOutside(event) {
        if (event.target.classList.contains('modal-overlay')) {
            closeModal();
        }
    }

    // Auto-open modal if there are validation errors
    @if($errors->any() && !session('edit_mode'))
    document.addEventListener('DOMContentLoaded', function() {
        openModal();
    });
    @endif
</script>
@endsection
