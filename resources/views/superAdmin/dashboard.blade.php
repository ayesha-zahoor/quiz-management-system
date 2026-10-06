@extends('layouts.app')

@section('user-role', 'Super Admin')
@section('page-title', 'Dashboard')
@section('page-description', 'Manage institutes, administrators, and platform configuration')

@section('sidebar')
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <div>
            <div class="sidebar-brand-title">Quiz Management</div>
            <div class="sidebar-brand-subtitle">Administration Portal</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section-label">MAIN</div>

        <a href="/superadmin/dashboard" class="nav-item">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
    </a>
{{-- 
        <a href="#" class="sidebar-nav-item">
            <i class="bi bi-building"></i>
            <span>Institutes</span>
        </a> --}}

        {{-- <a href="#" class="sidebar-nav-item">
            <i class="bi bi-person-badge"></i>
            <span>Institute Admins</span>
        </a>

        <div class="sidebar-section-label mt-4">SYSTEM</div>

        <a href="#" class="sidebar-nav-item">
            <i class="bi bi-sliders2"></i>
            <span>Configuration</span>
        </a> --}}
<a href="#" id="profileLink" class="nav-item">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                SA
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">Super Admin</div>
                <div class="sidebar-user-role">Platform Administrator</div>
            </div>
            <button type="button" class="sidebar-logout" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </div>
    </div>
@endsection

