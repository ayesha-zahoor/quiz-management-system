@extends('layouts.institute')

@section('title', 'Student Management')
@section('user-role', 'Institute Admin')
@section('page-title', 'Student Management')
@section('page-description', 'Manage students enrolled in your institute')

@section('content')
<div class="container-fluid px-0">

    {{-- Page heading --}}
    <div class="page-head">
        <div>
            <h4 class="mb-1">Students</h4>
            <p class="text-muted mb-0">Manage students enrolled in your institute</p>
        </div>

        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#studentModal">
            <i class="bi bi-plus-lg me-1"></i> Add Student
        </button>
    </div>

    {{-- Stat cards --}}
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
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div>
                        <small class="text-muted">New This Month</small>
                        <h4 class="mb-0" id="newThisMonth">0</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Student list --}}
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
                           placeholder="Search name, email, roll no. or class" autocomplete="off">
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 student-table">
                    <thead>
                        <tr>
                            <th class="col-index ps-4">#</th>
                            <th class="col-student">Student</th>
                            <th class="col-roll">Roll Number</th>
                            <th class="col-class">Class</th>
                            <th class="col-quiz">Quizzes Attempted</th>
                            <th class="col-joined">Joined</th>
                            <th class="col-actions text-end pe-4">Actions</th>
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

        <div class="card-footer bg-white border-0 px-4 py-3 pager-bar" id="studentPager"></div>
    </div>
</div>

{{-- Add / Edit modal --}}
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

            <form id="studentForm" novalidate>
                <div class="modal-body">
                    <input type="hidden" id="studentId">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="studentName">Student Name</label>
                            <input type="text" class="form-control" name="name" id="studentName" required>
                            <div class="field-error" data-error="name"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="studentEmail">Email Address</label>
                            <input type="email" class="form-control" name="email" id="studentEmail" required>
                            <div class="field-error" data-error="email"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="studentRoll">Roll Number</label>
                            <input type="text" class="form-control" name="student_roll_no" id="studentRoll" required>
                            <div class="field-error" data-error="student_roll_no"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="studentClass">Class</label>
                            <select class="form-select" name="class_id" id="studentClass" required>
                                <option value="">Select Class</option>
                            </select>
                            <div class="field-error" data-error="class_id"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="studentPassword">Password</label>
                            <input type="password" class="form-control" name="password"
                                   id="studentPassword" autocomplete="new-password">
                            <small class="text-muted" id="passwordHint">
                                Required when creating a student.
                            </small>
                            <div class="field-error" data-error="password"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label" for="studentPasswordConfirmation">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                   id="studentPasswordConfirmation" autocomplete="new-password">
                            <div class="field-error" data-error="password_confirmation"></div>
                        </div>

                        <div class="col-12">
                            <label class="form-label" for="studentPhoto">Profile Photo</label>
                            <div class="photo-row">
                                <img id="studentPhotoPreview" class="photo-preview" alt="" style="display:none">
                                <div class="flex-grow-1">
                                    <input type="file" class="form-control" name="profile_image" id="studentPhoto"
                                           accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted">JPG, PNG or WebP, up to 2 MB.</small>
                                    <div class="field-error" data-error="profile_image"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveStudentBtn">Save Student</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Delete confirmation modal --}}
