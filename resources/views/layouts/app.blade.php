<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Talkyu')</title>
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

        /* Ambient background circles */
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
            background: rgba(255, 255, 255, 0.75);
            bottom: -50px;
            left: -100px;
        }

        /* Container utility */
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        @yield('styles')
    </style>
</head>
<body>
    <div class="ambient-circle circle-1"></div>
    <div class="ambient-circle circle-2"></div>

    @if(Auth::check() && Auth::user()->role === 'admin')
        @include('layouts.navbar_admin')
    @else
        @include('layouts.navbar')
    @endif

    @yield('content')

    @yield('scripts')
</body>
</html>
