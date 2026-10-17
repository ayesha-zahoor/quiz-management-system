{{-- resources/views/student/result-quiz.blade.php --}}
@extends('layouts.student')

@section('title', 'Quiz result')

@section('content')

<style>
    .rv { max-width: 860px; margin: 0 auto; }
    .rv-back { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 18px; color: var(--muted-color); font-weight: 700; }
    .rv-back:hover { color: var(--secondary-color); }
    .rv-eyebrow { color: var(--muted-color); font-weight: 600; margin-bottom: 4px; }
    .rv-title { margin: 0 0 22px; font-size: clamp(26px, 3vw, 34px); font-weight: 800; line-height: 1.2; overflow-wrap: anywhere; }

    .rv-alert { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 20px; padding: 14px 18px;
                border-radius: var(--radius-md); background: #fdecec; color: #b42318; border: 1px solid #f7caca; }
    .rv-alert button { margin-left: auto; border: 0; background: #b42318; color: #fff; border-radius: 10px; padding: 6px 14px; font-weight: 700; }

    .rv-card { overflow: hidden; background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }

    /* Verdict band: tinted green when passed, red when not */
    .rv-band { display: flex; align-items: center; gap: 18px; padding: 26px 30px; }
    .rv-band.passed { background: color-mix(in srgb, #22a06b 12%, var(--surface-color)); }
    .rv-band.failed { background: color-mix(in srgb, #e5484d 10%, var(--surface-color)); }
    .rv-badge { width: 58px; height: 58px; flex: 0 0 auto; display: grid; place-items: center; border-radius: 18px; font-size: 28px; color: #fff; background: var(--border-color); }
    .passed .rv-badge { background: #22a06b; }
    .failed .rv-badge { background: #e5484d; }
    .rv-verdict { margin: 0 0 4px; font-size: 22px; font-weight: 800; }
    .rv-detail { margin: 0; color: var(--muted-color); line-height: 1.6; }

    .rv-body { padding: 30px; }

    .rv-score { display: flex; align-items: baseline; gap: 14px; flex-wrap: wrap; margin-bottom: 30px; }
    .rv-big { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 68px; font-weight: 800; letter-spacing: -.05em; line-height: 1; }
    .rv-of { font-size: 22px; font-weight: 700; color: var(--muted-color); }
    .rv-pct { margin-left: auto; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 28px; font-weight: 800; }

    /* Score track with a pass-mark marker */
    .rv-trackwrap { position: relative; padding-top: 34px; margin-bottom: 8px; }
    .rv-track { height: 14px; border-radius: 999px; background: var(--border-color); overflow: hidden; }
    .rv-fill { height: 100%; width: 0; border-radius: 999px; background: #22a06b; transition: width .9s cubic-bezier(.2,.7,.2,1); }
    .failed .rv-fill { background: #e5484d; }
    .rv-mark { position: absolute; top: 0; bottom: -6px; width: 0; border-left: 2px dashed var(--text-color); opacity: .55; }
    .rv-mark-label { position: absolute; top: 0; white-space: nowrap; font-size: 12px; font-weight: 700; color: var(--text-color); transform: translateX(-50%); }
    .rv-scale { display: flex; justify-content: space-between; margin-top: 8px; color: var(--muted-color); font-size: 12px; }

    .rv-facts { display: grid; grid-template-columns: repeat(3, 1fr); margin-top: 28px; border-top: 1px solid var(--border-color); }
    .rv-fact { padding: 20px 0 0; }
    .rv-fact + .rv-fact { padding-left: 24px; border-left: 1px solid var(--border-color); }
    .rv-fact b { display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 24px; font-weight: 800; letter-spacing: -.03em; }
    .rv-fact span { color: var(--muted-color); font-size: 13px; }

    .rv-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 28px; }
    .rv-btn2 { display: inline-flex; align-items: center; gap: 8px; padding: 11px 20px; border-radius: 12px; font-weight: 800;
               border: 1px solid var(--border-color); color: var(--text-color); background: var(--surface-color); }
    .rv-btn2:hover { border-color: var(--primary-color); color: var(--text-color); }

    .is-loading .rv-big, .is-loading .rv-pct, .is-loading .rv-fact b { color: transparent; background: var(--border-color); border-radius: 10px; animation: rvPulse 1.2s ease-in-out infinite; }
    .is-loading .rv-big { width: 120px; }
    @keyframes rvPulse { 50% { opacity: .45; } }

    @media (max-width: 560px) {
        .rv-band, .rv-body { padding: 22px; }
        .rv-big { font-size: 54px; }
        .rv-pct { margin-left: 0; width: 100%; }
        .rv-facts { grid-template-columns: 1fr; }
        .rv-fact + .rv-fact { padding-left: 0; border-left: 0; border-top: 1px solid var(--border-color); margin-top: 16px; }
        .rv-actions .btn, .rv-actions a { width: 100%; justify-content: center; }
    }
    @media (prefers-reduced-motion: reduce) { .rv-fill { transition: none; } .is-loading * { animation: none !important; } }
</style>

<div class="student-content">
<div class="rv is-loading" id="rv">

    <a class="rv-back" href="{{ url('/student/results') }}"><i class="bi bi-arrow-left"></i> My results</a>

    <div class="rv-eyebrow">Quiz result</div>
    <h1 class="rv-title">{{ $quiz->title ?? 'Quiz result' }}</h1>

    <div class="rv-alert" id="rv-alert" hidden>
        <i class="bi bi-exclamation-circle fs-5"></i>
        <span id="rv-alert-text"></span>
        <button type="button" id="rv-retry">Try again</button>
    </div>

    <article class="rv-card" id="rv-card">
        <div class="rv-band" id="rv-band">
            <div class="rv-badge"><i class="bi bi-hourglass-split" id="rv-badge-icon"></i></div>
            <div>
                <h2 class="rv-verdict" id="rv-verdict">Loading your result</h2>
                <p class="rv-detail" id="rv-detail">One moment while we check your score.</p>
            </div>
        </div>

        <div class="rv-body">
            <div class="rv-score">
                <span class="rv-big" id="rv-score">0</span>
                <span class="rv-of">out of <span id="rv-total">0</span> marks</span>
                <span class="rv-pct"><span id="rv-percentage">0</span>%</span>
            </div>

            <div class="rv-trackwrap">
                <span class="rv-mark-label" id="rv-mark-label"></span>
                <span class="rv-mark" id="rv-mark"></span>
                <div class="rv-track"><div class="rv-fill" id="rv-fill"></div></div>
                <div class="rv-scale"><span>0</span><span id="rv-scale-end"></span></div>
            </div>

            <div class="rv-facts">
                <div class="rv-fact"><b id="rv-f-score">0</b><span>Your score</span></div>
                <div class="rv-fact"><b id="rv-f-pass">0</b><span>Marks needed to pass</span></div>
                <div class="rv-fact"><b id="rv-f-total">0</b><span>Total marks</span></div>
            </div>

            <div class="rv-actions">
                <a class="btn btn-institute px-4 py-2" href="{{ url('/student/results') }}"><i class="bi bi-graph-up-arrow me-2"></i>All my results</a>
                <a class="rv-btn2" href="{{ url('/student/quizzes') }}"><i class="bi bi-journal-check"></i>Browse quizzes</a>
            </div>
        </div>
    </article>

</div>
</div>

<script>
(function () {
    const API_URL = "/api/student/result-quiz/{{ $quiz->id }}";
    const ME_URL  = "/api/me";
    const token   = localStorage.getItem('api_token');

    const $ = (id) => document.getElementById(id);
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const headers = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
    if (token) headers['Authorization'] = 'Bearer ' + token;

    function countUp(el, to) {
        to = Number(to) || 0;
        if (reduceMotion || to === 0) { el.textContent = to; return; }
        const start = performance.now(), dur = 700;
        (function tick(t) {
            const p = Math.min((t - start) / dur, 1);
            el.textContent = Math.round(to * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(tick);
        })(start);
    }

    // Fills the top-right name, avatar and institute (same as the other student pages)
    async function loadUser() {
        try {
            const res = await fetch(ME_URL, { headers });
            if (!res.ok) return;
            const json = await res.json();
            const u = json.user || json.data || json;
            const name = u && u.name;
            if (!name) return;
            $('studentDisplayName').textContent = name;
            $('studentAvatarInitials').textContent = name.split(' ').map(w => w[0]).slice(0, 2).join('').toUpperCase();
            if (u.institute && u.institute.name) $('studentInstituteName').textContent = u.institute.name;
        } catch (e) { /* keep defaults */ }
    }

    async function loadResult() {
        $('rv').classList.add('is-loading');
        $('rv-alert').hidden = true;
        try {
            const res  = await fetch(API_URL, { headers, credentials: 'same-origin' });
            const json = await res.json().catch(() => ({}));
            if (!res.ok || !json.status) {
                throw new Error(json.message || (res.status === 401
                    ? 'You are not logged in. Please log in again.'
                    : 'Could not load the result.'));
            }

            const d = json.data;
            const passed = d.result === 'Passed';
            const total  = Number(d.total_marks) || 0;
            const score  = Number(d.score) || 0;
            const pass   = Number(d.pass_marks) || 0;

            $('rv').classList.remove('is-loading');
            $('rv-card').classList.toggle('passed', passed);
            $('rv-card').classList.toggle('failed', !passed);
            $('rv-band').className = 'rv-band ' + (passed ? 'passed' : 'failed');
            $('rv-badge-icon').className = 'bi ' + (passed ? 'bi-trophy-fill' : 'bi-arrow-repeat');

            if (passed) {
                $('rv-verdict').textContent = 'Well done, you passed!';
                $('rv-detail').textContent = score > pass
                    ? 'You finished ' + (score - pass) + ' ' + (score - pass === 1 ? 'mark' : 'marks') + ' above the pass mark.'
                    : 'You reached the pass mark exactly.';
            } else {
                const gap = pass - score;
                $('rv-verdict').textContent = 'Not quite there yet';
                $('rv-detail').textContent = 'You were ' + gap + ' ' + (gap === 1 ? 'mark' : 'marks') + ' short of the pass mark. Keep practising and try again.';
            }

            countUp($('rv-score'), score);
            countUp($('rv-percentage'), d.percentage);
            $('rv-total').textContent = total;
            $('rv-f-score').textContent = score;
            $('rv-f-pass').textContent = pass;
            $('rv-f-total').textContent = total;
            $('rv-scale-end').textContent = total;

            // Pass-mark marker on the track
            const passPos = total > 0 ? Math.min(pass / total * 100, 100) : 0;
            $('rv-mark').style.left = passPos + '%';
            const label = $('rv-mark-label');
            label.textContent = 'Pass mark ' + pass;
            label.style.left = passPos + '%';
            label.style.transform = passPos > 88 ? 'translateX(-100%)' : passPos < 12 ? 'translateX(0)' : 'translateX(-50%)';

            const fillPct = total > 0 ? Math.min(score / total * 100, 100) : 0;
            requestAnimationFrame(() => { $('rv-fill').style.width = fillPct + '%'; });
        } catch (err) {
            $('rv').classList.remove('is-loading');
            $('rv-alert-text').textContent = err.message;
            $('rv-alert').hidden = false;
            $('rv-verdict').textContent = 'Result unavailable';
            $('rv-detail').textContent = 'We could not load this result right now.';
        }
    }

    $('rv-retry').addEventListener('click', loadResult);
    loadUser();
    loadResult();
})();
</script>
@endsection