{{-- resources/views/student/takeQuiz.blade.php --}}
@extends('layouts.student')

@section('title', 'Take Quiz')

@section('content')
<div class="student-content">
<div class="tq">

<header class="qh">
    <div class="qh-in">
        <button type="button" class="icon-btn" id="exitBtn" aria-label="Leave quiz"><i class="bi bi-x-lg"></i></button>

        <div class="qh-title">
            <h1 id="quizTitle">Quiz</h1>
            <div id="quizSubtitle">Loading...</div>
        </div>

        <div class="timer" id="timerBox" hidden>
            <i class="bi bi-clock"></i><span id="timer">--:--</span>
        </div>
    </div>
</header>


    <div class="state" id="loadingState">
        <div class="spinner-border text-success mb-3" role="status"></div>
        <h4>Getting your quiz ready</h4>
        <p class="text-secondary mb-0">One moment please.</p>
    </div>

    <div class="state" id="errorState" hidden>
        <i class="bi bi-exclamation-circle text-danger"></i>
        <h4 class="mt-3">We couldn't open this quiz</h4>
        <p class="text-secondary" id="errorMessage">Please try again.</p>
        <div class="d-flex justify-content-center gap-2">
            <a href="/student/quizzes" class="btn-q">Back to my quizzes</a>
            <button type="button" class="btn-q primary" id="retryBtn">Try again</button>
        </div>
    </div>

    <div id="quizContent" hidden>
        <div class="q-layout">

            <section>
                <div class="q-card" id="questionCard">

                    <div class="q-top">
                        <span class="pill" id="counter">Question 1</span>
                        <span class="marks"><i class="bi bi-award me-1"></i><span id="marks">1 mark</span></span>
                        <button type="button" class="flag-btn" id="flagBtn"><i class="bi bi-flag"></i> <span>Mark for review</span></button>
                    </div>

                    <div class="q-progress"><div id="progressBar"></div></div>
                    <div class="q-progress-text" id="progressText">0 of 0 answered</div>

                    <div class="q-image" id="imageWrap" hidden><img id="qImage" src="" alt="Question picture"></div>

                    <h2 class="q-text" id="qText"></h2>

                    {{-- The one Listen button: reads the question and then each answer --}}
                    <p class="q-urdu" id="qTextUrdu" dir="rtl" lang="ur" hidden></p>

                    <div class="listen-row">
                        <button type="button" class="listen" id="listenBtn" hidden>
                            <i class="bi bi-volume-up-fill"></i><span>Listen</span>
                        </button>

                        <div class="lang-toggle" id="langToggle" role="group" aria-label="Listen in">
                            <button type="button" data-lang="en" class="active">English</button>
                            <button type="button" data-lang="ur" lang="ur">اردو</button>
                        </div>
                    </div>

                    <div class="options" id="options" role="radiogroup" aria-label="Answer options"></div>

                    <div class="q-foot">
                        <button type="button" class="btn-q" id="prevBtn"><i class="bi bi-arrow-left"></i> Back</button>
                        <div class="save-state" id="saveState" aria-live="polite"></div>
                        <button type="button" class="btn-q primary" id="nextBtn">Next <i class="bi bi-arrow-right"></i></button>
                    </div>

                </div>
            </section>

            <aside>
                <div class="q-side-card">
                    <h3 id="navTitle">Question navigator</h3>
                    <p>Tap a number to jump to that question.</p>

                    <div class="grid" id="grid"></div>

                    <div class="legend">
                        <span class="l-answered">Answered</span>
                        <span class="l-current">Current</span>
                        <span class="l-flag">For review</span>
                    </div>

                    <div class="stat-row"><span>Total questions</span><strong id="totalQuestions">0</strong></div>
                    <div class="stat-row"><span>Answered</span><strong id="answeredCount">0</strong></div>

                    <button type="button" class="btn-q primary submit-side" id="submitBtn"><i class="bi bi-send"></i> Finish quiz</button>
                </div>
            </aside>

        </div>
    </div>


</div>
</div>




{{-- Finish quiz --}}
<div class="modal fade" id="submitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4 text-center">
                <div class="modal-icon"><i class="bi bi-send-check"></i></div>
                <h4>Finish your quiz?</h4>
                <p class="text-secondary" id="submitMessage"></p>
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button" class="btn-q" data-bs-dismiss="modal">Keep going</button>
                    <button type="button" class="btn-q primary" id="confirmSubmitBtn">Yes, finish</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Leave quiz --}}
<div class="modal fade" id="leaveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4 text-center">
                <div class="modal-icon"><i class="bi bi-box-arrow-left"></i></div>
                <h4>Leave the quiz?</h4>
                <p class="text-secondary">Your answers are saved, but the timer keeps running while you are away.</p>
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button" class="btn-q" data-bs-dismiss="modal">Stay here</button>
                    <a href="/student/quizzes" class="btn-q primary">Leave</a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Time is up --}}
<div class="overlay" id="timeUp" hidden>
    <div class="overlay-card">
        <div class="spinner-border text-success mb-3" id="timeUpSpinner" role="status"></div>
        <h4 id="timeUpTitle">Time's up!</h4>
        <p class="text-secondary mb-0" id="timeUpText">Sending your answers...</p>
        <button type="button" class="btn-q primary mt-3" id="timeUpRetry" hidden>Try again</button>
    </div>
