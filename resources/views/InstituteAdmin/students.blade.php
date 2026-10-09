
@extends('layouts.institute')

@section('title', 'Student Management')
@section('user-role', 'Institute Admin')
@section('page-title', 'Student Management')
@section('page-description', 'Manage students enrolled in your institute')

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

    <a href="/instituteAdmin/teachers" class="nav-link">
        <i class="bi bi-person-badge"></i>
        <span>Teacher Management</span>
    </a>

    <a href="/instituteAdmin/students" class="nav-link active">
        <i class="bi bi-people"></i>
        <span>Student Management</span>
    </a>
@endsection

@section('content')
<div class="container-fluid px-0">

    <div class="page-head">
        <div>
            <h4 class="mb-1">Students</h4>
            <p class="text-muted mb-0">Manage students enrolled in your institute</p>
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#studentModal">
            <i class="bi bi-plus-lg me-1"></i> Add Student
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <small class="text-muted">Total Students</small>
                        <h4 class="mb-0" id="totalStudents">0</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3">
                        <i class="bi bi-person-check"></i>
                    </div>
                    <div>
                        <small class="text-muted">Active Students</small>
                        <h4 class="mb-0" id="activeStudents">0</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="icon-box me-3">
                        <i class="bi bi-person-x"></i>
                    </div>
                    <div>
                        <small class="text-muted">Inactive Students</small>
                        <h4 class="mb-0" id="inactiveStudents">0</h4>
                    </div> 
                </div>
            </div>
        </div> -->
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 px-4 py-3">
            <div class="list-head">
                <div>
                    <h5 class="mb-1">Student List</h5>
                    <small class="text-muted" id="studentCount">
                        Students registered in this institute
                    </small>
                </div>

                <div class="input-group search-box">
                    <span class="input-group-text bg-white">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control" id="studentSearch"
                           placeholder="Search students..." autocomplete="off">
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 student-table">
                    <thead>
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Student</th>
                            <th>Roll Number</th>
                            <th>Email</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentTableBody">
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                Loading students...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="studentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="studentModalTitle">Add Student</h5>
                    <small class="text-muted">Enter student account details</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="studentForm">
                <div class="modal-body">
                    <input type="hidden" id="studentId">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="studentName">Student Name</label>
                            <input type="text" class="form-control" name="name"
                                   id="studentName" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="studentEmail">Email Address</label>
                            <input type="email" class="form-control" name="email"
                                   id="studentEmail" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="studentRoll">Roll Number</label>
                            <input type="text" class="form-control" name="student_roll_no"
                                   id="studentRoll" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="studentClass">Class</label>
                            <select class="form-select" name="class_id" id="studentClass" required>
                                <option value="">Select Class</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="studentPassword">Password</label>
                            <input type="password" class="form-control" name="password"
                                   id="studentPassword" autocomplete="new-password">
                            <small class="text-muted" id="passwordHint">
                                Required when creating a student.
                            </small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="studentPasswordConfirmation">
                                Confirm Password
                            </label>
                            <input type="password" class="form-control"
                                   name="password_confirmation"
                                   id="studentPasswordConfirmation"
                                   autocomplete="new-password">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveStudentBtn">
                        Save Student
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="delete-icon mb-3">
                    <i class="bi bi-trash"></i>
                </div>
                <h5>Delete Student?</h5>
                <p class="text-muted">
                    Are you sure you want to delete this student?
                </p>
                <input type="hidden" id="deleteStudentId">

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger"
                            id="confirmDeleteStudent">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .page-head, .list-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-head {
        margin-bottom: 24px;
    }

    .icon-box {
        width: 45px;
        height: 45px;
        flex: 0 0 45px;
        border-radius: 10px;
        background: rgba(132, 204, 22, .12);
        color: #65a30d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .search-box {
        width: 280px;
        max-width: 100%;
    }

    .search-box .form-control {
        border-left: 0;
    }

    .search-box .input-group-text {
        border-right: 0;
    }

    .student-table {
        min-width: 900px;
    }

    .student-table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        padding-top: 12px;
        padding-bottom: 12px;
    }

    .student-table tbody td {
        font-size: 14px;
        padding-top: 14px;
        padding-bottom: 14px;
    }

    .student-avatar {
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

    .student-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .student-cell strong {
        overflow-wrap: anywhere;
    }

    .badge-active, .badge-inactive {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        text-transform: capitalize;
    }

    .badge-active {
        background: #dcfce7;
        color: #15803d;
    }

    .badge-inactive {
        background: #f1f5f9;
        color: #64748b;
    }

    .action-buttons {
        display: inline-flex;
        gap: 8px;
    }

    .action-btn {
        border: 0;
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 13px;
        font-weight: 600;
    }

    .edit-btn {
        background: #ecfccb;
        color: #4d7c0f;
    }

    .delete-btn {
        background: #fee2e2;
        color: #dc2626;
    }

    .delete-icon {
        width: 60px;
        height: 60px;
        margin: auto;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fee2e2;
        color: #dc2626;
        font-size: 25px;
    }

    @media (max-width: 768px) {
        .search-box {
            width: 100%;
        }

        .list-head {
            align-items: stretch;
        }

        .page-head .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let allStudents = [];
    let allClasses = [];

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function studentInitials(name) {
        return (name || '?').trim()
            .split(/\s+/)
            .map(word => word[0])
            .slice(0, 2)
            .join('')
            .toUpperCase();
    }

    function showStudentMessage(type, message) {
        if (typeof showResultModal === 'function') {
            showResultModal(
                type,
                type === 'success' ? 'Success' : 'Request Failed',
                message
            );
        } else {
            alert(message);
        }
    }

    function getStudentError(xhr, fallback) {
        const response = xhr.responseJSON;

        if (response?.errors) {
            return Object.values(response.errors).flat().join('\n');
        }

        return response?.message || fallback;
    }

    function responseItems(response) {
        const payload = response?.data;

        if (Array.isArray(payload)) return payload;
        if (Array.isArray(payload?.data)) return payload.data;

        return [];
    }

    function loadClasses(selectedId = '') {
        $.ajax({
            url: '/api/classes',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function (response) {
                allClasses = responseItems(response);

                let options = '<option value="">Select Class</option>';

                allClasses.forEach(function (item) {
                    const id = item.id;
                    const name = item.class_name || item.name || 'Class';
                    options += `<option value="${id}">${escapeHtml(name)}</option>`;
                });

                $('#studentClass').html(options);

                if (selectedId) {
                    $('#studentClass').val(String(selectedId));
                }
            },
            error: function (xhr) {
                showStudentMessage(
                    'error',
                    getStudentError(xhr, 'Unable to load classes.')
                );
            }
        });
    }

    function loadStudents() {
        $('#studentTableBody').html(`
            <tr><td colspan="7" class="text-center py-5">Loading students...</td></tr>
        `);

        $.ajax({
            url: '/api/admingettingStudents',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function (response) {
                allStudents = responseItems(response);
                updateStudentStats();
                filterStudents();
            },
            error: function (xhr) {
                $('#studentTableBody').html(`
                    <tr>
                        <td colspan="7" class="text-center py-5 text-danger">
                            ${escapeHtml(getStudentError(xhr, 'Unable to load students.'))}
                        </td>
                    </tr>
                `);
            }
        });
    }

    function updateStudentStats() {
        const inactive = allStudents.filter(student =>
            (student.status || 'active').toLowerCase() === 'inactive'
        ).length;

        $('#totalStudents').text(allStudents.length);
        $('#activeStudents').text(allStudents.length - inactive);
        $('#inactiveStudents').text(inactive);
    }

    function filterStudents() {
        const query = ($('#studentSearch').val() || '').trim().toLowerCase();

        const filtered = allStudents.filter(function (student) {
            const className = student.academic_class?.class_name
                || student.academicClass?.class_name
                || student.class?.class_name
                || '';

            return [
                student.name,
                student.email,
                student.student_roll_no,
                student.status,
                className
            ].join(' ').toLowerCase().includes(query);
        });

        $('#studentCount').text(
            query
                ? `Showing ${filtered.length} of ${allStudents.length} students`
                : 'Students registered in this institute'
        );

        renderStudents(filtered);
    }

    function renderStudents(students) {
        if (!allStudents.length) {
            $('#studentTableBody').html(`
                <tr>
                    <td colspan="7" class="text-center py-5">
                        No students found. Add a student to get started.
                    </td>
                </tr>
            `);
            return;
        }

        if (!students.length) {
            $('#studentTableBody').html(`
                <tr>
                    <td colspan="7" class="text-center py-5">
                        No matching students found.
                    </td>
                </tr>
            `);
            return;
        }

        let rows = '';

        students.forEach(function (student, index) {
            const status = (student.status || 'active').toLowerCase();
            const statusClass = status === 'inactive'
                ? 'badge-inactive'
                : 'badge-active';

            const className = student.academic_class?.class_name
                || student.academicClass?.class_name
                || student.class?.class_name
                || '—';

            rows += `
                <tr>
                    <td class="ps-4">${index + 1}</td>
                    <td>
                        <div class="student-cell">
                            <div class="student-avatar">
                                ${escapeHtml(studentInitials(student.name))}
                            </div>
                            <strong>${escapeHtml(student.name)}</strong>
                        </div>
                    </td>
                    <td>${escapeHtml(student.student_roll_no || '—')}</td>
                    <td>${escapeHtml(student.email)}</td>
                    <td>${escapeHtml(className)}</td>
                    <td>
                        <span class="${statusClass}">${escapeHtml(status)}</span>
                    </td>
                    <td class="text-end pe-4">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                data-id="${student.id}"
                                data-bs-toggle="modal"
                                data-bs-target="#studentModal">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                data-id="${student.id}"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteStudentModal">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        $('#studentTableBody').html(rows);
    }

    function resetStudentForm() {
        $('#studentForm')[0].reset();
        $('#studentId').val('');
        $('#studentModalTitle').text('Add Student');
        $('#studentPassword').prop('required', true);
        $('#studentPasswordConfirmation').prop('required', true);
        $('#passwordHint').text('Required when creating a student.');
        $('#saveStudentBtn').text('Save Student');
    }

    $('#studentModal').on('show.bs.modal', function () {
        if (!$('#studentId').val()) {
            resetStudentForm();
            loadClasses();
        }
    });

    $(document).on('click', '.edit-btn', function () {
        const id = $(this).data('id');
        const student = allStudents.find(item => String(item.id) === String(id));

        if (!student) {
            showStudentMessage('error', 'Student details could not be found.');
            return;
        }

        $('#studentId').val(student.id);
        $('#studentName').val(student.name || '');
        $('#studentEmail').val(student.email || '');
        $('#studentRoll').val(student.student_roll_no || '');
        $('#studentPassword, #studentPasswordConfirmation').val('');
        $('#studentPassword, #studentPasswordConfirmation').prop('required', false);
        $('#studentModalTitle').text('Edit Student');
        $('#saveStudentBtn').text('Update Student');
        $('#passwordHint').text('Leave blank to keep the current password.');

        const classId = student.class_id
            || student.academic_class?.id
            || student.academicClass?.id
            || '';

        loadClasses(classId);
    });

    $('#studentForm').on('submit', function (event) {
        event.preventDefault();

        const id = $('#studentId').val();
        const password = $('#studentPassword').val();
        const confirmation = $('#studentPasswordConfirmation').val();

        if (password !== confirmation) {
            showStudentMessage('error', 'Passwords do not match.');
            return;
        }

        if (!id && !password) {
            showStudentMessage('error', 'Please enter a password for the new student.');
            return;
        }

        const formData = new FormData(this);
        const url = id ? '/api/students/' + encodeURIComponent(id) : '/api/students';

        if (id) {
            formData.append('_method', 'PUT');
        }

        $('#saveStudentBtn').prop('disabled', true);

        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('studentModal')
                ).hide();

                resetStudentForm();
                loadStudents();

                showStudentMessage(
                    'success',
                    response.message || (id
                        ? 'Student updated successfully.'
                        : 'Student created successfully.')
                );
            },
            error: function (xhr) {
                showStudentMessage(
                    'error',
                    getStudentError(xhr, 'Unable to save student.')
                );
            },
            complete: function () {
                $('#saveStudentBtn').prop('disabled', false);
            }
        });
    });

    $(document).on('click', '.delete-btn', function () {
        $('#deleteStudentId').val($(this).data('id'));
    });

    $('#confirmDeleteStudent').on('click', function () {
        const id = $('#deleteStudentId').val();

        if (!id) {
            showStudentMessage('error', 'Select a student to delete.');
            return;
        }

        const button = $(this).prop('disabled', true).text('Deleting...');

        $.ajax({
            url: '/api/students/' + encodeURIComponent(id),
            type: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('deleteStudentModal')
                ).hide();

                loadStudents();
                showStudentMessage(
                    'success',
                    response.message || 'Student deleted successfully.'
                );
            },
            error: function (xhr) {
                showStudentMessage(
                    'error',
                    getStudentError(xhr, 'Unable to delete student.')
                );
            },
            complete: function () {
                button.prop('disabled', false).text('Delete');
                $('#deleteStudentId').val('');
            }
        });
    });

    $('#studentSearch').on('input', filterStudents);

    $(document).ready(function () {
        loadClasses();
        loadStudents();
    });
</script>
@endpush
