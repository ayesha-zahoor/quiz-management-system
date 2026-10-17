<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Quiz Management System')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /*
         | Colors come from the institute configuration set by the super admin.
         | The values below are only defaults until the configuration loads.
         | Light / dark shades are derived from the primary color automatically.
         */
        :root {
            --primary-color: #84CC16;
            --secondary-color: #2563EB;
            --accent-color: #F59E0B;
            --background-color: #F8FAFC;
            --text-color: #111827;

            --primary-dark: color-mix(in srgb, var(--primary-color) 78%, black);
            --primary-light: color-mix(in srgb, var(--primary-color) 16%, white);
            --on-primary: #0B1120; /* readable text color on top of the primary color */

            /* Aliases so older pages that use the "lime" names keep working */
            --lime: var(--primary-color);
            --lime-dark: var(--primary-dark);
            --lime-light: var(--primary-light);

            --navy: #0B1120;
            --white: #FFFFFF;
            --off-white: #F8FAFC;
            --slate: #64748B;
            --slate-light: #E2E8F0;
            --dark-text: var(--text-color);

            --danger: #DC2626;
            --warning: #D97706;
            --success: #16A34A;

            --sidebar-width: 256px;
            --shadow-sm: 0 1px 2px rgba(16, 24, 40, 0.04), 0 1px 3px rgba(16, 24, 40, 0.06);
            --shadow-md: 0 10px 26px -10px color-mix(in srgb, var(--primary-color) 45%, transparent);
        }

        * { box-sizing: border-box; }

        html {
            scrollbar-width: thin;
            scrollbar-color: rgba(100, 116, 139, 0.35) transparent;
        }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(100, 116, 139, 0.3); border-radius: 8px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(100, 116, 139, 0.5); }

        body {
            margin: 0;
            color: var(--text-color);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            /* soft glow that follows the institute's primary color */
            background:
                radial-gradient(900px 520px at 100% -5%, color-mix(in srgb, var(--primary-color) 16%, transparent), transparent 60%),
                radial-gradient(800px 600px at 10% 110%, color-mix(in srgb, var(--primary-color) 11%, transparent), transparent 60%),
                var(--background-color);
            background-attachment: fixed;
        }

        a { text-decoration: none; color: var(--primary-color); }
        a:hover { color: var(--secondary-color); }

        .app-wrapper { min-height: 100vh; }

        /* ================= Sidebar ================= */

        .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            height: 100dvh;
            background: linear-gradient(180deg,
                color-mix(in srgb, var(--primary-color) 90%, white) 0%,
                var(--primary-color) 50%,
                var(--primary-dark) 100%);
            z-index: 1050;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* the sidebar itself never shows a scrollbar */
        }

        .sidebar-brand {
            flex: 0 0 auto;
            min-height: 78px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(11, 17, 32, 0.12);
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 11px;
            background: var(--navy);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 6px 14px -4px rgba(11, 17, 32, 0.45);
        }

        .brand-text { color: var(--navy); line-height: 1.1; }
        .brand-text strong { display: block; font-size: 15px; font-weight: 700; }
        .brand-text span { display: block; margin-top: 4px; font-size: 11px; font-weight: 600; opacity: 0.7; }

        .sidebar-nav {
            flex: 1 1 auto;
            min-height: 0;
            padding: 14px 12px;
            overflow-y: auto;
            scrollbar-width: none;
        }
        .sidebar-nav::-webkit-scrollbar { display: none; }

        .sidebar-nav .nav-link,
        .sidebar-nav .nav-item,
        .sidebar-nav .sidebar-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 44px;
            padding: 10px 13px;
            margin-bottom: 4px;
            color: rgba(11, 17, 32, 0.78);
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .sidebar-nav .nav-link i,
        .sidebar-nav .nav-item i,
        .sidebar-nav .sidebar-nav-item i {
            width: 20px;
            font-size: 17px;
            text-align: center;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-item:hover,
        .sidebar-nav .sidebar-nav-item:hover {
            background: rgba(255, 255, 255, 0.4);
            color: var(--navy);
        }

        .sidebar-nav .nav-link.active,
        .sidebar-nav .nav-item.active,
        .sidebar-nav .sidebar-nav-item.active {
            background: var(--secondary-color);
            color: var(--white);
            box-shadow: 0 8px 18px -8px rgba(11, 17, 32, 0.6);
        }

        .sidebar-nav .nav-link.active i,
        .sidebar-nav .nav-item.active i,
        .sidebar-nav .sidebar-nav-item.active i {
            color: var(--accent-color);
        }

        .sidebar-nav .sidebar-section-label {
            margin: 14px 8px 8px;
            color: rgba(11, 17, 32, 0.6);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        /* Pages that still nest a brand / footer inside @section('sidebar') */
        .sidebar-nav > .sidebar-brand,
        .sidebar-nav > .sidebar-footer { display: none; }
        .sidebar-nav .sidebar-nav { padding: 0; overflow: visible; }

        /* ---- Footer / user card ---- */
        .sidebar-footer {
            flex: 0 0 auto;
            padding: 14px;
            border-top: 1px solid rgba(11, 17, 32, 0.12);
        }

        .sidebar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(6px);
        }

        .sidebar-user-link {
            flex: 1;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 2px;
            border-radius: 9px;
            color: inherit;
            transition: background 0.2s ease;
        }
        .sidebar-user-link:hover { background: rgba(255, 255, 255, 0.4); color: inherit; }

        .sidebar-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--navy);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
        }

        .sidebar-user-info { min-width: 0; }

        .sidebar-user-name {
            display: block;
            color: var(--navy);
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            display: block;
            color: rgba(11, 17, 32, 0.65);
            font-size: 11px;
            margin-top: 2px;
        }

        .logout-btn {
            flex: 0 0 auto;
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 10px;
            background: var(--navy);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.2s ease;
        }
        .logout-btn:hover { background: var(--danger); }
        .logout-btn:active { transform: scale(0.94); }
        .logout-btn:focus-visible,
        .sidebar-nav a:focus-visible,
        .sidebar-user-link:focus-visible { outline: 2px solid var(--navy); outline-offset: 2px; }

        /* ================= Main ================= */

        .app-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            min-width: 0;
        }

        .app-topbar {
            height: 78px;
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--slate-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .topbar-left { display: flex; align-items: center; gap: 15px; }

        .mobile-menu-btn {
            display: none;
            border: 0;
            background: var(--primary-light);
            color: var(--primary-dark);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            font-size: 20px;
        }
        .mobile-menu-btn:hover { background: var(--primary-color); color: var(--on-primary); }

        .page-heading h1 { margin: 0; font-size: 21px; font-weight: 700; color: var(--text-color); }
        .page-heading p { margin: 4px 0 0; color: var(--slate); font-size: 13px; }

        .topbar-right { display: flex; align-items: center; gap: 15px; }

        .topbar-icon-btn {
            width: 40px;
            height: 40px;
            border: 1px solid var(--slate-light);
            border-radius: 10px;
            background: var(--white);
            color: var(--slate);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }
        .topbar-icon-btn:hover {
            background: var(--primary-light);
            color: var(--primary-dark);
            border-color: var(--primary-color);
        }

        /* Clicking the photo or name opens the admin's profile */
        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 8px 4px 15px;
            margin-left: 4px;
            border-left: 1px solid var(--slate-light);
            border-radius: 0 12px 12px 0;
            color: inherit;
            transition: background 0.2s ease;
        }
        .topbar-profile:hover { background: var(--primary-light); color: inherit; }
        .topbar-profile:focus-visible { outline: 2px solid var(--primary-color); outline-offset: 2px; }

        .topbar-avatar {
            position: relative;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            background: var(--primary-color);
            color: var(--on-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 0 0 2px var(--white), 0 0 0 4px color-mix(in srgb, var(--primary-color) 55%, transparent);
            transition: box-shadow 0.2s ease;
        }
        .topbar-profile:hover .topbar-avatar {
            box-shadow: 0 0 0 2px var(--white), 0 0 0 4px var(--primary-color);
        }

        .topbar-avatar img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        .topbar-avatar.has-image img { display: block; }

        .topbar-profile-info strong { display: block; font-size: 13px; font-weight: 700; color: var(--text-color); }
        .topbar-profile-info span { display: block; color: var(--slate); font-size: 11px; margin-top: 2px; }

        /* ================= Content ================= */

        .app-content { padding: 30px; min-height: calc(100vh - 78px); }
        .content-container { max-width: 1500px; margin: 0 auto; }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }
        .section-header h2 { margin: 0; font-size: 19px; font-weight: 700; color: var(--text-color); }
        .section-header p { margin: 5px 0 0; color: var(--slate); font-size: 13px; }

        /* Buttons (kept as before) */
        .btn-lime {
            background: var(--primary-color);
            border: 1px solid var(--primary-color);
            color: var(--on-primary);
            font-weight: 700;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13px;
            transition: 0.2s;
        }
        .btn-lime:hover { background: var(--primary-dark); border-color: var(--primary-dark); color: var(--white); }

        .btn-navy {
            background: var(--secondary-color);
            border: 1px solid var(--secondary-color);
            color: var(--white);
            font-weight: 600;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13px;
        }
        .btn-navy:hover { background: var(--primary-color); border-color: var(--primary-color); color: var(--on-primary); }

        .btn-primary { background: var(--primary-color); border-color: var(--primary-color); color: var(--on-primary); }
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active { background: var(--primary-dark) !important; border-color: var(--primary-dark) !important; color: var(--white) !important; }

        .btn-secondary { background: var(--secondary-color); border-color: var(--secondary-color); color: var(--white); }
        .btn-secondary:hover,
        .btn-secondary:focus { background: var(--primary-color); border-color: var(--primary-color); color: var(--on-primary); }

        .btn-accent { background: var(--accent-color); border-color: var(--accent-color); color: var(--white); font-weight: 600; }
        .btn-accent:hover { opacity: 0.9; color: var(--white); }

        .content-card {
            background: var(--white);
            border: 1px solid var(--slate-light);
            border-radius: 14px;
            padding: 22px;
            box-shadow: var(--shadow-sm);
        }

        .form-label { font-size: 13px; font-weight: 600; color: var(--text-color); }

        .form-control,
        .form-select {
            min-height: 42px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 13px;
            color: var(--text-color);
            background-color: var(--white);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary-color) 18%, transparent);
        }

        .app-alert { border: 0; border-radius: 10px; font-size: 13px; }

        /* Shared table helpers */
        .dashboard-table tbody td:last-child { text-align: right; white-space: nowrap; }

        .dashboard-table .btn,
        .dashboard-table .btn-warning {
            background: var(--primary-light);
            border: 1px solid transparent;
            color: var(--primary-dark);
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
            padding: 8px 14px;
            border-radius: 8px;
            transition: 0.2s;
        }
        .dashboard-table .btn:hover,
        .dashboard-table .btn-warning:hover { background: var(--primary-color); color: var(--on-primary); }
        .dashboard-table .table-primary-info { min-width: 0; }
        .dashboard-table .table-avatar { object-fit: cover; background: var(--white); }

        .quick-action { font-family: inherit; }
        .quick-action-content span a { color: var(--primary-color); font-weight: 600; }
        .quick-action-content span a:hover { color: var(--secondary-color); }

        .text-success { color: var(--success) !important; }
        .text-danger  { color: var(--danger) !important; }
        .text-warning { color: var(--warning) !important; }
        .bg-success   { background-color: var(--success) !important; }
        .bg-danger    { background-color: var(--danger) !important; }
        .bg-warning   { background-color: var(--warning) !important; }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        textarea:-webkit-autofill,
        textarea:-webkit-autofill:hover,
        textarea:-webkit-autofill:focus,
        select:-webkit-autofill,
        select:-webkit-autofill:hover,
        select:-webkit-autofill:focus {
            -webkit-text-fill-color: var(--text-color);
            -webkit-box-shadow: 0 0 0 1000px var(--white) inset;
            transition: background-color 5000s ease-in-out 0s;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(11, 17, 32, 0.45);
            z-index: 1040;
        }

        /* ================= Responsive ================= */

        @media (max-width: 991.98px) {
            .app-sidebar { transform: translateX(-100%); transition: transform 0.25s ease; }
            .app-sidebar.open { transform: translateX(0); }
            .sidebar-overlay.show { display: block; }
            .app-main { margin-left: 0; }
            .mobile-menu-btn { display: flex; align-items: center; justify-content: center; }
            .app-topbar { padding: 0 20px; }
            .app-content { padding: 22px 20px; }
        }

        @media (max-width: 767.98px) {
            .app-topbar { height: 68px; }
            .page-heading p { display: none; }
            .topbar-profile-info { display: none; }
            .topbar-profile { border-left: 0; padding-left: 8px; margin-left: 0; }
            .topbar-icon-btn { display: none; }
            .section-header { align-items: flex-start; flex-direction: column; }
            .section-header .btn-lime,
            .section-header .btn-navy { width: 100%; }
            .app-content { padding: 18px 15px; }
            .content-card { padding: 17px; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; }
        }
    </style>

    {{-- Apply the last known institute colors immediately, so the page doesn't flash the default colors --}}
    <script>
        window.applyInstituteTheme = function (config) {
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

            // Dark or light text on top of the primary color, whichever is readable
            const hex = (config.primary_color || '').replace('#', '');

            if (/^[0-9a-f]{6}$/i.test(hex)) {
                const r = parseInt(hex.substr(0, 2), 16),
                      g = parseInt(hex.substr(2, 2), 16),
                      b = parseInt(hex.substr(4, 2), 16);

                root.setProperty('--on-primary', (r * 299 + g * 587 + b * 114) / 1000 > 150 ? '#0B1120' : '#FFFFFF');
            }
        };

        try {
            window.applyInstituteTheme(JSON.parse(localStorage.getItem('institute_config') || 'null'));
        } catch (e) {}
    </script>

    @stack('styles')
</head>

<body>

<div class="app-wrapper">

    <aside class="app-sidebar" id="appSidebar">

        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="bi bi-patch-question-fill"></i>
            </div>

            <div class="brand-text">
                <strong>Quiz Management</strong>
                <span>Learning Platform</span>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Main</div>

            <a href="/instituteAdmin/dashboard"
               class="nav-item {{ request()->is('instituteAdmin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
              <a href="/instituteAdmin/classes"
               class="nav-item {{ request()->is('instituteAdmin/classes*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Classes</span>
            </a>

            <a href="/instituteAdmin/subjects"
               class="nav-item {{ request()->is('instituteAdmin/subjects*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>Subjects</span>
            </a>

            <a href="/instituteAdmin/students"
               class="nav-item {{ request()->is('instituteAdmin/students*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Students</span>
            </a>

            <a href="/instituteAdmin/teachers"
               class="nav-item {{ request()->is('instituteAdmin/teachers*') ? 'active' : '' }}">
                <i class="bi bi-person-workspace"></i>
                <span>Teachers</span>
            </a>

            <a href="/instituteAdmin/results" class=" nav-item {{ request()->is('instituteAdmin/results*') ? 'active' : '' }}">
    <i class="bi bi-bar-chart-line"></i>
     <span>Results</span>
</a>
            <div class="sidebar-section-label">Account</div>
            <a href="#" id="profileLink"
               class="nav-item js-profile-link {{ request()->is('instituteAdmin/profile*') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">

                <a href="#" class="sidebar-user-link js-profile-link" title="View and update your profile">
                    <div class="sidebar-avatar" id="sidebarInitials">IA</div>

                    <div class="sidebar-user-info">
                        <span class="sidebar-user-name" id="sidebarUserName">Institute Admin</span>
                        <span class="sidebar-user-role" id="sidebarUserRole">@yield('user-role', 'Administrator')</span>
                    </div>
                </a>

                <button type="button" id="logout" class="logout-btn" title="Log out" aria-label="Log out">
                    <i class="bi bi-box-arrow-right"></i>
                </button>

            </div>
        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <main class="app-main">

        <header class="app-topbar">

            <div class="topbar-left">
                <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Open navigation">
                    <i class="bi bi-list"></i>
                </button>

                <div class="page-heading">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                    <p>@yield('page-description', 'Quiz Management System')</p>
                </div>
            </div>

            <div class="topbar-right">

                {{-- Click the photo or name to open and update your profile --}}
                <a href="#" class="topbar-profile js-profile-link" id="topbarProfile" title="View and update your profile">

                    <div class="topbar-avatar" id="topbarAvatar">
                        <span id="avatarInitials">IA</span>
                        <img id="Avatar" src="" alt="">
                    </div>

                    <div class="topbar-profile-info">
                        <strong id="topbarUserName">Institute Admin</strong>
                        <span id="topbarUserRole">View profile</span>
                    </div>

                </a>

            </div>

        </header>

        <div class="app-content">
            <div class="content-container">
                <div id="globalAlertContainer"></div>
                @yield('content')
            </div>
        </div>

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    // Adjust these to your routes
    const PROFILE_PAGE_URL = '/instituteAdmin/profile';   // the page itself is /instituteAdmin/profile/{id}
    const PROFILE_API_URL  = '/api/superAdmin/profile/';   // returns the signed-in admin (name, profile_image)

    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('appSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);

        document.querySelectorAll('.app-sidebar .sidebar-nav a').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 991) closeSidebar();
            });
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 991) closeSidebar();
        });

        // Use the id remembered from the last visit so the links work straight away
        setProfileLinks(localStorage.getItem('admin_id'));
    });

    // Every profile link (top bar photo and name, sidebar card, "Profile" menu item) opens /instituteAdmin/profile/{id}
    function setProfileLinks(id) {
        if (!id) return;

        document.querySelectorAll('.js-profile-link').forEach(function (link) {
            link.setAttribute('href', PROFILE_PAGE_URL + '/' + id);
        });
    }

    function showGlobalAlert(message, type = 'success') {
        const container = document.getElementById('globalAlertContainer');
        if (!container) return;

        const iconMap = {
            success: 'bi-check-circle-fill',
            danger: 'bi-exclamation-circle-fill',
            warning: 'bi-exclamation-triangle-fill',
            info: 'bi-info-circle-fill'
        };

        container.innerHTML = `
            <div class="alert alert-${type} app-alert alert-dismissible fade show mb-4" role="alert">
                <i class="bi ${iconMap[type] || iconMap.info} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    }

    function setButtonLoading(button, loading, loadingText = 'Loading...') {
        if (!button) return;

        if (loading) {
            button.dataset.originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = `<span class="spinner-border spinner-border-sm me-2"></span>${loadingText}`;
        } else {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText || 'Submit';
        }
    }

    window.token = localStorage.getItem('api_token');

    // Signed-in admin: photo, name, initials
    $.ajax({
        url: PROFILE_API_URL,
        type: 'GET',
        headers: { 'Authorization': 'Bearer ' + token },
        success: function (response) {
            const user = response.data || {};
            window.currentUser = user;

            if (user.name) {
                const initials = user.name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
                $('#topbarUserName, #sidebarUserName').text(user.name);
                $('#avatarInitials, #sidebarInitials').text(initials);
            }
            console.log(user);

            if (user.profile_image) {
                const img = document.getElementById('Avatar');
                img.onload = () => document.getElementById('topbarAvatar').classList.add('has-image');
                img.onerror = () => document.getElementById('topbarAvatar').classList.remove('has-image');
                img.src = '/storage/' + user.profile_image;
            }

            if (user.id) {
                localStorage.setItem('admin_id', user.id);
                setProfileLinks(user.id);
            }

            // Lets any page react (for example the dashboard greeting)
            $(document).trigger('user:loaded', [user]);
        }
    });

    // Institute configuration (colors). Pages can reuse this same request instead of calling the API twice.
    window.instituteDashboard = $.ajax({
        url: '/api/instituteAdmin/dashboard',
        type: 'GET',
        headers: { 'Authorization': 'Bearer ' + token }
    });

    window.instituteDashboard.done(function (response) {
        const configuration = response?.data?.institute?.configuration;

        if (configuration) {
            window.applyInstituteTheme(configuration);
            localStorage.setItem('institute_config', JSON.stringify(configuration));
        }
    });

    document.getElementById('logout').addEventListener('click', function () {
        this.disabled = true;

        $.ajax({
            url: '/api/logout',
            type: 'POST',
            headers: { 'Authorization': 'Bearer ' + token },
            complete: function () {
                // Always sign out on this device, even if the request fails
                localStorage.removeItem('api_token');
                localStorage.removeItem('institute_config');
                localStorage.removeItem('admin_id');
                window.location.href = '/';
            }
        });
    });
</script>

@stack('scripts')

</body>
</html>