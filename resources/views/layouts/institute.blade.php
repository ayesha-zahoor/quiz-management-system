<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Quiz Management System')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

   <style>
    :root {
        --primary-color: #84CC16;
        --primary-dark: #65A30D;
        --primary-light: #ECFCCB;

        --secondary-color: #2563EB;
        --accent-color: #F59E0B;
        --background-color: #F8FAFC;
        --text-color: #111827;

        --navy: #0B1120;
        --white: #FFFFFF;
        --off-white: #F8FAFC;
        --slate: #64748B;
        --slate-light: #E2E8F0;
        --dark-text: #111827;

        --danger: #DC2626;
        --warning: #D97706;
        --success: #16A34A;

        --sidebar-width: 250px;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background: var(--background-color);
        color: var(--text-color);
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
    }

    a {
        text-decoration: none;
        color: var(--primary-color);
    }

    a:hover {
        color: var(--secondary-color);
    }

    .app-wrapper {
        min-height: 100vh;
    }

    /* Sidebar */

    .app-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: var(--sidebar-width);
        height: 100vh;
        background: var(--primary-color);
        z-index: 1050;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
    }

    .sidebar-brand {
        min-height: 78px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid rgba(11, 17, 32, 0.12);
    }

    .brand-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--navy);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .brand-text {
        color: var(--navy);
        line-height: 1.1;
    }

    .brand-text strong {
        display: block;
        font-size: 15px;
        font-weight: 700;
    }

    .brand-text span {
        display: block;
        margin-top: 4px;
        font-size: 10px;
        font-weight: 600;
        opacity: 0.7;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .sidebar-role {
        margin: 20px 18px 10px;
        color: rgba(11, 17, 32, 0.6);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .sidebar-nav {
        padding: 0 12px;
        flex: 1;
    }

    .sidebar-nav .nav-link,
    .sidebar-nav .nav-item,
    .sidebar-nav .sidebar-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 45px;
        padding: 10px 13px;
        margin-bottom: 4px;
        color: rgba(11, 17, 32, 0.75);
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.2s ease;
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
        background: rgba(255, 255, 255, 0.38);
        color: var(--navy);
    }

    .sidebar-nav .nav-link.active,
    .sidebar-nav .nav-item.active,
    .sidebar-nav .sidebar-nav-item.active {
        background: var(--secondary-color);
        color: var(--white);
    }

    .sidebar-nav .nav-link.active i,
    .sidebar-nav .nav-item.active i,
    .sidebar-nav .sidebar-nav-item.active i {
        color: var(--accent-color);
    }

    .sidebar-nav .sidebar-section-label {
        margin: 18px 6px 8px;
        color: rgba(11, 17, 32, 0.6);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .sidebar-nav > .sidebar-brand,
    .sidebar-nav > .sidebar-footer {
        display: none;
    }

    .sidebar-nav .sidebar-nav {
        padding: 0;
    }

    .sidebar-footer {
        padding: 15px 14px;
        border-top: 1px solid rgba(11, 17, 32, 0.12);
    }

    .sidebar-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px;
        border-radius: 9px;
        background: rgba(255, 255, 255, 0.3);
    }

    .sidebar-avatar {
        width: 36px;
        height: 36px;
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

    .sidebar-user-info {
        min-width: 0;
    }

    .sidebar-user-name {
        display: block;
        color: var(--navy);
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sidebar-user-role {
        display: block;
        color: rgba(11, 17, 32, 0.6);
        font-size: 10px;
        margin-top: 2px;
    }

    /* Main */

    .app-main {
        margin-left: var(--sidebar-width);
        min-height: 100vh;
        background: var(--background-color);
    }

    /* Topbar */

    .app-topbar {
        height: 78px;
        background: var(--white);
        border-bottom: 1px solid var(--slate-light);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 30px;
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .topbar-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .mobile-menu-btn {
        display: none;
        border: 0;
        background: var(--primary-light);
        color: var(--primary-color);
        width: 40px;
        height: 40px;
        border-radius: 8px;
        font-size: 20px;
    }

    .mobile-menu-btn:hover {
        background: var(--primary-color);
        color: var(--white);
    }

    .page-heading h1 {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: var(--text-color);
    }

    .page-heading p {
        margin: 4px 0 0;
        color: var(--slate);
        font-size: 12px;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .topbar-icon-btn {
        width: 38px;
        height: 38px;
        border: 1px solid var(--slate-light);
        border-radius: 8px;
        background: var(--white);
        color: var(--slate);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s;
    }

    .topbar-icon-btn:hover {
        background: var(--primary-light);
        color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .topbar-profile {
        display: flex;
        align-items: center;
        gap: 9px;
        padding-left: 12px;
        border-left: 1px solid var(--slate-light);
    }

    .topbar-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        flex-shrink: 0;
        background: var(--primary-color);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
    }

    .topbar-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        position: static;
        border-radius: 50%;
    }

    .topbar-profile-info strong {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-color);
    }

    .topbar-profile-info span {
        display: block;
        color: var(--slate);
        font-size: 10px;
        margin-top: 2px;
    }

    /* Content */

    .app-content {
        padding: 30px;
        background: var(--background-color);
        min-height: calc(100vh - 78px);
    }

    .content-container {
        max-width: 1500px;
        margin: 0 auto;
    }

    /* General UI */

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .section-header h2 {
        margin: 0;
        font-size: 19px;
        font-weight: 700;
        color: var(--text-color);
    }

    .section-header p {
        margin: 5px 0 0;
        color: var(--slate);
        font-size: 13px;
    }

    /* Primary button */

    .btn-lime {
        background: var(--primary-color);
        border: 1px solid var(--primary-color);
        color: var(--white);
        font-weight: 700;
        padding: 9px 16px;
        border-radius: 7px;
        font-size: 13px;
        transition: 0.2s;
    }

    .btn-lime:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        color: var(--white);
    }

    /* Secondary button */

    .btn-navy {
        background: var(--secondary-color);
        border: 1px solid var(--secondary-color);
        color: var(--white);
        font-weight: 600;
        padding: 9px 16px;
        border-radius: 7px;
        font-size: 13px;
    }

    .btn-navy:hover {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--white);
    }

    /* Bootstrap primary buttons */

    .btn-primary {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--white);
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        color: var(--white);
    }

    /* Bootstrap secondary buttons */

    .btn-secondary {
        background: var(--secondary-color);
        border-color: var(--secondary-color);
        color: var(--white);
    }

    .btn-secondary:hover,
    .btn-secondary:focus {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: var(--white);
    }

    /* Accent button */

    .btn-accent {
        background: var(--accent-color);
        border-color: var(--accent-color);
        color: var(--white);
        font-weight: 600;
    }

    .btn-accent:hover {
        opacity: 0.9;
        color: var(--white);
    }

    /* Content card */

    .content-card {
        background: var(--white);
        border: 1px solid var(--slate-light);
        border-radius: 10px;
        padding: 22px;
    }

    /* Forms */

    .form-label {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-color);
    }

    .form-control,
    .form-select {
        min-height: 42px;
        border: 1px solid #CBD5E1;
        border-radius: 7px;
        font-size: 13px;
        color: var(--text-color);
        background-color: var(--white);
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px color-mix(
            in srgb,
            var(--primary-color) 15%,
            transparent
        );
    }

    /* Alerts */

    .app-alert {
        border: 0;
        border-radius: 8px;
        font-size: 13px;
    }

    /* Dashboard table */

    .dashboard-table thead tr::after {
        content: "";
        display: table-cell;
        background: var(--off-white);
        border-bottom: 1px solid var(--slate-light);
    }

    .dashboard-table tbody td:last-child {
        text-align: right;
        white-space: nowrap;
    }

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
        border-radius: 6px;
        transition: 0.2s;
    }

    .dashboard-table .btn:hover,
    .dashboard-table .btn-warning:hover {
        background: var(--primary-color);
        color: var(--white);
    }

    .dashboard-table .table-primary-info {
        min-width: 170px;
    }

    .dashboard-table .table-avatar {
        object-fit: cover;
        background: var(--white);
    }

    /* Quick actions */

    .quick-action {
        font-family: inherit;
    }

    .quick-action-content span a {
        color: var(--primary-color);
        font-weight: 600;
    }

    .quick-action-content span a:hover {
        color: var(--secondary-color);
    }

    /* Status colors */

    .text-success {
        color: var(--success) !important;
    }

    .text-danger {
        color: var(--danger) !important;
    }

    .text-warning {
        color: var(--warning) !important;
    }

    .bg-success {
        background-color: var(--success) !important;
    }

    .bg-danger {
        background-color: var(--danger) !important;
    }

    .bg-warning {
        background-color: var(--warning) !important;
    }

    /* Autofill */

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
        -webkit-box-shadow: 0 0 0px 1000px var(--white) inset;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* Overlay */

    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(11, 17, 32, 0.45);
        z-index: 1040;
    }

    /* Responsive */

    @media (max-width: 991.98px) {

        :root {
            --sidebar-width: 250px;
        }

        .app-sidebar {
            transform: translateX(-100%);
            transition: transform 0.25s ease;
        }

        .app-sidebar.open {
            transform: translateX(0);
        }

        .sidebar-overlay.show {
            display: block;
        }

        .app-main {
            margin-left: 0;
        }

        .mobile-menu-btn {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .app-topbar {
            padding: 0 20px;
        }

        .app-content {
            padding: 22px 20px;
        }
    }

    @media (max-width: 767.98px) {

        .app-topbar {
            height: 68px;
        }

        .page-heading p {
            display: none;
        }

        .topbar-profile-info {
            display: none;
        }

        .topbar-profile {
            border-left: 0;
            padding-left: 0;
        }

        .topbar-icon-btn {
            display: none;
        }

        .section-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .section-header .btn-lime,
        .section-header .btn-navy {
            width: 100%;
        }

        .app-content {
            padding: 18px 15px;
        }

        .content-card {
            padding: 17px;
        }
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

        <div class="sidebar-role">
            @yield('user-role', 'Super Admin')
        </div>

        <nav class="sidebar-nav">

            @yield('sidebar')

        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user">
               

                <div class="sidebar-user-info">
                    <span class="sidebar-user-name" id="sidebarUserName">
                        Super Admin
                    </span>

                    <span class="sidebar-user-role" id="sidebarUserRole">
                        Administrator
                    </span>
                </div>
                <button id="logout" class="btn btn-secondary">Logout</button>
            </div>
        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <main class="app-main">

        <header class="app-topbar">

            <div class="topbar-left">

                <button
                    type="button"
                    class="mobile-menu-btn"
                    id="mobileMenuBtn"
                    aria-label="Open navigation"
                >
                    <i class="bi bi-list"></i>
                </button>

                <div class="page-heading">
                    <h1>@yield('page-title', 'Dashboard')</h1>

                    <p>
                        @yield('page-description', 'Quiz Management System')
                    </p>
                </div>

            </div>

            <div class="topbar-right">

                <button
                    type="button"
                    class="topbar-icon-btn"
                    id="notificationBtn"
                    aria-label="Notifications"
                >
                    <i class="bi bi-bell"></i>
                </button>

                <div class="topbar-profile">

                    <div class="topbar-avatar" id="topbarAvatar">
                        <img id= "Avatar" src="" alt="">
                    </div>

                    <div class="topbar-profile-info">
                        <strong id="topbarUserName">
                            Super Admin
                        </strong>

                        <span id="topbarUserRole">
                            Administrator
                        </span>
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
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', openSidebar);
        }
        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }
        document.querySelectorAll('.app-sidebar .nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 991) {
                    closeSidebar();
                }
            });
        });
        window.addEventListener('resize', function () {
            if (window.innerWidth > 991) {
                closeSidebar();
            }
        });
    });

    function showGlobalAlert(message, type = 'success') {
        const container = document.getElementById('globalAlertContainer');

        if (!container) {
            return;
        }

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
        if (!button) {
            return;
        }

        if (loading) {
            button.dataset.originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2"></span>
                ${loadingText}
            `;
        } else {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText || 'Submit';
        }
    }
    window.token = localStorage.getItem('api_token');
    $.ajax({
        url:'/api/superAdmin/profile',
        type:'GET',
         headers: { 'Authorization': 'Bearer ' + token },
         success:function(response){
            console.log(response);
            const profile = response.data.profile_image;
            document.getElementById('Avatar').src = '/storage/' + profile;
         }
        
    });
    // configuration
    $.ajax({
        url:'/api/instituteAdmin/dashboard',
        type:'GET',
         headers: { 'Authorization': 'Bearer ' + token },
         success:function(response){
            console.log("app.blade: ",response.data.institute.configuration);
            const configuration = response.data.institute.configuration;
//             document.documentElement.style.setProperty(
//     '--lime',
//     configuration.primary_color
// );
   document.documentElement.style.setProperty('--primary-color',configuration.primary_color);
   document.documentElement.style.setProperty('--secondary-color',configuration.secondary_color);
   document.documentElement.style.setProperty('--accent-color',configuration.accent_color);
   document.documentElement.style.setProperty('--background-color',configuration.background_color);
   document.documentElement.style.setProperty('--text-color',configuration.text_color);
            // document.getElementById('Avatar').src = '/storage/' + profile;
         }
        
    });
    const logout = document.getElementById('logout');
    logout.addEventListener('click',function(){
        $.ajax({
        url:'/api/logout',
        type:'POST',
         headers: { 'Authorization': 'Bearer ' + token },
         success:function(response){
            console.log(response);
            localStorage.removeItem('api_token');

            window.location.href = "/";

            
         }
        
    });
    })
</script>

@stack('scripts')

</body>
</html>