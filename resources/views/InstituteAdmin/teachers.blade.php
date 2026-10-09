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
    <i class="bi bi-building"></i>
    <span>Class Management</span>
</a>

<a href="/instituteAdmin/subjects" class="nav-link">
    <i class="bi bi-book"></i>
    <span>Subject Management</span>
</a>

<a href="/instituteAdmin/teachers" class="nav-link active">
    <i class="bi bi-person-badge"></i>
    <span>Teacher Management</span>
</a>

<a href="#" class="nav-link">
    <i class="bi bi-people"></i>
    <span>Student Management</span>
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

        <div class="col-md-4">
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

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div>
                        <small class="text-muted">Active Teachers</small>
                        <h4 class="mb-0" id="activeTeachers">0</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3">
                        <i class="bi bi-person-x"></i>
                    </div>
                    <div>
                        <small class="text-muted">Inactive Teachers</small>
                        <h4 class="mb-0" id="inactiveTeachers">0</h4>
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
                        placeholder="Search teachers..."
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
                            <th class="col-email">Email</th>
                            <th class="col-status">Status</th>
                            <th class="col-joined">Joined</th>
                            <th class="col-actions text-end pe-4">Actions</th>
                        </tr>
                    </thead>

                    <tbody id="TableBody">
                        <tr>
                            <td colspan="6" class="text-center py-5">
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

<!-- Add/Edit Teacher Modal -->
<div class="modal fade" id="teacherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="teacherModalTitle">Add Teacher</h5>
                    <small class="text-muted">Create a teacher account for your institute</small>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="teacherForm">

                <div class="modal-body">

                    <input type="hidden" id="editTeacherId">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="teacherName" class="form-label">Teacher Name</label>
                            <input type="text" class="form-control" name="name" id="teacherName" placeholder="Enter teacher name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="teacherEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email"  id="teacherEmail" placeholder="teacher@example.com" required>
                        </div>

                        <div class="col-md-6" id="passwordField">
                            <label for="teacherPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password"  id="teacherPassword" placeholder="Enter password">
                        </div>

                        <div class="col-md-6" id="confirmPasswordField">
                            <label for="teacherPasswordConfirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="teacherPasswordConfirmation" placeholder="Confirm password">
                        </div>

                        <!-- <div class="col-md-6">
                            <label for="teacherStatus" class="form-label">Status</label>
                            <select class="form-select" id="teacherStatus">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div> -->

                        <div class="col-md-6">
                            <label for="teacherPhone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="contact"  id="teacherPhone" placeholder="Enter phone number">
                        </div>

                          <div class="col-md-6">
                        <label for="admin_profile_image" class="form-label">profile image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image" accept=".jpg,.jpeg,.png,.webp">
                        <div class="field-hint">JPG, PNG or WebP.</div>
                        <div id="adminProfileImageError" class="field-error"></div>
                    </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>
                        Save Teacher
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- edit form -->
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

            <form id="Form" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" id="editId">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="editName" class="form-label">Teacher Name</label>
                            <input type="text" class="form-control" name="name" id="editName" required>
                        </div>

                        <div class="col-md-6">
                            <label for="editEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="editEmail" autocomplete="off" required>
                        </div>

                        <div class="col-md-6">
                            <label for="editPhone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" name="contact" id="editPhone" placeholder="Enter phone number">
                        </div>

                        <div class="col-md-6">
                            <label for="editPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" name="password" id="editPassword"
                                   autocomplete="new-password" placeholder="Leave blank to keep current">
                        </div>

                        <div class="col-md-6">
                            <label for="editPasswordConfirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="editPasswordConfirmation"
                                   autocomplete="new-password" placeholder="Confirm new password">
                        </div>

                        <div class="col-md-6">
                            <label for="editProfile" class="form-label">Profile image</label>
                            <input type="file" class="form-control" id="editProfile" name="profile_image" accept=".jpg,.jpeg,.png,.webp">
                            <img src="" id="teacherImagePreview" class="edit-preview" alt="" style="display:none">
                            <div class="field-hint">JPG, PNG or WebP.</div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Update Teacher
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteTeacherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-body text-center p-4">

                <div class="delete-icon mb-3">
                    <i class="bi bi-trash"></i>
                </div>

                <h5>Delete Teacher?</h5>

                <p class="text-muted mb-4">
                    Are you sure you want to delete this teacher?
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

@endsection


