
@extends('layouts.teacher')

@section('title', 'My Profile')
@section('user-role', 'Teacher')
@section('page-title', 'My Profile')
@section('page-description', 'Manage your personal information and teacher account')

@section('content')

@php
    $user = $user ?? auth()->user();
    $institute = $user?->institute;
    $initials = collect(preg_split('/\s+/', trim($user?->name ?? 'Teacher')))
        ->filter()
        ->map(fn ($word) => mb_substr($word, 0, 1))
        ->take(2)
        ->implode('');
@endphp

<div class="container-fluid px-0 teacher-profile">

    <section class="profile-hero">
        <div class="hero-decoration"></div>

        <div class="hero-content">
            <div class="avatar-wrap">
                <div class="profile-avatar" id="headerAvatar">
                    @if($user?->profile_image)
                        <img src="{{ asset('storage/'.$user->profile_image) }}" alt="Teacher profile photo">
                    @else
                        <span>{{ strtoupper($initials) }}</span>
                    @endif
                </div>

                <button type="button" class="avatar-edit" id="avatarEditBtn" title="Change profile photo">
                    <i class="bi bi-camera-fill"></i>
                </button>
            </div>

            <div class="profile-identity">
                <span class="eyebrow">TEACHER ACCOUNT</span>
                <h2>{{ $user?->name ?? 'Teacher' }}</h2>
                <p><i class="bi bi-envelope me-2"></i>{{ $user?->email ?? 'No email available' }}</p>

                <div class="identity-tags">
                    <span><i class="bi bi-mortarboard-fill"></i> Teacher</span>
                    <span><i class="bi bi-person-badge"></i> ID #{{ $user?->id ?? '—' }}</span>
                </div>
            </div>

            <div class="institute-panel">
                <div class="institute-logo">
                    @if($institute?->logo)
                        <img src="{{ asset('storage/'.$institute->logo) }}" alt="Institute logo">
                    @else
                        <i class="bi bi-building"></i>
                    @endif
                </div>
                <div class="institute-text">
                    <small>YOUR INSTITUTE</small>
                    <strong>{{ $institute?->name ?? 'Institute not assigned' }}</strong>
                </div>
            </div>
        </div>
    </section>

    <div class="section-heading">
        <div>
            <h4>Account settings</h4>
            <p>Update your personal details and profile picture.</p>
        </div>
        <div class="section-icon"><i class="bi bi-sliders"></i></div>
    </div>

    <div class="row g-4">

        <div class="col-lg-7">
            <section class="profile-card">
                <div class="card-heading">
                    <div class="card-icon"><i class="bi bi-person-lines-fill"></i></div>
                    <div>
                        <h5>Personal information</h5>
                        <p>Keep your account information up to date.</p>
                    </div>
                </div>

                <form id="profileForm" enctype="multipart/form-data" novalidate>
                    <input type="hidden" id="teacherId" value="{{ $user?->id }}">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $user?->name }}"
                                   placeholder="Enter your full name" required>
                            <div class="field-error" data-error="name"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ $user?->email }}"
                                   placeholder="Enter your email address" required>
                            <div class="field-error" data-error="email"></div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Profile photo</label>

                            <div class="photo-upload">
                                <div class="photo-thumb" id="photoThumb">
                                    @if($user?->profile_image)
                                        <img src="{{ asset('storage/'.$user->profile_image) }}" alt="Current profile photo">
                                    @else
                                        <span>{{ strtoupper($initials) }}</span>
                                    @endif
                                </div>

                                <div class="photo-upload-details">
                                    <strong>Personalize your teacher account</strong>
                                    <p>Choose a photo that colleagues and students can recognize.</p>
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="chooseBtn">
                                        <i class="bi bi-upload me-1"></i> Choose photo
                                    </button>
                                    <small id="photoHint">JPG, PNG or WebP · Maximum 2 MB</small>
                                </div>

                                <input type="file" id="profile_image" name="profile_image"
                                       accept=".jpg,.jpeg,.png,.webp" hidden>
                            </div>

                            <div class="field-error" data-error="profile_image"></div>
                        </div>
                    </div>

                    <div class="form-footer">
                        <small id="dirtyNote">No changes yet.</small>

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light" id="resetButton" disabled>
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary" id="saveButton" disabled>
                                <i class="bi bi-check2-circle me-2"></i> Save changes
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </div>

        <div class="col-lg-5">

            <section class="profile-card mb-4">
                <div class="card-heading">
                    <div class="card-icon"><i class="bi bi-building"></i></div>
                    <div>
                        <h5>Institute information</h5>
                        <p>Your professional affiliation.</p>
                    </div>
                </div>

                <div class="institute-detail">
                    <span class="detail-icon"><i class="bi bi-bank"></i></span>
                    <div>
                        <small>Institute name</small>
                        <strong>{{ $institute?->name ?? 'Not assigned' }}</strong>
                    </div>
                </div>

                <div class="institute-detail">
                    <span class="detail-icon"><i class="bi bi-envelope"></i></span>
                    <div>
                        <small>Institute email</small>
                        <strong>{{ $institute?->email ?? 'Not available' }}</strong>
                    </div>
                </div>

                <div class="institute-detail">
                    <span class="detail-icon"><i class="bi bi-telephone"></i></span>
                    <div>
                        <small>Contact</small>
                        <strong>{{ $institute?->Contact ?? $institute?->contact ?? 'Not available' }}</strong>
                    </div>
                </div>

                <div class="institute-detail">
                    <span class="detail-icon"><i class="bi bi-geo-alt"></i></span>
                    <div>
                        <small>Address</small>
                        <strong>{{ $institute?->address ?? 'Not available' }}</strong>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastBox"></div>

