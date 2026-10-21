@extends('layouts.app')

@section('user-role', 'Platform Administrator')
@section('page-title', 'Permission Management')
@section('page-description', 'Control what each role can access and perform')

@section('sidebar')
    <div class="sidebar-section-label">Main</div>

    <a href="/superAdmin/permissions" class="nav-item active">
        <i class="bi bi-shield-lock"></i>
        <span>Permission Management</span>
    </a>

    <a href="#" id="profileLink" class="nav-item">
        <i class="bi bi-person-circle"></i>
        <span>Profile</span>
    </a>
@endsection

@section('content')
<div class="permission-page">
    <div class="permission-intro">
        <div>
            <h2>Role Access Control</h2>
            <p>Choose an actor, open a module, and manage individual actions.</p>
        </div>
        <div class="permission-summary">
            <i class="bi bi-shield-check"></i>
            <span>Role-based access</span>
        </div>
    </div>

    <div id="permissionMessage" class="mb-3" role="status" aria-live="polite"></div>

    <section class="permission-section">
        <div class="section-heading">
            <div>
                <h4>1. Select an actor</h4>
                <p>Choose the role whose permissions you want to configure.</p>
            </div>
            <span id="roleCount" class="permission-count">Loading roles...</span>
        </div>

        <div id="actorCards" class="actor-grid">
            <div class="permission-loading">
                <span class="spinner-border spinner-border-sm"></span>
                Loading roles...
            </div>
        </div>
    </section>

    <section id="permissionWorkspace" class="permission-section d-none">
        <div class="selected-role-header">
            <div class="selected-role-icon">
                <i class="bi bi-person-gear"></i>
            </div>
            <div class="selected-role-info">
                <span class="selected-role-label">CONFIGURING PERMISSIONS FOR</span>
                <h4 id="selectedRoleName">Selected Role</h4>
                <p id="selectedRoleDescription">Manage access to modules and actions.</p>
            </div>
            <button type="button" id="resetPermissionsBtn" class="btn btn-light border">
                <i class="bi bi-arrow-counterclockwise me-1"></i>
                Reset changes
            </button>
        </div>

        <div class="permission-toolbar">
            <div class="permission-search">
                <i class="bi bi-search"></i>
                <input type="search" id="permissionSearch"
                       placeholder="Search modules, submodules or actions..."
                       aria-label="Search permissions">
            </div>
            <span id="permissionTotal" class="text-muted small">0 actions</span>
        </div>

        <div id="permissionList">
            <div class="permission-empty">
                Select a role to load its permissions.
            </div>
        </div>

        <div class="permission-save-bar">
            <div>
                <strong id="selectedActionCount">0 actions enabled</strong>
                <p>Changes take effect after you save.</p>
            </div>
            <button type="button" id="savePermissionsBtn" class="btn btn-primary" disabled>
                <span class="save-button-text">
                    <i class="bi bi-check2-circle me-1"></i>
                    Save Permissions
                </span>
                <span class="save-button-loading d-none">
                    <span class="spinner-border spinner-border-sm me-1"></span>
                    Saving...
                </span>
            </button>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .permission-page {
        --permission-border: #e5e9f0;
        --permission-muted: #738096;
        --permission-text: #172338;
        --permission-surface: #ffffff;
        color: var(--permission-text);
    }

    .permission-intro {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 28px;
    }

    .permission-intro h2 {
        margin: 0 0 7px;
        font-size: 25px;
        font-weight: 750;
        letter-spacing: -.5px;
    }

    .permission-intro p,
    .section-heading p {
        color: var(--permission-muted);
        margin: 0;
        font-size: 14px;
    }

    .permission-summary {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border: 1px solid var(--permission-border);
        border-radius: 12px;
        background: var(--permission-surface);
        color: var(--permission-muted);
        font-size: 13px;
        white-space: nowrap;
    }

    .permission-summary i {
        color: #16805d;
        font-size: 17px;
    }

    .permission-section {
        margin-bottom: 26px;
    }

    .section-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 15px;
    }

    .section-heading h4 {
        font-size: 17px;
        font-weight: 750;
        margin: 0 0 5px;
    }

    .permission-count {
        color: var(--permission-muted);
        font-size: 12px;
        white-space: nowrap;
    }

    .actor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 14px;
    }

    .actor-card {
        position: relative;
        display: flex;
        align-items: center;
        gap: 13px;
        width: 100%;
        min-height: 105px;
        padding: 19px;
        text-align: left;
        background: var(--permission-surface);
        border: 1px solid var(--permission-border);
        border-radius: 15px;
        transition: border-color .2s, box-shadow .2s, transform .2s;
        cursor: pointer;
    }

    .actor-card:hover {
        border-color: #9baec6;
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(20, 35, 60, .06);
    }

    .actor-card.active {
        border: 2px solid var(--bs-primary, #2563eb);
        padding: 18px;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .07);
    }

    .actor-icon {
        display: grid;
        place-items: center;
        flex: 0 0 48px;
        height: 48px;
        border-radius: 13px;
        background: #eef3fa;
        color: #31557f;
        font-size: 22px;
    }

    .actor-card.active .actor-icon {
        background: #e7efff;
        color: #2457c5;
    }

    .actor-details {
        min-width: 0;
    }

    .actor-name {
        display: block;
        font-size: 14px;
        font-weight: 750;
        overflow-wrap: anywhere;
    }

    .actor-description {
        display: block;
        margin-top: 4px;
        font-size: 12px;
        color: var(--permission-muted);
    }

    .actor-check {
        margin-left: auto;
        color: #2563eb;
        font-size: 19px;
    }

    .selected-role-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 20px;
        margin-bottom: 18px;
        background: var(--permission-surface);
        border: 1px solid var(--permission-border);
        border-radius: 15px;
    }

    .selected-role-icon {
        display: grid;
        place-items: center;
        flex: 0 0 49px;
        height: 49px;
        background: #eef3fa;
        color: #31557f;
        border-radius: 13px;
        font-size: 23px;
    }

    .selected-role-info {
        flex: 1;
        min-width: 0;
    }

    .selected-role-label {
        display: block;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 1px;
        color: var(--permission-muted);
        margin-bottom: 4px;
    }

    .selected-role-info h4 {
        font-size: 19px;
        font-weight: 750;
        margin: 0 0 4px;
    }

    .selected-role-info p {
        font-size: 13px;
        color: var(--permission-muted);
        margin: 0;
    }

    .permission-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .permission-search {
        display: flex;
        align-items: center;
        gap: 9px;
        width: min(100%, 430px);
        padding: 0 13px;
        min-height: 43px;
        background: var(--permission-surface);
        border: 1px solid var(--permission-border);
        border-radius: 10px;
    }

    .permission-search i {
        color: var(--permission-muted);
    }

    .permission-search input {
        width: 100%;
        border: 0;
        outline: 0;
        background: transparent;
        font-size: 13px;
        color: inherit;
    }

    .module-card {
        background: var(--permission-surface);
        border: 1px solid var(--permission-border);
        border-radius: 13px;
        margin-bottom: 12px;
        overflow: hidden;
    }

    .module-header {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        padding: 17px 19px;
        border: 0;
        background: var(--permission-surface);
        text-align: left;
        color: inherit;
    }

    .module-header:hover {
        background: #f8fafc;
    }

    .module-icon {
        display: grid;
        place-items: center;
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border-radius: 10px;
        background: #f0f4fa;
        color: #35577f;
        font-size: 18px;
    }

    .module-title-wrap {
        flex: 1;
        min-width: 0;
    }

    .module-title {
        display: block;
        font-size: 14px;
        font-weight: 750;
    }

    .module-meta {
        display: block;
        margin-top: 3px;
        color: var(--permission-muted);
        font-size: 12px;
    }

    .module-chevron {
        color: var(--permission-muted);
        transition: transform .2s;
    }

    .module-header[aria-expanded="true"] .module-chevron {
        transform: rotate(180deg);
    }

    .module-body {
        padding: 0 17px 16px;
        border-top: 1px solid #edf0f5;
    }

    .submodule-card {
        margin-top: 14px;
        border: 1px solid var(--permission-border);
        border-radius: 11px;
        overflow: hidden;
    }

    .submodule-header {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 13px 15px;
        border: 0;
        background: #f8fafc;
        color: inherit;
        text-align: left;
    }

    .submodule-header:hover {
        background: #f1f5f9;
    }

    .submodule-title {
        flex: 1;
        font-size: 13px;
        font-weight: 700;
    }

    .submodule-meta {
        font-size: 11px;
        color: var(--permission-muted);
    }

    .submodule-body {
        padding: 5px 15px 10px;
    }

    .permission-action {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 12px 0;
        border-bottom: 1px solid #edf0f5;
    }

    .permission-action:last-child {
        border-bottom: 0;
    }

    .action-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
    }

    .action-key {
        display: block;
        margin-top: 3px;
        font-size: 11px;
        color: var(--permission-muted);
        overflow-wrap: anywhere;
    }

    .permission-switch {
        position: relative;
        flex: 0 0 42px;
        width: 42px;
        height: 24px;
    }

    .permission-switch input {
        position: absolute;
        opacity: 0;
        width: 1px;
        height: 1px;
    }

    .switch-track {
        position: absolute;
        inset: 0;
        border-radius: 30px;
        background: #cbd3df;
        cursor: pointer;
        transition: background .2s;
    }

    .switch-track::before {
        content: "";
        position: absolute;
        width: 18px;
        height: 18px;
        top: 3px;
        left: 3px;
        border-radius: 50%;
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, .15);
        transition: transform .2s;
    }

    .permission-switch input:checked + .switch-track {
        background: #16805d;
    }

    .permission-switch input:checked + .switch-track::before {
        transform: translateX(18px);
    }

    .permission-switch input:focus-visible + .switch-track {
        outline: 3px solid rgba(37, 99, 235, .25);
        outline-offset: 2px;
    }

    .permission-save-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-top: 18px;
        padding: 18px 20px;
        background: var(--permission-surface);
        border: 1px solid var(--permission-border);
        border-radius: 13px;
    }

    .permission-save-bar strong {
        font-size: 13px;
    }

    .permission-save-bar p {
        margin: 4px 0 0;
        color: var(--permission-muted);
        font-size: 12px;
    }

    .permission-save-bar .btn {
        min-height: 42px;
        padding: 9px 17px;
        font-size: 13px;
        font-weight: 650;
        white-space: nowrap;
    }

    .permission-empty,
    .permission-loading {
        padding: 30px 18px;
        text-align: center;
        color: var(--permission-muted);
        font-size: 13px;
    }

    .permission-loading {
        grid-column: 1 / -1;
    }

    .d-none {
        display: none !important;
    }

    @media (max-width: 700px) {
        .permission-intro,
        .selected-role-header {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .permission-summary {
            display: none;
        }

        .selected-role-header .btn {
            width: 100%;
        }

        .permission-toolbar {
            align-items: stretch;
            flex-direction: column;
        }

        .permission-search {
            width: 100%;
        }

        .permission-save-bar {
            align-items: stretch;
            flex-direction: column;
        }

        .permission-save-bar .btn {
            width: 100%;
        }

        .module-header {
            padding: 13px;
        }

        .module-body {
            padding: 0 10px 12px;
        }

        .submodule-body {
            padding: 4px 11px 8px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(function () {
    const permissionApi = '/api/permissions';

    let roles = [];
    let selectedRoleId = null;
    let originalAssignedIds = [];
    let currentAssignedIds = [];
    let currentPermissionGroups = {};
    let currentTree = {};
    let isSaving = false;

    const roleIcons = {
        'institute admin': 'bi-building',
        'teacher': 'bi-mortarboard',
        'student': 'bi-person-workspace'
    };

    function requestHeaders() {
        return {
            Authorization: 'Bearer ' + (localStorage.getItem('api_token') || ''),
            Accept: 'application/json'
        };
    }

    function showMessage(message, type = 'info') {
        const validTypes = ['success', 'danger', 'warning', 'info'];
        const safeType = validTypes.includes(type) ? type : 'info';

        $('#permissionMessage').empty().append(
            $('<div>')
                .addClass('alert alert-' + safeType + ' py-2')
                .text(message)
        );
    }

    function prettyLabel(value) {
        return String(value || '')
            .replace(/\.(?=[a-z])/gi, ' ')
            .replace(/[_-]+/g, ' ')
            .replace(/\s+/g, ' ')
            .trim()
            .replace(/\b\w/g, character => character.toUpperCase());
    }

    function normalizeName(value) {
        return String(value || '')
            .trim()
            .toLowerCase()
            .replace(/[\s-]+/g, '_');
    }

    function roleIcon(roleName) {
        return roleIcons[String(roleName || '').toLowerCase()] || 'bi-person-badge';
    }

    function getPermissionItems(permissionGroups) {
        const items = [];

        if (Array.isArray(permissionGroups)) {
            permissionGroups.forEach(permission => {
                if (permission && permission.id !== undefined) {
                    items.push({
                        ...permission,
                        module: permission.module || 'General'
                    });
                }
            });

            return items;
        }

        Object.keys(permissionGroups || {}).forEach(moduleName => {
            const permissions = permissionGroups[moduleName];

            if (!Array.isArray(permissions)) {
                return;
            }

            permissions.forEach(permission => {
                if (permission && permission.id !== undefined) {
                    items.push({
                        ...permission,
                        module: permission.module || moduleName
                    });
                }
            });
        });

        return items;
    }

    function actionParts(permission) {
        const rawName = String(permission.name || permission.title || '');
        const normalized = normalizeName(rawName);
        const knownActions = [
            'view', 'read', 'list', 'index', 'show',
            'create', 'store', 'add',
            'edit', 'update', 'modify',
            'delete', 'destroy', 'remove',
            'publish', 'unpublish', 'assign', 'manage',
            'export', 'import', 'download', 'upload',
            'attempt', 'submit', 'grade', 'approve',
            'restore', 'activate', 'deactivate'
        ];

        let submodule = 'General';
        let action = rawName || 'Permission';

        if (normalized.includes('.')) {
            const parts = normalized.split('.').filter(Boolean);

            if (parts.length >= 2) {
                if (knownActions.includes(parts[0])) {
                    action = parts[0] + (parts.length > 2 ? ' ' + parts.slice(2).join(' ') : '');
                    submodule = parts[1];
                } else {
                    submodule = parts[0];
                    action = parts.slice(1).join(' ');
                }
            }
        } else {
            const tokens = normalized.split('_').filter(Boolean);

            if (tokens.length >= 2 && knownActions.includes(tokens[0])) {
                action = tokens[0];
                submodule = tokens.slice(1).join('_');
            } else if (tokens.length >= 2 && knownActions.includes(tokens[tokens.length - 1])) {
                action = tokens[tokens.length - 1];
                submodule = tokens.slice(0, -1).join('_');
            } else {
                const leadingAction = knownActions.find(item =>
                    normalized.startsWith(item + '_')
                );

                if (leadingAction) {
                    action = leadingAction;
                    submodule = normalized.slice(leadingAction.length + 1);
                }
            }
        }

        if (permission.action) {
            action = permission.action;
        }

        if (permission.submodule) {
            submodule = permission.submodule;
        }

        if (permission.resource) {
            submodule = permission.resource;
        }

        return {
            submodule: prettyLabel(submodule),
            action: prettyLabel(action),
            key: rawName
        };
    }

    function buildPermissionTree(permissionGroups) {
        const items = getPermissionItems(permissionGroups);
        const tree = {};

        items.forEach(permission => {
            const moduleName = String(permission.module || 'General');
            const parts = actionParts(permission);

            if (!tree[moduleName]) {
                tree[moduleName] = {};
            }

            if (!tree[moduleName][parts.submodule]) {
                tree[moduleName][parts.submodule] = [];
            }

            tree[moduleName][parts.submodule].push({
                id: Number(permission.id),
                name: permission.name || permission.title || parts.action,
                description: permission.description || '',
                action: parts.action,
                key: parts.key
            });
        });

        return tree;
    }

    function renderActorCards() {
        const $container = $('#actorCards').empty();

        $('#roleCount').text(roles.length + (roles.length === 1 ? ' role' : ' roles'));

        if (!roles.length) {
            $container.html(
                $('<div>')
                    .addClass('permission-empty')
                    .text('No configurable roles were returned by the server.')
            );
            return;
        }

        roles.forEach(role => {
            const isActive = Number(role.id) === Number(selectedRoleId);
            const name = role.role_name || role.name || 'Unnamed role';

            const $card = $('<button>', {
                type: 'button',
                class: 'actor-card' + (isActive ? ' active' : ''),
                'aria-pressed': isActive ? 'true' : 'false'
            }).data('role-id', role.id);

            const $icon = $('<span>')
                .addClass('actor-icon')
                .append($('<i>').addClass('bi ' + roleIcon(name)));

            const $details = $('<span>').addClass('actor-details');

            $details.append(
                $('<span>').addClass('actor-name').text(name),
                $('<span>').addClass('actor-description').text('Configure role access')
            );

            $card.append($icon, $details);

            if (isActive) {
                $card.append(
                    $('<i>').addClass('bi bi-check-circle-fill actor-check')
                );
            }

            $container.append($card);
        });
    }

    function loadRoles() {
        $('#actorCards').html(
            '<div class="permission-loading"><span class="spinner-border spinner-border-sm me-2"></span>Loading roles...</div>'
        );

        $.ajax({
            url: permissionApi,
            method: 'GET',
            headers: requestHeaders(),

            success: function (response) {
                roles = Array.isArray(response.roles) ? response.roles : [];

                if (response.selected_role_id) {
                    selectedRoleId = Number(response.selected_role_id);
                } else if (roles.length) {
                    selectedRoleId = Number(roles[0].id);
                }

                renderActorCards();

                if (selectedRoleId) {
                    loadRolePermissions(selectedRoleId);
                } else {
                    $('#permissionWorkspace').addClass('d-none');
                    showMessage('No configurable roles are available.', 'warning');
                }
            },

            error: function (xhr) {
                $('#actorCards').empty().append(
                    $('<div>')
                        .addClass('permission-empty text-danger')
                        .text(xhr.responseJSON?.message || 'Unable to load roles. Check your login and API access.')
                );
                showMessage('Failed to load roles.', 'danger');
            }
        });
    }

    function loadRolePermissions(roleId) {
        selectedRoleId = Number(roleId);
        renderActorCards();

        $('#permissionWorkspace').removeClass('d-none');
        $('#permissionList').html(
            '<div class="permission-empty"><span class="spinner-border spinner-border-sm me-2"></span>Loading permissions...</div>'
        );
        $('#savePermissionsBtn').prop('disabled', true);
        $('#permissionSearch').val('');

        const role = roles.find(item => Number(item.id) === selectedRoleId);
        $('#selectedRoleName').text(role?.role_name || role?.name || 'Selected Role');
        $('#selectedRoleDescription').text('Configure the modules, submodules, and actions available to this role.');

        $.ajax({
            url: permissionApi + '?role_id=' + encodeURIComponent(selectedRoleId),
            method: 'GET',
            headers: requestHeaders(),

            success: function (response) {
                currentPermissionGroups = response.permissions || {};
                currentTree = buildPermissionTree(currentPermissionGroups);

                originalAssignedIds = (response.assigned_permission_ids || [])
                    .map(Number);

                currentAssignedIds = [...originalAssignedIds];

                renderPermissionTree();
                updateActionCount();

                $('#savePermissionsBtn').prop('disabled', false);
            },

            error: function (xhr) {
                $('#permissionList').empty().append(
                    $('<div>')
                        .addClass('permission-empty text-danger')
                        .text(xhr.responseJSON?.message || 'Unable to load this role’s permissions.')
                );
                showMessage('Failed to load permissions for this role.', 'danger');
            }
        });
    }

    function createActionSwitch(permission) {
        const checked = currentAssignedIds.includes(Number(permission.id));
        const switchId = 'permission-switch-' + permission.id;

        const $row = $('<div>').addClass('permission-action');

        const $labelWrap = $('<div>').addClass('flex-grow-1');
        $labelWrap.append(
            $('<span>').addClass('action-label').text(permission.action)
        );

        if (permission.description) {
            $labelWrap.append(
                $('<span>').addClass('action-key').text(permission.description)
            );
        } else if (permission.name) {
            $labelWrap.append(
                $('<span>').addClass('action-key').text(permission.name)
            );
        }

        const $switch = $('<label>').addClass('permission-switch');

        const $input = $('<input>', {
            type: 'checkbox',
            id: switchId,
            class: 'permission-toggle',
            value: permission.id,
            'aria-label': permission.action
        }).prop('checked', checked);

        const $track = $('<span>').addClass('switch-track');

        $switch.append($input, $track);
        $row.append($labelWrap, $switch);

        return $row;
    }

    function renderPermissionTree() {
        const $container = $('#permissionList').empty();
        const moduleNames = Object.keys(currentTree);

        if (!moduleNames.length) {
            $container.append(
                $('<div>')
                    .addClass('permission-empty')
                    .text('No permissions are available.')
            );
            $('#permissionTotal').text('0 actions');
            return;
        }

        let totalActions = 0;

        moduleNames.forEach((moduleName, moduleIndex) => {
            const submodules = currentTree[moduleName];
            const submoduleNames = Object.keys(submodules);
            const moduleActionCount = submoduleNames.reduce(
                (count, name) => count + submodules[name].length,
                0
            );

            totalActions += moduleActionCount;

            const moduleId = 'permission-module-' + moduleIndex;
            const $card = $('<div>').addClass('module-card permission-searchable');

            const $header = $('<button>', {
                type: 'button',
                class: 'module-header',
                'data-bs-toggle': 'collapse',
                'data-bs-target': '#' + moduleId,
                'aria-expanded': moduleIndex === 0 ? 'true' : 'false',
                'aria-controls': moduleId
            });

            $header.append(
                $('<span>').addClass('module-icon').append(
                    $('<i>').addClass('bi bi-folder2-open')
                )
            );

            const $titleWrap = $('<span>').addClass('module-title-wrap');
            $titleWrap.append(
                $('<span>').addClass('module-title').text(prettyLabel(moduleName)),
                $('<span>').addClass('module-meta').text(
                    submoduleNames.length + ' submodules · ' +
                    moduleActionCount + (moduleActionCount === 1 ? ' action' : ' actions')
                )
            );

            $header.append(
                $titleWrap,
                $('<i>').addClass('bi bi-chevron-down module-chevron')
            );

            const $body = $('<div>')
                .attr('id', moduleId)
                .addClass('collapse' + (moduleIndex === 0 ? ' show' : ''));

            const $moduleBody = $('<div>').addClass('module-body');

            submoduleNames.forEach((submoduleName, submoduleIndex) => {
                const actions = submodules[submoduleName];
                const submoduleId = moduleId + '-submodule-' + submoduleIndex;

                const $subCard = $('<div>').addClass('submodule-card permission-searchable');

                const $subHeader = $('<button>', {
                    type: 'button',
                    class: 'submodule-header',
                    'data-bs-toggle': 'collapse',
                    'data-bs-target': '#' + submoduleId,
                    'aria-expanded': 'false',
                    'aria-controls': submoduleId
                });

                $subHeader.append(
                    $('<i>').addClass('bi bi-folder2 text-secondary')
                );

                $subHeader.append(
                    $('<span>').addClass('submodule-title').text(submoduleName),
                    $('<span>').addClass('submodule-meta').text(
                        actions.length + (actions.length === 1 ? ' action' : ' actions')
                    ),
                    $('<i>').addClass('bi bi-chevron-down module-chevron')
                );

                const $subBody = $('<div>')
                    .attr('id', submoduleId)
                    .addClass('collapse');

                const $actionBody = $('<div>').addClass('submodule-body');

                actions.forEach(permission => {
                    $actionBody.append(createActionSwitch(permission));
                });

                $subBody.append($actionBody);
                $subCard.append($subHeader, $subBody);
                $moduleBody.append($subCard);
            });

            $body.append($moduleBody);
            $card.append($header, $body);
            $container.append($card);
        });

        $('#permissionTotal').text(totalActions + (totalActions === 1 ? ' action' : ' actions'));
        applyPermissionSearch();
    }

    function updateActionCount() {
        const enabledCount = $('#permissionList .permission-toggle:checked').length;
        $('#selectedActionCount').text(
            enabledCount + (enabledCount === 1 ? ' action enabled' : ' actions enabled')
        );
    }

    function applyPermissionSearch() {
        const query = String($('#permissionSearch').val() || '').trim().toLowerCase();

        $('#permissionList .module-card').each(function () {
            const $module = $(this);
            const moduleMatches = $module.find('.module-title').text().toLowerCase().includes(query);
            let hasVisibleSubmodule = false;

            $module.find('.submodule-card').each(function () {
                const $submodule = $(this);
                const submoduleMatches = $submodule.find('.submodule-title').text().toLowerCase().includes(query);
                let hasVisibleAction = false;

                $submodule.find('.permission-action').each(function () {
                    const $action = $(this);
                    const actionMatches = $action.text().toLowerCase().includes(query);
                    const visible = !query || moduleMatches || submoduleMatches || actionMatches;

                    $action.toggle(visible);

                    if (visible) {
                        hasVisibleAction = true;
                    }
                });

                const visibleSubmodule = !query || moduleMatches || submoduleMatches || hasVisibleAction;
                $submodule.toggle(visibleSubmodule);

                if (visibleSubmodule) {
                    hasVisibleSubmodule = true;
                }

                if (query && visibleSubmodule) {
                    $submodule.find('.collapse').addClass('show');
                    $submodule.find('.submodule-header').attr('aria-expanded', 'true');
                }
            });

            const visibleModule = !query || moduleMatches || hasVisibleSubmodule;
            $module.toggle(visibleModule);

            if (query && visibleModule) {
                $module.find('.module-body').parent('.collapse').addClass('show');
                $module.find('.module-header').attr('aria-expanded', 'true');
            }
        });
    }

    $('#actorCards').on('click', '.actor-card', function () {
        const roleId = Number($(this).data('role-id'));

        if (roleId !== selectedRoleId) {
            loadRolePermissions(roleId);
        }
    });

    $('#permissionList').on('change', '.permission-toggle', function () {
        const permissionId = Number($(this).val());

        if ($(this).is(':checked')) {
            if (!currentAssignedIds.includes(permissionId)) {
                currentAssignedIds.push(permissionId);
            }
        } else {
            currentAssignedIds = currentAssignedIds.filter(id => id !== permissionId);
        }

        updateActionCount();
    });

    $('#permissionSearch').on('input', applyPermissionSearch);

    $('#resetPermissionsBtn').on('click', function () {
        currentAssignedIds = [...originalAssignedIds];
        renderPermissionTree();
        updateActionCount();
        $('#permissionSearch').val('');
        showMessage('Unsaved changes have been reset.', 'info');
    });

    $('#savePermissionsBtn').on('click', function () {
        if (isSaving || !selectedRoleId) {
            return;
        }

        isSaving = true;

        const $button = $(this);
        $button.prop('disabled', true);
        $button.find('.save-button-text').addClass('d-none');
        $button.find('.save-button-loading').removeClass('d-none');

        $.ajax({
            url: permissionApi,
            method: 'PUT',
            headers: requestHeaders(),
            contentType: 'application/json',
            data: JSON.stringify({
                role_id: selectedRoleId,
                permission_ids: currentAssignedIds
            }),

            success: function (response) {
                originalAssignedIds = (response.assigned_permission_ids || currentAssignedIds)
                    .map(Number);

                currentAssignedIds = [...originalAssignedIds];

                renderPermissionTree();
                updateActionCount();

                showMessage(
                    response.message || 'Permissions saved successfully.',
                    'success'
                );
            },

            error: function (xhr) {
                showMessage(
                    xhr.responseJSON?.message || 'Unable to save permissions. Please try again.',
                    'danger'
                );
            },

            complete: function () {
                isSaving = false;
                $button.prop('disabled', false);
                $button.find('.save-button-text').removeClass('d-none');
                $button.find('.save-button-loading').addClass('d-none');
            }
        });
    });

    loadRoles();
});
</script>
@endpush