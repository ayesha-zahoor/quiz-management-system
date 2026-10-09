@extends('layouts.app')

@section('user-role', 'Platform Administrator')
@section('page-title', 'Add Institute')
@section('page-description', 'Create a new institute with its initial administrator and configuration.')

@section('sidebar')
    <div class="sidebar-section-label">Main</div>

    <a href="/superAdmin/dashboard" class="nav-item">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
    </a>

    <a href="/superadmin/addInstitute" class="nav-item active">
        <i class="bi bi-building-add"></i>
        <span>Add institute</span>
    </a>

    <a href="#" id="profileLink" class="nav-item">
        <i class="bi bi-person-circle"></i>
        <span>Profile</span>
    </a>
@endsection


@section('content')

<div class="page-top">
    <a href="/superAdmin/dashboard" class="back-link">
        <i class="bi bi-arrow-left"></i> Back to dashboard
    </a>
</div>

<div id="formAlert" class="alert-box" role="alert"></div>

<form id="instituteForm" enctype="multipart/form-data" novalidate>
    <div class="row g-4">

        {{-- ================= Left: form ================= --}}
        <div class="col-xl-8">

            {{-- Institute information --}}
            <section class="form-section">
                <header class="form-section-head">
                    <div class="head-icon"><i class="bi bi-building"></i></div>
                    <div>
                        <h5>Institute information</h5>
                        <p>Enter the basic details of the institute.</p>
                    </div>
                </header>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Institute name <span class="req">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="e.g. Sun Rise College">
                        <div id="nameError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Institute email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="college@example.com">
                        <div id="emailError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="Contact" class="form-label">Contact number</label>
                        <input type="text" class="form-control" id="Contact" name="Contact" placeholder="03001234567">
                        <div id="ContactError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Institute address">
                        <div id="addressError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="license_key" class="form-label">License key</label>
                        <input type="text" class="form-control" id="license_key" name="license_key" placeholder="Leave empty to generate automatically">
                        <div id="licenseKeyError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="license_expires_at" class="form-label">License expiry</label>
                        <input type="date" class="form-control" id="license_expires_at" name="license_expires_at">
                        <div id="licenseExpiryError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" selected>Active</option>
                            <option value="suspended">Suspended</option>
                            <option value="expired">Expired</option>
                        </select>
                        <div id="statusError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="logo" class="form-label">Institute logo</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept=".jpg,.jpeg,.png,.webp">
                        <div class="field-hint">JPG, PNG or WebP.</div>
                        <div id="logoError" class="field-error"></div>
                    </div>
                </div>
            </section>

            {{-- Initial admin --}}
            <section class="form-section">
                <header class="form-section-head">
                    <div class="head-icon"><i class="bi bi-person-badge"></i></div>
                    <div>
                        <h5>Initial institute admin</h5>
                        <p>This administrator will manage the institute after it's created.</p>
                    </div>
                </header>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="admin_name" class="form-label">Admin name <span class="req">*</span></label>
                        <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder="e.g. Sun Rise Admin">
                        <div id="adminNameError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="admin_email" class="form-label">Admin email <span class="req">*</span></label>
                        <input type="email" class="form-control" id="admin_email" name="admin_email" placeholder="admin@example.com">
                        <div id="adminEmailError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="admin_password" class="form-label">Admin password <span class="req">*</span></label>
                        <div class="password-wrap">
                            <input type="password" class="form-control" id="admin_password" name="admin_password" placeholder="Minimum 8 characters">
                            <button type="button" class="toggle-pass" data-target="admin_password" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div id="adminPasswordError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="admin_password_confirmation" class="form-label">Confirm password <span class="req">*</span></label>
                        <div class="password-wrap">
                            <input type="password" class="form-control" id="admin_password_confirmation" name="admin_password_confirmation" placeholder="Re-enter password">
                            <button type="button" class="toggle-pass" data-target="admin_password_confirmation" aria-label="Show password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                        <div id="adminPasswordConfirmationError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="admin_profile_image" class="form-label">Admin profile image</label>
                        <input type="file" class="form-control" id="admin_profile_image" name="admin_profile_image" accept=".jpg,.jpeg,.png,.webp">
                        <div class="field-hint">JPG, PNG or WebP.</div>
                        <div id="adminProfileImageError" class="field-error"></div>
                    </div>
                </div>
            </section>

            {{-- Colors --}}
            <section class="form-section">
                <header class="form-section-head">
                    <div class="head-icon"><i class="bi bi-palette"></i></div>
                    <div>
                        <h5>Institute colors</h5>
                        <p>Choose the colors used across this institute's quiz portal. The preview updates as you pick.</p>
                    </div>
                </header>

                <div class="color-grid">
                    @php
                        $colors = [
                            ['primary_color',    'primaryColorError',    'Primary',    'Main brand color',       '#84CC16'],
                            ['secondary_color',  'secondaryColorError',  'Secondary',  'Supporting color',       '#65A30D'],
                            ['accent_color',     'accentColorError',     'Accent',     'Highlights and actions', '#F59E0B'],
                            ['background_color', 'backgroundColorError', 'Background', 'Page background',        '#F8FAFC'],
                            ['text_color',       'textColorError',       'Text',       'Default text color',     '#111827'],
                        ];
                    @endphp

                    @foreach ($colors as [$id, $errId, $label, $hint, $default])
                        <div class="color-tile">
                            <label class="color-swatch" style="--swatch: {{ $default }}" for="{{ $id }}">
                                <input type="color" id="{{ $id }}" name="{{ $id }}" value="{{ $default }}">
                            </label>
                            <div class="color-meta">
                                <label for="{{ $id }}" class="color-name">{{ $label }}</label>
                                <small>{{ $hint }}</small>
                                <code id="{{ $id }}_value">{{ $default }}</code>
                            </div>
                            <div id="{{ $errId }}" class="field-error"></div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        {{-- ================= Right: live preview ================= --}}
        <div class="col-xl-4">
            <div class="sticky-col">

                <div class="side-card">
                    <div class="side-card-title">
                        <h5>Live preview</h5>
                        <span class="live-dot">Updates as you type</span>
                    </div>

                    {{-- Mini themed mock of the institute portal --}}
                    <div class="mock" id="mock">
                        <div class="mock-bar">
                            <div class="mock-logo" id="logoPreview"><i class="bi bi-building"></i></div>
                            <div class="mock-titles">
                                <strong id="pvName">Institute name</strong>
                                <span id="pvEmail">institute@example.com</span>
                            </div>
                        </div>

                        <div class="mock-body">
                            <div class="mock-text" id="pvText">Welcome to your quiz portal</div>
                            <div class="mock-sub" id="pvSub">Quizzes, results and students in one place.</div>
                            <div class="mock-actions">
                                <span class="mock-btn" id="pvBtn">Start quiz</span>
                                <span class="mock-btn secondary" id="pvBtn2">Results</span>
                                <span class="mock-badge" id="pvBadge">New</span>
                            </div>
                        </div>
                    </div>

                    <div class="pv-rows">
                        <div class="pv-row">
                            <span class="pv-label">Status</span>
                            <span class="pv-pill" id="pvStatus">Active</span>
                        </div>
                        <div class="pv-row">
                            <span class="pv-label">License expiry</span>
                            <strong id="pvExpiry">Not set</strong>
                        </div>
                    </div>

                    <div class="pv-admin">
                        <div class="pv-admin-avatar" id="adminPreview">?</div>
                        <div class="pv-admin-info">
                            <span class="pv-label">Administrator</span>
                            <strong id="pvAdminName">Not added yet</strong>
                            <small id="pvAdminEmail">admin@example.com</small>
                        </div>
                    </div>
                </div>

                <div class="side-card info-card">
                    <div class="info-icon"><i class="bi bi-info-circle"></i></div>
                    <div>
                        <h6>One step setup</h6>
                        <p>This creates the institute, its first administrator and its colors together.</p>
                    </div>
                </div>

                <button type="submit" id="submitButton" class="btn-submit w-100">
                    <span id="submitText"><i class="bi bi-building-add me-2"></i>Create institute</span>
                    <span id="submitLoading" style="display:none;">
                        <span class="spinner-border spinner-border-sm me-2"></span>Creating...
                    </span>
                </button>

            </div>
        </div>

    </div>
