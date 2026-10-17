@extends('layouts.student')

@section('title', 'My Quizzes')

@section('content')
<style>
    /* Colors come from the layout's theme variables. Only "style" (junior / senior) changes the look. */

    .quiz-home { max-width: 1100px; margin: auto; animation: appear .4s ease both; }

    @keyframes appear {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    button:focus-visible, .status-tab:focus-visible, .subject-chip:focus-visible {
        outline: 2px solid var(--secondary-color);
        outline-offset: 2px;
    }

    /* ---------- Page header: title, live summary, search ---------- */
    .qh { display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; margin-bottom: 26px; }
    .qh-main { flex: 1 1 280px; min-width: 0; }
    .qh-title { margin: 0 0 6px; font-size: clamp(28px, 3.2vw, 36px); font-weight: 800; line-height: 1.15; }
    .qh-sub { margin: 0; color: var(--muted-color); font-size: 14px; line-height: 1.6; }
    .qh-art { display: none; }

    .quiz-search { position: relative; width: 290px; flex: 0 0 auto; margin: 0; }
    .quiz-search i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--muted-color); }
    .quiz-search input {
        width: 100%; height: 46px; padding: 0 14px 0 40px;
        border: 1px solid var(--border-color); border-radius: 14px; outline: none;
        background: var(--surface-color); color: var(--text-color); font: inherit; font-size: 13px;
    }
    .quiz-search input:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary-color) 16%, transparent); }

    /* ---------- Continue strip ---------- */
    .qcont {
        display: flex; align-items: center; gap: 18px; flex-wrap: wrap;
        margin-bottom: 28px; padding: 20px 22px; border-radius: 20px;
        background: var(--primary-soft);
        border: 1px solid color-mix(in srgb, var(--primary-color) 38%, var(--border-color));
    }
    .qcont[hidden] { display: none; }
    .qcont-icon {
        width: 50px; height: 50px; flex: 0 0 auto; display: grid; place-items: center;
        border-radius: 16px; background: var(--surface-color); color: var(--secondary-color); font-size: 23px;
    }
    .qcont-text { flex: 1 1 240px; min-width: 0; }
    .qcont-label { color: var(--secondary-color); font-size: 12px; font-weight: 800; }
    .qcont-title { margin: 3px 0 2px; font-size: 19px; font-weight: 800; overflow-wrap: anywhere; }
    .qcont-meta { color: var(--muted-color); font-size: 12px; }
    .qcont .start-button { padding: 13px 22px; font-size: 13px; border-radius: 13px; }

    /* ---------- Tabs and chips ---------- */
    .status-tabs { display: flex; flex-wrap: wrap; gap: 26px; margin: 0 0 18px; border-bottom: 1px solid var(--border-color); }
    .status-tab {
        display: inline-flex; align-items: center; gap: 8px; margin-bottom: -1px; padding: 10px 2px 12px;
        border: 0; border-bottom: 3px solid transparent; background: transparent;
        color: var(--muted-color); font: inherit; font-size: 14px; font-weight: 700;
        transition: color .2s ease, border-color .2s ease;
    }
    .status-tab:hover { color: var(--text-color); }
    .status-tab b { padding: 1px 9px; border-radius: 999px; background: var(--background-color); border: 1px solid var(--border-color); color: var(--muted-color); font-size: 11px; }
    .status-tab.active { color: var(--text-color); border-bottom-color: var(--primary-color); }
    .status-tab.active b { background: var(--primary-soft); border-color: transparent; color: var(--secondary-color); }

    .subject-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; }
    .subject-chips:empty { display: none; }
    .subject-chip {
        display: inline-flex; align-items: center; gap: 7px; padding: 7px 14px;
        border: 1px solid var(--border-color); border-radius: 999px; background: var(--surface-color);
        color: var(--text-color); font: inherit; font-size: 12px; font-weight: 700;
        transition: border-color .2s ease, background .2s ease;
    }
    .subject-chip:hover { border-color: var(--primary-color); }
    .subject-chip.active { border-color: var(--primary-color); background: var(--primary-soft); }

    /* ---------- List and group headings ---------- */
    .quiz-grid { display: grid; grid-template-columns: 1fr; gap: 12px; }

    .qgroup { grid-column: 1 / -1; display: flex; align-items: center; gap: 10px; margin: 16px 0 2px; font-size: 14px; font-weight: 800; color: var(--muted-color); }
    .qgroup:first-child { margin-top: 0; }
    .qgroup span { padding: 1px 9px; border-radius: 999px; background: var(--surface-color); border: 1px solid var(--border-color); font-size: 11px; }

    /* ---------- Senior: one quiz per row ---------- */
    .quiz-card {
        display: grid; grid-template-columns: 48px minmax(0, 1fr) auto auto auto; align-items: center; gap: 18px;
        min-width: 0; padding: 16px 18px 16px 20px;
        border: 1px solid var(--border-color); border-left: 4px solid var(--primary-color);
        border-radius: 16px; background: var(--surface-color);
        transition: transform .2s ease, box-shadow .2s ease;
        animation: appear .3s ease both;
    }
    .quiz-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-hover); }
    .quiz-card.st-in_progress { border-left-color: var(--accent-color); }
    .quiz-card.st-completed { border-left-color: color-mix(in srgb, var(--secondary-color) 30%, var(--border-color)); }

    .subject-icon { width: 48px; height: 48px; display: grid; place-items: center; border-radius: 14px; background: var(--primary-soft); color: var(--secondary-color); font-size: 21px; }
    .qmain { min-width: 0; }
    .quiz-title { margin: 0 0 4px; font-size: 16px; font-weight: 800; overflow-wrap: anywhere; }
    .quiz-subject { color: var(--muted-color); font-size: 12px; }

    .qmeta { display: flex; flex-direction: column; gap: 5px; color: var(--muted-color); font-size: 12px; white-space: nowrap; }
    .qmeta span { display: inline-flex; align-items: center; gap: 6px; }

    .qpill { display: inline-flex; align-items: center; gap: 7px; padding: 6px 12px; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .qpill::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
    .qpill.todo { background: var(--primary-soft); color: var(--secondary-color); }
    .qpill.in_progress { background: color-mix(in srgb, var(--accent-color) 20%, var(--surface-color)); color: color-mix(in srgb, var(--accent-color) 70%, #000); }
    .qpill.completed { background: var(--background-color); color: var(--muted-color); }

    .start-button {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 16px;
        border: 0; border-radius: 11px; background: var(--primary-color); color: var(--on-primary, #fff);
        font: inherit; font-size: 12px; font-weight: 800; white-space: nowrap;
        transition: background .2s ease, transform .2s ease, color .2s ease;
    }
    .start-button:hover { background: var(--secondary-color); color: var(--on-secondary, #fff); transform: translateY(-1px); }
    .start-button:disabled { opacity: .6; cursor: wait; transform: none; }
    .start-button.done { background: var(--primary-soft); color: var(--secondary-color); }

    /* ---------- Empty and message ---------- */
    .empty-state { grid-column: 1 / -1; padding: 46px 20px; border: 1px dashed var(--border-color); border-radius: 18px; background: var(--surface-color); text-align: center; }
    .empty-state i { font-size: 34px; color: var(--muted-color); }
    .empty-state h3 { margin: 12px 0 6px; font-size: 17px; font-weight: 800; }
    .empty-state p { margin: 0; color: var(--muted-color); font-size: 13px; }

    .page-message { margin-bottom: 20px; padding: 15px 17px; border: 1px solid var(--border-color); border-radius: 13px; background: var(--surface-color); color: var(--muted-color); font-size: 13px; }
    .page-message.error { border-color: #fecaca; background: #fef2f2; color: #b91c1c; }


    /* ======================================================================
       JUNIOR STYLE (primary and elementary classes)
       Big, friendly, few words, large tap targets.
    ====================================================================== */

    .quiz-home[data-style="junior"] .qh { justify-content: flex-start; gap: 22px; }
    .quiz-home[data-style="junior"] .qh-art {
        display: grid; place-items: center; order: -1; flex: 0 0 auto; width: 92px; height: 92px;
        border-radius: 28px; background: var(--primary-soft); color: var(--secondary-color);
        font-size: 44px; transform: rotate(-5deg);
    }
    .quiz-home[data-style="junior"] .qh-title { font-size: clamp(32px, 4.5vw, 46px); }
    .quiz-home[data-style="junior"] .qh-sub { font-size: 17px; }
    .quiz-home[data-style="junior"] .quiz-search { display: none; }

    .quiz-home[data-style="junior"] .qcont { padding: 24px; border-radius: 26px; }
    .quiz-home[data-style="junior"] .qcont-title { font-size: 24px; }
    .quiz-home[data-style="junior"] .qcont-label, .quiz-home[data-style="junior"] .qcont-meta { font-size: 15px; }
    .quiz-home[data-style="junior"] .qcont .start-button { min-height: 56px; padding: 0 28px; border-radius: 18px; font-size: 16px; }

    .quiz-home[data-style="junior"] .status-tab { padding: 12px 4px 14px; font-size: 16px; }
    .quiz-home[data-style="junior"] .subject-chip { padding: 11px 18px; font-size: 15px; }
    .quiz-home[data-style="junior"] .qgroup { font-size: 20px; color: var(--text-color); }
    .quiz-home[data-style="junior"] .quiz-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; }

    .jr-card {
        display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 28px 22px 24px;
        border: 2px solid var(--border-color); border-radius: 28px; background: var(--surface-color); text-align: center;
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease; animation: appear .3s ease both;
    }
    .jr-card:hover { transform: translateY(-5px); border-color: var(--primary-color); box-shadow: var(--shadow-hover); }
    .jr-icon { width: 82px; height: 82px; display: grid; place-items: center; margin-bottom: 8px; border-radius: 26px; background: var(--primary-soft); color: var(--secondary-color); font-size: 40px; transform: rotate(-4deg); }
    .jr-card .quiz-title { margin: 6px 0 2px; font-size: 21px; }
    .jr-card .quiz-subject { font-size: 14px; font-weight: 700; }
    .jr-chips { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin: 12px 0 16px; }
    .jr-chip { display: inline-flex; align-items: center; gap: 6px; padding: 7px 13px; border-radius: 999px; background: var(--background-color); color: var(--text-color); font-size: 13px; font-weight: 700; }
    .jr-chip.todo { background: var(--primary-soft); }
    .jr-chip.in_progress { background: #fef3c7; color: #92400e; }
    .jr-chip.completed { background: #dcfce7; color: #166534; }
    .jr-card .start-button { width: 100%; min-height: 56px; border-radius: 18px; font-size: 16px; }

    .quiz-home[data-level="elementary"] .jr-icon { width: 68px; height: 68px; font-size: 32px; border-radius: 22px; }
    .quiz-home[data-level="elementary"] .jr-card .quiz-title { font-size: 19px; }
    .quiz-home[data-level="elementary"] .quiz-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }


    /* ---------- Responsive ---------- */
    @media (max-width: 1200px) {
        .quiz-home[data-level="elementary"] .quiz-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 760px) {
        .quiz-card { grid-template-columns: 48px minmax(0, 1fr); gap: 12px 14px; }
        .quiz-card .qmeta, .quiz-card .qpill { grid-column: 2; justify-self: start; }
        .quiz-card .qmeta { flex-direction: row; gap: 16px; }
        .quiz-card .start-button { grid-column: 1 / -1; width: 100%; padding: 12px; }
        .quiz-search { width: 100%; }
        .status-tabs { gap: 18px; overflow-x: auto; flex-wrap: nowrap; }
        .status-tab { flex: 0 0 auto; }
        .qcont .start-button { width: 100%; }
    }

    @media (max-width: 700px) {
        .quiz-home[data-style="junior"] .qh-art { width: 64px; height: 64px; font-size: 30px; border-radius: 20px; }
        .quiz-home[data-style="junior"] .quiz-grid,
        .quiz-home[data-level="elementary"] .quiz-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 400px) { .quiz-home[data-style="junior"] .qh-art { display: none; } }

    @media (prefers-reduced-motion: reduce) {
        .quiz-home, .quiz-card, .jr-card { animation: none; }
        .quiz-card, .start-button, .jr-card { transition: none; }
        .jr-icon, .qh-art { transform: none !important; }
    }
</style>

<div class="student-content">
    <div class="quiz-home" id="quizHome" data-style="senior" data-level="secondary">

        <header class="qh">
            <div class="qh-main">
                <h1 class="qh-title" id="pageTitle">My quizzes</h1>
                <p class="qh-sub" id="pageSub">Everything your teachers have assigned to you.</p>
            </div>

            <div class="qh-art"><i class="bi bi-journal-check"></i></div>

            <label class="quiz-search">
                <i class="bi bi-search"></i>
                <input type="search" id="quizSearch" placeholder="Search by quiz or subject..." aria-label="Search quizzes">
            </label>
        </header>

        <div id="quizPageMessage" class="page-message">Loading your quizzes...</div>

        {{-- Shows only when the student has an unfinished quiz --}}
        <section class="qcont" id="quizContinue" hidden>
            <div class="qcont-icon"><i class="bi bi-hourglass-split"></i></div>
            <div class="qcont-text">
                <div class="qcont-label" id="contLabel">Continue where you left off</div>
                <div class="qcont-title" id="contTitle"></div>
                <div class="qcont-meta" id="contMeta"></div>
            </div>
            <button type="button" class="start-button" id="contBtn" data-quiz-id="" data-attempt-status="in_progress"></button>
        </section>

        <section id="availableQuizzes">
            <div class="status-tabs" id="statusTabs" role="group" aria-label="Filter by progress">
                <button type="button" class="status-tab active" data-status="all">All <b id="tabAll">0</b></button>
                <button type="button" class="status-tab" data-status="todo">To do <b id="tabTodo">0</b></button>
                <button type="button" class="status-tab" data-status="in_progress">In progress <b id="tabProgress">0</b></button>
                <button type="button" class="status-tab" data-status="completed">Done <b id="tabDone">0</b></button>
            </div>

            <div class="subject-chips" id="subjectChips"></div>

            <div class="quiz-grid" id="quizGrid">
                <div class="empty-state">
                    <i class="bi bi-journal-bookmark"></i>
                    <h3>Loading quizzes</h3>
                    <p>Your available quizzes will appear here.</p>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    const token = window.token || localStorage.getItem('api_token');

    let quizzes = [];
    let style = 'senior';                       // 'junior' or 'senior'
    let filters = { status: 'all', subject: 'all' };


    /* ---------------------------------------------------------------
       Words that change with the style
    --------------------------------------------------------------- */

    const COPY = {
        junior: {
            title: 'Pick a quiz',
            sub: 'Tap a quiz to begin.',
            cont: 'Keep going!',
            start: 'Start', resume: 'Keep going', result: 'See my result',
            groups: { in_progress: 'Keep going', todo: 'New quizzes', completed: 'Finished' }
        },
        senior: {
            title: 'My quizzes',
            sub: '',
            cont: 'Continue where you left off',
            start: 'Start quiz', resume: 'Continue quiz', result: 'View result',
            groups: { in_progress: 'In progress', todo: 'Ready to start', completed: 'Completed' }
        }
    };


    /* ---------------------------------------------------------------
       Institute theme, institute logo and student (unchanged behaviour)
    --------------------------------------------------------------- */

    function applyConfiguration(config) {
        if (!config) return;

        const properties = {
            primary_color: '--primary-color',
            secondary_color: '--secondary-color',
            accent_color: '--accent-color',
            background_color: '--background-color',
            text_color: '--text-color'
        };

        Object.keys(properties).forEach(function (key) {
            const value = config[key];

            if (typeof value === 'string' && /^#[0-9a-f]{3,8}$/i.test(value)) {
                document.documentElement.style.setProperty(properties[key], value);
            }
        });

        localStorage.setItem('student_config', JSON.stringify(config));
    }

    function initialsOf(name, fallback) {
        const letters = String(name || '').split(/\s+/).filter(Boolean).slice(0, 2).map(w => w[0]).join('').toUpperCase();
        return letters || fallback;
    }

    function applyInstitute(institute) {
        if (!institute) return;

        $('#studentInstituteName').text(institute.name || 'Your Institute');
        $('#instituteLogoPlaceholder').text(initialsOf(institute.name, 'IN'));

        if (institute.logo) {
            $('#studentInstituteLogo').attr('src', institute.logo).removeClass('d-none');
            $('#instituteLogoPlaceholder').addClass('d-none');

            $('#studentInstituteLogo').off('error').on('error', function () {
                $(this).addClass('d-none');
                $('#instituteLogoPlaceholder').removeClass('d-none');
            });
        } else {
            $('#studentInstituteLogo').addClass('d-none');
            $('#instituteLogoPlaceholder').removeClass('d-none');
        }
    }

    function applyStudent(student) {
        if (!student) return;

        const name = student.name || 'Student';

        $('#studentDisplayName').text(name);
        $('#studentAvatarInitials').text(initialsOf(name, 'ST'));

        if (student.profile_image) {
            $('#studentAvatarImage').attr('src', student.profile_image).removeClass('d-none');
            $('#studentAvatarInitials').addClass('d-none');

            $('#studentAvatarImage').off('error').on('error', function () {
                $(this).addClass('d-none');
                $('#studentAvatarInitials').removeClass('d-none');
            });
        }
    }


    /* ---------------------------------------------------------------
       Working out the student's level (this decides the style)
    --------------------------------------------------------------- */

    // 'Higher Secondary', 'higher_secondary', 'higher' all become 'higher'
    function normalizeLevel(value) {
        const text = String(value || '').toLowerCase().replace(/[\s_-]/g, '');

        if (text.includes('highersecondary') || text === 'higher') return 'higher';
        if (text.includes('primary')) return 'primary';
        if (text.includes('elementary')) return 'elementary';
        if (text.includes('secondary')) return 'secondary';

        return null;
    }

    // From the class group, or from the class number when the group is missing
    function levelOfQuiz(quiz) {
        const fromGroup = normalizeLevel(quiz.class_group);
        if (fromGroup) return fromGroup;

        const match = String(quiz.class_name || '').match(/\d+/);
        const number = match ? parseInt(match[0], 10) : null;

        if (number === null) return null;
        if (number <= 5) return 'primary';
        if (number <= 8) return 'elementary';
        if (number <= 10) return 'secondary';
        return 'higher';
    }

    function decideLevel(data) {
        // 1. The API tells us (best)
        const student = data.student || {};
        const fromApi = normalizeLevel(student.level || student.class_group || student.group);
        if (fromApi) return fromApi;

        // 2. The most common level among the student's quizzes
        const counts = {};
        quizzes.forEach(function (quiz) {
            const level = levelOfQuiz(quiz);
            if (level) counts[level] = (counts[level] || 0) + 1;
        });

        const best = Object.keys(counts).sort((a, b) => counts[b] - counts[a])[0];
        if (best) return best;

        // 3. What we remembered last time, then a safe default
        return localStorage.getItem('student_level') || 'secondary';
    }

    function applyLevel(level) {
        style = (level === 'primary' || level === 'elementary') ? 'junior' : 'senior';

        const copy = COPY[style];

        $('#quizHome').attr({ 'data-style': style, 'data-level': level });
        document.body.setAttribute('data-level', level);   // other student pages can use it too

        $('#pageTitle').text(copy.title);
        $('#contLabel').text(copy.cont);

        // Remembered so the quiz page can match
        localStorage.setItem('student_level', level);
        localStorage.setItem('student_style', style);
    }


    /* ---------------------------------------------------------------
       Helpers
    --------------------------------------------------------------- */

    function escapeHtml(value) {
        return String(value ?? '').replace(/[&<>"']/g, function (character) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[character];
        });
    }

    function subjectIcon(subject) {
        const value = String(subject || '').toLowerCase();

        if (value.includes('math')) return 'bi-calculator';
        if (value.includes('science') || value.includes('biology')) return 'bi-activity';
        if (value.includes('computer') || /\bit\b/.test(value)) return 'bi-pc-display';
        if (value.includes('english') || value.includes('urdu')) return 'bi-book';
        if (value.includes('physics')) return 'bi-lightning-charge';
        if (value.includes('chemistry')) return 'bi-droplet-half';

        return 'bi-journal-text';
    }

    // 'todo', 'in_progress' or 'completed'
    function statusOf(quiz) {
        if (quiz.attempt_status === 'completed') return 'completed';
        if (quiz.attempt_status === 'in_progress') return 'in_progress';
        return 'todo';
    }

    function showMessage(text, isError) {
        $('#quizPageMessage').text(text).toggleClass('error', !!isError).removeClass('d-none');
    }


    /* ---------------------------------------------------------------
       Drawing the page
    --------------------------------------------------------------- */

    // "4 quizzes: 1 in progress, 3 done."
    function summaryText(total, todo, progress, done) {
        if (!total) return 'No quizzes have been assigned to you yet.';

        const parts = [];
        if (progress) parts.push(progress + ' in progress');
        if (todo) parts.push(todo + ' to do');
        if (done) parts.push(done + ' done');

        return total + ' ' + (total === 1 ? 'quiz' : 'quizzes') + ': ' + parts.join(', ') + '.';
    }

    function renderCounts() {
        const done = quizzes.filter(q => statusOf(q) === 'completed').length;
        const progress = quizzes.filter(q => statusOf(q) === 'in_progress').length;
        const todo = quizzes.length - done - progress;

        $('#tabAll').text(quizzes.length);
        $('#tabTodo').text(todo);
        $('#tabProgress').text(progress);
        $('#tabDone').text(done);

        $('#pageSub').text(style === 'junior' ? COPY.junior.sub : summaryText(quizzes.length, todo, progress, done));
    }

    function renderSubjects() {
        const names = [...new Set(quizzes.map(q => q.subject_name).filter(Boolean))];

        // One subject only: nothing to choose, so no chips
        if (names.length < 2) {
            $('#subjectChips').empty();
            return;
        }

        const chip = (value, label, icon) =>
            `<button type="button" class="subject-chip ${filters.subject === value ? 'active' : ''}" data-subject="${escapeHtml(value)}">
                <i class="bi ${icon}"></i>${escapeHtml(label)}
             </button>`;

        $('#subjectChips').html(
            chip('all', 'All subjects', 'bi-grid') +
            names.map(name => chip(name, name, subjectIcon(name))).join('')
        );
    }

    function buttonHtml(quiz) {
        const copy = COPY[style];
        const status = statusOf(quiz);

        if (status === 'completed') return '<i class="bi bi-bar-chart-line"></i> ' + copy.result;
        if (status === 'in_progress') return '<i class="bi bi-play-fill"></i> ' + copy.resume;
        return '<i class="bi bi-play-fill"></i> ' + copy.start;
    }

    // The "continue" strip: the first unfinished quiz
    function renderContinue() {
        const open = quizzes.filter(q => statusOf(q) === 'in_progress');
        const box = $('#quizContinue');

        if (!open.length) {
            box.prop('hidden', true);
            return;
        }

        const quiz = open[0];
        const minutes = (Number(quiz.time_limit_minutes) || 0) + ' min';
        const more = open.length > 1 ? ', plus ' + (open.length - 1) + ' more in progress' : '';

        $('#contTitle').text(quiz.title);
        $('#contMeta').text([quiz.subject_name, minutes].filter(Boolean).join(', ') + more);
        $('#contBtn').attr('data-quiz-id', quiz.id).html(buttonHtml(quiz));

        box.prop('hidden', false);
    }

    // Junior: big and friendly
    function juniorCard(quiz) {
        const status = statusOf(quiz);
        const chipText = status === 'completed' ? 'Finished' : status === 'in_progress' ? 'Not finished yet' : 'New';
        const chipIcon = status === 'completed' ? 'bi-check-circle-fill' : status === 'in_progress' ? 'bi-hourglass-split' : 'bi-stars';

        return `
            <article class="jr-card">
                <div class="jr-icon"><i class="bi ${subjectIcon(quiz.subject_name)}"></i></div>
                <h3 class="quiz-title">${escapeHtml(quiz.title)}</h3>
                <div class="quiz-subject">${escapeHtml(quiz.subject_name || 'Fun quiz')}</div>

                <div class="jr-chips">
                    <span class="jr-chip"><i class="bi bi-clock"></i> ${Number(quiz.time_limit_minutes) || 0} min</span>
                    <span class="jr-chip ${status}"><i class="bi ${chipIcon}"></i> ${chipText}</span>
                </div>

                <button type="button" class="start-button ${status === 'completed' ? 'done' : ''}"
                        data-quiz-id="${Number(quiz.id)}" data-attempt-status="${status}">
                    ${buttonHtml(quiz)}
                </button>
            </article>`;
    }

    // Senior: one clear row per quiz
    function seniorCard(quiz) {
        const status = statusOf(quiz);
        const statusText = status === 'completed' ? 'Completed' : status === 'in_progress' ? 'In progress' : 'Ready to begin';
        const where = [quiz.subject_name || 'General quiz', quiz.class_name].filter(Boolean).join(', ');

        return `
            <article class="quiz-card st-${status}">
                <div class="subject-icon"><i class="bi ${subjectIcon(quiz.subject_name)}"></i></div>

                <div class="qmain">
                    <h3 class="quiz-title">${escapeHtml(quiz.title)}</h3>
                    <div class="quiz-subject">${escapeHtml(where)}</div>
                </div>

                <div class="qmeta">
                    <span><i class="bi bi-clock"></i> ${Number(quiz.time_limit_minutes) || 0} minutes</span>
                    <span><i class="bi bi-award"></i> ${Number(quiz.total_marks) || 0} marks</span>
                </div>

                <span class="qpill ${status}">${statusText}</span>

                <button type="button" class="start-button ${status === 'completed' ? 'done' : ''}"
                        data-quiz-id="${Number(quiz.id)}" data-attempt-status="${status}">
                    ${buttonHtml(quiz)}
                </button>
            </article>`;
    }

    function renderQuizzes() {
        const search = $('#quizSearch').val().trim().toLowerCase();
        const order = { in_progress: 0, todo: 1, completed: 2 };   // unfinished first, finished last
        const card = style === 'junior' ? juniorCard : seniorCard;

        const shown = quizzes.filter(function (quiz) {
            const matchesStatus = filters.status === 'all' || statusOf(quiz) === filters.status;
            const matchesSubject = filters.subject === 'all' || quiz.subject_name === filters.subject;
            const matchesText = [quiz.title, quiz.subject_name, quiz.class_name].join(' ').toLowerCase().includes(search);

            return matchesStatus && matchesSubject && matchesText;
        }).sort((a, b) => order[statusOf(a)] - order[statusOf(b)]);

        if (!shown.length) {
            const none = !quizzes.length;

            $('#quizGrid').html(`
                <div class="empty-state">
                    <i class="bi ${none ? 'bi-journal-bookmark' : 'bi-search'}"></i>
                    <h3>${none ? 'No quizzes yet' : 'No quizzes found'}</h3>
                    <p>${none ? 'When your teacher publishes a quiz for your class, it will show up here.' : 'Try a different filter or search.'}</p>
                </div>`);
            return;
        }

        // On the "All" tab, group by progress (only when there is more than one group)
        const groups = ['in_progress', 'todo', 'completed']
            .map(s => ({ s: s, items: shown.filter(q => statusOf(q) === s) }))
            .filter(g => g.items.length);

        if (filters.status === 'all' && groups.length > 1) {
            $('#quizGrid').html(groups.map(g =>
                `<h3 class="qgroup">${COPY[style].groups[g.s]}<span>${g.items.length}</span></h3>` +
                g.items.map(card).join('')
            ).join(''));
            return;
        }

        $('#quizGrid').html(shown.map(card).join(''));
    }


    /* ---------------------------------------------------------------
       Loading
    --------------------------------------------------------------- */

    function loadQuizzes() {
        if (!token) {
            showMessage('Your session has expired. Please log in again.', true);
            return;
        }

        $.ajax({
            url: '/api/student/quizzes',
            method: 'GET',
            headers: { Authorization: 'Bearer ' + token, Accept: 'application/json' }
        }).done(function (response) {
            if (!response || response.success === false) {
                showMessage((response && response.message) || 'Unable to load quizzes.', true);
                return;
            }

            const data = response.data || {};

            quizzes = Array.isArray(data.quizzes) ? data.quizzes : [];

            applyConfiguration(data.configuration);
            applyInstitute(data.institute);
            applyStudent(data.student);
            applyLevel(decideLevel(data));

            renderCounts();
            renderSubjects();
            renderContinue();
            renderQuizzes();

            $('#quizPageMessage').addClass('d-none');
        }).fail(function (xhr) {
            if (xhr.status === 401 || xhr.status === 403) {
                showMessage('You are not authorized to view these quizzes. Please log in with your student account.', true);
            } else {
                showMessage('Could not load quizzes. Please refresh the page and try again.', true);
            }
        });
    }


    /* ---------------------------------------------------------------
       Clicks
    --------------------------------------------------------------- */

    $('#statusTabs').on('click', '.status-tab', function () {
        filters.status = $(this).data('status');
        $('.status-tab').removeClass('active');
        $(this).addClass('active');
        renderQuizzes();
    });

    $('#subjectChips').on('click', '.subject-chip', function () {
        filters.subject = String($(this).data('subject'));
        renderSubjects();
        renderQuizzes();
    });

    $('#quizSearch').on('input', renderQuizzes);

    // Works for the list buttons and the "continue" strip button
    $('#quizHome').on('click', '.start-button', function () {
        const button = $(this);
        const quizId = button.attr('data-quiz-id');
        const label = button.html();

        // A finished quiz opens its result instead of starting again
        if (button.attr('data-attempt-status') === 'completed') {
            window.location.href = '/student/result-quiz/' + quizId;
            return;
        }

        button.prop('disabled', true).text('Opening...');

        $.ajax({
            url: '/api/student/quizzes/' + quizId + '/start',
            method: 'POST',
            headers: {
                Authorization: 'Bearer ' + token,
                Accept: 'application/json',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }).done(function (response) {
            if (response && response.success === false) {
                showMessage(response.message || 'Unable to start this quiz.', true);
                button.prop('disabled', false).html(label);
                return;
            }

            const attemptId = response?.data?.attempt?.id
                || response?.attempt?.id
                || response?.data?.attempt_id
                || response?.attempt_id;

            if (attemptId) {
                window.location.href = '/student/takeQuiz/' + attemptId;
                return;
            }

            showMessage('The quiz was opened, but the attempt ID was not returned by the API. Check the start() response.', true);
            button.prop('disabled', false).html(label);
        }).fail(function (xhr) {
            showMessage((xhr.responseJSON && xhr.responseJSON.message) || 'Unable to start this quiz.', true);
            button.prop('disabled', false).html(label);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    loadQuizzes();
});
</script>
@endpush