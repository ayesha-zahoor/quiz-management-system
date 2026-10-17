{{-- resources/views/institute/results.blade.php --}}
@extends('layouts.institute')

@section('title', 'Student Results')
@section('user-role', 'Institute Admin')
@section('page-title', 'Student Results')
@section('page-description', 'See how students are achieving across your institute')

@section('content')
<div class="container-fluid px-0 ar">

    <div class="ar-alert" id="err" hidden></div>

    {{-- Filters --}}
    <div class="ar-filters">
        <div>
            <h4 class="mb-1">Results overview</h4>
            <p class="text-muted mb-0">Based on completed quiz attempts.</p>
        </div>
        <div class="ar-selects">
            <select id="fClass" aria-label="Filter by class"><option value="">All classes</option></select>
            <select id="fQuiz" aria-label="Filter by quiz"><option value="">All quizzes</option></select>
            <button type="button" class="btn btn-light" id="fReset"><i class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
        </div>
    </div>

    {{-- Summary --}}
    <div class="row g-3 mb-4" id="kpis">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center">
                <div class="icon-box me-3"><i class="bi bi-journal-check"></i></div>
                <div><small class="text-muted">Completed attempts</small><h4 class="mb-0" id="kAttempts">0</h4></div>
            </div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center">
                <div class="icon-box me-3"><i class="bi bi-people"></i></div>
                <div><small class="text-muted">Students who attempted</small><h4 class="mb-0" id="kStudents">0</h4></div>
            </div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center">
                <div class="icon-box me-3"><i class="bi bi-graph-up-arrow"></i></div>
                <div><small class="text-muted">Average score</small><h4 class="mb-0" id="kAverage">0%</h4></div>
            </div></div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100"><div class="card-body d-flex align-items-center">
                <div class="icon-box me-3"><i class="bi bi-patch-check"></i></div>
                <div><small class="text-muted">Pass rate</small><h4 class="mb-0" id="kPass">0%</h4></div>
            </div></div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        {{-- Performance by class --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="mb-1">Performance by class</h5>
                    <p class="text-muted small mb-3">Average score and pass rate for each class.</p>
                    <div id="byClass"></div>
                </div>
            </div>
        </div>

        {{-- Top students --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h5 class="mb-1">Top students</h5>
                    <p class="text-muted small mb-3">Highest average score.</p>
                    <div id="topStudents"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Performance by quiz --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-0">
            <div class="px-4 pt-4 pb-2">
                <h5 class="mb-1">Performance by quiz</h5>
                <p class="text-muted small mb-0">Which quizzes students find easy or hard.</p>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0 ar-table">
                    <thead><tr><th class="ps-4">Quiz</th><th>Class</th><th>Attempts</th><th>Average score</th><th class="pe-4">Pass rate</th></tr></thead>
                    <tbody id="byQuiz"><tr><td colspan="5" class="text-center py-4">Loading...</td></tr></tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent attempts --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="px-4 pt-4 pb-2">
                <h5 class="mb-1">Recent attempts</h5>
                <p class="text-muted small mb-0">The latest completed quizzes.</p>
            </div>
            <div class="table-responsive">
                <table class="table align-middle mb-0 ar-table">
                    <thead><tr><th class="ps-4">Student</th><th>Quiz</th><th>Score</th><th>Result</th><th class="pe-4">Date</th></tr></thead>
                    <tbody id="recent"><tr><td colspan="5" class="text-center py-4">Loading...</td></tr></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .ar-alert { margin-bottom: 16px; padding: 14px 18px; border-radius: 12px; background: #fdecec; color: #b42318; border: 1px solid #f7caca; }

    .ar-filters { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; margin-bottom: 22px; }
    .ar-selects { display: flex; flex-wrap: wrap; gap: 10px; }
    .ar-selects select { height: 40px; min-width: 170px; padding: 0 12px; border: 1px solid #e2e8f0; border-radius: 10px; background: #fff; font-size: 14px; }
    .ar-selects select:focus { outline: none; border-color: var(--primary-color, #84cc16); box-shadow: 0 0 0 3px rgba(132, 204, 22, .18); }

    .icon-box { width: 45px; height: 45px; flex: 0 0 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 20px;
                background: color-mix(in srgb, var(--primary-color, #84cc16) 14%, #fff); color: var(--secondary-color, #4d7c0f); }

    .ar-table thead th { background: #f8fafc; color: #475569; font-size: 13px; font-weight: 600; white-space: nowrap; padding: 12px; }
    .ar-table td { font-size: 14px; padding: 12px; }
    .ar-table small { color: #64748b; }

    /* Class rows */
    .cls-row { display: grid; grid-template-columns: minmax(0, 1.3fr) minmax(0, 1.5fr) 110px; align-items: center; gap: 14px; padding: 12px 0; border-top: 1px solid #eef2f6; }
    .cls-row:first-child { border-top: 0; }
    .cls-row strong { display: block; font-size: 14px; }
    .cls-row small { color: #64748b; font-size: 12px; }
    .meter { height: 8px; border-radius: 999px; background: #eef2f6; overflow: hidden; margin-bottom: 4px; }
    .meter > div { height: 100%; border-radius: 999px; }
    .meter.good > div { background: #16a34a; } .meter.mid > div { background: #d97706; } .meter.low > div { background: #dc2626; }

    .pill { display: inline-block; padding: 4px 11px; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .pill.pass { background: #dcfce7; color: #166534; }
    .pill.fail { background: #fee2e2; color: #b91c1c; }
    .pill.wait { background: #fef3c7; color: #92400e; }

    /* Top students */
    .top-row { display: flex; align-items: center; gap: 12px; padding: 11px 0; border-top: 1px solid #eef2f6; }
    .top-row:first-child { border-top: 0; }
    .rank { width: 32px; height: 32px; flex: 0 0 32px; display: grid; place-items: center; border-radius: 50%; background: #f1f5f9; color: #475569; font-weight: 800; font-size: 13px; }
    .rank.r1 { background: #fef3c7; color: #92400e; }
    .top-row .who { flex: 1; min-width: 0; }
    .top-row strong { display: block; font-size: 14px; overflow-wrap: anywhere; }
    .top-row small { color: #64748b; font-size: 12px; }
    .top-row b { font-size: 16px; }

    .empty-note { padding: 30px 0; text-align: center; color: #64748b; }

    @media (max-width: 575px) { .cls-row { grid-template-columns: 1fr 1fr; } .cls-row > :first-child { grid-column: 1 / -1; } .ar-selects, .ar-selects select, .ar-selects .btn { width: 100%; } }
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
    const fmtDate = (v) => v ? new Date(v).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' }) : '-';

    let filters = { classes: [], quizzes: [] };
    let filtersBuilt = false;

    function buildFilters(f) {
        filters = f;
        $('fClass').innerHTML = '<option value="">All classes</option>' +
            f.classes.map(c => `<option value="${c.id}">${esc(c.class_name)}</option>`).join('');
        fillQuizSelect();
        filtersBuilt = true;
    }

    // The quiz dropdown only lists quizzes of the chosen class
    function fillQuizSelect() {
        const classId = $('fClass').value;
        const list = filters.quizzes.filter(q => !classId || String(q.class_id) === classId);
        $('fQuiz').innerHTML = '<option value="">All quizzes</option>' +
            list.map(q => `<option value="${q.id}">${esc(q.title)}</option>`).join('');
    }

    function render(d) {
        $('kAttempts').textContent = d.stats.attempts;
        $('kStudents').textContent = d.stats.students;
        $('kAverage').textContent  = d.stats.average + '%';
        $('kPass').textContent     = d.stats.pass_rate + '%';

        $('byClass').innerHTML = d.by_class.length
            ? d.by_class.map(c => `
                <div class="cls-row">
                    <div><strong>${esc(c.class_name)}</strong><small>${c.attempts} attempts, ${c.students} students</small></div>
                    <div><div class="meter ${band(c.average)}"><div style="width:${Math.min(c.average, 100)}%"></div></div><small>${c.average}% average</small></div>
                    <div><span class="pill ${c.pass_rate >= 60 ? 'pass' : 'wait'}">${c.pass_rate}% passed</span></div>
                </div>`).join('')
            : '<div class="empty-note">No completed attempts yet.</div>';

        $('topStudents').innerHTML = d.top_students.length
            ? d.top_students.map((s, i) => `
                <div class="top-row">
                    <span class="rank ${i === 0 ? 'r1' : ''}">${i + 1}</span>
                    <div class="who"><strong>${esc(s.student)}</strong><small>${esc(s.roll_no || 'No roll number')}, ${s.attempts} ${s.attempts === 1 ? 'quiz' : 'quizzes'}</small></div>
                    <b>${s.average}%</b>
                </div>`).join('')
            : '<div class="empty-note">No results yet.</div>';

        $('byQuiz').innerHTML = d.by_quiz.length
            ? d.by_quiz.map(q => `
                <tr>
                    <td class="ps-4 fw-semibold">${esc(q.quiz)}</td>
                    <td>${esc(q.class_name || '-')}</td>
                    <td>${q.attempts}</td>
                    <td style="min-width:170px"><div class="meter ${band(q.average)}"><div style="width:${Math.min(q.average, 100)}%"></div></div><small>${q.average}%</small></td>
                    <td class="pe-4"><span class="pill ${q.pass_rate >= 60 ? 'pass' : 'wait'}">${q.pass_rate}%</span></td>
                </tr>`).join('')
            : '<tr><td colspan="5" class="text-center py-4 text-muted">No quizzes have been completed yet.</td></tr>';

        $('recent').innerHTML = d.recent.length
            ? d.recent.map(r => `
                <tr>
                    <td class="ps-4"><div class="fw-semibold">${esc(r.student)}</div><small>${esc(r.roll_no || '')}</small></td>
                    <td>${esc(r.quiz)}</td>
                    <td>${esc(r.score)} / ${esc(r.total)} <small>(${r.percentage}%)</small></td>
                    <td><span class="pill ${r.passed ? 'pass' : 'fail'}">${r.passed ? 'Passed' : 'Failed'}</span></td>
                    <td class="pe-4">${fmtDate(r.date)}</td>
                </tr>`).join('')
            : '<tr><td colspan="5" class="text-center py-4 text-muted">No attempts to show.</td></tr>';
    }

    function load() {
        const params = new URLSearchParams();
        if ($('fClass').value) params.set('class_id', $('fClass').value);
        if ($('fQuiz').value)  params.set('quiz_id', $('fQuiz').value);

        $('err').hidden = true;
        $('kpis').style.opacity = '.55';

        fetch('/api/instituteAdmin/results?' + params.toString(), { headers })
            .then(async res => {
                const json = await res.json().catch(() => ({}));
                if (!res.ok || !json.success) throw new Error(json.message || 'Could not load results.');
                return json.data;
            })
            .then(d => {
                if (!filtersBuilt) buildFilters(d.filters);
                render(d);
            })
            .catch(err => {
                $('err').textContent = err.message;
                $('err').hidden = false;
            })
            .finally(() => { $('kpis').style.opacity = ''; });
    }

    $('fClass').addEventListener('change', function () { fillQuizSelect(); load(); });
    $('fQuiz').addEventListener('change', load);
    $('fReset').addEventListener('click', function () {
        $('fClass').value = '';
        fillQuizSelect();
        $('fQuiz').value = '';
        load();
    });

    load();
})();
</script>
@endpush