@endsection

@push('styles')
<style>
.teacher-profile {
    color: var(--text-color);
    padding-bottom: 25px;
}

.profile-hero,
.profile-card {
    background: var(--white);
    border: 1px solid var(--slate-light);
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
}

.profile-hero {
    position: relative;
    overflow: hidden;
    padding: 28px;
    margin-bottom: 28px;
}

.hero-decoration {
    position: absolute;
    top: -110px;
    right: -60px;
    width: 270px;
    height: 270px;
    border-radius: 50%;
    background: var(--primary-light);
    opacity: .65;
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
}

.avatar-wrap {
    position: relative;
    flex: 0 0 auto;
}

.profile-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 108px;
    height: 108px;
    overflow: hidden;
    border-radius: 20px;
    border: 4px solid var(--white);
    background: var(--primary-light);
    color: var(--primary-dark);
    box-shadow: var(--shadow-sm);
    font-size: 32px;
    font-weight: 800;
}

.profile-avatar img,
.photo-thumb img,
.institute-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-edit {
    position: absolute;
    right: -7px;
    bottom: -7px;
    width: 34px;
    height: 34px;
    border: 3px solid var(--white);
    border-radius: 50%;
    background: var(--primary-color);
    color: var(--on-primary);
    cursor: pointer;
}

.profile-identity {
    flex: 1 1 220px;
    min-width: 0;
}

.eyebrow {
    color: var(--primary-dark);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.4px;
}

.profile-identity h2 {
    margin: 7px 0 5px;
    font-size: 27px;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.profile-identity p {
    margin: 0 0 13px;
    color: var(--slate);
    overflow-wrap: anywhere;
}

.identity-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.identity-tags span {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 11px;
    border-radius: 8px;
    background: var(--primary-light);
    color: var(--primary-dark);
    font-size: 12px;
    font-weight: 700;
}

.institute-panel {
    display: flex;
    align-items: center;
    gap: 11px;
    max-width: 240px;
    padding: 12px;
    border: 1px solid var(--slate-light);
    background: var(--white);
    border-radius: 12px;
}

.institute-logo {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 44px;
    width: 44px;
    height: 44px;
    overflow: hidden;
    border-radius: 10px;
    background: var(--primary-light);
    color: var(--primary-dark);
    font-size: 20px;
}

.institute-text {
    min-width: 0;
}

.institute-text small,
.institute-text strong {
    display: block;
}

.institute-text small {
    margin-bottom: 3px;
    color: var(--slate);
    font-size: 10px;
    font-weight: 800;
}

.institute-text strong {
    font-size: 13px;
    overflow-wrap: anywhere;
}

.section-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 18px;
}

.section-heading h4 {
    margin: 0 0 4px;
    font-size: 19px;
    font-weight: 800;
}

.section-heading p {
    margin: 0;
    color: var(--slate);
    font-size: 13px;
}

.section-icon,
.card-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 44px;
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: var(--primary-light);
    color: var(--primary-dark);
    font-size: 19px;
}

.profile-card {
    height: 100%;
    padding: 23px;
}

.card-heading {
    display: flex;
    align-items: center;
    gap: 13px;
    padding-bottom: 18px;
    margin-bottom: 21px;
    border-bottom: 1px solid var(--slate-light);
}

.card-heading h5 {
    margin: 0 0 4px;
    font-size: 15px;
    font-weight: 800;
}

.card-heading p {
    margin: 0;
    color: var(--slate);
    font-size: 12px;
}

.teacher-profile .form-label {
    margin-bottom: 7px;
    font-size: 13px;
    font-weight: 700;
}

.teacher-profile .form-control {
    min-height: 44px;
    border-color: var(--slate-light);
    border-radius: 9px;
}

.teacher-profile .form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 .2rem var(--primary-light);
}

