{{-- resources/views/teacher/results.blade.php --}}
@extends('layouts.teacher')

@section('title', 'Quiz Results')
@section('page-title', 'Quiz Results')
@section('page-description', 'See how your students are performing')

@section('content')
<div class="res">

    <div class="res-alert" id="err" hidden></div>

    {{-- Summary --}}
    <section class="res-kpis">
        <article class="res-kpi">
            <span class="res-ico"><i class="bi bi-journal-text"></i></span>
            <div><b id="kQuizzes">0</b><small>Quizzes</small></div>
        </article>
        <article class="res-kpi">
            <span class="res-ico"><i class="bi bi-people"></i></span>
            <div><b id="kAttempts">0</b><small>Completed attempts</small></div>
        </article>
        <article class="res-kpi">
            <span class="res-ico"><i class="bi bi-graph-up-arrow"></i></span>
            <div><b id="kAverage">0%</b><small>Average score</small></div>
        </article>
        <article class="res-kpi">
            <span class="res-ico"><i class="bi bi-patch-check"></i></span>
            <div><b id="kPass">0%</b><small>Pass rate</small></div>
        </article>
    </section>

    {{-- Quiz list --}}
    <section class="res-card">
        <div class="res-toolbar">
            <div>
                <h2>Your quizzes</h2>
                <p>Open a quiz to see every student's score.</p>
            </div>
            <label class="res-search">
                <i class="bi bi-search"></i>
                <input type="search" id="search" placeholder="Search quizzes..." aria-label="Search quizzes">
            </label>
        </div>

        <div class="res-head">
            <span>Quiz</span><span>Attempts</span><span>Average score</span><span>Pass rate</span><span></span>
        </div>
        <div id="list"><div class="res-empty">Loading results...</div></div>
    </section>

</div>
@endsection

