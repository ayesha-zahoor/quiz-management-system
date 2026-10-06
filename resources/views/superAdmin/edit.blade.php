@extends('layouts.app')
@section('user-role', 'Super Admin')
@section('page-title', 'Add Institute')
@section('page-description', 'Create a new institute with its initial administrator and configuration.')

@section('sidebar')
    <a href="/superadmin/dashboard" class="nav-item">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
    </a>

    {{-- <a href="/superadmin/institutes" class="nav-item active">
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

<div class="container-fluid px-0">

    <div id="formAlert" class="alert-box"></div>

    <form id="instituteForm" enctype="multipart/form-data">

        <div class="row g-4">
            {{-- <pre>
    {{ print_r($editInstitute->toArray()) }}
</pre>
<pre>
    {{ print_r($editInstituteConfig->toArray()) }}
</pre>
<pre>
    {{ print_r($admin->toArray()) }}
</pre> --}}
            <div class="col-lg-8">

                <div class="form-section">
                   <input type="hidden" id="instituteId" value="{{ $editInstitute->id }}">
                    <div class="section-header">
                        <div>
                            <h5>Institute Information</h5>
                            <p>Edit information of the institute.</p>
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
                                value="{{ $editInstitute->name }}"
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
                                value="{{ $editInstitute->email}}"
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
                                value="{{$editInstitute->Contact}}"
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
                                value="{{$editInstitute->address}}"
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
                                value="{{ $editInstitute->license_key}}"
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
                                value="{{$editInstitute->license_expires_at}}"
                            >

                            <div id="licenseExpiryError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">
                                Status
                            </label>

                            <select class="form-select" id="status" name="status">
                                <option value="active" selected>{{ $editInstitute->status}}</option>
                                <option value="suspended">Suspended</option>
                                <option value="expired">Expired</option>
                            </select>

                            <div id="statusError" class="field-error"></div>
                        </div>

                        <div class="col-md-6">
                           @if($editInstitute->logo)
    <img src="{{ asset('storage/'.$editInstitute->logo) }}"
         alt="Institute Logo"
         width="100"
         height="100">
@endif
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
                                value="{{$admin->name}}"
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
                                value="{{$admin->email}}"
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
                            @if($admin->profile_image)
  <img src = "{{ asset('storage/'.$admin->profile_image)}}"   width="100"
     height="100"> 
@endif
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
                                        value="{{ $editInstituteConfig->primary_color }}"
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
                                      value="{{ $editInstituteConfig->secondary_color}}"
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
                                     value="{{ $editInstituteConfig->accent_color}}"
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
                                     value="{{ $editInstituteConfig->background_color }}"
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
                                        value="{{ $editInstituteConfig->text_color }}"
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
/* ===== Cards & sections ===== */
.form-section,
.side-card {
    box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
}

.section-header {
    padding-bottom: 16px;
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

/* Sticky right column */
@media (min-width: 992px) {
    .col-lg-4 {
        position: sticky;
        top: 100px;
        align-self: flex-start;
    }
}

/* ===== Inputs ===== */
.form-control,
.form-select {
    background: #fcfdfe;
    transition: border-color .2s, box-shadow .2s, background .2s;
}

.form-control:hover,
.form-select:hover {
    border-color: #c3ccd6;
}

.form-control:focus,
.form-select:focus {
    background: #ffffff;
}

.form-label {
    margin-bottom: 6px;
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
    transition: .2s;
}

input[type="file"].form-control::file-selector-button:hover {
    background: #84CC16;
    color: #0B1120;
}

/* Saved images (logo / admin photo) */
.form-section .col-md-6 > img {
    display: block;
    width: 84px !important;
    height: 84px !important;
    object-fit: cover;
    margin-bottom: 12px;
    padding: 3px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    background: #fff;
}

/* ===== Color pickers ===== */
.color-field {
    background: #fcfdfe;
    transition: border-color .2s, box-shadow .2s;
}

.color-field:hover {
    border-color: #84CC16;
    box-shadow: 0 0 0 3px rgba(132, 204, 22, .10);
}

.color-picker-wrapper span {
    font-family: ui-monospace, Menlo, Consolas, monospace;
    letter-spacing: .3px;
}

/* ===== Preview card ===== */
.side-card:first-child {
    --pv-primary: #84CC16;
    --pv-accent: #F59E0B;
    position: relative;
    overflow: hidden;
    padding-top: 30px;
}

.side-card:first-child::before {
    content: "";
    position: absolute;
    inset: 0 0 auto 0;
    height: 6px;
    background: linear-gradient(90deg, var(--pv-primary), var(--pv-accent));
}

.logo-preview {
    border: 2px dashed #d5dde6;
    background: #fff;
    box-shadow: 0 0 0 4px #f8fafc;
}

.logo-preview img {
    object-fit: contain;
    padding: 6px;
}

#pvSubtitle {
    margin-bottom: 12px;
}

.preview-meta {
    margin-top: 6px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.pv-center {
    text-align: center;
    margin-bottom: 6px;
}

.pv-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    text-transform: capitalize;
}

.pv-active    { background: #ecfccb; color: #4d7c0f; }
.pv-suspended { background: #fef3c7; color: #b45309; }
.pv-expired   { background: #fee2e2; color: #b91c1c; }

.pv-row {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 13px;
    color: #334155;
    word-break: break-word;
}

.pv-row i {
    color: var(--pv-primary);
    margin-top: 2px;
}

.pv-row .pv-empty {
    color: #a0aec0;
    font-style: italic;
}

.preview-color {
    box-shadow: inset 0 0 0 1px rgba(0, 0, 0, .06);
}

/* ===== Setup card ===== */
.setup-list {
    list-style: none;
    margin: 0 0 14px;
    padding: 0;
}

.setup-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #475569;
}

.setup-list li span:nth-child(2) {
    flex: 1;
}

.setup-list em {
    font-style: normal;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 999px;
    background: #f1f5f9;
    color: #64748b;
}

.setup-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    background: #cbd5e1;
}

.setup-list li.edited .setup-dot { background: #F59E0B; }
.setup-list li.edited em { background: #fef3c7; color: #b45309; }

.setup-hint {
    font-size: 12px !important;
    color: #64748b;
}

/* ===== Submit button ===== */
.btn-submit {
    box-shadow: 0 6px 14px rgba(132, 204, 22, .28);
}

.btn-submit:hover {
    transform: translateY(-1px);
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

// console.log(id);

// logoInput.addEventListener('change', function () {

//     // Show the saved logo in the preview (if there is one)
// const savedImg = logoInput.closest('.col-md-6').querySelector('img');
// let savedLogoHtml = '<i class="bi bi-building"></i>';

// if (savedImg && !savedImg.src.endsWith('/storage/')) {
//     savedLogoHtml = '<img src="' + savedImg.src + '" alt="Institute Logo">';
// }

// logoPreview.innerHTML = savedLogoHtml;

// When a new file is chosen, show it. If cleared, show the saved logo again.
logoInput.addEventListener('change', function () {
    const logoInput = document.getElementById('logo');
    console.log(logoInput);
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
                response.message || 'Institute Updated successfully.',
                'success'
            );

            instituteForm.reset();

            logoPreview.innerHTML =
                '<i class="bi bi-building"></i>';

            setLoading(false);
            window.location.href="/superadmin/dashboard";

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