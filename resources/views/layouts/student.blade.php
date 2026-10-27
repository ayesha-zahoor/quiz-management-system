
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Portal') | QuizSphere</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #84cc16;
            --secondary-color: #365314;
            --accent-color: #a3e635;
            --background-color: #f6f8f4;
            --text-color: #18251c;
            --surface-color: #ffffff;
            --muted-color: #748176;
            --border-color: #e8eee7;
            --primary-soft: #eef8dc;
            --primary-dark: #365314;
            --on-primary: #0b1120;
            --on-secondary: #ffffff;
            --on-accent: #0b1120;
            --shadow-soft: 0 8px 28px rgba(28, 48, 29, .055);
            --shadow-hover: 0 18px 42px rgba(28, 48, 29, .11);
            --radius-lg: 22px;
            --radius-md: 15px;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--background-color);
            color: var(--text-color);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
        }

        h1, h2, h3, h4, h5, h6, .brand-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -.035em;
        }

        a { text-decoration: none; }

        .student-shell {
            min-height: 100vh;
        }

        .student-sidebar {
            width: 258px;
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 1040;
            background: linear-gradient(170deg,
                color-mix(in srgb, var(--secondary-color) 86%, white) 0%,
                var(--secondary-color) 52%,
                color-mix(in srgb, var(--secondary-color) 82%, black) 100%);
            color: var(--on-secondary);
            border-right: 1px solid color-mix(in srgb, var(--secondary-color) 75%, black);
            display: flex;
            flex-direction: column;
            padding: 26px 17px 18px;
            transition: transform .3s ease;
            overflow-y: auto;
overscroll-behavior: contain;
scrollbar-width: thin;
scrollbar-color: rgba(255, 255, 255, .35) transparent;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 10px;
            margin-bottom: 38px;
            color: var(--on-secondary);
        }
        .student-sidebar::-webkit-scrollbar { width: 6px; }
.student-sidebar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, .3); border-radius: 6px; }