.photo-upload {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 16px;
    border: 1px dashed var(--slate-light);
    border-radius: 12px;
}

.photo-thumb {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 65px;
    width: 65px;
    height: 65px;
    overflow: hidden;
    border-radius: 14px;
    background: var(--primary-light);
    color: var(--primary-dark);
    font-weight: 800;
}

.photo-upload-details {
    min-width: 0;
}

.photo-upload-details strong,
.photo-upload-details p,
.photo-upload-details small {
    display: block;
}

.photo-upload-details strong {
    font-size: 13px;
}

.photo-upload-details p {
    margin: 4px 0 10px;
    color: var(--slate);
    font-size: 12px;
}

.photo-upload-details small {
    margin-top: 8px;
    color: var(--slate);
    overflow-wrap: anywhere;
}

.form-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 25px;
    padding-top: 19px;
    border-top: 1px solid var(--slate-light);
}

#dirtyNote {
    color: var(--slate);
    font-size: 12px;
}

.teacher-profile #saveButton {
    font-weight: 700;
}

.teacher-profile #saveButton:disabled,
.teacher-profile #resetButton:disabled {
    opacity: .55;
    cursor: not-allowed;
}

.field-error {
    margin-top: 5px;
    color: var(--danger);
    font-size: 12px;
}

.field-error:empty {
    display: none;
}

.institute-detail {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid var(--slate-light);
}

.institute-detail:last-child {
    border-bottom: 0;
}

.detail-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 0 0 36px;
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: var(--primary-light);
    color: var(--primary-dark);
}

.institute-detail > div {
    min-width: 0;
}

.institute-detail small,
.institute-detail strong {
    display: block;
}

.institute-detail small {
    margin-bottom: 3px;
    color: var(--slate);
    font-size: 11px;
}

.institute-detail strong {
    font-size: 13px;
    font-weight: 600;
    overflow-wrap: anywhere;
}

.account-detail {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    padding: 12px 0;
    border-bottom: 1px solid var(--slate-light);
    font-size: 13px;
}

.account-detail span {
    color: var(--slate);
}

.account-detail strong {
    text-align: right;
    overflow-wrap: anywhere;
}

.security-note {
    display: flex;
    gap: 12px;
    margin-top: 20px;
    padding: 14px;
    border-radius: 11px;
    background: var(--primary-light);
    color: var(--primary-dark);
}

.security-note > i {
    font-size: 18px;
}

.security-note strong {
    font-size: 12px;
}

.security-note p {
    margin: 4px 0 0;
    font-size: 12px;
    line-height: 1.5;
}

.toast-container {
    z-index: 2000;
}

.notice-toast {
    border: 0;
    border-radius: 12px;
    box-shadow: var(--shadow-sm);
    min-width: 300px;
}

.notice-toast .toast-body {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 14px;
    white-space: pre-line;
}

.notice-toast.success {
    background: #dcfce7;
    color: #15803d;
}

.notice-toast.error {
    background: #fee2e2;
    color: #b91c1c;
}

@media (max-width: 767px) {
    .profile-hero {
        padding: 20px;
    }

    .hero-content {
        gap: 18px;
    }

    .institute-panel {
        max-width: none;
        width: 100%;
    }

    .profile-card {
        padding: 18px;
    }
}

