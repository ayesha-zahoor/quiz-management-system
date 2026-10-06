
@extends('layouts.app')

@section('user-role', 'Super Admin')
@section('page-title', 'My Profile')
@section('page-description', 'View and manage your Super Admin account information.')

@section('sidebar')

    <a href="/superadmin/dashboard" class="nav-item">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
    </a>

    {{-- <a href="/superadmin/institutes" class="nav-item">
        <i class="bi bi-building"></i>
        <span>Institutes</span>
    </a>

    <a href="/superadmin/institute-admins" class="nav-item">
        <i class="bi bi-person-badge"></i>
        <span>Institute Admins</span>
    </a>

    <a href="/superadmin/configuration" class="nav-item">
        <i class="bi bi-sliders"></i>
        <span>Configuration</span>
    </a> --}}

    <a href="/superadmin/profile" class="nav-item active">
        <i class="bi bi-person-circle"></i>
        <span>Profile</span>
    </a>

@endsection


@section('content')

<div class="container-fluid px-0">

    <div id="formAlert" class="alert-box"></div>

    <div class="row g-4">

        <div class="col-lg-4">

            <div class="profile-card profile-summary">

                <div class="profile-cover"></div>

                <div class="profile-avatar-wrapper">

                    <div class="profile-avatar" id="profileAvatar">

                        @if($user->profile_image)
                            <img
                                src="{{ asset('storage/'.$user->profile_image) }}"
                                alt="Profile Image"
                                id="avatarImage"
                            >
                        @else
                            <i class="bi bi-person-fill"></i>
                        @endif

                    </div>

                </div>

                <div class="profile-summary-content">

                    <h4>{{ $user->name }}</h4>

                    <p class="profile-email">
                        <i class="bi bi-envelope"></i>
                        {{ $user->email }}
                    </p>

                    <span class="role-badge">
                        <i class="bi bi-shield-check"></i>
                        Super Admin
                    </span>

                    <div class="profile-divider"></div>

                    <div class="profile-meta">
                         <input type="hidden" id="adminId" value="{{ $user->id }}">
                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="bi bi-person-vcard"></i>
                            </div>
                            <div>
                                <small>Admin ID</small>
                                <strong>#{{ $user->id }}</strong>
                            </div>
                        </div>

                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <div>
                                <small>Account Type</small>
                                <strong>System Administrator</strong>
                            </div>
                        </div>

                        <div class="meta-item">
                            <div class="meta-icon">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div>
                                <small>Account Status</small>
                                <strong class="status-active">
                                    Active
                                </strong>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="col-lg-8">

            <div class="form-section">

                <div class="section-header">

                    <div>
                        <h5>Personal Information</h5>
                        <p>Update the information associated with your Super Admin account.</p>
                    </div>

                    <div class="section-icon">
                        <i class="bi bi-person-vcard"></i>
                    </div>

                </div>


                <form id="profileForm" enctype="multipart/form-data">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label for="name" class="form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="{{ $user->name }}"
                                placeholder="Enter your full name"
                            >

                            <div id="nameError" class="field-error"></div>

                        </div>


                        <div class="col-md-6">

                            <label for="email" class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="{{ $user->email }}"
                                placeholder="Enter your email address"
                            >

                            <div id="emailError" class="field-error"></div>

                        </div>


                        <div class="col-md-12">

                            <label for="profile_image" class="form-label">
                                Profile Image
                            </label>

                            <div class="image-upload-area">

                                <div class="upload-preview">

                                    @if($user->profile_image)

                                        <img
                                            src="{{ asset('storage/'.$user->profile_image) }}"
                                            alt="Profile Image"
                                            id="imagePreview"
                                        >
                                    @else
                                        <div id="imagePreviewPlaceholder">
                                            <i class="bi bi-person"></i>
                                        </div>

                                    @endif

                                </div>

                                <div class="upload-content">

                                    <strong>Change profile image</strong>

                                    <p>
                                        Upload a JPG, JPEG, PNG or WEBP image.
                                    </p>

                                    <input
                                        type="file"
                                        class="form-control"
                                        id="profile_image"
                                        name="profile_image"
                                        accept=".jpg,.jpeg,.png,.webp"
                                    >

                                </div>

                            </div>

                            <div id="profileImageError" class="field-error"></div>

                        </div>

                    </div>


                    <div class="section-header security-header">

                        <div>
                            <h5>Change Password</h5>
                            <p>Leave these fields empty if you do not want to change your password.</p>
                        </div>

                        <div class="section-icon">
                            <i class="bi bi-lock"></i>
                        </div>

                    </div>


                    <div class="row g-3">

                        <div class="col-md-6">

                            <label for="password" class="form-label">
                                New Password
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="Enter new password"
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-target="password"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>

                            </div>

                            <div id="passwordError" class="field-error"></div>

                        </div>


                        <div class="col-md-6">

                            <label for="password_confirmation" class="form-label">
                                Confirm New Password
                            </label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Confirm new password"
                                >

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-target="password_confirmation"
                                >
                                    <i class="bi bi-eye"></i>
                                </button>

                            </div>

                            <div id="passwordConfirmationError" class="field-error"></div>

                        </div>

                    </div>


                    <div class="form-footer">

                        <div class="security-note">
                            <i class="bi bi-shield-check"></i>

                            <div>
                                <strong>Keep your account secure</strong>
                                <span>Use a strong password that you do not use elsewhere.</span>
                            </div>
                        </div>


                        <button
                            type="submit"
                            id="saveButton"
                            class="btn-submit"
                        >

                            <span id="saveText">
                                <i class="bi bi-check2-circle me-2"></i>
                                Save Changes
                            </span>

                            <span id="saveLoading" style="display:none;">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Saving...
                            </span>

                        </button>

                    </div>

                </form>

            </div>


            <div class="side-card account-card mt-4">

                <div class="account-icon">
                    <i class="bi bi-info-circle"></i>
                </div>

                <div>

                    <h6>About Your Account</h6>

                    <p>
                        This account has Super Admin access and is responsible
                        for managing institutes, institute administrators and
                        system-level configuration.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@push('styles')

