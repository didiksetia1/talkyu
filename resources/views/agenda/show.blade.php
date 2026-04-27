<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $agenda->title }} - Agenda Talkyu</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #fffdfd 0%, #ffecec 100%);
            color: #7a0f0f;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .ambient-circle {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
            pointer-events: none;
        }
        .circle-1 {
            width: 500px;
            height: 500px;
            background: rgba(220, 38, 38, 0.14);
            top: -100px;
            right: -100px;
        }
        .circle-2 {
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.72);
            bottom: -50px;
            left: -100px;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 25px;
            color: rgba(127, 29, 29, 0.72);
            text-decoration: none;
            font-size: 15px;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #dc2626;
        }

        .blog-header {
            margin-bottom: 30px;
        }

        .blog-title {
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.3;
            color: #7f1d1d;
        }

        .blog-meta {
            color: rgba(127, 29, 29, 0.68);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .blog-category {
            display: inline-block;
            margin-bottom: 14px;
            font-size: 12px;
            font-weight: 700;
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
            border-radius: 999px;
            padding: 5px 12px;
        }

        .blog-cover {
            width: 100%;
            height: auto;
            max-height: 450px;
            object-fit: cover;
            border-radius: 20px;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(185, 28, 28, 0.16);
        }

        .blog-content {
            font-size: 18px;
            line-height: 1.7;
            color: rgba(127, 29, 29, 0.86);
            margin-bottom: 50px;
        }

        /* Action Bar (Like Section) */
        .action-bar {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px 0;
            border-top: 1px solid rgba(220, 38, 38, 0.12);
            border-bottom: 1px solid rgba(220, 38, 38, 0.12);
            margin-bottom: 40px;
        }

        .btn-like {
            background: rgba(220, 38, 38, 0.08);
            border: 1px solid rgba(220, 38, 38, 0.22);
            color: #b91c1c;
            padding: 10px 20px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-like:hover {
            background: rgba(220, 38, 38, 0.14);
            transform: scale(1.05);
        }

        .btn-like.liked {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: #fff;
        }

        .likes-count {
            font-size: 16px;
            color: rgba(127, 29, 29, 0.72);
        }

        /* Comments Section */
        .comments-section {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            border: 1px solid rgba(220, 38, 38, 0.12);
            backdrop-filter: blur(10px);
        }

        .comments-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .comment-form {
            margin-bottom: 40px;
        }

        .comment-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid rgba(220, 38, 38, 0.18);
            padding: 15px;
            border-radius: 12px;
            color: #7f1d1d;
            font-family: inherit;
            font-size: 15px;
            resize: vertical;
            min-height: 100px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .comment-input:focus {
            outline: none;
            border-color: #dc2626;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
        }

        .btn-comment {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-comment:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 38, 38, 0.28);
        }

        .comment-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .comment-item {
            padding: 20px;
            background: rgba(255, 245, 245, 1);
            border-radius: 12px;
            border: 1px solid rgba(220, 38, 38, 0.08);
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .comment-author {
            font-weight: 600;
            color: #b91c1c;
        }

        .comment-date {
            font-size: 12px;
            color: rgba(127, 29, 29, 0.55);
        }

        .comment-text {
            color: rgba(127, 29, 29, 0.82);
            line-height: 1.5;
            font-size: 15px;
        }
    </style>
</head>
<body>

    <div class="ambient-circle circle-1"></div>
    <div class="ambient-circle circle-2"></div>

    @include('layouts.navbar')

    <div class="container">
        <a href="{{ route('agenda.index') }}" class="back-link">&larr; Kembali ke Daftar Agenda</a>

        @if(session('success_like'))
            <div style="background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.22); color: #b91c1c; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                {{ session('success_like') }}
            </div>
        @endif

        <div class="blog-header">
            @if($agenda->category)
                <span class="blog-category">{{ $agenda->category }}</span>
            @endif
            <h1 class="blog-title">{{ $agenda->title }}</h1>
            <div class="blog-meta">
                <span>📅 Dipublikasikan pada {{ $agenda->created_at->format('d M Y') }}</span>
            </div>
        </div>

        @if($agenda->image_source)
            <img src="{{ $agenda->image_source }}" alt="{{ $agenda->title }}" class="blog-cover">
        @endif

        <div class="blog-content">
            {!! nl2br(e($agenda->content)) !!}
        </div>

        <div class="action-bar">
            <form action="{{ route('agenda.like', $agenda->id) }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-like {{ $userLiked ? 'liked' : '' }}">
                    @if($userLiked) ❤️ Disukai @else 🤍 Suka @endif
                </button>
            </form>
            <span class="likes-count">{{ $agenda->likes_count }} orang menyukai ini</span>
        </div>

        <div class="comments-section">
            <h2 class="comments-title">Komentar ({{ $agenda->comments->count() }})</h2>

            @if(session('success'))
                    <div style="background: rgba(220, 38, 38, 0.08); border: 1px solid rgba(220, 38, 38, 0.22); color: #b91c1c; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('agenda.comment', $agenda->id) }}" method="POST" class="comment-form">
                @csrf
                <textarea name="content" class="comment-input" placeholder="Tulis komentar Anda di sini..." required></textarea>
                @error('content')
                    <div style="color: #dc2626; font-size: 13px; margin-top: -10px; margin-bottom: 10px;">{{ $message }}</div>
                @enderror
                <button type="submit" class="btn-comment">Kirim Komentar</button>
            </form>

            <div class="comment-list">
                @forelse($agenda->comments as $comment)
                    <div class="comment-item">
                        <div class="comment-header">
                            <span class="comment-author">{{ $comment->user->name }}</span>
                            <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="comment-text">
                            {{ $comment->content }}
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; color: rgba(127,29,29,0.58); padding: 20px;">
                        Belum ada komentar. Jadilah yang pertama berkomentar!
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</body>
</html>
