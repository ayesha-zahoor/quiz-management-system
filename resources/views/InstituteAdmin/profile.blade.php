@extends('layouts.institute')

@section('title', 'My Profile')
@section('user-role', 'Institute Admin')
@section('page-title', 'My Profile')
@section('page-description', 'View and update your institute admin account')

@section('content')

@php
    $institute = $user->institute;
    $instStatus = $institute->status ?? null;
    $statusKind = $instStatus === 'active' ? 'ok' : ($instStatus === 'suspended' ? 'warn' : 'bad');
    $initials = collect(preg_split('/\s+/', trim($user->name)))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('');
@endphp

<div class="container-fluid px-0">

    {{-- ================= Header banner ================= --}}
    <section class="me-header">

        <div class="me-cover">
            <div class="me-institute">
                <div class="me-institute-logo">
                    @if(!empty($institute->logo))
                        <img src="{{ asset('storage/'.$institute->logo) }}" alt="Institute logo">
                    @else
                        <i class="bi bi-building"></i>
                    @endif
                </div>
                <div>
                    <small>Institute</small>
                    <strong>{{ $institute->name ?? '—' }}</strong>
                </div>
            </div>
        </div>

        <div class="me-body">

            <div class="me-avatar-wrap">
                <div class="me-avatar" id="headerAvatar">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/'.$user->profile_image) }}" alt="Profile photo">
                    @else
                        <span>{{ strtoupper($initials) }}</span>
                    @endif
                </div>

                <button type="button" class="me-avatar-edit" id="avatarEditBtn" title="Change photo" aria-label="Change photo">
                    <i class="bi bi-camera-fill"></i>
                </button>
            </div>

            <div class="me-info">
                <h2>{{ $user->name }}</h2>
                <p><i class="bi bi-envelope"></i> {{ $user->email }}</p>

                <div class="me-badges">
                    <span class="badge-pill role"><i class="bi bi-shield-check"></i> Institute Admin</span>

                    @if($instStatus)
                        <span class="badge-pill {{ $statusKind }}"><i class="bi bi-dot"></i> Institute {{ $instStatus }}</span>
                    @endif
                </div>
            </div>

            <div class="me-stats">
                <div>
                    <small>Admin ID</small>
                    <strong>#{{ $user->id }}</strong>
                </div>
                <div>
                    <small>Member since</small>
                    <strong>{{ optional($user->created_at)->format('M j, Y') ?? '—' }}</strong>
                </div>
                <div>
                    <small>Account</small>
                    <strong class="text-ok">Active</strong>
                </div>
            </div>

        </div>

    </section>


    <div class="row g-4">

        {{-- ================= Edit details ================= --}}
        <div class="col-lg-7">

            <section class="me-card">

                <header class="me-card-head">
                    <div class="me-icon"><i class="bi bi-person-vcard"></i></div>
                    <div>
                        <h5>Your details</h5>
                        <p>Update your name, email and profile photo.</p>
                    </div>
                </header>

                <form id="profileForm" enctype="multipart/form-data" novalidate>

                    <input type="hidden" id="adminId" value="{{ $user->id }}">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $user->name }}" placeholder="Enter your full name">
                            <div class="field-error" data-error="name"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ $user->email }}" placeholder="Enter your email address">
                            <div class="field-error" data-error="email"></div>
                        </div>

                        <div class="col-12">
                            <label class="form-label d-block">Profile Photo</label>

                            <div class="photo-row">
                                <div class="photo-thumb" id="photoThumb">
                                    @if($user->profile_image)
                                        <img src="{{ asset('storage/'.$user->profile_image) }}" alt="">
                                    @else
                                        <span>{{ strtoupper($initials) }}</span>
                                    @endif
                                </div>

                                <div class="photo-actions">
                                    <button type="button" class="btn btn-light btn-sm" id="chooseBtn">
                                        <i class="bi bi-upload me-1"></i> Upload new photo
                                    </button>
                                    <small id="photoHint">JPG, PNG or WebP, up to 2 MB.</small>
                                </div>

                                <input type="file" id="profile_image" name="profile_image"
                                       accept=".jpg,.jpeg,.png,.webp" hidden>
                            </div>

                            <div class="field-error" data-error="profile_image"></div>
                        </div>

                    </div>

                    <div class="me-footer">
                        <small class="text-muted" id="dirtyNote">No changes yet.</small>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light" id="resetButton" disabled>Reset</button>
                            <button type="submit" class="btn btn-primary save-btn" id="saveButton" disabled>
                                <i class="bi bi-check2-circle me-2"></i> Save Changes
                            </button>
                        </div>
                    </div>

                </form>

            </section>

        </div>


        {{-- ================= Institute (read only) + security ================= --}}
        <div class="col-lg-5">

            <section class="me-card mb-4">

                <header class="me-card-head">
                    <div class="me-icon"><i class="bi bi-building"></i></div>
                    <div>
                        <h5>Your institute</h5>
                        <p>Managed by the Super Admin.</p>
                    </div>
                </header>

                <ul class="detail-list">
                    <li>
                        <i class="bi bi-bank"></i>
                        <div><small>Name</small><strong>{{ $institute->name ?? '—' }}</strong></div>
                    </li>
                    <li>
                        <i class="bi bi-envelope"></i>
                        <div><small>Email</small><strong>{{ $institute->email ?? '—' }}</strong></div>
                    </li>
                    <li>
                        <i class="bi bi-telephone"></i>
                        <div><small>Contact</small><strong>{{ $institute->Contact ?? '—' }}</strong></div>
                    </li>
                    <li>
                        <i class="bi bi-geo-alt"></i>
                        <div><small>Address</small><strong>{{ $institute->address ?? '—' }}</strong></div>
                    </li>
                    <li>
                        <i class="bi bi-calendar-event"></i>
                        <div>
                            <small>License valid until</small>
                            <strong>
                                @if(!empty($institute->license_expires_at))
                                    {{ \Carbon\Carbon::parse($institute->license_expires_at)->format('M j, Y') }}
                                @else
                                    No expiry set
                                @endif
                            </strong>
                        </div>
                    </li>
                </ul>

            </section>

            <section class="me-card note-card">
                <div class="me-icon"><i class="bi bi-lock"></i></div>
                <div>
                    <h6>Password</h6>
                    <p>
                        For security, your password can only be changed by the Super Admin.
                        Contact them if you need it reset.
                    </p>
                </div>
            </section>

        </div>

    </div>

