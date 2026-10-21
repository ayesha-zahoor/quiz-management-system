@extends('layouts.institute')

@section('title', 'Dashboard')
@section('user-role', 'Institute Admin')
@section('page-title', 'Dashboard')
@section('page-description', 'Manage your institute, classes, teachers, and subjects')



@section('content')

    {{-- Greeting --}}
    <div class="dash-head">
        <div>
            <h2 class="dash-welcome"><span id="greeting">Welcome back</span><span id="welcomeName"></span></h2>
            <p class="dash-sub">Here's what is happening in your institute today.</p>
        </div>

        <div class="dash-date">
            <i class="bi bi-calendar3"></i>
            <span id="currentDate"></span>
        </div>
    </div>

    {{-- Institute banner --}}
    <section class="hero" id="hero">
        <div class="hero-logo" id="instituteLogo"><i class="bi bi-building"></i></div>

        <div class="hero-main">
            <div class="hero-title">
                <h3 id="instituteName">Loading institute...</h3>
                <span class="hero-status" id="instituteStatus"><i></i><b>Active</b></span>
            </div>

            <div class="hero-chips">
                <span class="hero-chip"><i class="bi bi-envelope"></i><span id="instituteEmail">—</span></span>
                <span class="hero-chip"><i class="bi bi-telephone"></i><span id="instituteContact">—</span></span>
                <span class="hero-chip"><i class="bi bi-geo-alt"></i><span id="instituteAddress">—</span></span>
            </div>
        </div>
    </section>

    {{-- Key numbers --}}
    <div class="stat-grid" id="statGrid">

        <a href="/instituteAdmin/classes" class="stat-card">
            <div class="stat-icon"><i class="bi bi-building"></i></div>
            <div class="stat-body">
                <span class="stat-label">Classes</span>
                <div class="stat-value" id="totalClasses">0</div>
                <span class="stat-link">Manage classes <i class="bi bi-arrow-right"></i></span>
            </div>
        </a>

        <a href="/instituteAdmin/students" class="stat-card">
            <div class="stat-icon"><i class="bi bi-people-fill"></i></div>
            <div class="stat-body">
                <span class="stat-label">Students</span>
                <div class="stat-value" id="totalStudents">0</div>
                <span class="stat-link">Manage students <i class="bi bi-arrow-right"></i></span>
            </div>
        </a>

        <a href="/instituteAdmin/teachers" class="stat-card">
            <div class="stat-icon"><i class="bi bi-person-workspace"></i></div>
            <div class="stat-body">
                <span class="stat-label">Teachers</span>
                <div class="stat-value" id="totalTeachers">0</div>
                <span class="stat-link">Manage teachers <i class="bi bi-arrow-right"></i></span>
            </div>
        </a>

        <a href="/instituteAdmin/subjects" class="stat-card">
            <div class="stat-icon"><i class="bi bi-book"></i></div>
            <div class="stat-body">
                <span class="stat-label">Subjects</span>
                <div class="stat-value" id="totalSubjects">0</div>
                <span class="stat-link">Manage subjects <i class="bi bi-arrow-right"></i></span>
            </div>
        </a>

        {{-- Shown only when the API sends quizzes_count / quiz_attempts_count --}}
        <div class="stat-card" id="quizCard" hidden>
            <div class="stat-icon accent"><i class="bi bi-patch-question-fill"></i></div>
            <div class="stat-body">
                <span class="stat-label">Quizzes</span>
                <div class="stat-value" id="totalQuizzes">0</div>
                <span class="stat-link plain">Created in your institute</span>
            </div>
        </div>

        <div class="stat-card" id="attemptCard" hidden>
            <div class="stat-icon accent"><i class="bi bi-journal-check"></i></div>
            <div class="stat-body">
                <span class="stat-label">Quiz attempts</span>
                <div class="stat-value" id="totalAttempts">0</div>
                <span class="stat-link plain">By your students</span>
            </div>
        </div>

    </div>

    <div class="row g-4 mb-4">

        {{-- Classes overview --}}
        <div class="col-xl-7">
            <section class="panel h-100">
                <header class="panel-head">
                    <div>
                        <h5>Classes overview</h5>
                        <p>Students enrolled in each class</p>
                    </div>
                    <a href="/instituteAdmin/classes" class="panel-link">Manage <i class="bi bi-arrow-right"></i></a>
                </header>

                <div class="panel-body" id="classesList">
                    <div class="skeleton" style="height:54px"></div>
                    <div class="skeleton" style="height:54px"></div>
                    <div class="skeleton" style="height:54px"></div>
                </div>
            </section>
        </div>

        {{-- Subjects --}}
        <div class="col-xl-5">
            <section class="panel h-100">
                <header class="panel-head">
                    <div>
                        <h5>Subjects</h5>
                        <p>Available in your institute</p>
                    </div>
                    <span class="count-pill" id="subjectCount">0</span>
                </header>

                <div class="panel-body" id="subjectsList">
                    <div class="skeleton" style="height:34px"></div>
                    <div class="skeleton" style="height:34px;width:70%"></div>
                </div>
            </section>
        </div>

    </div>

    {{-- Teaching staff --}}
    <section class="panel mb-4">
        <header class="panel-head">
            <div>
                <h5>Teaching staff</h5>
                <p>Teachers and the classes and subjects they teach</p>
            </div>
            <a href="/instituteAdmin/teachers" class="panel-link">Manage <i class="bi bi-arrow-right"></i></a>
        </header>

        <div class="panel-body">
            <div class="staff-grid" id="teacherGrid">
                <div class="skeleton" style="height:130px"></div>
                <div class="skeleton" style="height:130px"></div>
                <div class="skeleton" style="height:130px"></div>
            </div>
        </div>
    </section>

    {{-- Students by class --}}
    <section class="panel">
        <header class="panel-head">
            <div>
                <h5>Students by class</h5>
                <p>Open a class to see who is enrolled</p>
            </div>
            <a href="/instituteAdmin/students" class="panel-link">All students <i class="bi bi-arrow-right"></i></a>
        </header>

        <div class="accordion accordion-flush" id="studentsByClass">
            <div class="panel-body">
                <div class="skeleton" style="height:48px"></div>
                <div class="skeleton" style="height:48px"></div>
            </div>
        </div>
    </section>

    <iframe src="https://www.slideshare.net/slideshow/embed_code/key/D1UYUNwImbveXh" width="510" height="420"frameborder="0" marginwidth="0" marginheight="0" scrolling="no"style="border: var(--border-1) solid #CCC; border-width:1px; margin-bottom:5px; max-width:100%;"allowfullscreen></iframe><div style="margin-bottom:5px"><strong><a href="https://www.slideshare.net/slideshow/digital-forensic-73189319/73189319" title="digital-forensic-73189319" target="_blank">digital-forensic-73189319</a></strong>from <strong><a href="https://www.slideshare.net/cleverence1" target="_blank">Cleverence Kombe</a></strong></div>


        