</form>

@endsection


@push('styles')
<style>
    .page-top { margin-bottom: 18px; }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border: 1px solid var(--slate-light);
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.85);
        color: var(--slate);
        font-size: 13px;
        font-weight: 600;
        transition: 0.2s;
    }
    .back-link:hover { color: var(--navy); border-color: var(--lime); background: var(--lime-light); }

    /* ---------- Sections ---------- */
    .form-section,
    .side-card {
        background: var(--white);
        border: 1px solid var(--slate-light);
        border-radius: 14px;
        padding: 24px;
        box-shadow: var(--shadow-sm);
    }
    .form-section + .form-section { margin-top: 24px; }

    .form-section-head {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
        padding-bottom: 18px;
        border-bottom: 1px solid #f1f5f9;
    }
    .head-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        border-radius: 11px;
        background: var(--lime-light);
        color: var(--lime-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }
    .form-section-head h5 { margin: 0; font-size: 16px; font-weight: 700; color: var(--dark-text); }
    .form-section-head p { margin: 3px 0 0; font-size: 13px; color: var(--slate); }

    .form-label { margin-bottom: 6px; color: #374151; font-weight: 600; font-size: 13px; }
    .req { color: var(--danger); }

    .form-control,
    .form-select { padding: 10px 12px; background-color: var(--white); }
    .form-control.is-invalid,
    .form-select.is-invalid { border-color: var(--danger); background-image: none; }
    .form-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12); }

    input[type="file"].form-control { padding: 8px 12px; }
    input[type="file"]::file-selector-button {
        margin-right: 12px;
        padding: 6px 12px;
        border: 0;
        border-radius: 7px;
        background: var(--lime-light);
        color: var(--lime-dark);
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
    }

    .field-hint { margin-top: 5px; color: #94a3b8; font-size: 12px; }
    .field-error { color: var(--danger); font-size: 12px; margin-top: 5px; min-height: 0; }
    .field-error:empty { display: none; }

    /* Password toggle */
    .password-wrap { position: relative; }
    .password-wrap .form-control { padding-right: 44px; }
    .toggle-pass {
        position: absolute;
        top: 50%;
        right: 6px;
        transform: translateY(-50%);
        width: 32px;
        height: 32px;
        border: 0;
        border-radius: 8px;
        background: transparent;
        color: var(--slate);
    }
    .toggle-pass:hover { background: var(--lime-light); color: var(--navy); }

    /* Alert */
    .alert-box { display: none; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 14px; }
    .alert-success { display: block; background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
    .alert-error   { display: block; background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

    /* ---------- Colors ---------- */
    .color-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 14px;
    }

    .color-tile {
        padding: 12px;
        border: 1px solid var(--slate-light);
        border-radius: 12px;
        background: #fcfdfb;
        transition: border-color 0.2s ease;
    }
    .color-tile:hover { border-color: var(--lime); }

    .color-swatch {
        position: relative;
        display: block;
        height: 64px;
        margin: 0 0 12px;
        border-radius: 9px;
        background: var(--swatch);
        border: 1px solid rgba(15, 23, 42, 0.1);
        cursor: pointer;
        overflow: hidden;
    }
    .color-swatch input[type="color"] {
        position: absolute;
        inset: -8px;
        width: calc(100% + 16px);
        height: calc(100% + 16px);
        opacity: 0;
        cursor: pointer;
    }

    .color-name { display: block; margin: 0; font-size: 13px; font-weight: 700; color: var(--dark-text); cursor: pointer; }
    .color-meta small { display: block; margin: 1px 0 6px; color: #94a3b8; font-size: 11px; }
    .color-meta code { font-size: 12px; font-weight: 600; color: #475569; background: transparent; padding: 0; }

    /* ---------- Right column ---------- */
    .sticky-col {
        position: sticky;
        top: 102px; /* topbar height + gap */
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .side-card { padding: 20px; }

    .side-card-title { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 16px; }
    .side-card-title h5 { margin: 0; font-size: 16px; font-weight: 700; color: var(--dark-text); }
    .live-dot { display: inline-flex; align-items: center; gap: 6px; color: var(--slate); font-size: 12px; }
    .live-dot::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: var(--lime); }

    /* Mini mock */
    .mock {
        --p: #84CC16; --s: #65A30D; --a: #F59E0B; --bg: #F8FAFC; --tx: #111827;
        border: 1px solid var(--slate-light);
        border-radius: 12px;
        overflow: hidden;
        background: var(--bg);
        color: var(--tx);
    }
    .mock-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        background: var(--p);
    }
    .mock-logo {
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.92);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        color: #94a3b8;
        font-size: 20px;
    }
    .mock-logo img { width: 100%; height: 100%; object-fit: cover; }
    .mock-titles { min-width: 0; }
    .mock-titles strong,
    .mock-titles span {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #fff;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.25);
    }
    .mock-titles strong { font-size: 14px; font-weight: 700; }
    .mock-titles span { font-size: 11px; opacity: 0.9; margin-top: 2px; }

    .mock-body { padding: 16px 14px 18px; }
    .mock-text { font-size: 14px; font-weight: 700; color: var(--tx); }
    .mock-sub { margin-top: 4px; font-size: 12px; color: var(--tx); opacity: 0.7; }
    .mock-actions { display: flex; align-items: center; gap: 8px; margin-top: 14px; flex-wrap: wrap; }
    .mock-btn {
        padding: 7px 14px;
        border-radius: 8px;
        background: var(--p);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    }
    .mock-btn.secondary { background: var(--s); }
    .mock-badge {
        padding: 4px 9px;
        border-radius: 999px;
        background: var(--a);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    }

    .pv-rows { margin-top: 16px; display: flex; flex-direction: column; gap: 10px; }
    .pv-row { display: flex; align-items: center; justify-content: space-between; gap: 10px; font-size: 13px; }
    .pv-label { color: var(--slate); font-size: 12px; }
    .pv-row strong { font-weight: 600; color: var(--dark-text); }
    .pv-pill {
        padding: 4px 10px;
        border-radius: 999px;
        background: var(--lime-light);
        color: var(--lime-dark);
        font-size: 12px;
        font-weight: 600;
    }
    .pv-pill.suspended { background: #fef3c7; color: #b45309; }
    .pv-pill.expired { background: #fee2e2; color: #b91c1c; }

    .pv-admin {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .pv-admin-avatar {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        border-radius: 50%;
        background: var(--navy);
        color: var(--lime);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        overflow: hidden;
    }
    .pv-admin-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .pv-admin-info { min-width: 0; }
    .pv-admin-info strong,
    .pv-admin-info small { display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .pv-admin-info strong { font-size: 13px; font-weight: 600; color: var(--dark-text); margin-top: 1px; }
    .pv-admin-info small { color: var(--slate); font-size: 12px; margin-top: 1px; }

    .info-card { display: flex; align-items: flex-start; gap: 14px; }
    .info-icon {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border-radius: 10px;
        background: var(--lime-light);
        color: var(--lime-dark);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .info-card h6 { margin: 0 0 4px; font-size: 14px; font-weight: 700; color: var(--dark-text); }
    .info-card p { margin: 0; color: var(--slate); font-size: 13px; line-height: 1.55; }

    .btn-submit {
        border: 0;
        border-radius: 12px;
        padding: 14px 18px;
        background: var(--navy);
        color: var(--white);
        font-size: 14px;
        font-weight: 700;
        box-shadow: 0 10px 20px -10px rgba(11, 17, 32, 0.6);
        transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
    }
    .btn-submit i { color: var(--lime); }
    .btn-submit:hover { background: var(--lime); color: var(--navy); }
    .btn-submit:hover i { color: var(--navy); }
    .btn-submit:active { transform: scale(0.98); }
    .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; }

    @media (max-width: 1199.98px) {
        .sticky-col { position: static; }
    }

    @media (max-width: 575.98px) {
        .form-section { padding: 18px; }
        .color-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush


@push('scripts')
<script>
    const $id = (x) => document.getElementById(x);

    const instituteForm = $id('instituteForm');
    const submitButton  = $id('submitButton');
    const submitText    = $id('submitText');
    const submitLoading = $id('submitLoading');
    const mock          = $id('mock');

    const DEFAULT_LOGO = '<i class="bi bi-building"></i>';

    function initialsOf(name) {
        return (name || '').trim().split(/\s+/).map(w => w[0]).slice(0, 2).join('').toUpperCase() || '?';
    }

    // Pick readable text (white or dark) over a given hex background
    function contrastOn(hex) {
        const h = hex.replace('#', '');
        const r = parseInt(h.substr(0, 2), 16), g = parseInt(h.substr(2, 2), 16), b = parseInt(h.substr(4, 2), 16);
        return (r * 299 + g * 587 + b * 114) / 1000 > 160 ? '#0B1120' : '#FFFFFF';
    }

    function formatDate(value) {
        if (!value) return 'Not set';
        return new Date(value + 'T00:00:00').toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    // ---------- Live preview ----------
    function updatePreview() {
        // Text
        $id('pvName').textContent  = $id('name').value.trim()  || 'Institute name';
        $id('pvEmail').textContent = $id('email').value.trim() || 'institute@example.com';
        $id('pvExpiry').textContent = formatDate($id('license_expires_at').value);

        const status = $id('status').value;
        const pill = $id('pvStatus');
        pill.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        pill.className = 'pv-pill ' + status;

        // Admin
        const adminName = $id('admin_name').value.trim();
        $id('pvAdminName').textContent  = adminName || 'Not added yet';
        $id('pvAdminEmail').textContent = $id('admin_email').value.trim() || 'admin@example.com';
        if (!$id('adminPreview').querySelector('img')) {
            $id('adminPreview').textContent = adminName ? initialsOf(adminName) : '?';
        }

        // Colors
        const p = $id('primary_color').value,  s = $id('secondary_color').value,
              a = $id('accent_color').value,   bg = $id('background_color').value,
              tx = $id('text_color').value;

        mock.style.setProperty('--p', p);
        mock.style.setProperty('--s', s);
        mock.style.setProperty('--a', a);
        mock.style.setProperty('--bg', bg);
        mock.style.setProperty('--tx', tx);

        // Keep text on colored areas readable
        mock.querySelectorAll('.mock-titles strong, .mock-titles span').forEach(el => el.style.color = contrastOn(p));
        $id('pvBtn').style.color   = contrastOn(p);
        $id('pvBtn2').style.color  = contrastOn(s);
        $id('pvBadge').style.color = contrastOn(a);
    }

    // Color pickers: update swatch + hex label
    document.querySelectorAll('.color-swatch input[type="color"]').forEach(function (input) {
        const swatch = input.closest('.color-swatch');
        const label  = $id(input.id + '_value');

        function sync() {
            swatch.style.setProperty('--swatch', input.value);
            label.textContent = input.value.toUpperCase();
            updatePreview();
        }

        input.addEventListener('input', sync);
        sync();
    });

    ['name', 'email', 'license_expires_at', 'status', 'admin_name', 'admin_email'].forEach(function (field) {
        $id(field).addEventListener('input', updatePreview);
        $id(field).addEventListener('change', updatePreview);
    });

    // Image previews
    function bindImagePreview(inputId, targetId, fallbackHtml, afterClear) {
        $id(inputId).addEventListener('change', function () {
            const file = this.files[0];
            const target = $id(targetId);

            if (!file) {
                target.innerHTML = fallbackHtml;
                if (afterClear) afterClear();
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                target.innerHTML = `<img src="${e.target.result}" alt="">`;
            };
            reader.readAsDataURL(file);
        });
    }

    bindImagePreview('logo', 'logoPreview', DEFAULT_LOGO);
    bindImagePreview('admin_profile_image', 'adminPreview', '?', updatePreview);

    // Password show / hide
    document.querySelectorAll('.toggle-pass').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = $id(this.dataset.target);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            this.innerHTML = `<i class="bi ${show ? 'bi-eye-slash' : 'bi-eye'}"></i>`;
            this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        });
    });

    updatePreview();

    // ---------- Submit ----------
    const errorMap = {
        name: 'nameError', email: 'emailError', Contact: 'ContactError', address: 'addressError',
        license_key: 'licenseKeyError', license_expires_at: 'licenseExpiryError', status: 'statusError',
        logo: 'logoError',
        admin_name: 'adminNameError', admin_email: 'adminEmailError',
        admin_password: 'adminPasswordError', admin_password_confirmation: 'adminPasswordConfirmationError',
        admin_profile_image: 'adminProfileImageError',
        primary_color: 'primaryColorError', secondary_color: 'secondaryColorError', accent_color: 'accentColorError',
        background_color: 'backgroundColorError', text_color: 'textColorError'
    };

    instituteForm.addEventListener('submit', function (event) {
        event.preventDefault();
        clearErrors();
        setLoading(true);

        $.ajax({
            url: '/api/addInstitute',
            type: 'POST',
            headers: { 'Authorization': 'Bearer ' + token },
            data: new FormData(instituteForm),
            contentType: false,
            processData: false,

            success: function (response) {
                showAlert(response.message || 'Institute created successfully.', 'success');
                window.scrollTo({ top: 0, behavior: 'smooth' });
                // Short pause so the success message is seen before redirecting
                setTimeout(function () { window.location.href = '/superAdmin/dashboard'; }, 900);
            },

            error: function (xhr) {
                setLoading(false);

                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = xhr.responseJSON.errors;
                    let firstField = null;

                    Object.keys(errors).forEach(function (field) {
                        const box = $id(errorMap[field]);
                        if (box) box.textContent = errors[field][0];

                        const input = $id(field);
                        if (input) {
                            input.classList.add('is-invalid');
                            if (!firstField) firstField = input;
                        }
                    });

                    showAlert('Please fix the highlighted fields and try again.', 'error');
                    if (firstField) {
                        firstField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstField.focus({ preventScroll: true });
                    }
                } else if (xhr.status === 422 && xhr.responseJSON) {
                    showAlert(xhr.responseJSON.message || 'Validation failed.', 'error');
                } else {
                    showAlert("Couldn't create the institute. Check your connection and try again.", 'error');
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        });
    });

    // Clear a field's error as soon as the user edits it
    instituteForm.addEventListener('input', function (e) {
        e.target.classList.remove('is-invalid');
        const box = $id(errorMap[e.target.id]);
        if (box) box.textContent = '';
    });

    function setLoading(loading) {
        submitButton.disabled = loading;
        submitText.style.display = loading ? 'none' : 'inline-block';
        submitLoading.style.display = loading ? 'inline-block' : 'none';
    }

    function clearErrors() {
        document.querySelectorAll('.field-error').forEach(el => el.textContent = '');
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        const alert = $id('formAlert');
        alert.className = 'alert-box';
        alert.textContent = '';
    }

    function showAlert(message, type) {
        const alert = $id('formAlert');
        alert.textContent = message;
        alert.className = 'alert-box ' + (type === 'success' ? 'alert-success' : 'alert-error');
    }
</script>
@endpush