</div>

<div class="toast-box" id="toast" hidden></div>



@endsection

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu&display=swap" rel="stylesheet">
<style>
        [hidden] { display: none !important; }

        .tq button { font: inherit; }

        /* ---------- Header ---------- */
        .tq { max-width: 1240px; margin: 0 auto; }
        .qh { position: sticky; top: 92px; z-index: 1010; margin-bottom: 20px; background: var(--surface-color); border: 1px solid var(--border-color); border-radius: 18px; box-shadow: var(--shadow-soft); }
        .qh-in { display: flex; align-items: center; gap: 14px; padding: 12px 16px; }
        .qh-title { flex: 1; min-width: 0; }
        .qh-title h1 { margin: 0; font-size: 18px; font-weight: 800; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .qh-title div { margin-top: 2px; color: var(--muted-color); font-size: 12px; }

        .icon-btn { flex: 0 0 auto; width: 42px; height: 42px; display: grid; place-items: center; border: 1px solid var(--border-color); border-radius: 12px; background: var(--surface-color); color: var(--text-color); }
        .icon-btn:hover { background: var(--primary-soft); }

        .timer { display: inline-flex; align-items: center; gap: 8px; padding: 10px 15px; border-radius: 12px; background: var(--primary-soft); color: var(--secondary-color); font-weight: 800; font-variant-numeric: tabular-nums; transition: background .3s, color .3s; }
        .timer.warn { background: #fee2e2; color: #b91c1c; animation: pulse 1.4s ease-in-out infinite; }
        @keyframes pulse { 50% { transform: scale(1.04); } }

        /* ---------- Layout ---------- */
        .q-layout { display: grid; grid-template-columns: minmax(0, 1fr) 320px; gap: 22px; align-items: start; }

        .q-card, .q-side-card, .state { background: var(--surface-color); border: 1px solid var(--border-color); border-radius: 20px; box-shadow: var(--shadow-soft); }
        .q-card { padding: 26px; animation: appear .3s ease both; }
        .q-side-card { position: sticky; top: 190px; padding: 22px; }
        @keyframes appear { from { opacity: 0; transform: translateY(8px); } to { opacity: 1; transform: none; } }

        .state { padding: 70px 20px; text-align: center; }
        .state i { font-size: 44px; }

        /* ---------- Question ---------- */
        .q-top { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin-bottom: 16px; }
        .pill { padding: 7px 13px; border-radius: 10px; background: var(--primary-soft); color: var(--secondary-color); font-size: 13px; font-weight: 800; }
        .marks { color: var(--muted-color); font-size: 13px; }
        .flag-btn { margin-left: auto; display: inline-flex; align-items: center; gap: 7px; padding: 7px 12px; border: 1px solid var(--border-color); border-radius: 10px; background: var(--surface-color); color: var(--muted-color); font-size: 13px; font-weight: 700; }
        .flag-btn.on { border-color: #f59e0b; background: #fef3c7; color: #92400e; }

        .q-progress { height: 8px; border-radius: 99px; background: #e8eee7; overflow: hidden; }
        .q-progress div { height: 100%; width: 0; border-radius: 99px; background: var(--primary-color); transition: width .4s ease; }
        .q-progress-text { margin: 8px 0 18px; color: var(--muted-color); font-size: 12px; }

        .q-image { margin-bottom: 14px; text-align: center; }
        .q-image img { max-width: 100%; max-height: 300px; border-radius: 16px; border: 1px solid var(--border-color); background: #fff; }

        .q-text { margin: 4px 0 18px; font-size: 22px; font-weight: 700; line-height: 1.55; overflow-wrap: anywhere; }

        .listen { display: inline-flex; align-items: center; gap: 10px; margin-bottom: 0; padding: 11px 18px; border: 0; border-radius: 14px; background: var(--secondary-color); color: var(--on-secondary, #ffffff); font-weight: 800; transition: transform .2s ease; }
        .listen:hover { transform: translateY(-2px); }
        .listen.playing { background: var(--primary-color); color: var(--on-primary, #0b1120); }
        .listen i { font-size: 20px; }

        /* ---------- Options ---------- */
        .options { display: grid; gap: 12px; }

        .opt { display: flex; align-items: center; gap: 14px; width: 100%; padding: 15px 17px; border: 2px solid var(--border-color); border-radius: 16px; background: var(--surface-color); color: var(--text-color); text-align: left; transition: border-color .2s, background .2s, transform .15s; }
        .opt:hover { border-color: var(--primary-color); }
        .opt:active { transform: scale(.99); }
        .opt:focus-visible { outline: 3px solid color-mix(in srgb, var(--primary-color) 40%, transparent); outline-offset: 2px; }

        .letter { flex: 0 0 auto; width: 38px; height: 38px; display: grid; place-items: center; border-radius: 12px; background: var(--primary-soft); color: var(--secondary-color); font-weight: 800; }
        .opt-text { flex: 1; min-width: 0; overflow-wrap: anywhere; }
        .opt-img { width: 56px; height: 56px; flex: 0 0 auto; object-fit: contain; border-radius: 10px; background: #fff; }
        .check { margin-left: auto; font-size: 22px; color: var(--primary-color); opacity: 0; transform: scale(.6); transition: .2s; }

        .opt.selected { border-color: var(--primary-color); background: color-mix(in srgb, var(--primary-color) 10%, white); }
        .opt.selected .letter { background: var(--primary-color); color: var(--on-primary, #0b1120); }
        .opt.selected .check { opacity: 1; transform: none; }

        /* When options have pictures they become big picture tiles */
        .options.picture { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .options.picture .opt { flex-direction: column; justify-content: center; gap: 10px; padding: 16px 12px; text-align: center; }
        .options.picture .opt-img { width: 100%; height: 140px; }
        .options.picture .opt-text { flex: 0 0 auto; }
        .options.picture .check { position: absolute; margin: 0; }
        .options.picture .opt { position: relative; }
        .options.picture .check { top: 10px; right: 10px; }

        /* ---------- Footer buttons ---------- */
        .q-foot { display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-top: 24px; padding-top: 18px; border-top: 1px solid var(--border-color); }

        .btn-q { display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 48px; padding: 0 22px; border: 1px solid var(--border-color); border-radius: 14px; background: var(--surface-color); color: var(--text-color); font-weight: 800; transition: transform .2s, background .2s; }
        .btn-q:hover:not(:disabled) { background: var(--primary-soft); transform: translateY(-1px); }
        .btn-q:disabled { opacity: .45; cursor: not-allowed; }
        .btn-q.primary { border-color: var(--primary-color); background: var(--primary-color); color: var(--on-primary, #0b1120); }
        .btn-q.primary:hover:not(:disabled) { background: var(--secondary-color); border-color: var(--secondary-color); color: var(--on-secondary, #ffffff); }

        .save-state { flex: 1; text-align: center; color: var(--muted-color); font-size: 12px; }
        .save-state.error { color: #b91c1c; font-weight: 700; }
        .save-state.ok { color: var(--secondary-color); }

        /* ---------- Navigator ---------- */
        .q-side-card h3 { margin: 0 0 4px; font-size: 16px; font-weight: 800; }
        .q-side-card p { margin: 0 0 14px; color: var(--muted-color); font-size: 12px; }

        .grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 9px; margin-bottom: 18px; }
        .grid button { position: relative; height: 42px; border: 1px solid var(--border-color); border-radius: 11px; background: var(--surface-color); font-weight: 700; color: var(--text-color); }
        .grid button.answered { border-color: var(--primary-color); background: var(--primary-soft); color: var(--secondary-color); }
        .grid button.current { border-color: var(--secondary-color); background: var(--secondary-color); color: var(--on-secondary, #ffffff); }
        .grid button.flagged::after { content: ""; position: absolute; top: 4px; right: 4px; width: 8px; height: 8px; border-radius: 50%; background: #f59e0b; }

        .legend { display: flex; flex-wrap: wrap; gap: 6px 14px; margin-bottom: 16px; color: var(--muted-color); font-size: 12px; }
        .legend span::before { content: ""; display: inline-block; width: 10px; height: 10px; margin-right: 6px; border-radius: 3px; border: 1px solid var(--border-color); }
        .legend .l-answered::before { background: var(--primary-soft); border-color: var(--primary-color); }
        .legend .l-current::before { background: var(--secondary-color); border-color: var(--secondary-color); }
        .legend .l-flag::before { background: #f59e0b; border-color: #f59e0b; border-radius: 50%; }

        .stat-row { display: flex; justify-content: space-between; padding: 10px 0; border-top: 1px solid var(--border-color); font-size: 13px; }
        .stat-row span { color: var(--muted-color); }
        .submit-side { width: 100%; margin-top: 12px; }

        /* ---------- Time's up overlay + toast (above Bootstrap modals, which use 1050+) ---------- */
        .overlay { position: fixed; inset: 0; z-index: 2000; display: grid; place-items: center; padding: 20px; background: rgba(15, 23, 42, .6); backdrop-filter: blur(4px); }
        .overlay-card { width: 100%; max-width: 380px; padding: 32px; border-radius: 22px; background: var(--surface-color); text-align: center; }

        .toast-box { position: fixed; left: 50%; bottom: 24px; z-index: 2100; max-width: calc(100% - 32px); padding: 12px 18px; border-radius: 12px; background: #1f2937; color: #fff; font-size: 14px; transform: translateX(-50%); }

        .modal-content { border: 0; border-radius: 22px; }
        .modal-icon { width: 58px; height: 58px; display: grid; place-items: center; margin: 0 auto 14px; border-radius: 18px; background: var(--primary-soft); color: var(--secondary-color); font-size: 26px; }


        /* ======================================================================
           JUNIOR STYLE (primary and elementary): one big thing at a time
        ====================================================================== */

        body[data-style="junior"] { font-size: 17px; }
        body[data-style="junior"] .q-layout { grid-template-columns: 1fr; max-width: 860px; margin: 0 auto; }
        body[data-style="junior"] .q-side-card { position: static; }
        body[data-style="junior"] .q-card { padding: 30px; border-radius: 28px; }

        body[data-style="junior"] .flag-btn,
        body[data-style="junior"] .marks,
        body[data-style="junior"] .legend,
        body[data-style="junior"] .stat-row,
        body[data-style="junior"] .q-side-card p { display: none; }

        body[data-style="junior"] .q-text { font-size: 28px; }
        body[data-style="junior"] .opt { min-height: 78px; padding: 18px 22px; border-radius: 22px; font-size: 21px; font-weight: 700; }
        body[data-style="junior"] .letter { width: 50px; height: 50px; border-radius: 16px; font-size: 21px; }
        body[data-style="junior"] .check { font-size: 30px; }
        body[data-style="junior"] .options.picture .opt-img { height: 170px; }
        body[data-style="junior"] .options.picture .opt-text { font-size: 20px; }

        body[data-style="junior"] .listen { padding: 15px 26px; border-radius: 18px; font-size: 18px; }
        body[data-style="junior"] .btn-q { min-height: 60px; padding: 0 30px; border-radius: 18px; font-size: 18px; }
        body[data-style="junior"] .timer { padding: 10px 16px; font-size: 17px; }
        body[data-style="junior"] .grid { grid-template-columns: repeat(auto-fill, minmax(46px, 1fr)); }
        body[data-style="junior"] .grid button { height: 46px; border-radius: 50%; }
        body[data-style="junior"] .q-side-card { padding: 18px 22px; }

        @media (max-width: 991.98px) {
            .q-layout { grid-template-columns: 1fr; }
            .q-side-card { position: static; }
        }

        @media (max-width: 575.98px) {
            .qh { top: 80px; }
            .q-card { padding: 18px; }
            .q-text { font-size: 19px; }
            body[data-style="junior"] .q-text { font-size: 24px; }
            .options.picture { grid-template-columns: 1fr 1fr; gap: 10px; }
            .btn-q { padding: 0 16px; }
            body[data-style="junior"] .btn-q { padding: 0 20px; }
        }

        @media (prefers-reduced-motion: reduce) { * { animation: none !important; transition: none !important; } }
    

        /* ---------- Listen language switch + Urdu text ---------- */
        .listen-row { display: flex; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
        .lang-toggle { display: inline-flex; padding: 4px; gap: 4px; border: 1px solid var(--border-color); border-radius: 12px; background: var(--surface-color); }
        .lang-toggle button { min-width: 64px; padding: 7px 14px; border: 0; border-radius: 9px; background: transparent; color: var(--muted-color); font-weight: 700; font-size: 14px; }
        .lang-toggle button.active { background: var(--primary-soft); color: var(--secondary-color); }
        .lang-toggle button:focus-visible { outline: 3px solid color-mix(in srgb, var(--primary-color) 40%, transparent); outline-offset: 1px; }
        body[data-style="junior"] .lang-toggle button { padding: 10px 18px; font-size: 17px; }

        .q-urdu { margin: -6px 0 16px; padding: 10px 14px; border-radius: 12px; background: var(--primary-soft); color: var(--text-color);
                  font-family: 'Noto Nastaliq Urdu', 'Jameel Noori Nastaleeq', 'Segoe UI', serif; font-size: 20px; line-height: 2.1; }
</style>
@endpush

@push('scripts')
<script>
(function () {

    // Readable text colors on top of the institute's primary and secondary colors
    (function () {
        try {
            const config = JSON.parse(localStorage.getItem('student_config') || 'null');
            if (!config) return;

            const root = document.documentElement.style;

            [['primary_color', '--on-primary'], ['secondary_color', '--on-secondary']].forEach(function (pair) {
                const hex = (config[pair[0]] || '').replace('#', '');

                if (/^[0-9a-f]{6}$/i.test(hex)) {
                    const r = parseInt(hex.substr(0, 2), 16), g = parseInt(hex.substr(2, 2), 16), b = parseInt(hex.substr(4, 2), 16);
                    root.setProperty(pair[1], (r * 299 + g * 587 + b * 114) / 1000 > 150 ? '#0b1120' : '#ffffff');
                }
            });
        } catch (e) {}
    })();

    const token = localStorage.getItem('api_token');
    const attemptId = Number(window.location.pathname.split('/').filter(Boolean).pop());

    const LETTERS = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

    let quiz = {};              // the quiz (title, id, ...)
    let questions = [];         // its questions, each with options
    let answers = {};           // questionId -> chosen optionId
    let flags = new Set();      // questions marked for review (this device only)
    let index = 0;              // the question on screen
    let endAt = null;           // when the timer ends (milliseconds), or null for no limit
    let timerHandle = null;
    let saveChain = Promise.resolve();   // answers are saved one after another, in order
    let submitting = false;

    if (!token) {
        window.location.href = '/';
    }


    /* ---------------------------------------------------------------
       Small helpers
    --------------------------------------------------------------- */

    function byId(id) { return document.getElementById(id); }

    function esc(text) {
        const div = document.createElement('div');
        div.textContent = text == null ? '' : text;
        return div.innerHTML.replace(/"/g, '&quot;');
    }

    function safeUrl(url) {
        return /^(https?:)?\/\//i.test(url || '') || /^\//.test(url || '') ? url : '';
    }

    function isJunior() {
        return document.body.dataset.style === 'junior';
    }

    // Talks to the API. Throws when the request fails OR the API says status:false
    async function api(method, url, body) {
        const response = await fetch(url, {
            method: method,
            headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json', 'Content-Type': 'application/json' },
            body: body ? JSON.stringify(body) : undefined
        });

        const data = await response.json().catch(function () { return {}; });

        if (!response.ok || data.status === false || data.success === false) {
            throw { status: response.status, data: data };
        }

        return data;
    }

    function errorText(error) {
        if (error.data && error.data.errors) return Object.values(error.data.errors).flat().join(' ');
        return (error.data && error.data.message) || 'Something went wrong. Please try again.';
    }

    function toast(text) {
        const box = byId('toast');
        box.textContent = text;
        box.hidden = false;
        clearTimeout(toast.timer);
        toast.timer = setTimeout(function () { box.hidden = true; }, 4000);
    }

    function setSaveState(kind, text) {
        const box = byId('saveState');
        box.textContent = text || '';
        box.className = 'save-state' + (kind ? ' ' + kind : '');
    }


    /* ---------------------------------------------------------------
       Listen: a recorded audio file, the browser's voice, or the server's Urdu voice
       - Urdu text uses the Urdu voice (the browser's if the device has one, otherwise the server's)
       - Everything else uses the English voice
       - It reads the question, then each answer
    --------------------------------------------------------------- */

    const Listen = (function () {
        const synth = window.speechSynthesis || null;
        let voices = [];
        let run = 0;            // changes whenever playback stops, so an old playback ends quietly
        let audio = null;
        let state = 'idle';     // 'idle' | 'loading' | 'playing'
        let mode = localStorage.getItem('listen_lang') === 'ur' ? 'ur' : 'en';   // the language the student wants to hear
        const URDU_LABELS = ['اے', 'بی', 'سی', 'ڈی', 'ای', 'ایف', 'جی', 'ایچ'];

        function loadVoices() { voices = synth ? synth.getVoices() : []; }
        if (synth) { loadVoices(); synth.onvoiceschanged = loadVoices; }

        function setState(next) {
            state = next;
            const button = byId('listenBtn');

            button.classList.toggle('playing', next !== 'idle');
            button.querySelector('i').className = next === 'idle' ? 'bi bi-volume-up-fill' : next === 'loading' ? 'bi bi-hourglass-split' : 'bi bi-stop-fill';
            button.querySelector('span').textContent = next === 'idle' ? 'Listen' : next === 'loading' ? 'Loading...' : 'Stop';
        }

        function isUrdu(text) { return /[\u0600-\u06FF]/.test(text); }

        function syncToggle() {
            document.querySelectorAll('#langToggle button').forEach(function (button) {
                button.classList.toggle('active', button.dataset.lang === mode);
            });
        }

        function setMode(next) {
            mode = next === 'ur' ? 'ur' : 'en';
            localStorage.setItem('listen_lang', mode);
            stop();
            syncToggle();
        }

        // Shows the Urdu version of the question on screen, so the student can read along
        function showUrdu(text) {
            const box = byId('qTextUrdu');
            box.textContent = text;
            box.hidden = false;
        }

        function voiceFor(lang) {
            if (!voices.length) loadVoices();

            const wanted = lang.toLowerCase();

            return voices.find(function (v) { return v.lang.toLowerCase().replace('_', '-') === wanted; })
                || voices.find(function (v) { return v.lang.toLowerCase().startsWith(wanted.split('-')[0]); });
        }

        // Chrome stops long speech, so it is read one sentence at a time
        function sentences(text) {
            return String(text).replace(/\s+/g, ' ').trim().split(/(?<=[۔.?؟!])\s+/).filter(Boolean);
        }

        function stop() {
            run++;

            if (synth) synth.cancel();

            if (audio) {
                const old = audio;
                audio = null;
                old.pause();
                if (old.onended) old.onended();   // lets any waiting playback finish
            }

            setState('idle');
        }

        function playUrl(url, myRun) {
            return new Promise(function (resolve, reject) {
                if (myRun !== run) return resolve();

                audio = new Audio(url);
                audio.onended = resolve;
                audio.onerror = function () { reject(new Error('The audio could not be played.')); };
                audio.play().catch(reject);
            });
        }

        // The server makes an Urdu MP3 (cached after the first time)
        // translate = true: the server first translates the English text into Urdu
        async function serverVoice(text, myRun, translate) {
            setState('loading');

            const response = await fetch('/api/student/speech', {
                method: 'POST',
                headers: { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                body: JSON.stringify({ text: text, translate: !!translate })
            });

            const data = await response.json().catch(function () { return {}; });

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'The Urdu voice is not available right now.');
            }

            if (myRun !== run) return data;

            setState('playing');
            await playUrl(data.url, myRun);

            return data;
        }

        function browserVoice(text, lang, voice, myRun) {
            return new Promise(function (resolve) {
                if (!synth || myRun !== run) return resolve();

                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = lang;
                if (voice) utterance.voice = voice;
                utterance.rate = (lang === 'ur-PK' || isJunior()) ? 0.85 : 1;   // slower is clearer
                utterance.onend = utterance.onerror = resolve;

                synth.speak(utterance);
            });
        }

        async function say(text, myRun) {
            const lang = isUrdu(text) ? 'ur-PK' : 'en-US';
            const voice = voiceFor(lang);

            // "Urdu" is chosen but this text is not Urdu: the server translates it, then speaks it
            if (mode === 'ur' && lang !== 'ur-PK' && /[\p{L}\p{N}]/u.test(text)) {
                return serverVoice(text, myRun, true);
            }

            // No Urdu voice on this device: use the server's
            if (lang === 'ur-PK' && !voice) return serverVoice(text, myRun);

            if (!synth) throw new Error('This browser cannot read aloud.');

            const parts = sentences(text);

            for (let i = 0; i < parts.length; i++) {
                if (myRun !== run) return;
                await browserVoice(parts[i], lang, voice, myRun);
            }
        }

        async function play(question) {
            stop();
            const myRun = run;

            setState('playing');
            await new Promise(function (resolve) { setTimeout(resolve, 60); });   // Chrome needs a moment after cancel()

            try {
                // 1. A recorded audio file for the question, if there is one
                const url = safeUrl(question.tts_audio_url);

                if (url) {
                    try {
                        await playUrl(url, myRun);
                        if (myRun === run) setState('idle');
                        return;
                    } catch (e) { /* the file failed, so read it aloud instead */ }
                }

                // 2. Read the question, then each answer
                const parts = [question.question_text];

                (question.options || []).forEach(function (option, i) {
                    const label = LETTERS[i] || (i + 1);

                    if (mode === 'ur') {
                        parts.push(URDU_LABELS[i] || String(label));   // "اے، بی، سی..." then the answer
                        parts.push(option.option_text);
                    } else {
                        parts.push(isUrdu(option.option_text) ? option.option_text : label + '. ' + option.option_text);
                    }
                });

                for (let i = 0; i < parts.length; i++) {
                    if (myRun !== run) return;

                    if (parts[i]) {
                        const result = await say(String(parts[i]), myRun);
                        if (i === 0 && result && result.text) showUrdu(result.text);
                    }

                    if (myRun === run && state === 'loading') setState('playing');
                }

                if (myRun === run) setState('idle');
            } catch (error) {
                if (myRun === run) {
                    setState('idle');
                    toast(error && error.message ? error.message : 'Could not read this aloud.');
                }
            }
        }

        syncToggle();

        return { play: play, stop: stop, setMode: setMode, active: function () { return state !== 'idle'; } };
    })();

    function stopListening() { Listen.stop(); }

    byId('langToggle').addEventListener('click', function (event) {
        const button = event.target.closest('button');
        if (button) Listen.setMode(button.dataset.lang);
    });

    byId('listenBtn').addEventListener('click', function () {
        if (Listen.active()) { Listen.stop(); return; }
        Listen.play(questions[index]);
    });


    /* ---------------------------------------------------------------
       Style: junior for primary and elementary, senior for the rest
    --------------------------------------------------------------- */

    function normalizeLevel(value) {
        const text = String(value || '').toLowerCase().replace(/[\s_-]/g, '');

        if (text.includes('highersecondary') || text === 'higher') return 'higher';
        if (text.includes('primary')) return 'primary';
        if (text.includes('elementary')) return 'elementary';
        if (text.includes('secondary')) return 'secondary';

        return null;
    }

    function levelOf(quizData) {
        const fromGroup = normalizeLevel(quizData.class_group);
        if (fromGroup) return fromGroup;

        const match = String(quizData.class_name || '').match(/\d+/);
        const number = match ? parseInt(match[0], 10) : null;

        if (number === null) return localStorage.getItem('student_level') || 'secondary';
        if (number <= 5) return 'primary';
        if (number <= 8) return 'elementary';
        if (number <= 10) return 'secondary';
        return 'higher';
    }

    function applyStyle(level) {
        const style = (level === 'primary' || level === 'elementary') ? 'junior' : 'senior';

        document.body.dataset.style = style;
        document.body.dataset.level = level;

        localStorage.setItem('student_level', level);
        localStorage.setItem('student_style', style);

        byId('navTitle').textContent = style === 'junior' ? 'My questions' : 'Question navigator';
    }


    /* ---------------------------------------------------------------
       Loading the attempt
    --------------------------------------------------------------- */

    async function loadQuiz() {
        byId('loadingState').hidden = false;
        byId('errorState').hidden = true;
        byId('quizContent').hidden = true;

        let payload;

        try {
            payload = (await api('GET', '/api/student/attempts/' + attemptId)) || {};
            console.log('Attempt response:', payload);   // check attempt.remaining_seconds here
        } catch (error) {
            showError(errorText(error));
            return;
        }

        const attempt = payload.attempt || {};
        quiz = payload.quiz || {};
        questions = quiz.questions || [];

        // A finished attempt goes straight to its result
        if (attempt.status === 'completed') {
            window.location.href = '/student/result-quiz/' + quiz.id;
            return;
        }

        if (!questions.length) {
            showError('This quiz has no questions yet. Please tell your teacher.');
            return;
        }

        answers = (payload.answers && !Array.isArray(payload.answers)) ? payload.answers : {};

        try {
            flags = new Set(JSON.parse(localStorage.getItem('flags_' + attemptId) || '[]'));
        } catch (e) {
            flags = new Set();
        }

        applyStyle(levelOf(quiz));

        byId('quizTitle').textContent = quiz.title || 'Quiz';
        byId('quizSubtitle').textContent = [quiz.subject_name, quiz.class_name].filter(Boolean).join(' · ') || 'Quiz in progress';
        byId('totalQuestions').textContent = questions.length;

        // First question that is not answered yet, so a student who comes back continues where they stopped
        const firstOpen = questions.findIndex(function (q) { return answers[q.id] === undefined; });
        index = firstOpen === -1 ? 0 : firstOpen;

        byId('loadingState').hidden = true;
        byId('quizContent').hidden = false;

        const secondsLeft = remainingSeconds(attempt);

        if (secondsLeft === null) {
            byId('timerBox').hidden = true;
            console.warn('No timer: the API sent neither attempt.remaining_seconds nor a usable started_at / time_limit_minutes.');
        } else {
            byId('timerBox').hidden = false;
            startTimer(secondsLeft);
        }

        render();
    }

    function showError(message) {
        byId('loadingState').hidden = true;
        byId('quizContent').hidden = true;
        byId('errorState').hidden = false;
        byId('errorMessage').textContent = message;
    }


    /* ---------------------------------------------------------------
       Drawing the page
    --------------------------------------------------------------- */

    function answeredCount() {
        return questions.filter(function (q) { return answers[q.id] !== undefined; }).length;
    }

    function render() {
        const question = questions[index];

        byId('counter').textContent = 'Question ' + (index + 1) + ' of ' + questions.length;
        byId('marks').textContent = question.marks_per_question + (Number(question.marks_per_question) === 1 ? ' mark' : ' marks');
        byId('qText').textContent = question.question_text || '';

        // Picture
        const image = safeUrl(question.image_url);
        byId('imageWrap').hidden = !image;
        if (image) byId('qImage').src = image;

        // Listen is always available (browser voice, or the server's Urdu voice)
        byId('listenBtn').hidden = false;
        byId('qTextUrdu').hidden = true;
        stopListening();

        renderOptions(question);
        renderGrid();
        renderProgress();
        renderFlag();

        byId('prevBtn').disabled = index === 0;
        byId('nextBtn').innerHTML = index === questions.length - 1
            ? 'Finish <i class="bi bi-flag"></i>'
            : 'Next <i class="bi bi-arrow-right"></i>';

        setSaveState('', '');
    }

    function renderOptions(question) {
        const options = question.options || [];
        const selected = answers[question.id];
        const hasPictures = options.some(function (o) { return safeUrl(o.image_url); });
        const box = byId('options');

        box.className = 'options' + (hasPictures ? ' picture' : '');

        box.innerHTML = options.map(function (option, i) {
            const chosen = String(selected) === String(option.id);
            const picture = safeUrl(option.image_url);

            return '<button type="button" class="opt' + (chosen ? ' selected' : '') + '" role="radio" aria-checked="' + chosen + '" data-option="' + option.id + '">' +
                '<span class="letter">' + (LETTERS[i] || (i + 1)) + '</span>' +
                (picture ? '<img class="opt-img" src="' + esc(picture) + '" alt="">' : '') +
                '<span class="opt-text">' + esc(option.option_text) + '</span>' +
                '<i class="bi bi-check-circle-fill check"></i>' +
                '</button>';
        }).join('');
    }

    function renderGrid() {
        byId('grid').innerHTML = questions.map(function (question, i) {
            let css = '';
            if (answers[question.id] !== undefined) css += ' answered';
            if (flags.has(question.id)) css += ' flagged';
            if (i === index) css += ' current';

            return '<button type="button" class="' + css.trim() + '" data-index="' + i + '" aria-label="Question ' + (i + 1) + '">' + (i + 1) + '</button>';
        }).join('');
    }

    function renderProgress() {
        const done = answeredCount();

        byId('answeredCount').textContent = done;
        byId('progressText').textContent = done + ' of ' + questions.length + ' answered';
        byId('progressBar').style.width = (done / questions.length * 100) + '%';
    }

    function renderFlag() {
        const on = flags.has(questions[index].id);
        const button = byId('flagBtn');

        button.className = 'flag-btn' + (on ? ' on' : '');
        button.innerHTML = '<i class="bi ' + (on ? 'bi-flag-fill' : 'bi-flag') + '"></i> <span>' + (on ? 'Marked for review' : 'Mark for review') + '</span>';
    }


    /* ---------------------------------------------------------------
       Choosing an answer (saved straight away, in order)
    --------------------------------------------------------------- */

    function chooseOption(questionId, optionId) {
        const previous = answers[questionId];

        if (String(previous) === String(optionId)) return;

        answers[questionId] = optionId;

        renderOptions(questions[index]);
        renderGrid();
        renderProgress();
        setSaveState('', 'Saving...');

        saveChain = saveChain.then(async function () {
            try {
                await api('POST', '/api/student/quizzesAttempt', {
                    attempt_id: attemptId,
                    question_id: questionId,
                    selected_option_id: optionId
                });

                setSaveState('ok', 'Answer saved');
            } catch (error) {
                // Put the old answer back so the screen never shows something that was not saved
                if (previous === undefined) delete answers[questionId]; else answers[questionId] = previous;

                if (questions[index] && questions[index].id === questionId) renderOptions(questions[index]);
                renderGrid();
                renderProgress();
                setSaveState('error', 'Not saved. Please tap your answer again.');
                toast(errorText(error));
            }
        });
    }

    byId('options').addEventListener('click', function (event) {
        const button = event.target.closest('.opt');
        if (button) chooseOption(questions[index].id, Number(button.dataset.option));
    });

    byId('grid').addEventListener('click', function (event) {
        const button = event.target.closest('button');
        if (button) goTo(Number(button.dataset.index));
    });

    function goTo(newIndex) {
        index = newIndex;
        render();   // render() also stops any voice that is playing
        byId('questionCard').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    byId('prevBtn').addEventListener('click', function () { if (index > 0) goTo(index - 1); });

    byId('nextBtn').addEventListener('click', function () {
        if (index < questions.length - 1) goTo(index + 1); else openSubmitModal();
    });

    byId('flagBtn').addEventListener('click', function () {
        const id = questions[index].id;

        if (flags.has(id)) flags.delete(id); else flags.add(id);

        localStorage.setItem('flags_' + attemptId, JSON.stringify([...flags]));
        renderFlag();
        renderGrid();
    });


    /* ---------------------------------------------------------------
       Timer
    --------------------------------------------------------------- */

    function formatTime(seconds) {
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = seconds % 60;
        const pad = function (n) { return String(n).padStart(2, '0'); };

        return h > 0 ? h + ':' + pad(m) + ':' + pad(s) : pad(m) + ':' + pad(s);
    }

    function tick() {
        const left = Math.max(0, Math.ceil((endAt - Date.now()) / 1000));

        byId('timer').textContent = formatTime(left);
        byId('timerBox').classList.toggle('warn', left <= (isJunior() ? 120 : 300));

        if (left <= 0) {
            clearInterval(timerHandle);
            submitQuiz(true);
        }
    }

    // Seconds left for this attempt. The API's remaining_seconds is best.
    // If it is missing, it is worked out from started_at, but only when that carries a timezone (like "...Z"),
    // because a plain "2026-10-15 07:22:38" would be read in the wrong timezone.
    function remainingSeconds(attempt) {
        if (attempt.remaining_seconds !== null && attempt.remaining_seconds !== undefined) {
            return Number(attempt.remaining_seconds);
        }

        const minutes = Number(quiz.time_limit_minutes);
        const started = String(attempt.started_at || '');

        if (minutes > 0 && /T.*(Z|[+-]\d\d:?\d\d)$/.test(started)) {
            return Math.max(0, Math.round((Date.parse(started) + minutes * 60000 - Date.now()) / 1000));
        }

        return null;
    }

    function startTimer(seconds) {
        endAt = Date.now() + seconds * 1000;
        clearInterval(timerHandle);
        tick();
        timerHandle = setInterval(tick, 500);
    }


    /* ---------------------------------------------------------------
       Finishing
    --------------------------------------------------------------- */

    function openSubmitModal() {
        const unanswered = questions.length - answeredCount();
        const flagged = flags.size;

        let text = unanswered > 0
            ? 'You have ' + unanswered + (unanswered === 1 ? ' question' : ' questions') + ' without an answer.'
            : 'You answered every question.';

        if (flagged > 0 && !isJunior()) text += ' ' + flagged + ' marked for review.';

        byId('submitMessage').textContent = text + ' You cannot change your answers after finishing.';
        bootstrap.Modal.getOrCreateInstance(byId('submitModal')).show();
    }

    async function submitQuiz(auto) {
        if (submitting) return;

        submitting = true;
        clearInterval(timerHandle);
        stopListening();

        byId('confirmSubmitBtn').disabled = true;
        byId('submitBtn').disabled = true;

        if (auto) {
            // Close any open dialog, so "Time's up" is the only thing on screen
            ['submitModal', 'leaveModal'].forEach(function (id) {
                const modal = bootstrap.Modal.getInstance(byId(id));
                if (modal) modal.hide();
            });

            byId('timeUp').hidden = false;
            byId('timeUpSpinner').hidden = false;
            byId('timeUpTitle').textContent = "Time's up!";
            byId('timeUpText').textContent = 'Sending your answers...';
            byId('timeUpRetry').hidden = true;
        }

        await saveChain;   // let any answer that is still being saved finish first

        try {
            await api('POST', '/api/student/submit-quiz', { attempt_id: attemptId });
            window.location.href = '/student/result-quiz/' + quiz.id;
        } catch (error) {
            // 405 means this attempt was already submitted, so just show the result
            if (error.status === 405) {
                window.location.href = '/student/result-quiz/' + quiz.id;
                return;
            }

            submitting = false;
            byId('confirmSubmitBtn').disabled = false;
            byId('submitBtn').disabled = false;

            const modal = bootstrap.Modal.getInstance(byId('submitModal'));
            if (modal) modal.hide();

            if (auto) {
                byId('timeUpSpinner').hidden = true;
                byId('timeUpTitle').textContent = "We couldn't send your answers";
                byId('timeUpText').textContent = errorText(error);
                byId('timeUpRetry').hidden = false;
            } else {
                toast(errorText(error));
            }
        }
    }

    byId('timeUpRetry').addEventListener('click', function () { submitQuiz(true); });
    byId('submitBtn').addEventListener('click', openSubmitModal);
    byId('confirmSubmitBtn').addEventListener('click', function () { submitQuiz(false); });
    byId('exitBtn').addEventListener('click', function () { bootstrap.Modal.getOrCreateInstance(byId('leaveModal')).show(); });
    byId('retryBtn').addEventListener('click', loadQuiz);

    window.addEventListener('pagehide', stopListening);

    loadQuiz();

})();
</script>
@endpush