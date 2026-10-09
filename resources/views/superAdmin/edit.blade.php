@extends('layouts.app')
@section('user-role', 'Platform Administrator')
@section('page-title', 'Update Institute')
@section('page-description', 'Edit the institute details, its administrator and its colors.')

@section('sidebar')
    <div class="sidebar-section-label">Main</div>

    <a href="/superAdmin/dashboard" class="nav-item">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
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

<div id="formAlert" class="alert-box"></div>

<form id="instituteForm" enctype="multipart/form-data">

    <input type="hidden" id="instituteId" value="{{ $editInstitute->id }}">

    <div class="row g-4">

        {{-- ================= Left: form ================= --}}
        <div class="col-xl-8">

            {{-- Institute information --}}
            <section class="form-section">
                <header class="form-section-head">
                    <div class="head-icon"><i class="bi bi-building"></i></div>
                    <div>
                        <h5>Institute information</h5>
                        <p>Edit the basic details of the institute.</p>
                    </div>
                </header>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="name" class="form-label">Institute name <span class="req">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{ $editInstitute->name }}" placeholder="e.g. Sun Rise College">
                        <div id="nameError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Institute email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="{{ $editInstitute->email }}" placeholder="college@example.com">
                        <div id="emailError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="Contact" class="form-label">Contact number</label>
                        <input type="text" class="form-control" id="Contact" name="Contact"
                               value="{{ $editInstitute->Contact }}" placeholder="03001234567">
                        <div id="ContactError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address"
                               value="{{ $editInstitute->address }}" placeholder="Institute address">
                        <div id="addressError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="license_key" class="form-label">License key</label>
                        <input type="text" class="form-control" id="license_key" name="license_key"
                               value="{{ $editInstitute->license_key }}" placeholder="Leave empty to generate automatically">
                        <div id="licenseKeyError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="license_expires_at" class="form-label">License expiry</label>
                        <input type="date" class="form-control" id="license_expires_at" name="license_expires_at"
                               value="{{ $editInstitute->license_expires_at }}">
                        <div id="licenseExpiryError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" {{ $editInstitute->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ $editInstitute->status === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="expired" {{ $editInstitute->status === 'expired' ? 'selected' : '' }}>Expired</option>
                        </select>
                        <div id="statusError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="logo" class="form-label">Institute logo</label>

                        @if($editInstitute->logo)
                            <div class="current-file">
                                <img src="{{ asset('storage/'.$editInstitute->logo) }}" alt="Institute logo">
                                <div>
                                    <strong>Current logo</strong>
                                    <small>Choose a new file to replace it.</small>
                                </div>
                            </div>
                        @endif

                        <input type="file" class="form-control" id="logo" name="logo" accept=".jpg,.jpeg,.png,.webp">
                        <div id="logoError" class="field-error"></div>
                    </div>

                </div>
            </section>

            {{-- Admin --}}
            <section class="form-section">
                <header class="form-section-head">
                    <div class="head-icon"><i class="bi bi-person-badge"></i></div>
                    <div>
                        <h5>Institute admin</h5>
                        <p>This administrator manages the institute.</p>
                    </div>
                </header>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="admin_name" class="form-label">Admin name <span class="req">*</span></label>
                        <input type="text" class="form-control" id="admin_name" name="admin_name"
                               value="{{ $admin->name }}" placeholder="e.g. Sun Rise Admin">
                        <div id="adminNameError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="admin_email" class="form-label">Admin email <span class="req">*</span></label>
                        <input type="email" class="form-control" id="admin_email" name="admin_email"
                               value="{{ $admin->email }}" placeholder="admin@example.com">
                        <div id="adminEmailError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="admin_password" class="form-label">Admin password <span class="req">*</span></label>
                        <input type="password" class="form-control" id="admin_password" name="admin_password"
                               placeholder="Minimum 8 characters">
                        <div id="adminPasswordError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="admin_password_confirmation" class="form-label">Confirm password <span class="req">*</span></label>
                        <input type="password" class="form-control" id="admin_password_confirmation" name="admin_password_confirmation"
                               placeholder="Confirm password">
                        <div id="adminPasswordConfirmationError" class="field-error"></div>
                    </div>

                    <div class="col-md-6">
                        <label for="admin_profile_image" class="form-label">Admin profile image</label>

                        @if($admin->profile_image)
                            <div class="current-file">
                                <img src="{{ asset('storage/'.$admin->profile_image) }}" alt="Admin profile image" class="round">
                                <div>
                                    <strong>Current photo</strong>
                                    <small>Choose a new file to replace it.</small>
                                </div>
                            </div>
                        @endif

                        <input type="file" class="form-control" id="admin_profile_image" name="admin_profile_image" accept=".jpg,.jpeg,.png,.webp">
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
                        <p>Choose the colors used across this institute's quiz portal.</p>
                    </div>
                </header>

                <div class="color-grid">

                    <div class="color-tile">
                        <input type="color" id="primary_color" name="primary_color" value="{{ $editInstituteConfig->primary_color }}">
                        <div class="color-meta">
                            <label for="primary_color" class="color-name">Primary</label>
                            <small>Main brand color</small>
                            <span id="primaryColorValue">#84CC16</span>
                            <input type="text" class="hex-input" data-for="primary_color" maxlength="7" spellcheck="false" autocomplete="off" aria-label="Hex code">
                            <div class="swatch-presets" data-for="primary_color"></div>
                        </div>
                        <div id="primaryColorError" class="field-error"></div>
                    </div>

                    <div class="color-tile">
                        <input type="color" id="secondary_color" name="secondary_color" value="{{ $editInstituteConfig->secondary_color }}">
                        <div class="color-meta">
                            <label for="secondary_color" class="color-name">Secondary</label>
                            <small>Supporting color</small>
                            <span id="secondaryColorValue">#65A30D</span>
                            <input type="text" class="hex-input" data-for="secondary_color" maxlength="7" spellcheck="false" autocomplete="off" aria-label="Hex code">
                            <div class="swatch-presets" data-for="secondary_color"></div>
                        </div>
                        <div id="secondaryColorError" class="field-error"></div>
                    </div>

                    <div class="color-tile">
                        <input type="color" id="accent_color" name="accent_color" value="{{ $editInstituteConfig->accent_color }}">
                        <div class="color-meta">
                            <label for="accent_color" class="color-name">Accent</label>
                            <small>Highlights and actions</small>
                            <span id="accentColorValue">#F59E0B</span>
                            <input type="text" class="hex-input" data-for="accent_color" maxlength="7" spellcheck="false" autocomplete="off" aria-label="Hex code">
                            <div class="swatch-presets" data-for="accent_color"></div>
                        </div>
                        <div id="accentColorError" class="field-error"></div>
                    </div>

                    <div class="color-tile">
                        <input type="color" id="background_color" name="background_color" value="{{ $editInstituteConfig->background_color }}">
                        <div class="color-meta">
                            <label for="background_color" class="color-name">Background</label>
                            <small>Page background</small>
                            <span id="backgroundColorValue">#F8FAFC</span>
                            <input type="text" class="hex-input" data-for="background_color" maxlength="7" spellcheck="false" autocomplete="off" aria-label="Hex code">
                            <div class="swatch-presets" data-for="background_color"></div>
                        </div>
                        <div id="backgroundColorError" class="field-error"></div>
                    </div>

                    <div class="color-tile">
                        <input type="color" id="text_color" name="text_color" value="{{ $editInstituteConfig->text_color }}">
                        <div class="color-meta">
                            <label for="text_color" class="color-name">Text</label>
                            <small>Default text color</small>
                            <span id="textColorValue">#111827</span>
                            <input type="text" class="hex-input" data-for="text_color" maxlength="7" spellcheck="false" autocomplete="off" aria-label="Hex code">
                            <div class="swatch-presets" data-for="text_color"></div>
                        </div>
                        <div id="textColorError" class="field-error"></div>
                    </div>

                </div>
            </section>

        </div>


        {{-- ================= Right: preview ================= --}}
        <div class="col-xl-4">
            <div class="sticky-col">

                <div class="side-card preview-card">
                    <div class="side-card-title">
                        <h5>Institute preview</h5>
                    </div>

                    <div class="logo-preview" id="logoPreview">
                        @if($editInstitute->logo)
                            <img src="{{ asset('storage/'.$editInstitute->logo) }}" alt="Institute logo">
                        @else
                            <i class="bi bi-building"></i>
                        @endif
                    </div>

                    <div class="pv-name">{{ $editInstitute->name }}</div>
                    <div class="pv-sub">{{ $editInstitute->email ?: 'No email added' }}</div>

                    <div class="pv-rows">
                        <div class="pv-row">
                            <span class="pv-label">Status</span>
                            <span class="pv-pill {{ $editInstitute->status }}">{{ ucfirst($editInstitute->status) }}</span>
                        </div>
                        <div class="pv-row">
                            <span class="pv-label">License expiry</span>
                            <strong>
                                {{ $editInstitute->license_expires_at ? \Carbon\Carbon::parse($editInstitute->license_expires_at)->format('M j, Y') : 'Not set' }}
                            </strong>
                        </div>
                    </div>

                    <div class="preview-colors">
                        <span class="pv-label">Colors</span>
                        <div><span id="previewPrimary" class="preview-color"></span><span>Primary</span></div>
                        <div><span id="previewSecondary" class="preview-color"></span><span>Secondary</span></div>
                        <div><span id="previewAccent" class="preview-color"></span><span>Accent</span></div>
                    </div>

                    <div class="pv-admin">
                        <div class="pv-admin-avatar">
                            @if($admin->profile_image)
                                <img src="{{ asset('storage/'.$admin->profile_image) }}" alt="">
                            @else
                                {{ strtoupper(mb_substr($admin->name ?? '?', 0, 1)) }}
                            @endif
                        </div>
                        <div class="pv-admin-info">
                            <span class="pv-label">Administrator</span>
                            <strong>{{ $admin->name }}</strong>
                            <small>{{ $admin->email }}</small>
                        </div>
                    </div>
                </div>

                <div class="side-card info-card">
                    <div class="info-icon"><i class="bi bi-info-circle"></i></div>
                    <div>
                        <h6>Updating this institute</h6>
                        <p>Saving updates the institute, its administrator and its colors together.</p>
                    </div>
                </div>

                <button type="submit" id="submitButton" class="btn-submit w-100">
                    <span id="submitText">
                        <i class="bi bi-check2-circle me-2"></i>
                        Update Institute
                    </span>

                    <span id="submitLoading" style="display:none;">
                        <span class="spinner-border spinner-border-sm me-2"></span>
                        Updating...
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

    .field-error { color: var(--danger); font-size: 12px; margin-top: 5px; }
    .field-error:empty { display: none; }

    /* Saved image row */
    .current-file {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid var(--slate-light);
        border-radius: 12px;
        background: #fcfdfb;
    }
    .current-file img {
        width: 52px;
        height: 52px;
        flex: 0 0 52px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--slate-light);
        background: var(--white);
    }
    .current-file img.round { border-radius: 50%; }
    .current-file strong { display: block; font-size: 13px; font-weight: 600; color: var(--dark-text); }
    .current-file small { display: block; margin-top: 2px; color: var(--slate); font-size: 12px; }

    /* Alert (used by the page script) */
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

    /* The native color input is the swatch itself */
    .color-tile input[type="color"] {
        display: block;
        width: 100%;
        height: 64px;
        margin-bottom: 12px;
        padding: 0;
        border: 1px solid rgba(15, 23, 42, 0.12);
        border-radius: 9px;
        background: none;
        cursor: pointer;
        -webkit-appearance: none;
        appearance: none;
    }
    .color-tile input[type="color"]::-webkit-color-swatch-wrapper { padding: 0; }
    .color-tile input[type="color"]::-webkit-color-swatch { border: 0; border-radius: 8px; }
    .color-tile input[type="color"]::-moz-color-swatch { border: 0; border-radius: 8px; }

    .color-name { display: block; margin: 0; font-size: 13px; font-weight: 700; color: var(--dark-text); cursor: pointer; }
    .color-meta small { display: block; margin: 1px 0 6px; color: #94a3b8; font-size: 11px; }
    .color-meta span { font-size: 12px; font-weight: 600; color: #475569; font-variant-numeric: tabular-nums; }

    /* ---------- Right column ---------- */
    .sticky-col {
        position: sticky;
        top: 102px;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .side-card { padding: 22px; }
    .side-card-title h5 { margin: 0 0 16px; font-size: 16px; font-weight: 700; color: var(--dark-text); }

    .logo-preview {
        width: 120px;
        height: 120px;
        margin: 0 auto 16px;
        border-radius: 16px;
        background: var(--white);
        border: 1px dashed #cbd5e1;
        box-shadow: 0 0 0 5px var(--off-white);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .logo-preview i { font-size: 40px; color: #94a3b8; }
    .logo-preview img { width: 100%; height: 100%; object-fit: contain; padding: 6px; }

    .pv-name { text-align: center; font-size: 17px; font-weight: 700; color: var(--dark-text); word-break: break-word; }
    .pv-sub { text-align: center; margin-top: 2px; color: var(--slate); font-size: 13px; word-break: break-word; }

    .pv-rows { margin-top: 18px; display: flex; flex-direction: column; gap: 10px; }
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

    .preview-colors {
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #f1f5f9;
    }
    .preview-colors > div {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
        color: #475569;
        font-size: 13px;
    }
    .preview-color {
        width: 26px;
        height: 26px;
        border-radius: 7px;
        border: 1px solid rgba(15, 23, 42, 0.1);
    }

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

    .info-card { display: flex; align-items: flex-start; gap: 14px; padding: 18px; }
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

    /* Hex field + quick presets (so the native picker / eyedropper isn't required) */
    .color-meta span[id$="ColorValue"] { display: none; }
    .hex-input {
        width: 100%;
        height: 32px;
        padding: 0 8px;
        border: 1px solid #CBD5E1;
        border-radius: 7px;
        font-family: ui-monospace, Menlo, Consolas, monospace;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        text-transform: uppercase;
        background: var(--white);
    }
    .hex-input:focus { outline: 0; border-color: var(--lime); box-shadow: 0 0 0 3px rgba(132, 204, 22, 0.18); }
    .hex-input.invalid { border-color: var(--danger); }
    .swatch-presets { display: flex; flex-wrap: wrap; gap: 5px; margin-top: 10px; }
    .swatch-presets .preset {
        width: 16px;
        height: 16px;
        padding: 0;
        border-radius: 50%;
        border: 1px solid rgba(15, 23, 42, 0.18);
        cursor: pointer;
        transition: transform 0.15s ease;
    }
    .swatch-presets .preset:hover { transform: scale(1.2); }

    @media (max-width: 1199.98px) {
        .sticky-col { position: static; } }
    }

    @media (max-width: 575.98px) {
        .form-section { padding: 18px; }
        .color-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush


@push('scripts')

<script>
console.log("EDIT INSTITUTE SCRIPT LOADED");
// const token = localStorage.getItem('api_token');
const instituteForm = document.getElementById('instituteForm');
const logoInput = document.getElementById('logo');
const logoPreview = document.getElementById('logoPreview');
const submitButton = document.getElementById('submitButton');
const submitText = document.getElementById('submitText');
const submitLoading = document.getElementById('submitLoading');
const id = document.getElementById('instituteId').value;

// The preview is rendered by Blade with the saved logo (or the building icon),
// so we keep that markup to restore it when the file input is cleared.
const savedLogoHtml = logoPreview.innerHTML;

// When a new file is chosen, show it. If cleared, show the saved logo again.
logoInput.addEventListener('change', function () {
    const file = this.files[0];

    if (!file) {
        logoPreview.innerHTML = savedLogoHtml;
        return;
    }

    const reader = new FileReader();
    reader.onload = function (event) {
        logoPreview.innerHTML = '<img src="' + event.target.result + '" alt="Institute Logo">';
    };
    reader.readAsDataURL(file);
});
const colorInputs = [
    {
        input: 'primary_color',
        value: 'primaryColorValue',
        preview: 'previewPrimary'
    },
    {
        input: 'secondary_color',
        value: 'secondaryColorValue',
        preview: 'previewSecondary'
    },
    {
        input: 'accent_color',
        value: 'accentColorValue',
        preview: 'previewAccent'
    }
];


colorInputs.forEach(function (item) {

    const input = document.getElementById(item.input);
    const value = document.getElementById(item.value);
    const preview = document.getElementById(item.preview);

    value.textContent = input.value.toUpperCase();
    preview.style.backgroundColor = input.value;

    input.addEventListener('input', function () {
        
        value.textContent = this.value.toUpperCase();
        preview.style.backgroundColor = this.value;

    });

});


const extraColorInputs = [
    {
        input: 'background_color',
        value: 'backgroundColorValue'
    },
    {
        input: 'text_color',
        value: 'textColorValue'
    }
];


extraColorInputs.forEach(function (item) {

    const input = document.getElementById(item.input);
    const value = document.getElementById(item.value);

    value.textContent = input.value.toUpperCase();

    input.addEventListener('input', function () {
        value.textContent = this.value.toUpperCase();
    });

});

instituteForm.addEventListener('submit', function (event) {

    event.preventDefault();

    clearErrors();

    const formData = new FormData(instituteForm);

    setLoading(true);

    $.ajax({

        url: '/api/updateInstitute/'+id,

        type: 'Post',

        headers: {
            'Authorization': 'Bearer ' + token
        },

        data: formData,

        contentType: false,

        processData: false,

        success: function (response) {

            console.log('Institute edit response:', response);
              
            showAlert(
                response.message || 'Institute updated successfully.',
                'success'
            );

            window.scrollTo({ top: 0, behavior: 'smooth' });

            // Keep the form as it is and the button disabled (prevents double submits),
            // then redirect after a short pause so the success message can be read.
            setTimeout(function () {
                window.location.href = '/superAdmin/dashboard';
            }, 900);

        },

        error: function (xhr) {

            console.log('Update Institute Error:', xhr);

            setLoading(false);

            if (xhr.status === 422 && xhr.responseJSON) {

                const errors = xhr.responseJSON.errors;

                if (errors) {

                    if (errors.name) {
                        document.getElementById('nameError').textContent = errors.name[0];
                    }

                    if (errors.email) {
                        document.getElementById('emailError').textContent = errors.email[0];
                    }

                    if (errors.Contact) {
                        document.getElementById('ContactError').textContent = errors.Contact[0];
                    }

                    if (errors.address) {
                        document.getElementById('addressError').textContent = errors.address[0];
                    }

                    if (errors.license_key) {
                        document.getElementById('licenseKeyError').textContent = errors.license_key[0];
                    }

                    if (errors.license_expires_at) {
                        document.getElementById('licenseExpiryError').textContent = errors.license_expires_at[0];
                    }

                    if (errors.status) {
                        document.getElementById('statusError').textContent = errors.status[0];
                    }

                    if (errors.logo) {
                        document.getElementById('logoError').textContent = errors.logo[0];
                    }

                    if (errors.admin_name) {
                        document.getElementById('adminNameError').textContent = errors.admin_name[0];
                    }

                    if (errors.admin_email) {
                        document.getElementById('adminEmailError').textContent = errors.admin_email[0];
                    }

                    if (errors.admin_password) {
                        document.getElementById('adminPasswordError').textContent = errors.admin_password[0];
                    }

                    if (errors.admin_password_confirmation) {
                        document.getElementById('adminPasswordConfirmationError').textContent =
                            errors.admin_password_confirmation[0];
                    }

                    if (errors.admin_profile_image) {
                        document.getElementById('adminProfileImageError').textContent =
                            errors.admin_profile_image[0];
                    }

                    if (errors.primary_color) {
                        document.getElementById('primaryColorError').textContent =
                            errors.primary_color[0];
                    }

                    if (errors.secondary_color) {
                        document.getElementById('secondaryColorError').textContent =
                            errors.secondary_color[0];
                    }

                    if (errors.accent_color) {
                        document.getElementById('accentColorError').textContent =
                            errors.accent_color[0];
                    }

                    if (errors.background_color) {
                        document.getElementById('backgroundColorError').textContent =
                            errors.background_color[0];
                    }

                    if (errors.text_color) {
                        document.getElementById('textColorError').textContent =
                            errors.text_color[0];
                    }

                } else {

                    showAlert(
                        xhr.responseJSON.message || 'Validation failed.',
                        'error'
                    );

                }

            } else {

                showAlert(
                    "Couldn't update the institute. Check your connection and try again.",
                    'error'
                );
                window.scrollTo({ top: 0, behavior: 'smooth' });

            }

        }

    });

});


function setLoading(loading) {

    submitButton.disabled = loading;

    if (loading) {

        submitText.style.display = 'none';
        submitLoading.style.display = 'inline-block';

    } else {

        submitText.style.display = 'inline-block';
        submitLoading.style.display = 'none';

    }

}


function clearErrors() {

    document.querySelectorAll('.field-error').forEach(function (element) {
        element.textContent = '';
    });

    const alert = document.getElementById('formAlert');

    alert.className = 'alert-box';
    alert.textContent = '';

}


function showAlert(message, type) {

    const alert = document.getElementById('formAlert');

    alert.textContent = message;

    alert.className = 'alert-box ' + (
        type === 'success'
            ? 'alert-success'
            : 'alert-error'
    );

}

// ----- Color helpers: type a hex code or tap a preset (no native picker needed) -----
(function () {
    const presets = ['#84CC16', '#16A34A', '#0EA5E9', '#2563EB', '#7C3AED', '#F59E0B', '#DC2626', '#FFFFFF', '#F8FAFC', '#111827'];

    function normalize(v) {
        v = v.trim();
        if (v[0] !== '#') v = '#' + v;
        if (/^#[0-9a-f]{3}$/i.test(v)) v = '#' + v[1] + v[1] + v[2] + v[2] + v[3] + v[3];
        return /^#[0-9a-f]{6}$/i.test(v) ? v.toLowerCase() : null;
    }

    document.querySelectorAll('.hex-input').forEach(function (hex) {
        const color = document.getElementById(hex.dataset.for);
        const box = document.querySelector('.swatch-presets[data-for="' + hex.dataset.for + '"]');

        // Setting the color input and firing "input" keeps the existing label + preview code working
        function setColor(v) {
            color.value = v;
            color.dispatchEvent(new Event('input', { bubbles: true }));
        }

        hex.value = color.value.toUpperCase();

        color.addEventListener('input', function () {
            hex.value = color.value.toUpperCase();
            hex.classList.remove('invalid');
        });

        hex.addEventListener('input', function () {
            if (/^#?[0-9a-f]{6}$/i.test(hex.value.trim())) {
                hex.classList.remove('invalid');
                setColor(normalize(hex.value));
            } else {
                hex.classList.toggle('invalid', hex.value.trim().length > 0);
            }
        });

        hex.addEventListener('blur', function () {
            const v = normalize(hex.value);
            if (v) setColor(v);
            else hex.value = color.value.toUpperCase();
            hex.classList.remove('invalid');
        });

        presets.forEach(function (c) {
            const b = document.createElement('button');
            b.type = 'button';
            b.className = 'preset';
            b.title = c;
            b.style.background = c;
            b.addEventListener('click', function () { setColor(c.toLowerCase()); });
            box.appendChild(b);
        });
    });
})();

</script>

@endpush