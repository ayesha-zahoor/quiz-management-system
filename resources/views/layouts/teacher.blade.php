<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Teacher Portal')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /*
         | Colors come from the institute configuration set by the super admin.
         | These are only defaults until it loads. Lighter / darker shades and the
         | readable "on" colors are derived automatically.
         */
        :root {
            --primary-color: #84CC16;
            --secondary-color: #365314;
            --accent-color: #A3E635;
            --background-color: #F8FAFC;
            --text-color: #1F2937;

            --primary-dark: color-mix(in srgb, var(--primary-color) 78%, black);
            --primary-light: color-mix(in srgb, var(--primary-color) 16%, white);
            --on-primary: #0B1120;
            --on-secondary: #FFFFFF;
            --on-accent: #0B1120;

            --slate: #64748B;
            --line: #E2E8F0;
            --sidebar-width: 262px;
        }

        * { box-sizing: border-box; }

        html {
            scrollbar-width: thin;
            scrollbar-color: rgba(100, 116, 139, 0.35) transparent;
        }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-thumb { background: rgba(100, 116, 139, 0.3); border-radius: 8px; }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text-color);
            font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            /* soft colored glow: this is what the glass cards blur */
            background:
                radial-gradient(900px 600px at 96% -8%, color-mix(in srgb, var(--accent-color) 32%, transparent), transparent 62%),
                radial-gradient(820px 620px at 4% 104%, color-mix(in srgb, var(--primary-color) 26%, transparent), transparent 62%),
                radial-gradient(700px 520px at 62% 42%, color-mix(in srgb, var(--secondary-color) 9%, transparent), transparent 70%),
                var(--background-color);
            background-attachment: fixed;
        }

        a { color: inherit; text-decoration: none; }

        /* ================= Sidebar ================= */

        .teacher-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-width);
            height: 100vh;
            height: 100dvh;
            z-index: 1050;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            color: var(--on-secondary);
            background: linear-gradient(170deg,
                color-mix(in srgb, var(--secondary-color) 86%, white) 0%,
                var(--secondary-color) 52%,
                color-mix(in srgb, var(--secondary-color) 82%, black) 100%);
        }

        .teacher-sidebar::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            top: -120px;
            right: -110px;
            border-radius: 50%;
            background: color-mix(in srgb, var(--primary-color) 28%, transparent);
            filter: blur(40px);
            pointer-events: none;
        }

        .teacher-brand {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 22px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .brand-logo {
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            border-radius: 13px;
            background: #fff;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.22);
        }
        .brand-logo img { width: 100%; height: 100%; object-fit: contain; padding: 4px; }

        .brand-text { min-width: 0; }
        #instituteName { font-size: 15px; font-weight: 700; line-height: 1.2; overflow-wrap: anywhere; }
        .brand-text small { display: block; margin-top: 3px; opacity: 0.7; font-size: 12px; }

        .teacher-nav { position: relative; flex: 1 1 auto; min-height: 0; padding: 18px 14px; overflow-y: auto; scrollbar-width: none; }
        .teacher-nav::-webkit-scrollbar { display: none; }

        .nav-label { margin: 0 8px 10px; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; opacity: 0.6; }

        .teacher-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 44px;
            padding: 10px 14px;
            margin-bottom: 5px;
            border-radius: 12px;
            color: inherit;
            font-size: 14px;
            font-weight: 600;
            opacity: 0.88;
            transition: background 0.2s ease, color 0.2s ease, opacity 0.2s ease;
        }
        .teacher-nav a i { width: 20px; font-size: 17px; text-align: center; }
        .teacher-nav a:hover { background: rgba(255, 255, 255, 0.12); opacity: 1; }

        .teacher-nav a.active {
            background: var(--primary-color);
            color: var(--on-primary);
            opacity: 1;
            box-shadow: 0 10px 22px -8px color-mix(in srgb, var(--primary-color) 70%, black);
        }

        .teacher-sidebar-footer { position: relative; padding: 14px; border-top: 1px solid rgba(255, 255, 255, 0.12); }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        .avatar-sm {
            position: relative;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            border-radius: 50%;
            background: var(--primary-color);
            color: var(--on-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            overflow: hidden;
        }
        .avatar-sm img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }

        .sidebar-user-info { flex: 1; min-width: 0; }
        #teacherSidebarName { font-size: 13px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user-info small { display: block; opacity: 0.7; font-size: 11px; margin-top: 1px; }

        .logout-btn {
            flex: 0 0 auto;
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.28);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s ease, transform 0.2s ease;
        }
        .logout-btn:hover { background: #DC2626; }
        .logout-btn:active { transform: scale(0.94); }

        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(11, 17, 32, 0.45); z-index: 1040; }

        /* ================= Main ================= */

        .teacher-main { margin-left: var(--sidebar-width); min-height: 100vh; min-width: 0; }

        .teacher-topbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            height: 78px;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            background: rgba(255, 255, 255, 0.62);
            backdrop-filter: blur(16px) saturate(160%);
            -webkit-backdrop-filter: blur(16px) saturate(160%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.7);
        }

        .topbar-left { display: flex; align-items: center; gap: 14px; min-width: 0; }

        .menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            border: 0;
            border-radius: 10px;
            background: var(--primary-light);
            color: var(--primary-dark);
            font-size: 20px;
            align-items: center;
            justify-content: center;
        }

        .page-heading h1 { margin: 0; font-size: 21px; font-weight: 700; color: var(--text-color); }
        .page-heading p { margin: 3px 0 0; color: var(--slate); font-size: 13px; }

        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 12px 5px 6px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.85);
            box-shadow: 0 6px 18px -8px rgba(15, 23, 42, 0.2);
            transition: box-shadow 0.2s ease;
        }
        .topbar-profile:hover { box-shadow: 0 10px 24px -8px rgba(15, 23, 42, 0.3); }
        .topbar-profile .avatar-sm { width: 40px; height: 40px; flex-basis: 40px; }
        #teacherName { font-size: 13px; font-weight: 700; color: var(--text-color); line-height: 1.2; }
        .topbar-profile small { display: block; color: var(--slate); font-size: 11px; }

        .teacher-content { padding: 28px 30px 40px; max-width: 1500px; margin: 0 auto; }

        /* Buttons used across teacher pages */
        .btn-primary { background: var(--primary-color); border-color: var(--primary-color); color: var(--on-primary); font-weight: 700; }
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active { background: var(--primary-dark) !important; border-color: var(--primary-dark) !important; color: #fff !important; }

        /* ================= Responsive ================= */

        @media (max-width: 991.98px) {
            .teacher-sidebar { transform: translateX(-100%); transition: transform 0.25s ease; }
            .teacher-sidebar.open { transform: none; }
            .sidebar-overlay.show { display: block; }
            .teacher-main { margin-left: 0; }
            .menu-btn { display: flex; }
            .teacher-topbar { padding: 0 18px; }
            .teacher-content { padding: 22px 18px 34px; }
        }

        @media (max-width: 575.98px) {
            .teacher-topbar { height: 68px; }
            .page-heading p { display: none; }
            .topbar-profile-info { display: none; }
            .topbar-profile { padding: 4px; }
        }

        @media (prefers-reduced-motion: reduce) { * { transition: none !important; animation: none !important; } }
    </style>

    {{-- Apply the last known institute colors straight away, so there is no flash of the defaults --}}
    <script>
        window.applyTeacherTheme = function (config) {
            if (!config) return;

            const root = document.documentElement.style;
            const map = {
                primary_color: '--primary-color',
                secondary_color: '--secondary-color',
                accent_color: '--accent-color',
                background_color: '--background-color',
                text_color: '--text-color'
            };

            Object.keys(map).forEach(function (key) {
                if (config[key]) root.setProperty(map[key], config[key]);
            });

            // Dark or light text on top of each color, whichever is readable
            [['primary_color', '--on-primary'], ['secondary_color', '--on-secondary'], ['accent_color', '--on-accent']]
                .forEach(function (pair) {
                    const hex = (config[pair[0]] || '').replace('#', '');

                    if (/^[0-9a-f]{6}$/i.test(hex)) {
                        const r = parseInt(hex.substr(0, 2), 16), g = parseInt(hex.substr(2, 2), 16), b = parseInt(hex.substr(4, 2), 16);
                        root.setProperty(pair[1], (r * 299 + g * 587 + b * 114) / 1000 > 150 ? '#0B1120' : '#FFFFFF');
                    }
                });
        };

        try { window.applyTeacherTheme(JSON.parse(localStorage.getItem('teacher_config') || 'null')); } catch (e) {}
    </script>

    @stack('styles')
</head>

<body>

<aside class="teacher-sidebar" id="teacherSidebar">

    <div class="teacher-brand">
        <div class="brand-logo">
            <i class="bi bi-mortarboard-fill" id="brandIcon"></i>
            <img id="instituteLogo" src="" alt="Institute logo" class="d-none">
        </div>

        <div class="brand-text">
            <div id="instituteName">Quiz Management</div>
            <small>Teacher Portal</small>
        </div>
    </div>

    <nav class="teacher-nav">
        <div class="nav-label">Main menu</div>

        <a href="/teacher/dashboard" class="{{ request()->is('teacher/dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <a href='/teacher/quizzes' class="{{ request()->is('teacher/quizzes') ? 'active' : '' }}">
            <i class="bi bi-journal-text"></i> My Quizzes
        </a>

        <a href="/teacher/createQuiz" class="{{ request()->is('teacher/quizzes/create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i> Create Quiz
        </a>
          <a href="/teacher/results" class="{{ request()->is('teacher/results*') ? 'active' : '' }}">
      <i class="bi bi-bar-chart-line"></i> Results
  </a>
          <a href="#" id="sidebarProfileLink"
              class="{{ request()->is('teacher/profile*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>
    </nav>

    <div class="teacher-sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar-sm">
                <span id="teacherSidebarInitials">T</span>
                <img id="teacherSidebarImage" src="" alt="Teacher" class="d-none">
            </div>

            <div class="sidebar-user-info">
                <div id="teacherSidebarName">Teacher</div>
                <small>Teacher</small>
            </div>

            <button type="button" id="teacherLogout" class="logout-btn" title="Log out" aria-label="Log out">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </div>
    </div>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="teacher-main">

    <header class="teacher-topbar">

        <div class="topbar-left">
            <button type="button" class="menu-btn" id="menuBtn" aria-label="Open menu"><i class="bi bi-list"></i></button>

            <div class="page-heading">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <p>@yield('page-description', 'Manage your quizzes')</p>
            </div>
        </div>

        <a href="#" id="topbarProfileLink" class="topbar-profile" title="View your profile">
            <div class="avatar-sm">
                <span id="teacherTopbarInitials">T</span>
                <img id="teacherProfileImage" src="" alt="Teacher profile" class="d-none">
            </div>

            <div class="topbar-profile-info">
                <div id="teacherName">Teacher</div>
                <small>View profile</small>
            </div>
        </a>

    </header>

    <main class="teacher-content">
        @yield('content')
    </main>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    window.token = localStorage.getItem('api_token');

    if (!window.token) {
        window.location.href = '/';
    }

    // ---------- Helpers shared with the pages ----------
    window.teacherUi = {
        initialsOf: function (name) {
            return (name || 'Teacher').trim().split(/\s+/).slice(0, 2).map(p => p.charAt(0).toUpperCase()).join('');
        },

        imageUrl: function (path) {
            if (!path) return '';
            if (/^https?:\/\//i.test(path) || path.startsWith('data:')) return path;
            return '{{ asset("storage") }}/' + path.replace(/^\/+/, '');
        },

        // Shows the picture when it loads, otherwise keeps the fallback (initials / icon)
        setImage: function (imgSelector, path, fallbackSelector) {
            const $img = $(imgSelector), $fallback = $(fallbackSelector);

            $img.off('load.t error.t').addClass('d-none');
            $fallback.removeClass('d-none');

            if (!path) return;

            $img.on('load.t', function () { $fallback.addClass('d-none'); $img.removeClass('d-none'); })
                .on('error.t', function () { $img.addClass('d-none'); $fallback.removeClass('d-none'); })
                .attr('src', window.teacherUi.imageUrl(path));
        }
    };

    // ---------- Mobile menu ----------
    $(function () {
        const sidebar = $('#teacherSidebar'), overlay = $('#sidebarOverlay');

        function openMenu()  { sidebar.addClass('open'); overlay.addClass('show'); document.body.style.overflow = 'hidden'; }
        function closeMenu() { sidebar.removeClass('open'); overlay.removeClass('show'); document.body.style.overflow = ''; }

        $('#menuBtn').on('click', openMenu);
        overlay.on('click', closeMenu);
        sidebar.find('a').on('click', closeMenu);
        $(window).on('resize', () => { if (window.innerWidth > 991) closeMenu(); });

        $('#teacherLogout').on('click', function () {
            $(this).prop('disabled', true);

            $.ajax({
                url: '/api/logout',
                type: 'POST',
                headers: { Authorization: 'Bearer ' + window.token, Accept: 'application/json' }
            }).always(function () {
                // Always sign out on this device, even if the request fails
                localStorage.removeItem('api_token');
                localStorage.removeItem('user');
                localStorage.removeItem('teacher_config');
                window.location.href = '/';
            });
        });
    });

    // ---------- One dashboard request, shared with the page ----------
    window.teacherDashboard = $.ajax({
        url: '/api/teacher/dashboard',
        type: 'GET',
        headers: { Authorization: 'Bearer ' + window.token, Accept: 'application/json' }
    });

    window.teacherDashboard.done(function (response) {
        if (!response || response.success === false) return;

        const data = response.data || {};
        const teacher = data.teacher || data.user || data.profile || {};
        const institute = data.institute || {};
        const teacherId = teacher.id;

// const teacherId = teacher.id;

if (teacherId) {
    const profileUrl = '/teacher/profile/' + encodeURIComponent(teacherId);

    $('#sidebarProfileLink').attr('href', profileUrl);
    $('#topbarProfileLink').attr('href', profileUrl);
}
        const configuration = data.configuration || institute.configuration || null;
        const name = teacher.name || data.teacher_name || 'Teacher';
        const ui = window.teacherUi;

        $('#teacherName, #teacherSidebarName').text(name);
        $('#teacherSidebarInitials, #teacherTopbarInitials').text(ui.initialsOf(name));
        $('#instituteName').text(institute.name || 'Your Institute');

        ui.setImage('#teacherProfileImage', teacher.profile_image, '#teacherTopbarInitials');
        ui.setImage('#teacherSidebarImage', teacher.profile_image, '#teacherSidebarInitials');
        ui.setImage('#instituteLogo', institute.logo, '#brandIcon');

        if (configuration) {
            window.applyTeacherTheme(configuration);
            localStorage.setItem('teacher_config', JSON.stringify(configuration));
            
        
        }

        // Kept for pages that still listen for it
        $(document).trigger('teacher:dashboard-loaded', [data]);
    });
//   console.log('jQuery available:', typeof window.jQuery);
//     console.log('$ available:', typeof window.$);

</script>

@stack('scripts')

</body>
</html>