<style>

.profile-card,
.form-section,
.side-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
}


/* ===== Profile Summary ===== */

.profile-card {
    overflow: hidden;
}

.profile-cover {
    height: 105px;
    background: linear-gradient(
        135deg,
        #65A30D,
        #84CC16
    );
    position: relative;
}

.profile-cover::after {
    content: "";
    position: absolute;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    right: -50px;
    top: -100px;
}

.profile-avatar-wrapper {
    display: flex;
    justify-content: center;
    margin-top: -55px;
    position: relative;
}

.profile-avatar {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: #ffffff;
    border: 5px solid #ffffff;
    box-shadow: 0 5px 20px rgba(15, 23, 42, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-avatar i {
    font-size: 48px;
    color: #94a3b8;
}

.profile-summary-content {
    padding: 18px 25px 28px;
    text-align: center;
}

.profile-summary-content h4 {
    margin: 0;
    font-weight: 700;
    color: #111827;
}

.profile-email {
    margin: 7px 0 12px;
    color: #64748b;
    font-size: 13px;
}

.profile-email i {
    margin-right: 5px;
}

.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 13px;
    border-radius: 999px;
    background: #ecfccb;
    color: #4d7c0f;
    font-size: 12px;
    font-weight: 700;
}

.profile-divider {
    border-top: 1px solid #eef2f7;
    margin: 23px 0 20px;
}

.profile-meta {
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.meta-icon {
    width: 38px;
    height: 38px;
    flex-shrink: 0;
    border-radius: 9px;
    background: #f0fdf4;
    color: #65A30D;
    display: flex;
    align-items: center;
    justify-content: center;
}

.meta-item small {
    display: block;
    color: #94a3b8;
    font-size: 11px;
    margin-bottom: 2px;
}

.meta-item strong {
    display: block;
    color: #334155;
    font-size: 13px;
}

.status-active {
    color: #65A30D !important;
}


/* ===== Main Form ===== */

.form-section {
    padding: 25px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 18px;
    margin-bottom: 22px;
    border-bottom: 1px solid #f1f5f9;
    position: relative;
    padding-left: 14px;
}

.section-header::before {
    content: "";
    position: absolute;
    left: 0;
    top: 2px;
    bottom: 18px;
    width: 4px;
    border-radius: 4px;
    background: #84CC16;
}

.section-header h5 {
    margin: 0;
    color: #111827;
    font-weight: 700;
}

.section-header p {
    margin: 5px 0 0;
    color: #64748b;
    font-size: 13px;
}

.section-icon {
    width: 38px;
    height: 38px;
    border-radius: 9px;
    background: #f0fdf4;
    color: #65A30D;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.form-label {
    color: #374151;
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 6px;
}

.form-control {
    border: 1px solid #dbe1e8;
    border-radius: 9px;
    padding: 10px 12px;
    font-size: 14px;
    background: #fcfdfe;
    transition: .2s ease;
}

.form-control:hover {
    border-color: #c3ccd6;
}

.form-control:focus {
    background: #ffffff;
    border-color: #84CC16;
    box-shadow: 0 0 0 3px rgba(132, 204, 22, 0.12);
}

.field-error {
    color: #dc2626;
    font-size: 12px;
    margin-top: 5px;
    min-height: 17px;
}


/* ===== Image Upload ===== */

.image-upload-area {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 15px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background: #fcfdfe;
}

.upload-preview {
    width: 75px;
    height: 75px;
    flex-shrink: 0;
    border-radius: 12px;
    overflow: hidden;
    background: #f1f5f9;
    border: 1px dashed #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

#imagePreviewPlaceholder i {
    font-size: 30px;
    color: #94a3b8;
}

.upload-content {
    flex: 1;
}

.upload-content strong {
    display: block;
    color: #334155;
    font-size: 13px;
    margin-bottom: 3px;
}

.upload-content p {
    margin: 0 0 8px;
    color: #94a3b8;
    font-size: 11px;
}

input[type="file"].form-control {
    padding: 6px 10px;
}

input[type="file"].form-control::file-selector-button {
    border: 0;
    margin: -6px 12px -6px -10px;
    padding: 10px 14px;
    background: #ecfccb;
    color: #4d7c0f;
    font-weight: 600;
    cursor: pointer;
}

input[type="file"].form-control::file-selector-button:hover {
    background: #84CC16;
    color: #0B1120;
}


/* ===== Password ===== */

.security-header {
    margin-top: 35px;
}

.password-wrapper {
    position: relative;
}

.password-wrapper .form-control {
    padding-right: 45px;
}

.password-toggle {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    border: 0;
    background: transparent;
    color: #94a3b8;
    cursor: pointer;
}

.password-toggle:hover {
    color: #65A30D;
}


/* ===== Form Footer ===== */

.form-footer {
    border-top: 1px solid #eef2f7;
    margin-top: 30px;
    padding-top: 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.security-note {
    display: flex;
    align-items: center;
    gap: 10px;
}

.security-note > i {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #f0fdf4;
    color: #65A30D;
    display: flex;
    align-items: center;
    justify-content: center;
}

.security-note strong {
    display: block;
    font-size: 12px;
    color: #334155;
}

.security-note span {
    display: block;
    font-size: 11px;
    color: #94a3b8;
    margin-top: 2px;
}

.btn-submit {
    border: none;
    border-radius: 9px;
    padding: 11px 20px;
    background: #84CC16;
    color: #0B1120;
    font-weight: 700;
    box-shadow: 0 6px 14px rgba(132, 204, 22, .22);
    transition: .2s ease;
    white-space: nowrap;
}

.btn-submit:hover {
    background: #65A30D;
    color: #ffffff;
    transform: translateY(-1px);
}

.btn-submit:disabled {
    opacity: .7;
    cursor: not-allowed;
}


/* ===== Account Card ===== */

.side-card {
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 13px;
}

.account-icon {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    border-radius: 9px;
    background: #f0fdf4;
    color: #65A30D;
    display: flex;
    align-items: center;
    justify-content: center;
}

.account-card h6 {
    margin: 2px 0 5px;
    color: #111827;
    font-weight: 700;
}

.account-card p {
    margin: 0;
    color: #64748b;
    font-size: 12px;
    line-height: 1.6;
}


/* ===== Alerts ===== */

.alert-box {
    display: none;
    border-radius: 9px;
    padding: 12px 15px;
    margin-bottom: 20px;
    font-size: 14px;
}

.alert-success {
    display: block;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
}

.alert-error {
    display: block;
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}


/* ===== Responsive ===== */

@media (max-width: 991px) {

    .profile-card {
        margin-bottom: 0;
    }

}

@media (max-width: 600px) {

    .form-section {
        padding: 18px;
    }

    .form-footer {
        align-items: stretch;
        flex-direction: column;
    }

    .btn-submit {
        width: 100%;
    }

    .image-upload-area {
        align-items: flex-start;
        flex-direction: column;
    }

}

</style>

@endpush


@push('scripts')

<script>

// const token = localStorage.getItem('api_token');

const profileForm = document.getElementById('profileForm');
const saveButton = document.getElementById('saveButton');
const saveText = document.getElementById('saveText');
const saveLoading = document.getElementById('saveLoading');


const profileImageInput = document.getElementById('profile_image');

if (profileImageInput) {

    profileImageInput.addEventListener('change', function () {

        const file = this.files[0];

        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {

            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('imagePreviewPlaceholder');

            if (placeholder) {
                placeholder.remove();
            }

            if (preview) {

                preview.src = event.target.result;

            } else {

                document.querySelector('.upload-preview').innerHTML =
                    '<img src="' + event.target.result + '" alt="Profile Image" id="imagePreview">';

            }

            const avatar = document.getElementById('avatarImage');

            if (avatar) {
                avatar.src = event.target.result;
            }

        };

        reader.readAsDataURL(file);

    });

}


document.querySelectorAll('.password-toggle').forEach(function (button) {

    button.addEventListener('click', function () {

        const target = document.getElementById(this.dataset.target);

        if (target.type === 'password') {

            target.type = 'text';

            this.innerHTML = '<i class="bi bi-eye-slash"></i>';

        } else {

            target.type = 'password';

            this.innerHTML = '<i class="bi bi-eye"></i>';

        }

    });

});

const id = document.getElementById('adminId').value;
// console.log(id);
profileForm.addEventListener('submit', function (event) {

    event.preventDefault();
    const formData = new FormData(profileForm);
     $.ajax({
        url:'/api/superAdmin/updateProfile/'+ id,
        type:'POST',
        headers:{
            'Authorization': 'Bearer '+ token
        },
        data:formData,
        contentType: false,
        processData: false,
        success: function (response) {

            console.log('Profile updataion:', response);
              
            showAlert(
                response.message || 'Prfile Updated successfully.',
                'success'
            );

            instituteForm.reset();
            window.location.href="/superadmin/dashboard";

        },
        error: function (xhr) {

            console.log('Profile Update Error:', xhr);

            // setLoading(false);
            // if (xhr.status === 422 && xhr.responseJSON) {
            //     const errors = xhr.responseJSON.errors;
            //       console.log(errors);
                // if (errors) {
                //     if (errors.name) {
                //         document.getElementById('nameError').textContent = errors.name[0];
                //     }
                //     if (errors.email) {
                //         document.getElementById('emailError').textContent = errors.email[0];
                //     }
                //     if (errors.Contact) {
                //         document.getElementById('ContactError').textContent = errors.Contact[0];
                //     }
                //     if (errors.address) {
                //         document.getElementById('addressError').textContent = errors.address[0];
                //     }
                //     if (errors.license_key) {
                //         document.getElementById('licenseKeyError').textContent = errors.license_key[0];
                //     }
                //     if (errors.license_expires_at) {
                //         document.getElementById('licenseExpiryError').textContent = errors.license_expires_at[0];
                //     }
                //     if (errors.status) {
                //         document.getElementById('statusError').textContent = errors.status[0];
                //     }
                //     if (errors.logo) {
                //         document.getElementById('logoError').textContent = errors.logo[0];
                //     }
                //     if (errors.admin_name) {
                //         document.getElementById('adminNameError').textContent = errors.admin_name[0];
                //     }
                //     if (errors.admin_email) {
                //         document.getElementById('adminEmailError').textContent = errors.admin_email[0];
                //     }
                //     if (errors.admin_password) {
                //         document.getElementById('adminPasswordError').textContent = errors.admin_password[0];
                //     }
                //     if (errors.admin_password_confirmation) {
                //         document.getElementById('adminPasswordConfirmationError').textContent =
                //             errors.admin_password_confirmation[0];
                //     }
                //     if (errors.admin_profile_image) {
                //         document.getElementById('adminProfileImageError').textContent =
                //             errors.admin_profile_image[0];
                //     }
                //     if (errors.primary_color) {
                //         document.getElementById('primaryColorError').textContent =
                //             errors.primary_color[0];
                //     }
                //     if (errors.secondary_color) {
                //         document.getElementById('secondaryColorError').textContent =
                //             errors.secondary_color[0];
                //     }
                //     if (errors.accent_color) {
                //         document.getElementById('accentColorError').textContent =
                //             errors.accent_color[0];
                //     }
                //     if (errors.background_color) {
                //         document.getElementById('backgroundColorError').textContent =
                //             errors.background_color[0];
                //     }
                //     if (errors.text_color) {
                //         document.getElementById('textColorError').textContent =
                //             errors.text_color[0];
                //     }
            //     } else {
            //         showAlert(
            //             xhr.responseJSON.message || 'Validation failed.',
            //             'error'
            //         );
            //     }
            // } else {
            //     showAlert(
            //         'Something went wrong while creating the institute.',
            //         'error'
            //     );
            // }

        }

    });

});
     /*
       Add your profile update API/AJAX request here.
    */

// });


</script>

@endpush

