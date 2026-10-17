{{-- resources/views/teacher/result-detail.blade.php --}}
@extends('layouts.teacher')

@section('title', 'Quiz Results')
@section('page-title', 'Quiz Results')
@section('page-description', 'Every student\'s score for this quiz')

@section('content')
<div class="rd">

    <a class="rd-back" href="/teacher/results"><i class="bi bi-arrow-left"></i> All results</a>
    <div class="rd-alert" id="err" hidden></div>

    <div class="rd-title">
        <h2 id="quizTitle">Loading...</h2>
        <p id="quizMeta"></p>
    </div>

    {{-- Summary --}}
    <section class="rd-kpis">
        <article class="rd-kpi"><small>Attempts</small><b id="sAttempts">0</b></article>
        <article class="rd-kpi"><small>Average</small><b id="sAverage">0%</b></article>
        <article class="rd-kpi"><small>Highest</small><b id="sHighest">0%</b></article>
        <article class="rd-kpi"><small>Lowest</small><b id="sLowest">0%</b></article>
        <article class="rd-kpi"><small>Pass rate</small><b id="sPass">0%</b></article>
    </section>

    {{-- Chart + pending --}}
    <section class="rd-two">
        <article class="rd-card">
            <h3>Score spread</h3>
            <p class="rd-sub">How many students fell in each score range.</p>
            <div class="chart" id="chart"></div>
        </article>

        <article class="rd-card">
            <h3>Not finished yet <span class="rd-count" id="pendingCount">0</span></h3>
            <p class="rd-sub">Students in this class without a completed attempt.</p>
            <div class="pending" id="pending"></div>
        </article>
    </section>

    {{-- Results table --}}
    <section class="rd-card">
        <div class="rd-toolbar">
            <h3 class="m-0">Student results</h3>
            <div class="rd-tools">
                <label class="rd-search">
                    <i class="bi bi-search"></i>
                    <input type="search" id="search" placeholder="Search name or roll no." aria-label="Search students">
                </label>
                <select id="sort" aria-label="Sort results">
                    <option value="high">Highest score first</option>
                    <option value="low">Lowest score first</option>
                    <option value="name">Name A to Z</option>
                    <option value="recent">Most recent</option>
                </select>
                <button type="button" class="btn-export" id="export"><i class="bi bi-download"></i> Export CSV</button>
            </div>
        </div>

        <div class="rd-chips" id="chips">
            <button type="button" data-filter="all" class="active">All <b id="cAll">0</b></button>
            <button type="button" data-filter="passed">Passed <b id="cPassed">0</b></button>
            <button type="button" data-filter="failed">Failed <b id="cFailed">0</b></button>
        </div>

        <div class="table-wrap">
            <table class="rd-table">
                <thead>
                    <tr><th>#</th><th>Student</th><th>Roll no.</th><th>Score</th><th>Percentage</th><th>Result</th><th>Date</th></tr>
                </thead>
                <tbody id="rows"><tr><td colspan="7" class="rd-empty">Loading...</td></tr></tbody>
            </table>
        </div>
    </section>

</div>
@endsection

