<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>StreamLine | Experience Live TV Like Never Before</title>
    <meta name="description" content="StreamLine offers over 500+ live channels in 4K quality. Watch your favorite sports, news, and entertainment anytime, anywhere.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #7C4DFF;
            --primary-dark: #651FFF;
            --background: #0F111A;
            --surface: #1A1C26;
            --text: #FFFFFF;
            --text-dim: #A1A09A;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--background);
            color: var(--text);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .hero {
            position: relative;
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background-image: linear-gradient(rgba(15, 17, 26, 0.6), rgba(15, 17, 26, 0.9)), url('/hero_bg.png');
            background-size: cover;
            background-position: center;
        }

        .nav {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 30px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .logo {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--text);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo span {
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links a {
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            padding: 12px 28px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: none;
            font-family: inherit;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 15px rgba(124, 77, 255, 0.3);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 77, 255, 0.4);
        }

        .btn-outline {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .hero-content {
            max-width: 800px;
            text-align: center;
            z-index: 5;
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-content h1 {
            font-size: clamp(40px, 8vw, 72px);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
            letter-spacing: -2px;
        }

        .hero-content h1 span {
            background: linear-gradient(to right, #7C4DFF, #03DAC6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-content p {
            font-size: clamp(16px, 2vw, 20px);
            color: var(--text-dim);
            margin-bottom: 40px;
            max-width: 600px;
            margin-inline: auto;
        }

        .glass-card {
            background: rgba(26, 28, 38, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 32px;
            padding: 40px;
            margin-top: 50px;
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
        }

        .stat-item h3 {
            font-size: 28px;
            font-weight: 800;
            color: var(--primary);
        }

        .stat-item p {
            font-size: 14px;
            color: var(--text-dim);
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .nav {
                padding: 20px;
            }
            .nav-links {
                display: none;
            }
            .glass-card {
                padding: 24px;
                gap: 20px;
            }
        }
    </style>
</head>
<body>
    <nav class="nav">
        <a href="/" class="logo">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="32" height="32" rx="8" fill="#7C4DFF"/>
                <path d="M10 12L22 16L10 20V12Z" fill="white"/>
            </svg>
            Stream<span>Line</span>
        </a>
        <div class="nav-links">
            <a href="#features">Features</a>
            <a href="#channels">Channels</a>
            <a href="#pricing">Pricing</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Sign In</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Join Now</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <main class="hero">
        <div class="hero-content">
            <h1>The Future of <span>Live Television</span> is Here.</h1>
            <p>Stream over 500+ premium channels, exclusive sports events, and local news in stunning 4K quality. Anytime, anywhere.</p>
            
            <div style="display: flex; gap: 20px; justify-content: center;">
                <a href="{{ route('register') }}" class="btn btn-primary">Start Free Trial</a>
                <a href="#features" class="btn btn-outline">Explore Channels</a>
            </div>

            <div class="glass-card">
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Live Channels</p>
                </div>
                <div style="width: 1px; height: 40px; background: rgba(255,255,255,0.1);"></div>
                <div class="stat-item">
                    <h3>4K UHD</h3>
                    <p>Streaming Quality</p>
                </div>
                <div style="width: 1px; height: 40px; background: rgba(255,255,255,0.1);"></div>
                <div class="stat-item">
                    <h3>99.9%</h3>
                    <p>Uptime Record</p>
                </div>
            </div>
        </div>
    </main>

    <section id="features" style="padding: 100px 50px; background: var(--background);">
        <div style="max-width: 1200px; margin: 0 auto; text-align: center;">
            <h2 style="font-size: 48px; margin-bottom: 60px;">Premium <span>Experience</span></h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <div class="glass-card" style="margin-top: 0; flex-direction: column; align-items: flex-start; text-align: left;">
                    <div style="background: rgba(124, 77, 255, 0.1); padding: 15px; border-radius: 16px; margin-bottom: 20px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#7C4DFF" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                    </div>
                    <h3 style="margin-bottom: 15px;">Multi-Device Support</h3>
                    <p style="color: var(--text-dim);">Watch on your TV, laptop, tablet, or phone. Sync your progress across all devices seamlessly.</p>
                </div>
                <div class="glass-card" style="margin-top: 0; flex-direction: column; align-items: flex-start; text-align: left;">
                    <div style="background: rgba(3, 218, 198, 0.1); padding: 15px; border-radius: 16px; margin-bottom: 20px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#03DAC6" stroke-width="2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                    </div>
                    <h3 style="margin-bottom: 15px;">Instant Playback</h3>
                    <p style="color: var(--text-dim);">Zero buffering technology ensures you jump straight into the action without waiting.</p>
                </div>
                <div class="glass-card" style="margin-top: 0; flex-direction: column; align-items: flex-start; text-align: left;">
                    <div style="background: rgba(255, 215, 0, 0.1); padding: 15px; border-radius: 16px; margin-bottom: 20px;">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFD700" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <h3 style="margin-bottom: 15px;">Catch-up TV</h3>
                    <p style="color: var(--text-dim);">Missed your favorite show? Rewind up to 7 days of content on selected channels.</p>
                </div>
            </div>
        </div>
    </section>

    <footer style="padding: 50px; text-align: center; border-top: 1px solid rgba(255,255,255,0.05);">
        <p style="color: var(--text-dim); font-size: 14px;">© 2026 StreamLine TV. All rights reserved. Premium streaming for everyone.</p>
    </footer>
</body>
</html>
