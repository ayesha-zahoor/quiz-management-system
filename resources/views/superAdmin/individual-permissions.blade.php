@extends('layouts.app')

@section('title', 'Individual Permissions')
@section('user-role', 'Platform Administrator')
@section('page-title', 'Individual Permissions')
@section('page-description', 'Block specific permissions for one user')

@section('sidebar')
    <div class="sidebar-section-label">Main</div>

    <a href="/superAdmin/permissions" class="nav-item">
        <i class="bi bi-shield-lock"></i>
        <span>Role Permissions</span>
    </a>

    <a href="/superAdmin/individual-permissions" class="nav-item active">
        <i class="bi bi-person-lock"></i>
        <span>Individual Permissions</span>
    </a>
@endsection

@section('content')

{{-- Step 1: choose a user --}}
<div class="content-card mb-4">
    <h5 class="mb-1">1. Choose a user</h5>
    <p class="text-muted small mb-3">
        You will see only the permissions that the user's role already has.
    </p>

    <div class="row g-3">
        <div class="col-md-3">
            <label for="roleFilter" class="form-label">Role</label>
            <select id="roleFilter" class="form-select">
                <option value="">All roles</option>
            </select>
        </div>

        <div class="col-md-4">
            <label for="userSearch" class="form-label">Search by name or email</label>
            <input type="text" id="userSearch" class="form-control" placeholder="Type to search" autocomplete="off">
        </div>

        <div class="col-md-5">
            <label for="userSelect" class="form-label">User</label>
            <select id="userSelect" class="form-select">
                <option value="">Select a user</option>
            </select>
            <div id="userCount" class="form-text"></div>
        </div>
    </div>

    <div id="message" class="alert mt-3 mb-0" role="status" hidden></div>
</div>