@media (max-width: 575px) {
    .profile-avatar {
        width: 88px;
        height: 88px;
        font-size: 27px;
    }

    .form-footer {
        align-items: stretch;
        flex-direction: column;
    }

    .form-footer .d-flex {
        justify-content: flex-end;
    }

    .photo-upload {
        align-items: flex-start;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(function () {
    const token = window.token || localStorage.getItem('token');

    const UPDATE_PROFILE_URL = id => '/api/superAdmin/updateProfile/' + encodeURIComponent(id);

    const SAVE_HTML = '<i class="bi bi-check2-circle me-2"></i> Save changes';
    const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
    const maxPhotoBytes = 2 * 1024 * 1024;

    const form = $('#profileForm');
    const fileInput = $('#profile_image')[0];

    const initial = {
        name: $('#name').val().trim(),
        email: $('#email').val().trim(),
        headerAvatar: $('#headerAvatar').html(),
        photoThumb: $('#photoThumb').html()
    };

    function esc(value) {
        return $('<div>').text(value ?? '').html();
    }

    function showNotice(type, message) {
        const icon = type === 'success'
            ? 'bi-check-circle-fill'
            : 'bi-exclamation-circle-fill';

        const element = $(`
            <div class="toast notice-toast ${type}" role="alert"
                 aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <i class="bi ${icon}"></i>
                    <span class="flex-grow-1">${esc(message)}</span>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `);

        $('#toastBox').append(element);
        element.on('hidden.bs.toast', () => element.remove());

        if (window.bootstrap?.Toast) {
            new bootstrap.Toast(element[0], { delay: 4000 }).show();
        } else {
            alert(message);
        }
    }

    function clearFieldErrors() {
        form.find('.field-error').text('');
        form.find('.is-invalid').removeClass('is-invalid');
    }

    function setFieldError(field, message) {
        form.find('[data-error="' + field + '"]').text(message);
        form.find('[name="' + field + '"]').addClass('is-invalid');
    }

    function isDirty() {
        return $('#name').val().trim() !== initial.name
            || $('#email').val().trim() !== initial.email
            || !!fileInput.files[0];
    }

    function refreshState() {
        const dirty = isDirty();
        $('#saveButton, #resetButton').prop('disabled', !dirty);
        $('#dirtyNote').text(dirty ? 'You have unsaved changes.' : 'No changes yet.');
    }

    function setBusy(busy) {
        $('#saveButton').prop('disabled', busy);

        if (busy) {
            $('#saveButton').html(
                '<span class="spinner-border spinner-border-sm me-2"></span> Saving...'
            );
        } else {
            $('#saveButton').html(SAVE_HTML);
            refreshState();
        }
    }

    $('#name, #email').on('input', function () {
        $(this).removeClass('is-invalid');
        form.find('[data-error="' + this.name + '"]').text('');
        refreshState();
    });

    $('#avatarEditBtn, #chooseBtn').on('click', function () {
        $('#profile_image').trigger('click');
    });

    $('#profile_image').on('change', function () {
        const file = this.files[0];

        form.find('[data-error="profile_image"]').text('');
        $('#profile_image').removeClass('is-invalid');

        if (!file) {
            refreshState();
            return;
        }

        let problem = '';

        if (!allowedTypes.includes(file.type)) {
            problem = 'Choose a JPG, PNG or WebP image.';
        } else if (file.size > maxPhotoBytes) {
            problem = 'The image must be 2 MB or smaller.';
        }

        if (problem) {
            this.value = '';
            setFieldError('profile_image', problem);
            $('#headerAvatar').html(initial.headerAvatar);
            $('#photoThumb').html(initial.photoThumb);
            $('#photoHint').text('JPG, PNG or WebP · Maximum 2 MB');
            refreshState();
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            const image = $('<img>', {
                src: event.target.result,
                alt: 'Selected profile photo'
            });

            $('#headerAvatar').empty().append(image.clone());
            $('#photoThumb').empty().append(image);
        };

        reader.readAsDataURL(file);
        $('#photoHint').text(file.name);
        refreshState();
    });

    $('#resetButton').on('click', function () {
        $('#name').val(initial.name);
        $('#email').val(initial.email);
        $('#profile_image').val('');
        $('#headerAvatar').html(initial.headerAvatar);
        $('#photoThumb').html(initial.photoThumb);
        $('#photoHint').text('JPG, PNG or WebP · Maximum 2 MB');
        clearFieldErrors();
        refreshState();
    });

    form.on('submit', function (event) {
        event.preventDefault();
        clearFieldErrors();

        if (!token) {
            showNotice('error', 'Your login session was not found. Please log in again.');
            return;
        }

        let invalid = false;
        const name = $('#name').val().trim();
        const email = $('#email').val().trim();

        if (!name) {
            setFieldError('name', 'Please enter your name.');
            invalid = true;
        }

        if (!/^\S+@\S+\.\S+$/.test(email)) {
            setFieldError('email', 'Please enter a valid email address.');
            invalid = true;
        }

        if (invalid) return;

        const formData = new FormData(form[0]);
        formData.delete('password');
        formData.delete('password_confirmation');

        setBusy(true);

        $.ajax({
            url: UPDATE_PROFILE_URL($('#teacherId').val()),
            type: 'POST',
            headers: {
                Authorization: 'Bearer ' + token,
                Accept: 'application/json'
            },
            data: formData,
            contentType: false,
            processData: false,

            success: function (response) {
                showNotice(
                    'success',
                    response.message || 'Profile updated successfully.'
                );

                setTimeout(function () {
                    window.location.reload();
                }, 900);
            },

            error: function (xhr) {
                setBusy(false);

                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    Object.entries(xhr.responseJSON.errors).forEach(function ([field, messages]) {
                        setFieldError(field, messages[0]);
                    });

                    showNotice('error', 'Please correct the highlighted fields.');
                    return;
                }

                if (xhr.status === 401) {
                    showNotice('error', 'Your session has expired. Please log in again.');
                    return;
                }

                showNotice(
                    'error',
                    xhr.responseJSON?.message || 'Could not update your profile. Please try again.'
                );
            }
        });
    });

    refreshState();
});
</script>
@endpush
