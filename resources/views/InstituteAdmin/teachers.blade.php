@extends('layouts.institute')

@section('title', 'Teacher Management')
@section('user-role', 'Institute Admin')
@section('page-title', 'Teacher Management')
@section('page-description', 'Manage institute teachers and their accounts')

@section('sidebar')
    <a href="/instituteAdmin/dashboard" class="nav-link">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <a href="/instituteAdmin/classes" class="nav-link">
        <i class="bi bi-mortarboard-fill"></i>
        <span>Classes</span>
    </a>

    <a href="/instituteAdmin/subjects" class="nav-link">
        <i class="bi bi-book"></i>
        <span>Subjects</span>
    </a>

    <a href="/instituteAdmin/teachers" class="nav-link active">
        <i class="bi bi-person-badge"></i>
        <span>Teachers</span>
    </a>

    <a href="/instituteAdmin/students" class="nav-link">
        <i class="bi bi-people-fill"></i>
        <span>Students</span>
    </a>
@endsection

@section('content')

<div class="container-fluid px-0">

    {{-- Page heading --}}
    <div class="page-head">
        <div>
            <h4 class="mb-1">Teachers</h4>
            <p class="text-muted mb-0">Manage teachers associated with your institute</p>
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#teacherModal">
            <i class="bi bi-plus-lg me-1"></i>
            Add Teacher
        </button>
    </div>

    {{-- Stat cards --}}
    <div class="row g-3 mb-4">

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <small class="text-muted">Total Teachers</small>
                        <h4 class="mb-0" id="totalTeachers">0</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div>
                        <small class="text-muted">New This Month</small>
                        <h4 class="mb-0" id="newTeachers">0</h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Teacher list --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 px-4 py-3">
            <div class="list-head">
                <div>
                    <h5 class="mb-1">Teacher List</h5>
                    <small class="text-muted" id="teacherCount">Teachers registered in this institute</small>
                </div>

                <div class="input-group search-box">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input
                        type="text"
                        class="form-control"
                        id="teacherSearch"
                        placeholder="Search name, email or phone"
                        autocomplete="off"
                    >
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 teachers-table">

                    <thead>
                        <tr>
                            <th class="col-index ps-4">#</th>
                            <th class="col-teacher">Teacher</th>
                            <th class="col-assigned">Teaches</th>
                            <th class="col-actions text-end pe-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="TableBody">
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-person-badge"></i>
                                    <h6 class="mt-3 mb-1">Loading teachers...</h6>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

    </div>

</div>

