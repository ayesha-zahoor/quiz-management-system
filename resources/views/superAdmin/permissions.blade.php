{{-- ===================================================================
     PERMISSION MANAGEMENT - OPTION B: MATRIX
     Place at: resources/views/superAdmin/permissions.blade.php
     (or wherever your current permission Blade lives; it replaces it).
     Rows = modules, columns = action types (View, Create, Edit, ...).
     Columns appear ONLY if the API returned a permission of that type.
     API (unchanged): GET /api/permissions, GET /api/permissions?role_id=ID,
                      PUT /api/permissions  {role_id, permission_ids}
     NOTE: hiding items here is a UI convenience only. Real security
     must be enforced by your backend (CheckPermission + controllers).
     =================================================================== --}}
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
<div class="pb">

    <div id="permissionMessage" class="mb-3" role="status" aria-live="polite"></div>

    <div class="pb-top">
        <div>
            <h2 class="pb-h">Role access control</h2>
            <p class="pb-sub">One grid per role. Tick a box to allow that action; use the row or column box to tick many at once.</p>
        </div>
    </div>

    {{-- Role selector + search --}}
    <div class="pb-bar">
        <div class="pb-field">
            <label for="roleSelect" class="pb-label">Role</label>
            <select id="roleSelect" class="form-select" aria-label="Select a role"><option>Loading roles</option></select>
        </div>
        <div class="pb-field pb-grow" id="searchField">
            <label for="permissionSearch" class="pb-label">Search</label>
            <input type="search" id="permissionSearch" class="form-control" autocomplete="off"
                   placeholder="Module or action name" aria-label="Search permissions">
        </div>
        <div class="pb-summary">
            <strong id="statEnabled">0</strong><span id="statTotal">of 0 allowed</span>
        </div>
    </div>

    <div id="scopeNote" class="mb-3"></div>

    <section id="permissionWorkspace" class="d-none">
        {{-- The matrix scrolls inside this box; header row and first column stay pinned --}}
        <div class="pb-card">
            <div class="pb-scroll" id="matrixScroll">
                <table class="pb-table" id="matrix">
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="permissionNoMatch" class="pb-empty d-none">Nothing matches your search.</div>
        </div>

        <div id="saveBar" class="pb-savebar">
            <div class="pb-savebar-text">
                <strong id="saveHeadline">No changes yet</strong>
                <span id="saveDetail">Tick or untick a box to begin.</span>
            </div>
            <button type="button" id="resetPermissionsBtn" class="pb-btn" disabled>
                <i class="bi bi-arrow-counterclockwise"></i> Discard
            </button>
            <button type="button" id="savePermissionsBtn" class="pb-btn pb-btn-primary" disabled>
                <span class="save-button-text"><i class="bi bi-check2-circle"></i> Save permissions</span>
                <span class="save-button-loading d-none"><span class="spinner-border spinner-border-sm"></span> Saving</span>
            </button>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .pb { --ink:#14202e; --muted:#6b7a8d; --line:#e3e8ef; --paper:#fff; --wash:#f5f7fa; --accent:#1f5eff; --on:#12805c; --warn:#f0a30a; color:var(--ink); padding-bottom:30px; }
    .pb-h { font-size:21px; font-weight:700; letter-spacing:-.3px; margin:0 0 4px; }
    .pb-sub { margin:0 0 16px; color:var(--muted); font-size:14px; max-width:70ch; }

    .pb-bar { display:flex; flex-wrap:wrap; align-items:flex-end; gap:12px; margin-bottom:14px; }
    .pb-field { min-width:220px; }
    .pb-grow { flex:1; }
    .pb-label { display:block; font-size:12px; font-weight:600; color:var(--muted); margin-bottom:4px; }
    .pb .form-select, .pb .form-control { min-height:42px; border-radius:10px; border-color:var(--line); font-size:14px; }
    .pb-summary { padding:0 4px 8px; white-space:nowrap; }
    .pb-summary strong { font-size:24px; letter-spacing:-.5px; margin-right:6px; }
    .pb-summary span { color:var(--muted); font-size:13px; }

    .pb-card { background:var(--paper); border:1px solid var(--line); border-radius:14px; overflow:hidden; }
    /* both-direction scroll with pinned header + first column */
    .pb-scroll { max-height:calc(100vh - 340px); min-height:220px; overflow:auto; }
    .pb-table { border-collapse:separate; border-spacing:0; width:100%; min-width:640px; }
    .pb-table th, .pb-table td { padding:12px 14px; border-bottom:1px solid #edf0f5; vertical-align:middle; background:var(--paper); }
    .pb-table thead th { position:sticky; top:0; z-index:3; background:var(--wash); text-align:center; font-size:13px; font-weight:700; border-bottom:1px solid var(--line); white-space:nowrap; }
    .pb-table thead th:first-child { left:0; z-index:4; text-align:left; }
    .pb-rowhead { position:sticky; left:0; z-index:2; min-width:230px; text-align:left; border-right:1px solid var(--line); }
    .pb-rowhead-inner { display:flex; align-items:center; gap:10px; }
    .pb-rowhead-name { font-weight:650; font-size:14px; }
    .pb-rowhead-meta { display:block; font-size:12px; color:var(--muted); font-weight:400; }
    .pb-table tbody tr:hover td, .pb-table tbody tr:hover th { background:#fafbfd; }
    .pb-table td { text-align:center; }
    .pb-none { color:#c3ccd8; }

    .pb-colhead { display:flex; flex-direction:column; align-items:center; gap:6px; }
    .pb-colhead small { font-weight:500; color:var(--muted); font-size:11px; }

    /* checkbox cell */
    .pb-cell { display:inline-flex; align-items:center; gap:7px; margin:2px 0; padding:4px 8px; border-radius:8px; cursor:pointer; font-size:12px; text-align:left; border:1px solid transparent; }
    .pb-cell:hover { background:var(--wash); }
    .pb-cell.changed { background:#fff4de; border-color:#f3cf85; }
    .pb-stack { display:flex; flex-direction:column; align-items:flex-start; }
    .pb input[type=checkbox] { width:18px; height:18px; accent-color:var(--on); cursor:pointer; flex:0 0 auto; margin:0; }
    .pb input[type=checkbox]:focus-visible { outline:3px solid rgba(31,94,255,.35); outline-offset:2px; }

    .pb-empty { text-align:center; padding:36px 16px; color:var(--muted); font-size:14px; }
    .pb-btn { display:inline-flex; align-items:center; gap:6px; min-height:40px; padding:0 14px; background:var(--paper); border:1px solid var(--line); border-radius:10px; font-size:13px; font-weight:600; color:var(--ink); white-space:nowrap; }
    .pb-btn:hover:not(:disabled) { background:var(--wash); }
    .pb-btn:disabled { opacity:.45; cursor:not-allowed; }
    .pb-btn-primary { background:var(--accent); border-color:var(--accent); color:#fff; padding:0 18px; }
    .pb-btn-primary:hover:not(:disabled) { background:#1650e0; }
    .pb-btn-primary:disabled { background:#b9c4d6; border-color:#b9c4d6; }
    .pb button:focus-visible { outline:3px solid rgba(31,94,255,.3); outline-offset:2px; }

    .pb-savebar { position:sticky; bottom:14px; z-index:20; display:flex; align-items:center; gap:10px; margin-top:14px; padding:13px 16px; background:rgba(255,255,255,.94); backdrop-filter:blur(8px); border:1px solid var(--line); border-radius:14px; box-shadow:0 10px 30px rgba(20,32,46,.12); }
    .pb-savebar.dirty { border-color:#f0c36d; background:rgba(255,249,235,.96); }
    .pb-savebar-text { flex:1; min-width:0; }
    .pb-savebar-text strong { display:block; font-size:14px; }
    .pb-savebar-text span { font-size:12px; color:var(--muted); }
    .d-none { display:none !important; }

    @media (max-width:700px) {
        .pb-field { min-width:100%; }
        .pb-rowhead { min-width:150px; }
        .pb-scroll { max-height:calc(100vh - 300px); }
        .pb-savebar { flex-wrap:wrap; bottom:8px; }
        .pb-savebar-text { flex-basis:100%; }
        .pb-savebar .pb-btn { flex:1; justify-content:center; }
    }
</style>
@endpush

@push('scripts')
<script>
$(function () {
    const API = '/api/permissions';

    /* ------------------------------------------------------------------
       UI SCOPE MAP (assumption - verify against your seeder).
       m = module names as returned by the API (matched loosely)
       a = '*' (all actions) or verbs ('view' matches view_*) or exact permission names.
       Anything outside the map is hidden from the grid. This is NOT security.
       ------------------------------------------------------------------ */
    const SCOPE = {
        institute_admin: [
            { m: ['Classes', 'Subjects', 'Teachers', 'Students'], a: '*' }
        ],
        teacher: [
            { m: ['Quizzes', 'Questions', 'Options'], a: '*' },
            { m: ['Quiz Attempts', 'Results'], a: ['view'] },
            { m: ['Classes', 'Subjects'], a: ['view'] }
        ],
        student: [
            { m: ['Quizzes'], a: ['view'] },
            { m: ['Quiz Attempts'], a: ['view', 'take', 'submit'] },
            { m: ['Results'], a: ['view_own_results'] }
        ]
    };
    const LOCKED_ROLES = ['system_admin'];
    // Column order. A verb becomes a column only if the API returned such a permission.
    const VERB_ORDER = ['view', 'create', 'edit', 'delete', 'publish', 'unpublish', 'assign', 'manage', 'take', 'submit'];

    let roles = [], roleId = null, roleKey = '', rules = null;
    let items = [], orig = new Set(), cur = new Set(), saving = false;

    const norm = s => String(s || '').toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^_+|_+$/g, '');
    const pretty = s => String(s || '').replace(/[_-]+/g, ' ').replace(/\s+/g, ' ').trim().replace(/\b\w/g, c => c.toUpperCase());
    const hdr = () => ({ Authorization: 'Bearer ' + (localStorage.getItem('api_token') || ''), Accept: 'application/json' });

    function msg(text, type) {
        const t = ['success', 'danger', 'warning', 'info'].includes(type) ? type : 'info';
        const $a = $('<div>').addClass('alert alert-' + t + ' py-2 mb-0').text(text);
        $('#permissionMessage').empty().append($a);
        if (t === 'success') setTimeout(() => $a.fadeOut(300, () => $a.remove()), 4000);
    }

    function flatten(groups) {
        const out = [];
        const add = (p, m) => {
            if (!p || p.id === undefined) return;
            const name = String(p.name || p.title || '');
            const verb = name.split('_')[0];
            out.push({
                id: Number(p.id), name: name, module: String(p.module || m || 'General'),
                label: pretty(name), desc: String(p.description || '').trim(),
                verb: verb, col: VERB_ORDER.includes(verb) ? verb : 'other',
                rest: pretty(name.split('_').slice(1).join('_'))      // e.g. "teacher classes"
            });
        };
        if (Array.isArray(groups)) groups.forEach(p => add(p));
        else Object.keys(groups || {}).forEach(m => Array.isArray(groups[m]) && groups[m].forEach(p => add(p, m)));
        return out;
    }

    function inScope(p) {
        if (!rules) return true;
        const m = norm(p.module);
        return rules.some(r => r.m.some(x => norm(x) === m) &&
            (r.a === '*' || r.a.some(a => p.name === a || p.name.indexOf(a + '_') === 0)));
    }
    const visible = () => items.filter(inScope);
    function modules() {
        const map = new Map();
        visible().forEach(p => { if (!map.has(p.module)) map.set(p.module, []); map.get(p.module).push(p); });
        return Array.from(map.entries());
    }
    function columns() {
        const present = new Set(visible().map(p => p.col));
        return VERB_ORDER.filter(v => present.has(v)).concat(present.has('other') ? ['other'] : []);
    }
    function diff() {
        let added = 0, removed = 0;
        cur.forEach(id => { if (!orig.has(id)) added++; });
        orig.forEach(id => { if (!cur.has(id)) removed++; });
        return { added, removed, total: added + removed };
    }
    const q = () => String($('#permissionSearch').val() || '').trim().toLowerCase();

    /* ---------- roles ---------- */
    function loadRoles() {
        $.ajax({
            url: API, method: 'GET', headers: hdr(),
            success: function (res) {
                roles = Array.isArray(res.roles) ? res.roles : [];
                roleId = res.selected_role_id ? Number(res.selected_role_id) : (roles.length ? Number(roles[0].id) : null);
                const $s = $('#roleSelect').empty();
                roles.forEach(r => $s.append($('<option>').val(r.id).text(pretty(r.role_name || r.name || 'Unnamed role'))));
                if (roleId) { $s.val(roleId); loadRole(roleId); } else { $s.append($('<option>').text('No roles')); msg('No configurable roles are available.', 'warning'); }
            },
            error: function (xhr) {
                $('#roleSelect').empty().append($('<option>').text('Unavailable'));
                msg(xhr.responseJSON?.message || 'Could not load roles. Check your login and API access.', 'danger');
            }
        });
    }

    function loadRole(id) {
        roleId = Number(id);
        const role = roles.find(r => Number(r.id) === roleId) || {};
        roleKey = norm(role.role_name || role.name);
        $('#permissionWorkspace').removeClass('d-none');
        $('#matrix thead').empty();
        $('#matrix tbody').html('<tr><td class="pb-empty" colspan="9"><span class="spinner-border spinner-border-sm me-2"></span>Loading permissions</td></tr>');
        $('#permissionSearch').val('');
        $('#savePermissionsBtn, #resetPermissionsBtn').prop('disabled', true);

        $.ajax({
            url: API + '?role_id=' + encodeURIComponent(roleId), method: 'GET', headers: hdr(),
            success: function (res) {
                items = flatten(res.permissions || {});
                orig = new Set((res.assigned_permission_ids || []).map(Number));
                cur = new Set(orig);
                rules = SCOPE[roleKey] || null;
                renderScopeNote(); renderMatrix(); refresh();
            },
            error: function (xhr) {
                $('#matrix tbody').html('<tr><td class="pb-empty text-danger" colspan="9"></td></tr>').find('td').text(xhr.responseJSON?.message || 'Could not load this role’s permissions.');
                msg('Failed to load permissions for this role.', 'danger');
            }
        });
    }

    function renderScopeNote() {
        const $n = $('#scopeNote').empty();
        if (LOCKED_ROLES.includes(roleKey) || !roleKey) return;
        if (!rules) {
            $n.append($('<div>').addClass('alert alert-warning py-2 mb-0')
                .text('No scope rule is defined for “' + pretty(roleKey) + '” in this page, so every permission the API returned is shown. Add a rule to SCOPE if this role should be limited.'));
            return;
        }
        const hidden = items.filter(p => !inScope(p));
        const hiddenAssigned = hidden.filter(p => cur.has(p.id));
        const $box = $('<div>').addClass('alert py-2 mb-0 ' + (hiddenAssigned.length ? 'alert-warning' : 'alert-info'));
        $box.append($('<div>').text(modules().length + ' module(s) offered to this role. ' + hidden.length + ' permission(s) outside its responsibility are hidden.'));
        if (hiddenAssigned.length) {
            $box.append($('<div>').addClass('mt-1')
                .append($('<span>').text(hiddenAssigned.length + ' hidden permission(s) are currently assigned and will be kept on save. '))
                .append($('<a>', { href: '#', id: 'revokeHidden' }).text('Remove them on next save')));
        }
        $n.append($box);
    }

    /* ---------- matrix ---------- */
    function colToggle(col) {
        return $('<input>', { type: 'checkbox', class: 'pb-col-toggle', 'aria-label': 'Toggle every ' + pretty(col) + ' action' }).data('col', col);
    }

    function renderMatrix() {
        const $h = $('#matrix thead').empty(), $b = $('#matrix tbody').empty();

        if (LOCKED_ROLES.includes(roleKey)) {
            $b.append($('<tr>').append($('<td>', { colspan: 9, class: 'pb-empty' }).text('This role bypasses permission checks in the backend, so toggles do not apply.')));
            $('#statEnabled').text('–'); $('#statTotal').text('not applicable');
            return;
        }
        const cols = columns(), mods = modules();
        if (!mods.length) { $b.append($('<tr>').append($('<td>', { colspan: 9, class: 'pb-empty' }).text('No permissions are available for this role.'))); return; }

        const $hr = $('<tr>').append($('<th>').text('Module'));
        cols.forEach(c => $hr.append($('<th>').append($('<div>').addClass('pb-colhead').append($('<span>').text(pretty(c)), colToggle(c)))));
        $h.append($hr);

        mods.forEach(([name, perms]) => {
            const $tr = $('<tr>').addClass('pb-row').data('m', name).data('ids', perms.map(p => p.id))
                .data('search', (name + ' ' + perms.map(p => p.label + ' ' + p.name + ' ' + p.desc).join(' ')).toLowerCase());

            $tr.append($('<th>', { scope: 'row', class: 'pb-rowhead' }).append(
                $('<div>').addClass('pb-rowhead-inner').append(
                    $('<input>', { type: 'checkbox', class: 'pb-row-toggle', 'aria-label': 'Allow every action in ' + name }),
                    $('<div>').append($('<span>').addClass('pb-rowhead-name').text(name), $('<span>').addClass('pb-rowhead-meta pb-row-count')))));

            cols.forEach(c => {
                const cell = perms.filter(p => p.col === c);
                const $td = $('<td>').attr('data-col', c);
                if (!cell.length) { $td.append($('<span>').addClass('pb-none').text('–')); }
                else {
                    const $wrap = $('<div>').addClass(cell.length > 1 ? 'pb-stack' : '');
                    cell.forEach(p => {
                        const text = cell.length > 1 ? (c === 'other' ? p.label : p.rest) : (c === 'other' ? p.label : '');
                        $wrap.append($('<label>').addClass('pb-cell').attr('title', p.desc || p.name).attr('data-id', p.id).append(
                            $('<input>', { type: 'checkbox', class: 'pb-perm', value: p.id, 'aria-label': p.label }),
                            text ? $('<span>').text(text) : null));
                    });
                    $td.append($wrap);
                }
                $tr.append($td);
            });
            $b.append($tr);
        });
        applySearch();
    }

    function applySearch() {
        const query = q();
        let any = false;
        $('#matrix tbody .pb-row').each(function () {
            const show = !query || String($(this).data('search')).includes(query);
            $(this).toggle(show);
            if (show) any = true;
        });
        $('#permissionNoMatch').toggleClass('d-none', any || !$('#matrix tbody .pb-row').length);
        refresh();
    }

    function setTri($el, on, total) {
        $el.prop('checked', total > 0 && on === total).prop('indeterminate', on > 0 && on < total);
    }

    function refresh() {
        if (LOCKED_ROLES.includes(roleKey)) return;
        // cells
        $('#matrix .pb-perm').each(function () {
            const id = Number(this.value), on = cur.has(id);
            this.checked = on;
            $(this).closest('.pb-cell').toggleClass('changed', on !== orig.has(id));
        });
        // rows
        $('#matrix tbody .pb-row').each(function () {
            const ids = $(this).data('ids'), on = ids.filter(id => cur.has(id)).length;
            setTri($(this).find('.pb-row-toggle'), on, ids.length);
            $(this).find('.pb-row-count').text(on + ' of ' + ids.length + ' allowed');
        });
        // columns (only rows currently shown)
        $('#matrix .pb-col-toggle').each(function () {
            const col = $(this).data('col'), ids = [];
            $('#matrix tbody .pb-row:visible td[data-col="' + col + '"] .pb-perm').each(function () { ids.push(Number(this.value)); });
            setTri($(this), ids.filter(id => cur.has(id)).length, ids.length);
        });
        // totals
        const vis = visible(), en = vis.filter(p => cur.has(p.id)).length;
        $('#statEnabled').text(en); $('#statTotal').text('of ' + vis.length + ' allowed');
        // save bar
        const d = diff();
        $('#saveBar').toggleClass('dirty', d.total > 0);
        $('#saveHeadline').text(d.total ? d.total + (d.total === 1 ? ' unsaved change' : ' unsaved changes') : 'No changes yet');
        $('#saveDetail').text(d.total ? d.added + ' newly allowed, ' + d.removed + ' newly blocked. Ctrl+S saves.' : 'Tick or untick a box to begin.');
        $('#savePermissionsBtn').prop('disabled', !d.total || saving);
        $('#resetPermissionsBtn').prop('disabled', !d.total || saving);
    }

    function save() {
        if (saving || !roleId || !diff().total) return;
        saving = true;
        const $b = $('#savePermissionsBtn').prop('disabled', true);
        $b.find('.save-button-text').addClass('d-none'); $b.find('.save-button-loading').removeClass('d-none');
        $.ajax({
            url: API, method: 'PUT', headers: hdr(), contentType: 'application/json',
            data: JSON.stringify({ role_id: roleId, permission_ids: Array.from(cur) }),
            success: function (res) {
                orig = new Set((res.assigned_permission_ids || Array.from(cur)).map(Number));
                cur = new Set(orig);
                msg(res.message || 'Permissions saved successfully.', 'success');
                renderScopeNote();
            },
            error: function (xhr) { msg(xhr.responseJSON?.message || 'Could not save permissions. Please try again.', 'danger'); },
            complete: function () {
                saving = false;
                $b.find('.save-button-text').removeClass('d-none'); $b.find('.save-button-loading').addClass('d-none');
                refresh();
            }
        });
    }

    /* ---------- events ---------- */
    $('#roleSelect').on('change', function () {
        const id = Number(this.value);
        if (id === roleId) return;
        if (diff().total && !confirm('You have unsaved changes. Switch role and discard them?')) { $(this).val(roleId); return; }
        loadRole(id);
    });
    $('#matrix').on('change', '.pb-perm', function () {
        const id = Number(this.value);
        this.checked ? cur.add(id) : cur.delete(id);
        refresh();
    });
    $('#matrix').on('change', '.pb-row-toggle', function () {
        const on = this.checked;
        $(this).closest('.pb-row').data('ids').forEach(id => on ? cur.add(id) : cur.delete(id));
        refresh();
    });
    $('#matrix').on('change', '.pb-col-toggle', function () {
        const on = this.checked, col = $(this).data('col');
        $('#matrix tbody .pb-row:visible td[data-col="' + col + '"] .pb-perm').each(function () {
            const id = Number(this.value); on ? cur.add(id) : cur.delete(id);
        });
        refresh();
    });
    $('#scopeNote').on('click', '#revokeHidden', function (e) {
        e.preventDefault();
        items.filter(p => !inScope(p)).forEach(p => cur.delete(p.id));
        renderScopeNote(); refresh();
        msg('Out-of-scope permissions will be removed when you save.', 'info');
    });
    $('#permissionSearch').on('input', applySearch);
    $('#resetPermissionsBtn').on('click', function () { cur = new Set(orig); renderScopeNote(); refresh(); msg('Unsaved changes discarded.', 'info'); });
    $('#savePermissionsBtn').on('click', save);
    $(document).on('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's' && $('#permissionWorkspace').is(':visible')) { e.preventDefault(); save(); }
    });
    window.addEventListener('beforeunload', function (e) { if (diff().total) { e.preventDefault(); e.returnValue = ''; } });

    loadRoles();
});
</script>
@endpush