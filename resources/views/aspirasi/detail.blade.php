@extends('layouts.app')

@section('title', 'Detail Aspirasi - Talkyu')

@section('styles')
<style>
    .page-header {
        margin-bottom: 30px;
    }

    .aspirasi-card {
        background: white;
        border-radius: 12px;
        padding: 30px;
        border: 1px solid rgba(220, 38, 38, 0.1);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 30px;
    }

    .aspirasi-title {
        font-size: 24px;
        font-weight: 700;
        color: #7f1d1d;
        margin-bottom: 15px;
    }

    .aspirasi-meta {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 25px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        padding-bottom: 15px;
        border-bottom: 1px solid #e5e7eb;
    }

    .section-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .aspirasi-text {
        font-size: 15px;
        color: #374151;
        line-height: 1.6;
        background: #f9fafb;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .btn-back {
        display: inline-block;
        margin-bottom: 20px;
        color: #b91c1c;
        text-decoration: none;
        font-weight: 600;
    }

    .bem-response {
        background: #f0fdf4;
        border-left: 4px solid #10b981;
        padding: 20px;
        border-radius: 0 8px 8px 0;
        margin-top: 30px;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .lampiran-box {
        margin-top: 20px;
        padding: 15px;
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        background: #fdfcfc;
    }
</style>
@endsection

@section('content')
<div class="container" style="padding: 40px 0; max-width: 900px; margin: 0 auto;">
    <a href="{{ route('aspirasi.list') }}" class="btn-back">← Kembali ke Daftar Aspirasi</a>

    <div class="aspirasi-card">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px;">
            <div class="aspirasi-title">{{ $aspirasi->judul ?? 'Tanpa Judul' }}</div>
            <span class="status-badge" style="background: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5;">{{ str_replace('_', ' ', $aspirasi->status) }}</span>
        </div>
        
        <div class="aspirasi-meta">
            <span>📁 Kategori: {{ App\Models\Aspirasi::CATEGORIES[$aspirasi->kategori] ?? $aspirasi->kategori }}</span>
            <span>👤 {{ $aspirasi->is_anonim ? 'Anonymous' : ($aspirasi->user?->name ?? 'Anonymous') }}</span>
            <span>📅 {{ $aspirasi->created_at->format('d M Y, H:i') }}</span>
            <span>👍 {{ $aspirasi->votes_count }} Votes</span>
        </div>

        <div class="section-title">Deskripsi Aspirasi</div>
        <div class="aspirasi-text">
            {{ $aspirasi->deskripsi }}
        </div>

        @if($aspirasi->tujuan_manfaat)
            <div class="section-title">Tujuan/Manfaat</div>
            <div class="aspirasi-text">
                {{ $aspirasi->tujuan_manfaat }}
            </div>
        @endif

        @if($aspirasi->lampiran)
            <div class="lampiran-box">
                <div class="section-title" style="margin-bottom: 5px;">📎 Lampiran Tersedia</div>
                <a href="{{ Storage::url($aspirasi->lampiran) }}" target="_blank" style="color: #b91c1c; font-weight: 600; text-decoration: none;">Lihat File Lampiran</a>
            </div>
        @endif

        @if($aspirasi->bem_response)
            <div class="bem-response">
                <div style="font-weight: bold; color: #065f46; margin-bottom: 10px;">📢 Tanggapan BEM:</div>
                <div style="color: #064e3b; line-height: 1.6;">{{ $aspirasi->bem_response }}</div>
            </div>
        @endif

        <div style="margin-top: 30px; display: flex; justify-content: flex-end;">
            <button id="like-btn" onclick="toggleLike()" style="background: white; border: 1px solid #d1d5db; padding: 10px 20px; border-radius: 20px; cursor: pointer; font-weight: 600; display: flex; align-items: center; gap: 8px; transition: all 0.2s;">
                <span id="like-icon">👍</span> Dukung (<span id="vote-count">{{ $aspirasi->votes_count }}</span>)
            </button>
        </div>
    </div>

    <!-- Comments Section -->
    <div class="aspirasi-card" style="margin-top: 20px;">
        <div class="section-title" style="margin-bottom: 20px; font-size: 18px;">Komentar ({{ $aspirasi->comments_count }})</div>
        
        @auth
        <div class="comment-form" style="margin-bottom: 30px;">
            <form onsubmit="submitComment(event)">
                <textarea id="comment-text" placeholder="Tulis tanggapan atau komentar Anda..." style="width: 100%; padding: 15px; border-radius: 8px; border: 1px solid #d1d5db; min-height: 100px; margin-bottom: 10px; font-family: inherit; font-size: 14px; resize: vertical;"></textarea>
                <div style="display: flex; justify-content: flex-end;">
                    <button type="submit" style="background: #b91c1c; color: white; padding: 10px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s;">Kirim Komentar</button>
                </div>
            </form>
        </div>
        @else
        <div style="margin-bottom: 30px; padding: 15px; background: #f9fafb; border-radius: 8px; text-align: center; border: 1px dashed #d1d5db;">
            Silakan <a href="{{ route('login') }}" style="color: #b91c1c; font-weight: bold; text-decoration: none;">Login</a> untuk ikut berdiskusi dan memberikan komentar.
        </div>
        @endauth

        <div class="comments-list">
            @forelse($comments as $comment)
                <div class="comment-item" style="padding: 15px 0; border-bottom: 1px solid #e5e7eb;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                        <div style="font-weight: 600; color: #1f2937;">{{ $comment->user_name ?? 'Mahasiswa' }}</div>
                        <div style="font-size: 12px; color: #9ca3af;">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</div>
                    </div>
                    <div style="font-size: 14px; color: #4b5563; line-height: 1.5;">{{ $comment->text }}</div>
                </div>
            @empty
                <div style="text-align: center; color: #6b7280; padding: 30px 0;">
                    Belum ada komentar. Jadilah yang pertama memberikan tanggapan!
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function toggleLike() {
        @auth
        const btn = document.getElementById('like-btn');
        btn.style.opacity = '0.7';
        btn.style.pointerEvents = 'none';

        fetch("{{ route('aspirasi.vote', $aspirasi->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            btn.style.opacity = '1';
            btn.style.pointerEvents = 'auto';
            if (data.success) {
                let countEl = document.getElementById('vote-count');
                let count = parseInt(countEl.innerText);
                if (data.message === 'Vote added') {
                    countEl.innerText = count + 1;
                    btn.style.borderColor = '#b91c1c';
                    btn.style.color = '#b91c1c';
                    btn.style.background = '#fef2f2';
                } else {
                    countEl.innerText = count - 1;
                    btn.style.borderColor = '#d1d5db';
                    btn.style.color = 'inherit';
                    btn.style.background = 'white';
                }
            }
        })
        .catch(err => {
            btn.style.opacity = '1';
            btn.style.pointerEvents = 'auto';
            console.error(err);
        });
        @else
        alert('Silakan login terlebih dahulu untuk menyukai aspirasi.');
        window.location.href = "{{ route('login') }}";
        @endauth
    }

    function submitComment(e) {
        e.preventDefault();
        const textInput = document.getElementById('comment-text');
        const text = textInput.value;
        const submitBtn = e.target.querySelector('button[type="submit"]');

        if (!text.trim()) return;

        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Mengirim...';

        fetch("{{ route('aspirasi.comment', $aspirasi->id) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ comment: text })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal mengirim komentar.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Kirim Komentar';
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Kirim Komentar';
        });
    }
</script>
@endsection
