{{-- resources/views/student/dashboard.blade.php --}}
@extends('layouts.student')

@section('title', 'Dashboard')

@section('content')

<style>
    /* All colors come from the layout's theme variables (set from the database). */
    .sd { max-width: 1180px; margin: 0 auto; }

    /* ---------- Header ---------- */
    .sd-head { display: flex; justify-content: space-between; align-items: flex-end; gap: 16px; flex-wrap: wrap; margin-bottom: 26px; }
    .sd-date { color: var(--muted-color); font-weight: 600; margin-bottom: 4px; }
    .sd-title { font-size: 32px; font-weight: 800; margin: 0; line-height: 1.15; }

    /* ---------- Error banner ---------- */
    .sd-alert { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; padding: 14px 18px; margin-bottom: 20px;
                border-radius: var(--radius-md); background: #fdecec; color: #b42318; border: 1px solid #f7caca; }
    .sd-alert button { margin-left: auto; border: 0; background: #b42318; color: #fff; border-radius: 10px; padding: 6px 14px; font-weight: 700; }

    /* ---------- KPI tiles ---------- */
    .sd-kpis { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 16px; }
    .sd-card { background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }
    .sd-kpi { padding: 20px 22px 22px; transition: transform .2s ease, box-shadow .2s ease; }
    .sd-kpi:hover { transform: translateY(-3px); box-shadow: var(--shadow-hover); }
    .sd-kpi-top { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
    .sd-ico { width: 42px; height: 42px; display: grid; place-items: center; border-radius: 13px; font-size: 19px; flex: 0 0 auto; }
    .sd-kpi-label { font-weight: 700; color: var(--text-color); }
    .sd-num { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 44px; font-weight: 800; letter-spacing: -.04em; line-height: 1; min-width: 44px; }
    .sd-cap { color: var(--muted-color); margin-top: 8px; font-size: 13px; }

    .tone-available { background: var(--primary-soft); color: var(--secondary-color); }
    .tone-total     { background: var(--border-color);  color: var(--text-color); }
    .tone-completed { background: color-mix(in srgb, var(--primary-color) 24%, var(--surface-color)); color: var(--secondary-color); }
    .tone-progress  { background: color-mix(in srgb, var(--accent-color) 20%, var(--surface-color)); color: color-mix(in srgb, var(--accent-color) 70%, #000); }

    /* loading skeleton */
    .is-loading .sd-num { color: transparent; background: var(--border-color); border-radius: 10px; width: 56px; height: 44px; animation: sdPulse 1.2s ease-in-out infinite; }
    @keyframes sdPulse { 50% { opacity: .45; } }

    /* ---------- Lower row ---------- */
    .sd-row { display: grid; grid-template-columns: 1.35fr 1fr; gap: 16px; }

    .sd-progress { padding: 26px 28px; display: flex; align-items: center; gap: 34px; flex-wrap: wrap; }
    .sd-ring { position: relative; width: 190px; height: 190px; flex: 0 0 auto; }
    .sd-ring svg { width: 100%; height: 100%; transform: rotate(-90deg); }
    .sd-ring circle { fill: none; stroke-width: 13; transition: stroke-dasharray .9s cubic-bezier(.2,.7,.2,1); }
    .sd-ring-track { stroke: var(--border-color); }
    .sd-ring-done  { stroke: var(--primary-color); }
    .sd-ring-open  { stroke: var(--accent-color); }
    .sd-ring-center { position: absolute; inset: 0; display: grid; place-content: center; text-align: center; }
    .sd-ring-pct { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 40px; font-weight: 800; letter-spacing: -.04em; line-height: 1; }
    .sd-ring-sub { color: var(--muted-color); font-size: 12px; margin-top: 4px; }

    .sd-legend { flex: 1 1 220px; min-width: 200px; }
    .sd-legend h5 { font-size: 18px; font-weight: 800; margin: 0 0 4px; }
    .sd-legend p { color: var(--muted-color); margin: 0 0 18px; }
    .sd-leg-row { display: flex; align-items: center; gap: 10px; padding: 11px 0; border-top: 1px solid var(--border-color); font-weight: 600; }
    .sd-dot { width: 11px; height: 11px; border-radius: 50%; flex: 0 0 auto; }
    .sd-leg-row b { margin-left: auto; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 17px; }

    .sd-next { position: relative; overflow: hidden; padding: 28px; display: flex; flex-direction: column; justify-content: space-between;
               background: var(--secondary-color); color: #fff; border: 0; min-height: 250px; }
    .sd-next-icon { width: 48px; height: 48px; display: grid; place-items: center; border-radius: 15px; font-size: 22px; background: rgba(255,255,255,.16); margin-bottom: 18px; }
    .sd-next h4 { font-size: 24px; font-weight: 800; margin: 0 0 8px; max-width: 18ch; line-height: 1.2; }
    .sd-next p { margin: 0 0 22px; opacity: .85; max-width: 36ch; line-height: 1.6; }
    .sd-next-btn { align-self: flex-start; display: inline-flex; align-items: center; gap: 8px; padding: 11px 20px; border-radius: 12px; font-weight: 800;
                   background: #fff; color: var(--secondary-color); transition: transform .2s ease; }
    .sd-next-btn:hover { transform: translateY(-2px); color: var(--secondary-color); }
    .sd-next-bg { position: absolute; right: -26px; bottom: -34px; font-size: 190px; line-height: 1; opacity: .08; pointer-events: none; }

    @media (max-width: 1000px) { .sd-kpis { grid-template-columns: repeat(2, 1fr); } .sd-row { grid-template-columns: 1fr; } }
    @media (max-width: 520px)  { .sd-title { font-size: 26px; } .sd-num { font-size: 36px; } .sd-progress { padding: 22px; gap: 22px; } .sd-ring { margin: 0 auto; } }
    @media (prefers-reduced-motion: reduce) { .sd-ring circle, .sd-kpi, .sd-next-btn { transition: none; } .is-loading .sd-num { animation: none; } }
</style>

<div class="student-content">
<div class="sd is-loading" id="sd">

    {{-- Error banner (hidden unless something fails) --}}
    <div class="sd-alert" id="sd-alert" hidden>
        <i class="bi bi-exclamation-circle fs-5"></i>
        <span id="sd-alert-text"></span>
        <button type="button" id="sd-retry">Try again</button>
    </div>

    {{-- Header --}}
    <header class="sd-head">
        <div>
            <div class="sd-date" id="sd-date"></div>
            <h2 class="sd-title"><span id="sd-greeting">Welcome</span><span id="sd-name"></span></h2>
        </div>
        <a class="btn btn-institute px-4 py-2" href="{{ url('/student/quizzes') }}">
            <i class="bi bi-journal-check me-2"></i>Browse quizzes
        </a>
    </header>

    {{-- KPI tiles --}}
    <section class="sd-kpis" aria-label="Quiz summary">
        <article class="sd-card sd-kpi">
            <div class="sd-kpi-top"><span class="sd-ico tone-available"><i class="bi bi-journal-check"></i></span><span class="sd-kpi-label">Available</span></div>
            <div class="sd-num" id="sd-available">0</div>
            <div class="sd-cap">Quizzes ready for you</div>
        </article>
        <article class="sd-card sd-kpi">
            <div class="sd-kpi-top"><span class="sd-ico tone-total"><i class="bi bi-collection"></i></span><span class="sd-kpi-label">Attempts</span></div>
            <div class="sd-num" id="sd-total">0</div>
            <div class="sd-cap">Every quiz you have started</div>
        </article>
        <article class="sd-card sd-kpi">
            <div class="sd-kpi-top"><span class="sd-ico tone-completed"><i class="bi bi-check2-circle"></i></span><span class="sd-kpi-label">Completed</span></div>
            <div class="sd-num" id="sd-completed">0</div>
            <div class="sd-cap">Submitted and scored</div>
        </article>
        <article class="sd-card sd-kpi">
            <div class="sd-kpi-top"><span class="sd-ico tone-progress"><i class="bi bi-hourglass-split"></i></span><span class="sd-kpi-label">In progress</span></div>
            <div class="sd-num" id="sd-progress">0</div>
            <div class="sd-cap">Waiting to be finished</div>
        </article>
    </section>

    {{-- Progress ring + next step --}}
    <section class="sd-row">
        <article class="sd-card sd-progress">
            <div class="sd-ring" role="img" aria-label="Completion progress">
                <svg viewBox="0 0 120 120">
                    <circle class="sd-ring-track" cx="60" cy="60" r="52"/>
                    <circle class="sd-ring-open"  id="sd-arc-open" cx="60" cy="60" r="52" stroke-dasharray="0 326.7"/>
                    <circle class="sd-ring-done"  id="sd-arc-done" cx="60" cy="60" r="52" stroke-dasharray="0 326.7"/>
                </svg>
                <div class="sd-ring-center">
                    <div class="sd-ring-pct"><span id="sd-pct">0</span>%</div>
                    <div class="sd-ring-sub">completed</div>
                </div>
            </div>
            <div class="sd-legend">
                <h5>Your progress</h5>
                <p id="sd-summary">Loading your numbers...</p>
                <div class="sd-leg-row"><span class="sd-dot" style="background:var(--primary-color)"></span>Completed<b id="sd-leg-done">0</b></div>
                <div class="sd-leg-row"><span class="sd-dot" style="background:var(--accent-color)"></span>In progress<b id="sd-leg-open">0</b></div>
            </div>
        </article>

        <article class="sd-card sd-next">
            <div>
                <div class="sd-next-icon"><i class="bi bi-lightning-charge" id="sd-next-icon"></i></div>
                <h4 id="sd-next-title">Checking your quizzes</h4>
                <p id="sd-next-text">One moment while we load your activity.</p>
            </div>
            <a class="sd-next-btn" id="sd-next-btn" href="{{ url('/student/quizzes') }}">
                <i class="bi bi-play-fill"></i><span id="sd-next-label">Open my quizzes</span>
            </a>
            <i class="bi bi-mortarboard-fill sd-next-bg"></i>
        </article>
    </section>

</div>
</div>

<script>
(function () {
    const API_URL = "/api/student/dashboard";
    const ME_URL  = "/api/me";
    const token   = localStorage.getItem('api_token');
    const CIRC    = 2 * Math.PI * 52; // ring circumference

    const $ = (id) => document.getElementById(id);
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const headers = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' };
    if (token) headers['Authorization'] = 'Bearer ' + token;

    // ---- Header: date + greeting (no network needed) ----
    const now = new Date();
    const hour = now.getHours();
    $('sd-greeting').textContent = hour < 12 ? 'Good morning' : hour < 18 ? 'Good afternoon' : 'Good evening';
    $('sd-date').textContent = now.toLocaleDateString(undefined, { weekday: 'long', month: 'long', day: 'numeric' });

    // ---- Count-up animation ----
    function countUp(el, to) {
        if (reduceMotion || to === 0) { el.textContent = to; return; }
        const start = performance.now(), dur = 700;
        (function tick(t) {
            const p = Math.min((t - start) / dur, 1);
            el.textContent = Math.round(to * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(tick);
        })(start);
    }

    // ---- Top-right name, avatar, institute ----
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
            $('sd-name').textContent = ', ' + name.split(' ')[0];
            if (u.institute && u.institute.name) $('studentInstituteName').textContent = u.institute.name;
        } catch (e) { /* keep defaults */ }
    }

    // ---- "Next step" card changes with the student's situation ----
    function setNext(d) {
        const plural = (n, a, b) => n === 1 ? a : b;
        let icon, title, text, label;
        if (d.in_progress_attempts > 0) {
            icon = 'bi-hourglass-split'; label = 'Resume quizzes';
            title = 'Pick up where you left off';
            text = 'You have ' + d.in_progress_attempts + ' unfinished ' + plural(d.in_progress_attempts, 'quiz', 'quizzes') + '. Finish ' + plural(d.in_progress_attempts, 'it', 'them') + ' to see your results.';
        } else if (d.available_quizzes > 0) {
            icon = 'bi-lightning-charge'; label = 'Start a quiz';
            title = 'New quizzes are waiting';
            text = d.available_quizzes + ' ' + plural(d.available_quizzes, 'quiz is', 'quizzes are') + ' available for you right now.';
        } else {
            icon = 'bi-patch-check'; label = 'View my quizzes';
            title = 'You are all caught up';
            text = 'Nothing is pending. New quizzes from your teachers will show up here.';
        }
        $('sd-next-icon').className = 'bi ' + icon;
        $('sd-next-title').textContent = title;
        $('sd-next-text').textContent = text;
        $('sd-next-label').textContent = label;
    }

    // ---- Main data ----
    async function loadDashboard() {
        $('sd').classList.add('is-loading');
        $('sd-alert').hidden = true;
        try {
            const res  = await fetch(API_URL, { headers, credentials: 'same-origin' });
            const json = await res.json().catch(() => ({}));
            if (!res.ok || !json.success) {
                throw new Error(json.message || (res.status === 401
                    ? 'You are not logged in. Please log in again.'
                    : 'Could not load your dashboard.'));
            }

            const d = json.data;
            $('sd').classList.remove('is-loading');

            countUp($('sd-available'), d.available_quizzes);
            countUp($('sd-total'),     d.total_attempts);
            countUp($('sd-completed'), d.completed_attempts);
            countUp($('sd-progress'),  d.in_progress_attempts);
            $('sd-leg-done').textContent = d.completed_attempts;
            $('sd-leg-open').textContent = d.in_progress_attempts;

            // Ring
            const total = d.total_attempts;
            const doneFrac = total > 0 ? d.completed_attempts / total : 0;
            const openFrac = total > 0 ? d.in_progress_attempts / total : 0;
            const doneLen = CIRC * doneFrac, openLen = CIRC * openFrac;
            $('sd-pct').textContent = Math.round(doneFrac * 100);
            $('sd-summary').textContent = total === 0
                ? 'No attempts yet. Your first quiz will show up here.'
                : 'You finished ' + d.completed_attempts + ' of ' + total + ' attempts.';

            const open = $('sd-arc-open');
            open.style.strokeDashoffset = -doneLen;       // open arc starts where done arc ends
            requestAnimationFrame(() => {
                $('sd-arc-done').setAttribute('stroke-dasharray', doneLen + ' ' + CIRC);
                open.setAttribute('stroke-dasharray', openLen + ' ' + CIRC);
            });

            setNext(d);
        } catch (err) {
            $('sd').classList.remove('is-loading');
            $('sd-alert-text').textContent = err.message;
            $('sd-alert').hidden = false;
            $('sd-next-title').textContent = 'Could not load your activity';
            $('sd-next-text').textContent = 'You can still open your quizzes from here.';
            $('sd-summary').textContent = 'Progress is unavailable right now.';
        }
    }

    $('sd-retry').addEventListener('click', loadDashboard);
    loadUser();
    loadDashboard();
})();
</script>
@endsection