</div>

{{-- Messages --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastBox"></div>

@endsection


@push('styles')
<style>

    .me-header,
    .me-card {
        background: var(--white);
        border: 1px solid var(--slate-light);
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
    }

    /* ---------- Header banner ---------- */
    .me-header { overflow: hidden; margin-bottom: 24px; }

    .me-cover {
        position: relative;
        height: 150px;
        background: linear-gradient(120deg, var(--primary-color), var(--primary-dark));
        overflow: hidden;
    }

    .me-cover::before,
    .me-cover::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.14);
        pointer-events: none;
    }
    .me-cover::before { width: 300px; height: 300px; right: -80px; top: -150px; }
    .me-cover::after  { width: 180px; height: 180px; right: 190px; bottom: -120px; }

    .me-institute {
        position: absolute;
        top: 18px;
        right: 20px;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 14px 8px 8px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(6px);
        max-width: calc(100% - 40px);
    }

    .me-institute-logo {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .me-institute-logo img { width: 100%; height: 100%; object-fit: cover; }

    .me-institute small { display: block; color: var(--slate); font-size: 11px; line-height: 1.1; }
    .me-institute strong { display: block; color: var(--navy); font-size: 14px; line-height: 1.3; overflow-wrap: anywhere; }

    .me-body {
        display: flex;
        align-items: flex-end;
        gap: 22px;
        padding: 0 28px 24px;
    }

    .me-avatar-wrap { position: relative; flex: 0 0 auto; margin-top: -62px; }

    .me-avatar {
        width: 124px;
        height: 124px;
        border-radius: 50%;
        border: 5px solid var(--white);
        background: var(--primary-color);
        color: var(--on-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 700;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.18);
    }
    .me-avatar img { width: 100%; height: 100%; object-fit: cover; }

    .me-avatar-edit {
        position: absolute;
        right: 2px;
        bottom: 6px;
        width: 36px;
        height: 36px;
        border: 3px solid var(--white);
        border-radius: 50%;
        background: var(--navy);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        transition: transform 0.2s ease, background 0.2s ease;
    }
    .me-avatar-edit:hover { background: var(--secondary-color); transform: scale(1.08); }

    .me-info { flex: 1; min-width: 0; padding-top: 14px; }
    .me-info h2 { margin: 0; font-size: 24px; font-weight: 700; letter-spacing: -0.4px; color: var(--text-color); overflow-wrap: anywhere; }
    .me-info p { margin: 4px 0 10px; color: var(--slate); font-size: 14px; overflow-wrap: anywhere; }
    .me-info p i { margin-right: 6px; }

    .me-badges { display: flex; flex-wrap: wrap; gap: 8px; }

    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        text-transform: capitalize;
    }
    .badge-pill.role { background: var(--primary-light); color: var(--primary-dark); }
    .badge-pill.ok   { background: #dcfce7; color: #15803d; }
    .badge-pill.warn { background: #fef3c7; color: #b45309; }
    .badge-pill.bad  { background: #fee2e2; color: #b91c1c; }
    .badge-pill i.bi-dot { font-size: 18px; margin: -4px -4px -4px -6px; }

    .me-stats { display: flex; gap: 28px; padding-top: 14px; }
    .me-stats small { display: block; color: var(--slate); font-size: 11px; margin-bottom: 2px; }
    .me-stats strong { display: block; font-size: 14px; color: var(--text-color); white-space: nowrap; }
    .text-ok { color: var(--success) !important; }

    /* ---------- Cards ---------- */
    .me-card { padding: 24px; }

    .me-card-head {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 22px;
        padding-bottom: 18px;
        border-bottom: 1px solid #f1f5f9;
    }

    .me-icon {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        border-radius: 11px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 19px;
    }

    .me-card-head h5 { margin: 0; font-size: 16px; font-weight: 700; color: var(--text-color); }
    .me-card-head p { margin: 3px 0 0; color: var(--slate); font-size: 13px; }

    .form-label { margin-bottom: 6px; }
    .form-control { padding: 10px 12px; }

    .field-error { color: var(--danger); font-size: 12px; margin-top: 5px; }
    .field-error:empty { display: none; }

    /* ---------- Photo row ---------- */
    .photo-row {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 14px;
        border: 1px solid var(--slate-light);
        border-radius: 12px;
        background: #fcfdfb;
    }

    .photo-thumb {
        width: 64px;
        height: 64px;
        flex: 0 0 64px;
        border-radius: 50%;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        overflow: hidden;
    }
    .photo-thumb img { width: 100%; height: 100%; object-fit: cover; }

    .photo-actions small { display: block; margin-top: 6px; color: var(--slate); font-size: 12px; }

    /* ---------- Footer ---------- */
    .me-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-top: 26px;
        padding-top: 20px;
        border-top: 1px solid #eef2f7;
    }

    .save-btn { padding: 10px 20px; font-weight: 700; border-radius: 10px; }
    .save-btn:disabled, #resetButton:disabled { opacity: 0.5; cursor: not-allowed; }

    /* ---------- Institute details ---------- */
    .detail-list { list-style: none; margin: 0; padding: 0; }

    .detail-list li {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .detail-list li:first-child { padding-top: 0; }
    .detail-list li:last-child { border-bottom: 0; padding-bottom: 0; }

    .detail-list li > i {
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .detail-list small { display: block; color: var(--slate); font-size: 11px; margin-bottom: 2px; }
    .detail-list strong { display: block; font-size: 14px; font-weight: 600; color: var(--text-color); overflow-wrap: anywhere; }

    /* ---------- Password note ---------- */
    .note-card { display: flex; align-items: flex-start; gap: 14px; padding: 20px; }
    .note-card h6 { margin: 2px 0 4px; font-size: 14px; font-weight: 700; color: var(--text-color); }
    .note-card p { margin: 0; color: var(--slate); font-size: 13px; line-height: 1.6; }

    /* ---------- Messages ---------- */
    .toast-container { z-index: 2000; }

    .notice-toast {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.18);
        min-width: 300px;
    }

    .notice-toast .toast-body { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; white-space: pre-line; }
    .notice-toast.success { background: #dcfce7; color: #15803d; }
    .notice-toast.error   { background: #fee2e2; color: #b91c1c; }

    /* ---------- Responsive ---------- */
    @media (max-width: 991.98px) {
        .me-body { flex-wrap: wrap; }
        .me-stats { width: 100%; padding-top: 4px; }
    }

    @media (max-width: 575.98px) {
        .me-body { flex-direction: column; align-items: center; text-align: center; padding: 0 18px 20px; }
        .me-info { padding-top: 6px; }
        .me-badges { justify-content: center; }
        .me-stats { justify-content: center; gap: 20px; }
        .me-institute { left: 14px; right: 14px; top: 14px; }
        .me-card { padding: 18px; }
        .me-footer { flex-direction: column; align-items: stretch; }
        .me-footer .d-flex { justify-content: flex-end; }
    }

</style>
@endpush


@push('scripts')
<script>
    // Adjust to your route if needed. Only name, email and photo are sent: no password.
    const UPDATE_PROFILE_URL = id => '/api/superAdmin/updateProfile/' + encodeURIComponent(id);

    const SAVE_HTML = '<i class="bi bi-check2-circle me-2"></i> Save Changes';
    const ALLOWED_PHOTO_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
    const MAX_PHOTO_BYTES = 2 * 1024 * 1024;

    const initial = {
        name: $('#name').val().trim(),
        email: $('#email').val().trim(),
        headerAvatar: $('#headerAvatar').html(),
        photoThumb: $('#photoThumb').html()
    };

    // ---------- Helpers ----------
    function esc(value) {
        return $('<div>').text(value ?? '').html();
    }

    function showNotice(type, message) {
        const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-circle-fill';
        const el = $(`
            <div class="toast notice-toast ${type}" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <i class="bi ${icon}"></i>
                    <span class="flex-grow-1">${esc(message)}</span>
                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>`);

        $('#toastBox').append(el);
        el.on('hidden.bs.toast', () => el.remove());
        new bootstrap.Toast(el[0], { delay: 4000 }).show();
    }

    function clearFieldErrors() {
        $('#profileForm .field-error').text('');
        $('#profileForm .is-invalid').removeClass('is-invalid');
    }

    function setFieldError(field, message) {
        $('#profileForm [data-error="' + field + '"]').text(message);
        $('#profileForm [name="' + field + '"]').addClass('is-invalid');
    }

    function setBusy(busy) {
        const button = $('#saveButton');
        button.prop('disabled', busy);
        button.html(busy ? '<span class="spinner-border spinner-border-sm me-2"></span> Saving...' : SAVE_HTML);
    }

    // ---------- Only allow saving when something changed ----------
    function isDirty() {
        return $('#name').val().trim() !== initial.name
            || $('#email').val().trim() !== initial.email
            || !!$('#profile_image')[0].files[0];
    }

    function refreshState() {
        const dirty = isDirty();
        $('#saveButton, #resetButton').prop('disabled', !dirty);
        $('#dirtyNote').text(dirty ? 'You have unsaved changes.' : 'No changes yet.');
    }

    $('#name, #email').on('input', function () {
        $(this).removeClass('is-invalid');
        $('#profileForm [data-error="' + this.name + '"]').text('');
        refreshState();
    });

    // ---------- Photo ----------
    $('#avatarEditBtn, #chooseBtn').on('click', () => $('#profile_image').trigger('click'));

    $('#profile_image').on('change', function () {
        const file = this.files[0];

        $('#profileForm [data-error="profile_image"]').text('');

        if (file) {
            let problem = '';

            if (!ALLOWED_PHOTO_TYPES.includes(file.type)) problem = 'Please choose a JPG, PNG or WebP image.';
            else if (file.size > MAX_PHOTO_BYTES) problem = 'The image must be 2 MB or smaller.';

            if (problem) {
                this.value = '';
                setFieldError('profile_image', problem);
                $('#headerAvatar').html(initial.headerAvatar);
                $('#photoThumb').html(initial.photoThumb);
                $('#photoHint').text('JPG, PNG or WebP, up to 2 MB.');
                refreshState();
                return;
            }

            const img = `<img src="${URL.createObjectURL(file)}" alt="">`;
            $('#headerAvatar').html(img);
            $('#photoThumb').html(img);
            $('#photoHint').text(file.name);
        }

        refreshState();
    });

    // ---------- Reset ----------
    $('#resetButton').on('click', function () {
        $('#name').val(initial.name);
        $('#email').val(initial.email);
        $('#profile_image').val('');
        $('#headerAvatar').html(initial.headerAvatar);
        $('#photoThumb').html(initial.photoThumb);
        $('#photoHint').text('JPG, PNG or WebP, up to 2 MB.');
        clearFieldErrors();
        refreshState();
    });

    // ---------- Save ----------
    $('#profileForm').on('submit', function (event) {
        event.preventDefault();
        clearFieldErrors();

        let invalid = false;

        if (!$('#name').val().trim()) { setFieldError('name', 'Please enter your name.'); invalid = true; }
        if (!/^\S+@\S+\.\S+$/.test($('#email').val().trim())) { setFieldError('email', 'Please enter a valid email address.'); invalid = true; }

        if (invalid) return;

        // Name, email and photo only. The password is never sent from this page.
        const formData = new FormData(this);
        formData.delete('password');
        formData.delete('password_confirmation');

        setBusy(true);

        $.ajax({
            url: UPDATE_PROFILE_URL($('#adminId').val()),
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                showNotice('success', response.message || 'Profile updated successfully.');

                // Reload so the sidebar and top bar show the new name and photo
                setTimeout(() => window.location.reload(), 900);
            },
            error: function (xhr) {
                setBusy(false);
                refreshState();

                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    Object.entries(xhr.responseJSON.errors).forEach(([field, messages]) => setFieldError(field, messages[0]));
                    showNotice('error', 'Please fix the highlighted fields and try again.');
                    return;
                }

                showNotice('error', xhr.responseJSON?.message || "Couldn't update your profile. Please try again.");
            }
        });
    });
</script>
@endpush