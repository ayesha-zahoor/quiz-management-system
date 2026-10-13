{{--
    School identity. Change the text here, and drop your logos into:
      public/images/school-logo.png    (Nawaz Sharif School)
      public/images/college-logo.png   (Sun Rise College)
    When a logo file is missing, an icon is shown instead.
--}}
@php
    $school  = 'Nawaz Sharif School';
    $college = 'Sun Rise College';
    $city    = 'Ahmad Pur East';

    $schoolLogo  = file_exists(public_path('images/school-logo.png'))  ? asset('images/school-logo.png')  : null;
    $collegeLogo = file_exists(public_path('images/college-logo.png')) ? asset('images/college-logo.png') : null;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Quiz Management System')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --navy: #0B1120;
            --lime: #84CC16;
            --lime-dark: #65A30D;
            --lime-deep: #4D7C0F;
            --lime-light: #ECFCCB;
            --white: #FFFFFF;
            --slate: #64748B;
            --dark-text: #111827;
            --border: #E2E8F0;

            --sun-x: clamp(48px, 13vw, 230px);   /* where the sun rises */
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--dark-text);
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--lime-light);
        }

        /* ================= The scene ================= */

        .scene {
            position: relative;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: linear-gradient(180deg, #F7FEE7 0%, #ECFCCB 32%, #BEF264 68%, #84CC16 100%);
        }

        /* Sun and rays */
        .sun-point {
            position: absolute;
            left: var(--sun-x);
            bottom: 215px;
            width: 0;
            height: 0;
            z-index: 0;
        }

        .rays {
            position: absolute;
            width: 1200px;
            height: 1200px;
            left: -600px;
            top: -600px;
            background: repeating-conic-gradient(from 0deg, rgba(255, 255, 255, 0.42) 0 3deg, transparent 3deg 10deg);
            -webkit-mask-image: radial-gradient(circle, #000 6%, transparent 62%);
            mask-image: radial-gradient(circle, #000 6%, transparent 62%);
            animation: spin 160s linear infinite;
        }

        .sun {
            position: absolute;
            width: 250px;
            height: 250px;
            left: -125px;
            top: -125px;
            border-radius: 50%;
            background: #FFFFFF;
            box-shadow: 0 0 0 26px rgba(255, 255, 255, 0.45), 0 0 110px 60px rgba(255, 255, 255, 0.55);
            animation: rise 2.4s cubic-bezier(0.2, 0.8, 0.2, 1) both;
        }

        @keyframes rise { from { transform: translateY(150px); opacity: 0.2; } to { transform: none; opacity: 1; } }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* School building in front of the sun */
        .school {
            position: absolute;
            left: var(--sun-x);
            bottom: 128px;
            width: clamp(200px, 26vw, 340px);
            height: auto;
            transform: translateX(-50%);
            z-index: 2;
        }

        /* Hills */
        .horizon {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 280px;
            z-index: 1;
            pointer-events: none;
        }

        /* ================= Content ================= */

        .auth-shell {
            position: relative;
            z-index: 3;
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 32px;
        }

        /* Top bar: school + affiliation */
        .auth-top {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 26px 0 8px;
        }

        .crest {
            width: 52px;
            height: 52px;
            flex: 0 0 52px;
            border-radius: 14px;
            background: var(--navy);
            color: var(--lime);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(11, 17, 32, 0.22);
        }
        .crest img { width: 100%; height: 100%; object-fit: cover; background: var(--white); }

        .school-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 22px;
            font-weight: 700;
            line-height: 1.15;
            color: var(--navy);
            letter-spacing: -0.2px;
        }

        .affiliation {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 5px;
            color: rgba(11, 17, 32, 0.72);
            font-size: 12.5px;
            font-weight: 600;
        }

        .affiliation .mini {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            background: var(--lime);
            color: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            overflow: hidden;
            flex: 0 0 20px;
        }
        .affiliation .mini img { width: 100%; height: 100%; object-fit: cover; }

        /* Hero + card */
        .auth-main {
            flex: 1;
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(0, 0.95fr);
            gap: clamp(24px, 5vw, 90px);
            align-items: center;
            padding: 12px 0 40px;
        }

        .auth-hero { align-self: start; padding-top: clamp(12px, 7vh, 80px); }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            margin-bottom: 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.7);
            color: var(--lime-deep);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .hero-title {
            margin: 0 0 16px;
            font-family: 'Playfair Display', Georgia, serif;
            font-size: clamp(36px, 4.6vw, 62px);
            line-height: 1.06;
            font-weight: 800;
            letter-spacing: -1.5px;
            color: var(--navy);
        }

        .hero-text {
            max-width: 470px;
            margin: 0 0 26px;
            color: rgba(11, 17, 32, 0.78);
            font-size: 17px;
            line-height: 1.7;
        }

        .hero-chips { display: flex; flex-wrap: wrap; gap: 10px; }

        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.78);
            color: var(--navy);
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 14px rgba(11, 17, 32, 0.06);
        }
        .hero-chip i { color: var(--lime-dark); }

        /* The sign-in card */
        .auth-card {
            position: relative;
            width: 100%;
            max-width: 450px;
            margin-left: auto;
            padding: 46px 36px 32px;
            border-radius: 24px;
            background: var(--white);
            box-shadow: 0 30px 80px rgba(11, 17, 32, 0.22), 0 0 0 1px rgba(255, 255, 255, 0.6);
        }

        .card-sun {
            position: absolute;
            top: -28px;
            left: 50%;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: var(--lime);
            color: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            transform: translateX(-50%);
            box-shadow: 0 0 0 6px var(--white), 0 10px 24px rgba(11, 17, 32, 0.18);
        }

        /* Footer sits on the dark foreground hill */
        .auth-foot {
            position: relative;
            z-index: 4;
            padding: 16px 20px 18px;
            text-align: center;
            color: rgba(255, 255, 255, 0.78);
            font-size: 12.5px;
        }
        .auth-foot strong { color: var(--white); font-weight: 600; }

        /* ================= Responsive ================= */

        @media (max-width: 991.98px) {
            .auth-main { grid-template-columns: 1fr; gap: 56px; padding-top: 4px; }
            .auth-hero { padding-top: 6px; text-align: center; }
            .hero-text { margin-left: auto; margin-right: auto; }
            .hero-chips { justify-content: center; }
            .auth-card { margin: 0 auto; }
            .horizon { height: 220px; }
            .sun-point { bottom: 160px; }
            .school { bottom: 96px; opacity: 0.9; }
        }

        @media (max-width: 575.98px) {
            .auth-shell { padding: 0 18px; }
            .auth-top { padding-top: 18px; }
            .school-name { font-size: 19px; }
            .hero-text { font-size: 15px; }
            .hero-chips { display: none; }
            .auth-card { padding: 44px 22px 26px; }
            .school { display: none; }
        }

        @media (prefers-reduced-motion: reduce) {
            .sun, .rays { animation: none; }
        }
    </style>

    @stack('styles')