{{-- Step 2: permissions of that user's role --}}
<div class="content-card" id="permissionCard" hidden>
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
        <div>
            <h5 class="mb-1">2. Permissions for <span id="userName"></span></h5>
            <p class="text-muted small mb-0">
                Role: <span id="userRole" class="badge text-bg-light"></span>
                &nbsp;<span id="summary"></span>
            </p>
        </div>

        <button type="button" id="saveBtn" class="btn btn-navy" disabled>Save changes</button>
    </div>

    <div class="info-box mb-4">
        <b>On</b> means the user has this permission from their role.
        <b>Off</b> blocks it for this user only. Other users with the same role are not affected.
    </div>

    <div id="permissionList"></div>
</div>

@endsection

@push('styles')
<style>
.info-box {
    background: var(--lime-light);
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 13px;
}

.module-title {
    font-size: 14px;
    font-weight: 700;
    margin: 22px 0 6px;
}
.module-title:first-child { margin-top: 0; }

.perm-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    padding: 12px 0;
    border-bottom: 1px solid var(--slate-light);
}
.perm-name { font-size: 14px; font-weight: 600; }
.perm-desc { font-size: 12px; color: var(--slate); }

.perm-switch-wrap {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}
.perm-switch-wrap .form-check-input { width: 2.6em; height: 1.35em; cursor: pointer; }
.perm-switch-wrap .form-check-input:checked { background-color: var(--success); border-color: var(--success); }
.perm-state { width: 52px; font-size: 12px; font-weight: 600; color: var(--success); }
.perm-state.off { color: var(--danger); }
</style>
@endpush

@push('scripts')
<script>
$(function () {
    const token = localStorage.getItem('api_token');
    const headers = { Authorization: 'Bearer ' + token, Accept: 'application/json' };

    // "institute_admin" becomes "Institute admin"
    function roleName(role) {
        const text = String(role || 'No role').replace(/_/g, ' ');
        return text.charAt(0).toUpperCase() + text.slice(1);
    }

    // Fill the role filter once, using the roles that exist in the database
    function fillRoles(roles) {
        if ($('#roleFilter option').length > 1) return;

        roles.forEach(function (role) {
            $('#roleFilter').append($('<option>', { value: role, text: roleName(role) }));
        });
    }

    let users = [];
    let selectedUser = null;
    let searchTimer = null;

    // ---------- small helpers ----------

    function showMessage(text, type = 'danger') {
        $('#message')
            .removeClass('alert-danger alert-success')
            .addClass('alert-' + type)
            .text(text)
            .prop('hidden', false);
    }

    function hideMessage() {
        $('#message').prop('hidden', true);
    }

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function permissionLabel(p) {
        const text = String(p.name).replace(/_/g, ' ');
        return text.charAt(0).toUpperCase() + text.slice(1);
    }

    function updateSummary() {
        const total = $('.perm-switch').length;
        const on = $('.perm-switch:checked').length;
        $('#summary').text(`${on} of ${total} allowed`);
    }

    // ---------- 1. users ----------

    function loadUsers() {
        $.ajax({
            url: '/api/permission-users',
            headers: headers,
            data: {
                role: $('#roleFilter').val(),
                search: $('#userSearch').val().trim()
            },
            success: function (response) {
                users = response.data || [];
                fillRoles(response.roles || []);

                const $select = $('#userSelect').empty()
                    .append('<option value="">Select a user</option>');

                users.forEach(function (user) {
                    $select.append($('<option>', {
                        value: user.id,
                        text: user.name + ' (' + roleName(user.role) + ')'
                    }));
                });

                if (!users.length) {
                    $select.append('<option value="" disabled>No users found</option>');
                    $('#userCount').text('No users match this role and search.');
                } else {
                    hideMessage();
                    $('#userCount').text(
                        users.length === 1
                            ? '1 user found.'
                            : users.length + ' users found. Open the list to choose one.'
                    );

                    // Exactly one match for a typed search: select it for the admin
                    if (users.length === 1 && $('#userSearch').val().trim()) {
                        $select.val(String(users[0].id)).trigger('change');
                    }
                }
            },
            error: function (xhr) {
                // The status tells you what is wrong: 404 = route missing, 500 = server error
                showMessage(
                    'Could not load users (HTTP ' + xhr.status + '). ' +
                    (xhr.responseJSON?.message || '')
                );
            }
        });
    }

    $('#roleFilter').on('change', loadUsers);

    $('#userSearch').on('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(loadUsers, 300);
    });

    $('#userSelect').on('change', function () {
        hideMessage();

        selectedUser = users.find(u => String(u.id) === $(this).val());

        if (!selectedUser) {
            $('#permissionCard').prop('hidden', true);
            return;
        }

        loadPermissions(selectedUser);
    });

    // ---------- 2. permissions of the user's role ----------

    function loadPermissions(user) {
        $.ajax({
            url: '/api/users/' + user.id + '/permissions',
            headers: headers,
            success: function (response) {
                // Ignore the answer if another user was picked in the meantime
                if (!selectedUser || selectedUser.id !== user.id) return;

                const permissions = response.permissions || [];
                const blocked = (response.blocked || []).map(Number);

                $('#userName').text(user.name);
                $('#userRole').text(roleName(user.role));

                renderPermissions(permissions, blocked);
                updateSummary();

                $('#saveBtn').prop('disabled', true);
                $('#permissionCard').prop('hidden', false);
            },
            error: function (xhr) {
                $('#permissionCard').prop('hidden', true);
                showMessage(xhr.responseJSON?.message || 'Could not load permissions.');
            }
        });
    }

    function renderPermissions(permissions, blocked) {
        if (!permissions.length) {
            $('#permissionList').html(
                '<p class="text-muted mb-0">This role has no permissions yet. ' +
                'Add some on the Role Permissions page first.</p>'
            );
            return;
        }

        // Group by module
        const groups = {};
        permissions.forEach(function (p) {
            const module = p.module || 'Other';
            (groups[module] = groups[module] || []).push(p);
        });

        let html = '';

        Object.keys(groups).forEach(function (module) {
            html += '<div class="module-title">' + escapeHtml(module) + '</div>';

            groups[module].forEach(function (p) {
                const isOn = !blocked.includes(Number(p.id));

                html += `
                    <div class="perm-row">
                        <div>
                            <div class="perm-name">${escapeHtml(permissionLabel(p))}</div>
                            <div class="perm-desc">${escapeHtml(p.description || p.name)}</div>
                        </div>
                        <div class="perm-switch-wrap form-check form-switch">
                            <span class="perm-state ${isOn ? '' : 'off'}">${isOn ? 'On' : 'Off'}</span>
                            <input class="form-check-input perm-switch" type="checkbox" role="switch"
                                   data-id="${p.id}" ${isOn ? 'checked' : ''}
                                   aria-label="${escapeHtml(permissionLabel(p))}">
                        </div>
                    </div>`;
            });
        });

        $('#permissionList').html(html);
    }

    // Flip a switch
    $('#permissionList').on('change', '.perm-switch', function () {
        const on = this.checked;

        $(this).siblings('.perm-state')
            .text(on ? 'On' : 'Off')
            .toggleClass('off', !on);

        updateSummary();
        $('#saveBtn').prop('disabled', false);
    });

    // ---------- 3. save ----------

    $('#saveBtn').on('click', function () {
        if (!selectedUser) return;

        // Every switch that is OFF is sent as "blocked"
        const blocked = $('.perm-switch:not(:checked)')
            .map(function () { return Number($(this).data('id')); })
            .get();

        const btn = this;
        setButtonLoading(btn, true, 'Saving...');

        $.ajax({
            url: '/api/users/' + selectedUser.id + '/permissions',
            method: 'PUT',
            headers: headers,
            contentType: 'application/json',
            data: JSON.stringify({ blocked: blocked }),
            success: function () {
                showMessage('Permissions saved for ' + selectedUser.name + '.', 'success');
                $('#saveBtn').prop('disabled', true);
            },
            error: function (xhr) {
                showMessage(xhr.responseJSON?.message || 'Could not save. Please try again.');
                $('#saveBtn').prop('disabled', false);
            },
            complete: function () {
                // setButtonLoading(false) re-enables the button, so set it again after
                const stillDisabled = $('#saveBtn').prop('disabled');
                setButtonLoading(btn, false);
                $('#saveBtn').prop('disabled', stillDisabled);
            }
        });
    });

    // ---------- start ----------

    if (!token) {
        showMessage('Your session has expired. Please log in again.');
        return;
    }

    loadUsers();
});
</script>
@endpush