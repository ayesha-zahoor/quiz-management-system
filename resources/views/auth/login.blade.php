
@extends('layouts.auth')
@section('title', 'Sign In | Quiz Management System')
@section('content')

<div class="login-header">

    <div class="login-badge">
        <i class="bi bi-shield-check"></i>
        Secure Access
    </div>

    <h2>Welcome Back</h2>

    <p>
        Sign in to access your quiz management workspace.
    </p>

</div>

<div id="loginAlert" class="login-alert" role="alert">
    <i class="bi bi-exclamation-circle-fill"></i>
    <span id="loginAlertMessage"></span>
</div>

<form id="loginForm" novalidate>

    <div class="form-group">

        <label for="loginIdentity">
            Email or Student ID
        </label>

        <div class="input-wrapper">

            <i class="bi bi-person input-icon"></i>

            <input
                type="text"
                id="loginIdentity"
                name="identity"
                class="form-control custom-input"
                placeholder="Enter email or student ID"
                autocomplete="username"
            >

        </div>

        <div class="field-error" id="identityError"></div>

    </div>


    <div class="form-group">

        <div class="password-label-row">

            <label for="loginPassword">
                Password
            </label>

            <a href="#" class="forgot-link" id="forgotPasswordLink">
                Forgot password?
            </a>

        </div>

        <div class="input-wrapper">

            <i class="bi bi-lock input-icon"></i>

            <input
                type="password"
                id="loginPassword"
                name="password"
                class="form-control custom-input password-input"
                placeholder="Enter your password"
                autocomplete="current-password"
            >

            <button
                type="button"
                class="password-toggle"
                id="passwordToggle"
                aria-label="Show password"
            >
                <i class="bi bi-eye" id="passwordToggleIcon"></i>
            </button>

        </div>

        <div class="field-error" id="passwordError"></div>

    </div>


    <div class="login-options">

        <label class="remember-wrapper">

            <input
                type="checkbox"
                id="rememberMe"
                name="remember"
            >

            <span class="custom-checkbox">
                <i class="bi bi-check"></i>
            </span>

            <span>Remember me</span>

        </label>

    </div>


    <button
        type="submit"
        class="signin-button"
        id="signinButton"
    >

        <span class="button-content" id="buttonContent">
            <i class="bi bi-box-arrow-in-right"></i>
            Sign In
        </span>

        <span class="button-loading" id="buttonLoading">
            <span class="spinner-border spinner-border-sm"></span>
            Signing in...
        </span>

    </button>

</form>


<div class="login-footer">

    <div class="footer-line">
        <span></span>
        <small>Quiz Management System</small>
        <span></span>
    </div>

    <p>
        Voice-enabled quizzes for Classes 1–12
    </p>

</div>


@endsection


@push('styles')