</head>

<body>

<div class="scene">

    {{-- Sunrise --}}
    <div class="sun-point" aria-hidden="true">
        <div class="rays"></div>
        <div class="sun"></div>
    </div>

    {{-- School building --}}
    <svg class="school" viewBox="0 -24 300 184" aria-hidden="true">
        <line x1="150" y1="-22" x2="150" y2="14" stroke="#0B1120" stroke-width="2"/>
        <path d="M150 -22 L174 -14 L150 -6 Z" fill="#84CC16"/>

        <polygon points="106,46 150,12 194,46" fill="#0B1120"/>
        <rect x="112" y="44" width="76" height="116" fill="#0B1120"/>
        <rect x="30" y="88" width="82" height="72" fill="#0B1120"/>
        <rect x="188" y="88" width="82" height="72" fill="#0B1120"/>
        <rect x="24" y="82" width="94" height="8" rx="2" fill="#0B1120"/>
        <rect x="182" y="82" width="94" height="8" rx="2" fill="#0B1120"/>

        <g fill="#ECFCCB" opacity="0.92">
            <circle cx="150" cy="33" r="6"/>
            <rect x="124" y="60" width="14" height="22" rx="2"/>
            <rect x="162" y="60" width="14" height="22" rx="2"/>
            <rect x="124" y="92" width="14" height="22" rx="2"/>
            <rect x="162" y="92" width="14" height="22" rx="2"/>
            <rect x="42" y="102" width="14" height="22" rx="2"/>
            <rect x="68" y="102" width="14" height="22" rx="2"/>
            <rect x="218" y="102" width="14" height="22" rx="2"/>
            <rect x="244" y="102" width="14" height="22" rx="2"/>
            <rect x="42" y="130" width="14" height="20" rx="2"/>
            <rect x="68" y="130" width="14" height="20" rx="2"/>
            <rect x="218" y="130" width="14" height="20" rx="2"/>
            <rect x="244" y="130" width="14" height="20" rx="2"/>
        </g>

        <path d="M138 160 V138 a12 12 0 0 1 24 0 V160 Z" fill="#84CC16"/>
        <rect x="120" y="156" width="60" height="4" fill="#0B1120"/>

        <circle cx="12" cy="138" r="15" fill="#0B1120"/><rect x="10" y="146" width="4" height="14" fill="#0B1120"/>
        <circle cx="288" cy="138" r="15" fill="#0B1120"/><rect x="286" y="146" width="4" height="14" fill="#0B1120"/>
    </svg>

    {{-- Hills --}}
    <svg class="horizon" viewBox="0 0 1440 280" preserveAspectRatio="none" aria-hidden="true">
        <path d="M0,120 C180,60 360,70 540,110 C760,160 980,60 1200,90 C1320,105 1400,95 1440,85 L1440,280 L0,280 Z" fill="#65A30D"/>
        <path d="M0,170 C200,120 420,150 620,175 C860,205 1060,130 1260,150 C1360,160 1410,170 1440,165 L1440,280 L0,280 Z" fill="#4D7C0F"/>
        <path d="M0,225 C240,200 480,235 720,225 C960,215 1200,240 1440,220 L1440,280 L0,280 Z" fill="#0B1120"/>
    </svg>


    <div class="auth-shell">

        <header class="auth-top">
            <div class="crest">
                @if($schoolLogo)
                    <img src="{{ $schoolLogo }}" alt="{{ $school }} logo">
                @else
                    <i class="bi bi-mortarboard-fill"></i>
                @endif
            </div>

            <div>
                <div class="school-name">{{ $school }}</div>
                <div class="affiliation">
                    <span class="mini">
                        @if($collegeLogo)
                            <img src="{{ $collegeLogo }}" alt="{{ $college }} logo">
                        @else
                            <i class="bi bi-brightness-high-fill"></i>
                        @endif
                    </span>
                    Affiliated with {{ $college }}, {{ $city }}
                </div>
            </div>
        </header>

        <main class="auth-main">

            <section class="auth-hero">
                <span class="hero-eyebrow"><i class="bi bi-patch-question-fill"></i> Quiz Management System</span>

                <h1 class="hero-title">Every lesson is a new sunrise.</h1>

                <p class="hero-text">
                    Practice, attempt and review quizzes online. A voice-enabled learning space
                    for students, teachers and administrators across Classes 1–12.
                </p>

                <div class="hero-chips">
                    <span class="hero-chip"><i class="bi bi-mic-fill"></i> Voice-enabled quizzes</span>
                    <span class="hero-chip"><i class="bi bi-mortarboard-fill"></i> Classes 1–12</span>
                    <span class="hero-chip"><i class="bi bi-bar-chart-fill"></i> Results you can review</span>
                </div>
            </section>

            <section class="auth-card">
                <div class="card-sun" aria-hidden="true"><i class="bi bi-brightness-alt-high-fill"></i></div>

                @yield('content')
            </section>

        </main>

        <footer class="auth-foot">
            <strong>{{ $school }}</strong> &middot; Affiliated with {{ $college }}, {{ $city }}
        </footer>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

@stack('scripts')

</body>
</html>