@endsection


@push('styles')
<style>
    /* ---------- Greeting ---------- */
    .dash-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 22px;
    }

    .dash-welcome { margin: 0 0 5px; font-size: 26px; font-weight: 700; letter-spacing: -0.5px; color: var(--text-color); }
    .dash-sub { margin: 0; color: var(--slate); font-size: 14px; }

    .dash-date {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border: 1px solid var(--slate-light);
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.85);
        color: var(--slate);
        font-size: 13px;
        white-space: nowrap;
    }

    /* ---------- Institute banner (uses the institute's own colors) ---------- */
    .hero {
        position: relative;
        display: flex;
        align-items: center;
        gap: 22px;
        padding: 24px 26px;
        margin-bottom: 22px;
        border-radius: 16px;
        overflow: hidden;
        color: var(--on-primary);
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        box-shadow: var(--shadow-md);
    }

    .hero::before,
    .hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.14);
        pointer-events: none;
    }
    .hero::before { width: 260px; height: 260px; right: -70px; top: -120px; }
    .hero::after  { width: 170px; height: 170px; right: 150px; bottom: -110px; }

    .hero-logo {
        position: relative;
        z-index: 1;
        width: 84px;
        height: 84px;
        flex: 0 0 84px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.95);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        overflow: hidden;
        box-shadow: 0 8px 20px -8px rgba(0, 0, 0, 0.35);
    }
    .hero-logo img { width: 100%; height: 100%; object-fit: cover; }

    .hero-main { position: relative; z-index: 1; min-width: 0; }

    .hero-title { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 12px; }
    .hero-title h3 { margin: 0; font-size: 22px; font-weight: 700; letter-spacing: -0.3px; overflow-wrap: anywhere; }

    .hero-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 11px;
        border-radius: 999px;
        background: var(--white);
        color: var(--navy);
        font-size: 12px;
        text-transform: capitalize;
    }
    .hero-status b { font-weight: 700; }
    .hero-status i { width: 7px; height: 7px; border-radius: 50%; background: var(--success); }
    .hero-status.warning i { background: var(--warning); }
    .hero-status.danger i { background: var(--danger); }

    .hero-chips { display: flex; flex-wrap: wrap; gap: 8px; }

    .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.22);
        font-size: 13px;
        font-weight: 500;
        max-width: 100%;
    }
    .hero-chip > span { overflow-wrap: anywhere; }

    /* ---------- Stat cards ---------- */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 20px;
        background: var(--white);
        border: 1px solid var(--slate-light);
        border-radius: 14px;
        box-shadow: var(--shadow-sm);
        color: inherit;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }
    .stat-card[hidden] { display: none; }
    a.stat-card:hover { border-color: var(--primary-color); box-shadow: var(--shadow-md); transform: translateY(-2px); color: inherit; }

    .stat-icon {
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }
    .stat-icon.accent {
        background: color-mix(in srgb, var(--accent-color) 16%, white);
        color: var(--accent-color);
    }

    .stat-label { display: block; color: var(--slate); font-size: 13px; font-weight: 600; }
    .stat-value { margin-top: 6px; font-size: 32px; line-height: 1; font-weight: 700; color: var(--text-color); font-variant-numeric: tabular-nums; }
    .stat-link { display: inline-block; margin-top: 10px; color: var(--primary-dark); font-size: 12px; font-weight: 700; }
    .stat-link.plain { color: var(--slate); font-weight: 500; }

    /* ---------- Panels ---------- */
    .panel {
        background: var(--white);
        border: 1px solid var(--slate-light);
        border-radius: 14px;
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 18px 22px;
        border-bottom: 1px solid var(--slate-light);
    }
    .panel-head h5 { margin: 0 0 3px; font-size: 16px; font-weight: 700; color: var(--text-color); }
    .panel-head p { margin: 0; color: var(--slate); font-size: 12px; }

    .panel-link { display: inline-flex; align-items: center; gap: 6px; color: var(--primary-dark); font-size: 13px; font-weight: 700; white-space: nowrap; }
    .panel-link:hover { color: var(--secondary-color); }

    .panel-body { padding: 18px 22px; }

    .count-pill {
        min-width: 30px;
        padding: 4px 10px;
        border-radius: 999px;
        background: var(--primary-light);
        color: var(--primary-dark);
        font-size: 12px;
        font-weight: 700;
        text-align: center;
    }

    /* ---------- Classes overview ---------- */
    .class-row { display: flex; align-items: center; gap: 14px; padding: 12px 0; border-bottom: 1px solid #f1f5f9; }
    .class-row:first-child { padding-top: 0; }
    .class-row:last-child { border-bottom: 0; padding-bottom: 0; }

    .class-ico {
        width: 40px;
        height: 40px;
        flex: 0 0 40px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .class-info { flex: 0 0 150px; min-width: 0; }
    .class-info strong { display: block; font-size: 14px; font-weight: 600; color: var(--text-color); overflow-wrap: anywhere; }
    .class-info small { color: var(--slate); font-size: 12px; text-transform: capitalize; }

    .bar { flex: 1; height: 8px; border-radius: 999px; background: #eef2f7; overflow: hidden; min-width: 60px; }
    .bar span { display: block; height: 100%; border-radius: 999px; background: var(--primary-color); transition: width 0.6s ease; }

    .class-count { flex: 0 0 auto; min-width: 84px; text-align: right; color: var(--slate); font-size: 12px; font-weight: 600; }
    .class-count b { color: var(--text-color); font-size: 15px; }

    /* ---------- Subjects ---------- */
    .chips { display: flex; flex-wrap: wrap; gap: 8px; max-height: 280px; overflow-y: auto; }

    .chip {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border-radius: 10px;
        background: var(--primary-light);
        color: var(--primary-dark);
        font-size: 13px;
        font-weight: 600;
    }

    .chip.small { padding: 4px 10px; font-size: 12px; border-radius: 999px; }
    .chip.alt { background: color-mix(in srgb, var(--secondary-color) 12%, white); color: var(--secondary-color); }

    /* ---------- Teaching staff ---------- */
    .staff-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 16px; }

    .staff-card {
        padding: 16px;
        border: 1px solid var(--slate-light);
        border-radius: 12px;
        background: #fcfdfb;
        transition: border-color 0.2s ease;
    }
    .staff-card:hover { border-color: var(--primary-color); }

    .person { display: flex; align-items: center; gap: 12px; min-width: 0; }
    .person > div { min-width: 0; }
    .person strong { display: block; font-size: 14px; font-weight: 600; color: var(--text-color); overflow-wrap: anywhere; }
    .person small { display: block; color: var(--slate); font-size: 12px; overflow-wrap: anywhere; }

    .avatar {
        width: 42px;
        height: 42px;
        flex: 0 0 42px;
        border-radius: 50%;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        overflow: hidden;
    }
    .avatar img { width: 100%; height: 100%; object-fit: cover; }

    .staff-block { margin-top: 12px; }
    .staff-block > span { display: block; margin-bottom: 6px; color: var(--slate); font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; }
    .staff-block .chips { max-height: none; gap: 6px; }
    .muted { color: var(--slate); font-size: 12px; }

    /* ---------- Students by class ---------- */
    .accordion { --bs-accordion-bg: transparent; --bs-accordion-border-color: var(--slate-light); }

    .accordion-button {
        gap: 12px;
        padding: 14px 22px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-color);
        background: transparent;
        box-shadow: none;
    }
    .accordion-button:not(.collapsed) { background: var(--primary-light); color: var(--text-color); box-shadow: none; }
    .accordion-button:focus { box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary-color) 22%, transparent); }

    .acc-meta { margin-left: auto; margin-right: 10px; display: flex; align-items: center; gap: 10px; }
    .acc-meta small { color: var(--slate); text-transform: capitalize; font-weight: 500; }

    .student-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 12px; padding: 16px 22px 20px; }
    .student-tile { display: flex; align-items: center; gap: 12px; padding: 10px 12px; border: 1px solid #eef2f7; border-radius: 10px; }
    .student-more { padding: 0 22px 18px; font-size: 13px; }

    /* ---------- Empty / error / loading ---------- */
    .empty { padding: 26px 10px; text-align: center; color: var(--slate); font-size: 13px; }
    .empty i { display: block; margin-bottom: 8px; font-size: 28px; color: var(--primary-dark); }
    .empty a { font-weight: 700; }
    .empty.error i { color: var(--danger); }

    .skeleton {
        height: 14px;
        margin-bottom: 12px;
        border-radius: 8px;
        background: linear-gradient(90deg, #eef2f7 25%, #f8fafc 50%, #eef2f7 75%);
        background-size: 200% 100%;
        animation: shimmer 1.2s infinite linear;
    }
    @keyframes shimmer { to { background-position: -200% 0; } }

    /* ---------- Responsive ---------- */
    @media (max-width: 767.98px) {
        .dash-head { flex-direction: column; }
        .dash-date { width: 100%; justify-content: center; }
        .dash-welcome { font-size: 22px; }
        .hero { flex-direction: column; align-items: flex-start; padding: 20px; }
        .class-row { flex-wrap: wrap; }
        .class-info { flex: 1; }
        .bar { order: 3; flex-basis: 100%; }
    }
</style>
@endpush


@push('scripts')
<script>
    // ---------- Header ----------
    document.getElementById('currentDate').textContent =
        new Date().toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });

    (function () {
        const hour = new Date().getHours();
        document.getElementById('greeting').textContent =
            hour < 12 ? 'Good morning' : hour < 18 ? 'Good afternoon' : 'Good evening';
    })();

    // Add the admin's first name once the layout has loaded the profile
    function showWelcomeName(user) {
        if (user && user.name) {
            $('#welcomeName').text(', ' + user.name.split(' ')[0]);
        }
    }

    if (window.currentUser) showWelcomeName(window.currentUser);
    $(document).on('user:loaded', (event, user) => showWelcomeName(user));

    // ---------- Helpers ----------
    function esc(text) {
        return $('<div>').text(text ?? '').html();
    }

    function initials(name) {
        return (name || '?').trim().split(/\s+/).map(w => w[0]).slice(0, 2).join('').toUpperCase();
    }

    function avatar(person) {
        const inner = person.profile_image
            ? `<img src="/storage/${esc(person.profile_image)}" alt="">`
            : esc(initials(person.name));

        return `<div class="avatar">${inner}</div>`;
    }

    function emptyBox(icon, message, link) {
        return `<div class="empty"><i class="bi ${icon}"></i>${message}${link ? ' ' + link : ''}</div>`;
    }

    function countUp(selector, target) {
        const el = document.querySelector(selector);
        if (!el) return;

        target = Number(target) || 0;

        if (!target || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            el.textContent = target;
            return;
        }

        const start = performance.now(), duration = 600;

        (function tick(now) {
            const p = Math.min((now - start) / duration, 1);
            el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
            if (p < 1) requestAnimationFrame(tick);
        })(start);
    }

    function uniqueBy(list, key) {
        const seen = new Map();
        (list || []).forEach(item => { if (item && !seen.has(item[key])) seen.set(item[key], item); });
        return [...seen.values()];
    }

    // ---------- Renderers ----------
    function renderInstitute(institute) {
        $('#instituteName').text(institute.name || 'Your institute');
        $('#instituteEmail').text(institute.email || '—');
        $('#instituteContact').text(institute.Contact || '—');
        $('#instituteAddress').text(institute.address || '—');

        if (institute.logo) {
            $('#instituteLogo').html(`<img src="/storage/${esc(institute.logo)}" alt="Institute logo">`);
        }

        if (institute.status) {
            const kind = institute.status === 'active' ? '' : institute.status === 'suspended' ? 'warning' : 'danger';

            $('#instituteStatus')
                .attr('class', 'hero-status ' + kind)
                .find('b').text(institute.status);
        }
    }

    function renderClasses(classes, totalStudents) {
        if (!classes.length) {
            $('#classesList').html(emptyBox('bi-building-add', 'No classes yet.', '<a href="/instituteAdmin/classes">Add your first class</a>'));
            return;
        }

        const max = Math.max(...classes.map(c => (c.students || []).length), 1);

        $('#classesList').html(classes.map(function (item) {
            const count = (item.students || []).length;
            const width = Math.round((count / max) * 100);

            return `
                <div class="class-row">
                    <div class="class-ico"><i class="bi bi-building"></i></div>
                    <div class="class-info">
                        <strong>${esc(item.class_name)}</strong>
                        <small>${esc(item.group || 'No group')}</small>
                    </div>
                    <div class="bar" title="${count} of ${totalStudents} students"><span style="width:${width}%"></span></div>
                    <div class="class-count"><b>${count}</b> ${count === 1 ? 'student' : 'students'}</div>
                </div>`;
        }).join(''));
    }

    function renderSubjects(subjects) {
        $('#subjectCount').text(subjects.length);

        if (!subjects.length) {
            $('#subjectsList').html(emptyBox('bi-book', 'No subjects yet.', '<a href="/instituteAdmin/subjects">Add a subject</a>'));
            return;
        }

        $('#subjectsList').html(
            '<div class="chips">' +
            subjects.map(s => `<span class="chip"><i class="bi bi-journal-text"></i>${esc(s.name)}</span>`).join('') +
            '</div>'
        );
    }

    function renderTeachers(teachers) {
        if (!teachers.length) {
            $('#teacherGrid').html(emptyBox('bi-person-workspace', 'No teachers yet.', '<a href="/instituteAdmin/teachers">Add a teacher</a>'));
            return;
        }

        $('#teacherGrid').html(teachers.map(function (teacher) {
            const classes  = uniqueBy(teacher.teaching_classes, 'id');
            const subjects = uniqueBy(teacher.teaching_subjects, 'id');

            const classChips = classes.length
                ? classes.map(c => `<span class="chip small">${esc(c.class_name)}</span>`).join('')
                : '<span class="muted">Not assigned yet</span>';

            const subjectChips = subjects.length
                ? subjects.map(s => `<span class="chip small alt">${esc(s.name)}</span>`).join('')
                : '<span class="muted">Not assigned yet</span>';

            return `
                <div class="staff-card">
                    <div class="person">
                        ${avatar(teacher)}
                        <div>
                            <strong>${esc(teacher.name)}</strong>
                            <small>${esc(teacher.email)}</small>
                        </div>
                    </div>

                    <div class="staff-block">
                        <span>Classes</span>
                        <div class="chips">${classChips}</div>
                    </div>

                    <div class="staff-block">
                        <span>Subjects</span>
                        <div class="chips">${subjectChips}</div>
                    </div>
                </div>`;
        }).join(''));
    }

    function renderStudentsByClass(classes) {
        if (!classes.length) {
            $('#studentsByClass').html('<div class="panel-body">' + emptyBox('bi-people', 'No classes found.') + '</div>');
            return;
        }

        const LIMIT = 12;

        $('#studentsByClass').html(classes.map(function (item, index) {
            const students = item.students || [];
            const id = 'classPane' + index;

            const body = students.length
                ? `<div class="student-grid">
                        ${students.slice(0, LIMIT).map(s => `
                            <div class="student-tile">
                                <div class="person">
                                    ${avatar(s)}
                                    <div>
                                        <strong>${esc(s.name)}</strong>
                                        <small>${esc(s.student_roll_no ? 'Roll ' + s.student_roll_no : (s.email || 'Student'))}</small>
                                    </div>
                                </div>
                            </div>`).join('')}
                   </div>
                   ${students.length > LIMIT
                        ? `<div class="student-more">and ${students.length - LIMIT} more · <a href="/instituteAdmin/students">View all students</a></div>`
                        : ''}`
                : '<div class="panel-body">' + emptyBox('bi-person-plus', 'No students in this class yet.') + '</div>';

            return `
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button ${index ? 'collapsed' : ''}" type="button"
                                data-bs-toggle="collapse" data-bs-target="#${id}">
                            <i class="bi bi-building"></i>
                            ${esc(item.class_name)}
                            <span class="acc-meta">
                                <small>${esc(item.group || '')}</small>
                                <span class="count-pill">${students.length}</span>
                            </span>
                        </button>
                    </h2>
                    <div id="${id}" class="accordion-collapse collapse ${index ? '' : 'show'}">
                        ${body}
                    </div>
                </div>`;
        }).join(''));
    }


    function showError() {
        const box = emptyBox('bi-exclamation-circle', "Couldn't load this section.", '<a href="#" onclick="location.reload();return false;">Try again</a>');

        $('#classesList, #subjectsList, #teacherGrid').html(box);
        $('#studentsByClass').html('<div class="panel-body">' + box + '</div>');
        $('#instituteName').text('Could not load institute');
        $('#statGrid .stat-value').text('—');
    }

    // ---------- Load data (shares the request the layout already made) ----------
    window.instituteDashboard
        .done(function (response) {
            const data = response.data || {};
            const classes  = data['Classes with students'] || [];
            const teachers = data['teacher assigned to classes and subjects'] || [];
            const subjects = data.total_subjects || [];

            countUp('#totalClasses', classes.length);
            countUp('#totalStudents', data.students_count ?? 0);
            countUp('#totalTeachers', data.teachers_count ?? 0);
            countUp('#totalSubjects', subjects.length);

            // Quiz numbers appear automatically once the API sends them
            if (data.quizzes_count !== undefined) {
                $('#quizCard').prop('hidden', false);
                countUp('#totalQuizzes', data.quizzes_count);
            }

            if (data.quiz_attempts_count !== undefined) {
                $('#attemptCard').prop('hidden', false);
                countUp('#totalAttempts', data.quiz_attempts_count);
            }

            renderInstitute(data.institute || {});
            renderClasses(classes, data.students_count ?? 0);
            renderSubjects(subjects);
            renderTeachers(teachers);
            renderStudentsByClass(classes);
        })
        .fail(function (xhr) {
            console.log('Dashboard error:', xhr);
            showError();
        });
</script>
@endpush