/* On short screens, hide the tip card and tighten the top so most things fit without scrolling */
@media (max-height: 760px) {
    .sidebar-help { display: none; }
    .brand { margin-bottom: 22px; }
}

        .brand-symbol {
            width: 43px;
            height: 43px;
            display: grid;
            place-items: center;
            color: var(--on-primary);
            border-radius: 15px;
            font-size: 21px;
            background: var(--primary-color);
            box-shadow: 0 7px 18px color-mix(in srgb, var(--primary-color) 28%, transparent);
        }

        .brand-name {
            font-size: 17px;
            font-weight: 800;
            line-height: 1.15;
        }

        .brand-caption {
            font-size: 11px;
            color: color-mix(in srgb, var(--on-secondary) 72%, transparent);
            margin-top: 4px;
        }

        .nav-label {
            padding: 0 12px;
            margin: 0 0 10px;
            color: color-mix(in srgb, var(--on-secondary) 62%, transparent);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .13em;
            text-transform: uppercase;
        }

        .student-nav {
            display: grid;
            gap: 6px;
        }

        .student-nav a {
            min-height: 46px;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 0 14px;
            border-radius: 12px;
            color: color-mix(in srgb, var(--on-secondary) 86%, transparent);
            font-weight: 600;
            transition: background .2s ease, color .2s ease, transform .2s ease;
        }

        .student-nav a i {
            font-size: 18px;
        }

        .student-nav a:hover {
            color: var(--on-secondary);
            background: rgba(255, 255, 255, .12);
            transform: translateX(2px);
        }

        .student-nav a.active {
            color: var(--on-primary);
            background: var(--primary-color);
            font-weight: 800;
            box-shadow: 0 8px 20px -8px color-mix(in srgb, var(--primary-color) 70%, black);
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        .sidebar-help {
            background: rgba(255, 255, 255, .09);
            border: 1px solid rgba(255, 255, 255, .14);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 17px;
        }

        .sidebar-help-icon {
            width: 35px;
            height: 35px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, .12);
            color: var(--on-secondary);
            border-radius: 11px;
            font-size: 17px;
            margin-bottom: 12px;
        }

        .sidebar-help p {
            color: color-mix(in srgb, var(--on-secondary) 76%, transparent);
            font-size: 12px;
            line-height: 1.6;
            margin: 5px 0 0;
        }

        .institute-mini {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 8px 0;
            border-top: 1px solid rgba(255, 255, 255, .16);
        }

        .institute-logo {
            width: 39px;
            height: 39px;
            flex: 0 0 auto;
            border-radius: 12px;
            object-fit: contain;
            background: rgba(255, 255, 255, .95);
            padding: 4px;
            border: 1px solid rgba(255, 255, 255, .25);
        }

        .institute-placeholder {
            display: grid;
            place-items: center;
            color: var(--on-primary);
            background: var(--primary-color);
            font-weight: 800;
        }

        .institute-name {
            font-size: 12px;
            font-weight: 800;
            line-height: 1.4;
            overflow-wrap: anywhere;
        }

        .institute-caption {
            font-size: 10px;
            color: var(--muted-color);
            margin-top: 3px;
        }

        .student-main {
            min-height: 100vh;
            margin-left: 258px;
        }

        .student-topbar {
            height: 79px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 0 38px;
            background: rgba(255,255,255,.88);
            backdrop-filter: blur(18px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .topbar-context {
            color: var(--muted-color);
            font-size: 12px;
            margin-top: 4px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 17px;
        }

        .topbar-icon {
            width: 39px;
            height: 39px;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            display: grid;
            place-items: center;
            color: var(--text-color);
            background: var(--surface-color);
            font-size: 17px;
        }

        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--text-color);
        }

        .student-avatar {
            width: 41px;
            height: 41px;
            border-radius: 14px;
            object-fit: cover;
            background: var(--primary-soft);
            color: var(--secondary-color);
            display: grid;
            place-items: center;
            font-weight: 800;
            border: 1px solid var(--border-color);
        }

        .topbar-profile-name {
            font-size: 12px;
            font-weight: 800;
        }

        .topbar-profile-role {
            color: var(--muted-color);
            font-size: 11px;
            margin-top: 3px;
        }

        .student-content {
            padding: 34px 38px 44px;
            max-width: 1800px;
            margin: 0 auto;
        }

        .student-footer {
            padding: 0 38px 25px;
            color: var(--muted-color);
            font-size: 11px;
        }

        .mobile-menu {
            display: none;
            border: 1px solid var(--border-color);
            background: var(--surface-color);
            border-radius: 11px;
            width: 40px;
            height: 40px;
            color: var(--text-color);
        }

        .theme-primary {
            background: var(--primary-color) !important;
            color: white !important;
        }

        .btn-institute {
            background: var(--primary-color);
            border: 1px solid var(--primary-color);
            color: white;
            border-radius: 11px;
            font-weight: 800;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .btn-institute:hover {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-soft);
        }

        @media (max-width: 1100px) {
            .student-sidebar { width: 230px; }
            .student-main { margin-left: 230px; }
            .student-topbar { padding: 0 24px; }
            .student-content { padding: 28px 24px 38px; }
            .student-footer { padding: 0 24px 22px; }
        }

        @media (max-width: 767px) {
            .student-sidebar {
                transform: translateX(-105%);
                width: 270px;
                box-shadow: var(--shadow-hover);
            }

            .student-sidebar.open { transform: translateX(0); }
            .student-main { margin-left: 0; }
            .student-topbar { height: 69px; padding: 0 16px; }
            .student-content { padding: 23px 16px 32px; }
            .student-footer { padding: 0 16px 20px; }
            .mobile-menu { display: grid; place-items: center; }
            .topbar-context, .topbar-profile-copy { display: none; }
            .topbar-right { gap: 9px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
        }
        
    </style>
<script>
window.applyStudentTheme = function (config) {
    if (!config) return;

    const root = document.documentElement.style;
    const colorKeys = {
        primary_color: '--primary-color',
        secondary_color: '--secondary-color',
        accent_color: '--accent-color',
        background_color: '--background-color',
        text_color: '--text-color'
    };

    Object.keys(colorKeys).forEach(function (key) {
        const value = config[key];
        if (typeof value === 'string' && /^#[0-9a-f]{3}(?:[0-9a-f]{3})?$/i.test(value.trim())) {
            root.setProperty(colorKeys[key], value.trim());
        }
    });

    function readableText(hex) {
        let value = (hex || '').replace('#', '').trim();
        if (value.length === 3) value = value.split('').map(char => char + char).join('');
        if (!/^[0-9a-f]{6}$/i.test(value)) return '#FFFFFF';
        const r = parseInt(value.substring(0, 2), 16);
        const g = parseInt(value.substring(2, 4), 16);
        const b = parseInt(value.substring(4, 6), 16);
        return (r * 299 + g * 587 + b * 114) / 1000 > 150 ? '#0B1120' : '#FFFFFF';
    }

    root.setProperty('--on-primary', readableText(config.primary_color));
    root.setProperty('--on-secondary', readableText(config.secondary_color));
    root.setProperty('--on-accent', readableText(config.accent_color));
    root.setProperty('--primary-soft', 'color-mix(in srgb, var(--primary-color) 16%, white)');
    root.setProperty('--primary-dark', 'color-mix(in srgb, var(--primary-color) 78%, black)');
};

try {
    window.applyStudentTheme(JSON.parse(localStorage.getItem('student_config') || 'null'));
} catch (error) {}
</script>
    @stack('styles')
</head>
<body>
<div class="student-shell">
    <aside class="student-sidebar" id="studentSidebar">
        <a href="/student/dashboard" class="brand">
            <span class="brand-symbol"><i class="bi bi-mortarboard-fill"></i></span>
            <span>
                <span class="brand-name d-block">QuizSphere</span>
                <span class="brand-caption d-block">Your learning space</span>
            </span>
        </a>

        <div class="nav-label">Workspace</div>

        <nav class="student-nav">
            <a href="/student/dashboard" class="{{ request()->is('student/dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i><span>Dashboard</span>
            </a>
            <a href="/student/quizzes" class="{{ request()->is('student/quizzes*') || request()->is('student/takeQuiz*') ? 'active' : '' }}">
                <i class="bi bi-journal-check"></i><span>My Quizzes</span>
            </a>
            <a href='/student/results' class="{{ request()->is('student/results*') || request()->is('student/result*') ? 'active' : '' }}">
                <i class="bi bi-graph-up-arrow"></i><span>My All Results</span>
            </a>
            <a href="/student/profile" class="{{ request()->is('student/profile*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i><span>My Profile</span>
            </a>
            <a href="#" id="studentLogout" role="button">
    <i class="bi bi-box-arrow-right"></i><span>Logout</span>
</a>
        </nav>

        <div class="sidebar-bottom">
            <div class="sidebar-help">
                <div class="sidebar-help-icon"><i class="bi bi-lightbulb"></i></div>
                <div class="fw-bold" style="color:var(--on-secondary);">A little progress daily</div>
                <p>Every quiz is a chance to discover what you know and what you can learn next.</p>
            </div>

            <div class="institute-mini">
                <div id="instituteLogoPlaceholder" class="institute-logo institute-placeholder">IN</div>
                <img id="studentInstituteLogo" class="institute-logo d-none" src="" alt="Institute logo">
                <div class="min-w-0">
                    <div class="institute-name" id="studentInstituteName">Your Institute</div>
                    <div class="institute-caption">Student learning portal</div>
                </div>
                
            </div>
        </div>
    </aside>

    <main class="student-main">
        <header class="student-topbar">
            <div class="d-flex align-items-center gap-3">
                <button class="mobile-menu" id="studentMenuToggle" type="button" aria-label="Open navigation">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <div>
                    <div class="fw-bold" style="font-family:'Plus Jakarta Sans',sans-serif;">Student Portal</div>
                    <div class="topbar-context">Learn at your pace. Grow with every quiz.</div>
                </div>
            </div>

            <div class="topbar-right">
                <a href="/student/quizzes" class="topbar-icon" title="Available quizzes" aria-label="Available quizzes">
                    <i class="bi bi-journal-check"></i>
                </a>
                <a href="/student/profile" class="topbar-profile">
                    <img id="studentAvatarImage" class="student-avatar d-none" src="" alt="Student profile">
                    <span id="studentAvatarInitials" class="student-avatar">ST</span>
                    <span class="topbar-profile-copy">
                        <span class="topbar-profile-name d-block" id="studentDisplayName">Student Name</span>
                        <span class="topbar-profile-role d-block">Student account</span>
                    </span>
                    <i class="bi bi-chevron-down small text-secondary"></i>
                </a>
            </div>
        </header>

        @yield('content')

        <footer class="student-footer d-flex flex-wrap justify-content-between gap-2">
            <span>© {{ date('Y') }} QuizSphere · Learning made meaningful.</span>
            <span>Stay curious. Keep improving.</span>
        </footer>
    </main>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function () {
    $('#studentMenuToggle').on('click', function () {
        $('#studentSidebar').toggleClass('open');
    });

    $(document).on('click', function (event) {
        if (
            window.innerWidth <= 767 &&
            !$(event.target).closest('#studentSidebar, #studentMenuToggle').length
        ) {
            $('#studentSidebar').removeClass('open');
        }
    });

    const token = localStorage.getItem('api_token') ||
        localStorage.getItem('token') ||
        localStorage.getItem('auth_token') ||
        localStorage.getItem('access_token');

    if (token) {
        $.ajax({
            url: '/api/student/quizzes',
            method: 'GET',
            headers: {
                Authorization: 'Bearer ' + token,
                Accept: 'application/json'
            }
        }).done(function (response) {
            const data = response && response.data ? response.data : {};
            const config = data.configuration || (data.institute && data.institute.configuration) || null;
            const student = data.student || data.user || {};
            const institute = data.institute || {};

            if (config) {
                window.applyStudentTheme(config);
                localStorage.setItem('student_config', JSON.stringify(config));
            }

            if (student.name) {
                $('#studentDisplayName').text(student.name);
                const initials = student.name.trim().split(/\s+/).slice(0, 2)
                    .map(part => part.charAt(0).toUpperCase()).join('');
                $('#studentAvatarInitials').text(initials || 'ST');
            }

            if (institute.name) $('#studentInstituteName').text(institute.name);

            if (institute.logo) {
                const logoPath = String(institute.logo);
                const logoUrl = /^https?:\/\//i.test(logoPath) || logoPath.startsWith('/')
                    ? logoPath
                    : '{{ asset("storage") }}/' + logoPath.replace(/^\/+/, '');

                $('#studentInstituteLogo').off('load.student error.student')
                    .on('load.student', function () {
                        $(this).removeClass('d-none');
                        $('#instituteLogoPlaceholder').addClass('d-none');
                    })
                    .on('error.student', function () {
                        $(this).addClass('d-none');
                        $('#instituteLogoPlaceholder').removeClass('d-none');
                    })
                    .attr('src', logoUrl);
            }

            if (student.profile_image) {
                const imagePath = String(student.profile_image);
                const imageUrl = /^https?:\/\//i.test(imagePath) || imagePath.startsWith('/')
                    ? imagePath
                    : '{{ asset("storage") }}/' + imagePath.replace(/^\/+/, '');

                $('#studentAvatarImage').off('load.student error.student')
                    .on('load.student', function () {
                        $(this).removeClass('d-none');
                        $('#studentAvatarInitials').addClass('d-none');
                    })
                    .on('error.student', function () {
                        $(this).addClass('d-none');
                        $('#studentAvatarInitials').removeClass('d-none');
                    })
                    .attr('src', imageUrl);
            }
        }).fail(function (xhr) {
            console.error('Could not load student institute configuration:', xhr.status, xhr.responseJSON || xhr.responseText);
        });
    }
    // ---- Logout settings (change if needed) ----
const LOGIN_URL = '/login';                          // your login page URL
const TOKEN_KEYS = ['api_token', 'token', 'auth_token', 'access_token'];
// --------------------------------------------

$('#studentLogout').on('click', async function (e) {
    e.preventDefault();

    const $link = $(this).css('pointer-events', 'none');
    $link.find('span').text('Logging out...');

    let token = null;
    for (const key of TOKEN_KEYS) {
        token = localStorage.getItem(key);
        if (token) break;
    }

    const headers = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
    if (token) headers['Authorization'] = 'Bearer ' + token;

    try {
        await fetch('/api/logout', { method: 'POST', headers: headers });
    } catch (err) {
        // Even if the server can't be reached, still log out on this device.
    }

    localStorage.clear();
    localStorage.removeItem('is_system_admin');
localStorage.removeItem('permissions');
    sessionStorage.clear();
    window.location.href = '/';

});
});
</script>

@stack('scripts')
</body>
</html>
