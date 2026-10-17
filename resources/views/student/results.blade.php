{{-- resources/views/student/results.blade.php --}}
@extends('layouts.student')

@section('title', 'My Results')

@section('content')
<style>
    .rs { max-width: 1100px; margin: auto; }
    .rs-head { margin-bottom: 24px; }
    .rs-title { margin: 0 0 6px; font-size: clamp(26px, 3vw, 34px); font-weight: 800; }
    .rs-copy { margin: 0; color: var(--muted-color); line-height: 1.7; }

    .rs-list { display: grid; gap: 12px; }
    .rs-row {
        display: grid; grid-template-columns: 48px minmax(0, 1fr) auto auto auto; align-items: center; gap: 18px;
        padding: 16px 18px 16px 20px; border: 1px solid var(--border-color); border-left: 4px solid var(--primary-color);
        border-radius: 16px; background: var(--surface-color); transition: transform .2s ease, box-shadow .2s ease;
    }
    .rs-row:hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); }
    .rs-row.failed { border-left-color: #e5484d; }

    .rs-icon { width: 48px; height: 48px; display: grid; place-items: center; border-radius: 14px; background: var(--primary-soft); color: var(--secondary-color); font-size: 21px; }
    .rs-name { margin: 0 0 4px; font-size: 16px; font-weight: 800; overflow-wrap: anywhere; }
    .rs-sub { color: var(--muted-color); font-size: 12px; }

    .rs-score { text-align: right; min-width: 72px; }
    .rs-score b { display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 24px; font-weight: 800; letter-spacing: -.03em; line-height: 1; }
    .rs-score span { color: var(--muted-color); font-size: 11px; }

    .rs-pill { padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .rs-pill.passed  { background: #dcfce7; color: #166534; }
    .rs-pill.failed  { background: #fee2e2; color: #b91c1c; }
    .rs-pill.unknown { background: var(--background-color); color: var(--muted-color); }

    .rs-btn {
        display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border-radius: 11px; white-space: nowrap;
        background: var(--primary-soft); color: var(--secondary-color); font-size: 12px; font-weight: 800; text-decoration: none;
    }
    .rs-btn:hover { background: var(--primary-color); color: var(--on-primary, #fff); }
    .rs-btn:focus-visible { outline: 2px solid var(--secondary-color); outline-offset: 2px; }

    .rs-empty { padding: 46px 20px; border: 1px dashed var(--border-color); border-radius: 18px; background: var(--surface-color); text-align: center; }
    .rs-empty i { font-size: 34px; color: var(--muted-color); }
    .rs-empty h3 { margin: 12px 0 6px; font-size: 17px; font-weight: 800; }
    .rs-empty p { margin: 0 0 16px; color: var(--muted-color); }
    .rs-msg { margin-bottom: 18px; padding: 14px 17px; border: 1px solid #fecaca; border-radius: 13px; background: #fef2f2; color: #b91c1c; }

    @media (max-width: 760px) {
        .rs-row { grid-template-columns: 48px minmax(0, 1fr); gap: 12px 14px; }
        .rs-score, .rs-pill { grid-column: 2; justify-self: start; text-align: left; }
        .rs-btn { grid-column: 1 / -1; justify-content: center; }
    }
</style>

<div class="student-content">
    <div class="rs">
        <header class="rs-head">
            <h1 class="rs-title">My results</h1>
            <p class="rs-copy">Every quiz you have finished, with your score.</p>
        </header>

        <div id="rsMsg" class="rs-msg" hidden></div>
        <div class="rs-list" id="rsList">
            <div class="rs-empty"><i class="bi bi-hourglass-split"></i><h3>Loading your results</h3></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    const token = window.token || localStorage.getItem('api_token');
    const headers = { Authorization: 'Bearer ' + token, Accept: 'application/json' };

    const esc = (v) => String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[c]));

    function icon(subject) {
        const s = String(subject || '').toLowerCase();
        if (s.includes('math')) return 'bi-calculator';
        if (s.includes('science') || s.includes('biology')) return 'bi-activity';
        if (s.includes('computer')) return 'bi-pc-display';
        if (s.includes('english') || s.includes('urdu')) return 'bi-book';
        if (s.includes('physics')) return 'bi-lightning-charge';
        if (s.includes('chemistry')) return 'bi-droplet-half';
        return 'bi-journal-text';
    }

    function showError(text) { $('#rsMsg').text(text).prop('hidden', false); }

    function empty(title, text, withButton) {
        $('#rsList').html(`
            <div class="rs-empty">
                <i class="bi bi-graph-up-arrow"></i>
                <h3>${title}</h3>
                <p>${text}</p>
                ${withButton ? '<a class="rs-btn" href="/student/quizzes">Go to my quizzes</a>' : ''}
            </div>`);
    }

    // Score for one quiz from your existing result API. Returns null if it fails.
    function fetchResult(id) {
        return $.ajax({ url: '/api/student/result-quiz/' + id, headers: headers })
            .then(r => (r && r.status ? r.data : null), () => null);
    }

    function row(quiz, result) {
        const passed = result ? result.result === 'Passed' : null;
        const pillClass = passed === null ? 'unknown' : passed ? 'passed' : 'failed';
        const pillText = passed === null ? 'Result ready' : result.result;
        const where = [quiz.subject_name, quiz.class_name].filter(Boolean).join(', ');

        const score = result
            ? `<div class="rs-score"><b>${esc(result.percentage)}%</b><span>${esc(result.score)} of ${esc(result.total_marks)}</span></div>`
            : `<div class="rs-score"><b>-</b><span>Score</span></div>`;

        return `
            <article class="rs-row ${passed === false ? 'failed' : ''}">
                <div class="rs-icon"><i class="bi ${icon(quiz.subject_name)}"></i></div>
                <div>
                    <h3 class="rs-name">${esc(quiz.title)}</h3>
                    <div class="rs-sub">${esc(where || 'Quiz')}</div>
                </div>
                ${score}
                <span class="rs-pill ${pillClass}">${esc(pillText)}</span>
                <a class="rs-btn" href="/student/result-quiz/${Number(quiz.id)}"><i class="bi bi-bar-chart-line"></i> View result</a>
            </article>`;
    }

    if (!token) {
        showError('Your session has expired. Please log in again.');
        empty('Not logged in', 'Log in to see your results.', false);
        return;
    }

    $.ajax({ url: '/api/student/quizzes', headers: headers }).done(function (response) {
        const all = (response && response.data && Array.isArray(response.data.quizzes)) ? response.data.quizzes : [];
        const done = all.filter(q => q.attempt_status === 'completed');

        if (!done.length) {
            empty('No results yet', 'Finish a quiz and your score will show up here.', true);
            return;
        }

        // Load every score at the same time
        $.when.apply($, done.map(q => fetchResult(q.id))).then(function () {
            const results = done.length === 1 ? [arguments[0]] : Array.from(arguments);
            $('#rsList').html(done.map((q, i) => row(q, results[i])).join(''));
        });
    }).fail(function () {
        showError('Could not load your results. Please refresh the page.');
        empty('Something went wrong', 'We could not load your quizzes.', false);
    });
});
</script>
@endpush