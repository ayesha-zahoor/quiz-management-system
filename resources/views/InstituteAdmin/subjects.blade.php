@extends('layouts.institute')

@section('title', 'Subject Management')
@section('user-role', 'Institute Admin')
@section('page-title', 'Subject Management')
@section('page-description', 'Manage subjects for your institute')



@section('content')
<div class="container-fluid px-0">

    {{-- Page heading --}}
    <div class="page-head">
        <div>
            <h4 class="mb-1">Subjects</h4>
            <p class="text-muted mb-0">Create and manage subjects for your institute</p>
        </div>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subjectModal">
            <i class="bi bi-plus-lg me-1"></i> Add Subject
        </button>
    </div>

    {{-- Subject list --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 px-4 py-3">
            <div class="list-head">
                <div>
                    <h5 class="mb-1">Institute Subjects</h5>
                    <small class="text-muted">All subjects available in your institute</small>
                </div>

                <div class="list-tools">
                    <span class="count-pill" id="subjectCount">0 subjects</span>

                    <div class="input-group search-box">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="subjectSearch" placeholder="Search by name or code" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 data-table">
                    <thead>
                        <tr>
                            <th class="col-index ps-4">#</th>
                            <th class="col-main">Subject</th>
                            <th class="col-code">Code</th>
                            <th class="col-actions text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subjectsTableBody">
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Loading subjects...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ================= Add / Edit modal ================= --}}
<div class="modal fade" id="subjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="subjectModalTitle">Add Subject</h5>
                    <small class="text-muted" id="subjectModalSub">Enter the subject details below</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="subjectForm" novalidate>
                <div class="modal-body">
                    <input type="hidden" id="editId">

                    <div class="mb-3">
                        <label for="subjectName" class="form-label">Subject Name</label>
                        <input type="text" class="form-control" id="subjectName" name="name" placeholder="e.g. Urdu" required>
                        <div class="field-error" data-error="name"></div>
                    </div>

                    <div>
                        <label for="subjectCode" class="form-label">Subject Code</label>
                        <input type="text" class="form-control" id="subjectCode" name="code" placeholder="e.g. URD-101" autocomplete="off" required>
                        <small class="text-muted">A short, unique code for this subject.</small>
                        <div class="field-error" data-error="code"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveSubjectBtn">
                        <i class="bi bi-check-lg me-1"></i> Save Subject
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- ================= Delete confirmation ================= --}}
<div class="modal fade" id="deleteSubjectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">

                <div class="delete-icon mb-3"><i class="bi bi-trash"></i></div>

                <h5>Delete Subject?</h5>

                <p class="text-muted mb-4">
                    <strong id="deleteSubjectName">This subject</strong> will be removed permanently.
                    This action cannot be undone.
                </p>

                <input type="hidden" id="deleteSubjectId">

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger px-4" id="confirmDeleteSubject">Delete</button>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Messages --}}
<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toastBox"></div>
@endsection