{{-- ================= Add teacher modal ================= --}}
<div class="modal fade" id="teacherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Add Teacher</h5>
                    <small class="text-muted">Create a teacher account for your institute</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="teacherForm" novalidate>
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="teacherName" class="form-label">Teacher Name</label>
                            <input type="text" class="form-control" name="name" id="teacherName" placeholder="Enter teacher name" required>
                            <div class="field-error" data-error="name"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="teacherEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="teacherEmail" placeholder="teacher@example.com" required>
                            <div class="field-error" data-error="email"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="teacherPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" id="teacherPassword"
                                   autocomplete="new-password" placeholder="Minimum 8 characters">
                            <div class="field-error" data-error="password"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="teacherPasswordConfirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="teacherPasswordConfirmation"
                                   autocomplete="new-password" placeholder="Confirm password">
                            <div class="field-error" data-error="password_confirmation"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="teacherPhone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="contact" id="teacherPhone" placeholder="Enter phone number">
                            <div class="field-error" data-error="contact"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="addProfile" class="form-label">Profile Image</label>
                            <div class="photo-row">
                                <img id="addPhotoPreview" class="photo-preview" alt="" style="display:none">
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control" id="addProfile" name="profile_image" accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">JPG, PNG or WebP.</small>
                                </div>
                            </div>
                            <div class="field-error" data-error="profile_image"></div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveTeacherBtn">
                        <i class="bi bi-check-lg me-1"></i> Save Teacher
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- ================= Edit teacher modal ================= --}}
<div class="modal fade" id="teacherEditModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Edit Teacher</h5>
                    <small class="text-muted">Update this teacher's account</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="teacherEditForm" autocomplete="off" novalidate>
                <div class="modal-body">
                    <input type="hidden" id="editId">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="editName" class="form-label">Teacher Name</label>
                            <input type="text" class="form-control" name="name" id="editName" required>
                            <div class="field-error" data-error="name"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="editEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="editEmail" autocomplete="off" required>
                            <div class="field-error" data-error="email"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="editPhone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="contact" id="editPhone" placeholder="Enter phone number">
                            <div class="field-error" data-error="contact"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="editPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password" id="editPassword"
                                   autocomplete="new-password" placeholder="Leave blank to keep current">
                            <div class="field-error" data-error="password"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="editPasswordConfirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="editPasswordConfirmation"
                                   autocomplete="new-password" placeholder="Confirm new password">
                            <div class="field-error" data-error="password_confirmation"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="editProfile" class="form-label">Profile Image</label>
                            <div class="photo-row">
                                <img id="teacherImagePreview" class="photo-preview" alt="" style="display:none">
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control" id="editProfile" name="profile_image" accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">JPG, PNG or WebP.</small>
                                </div>
                            </div>
                            <div class="field-error" data-error="profile_image"></div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="updateTeacherBtn">
                        <i class="bi bi-check-lg me-1"></i> Update Teacher
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- ================= Assign class + subject modal ================= --}}
<div class="modal fade" id="teacherAssignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Assign Class and Subject</h5>
                    <small class="text-muted" id="assignTeacherName">Choose what this teacher will teach</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="teacherAssignForm" novalidate>
                <div class="modal-body">
                    <input type="hidden" id="assignTeacherId">

                    <div class="assigned-box">
                        <div class="assigned-title">
                            <span><i class="bi bi-diagram-3 me-1"></i> Currently assigned</span>
                            <span class="count-pill" id="assignedCount">0</span>
                        </div>
                        <div id="assignedList" class="assigned-list">
                            <div class="muted-note">Loading...</div>
                        </div>
                    </div>

                    <div class="assign-new-label">Add a new assignment</div>

                    <div class="row g-3">

                        <div class="col-12">
                            <label for="assignClass" class="form-label">Class</label>
                            <select class="form-select" name="class_id" id="assignClass" required>
                                <option value="">Select Class</option>
                            </select>
                            <div class="field-error" data-error="class_id"></div>
                        </div>

                        <div class="col-12">
                            <label for="assignSubject" class="form-label">Subject</label>
                            <select class="form-select" name="subject_id" id="assignSubject" required>
                                <option value="">Select Subject</option>
                            </select>
                            <div class="field-error" data-error="subject_id"></div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="assignBtn">
                        <i class="bi bi-check-lg me-1"></i> Assign
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- ================= Delete confirmation modal ================= --}}
<div class="modal fade" id="deleteTeacherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-body text-center p-4">

                <div class="delete-icon mb-3">
                    <i class="bi bi-trash"></i>
                </div>

                <h5>Delete Teacher?</h5>

                <p class="text-muted mb-4">
                    <strong id="deleteTeacherName">This teacher</strong> will be removed permanently.
                    This action cannot be undone.
                </p>

                <input type="hidden" id="deleteTeacherId">

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger px-4" id="confirmDeleteTeacher">Delete</button>
                </div>

            </div>

        </div>
    </div>
</div>

