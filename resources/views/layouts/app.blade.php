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
        :root {
            --navy: #0B1120;
            --lime: #84CC16;
            --lime-dark: #65A30D;
            --lime-light: #ECFCCB;
            --white: #FFFFFF;
            --off-white: #F8FAFC;
            --slate: #64748B;
            --slate-light: #E2E8F0;
            --dark-text: #111827;
            --danger: #DC2626;
            --warning: #D97706;
            --success: #16A34A;
            --sidebar-width: 256px;
            --shadow-sm: 0 1px 2px rgba(16, 24, 40, 0.04), 0 1px 3px rgba(16, 24, 40, 0.06);
            --shadow-md: 0 8px 24px -8px rgba(101, 163, 13, 0.25);
        }

        * { box-sizing: border-box; }

        html {
            scrollbar-width: thin;
            scrollbar-color: rgba(100, 116, 139, 0.35) transparent;
        }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, 0.3);
            border-radius: 8px;
        }
        ::-webkit-scrollbar-thumb:hover { background: rgba(100, 116, 139, 0.5); }

        body {
            margin: 0;
            color: var(--dark-text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            /* soft lime glow behind the content */
            background:
                radial-gradient(900px 520px at 100% -5%, rgba(132, 204, 22, 0.16), transparent 60%),
                radial-gradient(800px 600px at 15% 110%, rgba(132, 204, 22, 0.12), transparent 60%),
                linear-gradient(180deg, #F7FBEF 0%, #F8FAFC 45%, #F4F9EA 100%);
            background-attachment: fixed;
        }

        a { text-decoration: none; }

        .app-wrapper { min-height: 100vh; }

        /* ================= Sidebar ================= */

        .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            height: 100dvh;
            background: linear-gradient(180deg, #8FD81E 0%, #84CC16 50%, #6FB10F 100%);
            z-index: 1050;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* no scrollbar on the sidebar itself */
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
            color: var(--lime);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
            box-shadow: 0 6px 14px -4px rgba(11, 17, 32, 0.45);
        }

        .brand-text { color: var(--navy); line-height: 1.1; }
        .brand-text strong { display: block; font-size: 15px; font-weight: 700; }
        .brand-text span {
            display: block;
            margin-top: 4px;
            font-size: 11px;
            font-weight: 600;
            opacity: 0.7;
        }

        /* Nav scrolls inside itself only if really needed, with the bar hidden */
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
            position: relative;
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
            background: var(--navy);
            color: var(--white);
            box-shadow: 0 8px 18px -8px rgba(11, 17, 32, 0.6);
        }

        .sidebar-nav .nav-link.active i,
        .sidebar-nav .nav-item.active i,
        .sidebar-nav .sidebar-nav-item.active i {
            color: var(--lime);
        }

        .sidebar-nav .sidebar-section-label {
            margin: 14px 8px 8px;
            color: rgba(11, 17, 32, 0.6);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        /* Backwards-compat: pages that still nest brand/footer inside @section('sidebar') */
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
            gap: 10px;
            padding: 10px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(6px);
        }

        .sidebar-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--navy);
            color: var(--lime);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
            flex-shrink: 0;
        }

        .sidebar-user-info { min-width: 0; flex: 1; }

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
        .sidebar-nav a:focus-visible {
            outline: 2px solid var(--navy);
            outline-offset: 2px;
        }

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
            background: var(--lime-light);
            color: var(--navy);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            font-size: 20px;
        }

        .page-heading h1 { margin: 0; font-size: 21px; font-weight: 700; color: var(--dark-text); }
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
            background: var(--lime-light);
            color: var(--navy);
            border-color: var(--lime);
        }

        .topbar-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-left: 15px;
            border-left: 1px solid var(--slate-light);
        }

        .topbar-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
            flex-shrink: 0;
            background: var(--navy);
            color: var(--lime);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 0 0 2px var(--white), 0 0 0 4px rgba(132, 204, 22, 0.55);
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

        .topbar-profile-info strong { display: block; font-size: 13px; font-weight: 700; }
        .topbar-profile-info span { display: block; color: var(--slate); font-size: 11px; margin-top: 2px; }

        /* ================= Content ================= */

        .app-content { padding: 30px; }
        .content-container { max-width: 1500px; margin: 0 auto; }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }
        .section-header h2 { margin: 0; font-size: 19px; font-weight: 700; }
        .section-header p { margin: 5px 0 0; color: var(--slate); font-size: 13px; }

        .btn-lime {
            background: var(--lime);
            border: 1px solid var(--lime);
            color: var(--navy);
            font-weight: 700;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13px;
            transition: 0.2s;
        }
        .btn-lime:hover { background: var(--lime-dark); border-color: var(--lime-dark); color: var(--white); }

        .btn-navy {
            background: var(--navy);
            border: 1px solid var(--navy);
            color: var(--white);
            font-weight: 600;
            padding: 9px 16px;
            border-radius: 8px;
            font-size: 13px;
        }
        .btn-navy:hover { background: #182238; color: var(--white); }

        .content-card {
            background: var(--white);
            border: 1px solid var(--slate-light);
            border-radius: 14px;
            padding: 22px;
            box-shadow: var(--shadow-sm);
        }

        .form-label { font-size: 13px; font-weight: 600; color: var(--dark-text); }

        .form-control,
        .form-select {
            min-height: 42px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 13px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--lime);
            box-shadow: 0 0 0 3px rgba(132, 204, 22, 0.18);
        }

        .app-alert { border: 0; border-radius: 10px; font-size: 13px; }

        /* Shared table button (used by dashboard + list pages) */
        .dashboard-table thead tr::after {
            content: "";
            display: table-cell;
            background: var(--off-white);
            border-bottom: 1px solid var(--slate-light);
        }
        .dashboard-table tbody td:last-child { text-align: right; white-space: nowrap; }

        .dashboard-table .btn,
        .dashboard-table .btn-warning {
            background: var(--lime-light);
            border: 1px solid transparent;
            color: var(--lime-dark);
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
            padding: 8px 14px;
            border-radius: 8px;
            transition: 0.2s;
        }
        .dashboard-table .btn:hover,
        .dashboard-table .btn-warning:hover { background: var(--lime); color: var(--navy); }

        .dashboard-table .table-primary-info { min-width: 170px; }
        .dashboard-table .table-avatar { object-fit: cover; background: var(--white); }

        .quick-action { font-family: inherit; }
        .quick-action-content span a { color: var(--lime-dark); font-weight: 600; }
        .quick-action-content span a:hover { color: var(--navy); }

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
            .topbar-profile { border-left: 0; padding-left: 0; }
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
            @yield('sidebar')
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-avatar" id="sidebarAvatar">SA</div>

                <div class="sidebar-user-info">
                    <span class="sidebar-user-name" id="sidebarUserName">Super Admin</span>
                    <span class="sidebar-user-role" id="sidebarUserRole">@yield('user-role', 'Administrator')</span>
                </div>

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
                <button type="button" class="topbar-icon-btn" id="notificationBtn" aria-label="Notifications">
                    <i class="bi bi-bell"></i>
                </button>

                <div class="topbar-profile">
                    <div class="topbar-avatar" id="topbarAvatar">
                        <span id="avatarInitials">SA</span>
                        <img id="Avatar" src="" alt="">
                    </div>

                    <div class="topbar-profile-info">
                        <strong id="topbarUserName">Super Admin</strong>
                        <span id="topbarUserRole">Administrator</span>
                    </div>
                </div>
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
    });

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

    // Load the signed-in admin's profile into the topbar + sidebar
    $.ajax({
        url: '/api/superAdmin/profile',
        type: 'GET',
        headers: { 'Authorization': 'Bearer ' + token },
        success: function (response) {
            const data = response.data || {};

            if (data.name) {
                const initials = data.name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
                $('#topbarUserName, #sidebarUserName').text(data.name);
                $('#avatarInitials, #sidebarAvatar').text(initials);
            }

            if (data.profile_image) {
                const img = document.getElementById('Avatar');
                img.onerror = function () {
                    document.getElementById('topbarAvatar').classList.remove('has-image');
                };
                img.onload = function () {
                    document.getElementById('topbarAvatar').classList.add('has-image');
                };
                img.src = '/storage/' + data.profile_image;
            }
             document.getElementById('profileLink').href = '/super-admin/profile/' + response.data.id;
            //  console.log("admin id",response.data.id);
        }
    });
    document.getElementById('logout').addEventListener('click', function () {
        const btn = this;
        btn.disabled = true;

        $.ajax({
            url: '/api/logout',
            type: 'POST',
            headers: { 'Authorization': 'Bearer ' + token },
            complete: function () {
                // Always clear the session on the client, even if the API call fails
                localStorage.removeItem('api_token');
                window.location.href = '/';
            }
        });
    });
</script>

@stack('scripts')

</body>
</html>