@section('content')
    <div class="dashboard-header-row">
        <div>
            <h2 class="dashboard-welcome">Welcome back, Super Admin</h2>
            <p class="dashboard-subtitle">Here's an overview of your quiz management platform.</p>
        </div>
        <div class="dashboard-date">
            <i class="bi bi-calendar3"></i>
            <span id="currentDate"></span>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon"><i class="bi bi-building"></i></div>
                    <span class="stat-label">Total Institutes</span>
                </div>
                <div class="stat-value" id="totalInstitutes">0</div>
                <div class="stat-footer"><span>Registered on the platform</span></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-stat-card">
                <div class="stat-card-top">
                    <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
                    <span class="stat-label">Active Institutes</span>
                </div>
                <div class="stat-value" id="activeInstitutes">0</div>
                <div class="stat-footer"><span>Currently running</span></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-stat-card stat-danger">
                <div class="stat-card-top">
                    <div class="stat-icon"><i class="bi bi-slash-circle"></i></div>
                    <span class="stat-label">Suspended / Expired</span>
                </div>
                <div class="stat-value" id="inactiveInstitutes">0</div>
                <div class="stat-footer"><span>Not able to use the platform</span></div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-stat-card stat-warning">
                <div class="stat-card-top">
                    <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                    <span class="stat-label">Expiring in 30 Days</span>
                </div>
                <div class="stat-value" id="expiringSoon">0</div>
                <div class="stat-footer"><span>Licenses to renew soon</span></div>
            </div>
        </div>
    </div>

    {{-- Institutes table (full width) --}}
    <div class="dashboard-panel mb-4">
        <div class="dashboard-panel-header">
            <div>
                <h5>Institutes</h5>
                <p>Institutes with their administrator, contact and license details</p>
            </div>
            <a href="/superadmin/institutes" class="panel-action">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="table-responsive">
            <table class="table dashboard-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Institute</th>
                        <th>Contact &amp; Location</th>
                        <th>Administrator</th>
                        <th>License</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="tableData">
                    <tr><td colspan="6" class="text-center text-muted py-4">Loading...</td></tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row g-4">
        {{-- License alerts --}}
        <div class="col-xl-8">
            <div class="dashboard-panel h-100">
                <div class="dashboard-panel-header">
                    <div>
                        <h5>License Alerts</h5>
                        <p>Expired, suspended or expiring within 30 days</p>
                    </div>
                </div>
                <div class="alert-list" id="licenseAlerts">
                    <div class="alert-empty">Loading...</div>
                </div>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="col-xl-4">
            <div class="dashboard-panel h-100">
                <div class="dashboard-panel-header">
                    <div>
                        <h5>Quick Actions</h5>
                        <p>Common administration tasks</p>
                    </div>
                </div>
                <div class="quick-actions">
                    <a href="/superadmin/addInstitute" class="quick-action">
                        <div class="quick-action-icon"><i class="bi bi-building-add"></i></div>
                        <div class="quick-action-content">
                            <strong>Add Institute</strong>
                            <span>Institute, admin and colors in one step</span>
                        </div>
                        <i class="bi bi-chevron-right quick-action-arrow"></i>
                    </a>

                    {{-- <a href="/superadmin/institutes" class="quick-action">
                        <div class="quick-action-icon"><i class="bi bi-buildings"></i></div>
                        <div class="quick-action-content">
                            <strong>Manage Institutes</strong>
                            <span>Search, edit, suspend or renew</span>
                        </div>
                        <i class="bi bi-chevron-right quick-action-arrow"></i>
                    </a>

                    <a href="/superadmin/configuration" class="quick-action">
                        <div class="quick-action-icon"><i class="bi bi-sliders2"></i></div>
                        <div class="quick-action-content">
                            <strong>Platform Configuration</strong>
                            <span>Manage system settings</span>
                        </div>
                        <i class="bi bi-chevron-right quick-action-arrow"></i>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .dashboard-header-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 28px;
    }

    .dashboard-welcome {
        margin: 0 0 5px;
        font-size: 25px;
        font-weight: 700;
        color: var(--dark-text);
        letter-spacing: -0.4px;
    }

    .dashboard-subtitle {
        margin: 0;
        color: var(--slate);
        font-size: 14px;
    }

    .dashboard-date {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 13px;
        border: 1px solid var(--slate-light);
        border-radius: 8px;
        background: var(--white);
        color: var(--slate);
        font-size: 13px;
        white-space: nowrap;
    }

    .dashboard-stat-card {
        background: var(--white);
        border: 1px solid var(--slate-light);
        border-radius: 12px;
        padding: 20px;
        height: 100%;
        transition: border-color 0.2s ease, transform 0.2s ease;
    }

    .dashboard-stat-card:hover {
        border-color: var(--lime);
        transform: translateY(-2px);
    }

    .stat-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 9px;
        background: var(--lime-light);
        color: var(--lime-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .stat-label {
        color: var(--slate);
        font-size: 13px;
        font-weight: 600;
        text-align: right;
    }

    .stat-value {
        margin-top: 18px;
        font-size: 30px;
        line-height: 1;
        font-weight: 700;
        color: var(--dark-text);
    }

    .stat-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 13px;
        color: var(--slate);
        font-size: 12px;
    }

    .stat-footer i {
        color: var(--lime-dark);
        font-size: 14px;
    }

    .dashboard-panel {
        background: var(--white);
        border: 1px solid var(--slate-light);
        border-radius: 12px;
        overflow: hidden;
    }

    .dashboard-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 20px 22px;
        border-bottom: 1px solid var(--slate-light);
    }

    .dashboard-panel-header h5 {
        margin: 0 0 4px;
        color: var(--dark-text);
        font-size: 16px;
        font-weight: 700;
    }

    .dashboard-panel-header p {
        margin: 0;
        color: var(--slate);
        font-size: 12px;
    }

    .panel-action {
        border: 0;
        background: transparent;
        color: var(--lime-dark);
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px;
    }

    .panel-action:hover {
        color: var(--navy);
    }

    .dashboard-table {
        --bs-table-bg: transparent;
    }

    .dashboard-table thead th {
        background: var(--off-white);
        color: var(--slate);
        border-bottom: 1px solid var(--slate-light);
        padding: 12px 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }

    .dashboard-table tbody td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: var(--dark-text);
        font-size: 13px;
    }

    .dashboard-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .table-primary-info {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 210px;
    }

    .table-avatar {
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        border-radius: 8px;
        background: var(--lime-light);
        color: var(--lime-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
    }

    .table-primary-info strong {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--dark-text);
    }

    .table-primary-info small {
        display: block;
        margin-top: 2px;
        color: var(--slate);
        font-size: 11px;
    }

    .institute-code {
        display: inline-block;
        padding: 4px 7px;
        border-radius: 5px;
        background: var(--off-white);
        color: var(--slate);
        font-family: monospace;
        font-size: 11px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
    }

    .status-active {
        background: var(--lime-light);
        color: var(--lime-dark);
    }

    .status-inactive {
        background: #f1f5f9;
        color: var(--slate);
    }

    .quick-actions {
        padding: 7px 12px 12px;
    }

    .quick-action {
        width: 100%;
        border: 0;
        border-bottom: 1px solid #f1f5f9;
        background: transparent;
        display: flex;
        align-items: center;
        gap: 12px;
        text-align: left;
        padding: 14px 10px;
        transition: background 0.2s ease;
    }

    .quick-action:last-child {
        border-bottom: 0;
    }

    .quick-action:hover {
        background: var(--off-white);
    }

    .quick-action-icon {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border-radius: 8px;
        background: var(--lime-light);
        color: var(--lime-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .quick-action-content {
        flex: 1;
        min-width: 0;
    }

    .quick-action-content strong {
        display: block;
        color: var(--dark-text);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .quick-action-content span {
        display: block;
        color: var(--slate);
        font-size: 11px;
    }

    .quick-action-arrow {
        color: var(--slate);
        font-size: 13px;
    }

    .system-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 10px;
        background: var(--lime-light);
        color: var(--lime-dark);
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .system-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--lime-dark);
    }

    .platform-overview {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }

    .overview-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 20px;
        border-right: 1px solid var(--slate-light);
    }

    .overview-item:last-child {
        border-right: 0;
    }

    .overview-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: var(--lime-light);
        color: var(--lime-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 36px;
    }

    .overview-item strong {
        display: block;
        color: var(--dark-text);
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .overview-item span {
        display: block;
        color: var(--slate);
        font-size: 11px;
    }

    @media (max-width: 991.98px) {
        .platform-overview {
            grid-template-columns: repeat(2, 1fr);
        }

        .overview-item {
            border-right: 0;
            border-bottom: 1px solid var(--slate-light);
        }

        .overview-item:nth-child(odd) {
            border-right: 1px solid var(--slate-light);
        }

        .overview-item:nth-last-child(-n+2) {
            border-bottom: 0;
        }
    }

    @media (max-width: 767.98px) {
        .dashboard-header-row {
            flex-direction: column;
        }

        .dashboard-date {
            width: 100%;
            justify-content: center;
        }

        .platform-overview {
            grid-template-columns: 1fr;
        }

        .overview-item,
        .overview-item:nth-child(odd) {
            border-right: 0;
            border-bottom: 1px solid var(--slate-light);
        }

        .overview-item:last-child {
            border-bottom: 0;
        }

        .dashboard-panel-header {
            align-items: flex-start;
        }
    }
    /* Stat card variants */
.dashboard-stat-card.stat-danger .stat-icon { background:#fee2e2; color:#dc2626; }
.dashboard-stat-card.stat-warning .stat-icon { background:#fef3c7; color:#d97706; }

/* Table */
.dashboard-table .table-avatar { object-fit: cover; background: var(--white); border:1px solid var(--slate-light); }
.person-avatar {
    width: 34px; height: 34px; flex: 0 0 34px;
    border-radius: 50%; object-fit: cover;
    background: var(--navy); color: var(--lime);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; font-weight: 700;
}
.contact-line { display:flex; align-items:center; gap:7px; color: var(--slate); font-size:12px; margin-bottom:3px; }
.contact-line i { color: var(--lime-dark); }
.dashboard-table td { white-space: nowrap; }
.dashboard-table td:nth-child(2) .contact-line:last-child { white-space: normal; min-width:160px; max-width:220px; }

/* Status colors */
.status-warning { background:#fef3c7; color:#b45309; }
.status-danger  { background:#fee2e2; color:#b91c1c; }

/* License alerts */
.alert-list { padding: 8px 14px 14px; }
.alert-row { display:flex; align-items:center; gap:12px; padding:12px 8px; border-bottom:1px solid #f1f5f9; }
.alert-row:last-child { border-bottom:0; }
.alert-row-icon { width:36px; height:36px; flex:0 0 36px; border-radius:8px; display:flex; align-items:center; justify-content:center; }
.alert-row-icon.warn { background:#fef3c7; color:#d97706; }
.alert-row-icon.bad  { background:#fee2e2; color:#dc2626; }
.alert-row-text { flex:1; min-width:0; }
.alert-row-text strong { display:block; font-size:13px; font-weight:600; }
.alert-row-text span { color: var(--slate); font-size:12px; }
.alert-row-action { font-size:12px; font-weight:700; color: var(--lime-dark); padding:6px 12px; border-radius:6px; background: var(--lime-light); }
.alert-row-action:hover { background: var(--lime); color: var(--navy); }
.alert-empty { padding:30px; text-align:center; color: var(--slate); font-size:13px; }
.alert-empty i { color: var(--lime-dark); margin-right:6px; }

/* Quick actions as links */
a.quick-action { color: inherit; text-decoration: none; }
</style>
@endpush

@push('scripts')
<script>
    // const token = localStorage.getItem('api_token');

    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('en-US', {
            weekday: 'short', month: 'short', day: 'numeric', year: 'numeric'
        });

    function esc(text) {
        return $('<div>').text(text ?? '').html();
    }

    function initials(name) {
        return (name || '?').split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
    }

    function daysLeft(dateStr) {
        if (!dateStr) return null;
        const today = new Date(); today.setHours(0, 0, 0, 0);
        return Math.ceil((new Date(dateStr) - today) / 86400000);
    }

    function formatDate(dateStr) {
        return dateStr
            ? new Date(dateStr).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
            : '—';
    }

    function licenseBadge(days) {
        if (days === null) return '<span class="text-muted">No expiry set</span>';
        if (days < 0)   return `<span class="status-badge status-danger">Expired ${Math.abs(days)}d ago</span>`;
        if (days <= 30) return `<span class="status-badge status-warning">${days} day${days === 1 ? '' : 's'} left</span>`;
        return `<span class="status-badge status-active">${days} days left</span>`;
    }

    function statusClass(status) {
        if (status === 'active') return 'status-active';
        if (status === 'suspended') return 'status-warning';
        return 'status-danger';
    }

    $.ajax({
        url: '/api/getInstitutes',
        type: 'GET',
        headers: { 'Authorization': 'Bearer ' + token },

        success: function (response) {
            const institutes = response.data || [];
            const adminId = response.admin.id;
              document.getElementById('profileLink').href =
        '/super-admin/profile/' + adminId;
            console.log(response);

            // ---- Stats ----
            const active   = institutes.filter(i => i.status === 'active').length;
            const inactive = institutes.filter(i => i.status !== 'active').length;
            const expiring = institutes.filter(i => {
                const d = daysLeft(i.license_expires_at);
                return d !== null && d >= 0 && d <= 30;
            }).length;

            $('#totalInstitutes').text(institutes.length);
            $('#activeInstitutes').text(active);
            $('#inactiveInstitutes').text(inactive);
            $('#expiringSoon').text(expiring);

            // ---- Table ----
            let rows = '';

            institutes.forEach(function (institute) {
                const admin = (institute.users || []).find(u => u.role_id == 2);
                const days  = daysLeft(institute.license_expires_at);

                const logo = institute.logo
                    ? `<img src="/storage/${institute.logo}" class="table-avatar" alt="">`
                    : `<div class="table-avatar"><i class="bi bi-building"></i></div>`;

                const adminAvatar = admin && admin.profile_image
                    ? `<img src="/storage/${admin.profile_image}" class="person-avatar" alt="">`
                    : `<div class="person-avatar">${admin ? initials(admin.name) : '?'}</div>`;

                rows += `
                <tr>
                    <td>
                        <div class="table-primary-info">
                            ${logo}
                            <div>
                                <strong>${esc(institute.name)}</strong>
                                <small>${esc(institute.email) || '—'}</small>
                            </div>
                        </div>
                    </td>

                    <td>
                        <div class="contact-line"><i class="bi bi-telephone"></i> ${esc(institute.Contact) || '—'}</div>
                        <div class="contact-line"><i class="bi bi-geo-alt"></i> ${esc(institute.address) || '—'}</div>
                    </td>

                    <td>
                        ${admin ? `
                            <div class="table-primary-info">
                                ${adminAvatar}
                                <div>
                                    <strong>${esc(admin.name)}</strong>
                                    <small>${esc(admin.email)}</small>
                                </div>
                            </div>`
                        : `<span class="text-muted">No administrator assigned</span>`}
                    </td>

                    <td>
                        ${licenseBadge(days)}
                        <small class="d-block text-muted mt-1">${formatDate(institute.license_expires_at)}</small>
                    </td>

                    <td>
                        <span class="status-badge ${statusClass(institute.status)}">${esc(institute.status)}</span>
                    </td>

                    <td class="text-end">
                        <a href="/superAdmin/edit/${institute.id}" class="btn btn-warning">
                            <i class="bi bi-pencil-square me-1"></i>Edit
                        </a>
                    </td>
                </tr>`;
            });

            $('.tableData').html(rows || `<tr><td colspan="6" class="text-center text-muted py-4">No institutes yet.</td></tr>`);

            // ---- License alerts ----
            const alerts = institutes
                .map(i => ({ ...i, days: daysLeft(i.license_expires_at) }))
                .filter(i => i.status !== 'active' || (i.days !== null && i.days <= 30))
                .sort((a, b) => (a.days ?? 9999) - (b.days ?? 9999));

            let alertHtml = '';

            alerts.forEach(function (i) {
                const message = i.status === 'suspended' ? 'Suspended'
                    : i.days === null ? 'No expiry date set'
                    : i.days < 0 ? `License expired ${Math.abs(i.days)} day(s) ago`
                    : `License expires in ${i.days} day(s)`;

                alertHtml += `
                <div class="alert-row">
                    <div class="alert-row-icon ${i.days !== null && i.days >= 0 && i.status === 'active' ? 'warn' : 'bad'}">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="alert-row-text">
                        <strong>${esc(i.name)}</strong>
                        <span>${message} · ${formatDate(i.license_expires_at)}</span>
                    </div>
                    <a href="/superAdmin/edit/${i.id}" class="alert-row-action">Renew</a>
                </div>`;
            });

            $('#licenseAlerts').html(alertHtml ||
                `<div class="alert-empty"><i class="bi bi-check-circle"></i> All licenses are healthy.</div>`);
        },

        error: function (xhr) {
            console.log('Institutes error:', xhr);
            $('.tableData').html(`<tr><td colspan="6" class="text-center text-danger py-4">Could not load institutes.</td></tr>`);
        }
    });
</script>
@endpush