{{-- Messages (success / error) --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastBox"></div>

@endsection


@push('styles')
<style>

    /* ---------- Heading rows ---------- */
    .page-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .list-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
    }

    /* ---------- Stat icon ---------- */
    .icon-box {
        width: 45px;
        height: 45px;
        flex: 0 0 45px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* ---------- Search ---------- */
    .search-box { width: 300px; max-width: 100%; }
    .search-box .form-control { border-left: 0; }
    .search-box .input-group-text { border-right: 0; }

    /* ---------- Table ---------- */
    .teachers-table { width: 100%; table-layout: fixed; }

    .teachers-table thead th {
        background: var(--off-white);
        color: var(--slate);
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        padding-top: 12px;
        padding-bottom: 12px;
    }

    .teachers-table tbody td {
        font-size: 14px;
        padding-top: 12px;
        padding-bottom: 12px;
        vertical-align: middle;
    }

    .col-index    { width: 56px; }
    .col-teacher  { width: 38%; }
    .col-assigned { width: auto; }
    .col-actions  { width: 200px; }

    .teachers-table td { overflow-wrap: anywhere; }

    .meta-line { display: flex; flex-wrap: wrap; gap: 2px 14px; margin-top: 4px; font-size: 12px; color: var(--slate); }
    .meta-line i { margin-right: 5px; color: var(--primary-dark); }

    .teacher-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .teacher-cell strong { display: block; overflow-wrap: anywhere; }
    .teacher-cell small { display: block; color: var(--slate); overflow-wrap: anywhere; }

    .teacher-avatar {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        border-radius: 50%;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
        object-fit: cover;
    }

    /* ---------- Row actions ---------- */
    .action-buttons {
        display: inline-flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border: 0;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        line-height: 1.2;
        white-space: nowrap;
        cursor: pointer;
        transition: filter 0.15s ease;
    }

    .action-btn:hover { filter: brightness(0.95); }
    .action-btn.icon { width: 34px; height: 34px; padding: 0; justify-content: center; }

    .edit-btn   { background: var(--primary-light); color: var(--primary-dark); }
    .assign-btn { background: color-mix(in srgb, var(--secondary-color) 12%, white); color: var(--secondary-color); }
    .delete-btn { background: color-mix(in srgb, var(--danger) 10%, white); color: var(--danger); }

    /* ---------- Assigned classes and subjects ---------- */
    .assign-cell { display: flex; flex-wrap: wrap; gap: 6px; }

    .assign-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 999px;
        background: var(--primary-light);
        color: var(--primary-dark);
        font-size: 12px;
        white-space: nowrap;
    }
    .assign-chip b { font-weight: 700; }
    .assign-chip i {
        font-style: normal;
        padding-left: 6px;
        border-left: 1px solid color-mix(in srgb, currentColor 30%, transparent);
    }
    .assign-chip.more { background: var(--off-white); color: var(--slate); cursor: default; }

    .muted-note { color: var(--slate); font-size: 12px; }

    .assigned-box {
        margin-bottom: 18px;
        border: 1px solid var(--slate-light);
        border-radius: 12px;
        background: #fcfdfb;
        overflow: hidden;
    }

    .assigned-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 14px;
        border-bottom: 1px solid var(--slate-light);
        font-size: 13px;
        font-weight: 700;
        color: var(--text-color);
    }

    .count-pill {
        min-width: 26px;
        padding: 2px 9px;
        border-radius: 999px;
        background: var(--primary-light);
        color: var(--primary-dark);
        font-size: 12px;
        font-weight: 700;
        text-align: center;
    }

    .assigned-list { max-height: 220px; overflow-y: auto; padding: 4px 14px; }
    .assigned-list > .muted-note { padding: 12px 0; }

    .assigned-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .assigned-row:last-child { border-bottom: 0; }
    .assigned-row strong { display: block; font-size: 13px; color: var(--text-color); }
    .assigned-row span { display: block; font-size: 12px; color: var(--slate); }

    .unassign-btn {
        flex: 0 0 auto;
        border: 0;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 600;
        background: color-mix(in srgb, var(--danger) 10%, white);
        color: var(--danger);
        transition: background 0.2s ease, color 0.2s ease;
    }
    .unassign-btn:hover,
    .unassign-btn.confirming { background: var(--danger); color: #fff; }

    .assign-new-label { margin-bottom: 10px; font-size: 13px; font-weight: 700; color: var(--text-color); }

    /* ---------- Empty state ---------- */
    .empty-state { color: var(--slate); }
    .empty-state i { font-size: 42px; color: var(--primary-dark); }

    /* ---------- Forms ---------- */
    .field-error { color: var(--danger); font-size: 12px; margin-top: 4px; }
    .field-error:empty { display: none; }

    .photo-row { display: flex; align-items: center; gap: 14px; }

    .photo-preview {
        width: 64px;
        height: 64px;
        flex: 0 0 64px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }

    /* ---------- Delete modal ---------- */
    .delete-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background: color-mix(in srgb, var(--danger) 12%, white);
        color: var(--danger);
        font-size: 25px;
    }

    /* ---------- Messages ---------- */
    .toast-container { z-index: 2000; }

    .notice-toast {
        border: 0;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.18);
        min-width: 300px;
    }

    .notice-toast .toast-body {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 14px;
        white-space: pre-line;
    }

    .notice-toast.success { background: #dcfce7; color: #15803d; }
    .notice-toast.error   { background: #fee2e2; color: #b91c1c; }

    @media (max-width: 991.98px) {
        .teachers-table { table-layout: auto; }
        .teachers-table thead { display: none; }

        .teachers-table,
        .teachers-table tbody,
        .teachers-table tr,
        .teachers-table td { display: block; width: 100%; }

        .teachers-table tbody tr { padding: 14px 18px; border-bottom: 1px solid var(--slate-light); }
        .teachers-table tbody tr:last-child { border-bottom: 0; }
        .teachers-table tbody td { padding: 6px 0 !important; border: 0; text-align: left !important; }
        .teachers-table td.cell-index { display: none; }

        .teachers-table td[data-label]::before {
            content: attr(data-label);
            display: block;
            margin-bottom: 4px;
            color: var(--slate);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }

        .teachers-table td.cell-actions { padding-top: 10px !important; }
        .teachers-table td.cell-actions .action-buttons { justify-content: flex-start; }
    }

    @media (max-width: 768px) {
        .search-box { width: 100%; }
        .list-head { flex-direction: column; align-items: stretch; }
        .page-head .btn { width: 100%; }
    }

</style>
@endpush


@push('scripts')
<script>
    // Adjust these two URLs to match your routes
    const SUBJECTS_URL = '/api/subjects';
    // route: teachers/{teacher}/classes
    const ASSIGN_URL   = id => '/api/teachers/' + encodeURIComponent(id) + '/classes';

    let allTeachers = [];
    let editSavedPhoto = '';   // the teacher's current photo URL while the edit window is open

    // ---------- Helpers ----------
    function esc(value) {
        return $('<div>').text(value ?? '').html();
    }

    function initials(name) {
        return (name || '?').trim().split(/\s+/).map(word => word[0]).slice(0, 2).join('').toUpperCase();
    }

    function formatDate(value) {
        if (!value) return '—';
        const date = new Date(value);
        return Number.isNaN(date.getTime())
            ? '—'
            : date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
    }

    function authHeaders() {
        return {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        };
    }

    // Handles every shape the API uses: [..], { data: [..] } and { data: { data: [..] } }
    function responseItems(response) {
        if (Array.isArray(response)) return response;
        if (Array.isArray(response?.data)) return response.data;
        if (Array.isArray(response?.data?.data)) return response.data.data;
        return [];
    }

    function getErrorMessage(xhr, fallback) {
        const response = xhr.responseJSON;
        if (response?.errors) {
            return Object.values(response.errors).flat().join('\n');
        }
        return response?.message || fallback;
    }

    // Success / error message: uses your layout's showResultModal if it exists, otherwise a toast
    function showNotice(type, message) {
        if (typeof showResultModal === 'function') {
            showResultModal(type, type === 'success' ? 'Success' : 'Request Failed', message);
            return;
        }

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

        const toast = new bootstrap.Toast(el[0], { delay: 4000 });
        el.on('hidden.bs.toast', () => el.remove());
        toast.show();
    }

    // Inline field errors (scoped to one form)
    function clearFieldErrors(form) {
        $(form).find('.field-error').text('');
        $(form).find('.is-invalid').removeClass('is-invalid');
    }

    function setFieldError(form, field, message) {
        $(form).find('[data-error="' + field + '"]').text(message);
        $(form).find('[name="' + field + '"]').addClass('is-invalid');
    }

    function showServerErrors(form, xhr, fallback) {
        if (xhr.status === 422 && xhr.responseJSON?.errors) {
            Object.entries(xhr.responseJSON.errors).forEach(function ([field, messages]) {
                setFieldError(form, field, messages[0]);
            });
            showNotice('error', 'Please fix the highlighted fields and try again.');
            return;
        }

        showNotice('error', getErrorMessage(xhr, fallback));
    }

    function setBusy(button, busy, busyText, normalHtml) {
        button.prop('disabled', busy);
        button.html(busy
            ? `<span class="spinner-border spinner-border-sm me-2"></span>${busyText}`
            : normalHtml);
    }

    const SAVE_HTML   = '<i class="bi bi-check-lg me-1"></i> Save Teacher';
    const UPDATE_HTML = '<i class="bi bi-check-lg me-1"></i> Update Teacher';
    const ASSIGN_HTML = '<i class="bi bi-check-lg me-1"></i> Assign';

    // ---------- Assigned classes and subjects ----------
    let subjectsById = {};
    let assignmentsByTeacher = {};          // teacherId -> [{ classId, className, subjectId }]
    const subjectsReady = $.Deferred();     // resolved once the subject names are known
    const REMOVE_HTML = '<i class="bi bi-x-lg"></i> Remove';

    function escAttr(value) {
        return esc(value).replace(/"/g, '&quot;');
    }

    function subjectName(id) {
        return subjectsById[id] || ('Subject #' + id);
    }

    // Each class comes back with the subject in pivot.subject_id
    function normalizeAssignments(response) {
        return responseItems(response).map(item => ({
            classId: item.id,
            className: item.class_name || item.name || 'Class',
            subjectId: item.pivot?.subject_id
        }));
    }

    function assignmentCellHtml(teacherId) {
        const list = assignmentsByTeacher[teacherId];

        if (list === undefined) return '<span class="muted-note">Loading...</span>';
        if (list === null) return '<span class="muted-note">Unavailable</span>';
        if (!list.length) return '<span class="muted-note">Not assigned yet</span>';

        const shown = list.slice(0, 3).map(a =>
            `<span class="assign-chip"><b>${esc(a.className)}</b><i>${esc(subjectName(a.subjectId))}</i></span>`
        ).join('');

        const hidden = list.slice(3);
        const more = hidden.length
            ? `<span class="assign-chip more" title="${escAttr(hidden.map(a => a.className + ' · ' + subjectName(a.subjectId)).join(', '))}">+${hidden.length} more</span>`
            : '';

        return shown + more;
    }

    function refreshAssignCell(teacherId) {
        $('#assignCell-' + teacherId).html(assignmentCellHtml(teacherId));
    }

    function fetchAssignments(teacherId) {
        return $.ajax({ url: ASSIGN_URL(teacherId), type: 'GET', headers: authHeaders() });
    }

    // Fills the "Teaches" column, one request per teacher; each row updates as its answer arrives
    function loadAllAssignments() {
        subjectsReady.always(function () {
            allTeachers.forEach(function (teacher) {
                fetchAssignments(teacher.id)
                    .done(response => { assignmentsByTeacher[teacher.id] = normalizeAssignments(response); })
                    .fail(() => { assignmentsByTeacher[teacher.id] = null; })
                    .always(() => refreshAssignCell(teacher.id));
            });
        });
    }

    // The list inside the Assign window
    function renderAssignedList(teacherId) {
        if (String($('#assignTeacherId').val()) !== String(teacherId)) return;   // window moved on to another teacher

        const list = assignmentsByTeacher[teacherId];
        $('#assignedCount').text(Array.isArray(list) ? list.length : 0);

        if (list === null) {
            $('#assignedList').html('<div class="muted-note">Couldn\'t load the current assignments.</div>');
            return;
        }

        if (!list || !list.length) {
            $('#assignedList').html('<div class="muted-note">This teacher has no classes or subjects yet.</div>');
            return;
        }

        $('#assignedList').html(list.map(a => `
            <div class="assigned-row">
                <div>
                    <strong>${esc(a.className)}</strong>
                    <span>${esc(subjectName(a.subjectId))}</span>
                </div>
                <button type="button" class="unassign-btn" data-class="${a.classId}" data-subject="${a.subjectId}">${REMOVE_HTML}</button>
            </div>`).join(''));
    }

    function loadAssignedFor(teacherId) {
        fetchAssignments(teacherId)
            .done(response => { assignmentsByTeacher[teacherId] = normalizeAssignments(response); })
            .fail(() => { assignmentsByTeacher[teacherId] = null; })
            .always(() => {
                renderAssignedList(teacherId);
                refreshAssignCell(teacherId);
            });
    }

    // ---------- List ----------
    function messageRow(icon, title, message) {
        return `
            <tr>
                <td colspan="4" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi ${icon}"></i>
                        <h6 class="mt-3 mb-1">${esc(title)}</h6>
                        <p class="text-muted mb-0">${esc(message)}</p>
                    </div>
                </td>
            </tr>`;
    }

    function renderTeachers(list) {
        if (!allTeachers.length) {
            $('#TableBody').html(messageRow('bi-person-badge', 'No teachers found', 'Add a teacher to begin managing your teaching staff.'));
            return;
        }

        if (!list.length) {
            $('#TableBody').html(messageRow('bi-search', 'No matching teachers', 'Try a different name, email or phone number.'));
            return;
        }

        let rows = '';

        list.forEach(function (teacher, index) {
            const photo = teacher.profile_image
                ? `<img src="/storage/${esc(teacher.profile_image)}" class="teacher-avatar" alt="">`
                : `<div class="teacher-avatar">${esc(initials(teacher.name))}</div>`;

            const phone = teacher.contact ?? teacher.phone;

            rows += `
                <tr>
                    <td class="ps-4 text-muted cell-index">${index + 1}</td>

                    <td data-label="Teacher">
                        <div class="teacher-cell">
                            ${photo}
                            <div>
                                <strong>${esc(teacher.name)}</strong>
                                <small>${esc(teacher.email)}</small>
                                <div class="meta-line">
                                    ${phone ? `<span><i class="bi bi-telephone"></i>${esc(phone)}</span>` : ''}
                                    <span><i class="bi bi-calendar3"></i>Joined ${formatDate(teacher.created_at)}</span>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td data-label="Teaches">
                        <div class="assign-cell" id="assignCell-${teacher.id}">${assignmentCellHtml(teacher.id)}</div>
                    </td>

                    <td class="text-end pe-4 cell-actions">
                        <div class="action-buttons">
                            <button type="button" class="action-btn icon edit-btn" data-id="${teacher.id}"
                                data-bs-toggle="modal" data-bs-target="#teacherEditModal"
                                title="Edit teacher" aria-label="Edit teacher">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" class="action-btn assign-btn" data-id="${teacher.id}"
                                data-bs-toggle="modal" data-bs-target="#teacherAssignModal">
                                <i class="bi bi-diagram-3"></i> Assign
                            </button>
                            <button type="button" class="action-btn icon delete-btn" data-id="${teacher.id}"
                                data-bs-toggle="modal" data-bs-target="#deleteTeacherModal"
                                title="Delete teacher" aria-label="Delete teacher">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;
        });

        $('#TableBody').html(rows);
    }

    function applySearch() {
        const query = ($('#teacherSearch').val() || '').trim().toLowerCase();

        const filtered = !query ? allTeachers : allTeachers.filter(function (teacher) {
            return [teacher.name, teacher.email, teacher.contact, teacher.phone]
                .join(' ').toLowerCase().includes(query);
        });

        $('#teacherCount').text(query
            ? `Showing ${filtered.length} of ${allTeachers.length} teachers`
            : 'Teachers registered in this institute');

        renderTeachers(filtered);
    }

    function updateStats() {
        const monthStart = new Date();
        monthStart.setDate(1);
        monthStart.setHours(0, 0, 0, 0);

        const added = allTeachers.filter(t => t.created_at && new Date(t.created_at) >= monthStart).length;

        $('#totalTeachers').text(allTeachers.length);
        $('#newTeachers').text(added);
    }

    function loadTeachers() {
        $.ajax({
            url: '/api/teachers',
            type: 'GET',
            headers: authHeaders(),
            success: function (response) {
                allTeachers = responseItems(response);
                updateStats();
                applySearch();
                loadAllAssignments();
            },
            error: function (xhr) {
                $('#TableBody').html(messageRow(
                    'bi-exclamation-circle',
                    "Couldn't load teachers",
                    getErrorMessage(xhr, 'Refresh the page or sign in again and try once more.')
                ));
            }
        });
    }

    $('#teacherSearch').on('input', applySearch);

    // ---------- Profile photo: check the file, then preview it ----------
    const ALLOWED_PHOTO_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
    const MAX_PHOTO_BYTES = 2 * 1024 * 1024;

    function photoProblem(file) {
        if (!file) return '';
        if (!ALLOWED_PHOTO_TYPES.includes(file.type)) return 'Please choose a JPG, PNG or WebP image.';
        if (file.size > MAX_PHOTO_BYTES) return 'The image must be 2 MB or smaller.';
        return '';
    }

    function bindPhotoPreview(inputSelector, imgSelector, savedUrl) {
        $(inputSelector).on('change', function () {
            const form = this.form;
            const file = this.files[0];
            const problem = photoProblem(file);

            $(form).find('[data-error="profile_image"]').text('');
            $(this).removeClass('is-invalid');

            if (problem) {
                this.value = '';
                setFieldError(form, 'profile_image', problem);
            }

            if (!problem && file) {
                $(imgSelector).attr('src', URL.createObjectURL(file)).show();
                return;
            }

            // No (valid) new file: show the saved photo again, or nothing
            const saved = savedUrl();
            saved ? $(imgSelector).attr('src', saved).show() : $(imgSelector).hide().attr('src', '');
        });
    }

    bindPhotoPreview('#addProfile', '#addPhotoPreview', () => '');
    bindPhotoPreview('#editProfile', '#teacherImagePreview', () => editSavedPhoto);

    // ---------- Add ----------
    $('#teacherModal').on('show.bs.modal', function () {
        $('#teacherForm')[0].reset();
        clearFieldErrors('#teacherForm');
        $('#addPhotoPreview').hide().attr('src', '');
        setBusy($('#saveTeacherBtn'), false, '', SAVE_HTML);
    });

    $('#teacherForm').on('submit', function (event) {
        event.preventDefault();
        clearFieldErrors(this);

        const password = $('#teacherPassword').val();
        const confirmation = $('#teacherPasswordConfirmation').val();
        let invalid = false;

        if (!password) {
            setFieldError(this, 'password', 'Please enter a password for the new teacher.');
            invalid = true;
        }

        if (password !== confirmation) {
            setFieldError(this, 'password_confirmation', 'Passwords do not match.');
            invalid = true;
        }

        if (invalid) return;

        const form = this;
        const button = $('#saveTeacherBtn');
        setBusy(button, true, 'Saving...', SAVE_HTML);

        $.ajax({
            url: '/api/teachers',
            type: 'POST',
            headers: authHeaders(),
            data: new FormData(form),
            processData: false,
            contentType: false,
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('teacherModal')).hide();
                loadTeachers();
                showNotice('success', response.message || 'Teacher added successfully.');
            },
            error: function (xhr) {
                showServerErrors(form, xhr, 'Unable to add the teacher. Please try again.');
            },
            complete: function () {
                setBusy(button, false, '', SAVE_HTML);
            }
        });
    });

    // ---------- Edit ----------
    $('#teacherEditModal').on('show.bs.modal', function (event) {
        const trigger = event.relatedTarget ? $(event.relatedTarget).closest('.edit-btn') : $();

        $('#teacherEditForm')[0].reset();
        clearFieldErrors('#teacherEditForm');
        editSavedPhoto = '';
        $('#teacherImagePreview').hide().attr('src', '');
        setBusy($('#updateTeacherBtn'), false, '', UPDATE_HTML);

        if (!trigger.length) return;

        const teacher = allTeachers.find(item => String(item.id) === String(trigger.data('id')));

        if (!teacher) {
            showNotice('error', 'Teacher details could not be found. Refresh the page and try again.');
            return;
        }

        $('#editId').val(teacher.id);
        $('#editName').val(teacher.name || '');
        $('#editEmail').val(teacher.email || '');
        $('#editPhone').val(teacher.contact ?? teacher.phone ?? '');

        if (teacher.profile_image) {
            editSavedPhoto = '/storage/' + teacher.profile_image;
            $('#teacherImagePreview').attr('src', editSavedPhoto).show();
        }
    });

    $('#teacherEditForm').on('submit', function (event) {
        event.preventDefault();
        clearFieldErrors(this);

        const teacherId = $('#editId').val();

        if (!teacherId) {
            showNotice('error', 'Missing teacher. Close the form and click Edit again.');
            return;
        }

        const password = $('#editPassword').val();
        const confirmation = $('#editPasswordConfirmation').val();

        if (password && password !== confirmation) {
            setFieldError(this, 'password_confirmation', 'Passwords do not match.');
            return;
        }

        const form = this;
        const formData = new FormData(form);
        formData.append('_method', 'PUT');

        // Blank password = keep the current one
        if (!password) {
            formData.delete('password');
            formData.delete('password_confirmation');
        }

        const button = $('#updateTeacherBtn');
        setBusy(button, true, 'Updating...', UPDATE_HTML);

        $.ajax({
            url: '/api/teachers/' + encodeURIComponent(teacherId),
            type: 'POST',
            headers: authHeaders(),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('teacherEditModal')).hide();
                loadTeachers();
                showNotice('success', response.message || 'Teacher updated successfully.');
            },
            error: function (xhr) {
                showServerErrors(form, xhr, 'Unable to update the teacher. Please try again.');
            },
            complete: function () {
                setBusy(button, false, '', UPDATE_HTML);
            }
        });
    });

    // ---------- Assign class + subject ----------
    function fillSelect(selector, placeholder, items, nameKeys) {
        let options = `<option value="">${placeholder}</option>`;

        items.forEach(function (item) {
            const name = nameKeys.map(key => item[key]).find(Boolean) || 'Untitled';
            options += `<option value="${item.id}">${esc(name)}</option>`;
        });

        $(selector).html(options);
    }

    function loadAssignOptions() {
        $.ajax({
            url: '/api/classes',
            type: 'GET',
            headers: authHeaders(),
            success: function (response) {
                fillSelect('#assignClass', 'Select Class', responseItems(response), ['class_name', 'name']);
            },
            error: function (xhr) {
                showNotice('error', getErrorMessage(xhr, 'Unable to load classes.'));
            }
        });

        $.ajax({
            url: SUBJECTS_URL,
            type: 'GET',
            headers: authHeaders(),
            success: function (response) {
                const subjects = responseItems(response);

                subjectsById = {};
                subjects.forEach(s => { subjectsById[s.id] = s.subject_name || s.name; });

                fillSelect('#assignSubject', 'Select Subject', subjects, ['subject_name', 'name']);
            },
            error: function (xhr) {
                showNotice('error', getErrorMessage(xhr, 'Unable to load subjects.'));
            },
            complete: function () {
                subjectsReady.resolve();
            }
        });
    }

    $('#teacherAssignModal').on('show.bs.modal', function (event) {
        const trigger = event.relatedTarget ? $(event.relatedTarget).closest('.assign-btn') : $();
        const teacher = allTeachers.find(item => String(item.id) === String(trigger.data('id')));

        $('#teacherAssignForm')[0].reset();
        clearFieldErrors('#teacherAssignForm');
        setBusy($('#assignBtn'), false, '', ASSIGN_HTML);

        $('#assignTeacherId').val(teacher ? teacher.id : '');
        $('#assignTeacherName').text(teacher ? 'Teacher: ' + teacher.name : 'Choose what this teacher will teach');

        // Show what is already assigned, fetched fresh
        $('#assignedCount').text(0);
        $('#assignedList').html('<div class="muted-note">Loading...</div>');

        if (teacher) {
            subjectsReady.always(() => loadAssignedFor(teacher.id));
        }
    });

    $('#teacherAssignForm').on('submit', function (event) {
        event.preventDefault();
        clearFieldErrors(this);

        const teacherId = $('#assignTeacherId').val();

        if (!teacherId) {
            showNotice('error', 'Missing teacher. Close the form and click Assign again.');
            return;
        }

        let invalid = false;

        if (!$('#assignClass').val()) {
            setFieldError(this, 'class_id', 'Please choose a class.');
            invalid = true;
        }

        if (!$('#assignSubject').val()) {
            setFieldError(this, 'subject_id', 'Please choose a subject.');
            invalid = true;
        }

        if (invalid) return;

        const alreadyAssigned = (assignmentsByTeacher[teacherId] || []).some(a =>
            String(a.classId) === String($('#assignClass').val()) &&
            String(a.subjectId) === String($('#assignSubject').val())
        );

        if (alreadyAssigned) {
            setFieldError(this, 'subject_id', 'This teacher already teaches this subject in that class.');
            return;
        }

        const form = this;
        const button = $('#assignBtn');
        setBusy(button, true, 'Assigning...', ASSIGN_HTML);

        $.ajax({
            url: ASSIGN_URL(teacherId),
            type: 'POST',
            headers: authHeaders(),
            data: {
                class_id: $('#assignClass').val(),
                subject_id: $('#assignSubject').val()
            },
            success: function (response) {
                // Keep the window open so several assignments can be added, and show the updated list
                $('#assignClass, #assignSubject').val('');
                loadAssignedFor(teacherId);
                showNotice('success', response.message || 'Class and subject assigned successfully.');
            },
            error: function (xhr) {
                showServerErrors(form, xhr, 'Unable to assign the class and subject. Please try again.');
            },
            complete: function () {
                setBusy(button, false, '', ASSIGN_HTML);
            }
        });
    });

    // ---------- Remove an assignment (asks to confirm first) ----------
    // Needs: Route::delete('teachers/{teacher}/classes/{class}', [TeacherClassController::class, 'destroy']);
    $(document).on('click', '.unassign-btn', function () {
        const button = $(this);

        if (!button.hasClass('confirming')) {
            button.addClass('confirming').text('Sure?');
            button.data('timer', setTimeout(() => button.removeClass('confirming').html(REMOVE_HTML), 3000));
            return;
        }

        clearTimeout(button.data('timer'));

        const teacherId = $('#assignTeacherId').val();
        button.prop('disabled', true).text('Removing...');

        $.ajax({
            url: ASSIGN_URL(teacherId) + '/' + encodeURIComponent(button.data('class')),
            type: 'POST',
            headers: authHeaders(),
            data: { _method: 'DELETE', subject_id: button.data('subject') },
            success: function (response) {
                showNotice('success', response.message || 'Assignment removed successfully.');
                loadAssignedFor(teacherId);
            },
            error: function (xhr) {
                button.prop('disabled', false).removeClass('confirming').html(REMOVE_HTML);
                showNotice('error', getErrorMessage(xhr, 'Unable to remove the assignment. Please try again.'));
            }
        });
    });

    // ---------- Delete (always asks first) ----------
    $('#deleteTeacherModal').on('show.bs.modal', function (event) {
        const trigger = $(event.relatedTarget).closest('.delete-btn');
        const teacher = allTeachers.find(item => String(item.id) === String(trigger.data('id')));

        $('#deleteTeacherId').val(trigger.data('id') || '');
        $('#deleteTeacherName').text(teacher ? teacher.name : 'This teacher');
    });

    $('#confirmDeleteTeacher').on('click', function () {
        const teacherId = $('#deleteTeacherId').val();

        if (!teacherId) {
            showNotice('error', 'Missing teacher. Close this window and try again.');
            return;
        }

        const button = $(this).prop('disabled', true).text('Deleting...');

        $.ajax({
            url: '/api/teachers/' + encodeURIComponent(teacherId),
            type: 'DELETE',
            headers: authHeaders(),
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteTeacherModal')).hide();
                loadTeachers();
                showNotice('success', response.message || 'Teacher deleted successfully.');
            },
            error: function (xhr) {
                showNotice('error', getErrorMessage(xhr, 'Unable to delete the teacher. Please try again.'));
            },
            complete: function () {
                button.prop('disabled', false).text('Delete');
                $('#deleteTeacherId').val('');
            }
        });
    });

    $(document).ready(function () {
        loadTeachers();
        loadAssignOptions();
    });
</script>
@endpush