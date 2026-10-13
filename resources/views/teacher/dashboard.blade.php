@extends('layouts.teacher')

@section('title', 'Teacher Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Manage your classes, subjects, and quizzes')

@section('content')

<div class="td">

    {{-- ================= Welcome banner ================= --}}
    <section class="td-hero">

        <div class="td-hero-text">
            <span class="td-date"><i class="bi bi-calendar3"></i> <span id="today"></span></span>

            <h2><span id="greeting">Welcome back</span>, <span id="heroName">Teacher</span></h2>
            <p>Here's what's happening with your quizzes today.</p>

            <div class="td-hero-actions">
                <a href="/teacher/quizzes/create" class="td-btn solid"><i class="bi bi-plus-lg"></i> Create New Quiz</a>
                <a href="/teacher/quizzes" class="td-btn ghost"><i class="bi bi-collection"></i> Manage Quizzes</a>
            </div>
        </div>

        <div class="td-hero-inst">
            <div class="td-hero-logo">
                <i class="bi bi-building" id="heroInstIcon"></i>
                <img id="heroInstLogo" src="" alt="Institute logo" class="d-none">
            </div>
            <div>
                <small>Your institute</small>
                <strong id="heroInstName">Loading...</strong>
            </div>
        </div>

    </section>


    {{-- ================= Stats ================= --}}
    <div class="td-stats">

        <article class="stat glass t1">
            <div class="stat-top">
                <span class="stat-label">Total Quizzes</span>
                <span class="stat-ico"><i class="bi bi-file-earmark-text"></i></span>
            </div>
            <div class="stat-value" id="totalQuizzes">0</div>
            <div class="stat-foot">All quizzes you created</div>
        </article>

        <article class="stat glass t2">
            <div class="stat-top">
                <span class="stat-label">Published</span>
                <span class="stat-ico"><i class="bi bi-check2-circle"></i></span>
            </div>
            <div class="stat-value" id="publishedQuizzes">0</div>
            <div class="stat-bar"><span id="publishedBar"></span></div>
            <div class="stat-foot"><span id="publishedPct">0%</span> available to students</div>
        </article>

        <article class="stat glass t3">
            <div class="stat-top">
                <span class="stat-label">Draft Quizzes</span>
                <span class="stat-ico"><i class="bi bi-pencil-square"></i></span>
                
                
            </div>
            <div class="stat-value" id="draftQuizzes">0</div>
            <div class="stat-bar"><span id="draftBar"></span></div>
            <div class="stat-foot"><span id="draftPct">0%</span> not yet published</div>
        </article>

        <article class="stat glass t4">
            <div class="stat-top">
                <span class="stat-label">My Classes</span>
                <span class="stat-ico"><i class="bi bi-mortarboard"></i></span>
            </div>
            <div class="stat-value" id="assignedClasses">0</div>
            <div class="stat-foot">Classes assigned to you</div>
        </article>

    </div>


    <div class="row g-4">

        {{-- ================= Quizzes ================= --}}
        <div class="col-xl-8">

            <section class="panel glass">

                <header class="panel-head">
                    <div>
                        <h5>My Quizzes</h5>
                        <p>View and manage your assessments</p>
                    </div>
                    <a href="/teacher/quizzes" class="panel-link">View all <i class="bi bi-arrow-right"></i></a>
                </header>

                <div class="quiz-tools">
                    <div class="search">
                        <i class="bi bi-search"></i>
                        <input type="search" id="quizSearch" placeholder="Search by title, class or subject" aria-label="Search quizzes" autocomplete="off">
                    </div>

                    <div class="seg" id="quizFilter" role="group" aria-label="Filter quizzes">
                        <button type="button" class="on" data-filter="all">All <b id="cntAll">0</b></button>
                        <button type="button" data-filter="published">Published <b id="cntPublished">0</b></button>
                        <button type="button" data-filter="draft">Drafts <b id="cntDraft">0</b></button>
                    </div>
                </div>

                <div id="quizList">
                    <div class="skeleton" style="height:82px"></div>
                    <div class="skeleton" style="height:82px"></div>
                    <div class="skeleton" style="height:82px"></div>
                </div>

                <div class="quiz-footer d-none" id="quizFooter"></div>

            </section>

        </div>


        {{-- ================= Side ================= --}}
        <div class="col-xl-4">

            <section class="panel glass mb-4">
                <h5 class="side-title">Your Profile</h5>

                <div class="profile">
                    <div class="profile-avatar">
                        <span id="profileInitials">T</span>
                        <img id="profileAvatar" src="" alt="Teacher profile picture" class="d-none">
                    </div>

                    <div class="profile-info">
                        <strong id="profileName">Loading...</strong>
                        <small id="profileEmail">Loading email...</small>
                        <span class="role-pill"><i class="bi bi-person-badge"></i> Teacher</span>
                    </div>
                </div>
            </section>

            <section class="panel glass mb-4">
                <h5 class="side-title">What you teach</h5>

                <div class="teach-block">
                    <span class="teach-label"><i class="bi bi-mortarboard"></i> Classes</span>
                    <div class="chips" id="teacherAssignedClasses"><span class="muted">Loading...</span></div>
                </div>

                <div class="teach-block">
                    <span class="teach-label"><i class="bi bi-book"></i> Subjects</span>
                    <div class="chips" id="teacherAssignedSubjects"><span class="muted">Loading...</span></div>
                </div>
            </section>

            <section class="panel glass">
                <h5 class="side-title">Quick Actions</h5>

                <div class="quick">
                    <a href="/teacher/quizzes/create" class="quick-link">
                        <span class="quick-ico"><i class="bi bi-plus-circle"></i></span>
                        <span><strong>Create a Quiz</strong><small>Start a new assessment</small></span>
                        <i class="bi bi-chevron-right"></i>
                    </a>

                    <a href="/teacher/quizzes" class="quick-link">
                        <span class="quick-ico"><i class="bi bi-collection"></i></span>
                        <span><strong>Manage Quizzes</strong><small>View and update your quizzes</small></span>
                        <i class="bi bi-chevron-right"></i>
                    </a>

                    <a href="/teacher/profile" class="quick-link">
                        <span class="quick-ico"><i class="bi bi-person-circle"></i></span>
                        <span><strong>My Profile</strong><small>View your account</small></span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </section>

        </div>

    </div>