@push('styles')
<style>
    .res { max-width: 1180px; margin: 0 auto; }

    .res-alert { margin-bottom: 18px; padding: 14px 18px; border-radius: 14px; background: #fdecec; color: #b42318; border: 1px solid #f7caca; }

    .res-kpis { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 18px; }
    .res-kpi {
        display: flex; align-items: center; gap: 14px; padding: 18px;
        background: #fff; border: 1px solid var(--line); border-radius: 18px;
    }
    .res-ico {
        width: 48px; height: 48px; flex: 0 0 auto; display: grid; place-items: center;
        border-radius: 14px; font-size: 21px; background: var(--primary-light); color: var(--primary-dark);
    }
    .res-kpi b { display: block; font-size: 27px; font-weight: 800; line-height: 1.1; letter-spacing: -.02em; }
    .res-kpi small { color: var(--slate); font-size: 12px; }

    .res-card { background: #fff; border: 1px solid var(--line); border-radius: 20px; padding: 22px 24px 8px; }
    .res-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 14px; }
    .res-toolbar h2 { margin: 0 0 3px; font-size: 18px; font-weight: 800; }
    .res-toolbar p { margin: 0; color: var(--slate); font-size: 13px; }

    .res-search { position: relative; width: 270px; max-width: 100%; margin: 0; }
    .res-search i { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--slate); }
    .res-search input {
        width: 100%; height: 42px; padding: 0 13px 0 38px; border: 1px solid var(--line); border-radius: 12px;
        outline: none; font: inherit; font-size: 13px; color: var(--text-color); background: #fff;
    }
    .res-search input:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary-color) 18%, transparent); }

    .res-head, .res-row {
        display: grid; grid-template-columns: minmax(0, 2.2fr) 90px minmax(0, 1.6fr) 130px 130px; align-items: center; gap: 16px;
    }
    .res-head { padding: 10px 0; border-bottom: 1px solid var(--line); color: var(--slate); font-size: 12px; font-weight: 700; }
    .res-row { padding: 16px 0; border-bottom: 1px solid var(--line); }
    .res-row:last-child { border-bottom: 0; }

    .cell-main strong { display: block; font-size: 15px; font-weight: 700; overflow-wrap: anywhere; }
    .cell-main small { color: var(--slate); font-size: 12px; }
    .tag-draft { margin-left: 6px; padding: 2px 8px; border-radius: 999px; background: #f1f5f9; color: var(--slate); font-size: 11px; font-weight: 700; }
    .cell-num b { font-size: 18px; font-weight: 800; }

    .meter { height: 8px; border-radius: 999px; background: #eef2f6; overflow: hidden; margin-bottom: 5px; }
    .meter > div { height: 100%; border-radius: 999px; }
    .meter.good > div { background: #16a34a; }
    .meter.mid  > div { background: #d97706; }
    .meter.low  > div { background: #dc2626; }
    .cell-avg small { color: var(--slate); font-size: 12px; }

    .pill { display: inline-block; padding: 5px 11px; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .pill.pass { background: #dcfce7; color: #166534; }
    .pill.wait { background: #fef3c7; color: #92400e; }
    .pill.none { background: #f1f5f9; color: var(--slate); }

    .btn-view {
        display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 14px; border-radius: 11px;
        background: var(--primary-light); color: var(--primary-dark); font-size: 13px; font-weight: 700; white-space: nowrap;
    }
    .btn-view:hover { background: var(--primary-color); color: var(--on-primary); }
    .btn-view:focus-visible { outline: 2px solid var(--primary-dark); outline-offset: 2px; }

    .res-empty { padding: 44px 10px; text-align: center; color: var(--slate); }

    @media (max-width: 991px) { .res-kpis { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 760px) {
        .res-head { display: none; }
        .res-row { grid-template-columns: 1fr 1fr; gap: 12px; }
        .res-row .cell-main, .res-row .cell-avg { grid-column: 1 / -1; }
        .res-row .btn-view { grid-column: 1 / -1; }
        .res-search { width: 100%; }
    }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const token = window.token || localStorage.getItem('api_token');
    const headers = { Accept: 'application/json', Authorization: 'Bearer ' + token };
    const $ = (id) => document.getElementById(id);
    const esc = (v) => String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[c]));
    const band = (v) => v >= 60 ? 'good' : v >= 40 ? 'mid' : 'low';

    let quizzes = [];

    function render() {
        const q = $('search').value.trim().toLowerCase();
        const shown = quizzes.filter(r => (r.title + ' ' + (r.class_name || '')).toLowerCase().includes(q));

        if (!shown.length) {
            $('list').innerHTML = '<div class="res-empty">' +
                (quizzes.length ? 'No quizzes match your search.' : 'You have not created any quizzes yet.') + '</div>';
            return;
        }

        $('list').innerHTML = shown.map(r => {
            const has = r.attempts > 0;
            return `
            <div class="res-row">
                <div class="cell-main">
                    <strong>${esc(r.title)}${r.is_published ? '' : '<span class="tag-draft">Draft</span>'}</strong>
                    <small>${esc(r.class_name || 'No class')}</small>
                </div>
                <div class="cell-num"><b>${r.attempts}</b></div>
                <div class="cell-avg">
                    ${has
                        ? `<div class="meter ${band(r.average)}"><div style="width:${Math.min(r.average, 100)}%"></div></div><small>${r.average}% average</small>`
                        : '<small>No attempts yet</small>'}
                </div>
                <div>${has
                    ? `<span class="pill ${r.pass_rate >= 60 ? 'pass' : 'wait'}">${r.pass_rate}% passed</span>`
                    : '<span class="pill none">No results</span>'}</div>
                <a class="btn-view" href="/teacher/results/${r.id}"><i class="bi bi-bar-chart-line"></i> View results</a>
            </div>`;
        }).join('');
    }

    fetch('/api/teacher/results', { headers })
        .then(async res => {
            const json = await res.json().catch(() => ({}));
            if (!res.ok || !json.success) throw new Error(json.message || 'Could not load results.');
            return json.data;
        })
        .then(data => {
            quizzes = data.quizzes || [];
            $('kQuizzes').textContent  = data.stats.quizzes;
            $('kAttempts').textContent = data.stats.attempts;
            $('kAverage').textContent  = data.stats.average + '%';
            $('kPass').textContent     = data.stats.pass_rate + '%';
            render();
        })
        .catch(err => {
            $('err').textContent = err.message;
            $('err').hidden = false;
            $('list').innerHTML = '<div class="res-empty">Results are unavailable right now.</div>';
        });

    $('search').addEventListener('input', render);
})();
</script>
@endpush