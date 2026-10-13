@extends('layouts.teacher')

@section('content')
<style>
    /* All styles are scoped to .qz so they never clash with your layout */
    .qz, .qz-modal, #qzToasts {
        --ink: #1e2433;
        --muted: #6b7a90;
        --line: #e2e8f0;
        --primary: #3b4a5f;
        --primary-hover: #2b3748;
        --soft: #eef1f5;
        --danger: #b42318;
        --danger-soft: #fdecea;
        font-family: inherit;
        color: var(--ink);
    }
    .qz { max-width: 1100px; padding: 8px 0 48px; }
    .qz *, .qz *::before, .qz *::after,
    .qz-modal *, .qz-modal *::before, .qz-modal *::after { box-sizing: border-box; }
    .qz h1, .qz h2, .qz h3, .qz p { margin: 0; }
    .qz svg { flex-shrink: 0; }

    /* ---------- Header ---------- */
    .qz-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 26px; }
    .qz-title { font-size: 28px; font-weight: 700; letter-spacing: -.02em; line-height: 1.2; }
    .qz-subtitle { color: var(--muted); font-size: 15px; margin-top: 4px; }

    /* ---------- Buttons ---------- */
    .qz-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px;
        padding: 9px 16px; border-radius: 12px; border: 1px solid transparent;
        font: inherit; font-size: 14px; font-weight: 600; line-height: 1.2;
        cursor: pointer; text-decoration: none; background: var(--soft); color: var(--ink);
        transition: background .15s, transform .15s, box-shadow .15s, opacity .15s;
    }
    .qz-btn:hover { background: #e1e6ed; }
    .qz-btn:active { transform: scale(.98); }
    .qz-btn:disabled { opacity: .55; cursor: not-allowed; }
    .qz-btn.primary { background: var(--primary); color: #fff; box-shadow: 0 4px 12px rgba(59,74,95,.25); }
    .qz-btn.primary:hover { background: var(--primary-hover); }
    .qz-btn.ghost { background: #fff; border-color: var(--line); }
    .qz-btn.ghost:hover { background: #f8fafc; }
    .qz-btn.danger { background: var(--danger-soft); color: var(--danger); }
    .qz-btn.danger:hover { background: #fbd9d5; }
    .qz-btn.danger-solid { background: var(--danger); color: #fff; }
    .qz-btn.danger-solid:hover { background: #912018; }

    /* ---------- Toolbar ---------- */
    .qz-toolbar { display: flex; gap: 14px; align-items: center; flex-wrap: wrap; margin-bottom: 22px; }
    .qz-search { position: relative; flex: 1; min-width: 240px; }
    .qz-search svg { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--muted); }
    .qz-input {
        width: 100%; padding: 11px 14px; border: 1px solid var(--line); border-radius: 12px;
        background: rgba(255,255,255,.9); font: inherit; font-size: 15px; color: var(--ink); outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .qz-search .qz-input { padding-left: 42px; }
    .qz-input:focus { border-color: #94a3b8; box-shadow: 0 0 0 4px rgba(148,163,184,.25); }

    .qz-tabs { display: flex; gap: 6px; padding: 5px; background: rgba(255,255,255,.7); border: 1px solid var(--line); border-radius: 14px; }
    .qz-tab {
        display: inline-flex; align-items: center; gap: 8px; padding: 8px 14px; border: 0; border-radius: 10px;
        background: transparent; font: inherit; font-size: 14px; font-weight: 600; color: var(--muted); cursor: pointer;
        transition: background .15s, color .15s;
    }
    .qz-tab:hover { color: var(--ink); }
    .qz-tab.active { background: var(--primary); color: #fff; }
    .qz-count { min-width: 22px; padding: 1px 7px; border-radius: 999px; background: var(--soft); color: var(--ink); font-size: 12px; text-align: center; }
    .qz-tab.active .qz-count { background: rgba(255,255,255,.22); color: #fff; }

    /* ---------- Cards ---------- */
    .qz-list { display: flex; flex-direction: column; gap: 16px; }
    .qz-card {
        display: flex; gap: 18px; padding: 22px; background: rgba(255,255,255,.85);
        border: 1px solid var(--line); border-radius: 20px; box-shadow: 0 1px 2px rgba(16,24,40,.04);
        transition: box-shadow .2s, transform .2s;
    }
    .qz-card:hover { box-shadow: 0 10px 28px rgba(16,24,40,.08); transform: translateY(-1px); }
    .qz-icon { width: 56px; height: 56px; border-radius: 16px; background: var(--soft); color: var(--muted); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .qz-body { flex: 1; min-width: 0; }
    .qz-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; }
    .qz-card-title { font-size: 19px; font-weight: 700; line-height: 1.3; word-break: break-word; }
    .qz-sub { color: var(--muted); font-size: 14px; margin-top: 4px; }
    .qz-pill { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; font-size: 13px; font-weight: 700; white-space: nowrap; }
    .qz-pill::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
    .qz-pill.draft { background: #fdf0c8; color: #8a4a0b; }
    .qz-pill.published { background: #d8f5e2; color: #17653a; }
    .qz-meta { display: flex; flex-wrap: wrap; gap: 8px 22px; margin-top: 14px; color: var(--muted); font-size: 14px; }
    .qz-meta span { display: inline-flex; align-items: center; gap: 7px; }
    .qz-actions { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 18px; }

    /* ---------- Empty + skeleton ---------- */
    .qz-empty { text-align: center; padding: 64px 20px; background: rgba(255,255,255,.7); border: 1px dashed #cbd5e1; border-radius: 20px; }
    .qz-empty .qz-icon { margin: 0 auto 14px; }
    .qz-empty h3 { font-size: 18px; font-weight: 700; }
    .qz-empty p { color: var(--muted); margin: 6px 0 18px; }
    .qz-skel { height: 150px; border-radius: 20px; background: linear-gradient(90deg, #eef1f5 25%, #f7f9fb 50%, #eef1f5 75%); background-size: 200% 100%; animation: qzshimmer 1.3s infinite; }
    @keyframes qzshimmer { to { background-position: -200% 0; } }

    /* ---------- Modals ---------- */
    .qz-modal {
        position: fixed; inset: 0; z-index: 9999; display: none; align-items: center; justify-content: center;
        padding: 16px; background: rgba(15,23,42,.45); backdrop-filter: blur(4px);
    }
    .qz-modal.open { display: flex; }
    .qz-dialog { width: 100%; max-width: 500px; max-height: 92vh; overflow-y: auto; background: #fff; border-radius: 22px; padding: 28px; box-shadow: 0 30px 80px rgba(15,23,42,.35); animation: qzpop .18s ease-out; }
    @keyframes qzpop { from { opacity: 0; transform: translateY(10px) scale(.97); } to { opacity: 1; transform: none; } }
    .qz-dialog h2 { font-size: 21px; font-weight: 700; margin: 0; }
    .qz-chip { display: inline-block; margin-top: 8px; padding: 4px 12px; border-radius: 999px; background: var(--soft); color: var(--muted); font-size: 13px; font-weight: 600; }
    .qz-notice { margin-top: 14px; padding: 10px 14px; border-radius: 12px; background: #fdf0c8; color: #8a4a0b; font-size: 13px; }
    .qz-field { margin-top: 16px; }
    .qz-field label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: var(--muted); }
    .qz-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .qz-error { margin-top: 14px; padding: 10px 14px; border-radius: 12px; background: var(--danger-soft); color: var(--danger); font-size: 14px; display: none; }
    .qz-foot { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; }
    .qz-warn-icon { width: 52px; height: 52px; border-radius: 50%; background: var(--danger-soft); color: var(--danger); display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
    .qz-dialog p.qz-text { color: var(--muted); margin: 8px 0 0; line-height: 1.5; }

    /* ---------- Toasts ---------- */
    #qzToasts { position: fixed; right: 24px; bottom: 24px; z-index: 10000; display: flex; flex-direction: column; gap: 10px; }
    .qz-toast { min-width: 240px; max-width: 360px; padding: 13px 16px; border-radius: 14px; background: #fff; border-left: 5px solid #17653a; box-shadow: 0 12px 32px rgba(15,23,42,.18); font-size: 14px; font-weight: 600; animation: qzpop .2s ease-out; }
    .qz-toast.err { border-left-color: var(--danger); }

    @media (max-width: 640px) {
        .qz-card { flex-direction: column; padding: 18px; }
        .qz-icon { width: 46px; height: 46px; }
        .qz-grid { grid-template-columns: 1fr; }
        .qz-tabs { width: 100%; overflow-x: auto; }
        #qzToasts { left: 16px; right: 16px; }
    }
</style>

<div class="qz">

    {{-- Header --}}
    <div class="qz-head">
        <div>
            <h2 class="qz-title">My Quizzes</h2>
            <p class="qz-subtitle">View and manage your assessments</p>
        </div>
        <a href="/teacher/createQuiz" class="qz-btn primary">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
            New Quiz
        </a>
    </div>

    {{-- Search + status tabs --}}
    <div class="qz-toolbar">
        <div class="qz-search">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
            <input id="search" class="qz-input" type="text" placeholder="Search by title, class or subject">
        </div>
        <div class="qz-tabs">
            <button type="button" class="qz-tab active" data-status="all">All <span class="qz-count" id="cntAll">0</span></button>
            <button type="button" class="qz-tab" data-status="published">Published <span class="qz-count" id="cntPub">0</span></button>
            <button type="button" class="qz-tab" data-status="draft">Drafts <span class="qz-count" id="cntDraft">0</span></button>
        </div>
    </div>

    {{-- Cards are drawn here --}}
    <div id="list" class="qz-list"></div>
</div>

{{-- Edit modal --}}
<div class="qz-modal" id="editModal">
    <div class="qz-dialog">
        <h2>Edit Quiz</h2>
        <span class="qz-chip" id="e_meta"></span>
        <div class="qz-notice" id="e_notice" style="display:none">This quiz is published. Changes apply to it immediately.</div>

        <input type="hidden" id="e_id">
        <input type="hidden" id="e_class_id">
        <input type="hidden" id="e_subject_id">

        <div class="qz-field">
            <label for="e_title">Title</label>
            <input id="e_title" class="qz-input" type="text" maxlength="255">
        </div>
        <div class="qz-field">
            <label for="e_time">Time limit (minutes) &mdash; leave empty for no limit</label>
            <input id="e_time" class="qz-input" type="number" min="1">
        </div>
        <div class="qz-grid">
            <div class="qz-field">
                <label for="e_total">Total marks</label>
                <input id="e_total" class="qz-input" type="number" min="0">
            </div>
            <div class="qz-field">
                <label for="e_pass">Pass marks</label>
                <input id="e_pass" class="qz-input" type="number" min="0">
            </div>
        </div>

        <div class="qz-error" id="e_error"></div>

        <div class="qz-foot">
            <button type="button" class="qz-btn ghost" id="cancelEdit">Cancel</button>
            <button type="button" class="qz-btn primary" id="saveEdit">Save changes</button>
        </div>
    </div>
</div>

{{-- Delete confirmation modal --}}
<div class="qz-modal" id="delModal">
    <div class="qz-dialog" style="max-width:430px">
        <div class="qz-warn-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M6 6l1 14h10l1-14"/></svg>
        </div>
        <h2>Delete this quiz?</h2>
        <p class="qz-text"><strong id="delName"></strong> and its questions will be removed. This cannot be undone.</p>
        <div class="qz-foot">
            <button type="button" class="qz-btn ghost" id="cancelDel">Cancel</button>
            <button type="button" class="qz-btn danger-solid" id="confirmDel">Delete quiz</button>
        </div>
    </div>
</div>

<div id="qzToasts"></div>

{{-- Loads jQuery only if your layout hasn't already --}}
<script>window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.7.1.min.js"><\/script>')</script>

<script>
$(function () {

    // ---------- 1. Setup ----------
    var API = '/api/teacher/quizzes';
    var TOKEN = localStorage.getItem('api_token');
    var quizzes = [];
    var statusFilter = 'all';
    var deleteId = null;

    if (!TOKEN) {
        window.location.href = '/login';   // change to your login URL
        return;
    }

    // Token is attached to every request automatically
    $.ajaxSetup({
        headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + TOKEN },
        statusCode: {
            401: function () {
                localStorage.removeItem('api_token');
                window.location.href = '/login';
            }
        }
    });

    // ---------- 2. Icons ----------
    function svg(paths, size) {
        size = size || 16;
        return '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + paths + '</svg>';
    }
    var ICON = {
        doc:     '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8M8 17h5"/>',
        marks:   '<circle cx="12" cy="12" r="9"/><path d="m8.5 12.5 2.5 2.5 4.5-5"/>',
        clock:   '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        list:    '<path d="M9 6h11M9 12h11M9 18h11"/><path d="M4 6h.01M4 12h.01M4 18h.01"/>',
        flag:    '<path d="M5 21V4"/><path d="M5 4h12l-2 4 2 4H5"/>',
        edit:    '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
        publish: '<path d="M12 16V4"/><path d="m7 9 5-5 5 5"/><path d="M5 20h14"/>',
        unpub:   '<path d="M12 4v12"/><path d="m7 11 5 5 5-5"/><path d="M5 20h14"/>',
        trash:   '<path d="M3 6h18"/><path d="M8 6V4h8v2"/><path d="M6 6l1 14h10l1-14"/>'
    };

    // ---------- 3. Helpers ----------
    function esc(text) {
        return $('<div>').text(text == null ? '' : text).html();
    }

    function toast(message, ok) {
        var $t = $('<div class="qz-toast' + (ok ? '' : ' err') + '">').text(message);
        $('#qzToasts').append($t);
        setTimeout(function () { $t.fadeOut(250, function () { $t.remove(); }); }, 3500);
    }

    function errorMessage(xhr, fallback) {
        var r = xhr.responseJSON || {};
        if (r.message) return r.message;
        if (r.errors) return Object.values(r.errors)[0][0];
        return fallback;
    }

    // Works whichever relation name the API returns
    function classOf(z) {
        var c = z.academic_class || z.academicClass || z.academic_classes || null;
        return c && c.name ? c.name : '';
    }
    function subjectOf(z) {
        return z.subject && z.subject.name ? z.subject.name : '';
    }

    // ---------- 4. Load ----------
    function showSkeleton() {
        $('#list').html('<div class="qz-skel"></div><div class="qz-skel"></div>');
    }

    function loadQuizzes() {
        $.ajax({
            url: API,
            method: 'GET',
            success: function (res) {
                console.log(res);
                quizzes = res.data || [];
                const teacherClasses = quizzes.academic_class;
                console.log(res.data);
                render();
            },
            error: function (xhr) {
                $('#list').html('');
                toast(errorMessage(xhr, 'Failed to load quizzes'), false);
            }
        });
    }

    // ---------- 5. Render ----------
    function updateCounts() {
        var pub = quizzes.filter(function (z) { return z.is_published; }).length;
        $('#cntAll').text(quizzes.length);
        $('#cntPub').text(pub);
        $('#cntDraft').text(quizzes.length - pub);
    }

    function render() {
        updateCounts();

        var search = $('#search').val().toLowerCase();

        var visible = quizzes.filter(function (z) {
            var text = (z.title + ' ' + classOf(z) + ' ' + subjectOf(z)).toLowerCase();
            var status = z.is_published ? 'published' : 'draft';
            return text.indexOf(search) !== -1 && (statusFilter === 'all' || statusFilter === status);
        });

        if (visible.length === 0) {
            var none = quizzes.length === 0;

            $('#list').html(
                '<div class="qz-empty">' +
                    '<div class="qz-icon">' + svg(ICON.doc, 26) + '</div>' +
                    '<h3>' + (none ? 'No quizzes yet' : 'No quizzes match your search') + '</h3>' +
                    '<p>' + (none ? 'Create your first quiz to get started.' : 'Try a different keyword or filter.') + '</p>' +
                    (none ? '<a href="/teacher/quizzes/createQuiz" class="qz-btn primary">Create Quiz</a>' : '') +
                '</div>'
            );
            return;
        }

        var html = '';
        $.each(visible, function (i, z) {
            var sub = [classOf(z), subjectOf(z)].filter(Boolean).join(' · ');
            var time = z.time_limit_minutes ? z.time_limit_minutes + ' min' : 'No time limit';
            var qCount = z.questions_count || 0;

            html +=
            '<article class="qz-card">' +
                '<div class="qz-icon">' + svg(ICON.doc, 24) + '</div>' +
                '<div class="qz-body">' +
                    '<div class="qz-top">' +
                        '<h3 class="qz-card-title">' + esc(z.title) + '</h3>' +
                        '<span class="qz-pill ' + (z.is_published ? 'published' : 'draft') + '">' + (z.is_published ? 'Published' : 'Draft') + '</span>' +
                    '</div>' +
                    (sub ? '<p class="qz-sub">' + esc(sub) + '</p>' : '') +
                    '<div class="qz-meta">' +
                        '<span>' + svg(ICON.marks) + z.total_marks + ' marks</span>' +
                        '<span>' + svg(ICON.flag) + 'Pass ' + z.pass_marks + '</span>' +
                        '<span>' + svg(ICON.clock) + time + '</span>' +
                        '<span>' + svg(ICON.list) + qCount + (qCount === 1 ? ' question' : ' questions') + '</span>' +
                    '</div>' +
                    '<div class="qz-actions">' +
                        '<a class="qz-btn primary" href="/teacher/' + z.id + '/questions">' + svg(ICON.list) + 'Manage Questions</a>' +
                        '<button type="button" class="qz-btn ghost btn-edit" data-id="' + z.id + '">' + svg(ICON.edit) + 'Edit</button>' +
                        '<button type="button" class="qz-btn ghost btn-publish" data-id="' + z.id + '" data-published="' + (z.is_published ? 1 : 0) + '">' +
                            (z.is_published ? svg(ICON.unpub) + 'Unpublish' : svg(ICON.publish) + 'Publish') +
                        '</button>' +
                        '<button type="button" class="qz-btn danger btn-delete" data-id="' + z.id + '">' + svg(ICON.trash) + 'Delete</button>' +
                    '</div>' +
                '</div>' +
            '</article>';
        });

        $('#list').html(html);
    }

    // ---------- 6. Publish / Unpublish ----------
    $('#list').on('click', '.btn-publish', function () {
        var $btn = $(this);
        var id = $btn.data('id');
        var action = $btn.data('published') == 1 ? 'unpublish' : 'publish';

        $btn.prop('disabled', true).text('Please wait…');

        $.ajax({
            url: API + '/' + id + '/' + action,
            method: 'PUT',
            success: function (res) {
                if (res.status === false) {
                    toast(res.message || 'Failed', false);
                    render();
                    return;
                }
                toast(res.message || 'Done', true);
                loadQuizzes();
            },
            error: function (xhr) {
                toast(errorMessage(xhr, 'Failed'), false);
                render();
            }
        });
    });

    // ---------- 7. Delete (custom confirm modal) ----------
    $('#list').on('click', '.btn-delete', function () {
        deleteId = $(this).data('id');
        var z = quizzes.find(function (q) { return q.id === deleteId; });
        $('#delName').text(z ? z.title : 'This quiz');
        $('#delModal').addClass('open');
    });

    $('#cancelDel').on('click', function () { $('#delModal').removeClass('open'); });

    $('#confirmDel').on('click', function () {
        var $btn = $(this).prop('disabled', true).text('Deleting…');

        $.ajax({
            url: API + '/' + deleteId,
            method: 'DELETE',
            success: function (res) {
                if (res.status === false) {
                    toast(res.message || 'Failed to delete', false);
                } else {
                    toast(res.message || 'Quiz deleted', true);
                    loadQuizzes();
                }
            },
            error: function (xhr) {
                toast(errorMessage(xhr, 'Failed to delete'), false);
            },
            complete: function () {
                $btn.prop('disabled', false).text('Delete quiz');
                $('#delModal').removeClass('open');
            }
        });
    });

    // ---------- 8. Edit: open ----------
    $('#list').on('click', '.btn-edit', function () {
        var id = $(this).data('id');
        var z = quizzes.find(function (q) { return q.id === id; });

        $('#e_id').val(z.id);
        $('#e_class_id').val(z.class_id);
        $('#e_subject_id').val(z.subject_id);
        $('#e_title').val(z.title);
        $('#e_time').val(z.time_limit_minutes || '');
        $('#e_total').val(z.total_marks);
        $('#e_pass').val(z.pass_marks);

        var meta = [classOf(z), subjectOf(z)].filter(Boolean).join(' · ');
        $('#e_meta').text(meta).toggle(meta !== '');
        $('#e_notice').toggle(!!z.is_published);
        $('#e_error').hide();

        $('#editModal').addClass('open');
        $('#e_title').trigger('focus');
    });

    $('#cancelEdit').on('click', function () { $('#editModal').removeClass('open'); });

    // ---------- 9. Edit: save ----------
    function editError(message) {
        $('#e_error').text(message).show();
    }

    $('#saveEdit').on('click', function () {
        var title = $.trim($('#e_title').val());
        var time = $('#e_time').val();
        var total = Number($('#e_total').val());
        var pass = Number($('#e_pass').val());

        // Quick checks before calling the server
        if (!title) return editError('Please enter a title.');
        if (pass > total) return editError('Pass marks cannot be more than total marks.');

        var $btn = $(this).prop('disabled', true).text('Saving…');

        $.ajax({
            url: API + '/' + $('#e_id').val(),
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({
                class_id:           Number($('#e_class_id').val()),
                subject_id:         Number($('#e_subject_id').val()),
                title:              title,
                time_limit_minutes: time ? Number(time) : null,
                total_marks:        total,
                pass_marks:         pass
            }),
            success: function (res) {
                if (res.status === false) {
                    editError(res.message || 'Failed to save');
                    return;
                }
                $('#editModal').removeClass('open');
                toast('Quiz updated', true);
                loadQuizzes();
            },
            error: function (xhr) {
                editError(errorMessage(xhr, 'Failed to save'));
            },
            complete: function () {
                $btn.prop('disabled', false).text('Save changes');
            }
        });
    });

    // ---------- 10. Tabs, search, close modals ----------
    $('.qz-tab').on('click', function () {
        $('.qz-tab').removeClass('active');
        $(this).addClass('active');
        statusFilter = $(this).data('status');
        render();
    });

    $('#search').on('input', render);

    // Click the dark backdrop or press Esc to close a modal
    $('.qz-modal').on('click', function (e) {
        if (e.target === this) $(this).removeClass('open');
    });
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') $('.qz-modal').removeClass('open');
    });

    // ---------- 11. Start ----------
    showSkeleton();
    loadQuizzes();
});
</script>
@endsection