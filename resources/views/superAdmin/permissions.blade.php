{{-- ===================================================================
     PERMISSION MANAGEMENT - MATRIX (v3)
     Place at: resources/views/superAdmin/permissions.blade.php  (replaces the old file)
     - One checkbox per module + action. If several permissions share an action
       (e.g. assign_teacher_classes + assign_teacher_subjects) they are controlled
       together by ONE "Assign" box.
     API (unchanged): GET /api/permissions, GET /api/permissions?role_id=ID,
                      PUT /api/permissions  {role_id, permission_ids}
     NOTE: this page only stores permissions. Real enforcement must be done by
     the backend (CheckPermission middleware / controllers).
     =================================================================== --}}
@extends('layouts.app')

@section('user-role', 'Platform Administrator')
@section('page-title', 'Permission Management')
@section('page-description', 'Control what each role can access and perform')

@section('sidebar')
    <div class="sidebar-section-label">Main</div>
    <a href="/superAdmin/dashboard" class="nav-item">
        <i class="bi bi-grid-1x2-fill"></i>
        <span>Dashboard</span>
    </a>
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
        <h2 class="pb-h">Role access control</h2>
        <p class="pb-sub">Pick a role, then tick what it is allowed to do in each module. Use the box in a row or column header to tick many at once.</p>
    </div>

    {{-- Toolbar --}}
    <div class="pb-toolbar">
        <div class="pb-field">
            <label for="roleSelect" class="pb-label">Role</label>
            <select id="roleSelect" class="form-select" aria-label="Select a role"><option>Loading roles</option></select>
        </div>
        <div class="pb-field pb-grow" id="searchField">
            <label for="permissionSearch" class="pb-label">Search</label>
            <div class="pb-search">
                <i class="bi bi-search"></i>
                <input type="search" id="permissionSearch" class="form-control" autocomplete="off"
                       placeholder="Search module or action" aria-label="Search permissions">
            </div>
        </div>
        <div class="pb-summary" title="Permissions allowed for this role">
            <strong id="statEnabled">0</strong><span id="statTotal">of 0 allowed</span>
        </div>
    </div>

    <div id="scopeNote" class="mb-3"></div>

    <section id="permissionWorkspace" class="d-none">
        <div class="pb-card">
            <div class="pb-cardbar">
                <div class="pb-seg" role="group" aria-label="Filter modules">
                    <button type="button" class="active" data-f="all">All</button>
                    <button type="button" data-f="some">Has access</button>
                    <button type="button" data-f="none">No access</button>
                </div>
                <div class="pb-legend">
                    <span><i class="pb-dot pb-dot-on"></i>Allowed</span>
                    <span><i class="pb-dot pb-dot-part"></i>Partly</span>
                    <span><i class="pb-dot pb-dot-chg"></i>Unsaved</span>
                </div>
                <div class="pb-bulk">
                    <button type="button" id="allowAllBtn" class="pb-btn pb-btn-sm"><i class="bi bi-check2-all"></i> Allow all shown</button>
                    <button type="button" id="clearAllBtn" class="pb-btn pb-btn-sm"><i class="bi bi-x-lg"></i> Clear all shown</button>
                </div>
            </div>

            <div class="pb-scroll" id="matrixScroll">
                <table class="pb-table" id="matrix">
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="permissionNoMatch" class="pb-empty d-none">
                <i class="bi bi-search"></i>
                <div>No modules match your search or filter.</div>
            </div>
        </div>

        <div id="saveBar" class="pb-savebar">
            <div class="pb-savebar-icon"><i class="bi bi-pencil-square"></i></div>
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
    .pb {
        --ink:#14202e; --muted:#6b7a8d; --line:#e3e8ef; --line-soft:#eef1f6;
        --paper:#fff; --wash:#f6f8fb; --accent:#1f5eff; --accent-soft:#eaf0ff;
        --on:#12805c; --on-soft:#e7f6ef; --on-line:#bfe3d2;
        --warn:#f0a30a; --warn-bg:#fff6e0; --warn-line:#f2cf80;
        color:var(--ink); padding-bottom:40px;
    }
    .pb-h { font-size:22px; font-weight:700; letter-spacing:-.3px; margin:0 0 4px; }
    .pb-sub { margin:0 0 20px; color:var(--muted); font-size:14px; max-width:72ch; }

    /* ---------- toolbar ---------- */
    .pb-toolbar { display:flex; flex-wrap:wrap; align-items:flex-end; gap:14px; margin-bottom:16px; }
    .pb-field { min-width:230px; }
    .pb-grow { flex:1; min-width:240px; }
    .pb-label { display:block; font-size:11px; font-weight:700; color:var(--muted); margin-bottom:6px; text-transform:uppercase; letter-spacing:.06em; }
    .pb .form-select, .pb .form-control {
        min-height:44px; border-radius:10px; border:1px solid var(--line); font-size:14px; background-color:var(--paper);
        box-shadow:none; transition:border-color .15s, box-shadow .15s;
    }
    .pb .form-select:focus, .pb .form-control:focus { border-color:var(--accent); box-shadow:0 0 0 3px rgba(31,94,255,.15); }
    .pb-search { position:relative; }
    .pb-search i { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:var(--muted); pointer-events:none; }
    .pb-search .form-control { padding-left:40px; }

    .pb-summary {
        display:inline-flex; align-items:baseline; gap:8px; height:44px; padding:0 16px; align-self:flex-end;
        background:var(--on-soft); border:1px solid var(--on-line); border-radius:10px; white-space:nowrap;
    }
    .pb-summary strong { font-size:20px; color:var(--on); letter-spacing:-.3px; }
    .pb-summary span { color:#2f6b55; font-size:13px; font-weight:500; }

    /* ---------- scope note ---------- */
    #scopeNote .alert { font-size:13px; border-radius:10px; padding:10px 14px !important; border:1px solid; }
    #scopeNote .alert-info { background:var(--accent-soft); border-color:#cddcff; color:#2a4a9a; }
    #scopeNote .alert-warning { background:var(--warn-bg); border-color:var(--warn-line); color:#7a5600; }
    #scopeNote a { font-weight:600; text-decoration:underline; }

    /* ---------- card ---------- */
    .pb-card { background:var(--paper); border:1px solid var(--line); border-radius:16px; overflow:hidden; box-shadow:0 1px 2px rgba(20,32,46,.04); }
    .pb-cardbar { display:flex; flex-wrap:wrap; align-items:center; gap:14px; padding:12px 16px; border-bottom:1px solid var(--line); background:var(--paper); }
    .pb-seg { display:inline-flex; background:var(--wash); border:1px solid var(--line); border-radius:10px; padding:3px; }
    .pb-seg button { border:0; background:transparent; padding:6px 13px; border-radius:8px; font-size:13px; font-weight:600; color:var(--muted); }
    .pb-seg button:hover { color:var(--ink); }
    .pb-seg button.active { background:var(--paper); color:var(--ink); box-shadow:0 1px 3px rgba(20,32,46,.12); }
    .pb-legend { display:flex; gap:14px; font-size:12px; color:var(--muted); flex:1; flex-wrap:wrap; }
    .pb-legend span { display:inline-flex; align-items:center; gap:6px; }
    .pb-dot { width:10px; height:10px; border-radius:3px; display:inline-block; }
    .pb-dot-on { background:var(--on); } .pb-dot-part { background:var(--on); opacity:.55; } .pb-dot-chg { background:var(--warn-bg); border:1.5px solid var(--warn); }
    .pb-bulk { display:flex; gap:8px; }

    .pb-scroll { overflow-x:auto; overflow-y:visible; }
    .pb-table { border-collapse:separate; border-spacing:0; width:100%; min-width:680px; }
    .pb-table th, .pb-table td { padding:14px 12px; border-bottom:1px solid var(--line-soft); vertical-align:middle; background:var(--paper); }
    .pb-table tbody tr:last-child th, .pb-table tbody tr:last-child td { border-bottom:0; }
    .pb-table thead th {
        background:var(--wash); text-align:center; font-size:11px; font-weight:700; color:#41536b;
        text-transform:uppercase; letter-spacing:.07em; border-bottom:1px solid var(--line); white-space:nowrap; min-width:110px;
    }
    .pb-table thead th:first-child { text-align:left; min-width:270px; position:sticky; left:0; z-index:3; }
    .pb-colhead { display:flex; flex-direction:column; align-items:center; gap:8px; }

    .pb-rowhead { position:sticky; left:0; z-index:2; min-width:270px; text-align:left; border-right:1px solid var(--line); }
    .pb-rowhead-inner { display:flex; align-items:center; gap:12px; }
    .pb-icon { width:38px; height:38px; border-radius:10px; background:var(--accent-soft); color:var(--accent); display:grid; place-items:center; font-size:17px; flex:0 0 auto; }
    .pb-rowhead-text { min-width:0; flex:1; }
    .pb-rowhead-name { display:block; font-weight:650; font-size:14px; line-height:1.3; }
    .pb-rowhead-meta { display:block; font-size:12px; color:var(--muted); font-weight:400; margin-top:1px; }
    .pb-meter { display:block; height:4px; width:100%; max-width:130px; margin-top:7px; border-radius:99px; background:var(--line); overflow:hidden; }
    .pb-meter i { display:block; height:100%; width:0; background:var(--on); border-radius:99px; transition:width .2s ease; }

    .pb-table tbody tr:hover th, .pb-table tbody tr:hover td { background:#fafcff; }
    .pb-table td { text-align:center; }
    .pb-none { color:#ccd4df; font-size:14px; user-select:none; }

    /* ---------- checkboxes ---------- */
    .pb input[type=checkbox] {
        -webkit-appearance:none; appearance:none; flex:0 0 auto; margin:0; width:20px; height:20px;
        border:1.8px solid #b4c0d0; border-radius:6px; background:#fff no-repeat center / 78%;
        cursor:pointer; transition:background-color .12s, border-color .12s;
    }
    .pb input[type=checkbox]:hover { border-color:var(--on); }
    .pb input[type=checkbox]:checked {
        background-color:var(--on); border-color:var(--on);
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath d='M3.5 8.5l3 3 6-7' fill='none' stroke='white' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
    }
    .pb input[type=checkbox]:indeterminate {
        background-color:var(--on); border-color:var(--on);
        background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath d='M4 8h8' fill='none' stroke='white' stroke-width='2.2' stroke-linecap='round'/%3E%3C/svg%3E");
    }
    .pb input[type=checkbox]:focus-visible { outline:3px solid rgba(31,94,255,.35); outline-offset:2px; }

    /* one clickable tile per module + action */
    .pb-cell { display:inline-flex; align-items:center; gap:8px; padding:6px; border-radius:10px; cursor:pointer; border:1px solid transparent; transition:background .12s, border-color .12s; margin:0; }
    .pb-cell:hover { background:var(--wash); }
    .pb-cell.changed { background:var(--warn-bg); border-color:var(--warn-line); }

    /* merged tile: one box + caption of what it covers */
    .pb-merged { flex-direction:column; gap:5px; padding:8px 10px; min-width:96px; }
    .pb-merged.on { background:var(--on-soft); border-color:var(--on-line); }
    .pb-merged.changed { background:var(--warn-bg); border-color:var(--warn-line); }
    .pb-merged .pb-cap { font-size:11px; line-height:1.25; color:var(--muted); font-weight:500; max-width:130px; text-align:center; }

    /* "other" permissions stay as individual chips */
    .pb-stack { display:flex; flex-wrap:wrap; justify-content:center; gap:6px; }
    .pb-chip { padding:6px 12px 6px 8px; border:1px solid var(--line); background:var(--paper); border-radius:999px; font-size:13px; font-weight:500; }
    .pb-chip.on { background:var(--on-soft); border-color:var(--on-line); }
    .pb-chip.changed { background:var(--warn-bg); border-color:var(--warn-line); }

    .pb-empty { text-align:center; padding:44px 16px; color:var(--muted); font-size:14px; }
    .pb-empty i { display:block; font-size:26px; margin-bottom:8px; opacity:.5; }
    td.pb-empty, .pb-table td.pb-empty { text-align:center; }

    /* ---------- buttons ---------- */
    .pb-btn { display:inline-flex; align-items:center; justify-content:center; gap:7px; min-height:42px; padding:0 16px; background:var(--paper); border:1px solid var(--line); border-radius:10px; font-size:13px; font-weight:600; color:var(--ink); white-space:nowrap; transition:background .12s; }
    .pb-btn-sm { min-height:34px; padding:0 12px; font-size:12px; }
    .pb-btn:hover:not(:disabled) { background:var(--wash); }
    .pb-btn:disabled { opacity:.5; cursor:not-allowed; }
    .pb-btn-primary { background:var(--accent); border-color:var(--accent); color:#fff; padding:0 20px; }
    .pb-btn-primary:hover:not(:disabled) { background:#1650e0; }
    .pb-btn-primary:disabled { background:#aebcd6; border-color:#aebcd6; opacity:1; }
    .pb button:focus-visible { outline:3px solid rgba(31,94,255,.3); outline-offset:2px; }

    /* ---------- save bar ---------- */
    .pb-savebar {
        position:sticky; bottom:16px; z-index:20; display:flex; align-items:center; gap:10px;
        margin-top:18px; padding:12px 16px; background:rgba(255,255,255,.96); backdrop-filter:blur(8px);
        border:1px solid var(--line); border-radius:14px; box-shadow:0 8px 28px rgba(20,32,46,.10); transition:background .2s, border-color .2s;
    }
    .pb-savebar-icon { width:36px; height:36px; border-radius:10px; background:var(--wash); color:var(--muted); display:grid; place-items:center; flex:0 0 auto; }
    .pb-savebar.dirty { border-color:var(--warn-line); background:rgba(255,248,230,.97); }
    .pb-savebar.dirty .pb-savebar-icon { background:var(--warn-bg); color:#a86f00; }
    .pb-savebar-text { flex:1; min-width:0; }
    .pb-savebar-text strong { display:block; font-size:14px; }
    .pb-savebar-text span { font-size:12px; color:var(--muted); }
    .d-none { display:none !important; }

    @media (max-width:760px) {
        .pb-field, .pb-grow { min-width:100%; }
        .pb-summary { width:100%; justify-content:center; }
        .pb-cardbar { gap:10px; }
        .pb-legend { display:none; }
        .pb-bulk { width:100%; } .pb-bulk .pb-btn { flex:1; }
        .pb-table th, .pb-table td { padding:12px 8px; }
        .pb-rowhead, .pb-table thead th:first-child { min-width:170px; }
        .pb-icon, .pb-meter { display:none; }
        .pb-savebar { flex-wrap:wrap; bottom:8px; }
        .pb-savebar-icon { display:none; }
        .pb-savebar-text { flex-basis:100%; }
        .pb-savebar .pb-btn { flex:1; }
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
            { m: ['Classes', 'Subjects', 'Teachers', 'Students'], a: '*' },
            { m: ['Results'], a: ['view_results', 'view_reports'] }
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
    const VERB_ORDER = ['view', 'create', 'edit', 'delete', 'publish', 'unpublish', 'assign', 'manage', 'take', 'submit'];
    const ICONS = {
        classes: 'bi-easel2', subjects: 'bi-book', teachers: 'bi-person-workspace', students: 'bi-mortarboard',
        results: 'bi-bar-chart-line', quizzes: 'bi-patch-question', questions: 'bi-question-circle',
        options: 'bi-ui-checks', quiz_attempts: 'bi-pencil-square'
    };

    let roles = [], roleId = null, roleKey = '', rules = null, filter = 'all';
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
                rest: pretty(name.split('_').slice(1).join('_'))
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
    const countOn = ids => ids.filter(id => cur.has(id)).length;

    /* "Teacher Classes" + "Teacher Subjects"  ->  "Classes + Subjects" */
    function caption(cell) {
        const t = cell.map(p => p.rest.split(' ').filter(Boolean));
        let k = 0;
        while (t.every(a => a.length > k + 1 && a[k] === t[0][k])) k++;
        return t.map(a => a.slice(k).join(' ')).join(' + ');
    }

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
        filter = 'all'; $('.pb-seg button').removeClass('active').filter('[data-f="all"]').addClass('active');
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

    /* one checkbox that controls one OR several permission ids */
    function cellBox(ids, text, cls, title, aria) {
        const $i = $('<input>', { type: 'checkbox', class: 'pb-box', 'aria-label': aria }).data('ids', ids);
        return $('<label>').addClass('pb-cell ' + cls).attr('title', title)
            .append($i, text ? $('<span>').addClass('pb-cap').text(text) : null);
    }

    function renderMatrix() {
        const $h = $('#matrix thead').empty(), $b = $('#matrix tbody').empty();

        if (LOCKED_ROLES.includes(roleKey)) {
            $b.append($('<tr>').append($('<td>', { colspan: 9, class: 'pb-empty' }).text('This role bypasses permission checks in the backend, so toggles do not apply.')));
            $('#statEnabled').text('–'); $('#statTotal').text('not applicable');
            $('.pb-cardbar').addClass('d-none');
            return;
        }
        $('.pb-cardbar').removeClass('d-none');
        const cols = columns(), mods = modules();
        if (!mods.length) { $b.append($('<tr>').append($('<td>', { colspan: 9, class: 'pb-empty' }).text('No permissions are available for this role.'))); return; }

        const $hr = $('<tr>').append($('<th>').text('Module'));
        cols.forEach(c => $hr.append($('<th>').append($('<div>').addClass('pb-colhead').append($('<span>').text(pretty(c)), colToggle(c)))));
        $h.append($hr);

        mods.forEach(([name, perms]) => {
            const allIds = perms.map(p => p.id);
            const $tr = $('<tr>').addClass('pb-row').data('ids', allIds)
                .data('search', (name + ' ' + perms.map(p => p.label + ' ' + p.name + ' ' + p.desc).join(' ')).toLowerCase());

            $tr.append($('<th>', { scope: 'row', class: 'pb-rowhead' }).append(
                $('<div>').addClass('pb-rowhead-inner').append(
                    $('<span>').addClass('pb-icon').append($('<i>').addClass('bi ' + (ICONS[norm(name)] || 'bi-folder2'))),
                    $('<div>').addClass('pb-rowhead-text').append(
                        $('<span>').addClass('pb-rowhead-name').text(name),
                        $('<span>').addClass('pb-rowhead-meta pb-row-count'),
                        $('<span>').addClass('pb-meter').append($('<i>'))),
                    $('<input>', { type: 'checkbox', class: 'pb-row-toggle', 'aria-label': 'Allow every action in ' + name, title: 'Allow / block everything in ' + name }))));

            cols.forEach(c => {
                const cell = perms.filter(p => p.col === c);
                const $td = $('<td>').attr('data-col', c);
                if (!cell.length) {
                    $td.append($('<span>').addClass('pb-none').attr('title', 'Not available for this module').text('–'));
                } else if (c === 'other') {
                    const $wrap = $('<div>').addClass('pb-stack');
                    cell.forEach(p => $wrap.append(cellBox([p.id], p.label, 'pb-chip', p.desc || p.name, p.label)));
                    $td.append($wrap);
                } else if (cell.length > 1) {
                    const cap = caption(cell);
                    $td.append(cellBox(cell.map(p => p.id), cap, 'pb-merged',
                        cell.map(p => p.label).join(' + '),
                        pretty(c) + ' ' + name + ': ' + cap));
                } else {
                    const p = cell[0];
                    $td.append(cellBox([p.id], '', '', p.desc || p.label, p.label));
                }
                $tr.append($td);
            });
            $b.append($tr);
        });
        applySearch();
    }

    /* search + filter decide which rows are shown (evaluated on input / filter click, not on every tick) */
    function applySearch() {
        const query = q();
        let any = false;
        $('#matrix tbody .pb-row').each(function () {
            const ids = $(this).data('ids'), on = countOn(ids);
            let show = !query || String($(this).data('search')).includes(query);
            if (show && filter === 'some') show = on > 0;
            if (show && filter === 'none') show = on === 0;
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
        // cells (each controls 1+ permission ids)
        $('#matrix .pb-box').each(function () {
            const ids = $(this).data('ids'), on = countOn(ids);
            setTri($(this), on, ids.length);
            const changed = ids.some(id => cur.has(id) !== orig.has(id));
            $(this).closest('.pb-cell').toggleClass('on', on === ids.length).toggleClass('changed', changed);
        });
        // rows
        $('#matrix tbody .pb-row').each(function () {
            const ids = $(this).data('ids'), on = countOn(ids);
            setTri($(this).find('.pb-row-toggle'), on, ids.length);
            $(this).find('.pb-row-count').text(on + ' of ' + ids.length + ' allowed');
            $(this).find('.pb-meter i').css('width', ids.length ? (on / ids.length * 100) + '%' : '0%');
        });
        // columns (only rows currently shown)
        $('#matrix .pb-col-toggle').each(function () {
            const col = $(this).data('col'), ids = [];
            $('#matrix tbody .pb-row:visible td[data-col="' + col + '"] .pb-box').each(function () {
                $(this).data('ids').forEach(id => ids.push(id));
            });
            setTri($(this), countOn(ids), ids.length);
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

    function visibleIds() {
        const ids = [];
        $('#matrix tbody .pb-row:visible').each(function () { $(this).data('ids').forEach(id => ids.push(id)); });
        return ids;
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
    // one box -> every permission id it controls
    $('#matrix').on('change', '.pb-box', function () {
        const on = this.checked;
        $(this).data('ids').forEach(id => on ? cur.add(id) : cur.delete(id));
        refresh();
    });
    $('#matrix').on('change', '.pb-row-toggle', function () {
        const on = this.checked;
        $(this).closest('.pb-row').data('ids').forEach(id => on ? cur.add(id) : cur.delete(id));
        refresh();
    });
    $('#matrix').on('change', '.pb-col-toggle', function () {
        const on = this.checked, col = $(this).data('col');
        $('#matrix tbody .pb-row:visible td[data-col="' + col + '"] .pb-box').each(function () {
            $(this).data('ids').forEach(id => on ? cur.add(id) : cur.delete(id));
        });
        refresh();
    });
    $('#allowAllBtn').on('click', function () { visibleIds().forEach(id => cur.add(id)); refresh(); });
    $('#clearAllBtn').on('click', function () { visibleIds().forEach(id => cur.delete(id)); refresh(); });
    $('.pb-seg').on('click', 'button', function () {
        filter = $(this).data('f');
        $('.pb-seg button').removeClass('active'); $(this).addClass('active');
        applySearch();
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