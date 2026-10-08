@extends('layouts.app')

@section('user-role', 'Super Admin')
@section('page-title', 'Add Institute')
@section('page-description', 'Create a new institute with its initial administrator and configuration.')

@section('sidebar')
     <a href="/superadmin/dashboard" class="nav-item">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
    </a>
{{-- 
    <a href="/superadmin/institutes" class="nav-item active">
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

    <a href="/superadmin/profile" class="nav-item">
        <i class="bi bi-person-circle"></i>
        <span>Profile</span>
    </a>
@endsection


@section('content')

<div class="container-fluid px-0 ms-auto">
        <a href='/superAdmin/dashboard' class="btn btn-outline-secondary">
        <span>Back</span>
    </a>
    <div id="formAlert" class="alert-box"></div>

    <form id="instituteForm" enctype="multipart/form-data">

        <div class="row g-4">

            <div class="col-lg-8">

                <div class="form-section">

                    <div class="section-header">
                        <div>
                            <h5>Institute Information</h5>
                            <p>Enter the basic information of the institute.</p>
                        </div>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="name" class="form-label">
                                Institute Name <span>*</span>
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                placeholder="e.g. Sun Rise College"
                            >

                            <div id="nameError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">
                                Institute Email
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="college@example.com"
                            >

                            <div id="emailError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="Contact" class="form-label">
                                Contact Number
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="Contact"
                                name="Contact"
                                placeholder="03001234567"
                            >

                            <div id="ContactError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="address" class="form-label">
                                Address
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="address"
                                name="address"
                                placeholder="Institute address"
                            >

                            <div id="addressError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="license_key" class="form-label">
                                License Key
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="license_key"
                                name="license_key"
                                placeholder="Leave empty to generate automatically"
                            >

                            <div id="licenseKeyError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="license_expires_at" class="form-label">
                                License Expiry
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="license_expires_at"
                                name="license_expires_at"
                            >

                            <div id="licenseExpiryError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">
                                Status
                            </label>

                            <select class="form-select" id="status" name="status">
                                <option value="active" selected>Active</option>
                                <option value="suspended">Suspended</option>
                                <option value="expired">Expired</option>
                            </select>

                            <div id="statusError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="logo" class="form-label">
                                Institute Logo
                            </label>

                            <input
                                type="file"
                                class="form-control"
                                id="logo"
                                name="logo"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            <div id="logoError" class="field-error"></div>
                        </div>

                    </div>

                </div>


                <div class="form-section mt-4">

                    <div class="section-header">
                        <div>
                            <h5>Initial Institute Admin</h5>
                            <p>This administrator will manage the institute after creation.</p>
                        </div>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="admin_name" class="form-label">
                                Admin Name <span>*</span>
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="admin_name"
                                name="admin_name"
                                placeholder="e.g. Sun Rise Admin"
                            >

                            <div id="adminNameError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="admin_email" class="form-label">
                                Admin Email <span>*</span>
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="admin_email"
                                name="admin_email"
                                placeholder="admin@example.com"
                            >

                            <div id="adminEmailError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="admin_password" class="form-label">
                                Admin Password <span>*</span>
                            </label>
                            <input
                                type="password"
                                class="form-control"
                                id="admin_password"
                                name="admin_password"
                                placeholder="Minimum 8 characters"
                            >
                            <div id="adminPasswordError" class="field-error"></div>
                        </div>
                        <div class="col-md-6">
                            <label for="admin_password_confirmation" class="form-label">
                                Confirm Password <span>*</span>
                            </label>
                            <input
                                type="password"
                                class="form-control"
                                id="admin_password_confirmation"
                                name="admin_password_confirmation"
                                placeholder="Confirm password"
                            >
                            <div id="adminPasswordConfirmationError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="admin_profile_image" class="form-label">
                                Admin Profile Image
                            </label>

                            <input
                                type="file"
                                class="form-control"
                                id="admin_profile_image"
                                name="admin_profile_image"
                                accept=".jpg,.jpeg,.png,.webp"
                            >

                            <div id="adminProfileImageError" class="field-error"></div>
                        </div>

                    </div>

                </div>


                <div class="form-section mt-4">

                    <div class="section-header">
                        <div>
                            <h5>Institute Configuration</h5>
                            <p>Choose the colors that will be used for this institute.</p>
                        </div>
                    </div>

                    <div class="row g-4">

                        <div class="col-md-6">
                            <div class="color-field">
                                <div>
                                    <label for="primary_color" class="form-label">
                                        Primary Color
                                    </label>
                                    <small>Main brand color</small>
                                </div>
                                <div class="color-picker-wrapper">
                                    <input
                                        type="color"
                                        id="primary_color"
                                        name="primary_color"
                                        value="#84CC16"
                                    >
                                    <span id="primaryColorValue">#84CC16</span>
                                </div>
                            </div>

                            <div id="primaryColorError" class="field-error"></div>
                        </div>


                        <div class="col-md-6">
                            <div class="color-field">
                                <div>
                                    <label for="secondary_color" class="form-label">
                                        Secondary Color
                                    </label>
                                    <small>Supporting brand color</small>
                                </div>
                                <div class="color-picker-wrapper">
                                    <input
                                        type="color"
                                        id="secondary_color"
                                        name="secondary_color"
                                        value="#65A30D"
                                    >
                                    <span id="secondaryColorValue">#65A30D</span>
                                </div>
                            </div>
                            <div id="secondaryColorError" class="field-error"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="color-field">
                                <div>
                                    <label for="accent_color" class="form-label">
                                        Accent Color
                                    </label>
                                    <small>Highlights and actions</small>
                                </div>
                                <div class="color-picker-wrapper">
                                    <input
                                        type="color"
                                        id="accent_color"
                                        name="accent_color"
                                        value="#F59E0B"
                                    >
                                    <span id="accentColorValue">#F59E0B</span>
                                </div>
                            </div>

                            <div id="accentColorError" class="field-error"></div>
                        </div>


                        <div class="col-md-6">
                            <div class="color-field">
                                <div>
                                    <label for="background_color" class="form-label">
                                        Background Color
                                    </label>
                                    <small>Platform background</small>
                                </div>

                                <div class="color-picker-wrapper">
                                    <input
                                        type="color"
                                        id="background_color"
                                        name="background_color"
                                        value="#F8FAFC"
                                    >
                                    <span id="backgroundColorValue">#F8FAFC</span>
                                </div>
                            </div>

                            <div id="backgroundColorError" class="field-error"></div>
                        </div>


                        <div class="col-md-6">
                            <div class="color-field">
                                <div>
                                    <label for="text_color" class="form-label">
                                        Text Color
                                    </label>
                                    <small>Default text color</small>
                                </div>

                                <div class="color-picker-wrapper">
                                    <input
                                        type="color"
                                        id="text_color"
                                        name="text_color"
                                        value="#111827"
                                    >
                                    <span id="textColorValue">#111827</span>
                                </div>
                            </div>

                            <div id="textColorError" class="field-error"></div>
                        </div>

                    </div>

                </div>

            </div>


            <div class="col-lg-4">

                <div class="side-card">

                    <div class="logo-preview" id="logoPreview">
                        <i class="bi bi-building"></i>
                    </div>

                    <h5>Institute Preview</h5>

                    <p>
                        The institute logo will be displayed here after selecting an image.
                    </p>

                    <div class="preview-colors">

                        <div>
                            <span
                                id="previewPrimary"
                                class="preview-color"
                            ></span>
                            <span>Primary</span>
                        </div>

                        <div>
                            <span
                                id="previewSecondary"
                                class="preview-color"
                            ></span>
                            <span>Secondary</span>
                        </div>

                        <div>
                            <span
                                id="previewAccent"
                                class="preview-color"
                            ></span>
                            <span>Accent</span>
                        </div>

                    </div>

                </div>


                <div class="side-card mt-4">

                    <div class="d-flex align-items-start gap-3">
                        <div class="info-icon">
                            <i class="bi bi-info-circle"></i>
                        </div>

                        <div>
                            <h6>Institute Setup</h6>
                            <p class="mb-0">
                                This form creates the institute, its initial
                                Institute Admin, and its configuration together.
                            </p>
                        </div>
                    </div>

                </div>


                <button
                    type="submit"
                    id="submitButton"
                    class="btn-submit mt-4 w-100"
                >
                    <span id="submitText">
                        <i class="bi bi-building-add me-2"></i>
                        Create Institute
                    </span>

                    <span id="submitLoading" style="display:none;">
                        <span class="spinner-border spinner-border-sm me-2"></span>
                        Creating...
                    </span>
                </button>

            </div>

        </div>

    </form>

</div>

@endsection


@push('styles')

<style>

.form-section,
.side-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 24px;
}

.section-header {
    margin-bottom: 22px;
}

.section-header h5 {
    margin: 0;
    color: #111827;
    font-weight: 700;
}

.section-header p {
    margin: 5px 0 0;
    color: #64748b;
    font-size: 14px;
}

.form-label {
    color: #374151;
    font-weight: 600;
    font-size: 14px;
}

.form-label span {
    color: #dc2626;
}

.form-control,
.form-select {
    border: 1px solid #dbe1e8;
    border-radius: 9px;
    padding: 10px 12px;
    font-size: 14px;
}

.form-control:focus,
.form-select:focus {
    border-color: #84CC16;
    box-shadow: 0 0 0 3px rgba(132, 204, 22, 0.12);
}

.field-error {
    color: #dc2626;
    font-size: 12px;
    margin-top: 5px;
    min-height: 17px;
}

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

.logo-preview {
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
    border-radius: 14px;
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.logo-preview i {
    font-size: 40px;
    color: #94a3b8;
}

.logo-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.side-card h5 {
    text-align: center;
    font-weight: 700;
    color: #111827;
}

.side-card > p {
    text-align: center;
    color: #64748b;
    font-size: 13px;
}

.color-field {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 14px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
}

.color-field .form-label {
    margin-bottom: 2px;
}

.color-field small {
    display: block;
    color: #94a3b8;
    font-size: 11px;
}

.color-picker-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}

.color-picker-wrapper input[type="color"] {
    width: 42px;
    height: 42px;
    padding: 3px;
    border: 1px solid #dbe1e8;
    border-radius: 8px;
    cursor: pointer;
    background: #ffffff;
}

.color-picker-wrapper span {
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    min-width: 62px;
}

.preview-colors {
    border-top: 1px solid #e5e7eb;
    margin-top: 20px;
    padding-top: 18px;
}

.preview-colors > div {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    color: #64748b;
    font-size: 13px;
}

.preview-color {
    width: 25px;
    height: 25px;
    border-radius: 6px;
    border: 1px solid #e5e7eb;
}

.info-icon {
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

.side-card h6 {
    font-weight: 700;
    color: #111827;
}

.side-card p {
    color: #64748b;
    font-size: 13px;
    line-height: 1.6;
}

.btn-submit {
    border: none;
    border-radius: 9px;
    padding: 12px 18px;
    background: #84CC16;
    color: #0B1120;
    font-weight: 700;
    transition: 0.2s ease;
}

.btn-submit:hover {
    background: #65A30D;
    color: #ffffff;
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

</style>

@endpush


@push('scripts')

<script>

// const token = localStorage.getItem('api_token');

const instituteForm = document.getElementById('instituteForm');
const logoInput = document.getElementById('logo');
const logoPreview = document.getElementById('logoPreview');

const submitButton = document.getElementById('submitButton');
const submitText = document.getElementById('submitText');
const submitLoading = document.getElementById('submitLoading');


logoInput.addEventListener('change', function () {

    const file = this.files[0];

    if (!file) {
        logoPreview.innerHTML = '<i class="bi bi-building"></i>';
        return;
    }

    const reader = new FileReader();

    reader.onload = function (event) {

        logoPreview.innerHTML = `
            <img src="${event.target.result}" alt="Institute Logo">
        `;

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

        url: '/api/addInstitute',

        type: 'POST',

        headers: {
            'Authorization': 'Bearer ' + token
        },

        data: formData,

        contentType: false,

        processData: false,

        success: function (response) {

            console.log('Institute create response:', response);

            showAlert(
                response.message || 'Institute created successfully.',
                'success'
            );

            instituteForm.reset();

            logoPreview.innerHTML =
                '<i class="bi bi-building"></i>';

            setLoading(false);

        },

        error: function (xhr) {

            console.log('Create Institute Error:', xhr);

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
                    'Something went wrong while creating the institute.',
                    'error'
                );

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

</script>

@endpush