<div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="delete-icon mb-3">
                    <i class="bi bi-trash"></i>
                </div>
                <h5>Delete Student?</h5>
                <p class="text-muted">
                    <strong id="deleteStudentName">This student</strong> will be removed permanently.
                    This action cannot be undone.
                </p>
                <input type="hidden" id="deleteStudentId">

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger px-4" id="confirmDeleteStudent">Delete</button>
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

    .page-head { margin-bottom: 24px; }

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

    .search-box { width: 320px; max-width: 100%; }
    .search-box .form-control { border-left: 0; }
    .search-box .input-group-text { border-right: 0; }

    /* ---------- Table ---------- */
    .student-table { min-width: 900px; transition: opacity .15s ease; }
    .student-table.is-loading { opacity: .55; }

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
        padding-top: 12px;
        padding-bottom: 12px;
        vertical-align: middle;
    }

    .col-index   { width: 64px; }
    .col-student { width: 30%; }
    .col-roll    { width: 120px; }
    .col-class   { width: 130px; }
    .col-quiz    { width: 150px; }
    .col-joined  { width: 130px; }
    .col-actions { width: 190px; }

    .student-table td.cell-nowrap { white-space: nowrap; }

    .student-cell {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .student-cell strong { display: block; overflow-wrap: anywhere; }
    .student-cell small { display: block; color: #64748b; overflow-wrap: anywhere; }

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
        object-fit: cover;
    }

    .class-tag,
    .attempt-pill {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        background: #ecfccb;
        color: #4d7c0f;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .attempt-pill i { margin-right: 4px; }

    .action-buttons { display: inline-flex; gap: 8px; }

    .action-btn {
        border: 0;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 600;
        transition: filter .15s ease;
    }

    .action-btn:hover { filter: brightness(.95); }
    .edit-btn { background: #ecfccb; color: #4d7c0f; }
    .delete-btn { background: #fee2e2; color: #dc2626; }

    /* ---------- Pagination ---------- */
    .pager-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pager-bar:empty { display: none; }

    /* ---------- Modal form ---------- */
    .field-error { color: #dc2626; font-size: 12px; margin-top: 4px; }
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
        .search-box { width: 100%; }
        .list-head { align-items: stretch; }
        .page-head .btn { width: 100%; }
        .pager-bar { justify-content: center; }
    }
</style>
@endpush

@push('scripts')
<script>
    let allStudents = [];
    let currentPage = 1;
    let searchTimer = null;

    // ---------- Helpers ----------
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

    function formatJoined(value) {
        return value
            ? new Date(value).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
            : '—';
    }

    function showStudentMessage(type, message) {
        if (typeof showResultModal === 'function') {
            showResultModal(type, type === 'success' ? 'Success' : 'Request Failed', message);
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

    function studentClassList(student) {
        return student.student_classes || [];
    }

    function studentClassNames(student) {
        return studentClassList(student).map(c => c.class_name).join(', ');
    }

    // Inline field errors
    function clearFieldErrors() {
        $('#studentForm .field-error').text('');
        $('#studentForm .is-invalid').removeClass('is-invalid');
    }

    function setFieldError(field, message) {
        $('#studentForm [data-error="' + field + '"]').text(message);
        $('#studentForm [name="' + field + '"]').addClass('is-invalid');
    }

    // ---------- Classes ----------
    function loadClasses(selectedId = '') {
        $.ajax({
            url: '/api/classes',
            type: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function (response) {
                let options = '<option value="">Select Class</option>';

                responseItems(response).forEach(function (item) {
                    const name = item.class_name || item.name || 'Class';
                    options += `<option value="${item.id}">${escapeHtml(name)}</option>`;
                });

                $('#studentClass').html(options);

                if (selectedId) {
                    $('#studentClass').val(String(selectedId));
                }
            },
            error: function (xhr) {
                showStudentMessage('error', getStudentError(xhr, 'Unable to load classes.'));
            }
        });
    }

    // ---------- Students list (server-side search + pagination) ----------
    function loadStudents(page = 1) {
        currentPage = page;
        $('.student-table').addClass('is-loading');

        $.ajax({
            url: '/api/students',
            type: 'GET',
            data: {
                search: ($('#studentSearch').val() || '').trim(),
                page: page
            },
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function (response) {
                const paginator = response.data || {};
                allStudents = paginator.data || [];

                $('#totalStudents').text(response.stats?.total ?? paginator.total ?? 0);
                $('#newThisMonth').text(response.stats?.new_this_month ?? 0);

                renderStudents(allStudents, paginator);
                renderPager(paginator);
            },
            error: function (xhr) {
                $('#studentTableBody').html(`
                    <tr>
                        <td colspan="7" class="text-center py-5 text-danger">
                            ${escapeHtml(getStudentError(xhr, 'Unable to load students.'))}
                        </td>
                    </tr>
                `);
                $('#studentPager').empty();
            },
            complete: function () {
                $('.student-table').removeClass('is-loading');
            }
        });
    }

    function renderStudents(students, paginator) {
        const query = ($('#studentSearch').val() || '').trim();

        $('#studentCount').text(
            query
                ? `${paginator.total ?? 0} result${paginator.total === 1 ? '' : 's'} for "${query}"`
                : 'Students registered in this institute'
        );

        if (!students.length) {
            $('#studentTableBody').html(`
                <tr>
                    <td colspan="7" class="text-center py-5">
                        ${query
                            ? 'No matching students found.'
                            : 'No students found. Add a student to get started.'}
                    </td>
                </tr>
            `);
            return;
        }

        const startAt = paginator.from || 1;
        let rows = '';

        students.forEach(function (student, index) {
            const photo = student.profile_image
                ? `<img src="/storage/${escapeHtml(student.profile_image)}" class="student-avatar" alt="">`
                : `<div class="student-avatar">${escapeHtml(studentInitials(student.name))}</div>`;

            const className = studentClassNames(student);
            const classCell = className
                ? `<span class="class-tag">${escapeHtml(className)}</span>`
                : '<span class="text-muted">—</span>';

            rows += `
                <tr>
                    <td class="ps-4 text-muted">${startAt + index}</td>
                    <td>
                        <div class="student-cell">
                            ${photo}
                            <div>
                                <strong>${escapeHtml(student.name)}</strong>
                                <small>${escapeHtml(student.email)}</small>
                            </div>
                        </div>
                    </td>
                    <td class="cell-nowrap">${escapeHtml(student.student_roll_no || '—')}</td>
                    <td>${classCell}</td>
                    <td><span class="attempt-pill"><i class="bi bi-journal-check"></i>${student.quiz_attempts_count ?? 0}</span></td>
                    <td class="cell-nowrap">${formatJoined(student.created_at)}</td>
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

    function renderPager(p) {
        if (!p || !p.total || p.last_page <= 1) {
            $('#studentPager').html(
                p && p.total ? `<small class="text-muted">Showing all ${p.total} student${p.total === 1 ? '' : 's'}</small>` : ''
            );
            return;
        }

        $('#studentPager').html(`
            <small class="text-muted">Showing ${p.from}–${p.to} of ${p.total} students</small>
            <div class="btn-group">
                <button type="button" class="btn btn-light btn-sm" data-page="${p.current_page - 1}"
                    ${p.current_page <= 1 ? 'disabled' : ''}>
                    <i class="bi bi-chevron-left"></i> Previous
                </button>
                <button type="button" class="btn btn-light btn-sm disabled">
                    Page ${p.current_page} of ${p.last_page}
                </button>
                <button type="button" class="btn btn-light btn-sm" data-page="${p.current_page + 1}"
                    ${p.current_page >= p.last_page ? 'disabled' : ''}>
                    Next <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        `);
    }

    $(document).on('click', '#studentPager [data-page]', function () {
        loadStudents(Number($(this).data('page')));
    });

    // Search on the server, after the user stops typing
    $('#studentSearch').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(function () { loadStudents(1); }, 300);
    });

    // ---------- Add / Edit modal ----------
    function resetStudentForm() {
        $('#studentForm')[0].reset();
        clearFieldErrors();
        $('#studentId').val('');
        $('#studentModalTitle').text('Add Student');
        $('#studentPassword, #studentPasswordConfirmation').prop('required', true);
        $('#passwordHint').text('Required when creating a student.');
        $('#saveStudentBtn').text('Save Student');
        $('#studentPhotoPreview').hide().attr('src', '');
    }

    // One handler decides: opened by an Edit button = fill the form, otherwise = blank form
    $('#studentModal').on('show.bs.modal', function (event) {
        const trigger = event.relatedTarget ? $(event.relatedTarget).closest('.edit-btn') : $();

        resetStudentForm();

        if (!trigger.length) {
            return;
        }

        const student = allStudents.find(item => String(item.id) === String(trigger.data('id')));

        if (!student) {
            showStudentMessage('error', 'Student details could not be found.');
            return;
        }

        const classId = studentClassList(student)[0]?.id || '';

        $('#studentId').val(student.id);
        $('#studentName').val(student.name || '');
        $('#studentEmail').val(student.email || '');
        $('#studentRoll').val(student.student_roll_no || '');
        $('#studentPassword, #studentPasswordConfirmation').prop('required', false);
        $('#studentModalTitle').text('Edit Student');
        $('#saveStudentBtn').text('Update Student');
        $('#passwordHint').text('Leave blank to keep the current password.');

        if (student.profile_image) {
            $('#studentPhotoPreview').attr('src', '/storage/' + student.profile_image).show();
        }

        // Classes are already loaded into the dropdown, so just select the right one
        if ($('#studentClass option').length > 1) {
            $('#studentClass').val(String(classId));
        } else {
            loadClasses(classId);
        }
    });

    // Preview a newly chosen photo
    $('#studentPhoto').on('change', function () {
        const file = this.files[0];

        if (file) {
            $('#studentPhotoPreview').attr('src', URL.createObjectURL(file)).show();
        }
    });

    $('#studentForm').on('submit', function (event) {
        event.preventDefault();
        clearFieldErrors();

        const id = $('#studentId').val();
        const password = $('#studentPassword').val();
        const confirmation = $('#studentPasswordConfirmation').val();

        let invalid = false;

        if (!id && !password) {
            setFieldError('password', 'Please enter a password for the new student.');
            invalid = true;
        }

        if (password !== confirmation) {
            setFieldError('password_confirmation', 'Passwords do not match.');
            invalid = true;
        }

        if (invalid) {
            return;
        }

        const formData = new FormData(this);
        const url = id ? '/api/students/' + encodeURIComponent(id) : '/api/students';

        if (id) {
            formData.append('_method', 'PUT');
        }

        // Blank password while editing = keep the current one
        if (!password) {
            formData.delete('password');
            formData.delete('password_confirmation');
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
                bootstrap.Modal.getOrCreateInstance(document.getElementById('studentModal')).hide();

                // New students appear first (latest), edited ones stay on the same page
                loadStudents(id ? currentPage : 1);

                showStudentMessage(
                    'success',
                    response.message || (id ? 'Student updated successfully.' : 'Student created successfully.')
                );
            },
            error: function (xhr) {
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    Object.entries(xhr.responseJSON.errors).forEach(function ([field, messages]) {
                        setFieldError(field, messages[0]);
                    });
                    return;
                }

                showStudentMessage('error', getStudentError(xhr, 'Unable to save student.'));
            },
            complete: function () {
                $('#saveStudentBtn').prop('disabled', false);
            }
        });
    });

    // ---------- Delete (always asks first) ----------
    $('#deleteStudentModal').on('show.bs.modal', function (event) {
        const trigger = $(event.relatedTarget).closest('.delete-btn');
        const student = allStudents.find(item => String(item.id) === String(trigger.data('id')));

        $('#deleteStudentId').val(trigger.data('id') || '');
        $('#deleteStudentName').text(student ? student.name : 'This student');
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
                bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteStudentModal')).hide();

                // If that was the last row on this page, go back one page
                loadStudents(allStudents.length === 1 && currentPage > 1 ? currentPage - 1 : currentPage);

                showStudentMessage('success', response.message || 'Student deleted successfully.');
            },
            error: function (xhr) {
                showStudentMessage('error', getStudentError(xhr, 'Unable to delete student.'));
            },
            complete: function () {
                button.prop('disabled', false).text('Delete');
                $('#deleteStudentId').val('');
            }
        });
    });

    $(document).ready(function () {
        loadClasses();
        loadStudents();
    });
</script>
@endpush