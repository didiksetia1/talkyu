<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda - Talkyu</title>
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
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

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

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 30px;
        }

        .blog-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(220, 38, 38, 0.12);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(185, 28, 28, 0.14);
            background: rgba(255, 245, 245, 1);
        }

        .blog-cover {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid rgba(220, 38, 38, 0.12);
        }

        .blog-content {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .blog-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 15px;
            line-height: 1.4;
            color: #7f1d1d;
            text-decoration: none;
        }

        .blog-title:hover {
            color: #dc2626;
        }

        .blog-category {
            display: inline-block;
            margin-bottom: 10px;
            font-size: 11px;
            font-weight: 700;
            background: #fff1f2;
            color: #be123c;
            border: 1px solid #fecdd3;
            border-radius: 999px;
            padding: 4px 10px;
        }

        .blog-excerpt {
            color: rgba(127, 29, 29, 0.72);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 25px;
            flex-grow: 1;
        }

        .blog-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid rgba(220, 38, 38, 0.12);
            color: rgba(127, 29, 29, 0.62);
            font-size: 14px;
        }

        .blog-stats {
            display: flex;
            gap: 15px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .read-more {
            color: #dc2626;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .read-more:hover {
            color: #b91c1c;
        }
    </style>
</head>
<body>

    <div class="ambient-circle circle-1"></div>
    <div class="ambient-circle circle-2"></div>

    @include('layouts.navbar')

    <div class="container">
        <div class="page-header">
            <h1>Agenda & Berita</h1>
            <p>Jelajahi informasi acara dan berita terbaru seputar kampus.</p>
        </div>

        <div class="blog-grid">
            @forelse($agendas as $agenda)
                <div class="blog-card">
                    @if($agenda->image_source)
                        <img src="{{ $agenda->image_source }}" alt="{{ $agenda->title }}" class="blog-cover">
                    @else
                        <div class="blog-cover" style="background: rgba(0,0,0,0.2); display: flex; center; align-items: center; justify-content: center;">No Image</div>
                    @endif

                    <div class="blog-content">
                        @if($agenda->category)
                            <span class="blog-category">{{ $agenda->category }}</span>
                        @endif
                        <a href="{{ route('agenda.show', $agenda->id) }}" class="blog-title">{{ $agenda->title }}</a>
                        <p class="blog-excerpt">{{ Str::limit($agenda->content, 120) }}</p>

                        <div class="blog-footer">
                            <span class="date">{{ $agenda->created_at->format('d M Y') }}</span>
                            <div class="blog-stats">
                                <span class="stat-item">❤️ {{ $agenda->likes_count }}</span>
                                <span class="stat-item">💬 {{ $agenda->comments_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: rgba(127, 29, 29, 0.72); padding: 50px;">
                    <p>Belum ada agenda yang dipublikasikan saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>
