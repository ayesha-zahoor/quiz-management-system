@extends('layouts.institute')

@section('title', 'Class Management')
@section('user-role', 'Institute Admin')
@section('page-title', 'Class Management')
@section('page-description', 'Manage classes and academic groups')



@section('content')
<div class="container-fluid px-0">

    {{-- Page heading --}}
    <div class="page-head">
        <div>
            <h4 class="mb-1">Classes</h4>
            <p class="text-muted mb-0">Create and manage classes for your institute</p>
        </div>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classModal">
            <i class="bi bi-plus-lg me-1"></i> Add Class
        </button>
    </div>

    {{-- Class list --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 px-4 py-3">
            <div class="list-head">
                <div>
                    <h5 class="mb-1">Institute Classes</h5>
                    <small class="text-muted">All classes registered in your institute</small>
                </div>

                <div class="list-tools">
                    <span class="count-pill" id="classCount">0 classes</span>

                    <div class="input-group search-box">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" id="classSearch" placeholder="Search classes or groups" autocomplete="off">
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
                            <th class="col-main">Class</th>
                            <th class="col-group">Group</th>
                            <th class="col-order">Order</th>
                            <th class="col-actions text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="classesTableBody">
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Loading classes...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ================= Add / Edit modal ================= --}}
<div class="modal fade" id="classModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="classModalTitle">Add Class</h5>
                    <small class="text-muted" id="classModalSub">Enter the class details below</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="classForm" novalidate>
                <div class="modal-body">
                    <input type="hidden" id="editId">

                    <div class="mb-3">
                        <label for="className" class="form-label">Class Name</label>
                        <input type="text" class="form-control" id="className" name="class_name" placeholder="e.g. Class 5" required>
                        <div class="field-error" data-error="class_name"></div>
                    </div>

                    <div class="mb-3">
                        <label for="classGroup" class="form-label">Group</label>
                        <input type="text" class="form-control" id="classGroup" name="group" list="groupOptions"
                               placeholder="e.g. primary" autocomplete="off" required>
                        <datalist id="groupOptions"></datalist>
                        <small class="text-muted">Pick an existing group or type a new one.</small>
                        <div class="field-error" data-error="group"></div>
                    </div>

                    <div>
                        <label for="sortOrder" class="form-label">Sort Order</label>
                        <input type="number" class="form-control" id="sortOrder" name="sort_order" min="0" placeholder="e.g. 1" required>
                        <small class="text-muted">Lower numbers are shown first.</small>
                        <div class="field-error" data-error="sort_order"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveClassBtn">
                        <i class="bi bi-check-lg me-1"></i> Save Class
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- ================= Delete confirmation ================= --}}
<div class="modal fade" id="deleteClassModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">

                <div class="delete-icon mb-3"><i class="bi bi-trash"></i></div>

                <h5>Delete Class?</h5>

                <p class="text-muted mb-4">
                    <strong id="deleteClassName">This class</strong> will be removed permanently.
                    This action cannot be undone.
                </p>

                <input type="hidden" id="deleteClassId">

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger px-4" id="confirmDeleteClass">Delete</button>
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
    .data-table { min-width: 640px; }

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
    .col-group   { width: 180px; }
    .col-order   { width: 110px; }
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

    .group-badge {
        display: inline-block;
        padding: 5px 11px;
        border-radius: 999px;
        background: color-mix(in srgb, var(--secondary-color) 12%, white);
        color: var(--secondary-color);
        font-size: 12px;
        font-weight: 700;
        text-transform: capitalize;
    }

    .order-number { font-weight: 700; font-variant-numeric: tabular-nums; }

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
    let allClasses = [];

    const SAVE_HTML   = '<i class="bi bi-check-lg me-1"></i> Save Class';
    const UPDATE_HTML = '<i class="bi bi-check-lg me-1"></i> Update Class';

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
    function sortedClasses(list) {
        return [...list].sort((a, b) =>
            (Number(a.sort_order) || 0) - (Number(b.sort_order) || 0) ||
            String(a.class_name).localeCompare(String(b.class_name))
        );
    }

    function messageRow(icon, title, message, withButton) {
        return `
            <tr>
                <td colspan="5" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi ${icon} big"></i>
                        <h6 class="mb-1">${esc(title)}</h6>
                        <p class="mb-${withButton ? '3' : '0'}">${esc(message)}</p>
                        ${withButton ? '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#classModal"><i class="bi bi-plus-lg me-1"></i> Add Class</button>' : ''}
                    </div>
                </td>
            </tr>`;
    }

    function renderClasses() {
        const query = ($('#classSearch').val() || '').trim().toLowerCase();

        const list = sortedClasses(allClasses).filter(item =>
            !query || [item.class_name, item.group].join(' ').toLowerCase().includes(query)
        );

        $('#classCount').text(query
            ? `${list.length} of ${allClasses.length} classes`
            : `${allClasses.length} ${allClasses.length === 1 ? 'class' : 'classes'}`);

        // Existing groups become suggestions in the form
        const groups = [...new Set(allClasses.map(c => c.group).filter(Boolean))];
        $('#groupOptions').html(groups.map(g => `<option value="${esc(g)}"></option>`).join(''));

        if (!allClasses.length) {
            $('#classesTableBody').html(messageRow('bi-mortarboard', 'No classes found', 'Add your first class to start managing your institute.', true));
            return;
        }

        if (!list.length) {
            $('#classesTableBody').html(messageRow('bi-search', 'No matching classes', 'Try a different name or group.', false));
            return;
        }

        $('#classesTableBody').html(list.map(function (item, index) {
            return `
                <tr>
                    <td class="ps-4 text-muted">${index + 1}</td>
                    <td>
                        <div class="row-main">
                            <div class="row-icon"><i class="bi bi-mortarboard"></i></div>
                            <strong>${esc(item.class_name)}</strong>
                        </div>
                    </td>
                    <td><span class="group-badge">${esc(item.group || '—')}</span></td>
                    <td><span class="order-number">${esc(item.sort_order ?? '—')}</span></td>
                    <td class="text-end pe-4">
                        <div class="action-buttons">
                            <button type="button" class="action-btn edit-btn" data-id="${item.id}"
                                data-bs-toggle="modal" data-bs-target="#classModal">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                            <button type="button" class="action-btn delete-btn" data-id="${item.id}"
                                data-bs-toggle="modal" data-bs-target="#deleteClassModal">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </td>
                </tr>`;
        }).join(''));
    }

    function loadClasses() {
        $.ajax({
            url: '/api/classes',
            type: 'GET',
            headers: authHeaders(),
            success: function (response) {
                allClasses = responseItems(response);
                renderClasses();
            },
            error: function (xhr) {
                $('#classesTableBody').html(messageRow('bi-exclamation-circle', "Couldn't load classes", getErrorMessage(xhr, 'Refresh the page and try again.'), false));
            }
        });
    }

    $('#classSearch').on('input', renderClasses);

    // ---------- Add / Edit ----------
    $('#classModal').on('show.bs.modal', function (event) {
        const trigger = event.relatedTarget ? $(event.relatedTarget).closest('.edit-btn') : $();

        $('#classForm')[0].reset();
        clearFieldErrors('#classForm');
        $('#editId').val('');
        setBusy($('#saveClassBtn'), false, '', SAVE_HTML);

        if (!trigger.length) {
            // New class: suggest the next sort order
            const next = allClasses.length ? Math.max(...allClasses.map(c => Number(c.sort_order) || 0)) + 1 : 1;
            $('#classModalTitle').text('Add Class');
            $('#classModalSub').text('Enter the class details below');
            $('#sortOrder').val(next);
            return;
        }

        const item = allClasses.find(c => String(c.id) === String(trigger.data('id')));

        if (!item) {
            showNotice('error', 'Class details could not be found. Refresh the page and try again.');
            return;
        }

        $('#editId').val(item.id);
        $('#className').val(item.class_name || '');
        $('#classGroup').val(item.group || '');
        $('#sortOrder').val(item.sort_order ?? '');
        $('#classModalTitle').text('Edit Class');
        $('#classModalSub').text('Update the class details below');
        setBusy($('#saveClassBtn'), false, '', UPDATE_HTML);
    });

    $('#classForm').on('submit', function (event) {
        event.preventDefault();
        clearFieldErrors(this);

        const form = this;
        const id = $('#editId').val();
        const normalHtml = id ? UPDATE_HTML : SAVE_HTML;
        let invalid = false;

        if (!$('#className').val().trim()) { setFieldError(form, 'class_name', 'Please enter the class name.'); invalid = true; }
        if (!$('#classGroup').val().trim()) { setFieldError(form, 'group', 'Please choose or enter a group.'); invalid = true; }
        if ($('#sortOrder').val() === '') { setFieldError(form, 'sort_order', 'Please enter a sort order.'); invalid = true; }

        if (invalid) return;

        const formData = new FormData(form);
        if (id) formData.append('_method', 'PUT');

        const button = $('#saveClassBtn');
        setBusy(button, true, id ? 'Updating...' : 'Saving...', normalHtml);

        $.ajax({
            url: id ? '/api/classes/' + encodeURIComponent(id) : '/api/classes',
            type: 'POST',
            headers: authHeaders(),
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('classModal')).hide();
                loadClasses();
                showNotice('success', response.message || (id ? 'Class updated successfully.' : 'Class added successfully.'));
            },
            error: function (xhr) {
                showServerErrors(form, xhr, id ? 'Unable to update the class. Please try again.' : 'Unable to add the class. Please try again.');
            },
            complete: function () {
                setBusy(button, false, '', normalHtml);
            }
        });
    });

    // ---------- Delete (always asks first) ----------
    $('#deleteClassModal').on('show.bs.modal', function (event) {
        const trigger = $(event.relatedTarget).closest('.delete-btn');
        const item = allClasses.find(c => String(c.id) === String(trigger.data('id')));

        $('#deleteClassId').val(trigger.data('id') || '');
        $('#deleteClassName').text(item ? item.class_name : 'This class');
    });

    $('#confirmDeleteClass').on('click', function () {
        const id = $('#deleteClassId').val();

        if (!id) {
            showNotice('error', 'Missing class. Close this window and try again.');
            return;
        }

        const button = $(this).prop('disabled', true).text('Deleting...');

        $.ajax({
            url: '/api/classes/' + encodeURIComponent(id),
            type: 'DELETE',
            headers: authHeaders(),
            success: function (response) {
                bootstrap.Modal.getOrCreateInstance(document.getElementById('deleteClassModal')).hide();
                loadClasses();
                showNotice('success', response.message || 'Class deleted successfully.');
            },
            error: function (xhr) {
                showNotice('error', getErrorMessage(xhr, 'Unable to delete the class. Please try again.'));
            },
            complete: function () {
                button.prop('disabled', false).text('Delete');
                $('#deleteClassId').val('');
            }
        });
    });

    $(document).ready(loadClasses);
</script>
@endpush