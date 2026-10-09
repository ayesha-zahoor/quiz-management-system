@extends('layouts.app')

@section('user-role', 'Platform Administrator')
@section('page-title', 'Dashboard')
@section('page-description', 'Manage institutes, administrators, and platform configuration')

@section('sidebar')
    <div class="sidebar-section-label">Main</div>

    <a href="/superAdmin/dashboard" class="nav-item active">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
    </a>

    <a href="#" id="profileLink" class="nav-item">
        <i class="bi bi-person-circle"></i>
        <span>Profile</span>
    </a>
@endsection

@section('content')
    <div class="dashboard-header-row">
        <div>
            <h2 class="dashboard-welcome"><span id="greeting">Welcome back</span>, Super Admin</h2>
            <p class="dashboard-subtitle">Here's an overview of your quiz management platform.</p>
        </div>

        <div class="header-actions">
            <div class="dashboard-date">
                <i class="bi bi-calendar3"></i>
                <span id="currentDate"></span>
            </div>
            <a href='/superAdmin/addInstitute' class="btn-add">
                <i class="bi bi-plus-lg"></i> Add institute
            </a>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-stat-card">
                <div class="stat-icon"><i class="bi bi-building"></i></div>
                <div class="stat-body">
                    <span class="stat-label">Total institutes</span>
                    <div class="stat-value" id="totalInstitutes">0</div>
                    <div class="stat-footer">Registered on the platform</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-stat-card">
                <div class="stat-icon"><i class="bi bi-check-circle"></i></div>
                <div class="stat-body">
                    <span class="stat-label">Active institutes</span>
                    <div class="stat-value" id="activeInstitutes">0</div>
                    <div class="stat-footer">Currently running</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-stat-card stat-danger">
                <div class="stat-icon"><i class="bi bi-slash-circle"></i></div>
                <div class="stat-body">
                    <span class="stat-label">Suspended or expired</span>
                    <div class="stat-value" id="inactiveInstitutes">0</div>
                    <div class="stat-footer">Can't use the platform</div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-stat-card stat-warning">
                <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
                <div class="stat-body">
                    <span class="stat-label">Expiring in 30 days</span>
                    <div class="stat-value" id="expiringSoon">0</div>
                    <div class="stat-footer">Licenses to renew soon</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Institutes table --}}
    <div class="dashboard-panel">
        <div class="dashboard-panel-header">
            <div>
                <h5>Institutes</h5>
                <p>Administrator, contact and license details for each institute</p>
            </div>

            <div class="panel-tools">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="search" id="instituteSearch" placeholder="Search institutes" aria-label="Search institutes">
                </div>
                <select id="statusFilter" class="form-select filter-select" aria-label="Filter by status">
                    <option value="">All statuses</option>
                    <option value="active">Active</option>
                    <option value="suspended">Suspended</option>
                    <option value="expired">Expired</option>
                </select>
               
            </div>
        </div>

        <div class="table-responsive">
            <table class="table dashboard-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Institute</th>
                        <th>Contact &amp; location</th>
                        <th>Administrator</th>
                        <th>License</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody class="tableData">
                    @for ($i = 0; $i < 3; $i++)
                        <tr class="skeleton-row">
                            <td><div class="skeleton" style="width:180px"></div></td>
                            <td><div class="skeleton" style="width:130px"></div></td>
                            <td><div class="skeleton" style="width:160px"></div></td>
                            <td><div class="skeleton" style="width:90px"></div></td>
                            <td><div class="skeleton" style="width:60px"></div></td>
                            <td><div class="skeleton ms-auto" style="width:60px"></div></td>
                        </tr>
                    @endfor
                </tbody>
            </table>
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
        margin-bottom: 26px;
    }

    .dashboard-welcome {
        margin: 0 0 5px;
        font-size: 26px;
        font-weight: 700;
        color: var(--dark-text);
        letter-spacing: -0.5px;
    }

    .dashboard-subtitle { margin: 0; color: var(--slate); font-size: 14px; }

    .header-actions { display: flex; align-items: center; gap: 12px; }

    .dashboard-date {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border: 1px solid var(--slate-light);
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.85);
        color: var(--slate);
        font-size: 13px;
        white-space: nowrap;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 10px;
        background: var(--navy);
        color: var(--white);
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
        box-shadow: 0 8px 18px -8px rgba(11, 17, 32, 0.55);
        transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }
    .btn-add i { color: var(--lime); }
    .btn-add:hover { background: var(--lime); color: var(--navy); }
    .btn-add:hover i { color: var(--navy); }
    .btn-add:active { transform: scale(0.97); }

    /* ---------- Stat cards ---------- */
    .dashboard-stat-card {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        height: 100%;
        padding: 20px;
        background: var(--white);
        border: 1px solid var(--slate-light);
        border-radius: 14px;
        box-shadow: var(--shadow-sm);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .dashboard-stat-card:hover { border-color: var(--lime); box-shadow: var(--shadow-md); }

    .stat-icon {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        border-radius: 12px;
        background: var(--lime-light);
        color: var(--lime-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-body { min-width: 0; }
    .stat-label { display: block; color: var(--slate); font-size: 13px; font-weight: 600; }
    .stat-value {
        margin-top: 6px;
        font-size: 32px;
        line-height: 1;
        font-weight: 700;
        color: var(--dark-text);
        font-variant-numeric: tabular-nums;
    }
    .stat-footer { margin-top: 10px; color: var(--slate); font-size: 12px; }

    .dashboard-stat-card.stat-danger .stat-icon { background: #fee2e2; color: #dc2626; }
    .dashboard-stat-card.stat-warning .stat-icon { background: #fef3c7; color: #d97706; }

    /* ---------- Panel ---------- */
    .dashboard-panel {
        background: var(--white);
        border: 1px solid var(--slate-light);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .dashboard-panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 15px;
        padding: 20px 22px;
        border-bottom: 1px solid var(--slate-light);
    }
    .dashboard-panel-header h5 { margin: 0 0 4px; color: var(--dark-text); font-size: 16px; font-weight: 700; }
    .dashboard-panel-header p { margin: 0; color: var(--slate); font-size: 12px; }

    .panel-tools { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

    .search-box { position: relative; }
    .search-box i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--slate);
        font-size: 13px;
        pointer-events: none;
    }
    .search-box input {
        width: 220px;
        height: 38px;
        padding: 0 12px 0 34px;
        border: 1px solid #CBD5E1;
        border-radius: 9px;
        font-size: 13px;
        font-family: inherit;
        background: var(--white);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .search-box input:focus {
        outline: 0;
        border-color: var(--lime);
        box-shadow: 0 0 0 3px rgba(132, 204, 22, 0.18);
    }

    .filter-select { width: 150px; min-height: 38px; height: 38px; padding-top: 0; padding-bottom: 0; }

    .panel-action {
        color: var(--lime-dark);
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px;
    }
    .panel-action:hover { color: var(--navy); }

    /* ---------- Table ---------- */
    .dashboard-table { --bs-table-bg: transparent; }

    .dashboard-table thead th {
        background: var(--off-white);
        color: var(--slate);
        border-bottom: 1px solid var(--slate-light);
        padding: 12px 20px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .dashboard-table tbody td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: var(--dark-text);
        font-size: 13px;
        vertical-align: middle;
    }
    /* Wrap long text (emails, addresses) instead of forcing a horizontal scroll */
    .dashboard-table tbody td:nth-child(-n+3) { white-space: normal; word-break: break-word; }
    .dashboard-table tbody td:nth-child(n+4) { white-space: nowrap; }
    .dashboard-table thead th { padding-left: 16px; padding-right: 16px; }
    .dashboard-table tbody td { padding-left: 16px; padding-right: 16px; }

    /* Never show a scrollbar under the table (it still scrolls on very small screens) */
    .dashboard-panel .table-responsive { scrollbar-width: none; -ms-overflow-style: none; }
    .dashboard-panel .table-responsive::-webkit-scrollbar { display: none; }
    .dashboard-table tbody tr { transition: background 0.15s ease; }
    .dashboard-table tbody tr:hover { background: #FAFDF4; }
    .dashboard-table tbody tr:last-child td { border-bottom: 0; }
    .table-primary-info { display: flex; align-items: center; gap: 11px; min-width: 0; }
    .table-primary-info > div:last-child { min-width: 0; }

    .table-avatar {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        border-radius: 9px;
        background: var(--lime-light);
        color: var(--lime-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        object-fit: cover;
    }
    img.table-avatar { background: var(--white); border: 1px solid var(--slate-light); }

    .person-avatar {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        border-radius: 50%;
        object-fit: cover;
        background: var(--navy);
        color: var(--lime);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
    }

    .table-primary-info strong { display: block; font-size: 13px; font-weight: 600; color: var(--dark-text); }
    .table-primary-info small { display: block; margin-top: 2px; color: var(--slate); font-size: 12px; }

    .contact-line { display: flex; align-items: center; gap: 7px; color: var(--slate); font-size: 12px; margin-bottom: 3px; }
    .contact-line i { color: var(--lime-dark); }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }
    .status-badge::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
    .status-active  { background: var(--lime-light); color: var(--lime-dark); }
    .status-warning { background: #fef3c7; color: #b45309; }
    .status-danger  { background: #fee2e2; color: #b91c1c; }

    .license-note { display: block; margin-top: 4px; color: var(--slate); font-size: 12px; }

    /* ---------- Empty + loading ---------- */
    .table-empty { padding: 44px 20px; text-align: center; color: var(--slate); }
    .table-empty i { display: block; margin-bottom: 10px; font-size: 30px; color: var(--lime-dark); }
    .table-empty strong { display: block; color: var(--dark-text); font-size: 14px; margin-bottom: 4px; }
    .table-empty span { font-size: 13px; }
    .table-empty a { color: var(--lime-dark); font-weight: 700; }
    .table-empty.error i { color: var(--danger); }

    .skeleton {
        height: 14px;
        border-radius: 6px;
        background: linear-gradient(90deg, #eef2f7 25%, #f8fafc 50%, #eef2f7 75%);
        background-size: 200% 100%;
        animation: shimmer 1.2s infinite linear;
    }
    @keyframes shimmer { to { background-position: -200% 0; } }

    /* ---------- Responsive ---------- */
    @media (max-width: 991.98px) {
        .dashboard-header-row { flex-direction: column; }
        .header-actions { width: 100%; }
        .header-actions .dashboard-date { flex: 1; justify-content: center; }
    }

    @media (max-width: 767.98px) {
        .dashboard-welcome { font-size: 22px; }
        .panel-tools { width: 100%; }
        .search-box { flex: 1 1 100%; }
        .search-box input { width: 100%; }
        .filter-select { flex: 1; width: auto; }
    }
</style>
@endpush

@push('scripts')
<script>
    // ---------- Header ----------
    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });

    (function () {
        const h = new Date().getHours();
        document.getElementById('greeting').textContent =
            h < 12 ? 'Good morning' : h < 18 ? 'Good afternoon' : 'Good evening';
    })();

    // ---------- Helpers ----------
    function esc(text) { return $('<div>').text(text ?? '').html(); }

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

    function countUp(selector, target) {
        const el = document.querySelector(selector);
        if (!el) return;
        if (!target || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            el.textContent = target; return;
        }
        const duration = 600, start = performance.now();
        (function tick(now) {
            const p = Math.min((now - start) / duration, 1);
            el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(tick);
        })(start);
    }

    // ---------- Table rendering ----------
    let allInstitutes = [];

    function renderRows() {
        const q = ($('#instituteSearch').val() || '').trim().toLowerCase();
        const status = $('#statusFilter').val();

        const list = allInstitutes.filter(function (i) {
            const admin = (i.users || []).find(u => u.role_id == 2);
            const hay = [i.name, i.email, i.Contact, i.address, admin && admin.name, admin && admin.email]
                .join(' ').toLowerCase();
            return (!q || hay.includes(q)) && (!status || i.status === status);
        });

        if (!allInstitutes.length) {
            $('.tableData').html(`<tr><td colspan="6"><div class="table-empty">
                <i class="bi bi-building-add"></i>
                <strong>No institutes yet</strong>
                <span><a href="/superadmin/addInstitute">Add your first institute</a> to get started.</span>
            </div></td></tr>`);
            return;
        }

        if (!list.length) {
            $('.tableData').html(`<tr><td colspan="6"><div class="table-empty">
                <i class="bi bi-search"></i>
                <strong>No matching institutes</strong>
                <span>Try a different search or clear the status filter.</span>
            </div></td></tr>`);
            return;
        }

        let rows = '';

        list.forEach(function (institute) {
            const admin = (institute.users || []).find(u => u.role_id == 2);
            const days  = daysLeft(institute.license_expires_at);

            const logo = institute.logo
                ? `<img src="/storage/${esc(institute.logo)}" class="table-avatar" alt="">`
                : `<div class="table-avatar"><i class="bi bi-building"></i></div>`;

            const adminAvatar = admin && admin.profile_image
                ? `<img src="/storage/${esc(admin.profile_image)}" class="person-avatar" alt="">`
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
                    ${institute.license_expires_at ? `<span class="license-note">${formatDate(institute.license_expires_at)}</span>` : ''}
                </td>

                <td><span class="status-badge ${statusClass(institute.status)}">${esc(institute.status)}</span></td>

                <td class="text-end">
                    <a href="/superAdmin/edit/${institute.id}" class="btn btn-warning">
                        <i class="bi bi-pencil-square me-1"></i>Edit
                    </a>
                </td>
            </tr>`;
        });

        $('.tableData').html(rows);
    }

    $('#instituteSearch').on('input', renderRows);
    $('#statusFilter').on('change', renderRows);

    // ---------- Load data ----------
    $.ajax({
        url: '/api/getInstitutes',
        type: 'GET',
        headers: { 'Authorization': 'Bearer ' + token },

        success: function (response) {
            allInstitutes = response.data || [];

            if (response.admin && response.admin.id) {
                document.getElementById('profileLink').href = '/super-admin/profile/' + response.admin.id;
            }

            const active   = allInstitutes.filter(i => i.status === 'active').length;
            const inactive = allInstitutes.filter(i => i.status !== 'active').length;
            const expiring = allInstitutes.filter(function (i) {
                const d = daysLeft(i.license_expires_at);
                return d !== null && d >= 0 && d <= 30;
            }).length;

            countUp('#totalInstitutes', allInstitutes.length);
            countUp('#activeInstitutes', active);
            countUp('#inactiveInstitutes', inactive);
            countUp('#expiringSoon', expiring);

            renderRows();
        },

        error: function (xhr) {
            console.log('Institutes error:', xhr);
            $('.tableData').html(`<tr><td colspan="6"><div class="table-empty error">
                <i class="bi bi-exclamation-circle"></i>
                <strong>Couldn't load institutes</strong>
                <span>Check your connection and <a href="#" onclick="location.reload();return false;">try again</a>.</span>
            </div></td></tr>`);
        }
    });
</script>
@endpush