@push('styles')
<style>
    .rd { max-width: 1180px; margin: 0 auto; }
    .rd-back { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 14px; color: var(--slate); font-weight: 700; }
    .rd-back:hover { color: var(--primary-dark); }
    .rd-alert { margin-bottom: 16px; padding: 14px 18px; border-radius: 14px; background: #fdecec; color: #b42318; border: 1px solid #f7caca; }

    .rd-title h2 { margin: 0 0 4px; font-size: 26px; font-weight: 800; overflow-wrap: anywhere; }
    .rd-title p { margin: 0 0 20px; color: var(--slate); }

    .rd-kpis { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; margin-bottom: 16px; }
    .rd-kpi { padding: 16px 18px; background: #fff; border: 1px solid var(--line); border-radius: 16px; }
    .rd-kpi small { display: block; color: var(--slate); font-size: 12px; margin-bottom: 6px; }
    .rd-kpi b { font-size: 26px; font-weight: 800; letter-spacing: -.02em; }

    .rd-two { display: grid; grid-template-columns: 1.25fr 1fr; gap: 16px; margin-bottom: 16px; }
    .rd-card { background: #fff; border: 1px solid var(--line); border-radius: 20px; padding: 22px 24px; margin-bottom: 0; }
    section.rd-card { margin-bottom: 16px; }
    .rd-card h3 { margin: 0 0 3px; font-size: 17px; font-weight: 800; }
    .rd-sub { margin: 0 0 16px; color: var(--slate); font-size: 13px; }
    .rd-count { margin-left: 6px; padding: 1px 9px; border-radius: 999px; background: #fef3c7; color: #92400e; font-size: 12px; }

    /* Score spread chart */
    .chart { display: flex; align-items: flex-end; gap: 14px; height: 200px; padding-top: 6px; }
    .bar-col { flex: 1; display: flex; flex-direction: column; justify-content: flex-end; align-items: center; height: 100%; }
    .bar-n { font-weight: 800; font-size: 14px; margin-bottom: 5px; }
    .bar { width: 100%; max-width: 62px; border-radius: 10px 10px 4px 4px; min-height: 4px; transition: height .6s cubic-bezier(.2,.7,.2,1); }
    .bar.low { background: #dc2626; } .bar.mid { background: #d97706; } .bar.good { background: #16a34a; }
    .bar-l { margin-top: 8px; color: var(--slate); font-size: 11px; font-weight: 600; white-space: nowrap; }

    /* Pending list */
    .pending { max-height: 232px; overflow-y: auto; display: grid; gap: 8px; }
    .pending-item { display: flex; align-items: center; justify-content: space-between; gap: 10px; padding: 9px 12px; border: 1px solid var(--line); border-radius: 12px; }
    .pending-item strong { display: block; font-size: 13px; font-weight: 700; }
    .pending-item small { color: var(--slate); font-size: 11px; }
    .tag { padding: 3px 9px; border-radius: 999px; font-size: 11px; font-weight: 700; white-space: nowrap; background: #f1f5f9; color: var(--slate); }
    .tag.progress { background: #fef3c7; color: #92400e; }
    .pending-empty { padding: 28px 0; text-align: center; color: var(--slate); }

    /* Table toolbar */
    .rd-toolbar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 14px; }
    .rd-tools { display: flex; flex-wrap: wrap; gap: 10px; }
    .rd-search { position: relative; margin: 0; }
    .rd-search i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--slate); }
    .rd-search input, .rd-tools select {
        height: 40px; border: 1px solid var(--line); border-radius: 11px; font: inherit; font-size: 13px; background: #fff; color: var(--text-color); outline: none;
    }
    .rd-search input { padding: 0 12px 0 36px; width: 220px; }
    .rd-tools select { padding: 0 12px; }
    .rd-search input:focus, .rd-tools select:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary-color) 18%, transparent); }
    .btn-export { height: 40px; padding: 0 14px; border: 0; border-radius: 11px; background: var(--primary-color); color: var(--on-primary); font-weight: 700; font-size: 13px; }
    .btn-export:hover { background: var(--primary-dark); color: #fff; }

    .rd-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 14px; }
    .rd-chips button { display: inline-flex; align-items: center; gap: 8px; padding: 7px 14px; border: 1px solid var(--line); border-radius: 999px; background: #fff; font: inherit; font-size: 13px; font-weight: 700; color: var(--slate); }
    .rd-chips button b { font-size: 11px; padding: 1px 8px; border-radius: 999px; background: #f1f5f9; }
    .rd-chips button.active { border-color: var(--primary-color); background: var(--primary-light); color: var(--primary-dark); }

    .table-wrap { overflow-x: auto; }
    .rd-table { width: 100%; min-width: 720px; border-collapse: collapse; }
    .rd-table th { padding: 11px 12px; border-bottom: 1px solid var(--line); background: #f8fafc; color: var(--slate); font-size: 12px; font-weight: 700; text-align: left; white-space: nowrap; }
    .rd-table td { padding: 13px 12px; border-bottom: 1px solid var(--line); font-size: 14px; vertical-align: middle; }
    .rd-table tr:last-child td { border-bottom: 0; }
    .rd-table .name { font-weight: 700; }
    .mini { display: flex; align-items: center; gap: 10px; min-width: 130px; }
    .mini .track { flex: 1; height: 7px; border-radius: 999px; background: #eef2f6; overflow: hidden; }
    .mini .track div { height: 100%; border-radius: 999px; }
    .mini .good { background: #16a34a; } .mini .mid { background: #d97706; } .mini .low { background: #dc2626; }
    .mini b { font-size: 13px; min-width: 46px; }
    .pill { display: inline-block; padding: 4px 11px; border-radius: 999px; font-size: 12px; font-weight: 700; }
    .pill.pass { background: #dcfce7; color: #166534; }
    .pill.fail { background: #fee2e2; color: #b91c1c; }
    .rd-empty { text-align: center; color: var(--slate); padding: 36px 10px !important; }

    @media (max-width: 991px) { .rd-kpis { grid-template-columns: repeat(3, 1fr); } .rd-two { grid-template-columns: 1fr; } }
    @media (max-width: 575px) { .rd-kpis { grid-template-columns: repeat(2, 1fr); } .rd-search input { width: 100%; } .rd-tools, .rd-search { width: 100%; } .rd-tools select, .btn-export { flex: 1; } }
    @media (prefers-reduced-motion: reduce) { .bar { transition: none; } }
</style>
@endpush

@push('scripts')
<script>
(function () {
    const QUIZ_ID = {{ (int) $quizId }};
    const token = window.token || localStorage.getItem('api_token');
    const headers = { Accept: 'application/json', Authorization: 'Bearer ' + token };

    const $ = (id) => document.getElementById(id);
    const esc = (v) => String(v ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[c]));
    const band = (v) => v >= 60 ? 'good' : v >= 40 ? 'mid' : 'low';
    const fmtDate = (v) => v ? new Date(v).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' }) : '-';

    let data = null;
    let filter = 'all';

    function visibleRows() {
        const q = $('search').value.trim().toLowerCase();

        const rows = data.results.filter(r =>
            (filter === 'all' || (filter === 'passed' ? r.passed : !r.passed)) &&
            (r.student + ' ' + (r.roll_no || '')).toLowerCase().includes(q)
        );

        const sort = $('sort').value;
        rows.sort((a, b) =>
            sort === 'low'    ? a.percentage - b.percentage :
            sort === 'name'   ? a.student.localeCompare(b.student) :
            sort === 'recent' ? new Date(b.date) - new Date(a.date) :
                                b.percentage - a.percentage
        );

        return rows;
    }

    function renderTable() {
        const rows = visibleRows();
        const total = data.quiz.total_marks;

        if (!rows.length) {
            $('rows').innerHTML = '<tr><td colspan="7" class="rd-empty">' +
                (data.results.length ? 'No students match your filters.' : 'No one has completed this quiz yet.') + '</td></tr>';
            return;
        }

        $('rows').innerHTML = rows.map((r, i) => `
            <tr>
                <td class="text-muted">${i + 1}</td>
                <td class="name">${esc(r.student)}</td>
                <td>${esc(r.roll_no || '-')}</td>
                <td>${esc(r.score)} / ${total}</td>
                <td><div class="mini"><div class="track"><div class="${band(r.percentage)}" style="width:${Math.min(r.percentage, 100)}%"></div></div><b>${r.percentage}%</b></div></td>
                <td><span class="pill ${r.passed ? 'pass' : 'fail'}">${r.passed ? 'Passed' : 'Failed'}</span></td>
                <td>${fmtDate(r.date)}</td>
            </tr>`).join('');
    }

    function renderChart(buckets) {
        const labels = ['0-20%', '21-40%', '41-60%', '61-80%', '81-100%'];
        const tones  = ['low', 'low', 'mid', 'good', 'good'];
        const max = Math.max(...buckets, 1);

        $('chart').innerHTML = buckets.map((n, i) => `
            <div class="bar-col">
                <span class="bar-n">${n}</span>
                <div class="bar ${tones[i]}" style="height:${Math.max(Math.round(n / max * 130), 4)}px"></div>
                <span class="bar-l">${labels[i]}</span>
            </div>`).join('');
    }

    function renderPending(list) {
        $('pendingCount').textContent = list.length;
        $('pending').innerHTML = list.length
            ? list.map(s => `
                <div class="pending-item">
                    <div><strong>${esc(s.name)}</strong><small>${esc(s.roll_no || 'No roll number')}</small></div>
                    <span class="tag ${s.status === 'In progress' ? 'progress' : ''}">${esc(s.status)}</span>
                </div>`).join('')
            : '<div class="pending-empty">Everyone has finished this quiz.</div>';
    }

    function exportCsv() {
        const cell = (v) => '"' + String(v ?? '').replace(/"/g, '""') + '"';
        const lines = [['Student', 'Roll No', 'Score', 'Total', 'Percentage', 'Result', 'Date'].map(cell).join(',')];

        visibleRows().forEach(r => lines.push([
            r.student, r.roll_no, r.score, data.quiz.total_marks, r.percentage, r.passed ? 'Passed' : 'Failed', fmtDate(r.date)
        ].map(cell).join(',')));

        // The BOM makes Excel read Urdu names correctly
        const blob = new Blob(['\uFEFF' + lines.join('\n')], { type: 'text/csv;charset=utf-8;' });
        const a = document.createElement('a');
        a.href = URL.createObjectURL(blob);
        a.download = data.quiz.title.replace(/[^\w\- ]+/g, '').trim().replace(/\s+/g, '-') + '-results.csv';
        a.click();
        URL.revokeObjectURL(a.href);
    }

    fetch('/api/teacher/results/' + QUIZ_ID, { headers })
        .then(async res => {
            const json = await res.json().catch(() => ({}));
            if (!res.ok || !json.success) {
                throw new Error(res.status === 404 ? 'This quiz was not found, or it is not yours.' : (json.message || 'Could not load results.'));
            }
            return json.data;
        })
        .then(d => {
            data = d;
            const s = d.stats;

            $('quizTitle').textContent = d.quiz.title;
            $('quizMeta').textContent = 'Pass mark: ' + d.quiz.pass_marks + ' of ' + d.quiz.total_marks + ' marks';

            $('sAttempts').textContent = s.attempts;
            $('sAverage').textContent  = s.average + '%';
            $('sHighest').textContent  = s.highest + '%';
            $('sLowest').textContent   = s.lowest + '%';
            $('sPass').textContent     = s.pass_rate + '%';

            const passed = d.results.filter(r => r.passed).length;
            $('cAll').textContent = d.results.length;
            $('cPassed').textContent = passed;
            $('cFailed').textContent = d.results.length - passed;

            renderChart(d.buckets);
            renderPending(d.pending);
            renderTable();
        })
        .catch(err => {
            $('quizTitle').textContent = 'Results unavailable';
            $('err').textContent = err.message;
            $('err').hidden = false;
            $('rows').innerHTML = '<tr><td colspan="7" class="rd-empty">Nothing to show.</td></tr>';
        });

    $('search').addEventListener('input', () => data && renderTable());
    $('sort').addEventListener('change', () => data && renderTable());
    $('export').addEventListener('click', () => data && exportCsv());

    $('chips').addEventListener('click', function (e) {
        const btn = e.target.closest('button');
        if (!btn || !data) return;
        filter = btn.dataset.filter;
        this.querySelectorAll('button').forEach(b => b.classList.toggle('active', b === btn));
        renderTable();
    });
})();
</script>
@endpush