</div>

@endsection


@push('styles')
<style>

    /* ---------- Glass ---------- */
    .glass {
        background: rgba(255, 255, 255, 0.58);
        -webkit-backdrop-filter: blur(16px) saturate(170%);
        backdrop-filter: blur(16px) saturate(170%);
        border: 1px solid rgba(255, 255, 255, 0.78);
        border-radius: 20px;
        box-shadow:
            0 14px 34px -14px color-mix(in srgb, var(--secondary-color) 40%, transparent),
            0 2px 6px rgba(15, 23, 42, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.95);
    }

    /* ---------- Welcome banner ---------- */
    .td-hero {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 24px;
        padding: 28px 32px;
        border-radius: 24px;
        overflow: hidden;
        color: var(--on-secondary);
        background: linear-gradient(125deg, var(--secondary-color), color-mix(in srgb, var(--secondary-color) 52%, var(--primary-color)));
        box-shadow: 0 26px 50px -24px color-mix(in srgb, var(--secondary-color) 75%, transparent);
    }

    .td-hero::before,
    .td-hero::after { content: ""; position: absolute; border-radius: 50%; pointer-events: none; }
    .td-hero::before { width: 320px; height: 320px; right: -80px; top: -150px; background: color-mix(in srgb, var(--primary-color) 40%, transparent); filter: blur(10px); }
    .td-hero::after  { width: 220px; height: 220px; right: 220px; bottom: -150px; background: color-mix(in srgb, var(--accent-color) 38%, transparent); filter: blur(14px); }

    .td-hero-text { position: relative; z-index: 1; min-width: 0; }

    .td-date {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        margin-bottom: 14px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.24);
        font-size: 12px;
        font-weight: 600;
    }

    .td-hero h2 { margin: 0 0 6px; font-size: clamp(24px, 3vw, 32px); font-weight: 800; letter-spacing: -0.6px; }
    .td-hero p { margin: 0 0 20px; opacity: 0.85; font-size: 15px; }

    .td-hero-actions { display: flex; flex-wrap: wrap; gap: 10px; }

    .td-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }
    .td-btn:hover { transform: translateY(-2px); }

    .td-btn.solid { background: var(--primary-color); color: var(--on-primary); box-shadow: 0 12px 24px -10px rgba(0, 0, 0, 0.45); }
    .td-btn.solid:hover { color: var(--on-primary); box-shadow: 0 16px 28px -10px rgba(0, 0, 0, 0.5); }

    .td-btn.ghost {
        background: rgba(255, 255, 255, 0.16);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: inherit;
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
    }
    .td-btn.ghost:hover { background: rgba(255, 255, 255, 0.26); color: inherit; }

    .td-hero-inst {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 18px 12px 12px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.26);
        -webkit-backdrop-filter: blur(10px);
        backdrop-filter: blur(10px);
        max-width: 320px;
    }

    .td-hero-logo {
        width: 54px;
        height: 54px;
        flex: 0 0 54px;
        border-radius: 14px;
        background: #fff;
        color: var(--secondary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        overflow: hidden;
    }
    .td-hero-logo img { width: 100%; height: 100%; object-fit: contain; padding: 5px; }

    .td-hero-inst small { display: block; opacity: 0.75; font-size: 12px; }
    .td-hero-inst strong { display: block; font-size: 15px; line-height: 1.25; overflow-wrap: anywhere; }

    /* ---------- Stat cards ---------- */
    .td-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 18px; margin-bottom: 24px; }

    .stat { position: relative; padding: 22px; overflow: hidden; transition: transform 0.25s ease, box-shadow 0.25s ease; }

    .stat::after {
        content: "";
        position: absolute;
        width: 150px;
        height: 150px;
        right: -46px;
        top: -56px;
        border-radius: 50%;
        background: radial-gradient(circle, var(--glow), transparent 68%);
        pointer-events: none;
    }

    .stat:hover {
        transform: translateY(-5px);
        box-shadow:
            0 24px 44px -16px color-mix(in srgb, var(--secondary-color) 50%, transparent),
            0 2px 6px rgba(15, 23, 42, 0.06),
            inset 0 1px 0 rgba(255, 255, 255, 0.95);
    }

    .stat.t1 { --glow: color-mix(in srgb, var(--primary-color) 55%, transparent); --ico: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); --on: var(--on-primary); }
    .stat.t2 { --glow: color-mix(in srgb, var(--accent-color) 55%, transparent);  --ico: linear-gradient(135deg, var(--accent-color), var(--primary-color)); --on: var(--on-accent); }
    .stat.t3 { --glow: color-mix(in srgb, var(--secondary-color) 35%, transparent); --ico: linear-gradient(135deg, var(--secondary-color), color-mix(in srgb, var(--secondary-color) 55%, var(--primary-color))); --on: var(--on-secondary); }
    .stat.t4 { --glow: color-mix(in srgb, var(--primary-color) 40%, var(--accent-color) 20%); --ico: linear-gradient(135deg, var(--primary-color), var(--accent-color)); --on: var(--on-primary); }

    .stat-top { position: relative; display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 14px; }
    .stat-label { color: var(--slate); font-size: 14px; font-weight: 600; }

    .stat-ico {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: var(--ico);
        color: var(--on);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        box-shadow: 0 10px 20px -8px color-mix(in srgb, var(--secondary-color) 55%, transparent);
    }

    .stat-value { position: relative; font-size: 38px; line-height: 1; font-weight: 800; letter-spacing: -1px; color: var(--text-color); font-variant-numeric: tabular-nums; }

    .stat-bar { position: relative; height: 6px; margin: 14px 0 4px; border-radius: 999px; background: rgba(15, 23, 42, 0.08); overflow: hidden; }
    .stat-bar span { display: block; width: 0; height: 100%; border-radius: 999px; background: var(--ico); transition: width 0.8s ease; }

    .stat-foot { position: relative; margin-top: 10px; color: var(--slate); font-size: 13px; }
    .stat-foot span { font-weight: 700; color: var(--text-color); }

    /* ---------- Panels ---------- */
    .panel { padding: 22px; }

    .panel-head { display: flex; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 18px; }
    .panel-head h5, .side-title { margin: 0; font-size: 17px; font-weight: 700; color: var(--text-color); }
    .panel-head p { margin: 3px 0 0; color: var(--slate); font-size: 13px; }
    .side-title { margin-bottom: 16px; }

    .panel-link { display: inline-flex; align-items: center; gap: 6px; color: var(--primary-dark); font-size: 13px; font-weight: 700; white-space: nowrap; }
    .panel-link:hover { color: var(--text-color); }

    /* ---------- Quiz tools ---------- */
    .quiz-tools { display: flex; flex-wrap: wrap; align-items: center; gap: 12px; margin-bottom: 16px; }

    .search { position: relative; flex: 1 1 220px; }
    .search i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--slate); font-size: 14px; pointer-events: none; }
    .search input {
        width: 100%;
        height: 42px;
        padding: 0 14px 0 38px;
        border: 1px solid rgba(255, 255, 255, 0.9);
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.7);
        font: inherit;
        font-size: 14px;
        color: var(--text-color);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .search input:focus { outline: 0; border-color: var(--primary-color); box-shadow: 0 0 0 4px color-mix(in srgb, var(--primary-color) 22%, transparent); }

    .seg { display: inline-flex; padding: 4px; gap: 2px; border-radius: 12px; background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); }
    .seg button {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border: 0;
        border-radius: 9px;
        background: transparent;
        color: var(--slate);
        font-size: 13px;
        font-weight: 600;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .seg button b { padding: 1px 7px; border-radius: 999px; background: rgba(15, 23, 42, 0.07); font-size: 11px; }
    .seg button.on { background: var(--primary-color); color: var(--on-primary); box-shadow: 0 6px 14px -6px color-mix(in srgb, var(--primary-color) 80%, black); }
    .seg button.on b { background: rgba(255, 255, 255, 0.35); }

    /* ---------- Quiz rows ---------- */
    .quiz-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 16px;
        margin-bottom: 10px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.85);
        color: inherit;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .quiz-row:hover {
        transform: translateY(-2px);
        border-color: var(--primary-color);
        box-shadow: 0 14px 28px -14px color-mix(in srgb, var(--secondary-color) 45%, transparent);
        color: inherit;
    }

    .quiz-ico {
        width: 46px;
        height: 46px;
        flex: 0 0 46px;
        border-radius: 14px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .quiz-main { flex: 1; min-width: 0; }
    .quiz-title-row { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 8px; }
    .quiz-title-row strong { font-size: 15px; font-weight: 700; color: var(--text-color); overflow-wrap: anywhere; }

    .pill { padding: 4px 11px; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .pill.published { background: #dcfce7; color: #166534; }
    .pill.draft { background: #fef3c7; color: #92400e; }

    .quiz-sub { margin-top: 3px; color: var(--slate); font-size: 13px; }
    .quiz-meta { display: flex; flex-wrap: wrap; gap: 6px 16px; margin-top: 8px; color: var(--slate); font-size: 12.5px; }
    .quiz-meta i { margin-right: 5px; color: var(--primary-dark); }
    .quiz-go { color: var(--slate); transition: transform 0.2s ease; }
    .quiz-row:hover .quiz-go { transform: translateX(3px); color: var(--primary-dark); }

    .quiz-footer { margin-top: 6px; padding-top: 14px; border-top: 1px solid rgba(15, 23, 42, 0.07); display: flex; justify-content: space-between; align-items: center; gap: 12px; color: var(--slate); font-size: 13px; }

    /* ---------- Profile ---------- */
    .profile { display: flex; align-items: center; gap: 16px; }

    .profile-avatar {
        position: relative;
        width: 74px;
        height: 74px;
        flex: 0 0 74px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        color: var(--on-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 800;
        overflow: hidden;
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.9), 0 12px 24px -8px color-mix(in srgb, var(--secondary-color) 55%, transparent);
    }
    .profile-avatar img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }

    .profile-info { min-width: 0; }
    .profile-info strong { display: block; font-size: 17px; font-weight: 700; overflow-wrap: anywhere; }
    .profile-info small { display: block; margin: 2px 0 8px; color: var(--slate); font-size: 13px; overflow-wrap: anywhere; }

    .role-pill { display: inline-flex; align-items: center; gap: 6px; padding: 4px 11px; border-radius: 999px; background: var(--primary-light); color: var(--primary-dark); font-size: 12px; font-weight: 700; }

    /* ---------- What you teach ---------- */
    .teach-block + .teach-block { margin-top: 16px; padding-top: 16px; border-top: 1px solid rgba(15, 23, 42, 0.07); }
    .teach-label { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; color: var(--slate); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .teach-label i { color: var(--primary-dark); }

    .chips { display: flex; flex-wrap: wrap; gap: 8px; }
    .chip { padding: 6px 12px; border-radius: 10px; background: var(--primary-light); color: var(--primary-dark); font-size: 13px; font-weight: 600; }
    .chip small { margin-left: 6px; opacity: 0.75; font-weight: 500; text-transform: capitalize; }
    .chip.alt { background: color-mix(in srgb, var(--accent-color) 22%, white); color: var(--text-color); }
    .muted { color: var(--slate); font-size: 13px; }

    /* ---------- Quick actions ---------- */
    .quick { display: grid; gap: 10px; }

    .quick-link {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 13px 14px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.85);
        color: inherit;
        transition: transform 0.2s ease, border-color 0.2s ease;
    }
    .quick-link:hover { transform: translateX(4px); border-color: var(--primary-color); color: inherit; }
    .quick-link > span:nth-child(2) { flex: 1; min-width: 0; }
    .quick-link strong { display: block; font-size: 14px; }
    .quick-link small { display: block; color: var(--slate); font-size: 12px; }
    .quick-link > i { color: var(--slate); font-size: 13px; }

    .quick-ico { width: 40px; height: 40px; flex: 0 0 40px; border-radius: 12px; background: var(--primary-light); color: var(--primary-dark); display: flex; align-items: center; justify-content: center; font-size: 18px; }

    /* ---------- Empty / error / loading ---------- */
    .empty { padding: 34px 16px; text-align: center; color: var(--slate); }
    .empty i { display: block; margin-bottom: 10px; font-size: 38px; color: var(--primary-dark); }
    .empty h6 { color: var(--text-color); font-weight: 700; }
    .empty.error i { color: #DC2626; }

    .skeleton {
        margin-bottom: 10px;
        border-radius: 16px;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.4) 25%, rgba(255, 255, 255, 0.85) 50%, rgba(255, 255, 255, 0.4) 75%);
        background-size: 200% 100%;
        animation: shimmer 1.3s infinite linear;
    }
    @keyframes shimmer { to { background-position: -200% 0; } }

    /* ---------- Responsive ---------- */
    @media (max-width: 767.98px) {
        .td-hero { flex-direction: column; align-items: flex-start; padding: 22px 20px; }
        .td-hero-inst { max-width: 100%; width: 100%; }
        .panel { padding: 18px; }
        .seg { width: 100%; }
        .seg button { flex: 1; justify-content: center; }
        .quiz-go { display: none; }
    }

    @supports not ((backdrop-filter: blur(1px)) or (-webkit-backdrop-filter: blur(1px))) {
        .glass { background: rgba(255, 255, 255, 0.92); }
    }
</style>
@endpush


@push('scripts')
<script>
    (function () {
        const ui = window.teacherUi;
        const PREVIEW_COUNT = 6;

        let quizzes = [];          // the teacher's quizzes
        let classes = [];          // classes assigned to the teacher
        let subjects = [];         // subjects assigned to the teacher
        let dash = {};             // the dashboard payload
        let filter = 'all';

        // ---------- Header ----------
        $('#today').text(new Date().toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric', year: 'numeric' }));

        const hour = new Date().getHours();
        $('#greeting').text(hour < 12 ? 'Good morning' : hour < 18 ? 'Good afternoon' : 'Good evening');

        // ---------- Helpers ----------
        function esc(value) {
            return $('<div>').text(value ?? '').html();
        }

        function countUp(selector, target) {
            const el = document.querySelector(selector);
            if (!el) return;

            target = Number(target) || 0;
            const from = Number(el.textContent) || 0;

            if (from === target || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                el.textContent = target;
                return;
            }

            const start = performance.now(), duration = 600;

            (function tick(now) {
                const p = Math.min((now - start) / duration, 1);
                el.textContent = Math.round(from + (target - from) * (1 - Math.pow(1 - p, 3)));
                if (p < 1) requestAnimationFrame(tick);
            })(start);
        }

        // The API may send an array, { data: [...] }, a paginator, or an object of quizzes
        function toList(payload) {
            if (Array.isArray(payload)) return payload;
            if (Array.isArray(payload?.data)) return payload.data;
            if (Array.isArray(payload?.data?.data)) return payload.data.data;
            if (Array.isArray(payload?.quizzes)) return payload.quizzes;

            if (payload && typeof payload === 'object') {
                const values = Object.values(payload);
                if (values.length && values.every(v => v && typeof v === 'object' && 'id' in v)) return values;
            }

            return [];
        }

        function isPublished(quiz) {
            return quiz.is_published === true || quiz.is_published === 1 || quiz.is_published === '1';
        }

        function className(quiz) {
            const assigned = classes.find(c => Number(c.id) === Number(quiz.class_id));

            return quiz.academic_class?.class_name || quiz.academicClass?.class_name || quiz.school_class?.class_name ||
                assigned?.class_name || quiz.class_name || 'Class not specified';
        }

        function subjectName(quiz) {
            const assigned = subjects.find(s => Number(s.id) === Number(quiz.subject_id));

            return quiz.subject?.subject_name || quiz.subject?.name ||
                assigned?.subject_name || assigned?.name || quiz.subject_name || 'Subject not specified';
        }

        // ---------- Stats ----------
        function figure(key, derived) {
            return dash[key] !== undefined && dash[key] !== null ? Number(dash[key]) : derived;
        }

        function renderStats() {
            const published = quizzes.filter(isPublished).length;

            const total = figure('total_quizzes', quizzes.length);
            const pub = figure('published_quizzes', published);
            const draft = figure('draft_quizzes', quizzes.length - published);

            countUp('#totalQuizzes', total);
            countUp('#publishedQuizzes', pub);
            countUp('#draftQuizzes', draft);
            countUp('#assignedClasses', classes.length);

            const pct = value => total ? Math.round((value / total) * 100) : 0;

            $('#publishedBar').css('width', pct(pub) + '%');
            $('#draftBar').css('width', pct(draft) + '%');
            $('#publishedPct').text(pct(pub) + '%');
            $('#draftPct').text(pct(draft) + '%');

            $('#cntAll').text(quizzes.length);
            $('#cntPublished').text(published);
            $('#cntDraft').text(quizzes.length - published);
        }

        // ---------- Quiz list ----------
        function emptyBox(icon, title, text, button) {
            return `<div class="empty"><i class="bi ${icon}"></i><h6>${title}</h6><p class="mb-3">${text}</p>${button || ''}</div>`;
        }

        function renderQuizzes() {
            const query = ($('#quizSearch').val() || '').toLowerCase().trim();

            let list = quizzes.filter(function (quiz) {
                const published = isPublished(quiz);
                const matchesStatus = filter === 'all' || (filter === 'published' && published) || (filter === 'draft' && !published);
                const matchesText = !query ||
                    (quiz.title || '').toLowerCase().includes(query) ||
                    className(quiz).toLowerCase().includes(query) ||
                    subjectName(quiz).toLowerCase().includes(query);

                return matchesStatus && matchesText;
            });

            // Newest first when dates are available
            list.sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0));

            if (!quizzes.length) {
                $('#quizList').html(emptyBox('bi-journal-plus', 'No quizzes yet', 'Create your first quiz to get started.',
                    '<a href="/teacher/quizzes/create" class="btn btn-primary btn-sm px-3"><i class="bi bi-plus-lg me-1"></i>Create Quiz</a>'));
                $('#quizFooter').addClass('d-none');
                return;
            }

            if (!list.length) {
                $('#quizList').html(emptyBox('bi-journal-x', 'No quizzes found', 'Try another search or filter.'));
                $('#quizFooter').addClass('d-none');
                return;
            }

            const shown = query ? list.slice(0, 30) : list.slice(0, PREVIEW_COUNT);

            $('#quizList').html(shown.map(function (quiz) {
                const published = isPublished(quiz);
                const questions = quiz.questions_count ?? quiz.questions?.length ?? 0;

                return `
                    return 
    <div class="quiz-row">
        <span class="quiz-ico">
            <i class="bi bi-file-earmark-text"></i>
        </span>

        <div class="quiz-main">
            <div class="quiz-title-row">
                <strong>${esc(quiz.title || 'Untitled Quiz')}</strong>
                <span class="pill ${published ? 'published' : 'draft'}">
                    ${published ? 'Published' : 'Draft'}
                </span>
            </div>

            <div class="quiz-sub">
                ${esc(className(quiz))} &middot; ${esc(subjectName(quiz))}
            </div>

            <div class="quiz-meta">
                <span><i class="bi bi-patch-check"></i>${esc(quiz.total_marks ?? '—')} marks</span>
                <span><i class="bi bi-clock"></i>${esc(quiz.time_limit_minutes ?? '—')} min</span>
                <span><i class="bi bi-list-check"></i>${esc(questions)} questions</span>
            </div>

            <div class="mt-3">
                <a href="/teacher/${quiz.id}/questions"
                   class="btn btn-sm btn-primary">
                    <i class="bi bi-list-check me-1"></i> Manage Questions
                </a>
            </div>
        </div>
    </div>`;
            }).join(''));

            $('#quizFooter')
                .removeClass('d-none')
                .html(`<span>Showing ${shown.length} of ${list.length} quiz${list.length === 1 ? '' : 'zes'}</span>
                       <a href="/teacher/quizzes" class="panel-link">Manage all quizzes <i class="bi bi-arrow-right"></i></a>`);
                       
                       
        }

        $('#quizSearch').on('input', renderQuizzes);

        $('#quizFilter').on('click', 'button', function () {
            filter = $(this).data('filter');
            $('#quizFilter button').removeClass('on');
            $(this).addClass('on');
            renderQuizzes();
        });

        // ---------- Side panels ----------
        function renderTeaching() {
            $('#teacherAssignedClasses').html(classes.length
                ? classes.map(c => `<span class="chip">${esc(c.class_name || 'Unnamed class')}${c.group ? `<small>${esc(c.group)}</small>` : ''}</span>`).join('')
                : '<span class="muted">No classes assigned yet. Ask your institute admin.</span>');

            $('#teacherAssignedSubjects').html(subjects.length
                ? subjects.map(s => `<span class="chip alt">${esc(s.subject_name || s.name || 'Unnamed subject')}</span>`).join('')
                : '<span class="muted">No subjects assigned yet. Ask your institute admin.</span>');
        }

        function renderProfile(data) {
            const teacher = data.teacher || data.user || data.profile || {};
            const institute = data.institute || {};
            const name = teacher.name || data.teacher_name || 'Teacher';

            $('#heroName').text(name.split(' ')[0]);
            $('#profileName').text(name);
            $('#profileEmail').text(teacher.email || data.email || 'Email not available');
            $('#profileInitials').text(ui.initialsOf(name));
            $('#heroInstName').text(institute.name || 'Your Institute');

            ui.setImage('#profileAvatar', teacher.profile_image, '#profileInitials');
            ui.setImage('#heroInstLogo', institute.logo, '#heroInstIcon');
        }

        // ---------- Load quizzes (own request, so the list never depends on the dashboard payload) ----------
        function quizzesFromDashboard() {
            return toList(dash.quizzes ?? dash.recent_quizzes);
        }

        function loadQuizzes() {
            $('#quizList').html('<div class="skeleton" style="height:82px"></div><div class="skeleton" style="height:82px"></div><div class="skeleton" style="height:82px"></div>');

            $.ajax({
                url: '/api/teacher/quizzes',
                type: 'GET',
                headers: { Authorization: 'Bearer ' + window.token, Accept: 'application/json' }
            })
            .done(function (response) {
                const list = toList(response);
                quizzes = list.length ? list : quizzesFromDashboard();
                renderStats();
                renderQuizzes();
            })
            .fail(function (xhr) {
                console.error('Quizzes request failed:', xhr.status, xhr.responseText);

                const fallback = quizzesFromDashboard();

                if (fallback.length) {
                    quizzes = fallback;
                    renderStats();
                    renderQuizzes();
                    return;
                }

                $('#quizList').html(emptyBox('bi-exclamation-circle', "Couldn't load your quizzes", 'Check your connection and try again.',
                    '<button type="button" class="btn btn-primary btn-sm px-3" id="retryQuizzes"><i class="bi bi-arrow-clockwise me-1"></i>Try again</button>')
                    .replace('class="empty"', 'class="empty error"'));
            });
        }

        $(document).on('click', '#retryQuizzes', loadQuizzes);

        // ---------- Dashboard (shared request from the layout) ----------
        window.teacherDashboard
            .done(function (response) {
                dash = (response && response.data) || {};
                classes = dash.classes || [];
                subjects = dash.subjects || dash.teaching_subjects || [];

                renderProfile(dash);
                renderTeaching();
                renderStats();
                renderQuizzes();           // class and subject names are known now
            })
            .fail(function (xhr) {
                console.error('Teacher dashboard request failed:', xhr.status, xhr.responseText);
                $('#teacherAssignedClasses, #teacherAssignedSubjects').html('<span class="muted">Could not load this.</span>');
                $('#heroInstName').text('Unavailable');
            });

        loadQuizzes();
    })();
</script>
@endpush