@push('styles')
<style>

    /* ---------- Heading rows ---------- */
    .edit-preview { width: 72px; height: 72px; object-fit: cover; border-radius: 50%; margin-top: 10px; border: 1px solid #e2e8f0; }
img.teacher-avatar { object-fit: cover; }
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
        background: rgba(132, 204, 22, 0.12);
        color: #65a30d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    /* ---------- Search ---------- */
    .search-box {
        width: 280px;
        max-width: 100%;
    }

    .search-box .form-control { border-left: 0; }
    .search-box .input-group-text { border-right: 0; }

    /* ---------- Table ---------- */
    .teachers-table { min-width: 760px; }

    .teachers-table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        padding-top: 12px;
        padding-bottom: 12px;
    }

    .teachers-table tbody td {
        font-size: 14px;
        padding-top: 14px;
        padding-bottom: 14px;
        vertical-align: middle;
    }

    /* Column widths so header and cells always line up */
    .col-index   { width: 64px; }
    .col-teacher { width: 28%; }
    .col-email   { width: 26%; }
    .col-status  { width: 120px; }
    .col-joined  { width: 140px; }
    .col-actions { width: 200px; }

    .teachers-table td.cell-email,
    .teachers-table td.cell-joined { white-space: nowrap; }
    .teachers-table td.cell-email { overflow: hidden; text-overflow: ellipsis; max-width: 0; }

    .teacher-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .teacher-avatar {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        border-radius: 50%;
        background: #ecfccb;
        color: #4d7c0f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
    }

    .teacher-cell strong {
        display: block;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ---------- Status badges ---------- */
    .badge-active,
    .badge-inactive {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        text-transform: capitalize;
    }

    .badge-active   { background: #dcfce7; color: #15803d; }
    .badge-inactive { background: #f1f5f9; color: #64748b; }

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
        cursor: pointer;
        transition: filter 0.15s ease;
    }

    .action-btn:hover { filter: brightness(0.95); }

    .edit-btn   { background: #ecfccb; color: #4d7c0f; }
    .delete-btn { background: #fee2e2; color: #dc2626; }

    /* ---------- Empty state ---------- */
    .empty-state { color: #64748b; }
    .empty-state i { font-size: 42px; color: #94a3b8; }

    /* ---------- Delete modal ---------- */
    .delete-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fee2e2;
        color: #dc2626;
        font-size: 25px;
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
    let allTeachers = [];

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

    function showNotice(type, message) {
        if (typeof showResultModal === 'function') {
            showResultModal(type, type === 'success' ? 'Success' : 'Request Failed', message);
        } else {
            alert(message);
        }
    }

    function getErrorMessage(xhr, fallback) {
        const response = xhr.responseJSON;
        if (response?.errors) {
            return Object.values(response.errors).flat().join('\n');
        }
        return response?.message || fallback;
    }

    function messageRow(icon, title, message) {
        return `
            <tr>
                <td colspan="6" class="text-center py-5">
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
            $('#TableBody').html(messageRow('bi-search', 'No matching teachers', 'Try a different name or email.'));
            return;
        }

        let rows = '';

        list.forEach(function (teacher, index) {
            const status = (teacher.status || 'active').toLowerCase();
            const statusClass = status === 'inactive' ? 'badge-inactive' : 'badge-active';
            const profile = teacher.profile_image
                ? `<img src="/storage/${esc(teacher.profile_image)}" class="teacher-avatar" alt="${esc(teacher.name)}">`
                : `<div class="teacher-avatar">${esc(initials(teacher.name))}</div>`;

            rows += `
                <tr>
                    <td class="ps-4 text-muted">${index + 1}</td>
                    <td>
                        <div class="teacher-cell">
                            ${profile}
                            <strong>${esc(teacher.name)}</strong>
                        </div>
                    </td>
                    <td class="cell-email" title="${esc(teacher.email)}">${esc(teacher.email)}</td>
                    <td><span class="${statusClass}">${esc(status)}</span></td>
                    <td class="cell-joined">${formatDate(teacher.created_at)}</td>
                    <td class="text-end pe-4">
                        <div class="action-buttons">
                            <button type="button" class="action-btn edit-btn" data-id="${teacher.id}" data-bs-toggle="modal" data-bs-target="#teacherEditModal">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button type="button" class="action-btn delete-btn" data-id="${teacher.id}" data-bs-toggle="modal" data-bs-target="#deleteTeacherModal">
                                <i class="bi bi-trash"></i> Delete
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
            return [
                teacher.name,
                teacher.email,
                teacher.contact,
                teacher.phone,
                teacher.status
            ].join(' ').toLowerCase().includes(query);
        });

        $('#teacherCount').text(query
            ? `Showing ${filtered.length} of ${allTeachers.length} teachers`
            : 'Teachers registered in this institute');

        renderTeachers(filtered);
    }

    function updateStats() {
        const inactive = allTeachers.filter(teacher => (teacher.status || 'active').toLowerCase() === 'inactive').length;
        $('#totalTeachers').text(allTeachers.length);
        $('#activeTeachers').text(allTeachers.length - inactive);
        $('#inactiveTeachers').text(inactive);
    }

    function loadTeachers() {
        $.ajax({
            url: '/api/teachers',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function (response) {
                const payload = response.data;
                allTeachers = Array.isArray(payload)
                    ? payload
                    : (Array.isArray(payload?.data) ? payload.data : []);

                updateStats();
                applySearch();
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

    function resetCreateForm() {
        $('#teacherForm')[0].reset();
        $('#editTeacherId').val('');
        $('#teacherPassword, #teacherPasswordConfirmation').prop('required', true);
        $('#passwordField, #confirmPasswordField').show();
        $('#teacherModalTitle').text('Add Teacher');
        $('#adminProfileImageError').text('');
    }

    $('#teacherModal').on('show.bs.modal', function () {
        resetCreateForm();
    });

    $('#teacherForm').on('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        const password = $('#teacherPassword').val();
        const confirmation = $('#teacherPasswordConfirmation').val();

        if (password !== confirmation) {
            showNotice('error', 'The password and confirmation do not match.');
            return;
        }

        $.ajax({
            url: '/api/teachers',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('teacherModal')).hide();
                resetCreateForm();
                loadTeachers();
                showNotice('success', response.message || 'Teacher created successfully.');
            },
            error: function (xhr) {
                showNotice('error', getErrorMessage(xhr, 'Unable to create teacher. Please check the details and try again.'));
            }
        });
    });

    $(document).on('click', '.edit-btn', function () {
        const teacherId = $(this).data('id');
        const teacher = allTeachers.find(item => String(item.id) === String(teacherId));
        if (!teacher) {
            showNotice('error', 'Teacher details could not be found. Refresh the page and try again.');
            return;
        }

        $('#editId').val(teacher.id);
        $('#editName').val(teacher.name || '');
        $('#editEmail').val(teacher.email || '');
        $('#editPhone').val(teacher.contact ?? teacher.phone ?? '');
        $('#editPassword, #editPasswordConfirmation').val('');
        $('#editProfile').val('');

        if (teacher.profile_image) {
            $('#teacherImagePreview').attr('src', '/storage/' + teacher.profile_image).show();
        } else {
            $('#teacherImagePreview').hide().attr('src', '');
        }
    });

    $('#editProfile').on('change', function () {
        const file = this.files[0];
        if (file) {
            $('#teacherImagePreview').attr('src', URL.createObjectURL(file)).show();
        }
    });

    $('#Form').on('submit', function (event) {
        event.preventDefault();

        const teacherId = $('#editId').val();
        if (!teacherId) {
            showNotice('error', 'Missing teacher ID. Close the form and select Edit again.');
            return;
        }

        const password = $('#editPassword').val();
        const confirmation = $('#editPasswordConfirmation').val();

        if (password && password !== confirmation) {
            showNotice('error', 'The new password and confirmation do not match.');
            return;
        }

        const formData = new FormData(this);
        formData.append('_method', 'PUT');

        $.ajax({
            url: '/api/teachers/' + encodeURIComponent(teacherId),
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('teacherEditModal')).hide();
                loadTeachers();
                showNotice('success', response.message || 'Teacher updated successfully.');
            },
            error: function (xhr) {
                showNotice('error', getErrorMessage(xhr, 'Unable to update teacher. Please check the details and try again.'));
            }
        });
    });

    $(document).on('click', '.delete-btn', function () {
        $('#deleteTeacherId').val($(this).data('id'));
    });

    $('#confirmDeleteTeacher').on('click', function () {
        const teacherId = $('#deleteTeacherId').val();
        if (!teacherId) {
            showNotice('error', 'Missing teacher ID. Please select the teacher again.');
            return;
        }

        const button = $(this).prop('disabled', true).text('Deleting...');

        $.ajax({
            url: '/api/teachers/' + encodeURIComponent(teacherId),
            type: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteTeacherModal')).hide();
                loadTeachers();
                showNotice('success', response.message || 'Teacher deleted successfully.');
            },
            error: function (xhr) {
                showNotice('error', getErrorMessage(xhr, 'Unable to delete teacher. Please try again.'));
            },
            complete: function () {
                button.prop('disabled', false).text('Delete');
                $('#deleteTeacherId').val('');
            }
        });
    });

    $(document).ready(function () {
        loadTeachers();
        $('#teacherSearch').on('input', applySearch);
    });
</script>
@endpush