<style>

    .login-header {
        margin-bottom: 32px;
    }

    .login-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 11px;
        margin-bottom: 18px;
        border-radius: 7px;
        background: rgba(132, 204, 22, 0.12);
        color: #65A30D;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .login-badge i {
        font-size: 13px;
    }

    .login-header h2 {
        margin: 0 0 9px;
        color: #0B1120;
        font-size: 34px;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -0.8px;
    }

    .login-header p {
        margin: 0;
        color: #64748B;
        font-size: 14px;
        line-height: 1.6;
    }

    .login-alert {
        display: none;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 14px;
        margin-bottom: 22px;
        border: 1px solid #FECACA;
        border-radius: 9px;
        background: #FEF2F2;
        color: #B91C1C;
        font-size: 13px;
        line-height: 1.5;
    }

    .login-alert.show {
        display: flex;
    }

    .login-alert i {
        margin-top: 2px;
        flex-shrink: 0;
    }

    .form-group {
        margin-bottom: 21px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #111827;
        font-size: 13px;
        font-weight: 700;
    }

    .password-label-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .password-label-row label {
        margin-bottom: 8px;
    }

    .forgot-link {
        margin-bottom: 8px;
        color: #65A30D;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
    }

    .forgot-link:hover {
        color: #4D7C0F;
        text-decoration: underline;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        top: 50%;
        left: 15px;
        z-index: 2;
        color: #94A3B8;
        font-size: 16px;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .custom-input {
        min-height: 50px;
        padding: 12px 44px;
        border: 1px solid #E2E8F0;
        border-radius: 9px;
        background: #FFFFFF;
        color: #111827;
        font-size: 14px;
        box-shadow: none !important;
        transition: border-color 0.18s ease, box-shadow 0.18s ease;
    }

    .custom-input::placeholder {
        color: #94A3B8;
    }

    .custom-input:focus {
        border-color: #84CC16;
        box-shadow: 0 0 0 3px rgba(132, 204, 22, 0.14) !important;
    }

    .custom-input.input-error {
        border-color: #EF4444;
    }

    .custom-input.input-error:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.10) !important;
    }

    .password-input {
        padding-right: 48px;
    }

    .password-toggle {
        position: absolute;
        top: 50%;
        right: 10px;
        width: 35px;
        height: 35px;
        border: 0;
        border-radius: 7px;
        background: transparent;
        color: #64748B;
        transform: translateY(-50%);
        transition: background 0.18s ease, color 0.18s ease;
    }

    .password-toggle:hover {
        background: rgba(132, 204, 22, 0.10);
        color: #65A30D;
    }

    .field-error {
        display: none;
        margin-top: 6px;
        color: #DC2626;
        font-size: 12px;
        line-height: 1.4;
    }

    .field-error.show {
        display: block;
    }

    .login-options {
        display: flex;
        align-items: center;
        margin-top: 2px;
        margin-bottom: 24px;
    }

    .remember-wrapper {
        display: inline-flex !important;
        align-items: center;
        gap: 9px;
        margin: 0 !important;
        color: #64748B !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        cursor: pointer;
        user-select: none;
    }

    .remember-wrapper input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .custom-checkbox {
        width: 18px;
        height: 18px;
        border: 1px solid #CBD5E1;
        border-radius: 5px;
        background: #FFFFFF;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #0B1120;
        font-size: 12px;
        transition: all 0.18s ease;
    }

    .custom-checkbox i {
        display: none;
    }

    .remember-wrapper input:checked + .custom-checkbox {
        border-color: #84CC16;
        background: #84CC16;
    }

    .remember-wrapper input:checked + .custom-checkbox i {
        display: block;
    }

    .signin-button {
        width: 100%;
        min-height: 51px;
        border: 0;
        border-radius: 9px;
        background: #84CC16;
        color: #0B1120;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: 0.1px;
        box-shadow: 0 7px 18px rgba(132, 204, 22, 0.20);
        transition: background 0.18s ease, transform 0.18s ease, box-shadow 0.18s ease;
    }

    .signin-button:hover {
        background: #65A30D;
        color: #FFFFFF;
        transform: translateY(-1px);
        box-shadow: 0 9px 22px rgba(132, 204, 22, 0.26);
    }

    .signin-button:active {
        transform: translateY(0);
    }

    .signin-button:disabled {
        cursor: not-allowed;
        opacity: 0.75;
        transform: none;
    }

    .button-content,
    .button-loading {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .button-loading {
        display: none;
    }

    .signin-button.loading .button-content {
        display: none;
    }

    .signin-button.loading .button-loading {
        display: inline-flex;
    }

    .login-footer {
        margin-top: 42px;
        text-align: center;
    }

    .footer-line {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 9px;
    }

    .footer-line span {
        height: 1px;
        flex: 1;
        background: #E2E8F0;
    }

    .footer-line small {
        color: #94A3B8;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        white-space: nowrap;
    }

    .login-footer p {
        margin: 0;
        color: #94A3B8;
        font-size: 11px;
    }

    @media (max-width: 768px) {

        .login-header h2 {
            font-size: 30px;
        }

        .login-footer {
            margin-top: 32px;
        }

    }

</style>

@endpush


@push('scripts')

<script>

    const loginForm = document.getElementById('loginForm');

    const loginIdentity = document.getElementById('loginIdentity');

    const loginPassword = document.getElementById('loginPassword');

    const passwordToggle = document.getElementById('passwordToggle');

    const passwordToggleIcon = document.getElementById('passwordToggleIcon');

    const signinButton = document.getElementById('signinButton');

    const loginAlert = document.getElementById('loginAlert');

    const loginAlertMessage = document.getElementById('loginAlertMessage');

    const identityError = document.getElementById('identityError');

    const passwordError = document.getElementById('passwordError');

    const forgotPasswordLink = document.getElementById('forgotPasswordLink');


    /*
     * Password visibility
     */

    passwordToggle.addEventListener('click', function () {

        const isPassword = loginPassword.type === 'password';

        loginPassword.type = isPassword ? 'text' : 'password';

        passwordToggleIcon.className = isPassword
            ? 'bi bi-eye-slash'
            : 'bi bi-eye';

        passwordToggle.setAttribute(
            'aria-label',
            isPassword ? 'Hide password' : 'Show password'
        );

    });


    /*
     * Remove individual validation errors while typing
     */

    loginIdentity.addEventListener('input', function () {

        clearFieldError(
            loginIdentity,
            identityError
        );

        hideLoginAlert();

    });


    loginPassword.addEventListener('input', function () {

        clearFieldError(
            loginPassword,
            passwordError
        );

        hideLoginAlert();

    });


    /*
     * Frontend validation
     */

    function validateLoginForm() {

        let valid = true;

        clearFieldError(loginIdentity, identityError);

        clearFieldError(loginPassword, passwordError);

        hideLoginAlert();


        if (loginIdentity.value.trim() === '') {

            showFieldError(
                loginIdentity,
                identityError,
                'Email or Student ID is required.'
            );

            valid = false;

        }


        if (loginPassword.value.trim() === '') {

            showFieldError(
                loginPassword,
                passwordError,
                'Password is required.'
            );

            valid = false;

        }


        return valid;

    }


    function showFieldError(field, errorElement, message) {

        field.classList.add('input-error');

        errorElement.textContent = message;

        errorElement.classList.add('show');

    }


    function clearFieldError(field, errorElement) {

        field.classList.remove('input-error');

        errorElement.textContent = '';

        errorElement.classList.remove('show');

    }


    function showLoginAlert(message) {

        loginAlertMessage.textContent = message;

        loginAlert.classList.add('show');

    }


    function hideLoginAlert() {

        loginAlert.classList.remove('show');

        loginAlertMessage.textContent = '';

    }


    /*
     * Loading state
     */

    function setLoginLoading(loading) {

        if (loading) {

            signinButton.classList.add('loading');

            signinButton.disabled = true;

        } else {

            signinButton.classList.remove('loading');

            signinButton.disabled = false;

        }

    }


    /*
     * Login submission
     *
     * FRONTEND PLACEHOLDER ONLY.
     *
     * Connect this function to your Laravel
     * authentication/API implementation.
     */
      function loginUser(identity, password){
                 $.ajax({
            url:'/api/login',
            type:'Post',
            data:{
                email:identity,
                password:password,
            },
            success:function(response){
                console.log(response);
                const token = response.token;
                const role= response.user.role.role_name;
                console.log(role);
                localStorage.setItem('api_token',token);
                if (role === 'system_admin') {
        window.location.href = '/superAdmin/dashboard';
    }
      else if(role === 'institute_admin') {
        window.location.href = '/instituteAdmin/dashboard';
    }
      },
            error: function(xhr) {

            console.log(xhr);

            setLoginLoading(false);

            showLoginAlert('Login failed.');
            }
        });

            }

    loginForm.addEventListener('submit', function (event) {

        event.preventDefault();

        if (!validateLoginForm()) {
            return;
        }

        const identity = loginIdentity.value.trim();

        const password = loginPassword.value;

        const remember = document.getElementById('rememberMe').checked;


        /*
         * Connect this function to the Laravel API.
         *
         * Do not assume an API URL here.
         *
         * Example integration flow later:
         *
         * 1. Send identity/email + password.
         * 2. Receive authentication response.
         * 3. Determine the authenticated user's role.
         * 4. Redirect to the appropriate role dashboard.
         *
         * The backend determines whether the user is:
         *
         * Super Admin
         * Institute Admin
         * Teacher
         * Student
         */

        console.log('Frontend login placeholder:', {
            identity: identity,
            password: password,
            remember: remember
        });


        setLoginLoading(true);
             loginUser(identity,password);

          
      
    });
       


    forgotPasswordLink.addEventListener('click', function (event) {

        event.preventDefault();

        showLoginAlert(
            'Forgot-password functionality will be connected to your Laravel authentication flow.'
        );

    });

</script>

@endpush