@push('styles')
<style>
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

    .list-tools { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }

    .count-pill {
        padding: 7px 12px;
        border-radius: 999px;
        background: var(--primary-light);
        color: var(--primary-dark);
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .search-box { width: 280px; max-width: 100%; }
    .search-box .form-control { border-left: 0; }
    .search-box .input-group-text { border-right: 0; }

    /* ---------- Table ---------- */
    .data-table { min-width: 560px; }

    .data-table thead th {
        background: var(--off-white);
        color: var(--slate);
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        padding-top: 12px;
        padding-bottom: 12px;
    }

    .data-table tbody td { font-size: 14px; padding-top: 12px; padding-bottom: 12px; vertical-align: middle; }

    .col-index   { width: 64px; }
    .col-code    { width: 200px; }
    .col-actions { width: 200px; }

    .row-main { display: flex; align-items: center; gap: 12px; min-width: 0; }
    .row-main strong { display: block; font-weight: 600; overflow-wrap: anywhere; }

    .row-icon {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .code-badge {
        display: inline-block;
        padding: 5px 11px;
        border-radius: 8px;
        background: color-mix(in srgb, var(--secondary-color) 12%, white);
        color: var(--secondary-color);
        font-family: ui-monospace, Menlo, Consolas, monospace;
        font-size: 12px;
        font-weight: 700;
    }

    /* ---------- Row actions ---------- */
    .action-buttons { display: inline-flex; gap: 8px; }

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
        transition: background 0.2s ease, color 0.2s ease;
    }

    .edit-btn { background: var(--primary-light); color: var(--primary-dark); }
    .edit-btn:hover { background: var(--primary-color); color: var(--on-primary); }

    .delete-btn { background: color-mix(in srgb, var(--danger) 10%, white); color: var(--danger); }
    .delete-btn:hover { background: var(--danger); color: #fff; }

    /* ---------- Empty state ---------- */
    .empty-state { padding: 10px; color: var(--slate); }
    .empty-state i.big { display: block; margin-bottom: 10px; font-size: 40px; color: var(--primary-dark); }
    .empty-state h6 { color: var(--text-color); }

    /* ---------- Forms ---------- */
    .field-error { color: var(--danger); font-size: 12px; margin-top: 4px; }
    .field-error:empty { display: none; }

    .delete-icon {
        width: 60px;
        height: 60px;
        margin: auto;
        border-radius: 50%;
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

    .notice-toast .toast-body { display: flex; align-items: flex-start; gap: 10px; font-size: 14px; white-space: pre-line; }
    .notice-toast.success { background: #dcfce7; color: #15803d; }
    .notice-toast.error   { background: #fee2e2; color: #b91c1c; }

    @media (max-width: 768px) {
        .search-box { width: 100%; }
        .list-tools { width: 100%; }
        .list-head { flex-direction: column; align-items: stretch; }
        .page-head .btn { width: 100%; }
    }
</style>
@endpush


@push('scripts')
<script>
    let allSubjects = [];

    const SAVE_HTML   = '<i class="bi bi-check-lg me-1"></i> Save Subject';
    const UPDATE_HTML = '<i class="bi bi-check-lg me-1"></i> Update Subject';

    // ---------- Helpers ----------
    function esc(value) {
        return $('<div>').text(value ?? '').html();
    }

    function authHeaders() {
        return { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' };
    }

    function responseItems(response) {
        if (Array.isArray(response)) return response;
        if (Array.isArray(response?.data)) return response.data;
        if (Array.isArray(response?.data?.data)) return response.data.data;
        return [];
    }

    function getErrorMessage(xhr, fallback) {
        const response = xhr.responseJSON;
        if (response?.errors) return Object.values(response.errors).flat().join('\n');
        return response?.message || fallback;
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
            Object.entries(xhr.responseJSON.errors).forEach(([field, messages]) => setFieldError(form, field, messages[0]));
            showNotice('error', 'Please fix the highlighted fields and try again.');
            return;
        }

        showNotice('error', getErrorMessage(xhr, fallback));
    }

    function setBusy(button, busy, busyText, normalHtml) {
        button.prop('disabled', busy);
        button.html(busy ? `<span class="spinner-border spinner-border-sm me-2"></span>${busyText}` : normalHtml);
    }

    // ---------- List ----------
    function messageRow(icon, title, message, withButton) {
        return `
            <tr>
                <td colspan="4" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi ${icon} big"></i>
                        <h6 class="mb-1">${esc(title)}</h6>
                        <p class="mb-${withButton ? '3' : '0'}">${esc(message)}</p>
                        ${withButton ? '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#subjectModal"><i class="bi bi-plus-lg me-1"></i> Add Subject</button>' : ''}
                    </div>
                </td>
            </tr>`;
    }

    function renderSubjects() {
        const query = ($('#subjectSearch').val() || '').trim().toLowerCase();

        const list = allSubjects.filter(item =>
            !query || [item.name, item.code].join(' ').toLowerCase().includes(query)
        );

        $('#subjectCount').text(query
            ? `${list.length} of ${allSubjects.length} subjects`
            : `${allSubjects.length} ${allSubjects.length === 1 ? 'subject' : 'subjects'}`);

        if (!allSubjects.length) {
            $('#subjectsTableBody').html(messageRow('bi-book', 'No subjects found', 'Add your first subject to start managing your institute.', true));
            return;
        }

        if (!list.length) {
            $('#subjectsTableBody').html(messageRow('bi-search', 'No matching subjects', 'Try a different name or code.', false));
            return;
        }

        $('#subjectsTableBody').html(list.map(function (item, index) {
            return `
                <tr>
                    <td class="ps-4 text-muted">${index + 1}</td>
                    <td>
                        <div class="row-main">
                            <div class="row-icon"><i class="bi bi-book"></i></div>
                            <strong>${esc(item.name)}</strong>
                        </div>
                    </td>
                    <td><span class="code-badge">${esc(item.code || '—')}</span></td>
                    <td class="text-end pe-4">
                        <div class="action-buttons">
                            <button type="button" class="action-btn edit-btn" data-id="${item.id}"
                                data-bs-toggle="modal" data-bs-target="#subjectModal">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button type="button" class="action-btn delete-btn" data-id="${item.id}"
                                data-bs-toggle="modal" data-bs-target="#deleteSubjectModal">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>`;
        }).join(''));
    }

    function loadSubjects() {
        $.ajax({
            url: '/api/subjects',
            type: 'GET',
            headers: authHeaders(),
            success: function (response) {
                allSubjects = responseItems(response);
                renderSubjects();
            },
            error: function (xhr) {
                $('#subjectsTableBody').html(messageRow('bi-exclamation-circle', "Couldn't load subjects", getErrorMessage(xhr, 'Refresh the page and try again.'), false));
            }
        });
    }

    $('#subjectSearch').on('input', renderSubjects);

    // ---------- Add / Edit ----------
    $('#subjectModal').on('show.bs.modal', function (event) {
        const trigger = event.relatedTarget ? $(event.relatedTarget).closest('.edit-btn') : $();

        $('#subjectForm')[0].reset();
        clearFieldErrors('#subjectForm');
        $('#editId').val('');
        $('#subjectModalTitle').text('Add Subject');
        $('#subjectModalSub').text('Enter the subject details below');
        setBusy($('#saveSubjectBtn'), false, '', SAVE_HTML);

        if (!trigger.length) return;

        const item = allSubjects.find(s => String(s.id) === String(trigger.data('id')));

        if (!item) {
            showNotice('error', 'Subject details could not be found. Refresh the page and try again.');
            return;
        }

        $('#editId').val(item.id);
        $('#subjectName').val(item.name || '');
        $('#subjectCode').val(item.code || '');
        $('#subjectModalTitle').text('Edit Subject');
        $('#subjectModalSub').text('Update the subject details below');
        setBusy($('#saveSubjectBtn'), false, '', UPDATE_HTML);
    });

    $('#subjectForm').on('submit', function (event) {
        event.preventDefault();
        clearFieldErrors(this);

        const form = this;
        const id = $('#editId').val();
        const normalHtml = id ? UPDATE_HTML : SAVE_HTML;
        let invalid = false;

        if (!$('#subjectName').val().trim()) { setFieldError(form, 'name', 'Please enter the subject name.'); invalid = true; }
        if (!$('#subjectCode').val().trim()) { setFieldError(form, 'code', 'Please enter the subject code.'); invalid = true; }

        if (invalid) return;

        const formData = new FormData(form);
        if (id) formData.append('_method', 'PUT');

        const button = $('#saveSubjectBtn');
        setBusy(button, true, id ? 'Updating...' : 'Saving...', normalHtml);

        $.ajax({
            url: id ? '/api/subjects/' + encodeURIComponent(id) : '/api/subjects',
            type: 'POST',
            headers: authHeaders(),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('subjectModal')).hide();
                loadSubjects();
                showNotice('success', response.message || (id ? 'Subject updated successfully.' : 'Subject added successfully.'));
            },
            error: function (xhr) {
                showServerErrors(form, xhr, id ? 'Unable to update the subject. Please try again.' : 'Unable to add the subject. Please try again.');
            },
            complete: function () {
                setBusy(button, false, '', normalHtml);
            }
        });
    });

    // ---------- Delete (always asks first) ----------
    $('#deleteSubjectModal').on('show.bs.modal', function (event) {
        const trigger = $(event.relatedTarget).closest('.delete-btn');
        const item = allSubjects.find(s => String(s.id) === String(trigger.data('id')));

        $('#deleteSubjectId').val(trigger.data('id') || '');
        $('#deleteSubjectName').text(item ? item.name : 'This subject');
    });

    $('#confirmDeleteSubject').on('click', function () {
        const id = $('#deleteSubjectId').val();

        if (!id) {
            showNotice('error', 'Missing subject. Close this window and try again.');
            return;
        }

        const button = $(this).prop('disabled', true).text('Deleting...');

        $.ajax({
            url: '/api/subjects/' + encodeURIComponent(id),
            type: 'DELETE',
            headers: authHeaders(),
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteSubjectModal')).hide();
                loadSubjects();
                showNotice('success', response.message || 'Subject deleted successfully.');
            },
            error: function (xhr) {
                showNotice('error', getErrorMessage(xhr, 'Unable to delete the subject. Please try again.'));
            },
            complete: function () {
                button.prop('disabled', false).text('Delete');
                $('#deleteSubjectId').val('');
            }
        });
    });

    $(document).ready(loadSubjects);
</script>
@endpush