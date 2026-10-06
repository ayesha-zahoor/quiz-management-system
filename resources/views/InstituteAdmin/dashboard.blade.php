
@extends('layouts.institute')


@section('user-role', 'Institute Admin')
@section('page-title', 'Dashboard')
@section('page-description', 'Manage your institute, classes, teachers, and subjects')

@section('sidebar')

    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <i class="bi bi-mortarboard-fill"></i>
        </div>

        <div>
            <div class="sidebar-brand-title">Quiz Management</div>
            <div class="sidebar-brand-subtitle">Administration Portal</div>
        </div>
    </div>

    <nav class="sidebar-nav">

        <div class="sidebar-section-label">MAIN</div>

        <a href="/instituteAdmin/dashboard" class="nav-item">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>

        <a href="#" class="nav-item">
            <i class="bi bi-people-fill"></i>
            <span>Students</span>
        </a>

        <a href="#" class="nav-item">
            <i class="bi bi-person-workspace"></i>
            <span>Teachers</span>
        </a>

        <a href='/instituteAdmin/classes' class="nav-item">
            <i class="bi bi-building"></i>
            <span>Classes</span>
        </a>

        <a href="/instituteAdmin/subjects" class="nav-item">
            <i class="bi bi-book"></i>
            <span>Subjects</span>
        </a>

        <div class="sidebar-section-label mt-4">ACCOUNT</div>

        <a href="#" id="profileLink" class="nav-item">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </a>

    </nav>

    <div class="sidebar-footer">

        <div class="sidebar-user">

            <div class="sidebar-user-avatar" id="sidebarInitials">
                IA
            </div>

            <div class="sidebar-user-info">

                <div class="sidebar-user-name" id="sidebarUserName">
                    Institute Admin
                </div>

                <div class="sidebar-user-role">
                    Institute Administrator
                </div>

            </div>

            <button type="button" class="sidebar-logout" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </button>

        </div>

    </div>

@endsection


@section('content')

    {{-- Dashboard Header --}}

    <div class="dashboard-header-row">

        <div>

            <h2 class="dashboard-welcome">
                Welcome back, <span id="welcomeName">Institute Admin</span>
            </h2>

            <p class="dashboard-subtitle">
                Here's an overview of your institute.
            </p>

        </div>

        <div class="dashboard-date">
            <i class="bi bi-calendar3"></i>
            <span id="currentDate"></span>
        </div>

    </div>


    {{-- Statistics --}}

    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat-card">

                <div class="stat-card-top">

                    <div class="stat-icon">
                        <i class="bi bi-building"></i>
                    </div>

                    <span class="stat-label">
                        Total Classes
                    </span>

                </div>

                <div class="stat-value" id="totalClasses">
                    0
                </div>

                <div class="stat-footer">
                    <span>Classes in your institute</span>
                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat-card">

                <div class="stat-card-top">

                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <span class="stat-label">
                        Total Students
                    </span>

                </div>

                <div class="stat-value" id="totalStudents">
                    0
                </div>

                <div class="stat-footer">
                    <span>Registered students</span>
                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat-card">

                <div class="stat-card-top">

                    <div class="stat-icon">
                        <i class="bi bi-person-workspace"></i>
                    </div>

                    <span class="stat-label">
                        Total Teachers
                    </span>

                </div>

                <div class="stat-value" id="totalTeachers">
                    0
                </div>

                <div class="stat-footer">
                    <span>Institute teachers</span>
                </div>

            </div>

        </div>


        <div class="col-xl-3 col-md-6">

            <div class="dashboard-stat-card">

                <div class="stat-card-top">

                    <div class="stat-icon">
                        <i class="bi bi-book"></i>
                    </div>

                    <span class="stat-label">
                        Total Subjects
                    </span>

                </div>

                <div class="stat-value" id="totalSubjects">
                    0
                </div>

                <div class="stat-footer">
                    <span>Available subjects</span>
                </div>

            </div>

        </div>

    </div>


    {{-- Institute Information --}}

    <div class="dashboard-panel mb-4">

        <div class="dashboard-panel-header">

            <div>

                <h5>Institute Information</h5>

                <p>
                    Basic information about your institute
                </p>

            </div>

            <span id="instituteStatus"
                  class="status-badge status-active">
                Active
            </span>

        </div>


        <div class="institute-info">

            <div class="institute-logo-area">

                <div id="instituteLogo"
                     class="institute-logo">

                    <i class="bi bi-building"></i>

                </div>

            </div>


            <div class="institute-details">

                <div class="info-item">

                    <span class="info-label">
                        Institute Name
                    </span>

                    <strong id="instituteName">
                        —
                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Email
                    </span>

                    <strong id="instituteEmail">
                        —
                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Contact
                    </span>

                    <strong id="instituteContact">
                        —
                    </strong>

                </div>


                <div class="info-item">

                    <span class="info-label">
                        Address
                    </span>

                    <strong id="instituteAddress">
                        —
                    </strong>

                </div>

            </div>

        </div>

    </div>


    {{-- Classes & Subjects --}}

    <div class="dashboard-panel mb-4">

        <div class="dashboard-panel-header">

            <div>

                <h5>Classes & Subjects</h5>

                <p>
                    Academic classes and subjects available in your institute
                </p>

            </div>

        </div>


        <div class="row g-0">

            {{-- Classes --}}

            <div class="col-xl-7">

                <div class="section-inner">

                    <div class="section-title">
                        <i class="bi bi-building"></i>
                        Classes
                    </div>

                    <div class="table-responsive">

                        <table class="table dashboard-table align-middle mb-0">

                            <thead>

                                <tr>

                                    <th>Class</th>
                                    <th>Group</th>
                                    <th>Students</th>

                                </tr>

                            </thead>

                            <tbody id="classesTable">

                                <tr>

                                    <td colspan="3"
                                        class="text-center text-muted py-4">

                                        Loading...

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            {{-- Subjects --}}

            <div class="col-xl-5">

                <div class="section-inner subject-section">

                    <div class="section-title">

                        <i class="bi bi-book"></i>

                        Subjects

                        <span class="section-count"
                              id="subjectCount">
                            0
                        </span>

                    </div>


                    <div id="subjectsList"
                         class="subject-list">

                        <div class="alert-empty">
                            Loading...
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Teacher Assignments --}}

    <div class="dashboard-panel mb-4">

        <div class="dashboard-panel-header">

            <div>

                <h5>Teacher Assignments</h5>

                <p>
                    Teachers assigned to specific classes and subjects
                </p>

            </div>

        </div>


        <div class="table-responsive">

            <table class="table dashboard-table align-middle mb-0">

                <thead>

                    <tr>

                        <th>Teacher</th>
                        <th>Class</th>
                        <th>Subject</th>

                    </tr>

                </thead>


                <tbody id="teacherTable">

                    <tr>

                        <td colspan="3"
                            class="text-center text-muted py-4">

                            Loading...

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

    </div>


    {{-- Students by Class --}}

    <div class="dashboard-panel mb-4">

        <div class="dashboard-panel-header">

            <div>

                <h5>Students by Class</h5>

                <p>
                    Students currently enrolled in each class
                </p>

            </div>

        </div>


        <div id="studentsByClass">

            <div class="alert-empty">
                Loading...
            </div>

        </div>

    </div>


    {{-- Quick Actions --}}

    <div class="dashboard-panel">

        <div class="dashboard-panel-header">

            <div>

                <h5>Quick Actions</h5>

                <p>
                    Common institute administration tasks
                </p>

            </div>

        </div>


        <div class="quick-actions">

            <a href="#" class="quick-action">

                <div class="quick-action-icon">
                    <i class="bi bi-building"></i>
                </div>

                <div class="quick-action-content">

                    <strong>
                        Manage Classes
                    </strong>

                    <span>
                        Add, edit and organize institute classes
                    </span>

                </div>

                <i class="bi bi-chevron-right quick-action-arrow"></i>

            </a>


            <a href="#" class="quick-action">

                <div class="quick-action-icon">
                    <i class="bi bi-person-workspace"></i>
                </div>

                <div class="quick-action-content">

                    <strong>
                        Manage Teachers
                    </strong>

                    <span>
                        Manage teachers and class assignments
                    </span>

                </div>

                <i class="bi bi-chevron-right quick-action-arrow"></i>

            </a>


            <a href="#" class="quick-action">

                <div class="quick-action-icon">
                    <i class="bi bi-book"></i>
                </div>

                <div class="quick-action-content">

                    <strong>
                        Manage Subjects
                    </strong>

                    <span>
                        View and manage institute subjects
                    </span>

                </div>

                <i class="bi bi-chevron-right quick-action-arrow"></i>

            </a>

        </div>

    </div>

@endsection


@push('styles')

<style>

.dashboard-header-row {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 28px;
}

.dashboard-welcome {
    margin: 0 0 5px;
    font-size: 25px;
    font-weight: 700;
    color: var(--dark-text);
    letter-spacing: -0.4px;
}

.dashboard-subtitle {
    margin: 0;
    color: var(--slate);
    font-size: 14px;
}

.dashboard-date {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 13px;
    border: 1px solid var(--slate-light);
    border-radius: 8px;
    background: var(--white);
    color: var(--slate);
    font-size: 13px;
    white-space: nowrap;
}

.dashboard-stat-card {
    background: var(--white);
    border: 1px solid var(--slate-light);
    border-radius: 12px;
    padding: 20px;
    height: 100%;
    transition: border-color 0.2s ease, transform 0.2s ease;
}

.dashboard-stat-card:hover {
    border-color: var(--lime);
    transform: translateY(-2px);
}

.stat-card-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 9px;
    background: var(--lime-light);
    color: var(--lime-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
}

.stat-label {
    color: var(--slate);
    font-size: 13px;
    font-weight: 600;
    text-align: right;
}

.stat-value {
    margin-top: 18px;
    font-size: 30px;
    line-height: 1;
    font-weight: 700;
    color: var(--dark-text);
}

.stat-footer {
    display: flex;
    align-items: center;
    margin-top: 13px;
    color: var(--slate);
    font-size: 12px;
}

.dashboard-panel {
    background: var(--white);
    border: 1px solid var(--slate-light);
    border-radius: 12px;
    overflow: hidden;
}

.dashboard-panel-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 20px 22px;
    border-bottom: 1px solid var(--slate-light);
}

.dashboard-panel-header h5 {
    margin: 0 0 4px;
    color: var(--dark-text);
    font-size: 16px;
    font-weight: 700;
}

.dashboard-panel-header p {
    margin: 0;
    color: var(--slate);
    font-size: 12px;
}

.dashboard-table {
    --bs-table-bg: transparent;
}

.dashboard-table thead th {
    background: var(--off-white);
    color: var(--slate);
    border-bottom: 1px solid var(--slate-light);
    padding: 12px 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    white-space: nowrap;
}

.dashboard-table tbody td {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    color: var(--dark-text);
    font-size: 13px;
}

.dashboard-table tbody tr:last-child td {
    border-bottom: 0;
}

.institute-info {
    display: flex;
    gap: 25px;
    padding: 24px;
}

.institute-logo-area {
    flex: 0 0 auto;
}

.institute-logo {
    width: 80px;
    height: 80px;
    border-radius: 12px;
    border: 1px solid var(--slate-light);
    background: var(--lime-light);
    color: var(--lime-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    overflow: hidden;
}

.institute-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.institute-details {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px 35px;
}

.info-label {
    display: block;
    color: var(--slate);
    font-size: 11px;
    margin-bottom: 4px;
}

.info-item strong {
    color: var(--dark-text);
    font-size: 13px;
    font-weight: 600;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}

.status-active {
    background: var(--lime-light);
    color: var(--lime-dark);
}

.status-warning {
    background: #fef3c7;
    color: #b45309;
}

.status-danger {
    background: #fee2e2;
    color: #b91c1c;
}

.section-inner {
    height: 100%;
}

.subject-section {
    border-left: 1px solid var(--slate-light);
}

.section-title {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 16px 20px;
    color: var(--dark-text);
    font-size: 13px;
    font-weight: 700;
    border-bottom: 1px solid var(--slate-light);
}

.section-title i {
    color: var(--lime-dark);
}

.section-count {
    margin-left: auto;
    min-width: 25px;
    padding: 3px 7px;
    border-radius: 5px;
    background: var(--lime-light);
    color: var(--lime-dark);
    font-size: 11px;
    text-align: center;
}

.subject-list {
    padding: 12px 16px;
    max-height: 270px;
    overflow-y: auto;
}

.subject-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 8px;
    border-bottom: 1px solid #f1f5f9;
}

.subject-item:last-child {
    border-bottom: 0;
}

.subject-number {
    width: 28px;
    height: 28px;
    flex: 0 0 28px;
    border-radius: 7px;
    background: var(--lime-light);
    color: var(--lime-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
}

.subject-name {
    color: var(--dark-text);
    font-size: 13px;
    font-weight: 600;
}

.teacher-name-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.teacher-avatar {
    width: 36px;
    height: 36px;
    flex: 0 0 36px;
    border-radius: 50%;
    background: var(--lime-light);
    color: var(--lime-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    overflow: hidden;
}

.teacher-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.teacher-name {
    font-weight: 600;
    color: var(--dark-text);
}

.teacher-email {
    display: block;
    margin-top: 2px;
    color: var(--slate);
    font-size: 11px;
}

.assignment-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 8px;
    border-radius: 6px;
    background: var(--lime-light);
    color: var(--lime-dark);
    font-size: 11px;
    font-weight: 600;
}

.student-class-section {
    border-bottom: 1px solid var(--slate-light);
}

.student-class-section:last-child {
    border-bottom: 0;
}

.student-class-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 22px;
    background: var(--off-white);
}

.student-class-name {
    display: flex;
    align-items: center;
    gap: 9px;
    color: var(--dark-text);
    font-size: 13px;
    font-weight: 700;
}

.student-class-name i {
    color: var(--lime-dark);
}

.student-class-group {
    color: var(--slate);
    font-size: 11px;
    text-transform: capitalize;
}

.student-list {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0;
}

.student-item {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 13px 22px;
    border-bottom: 1px solid #f1f5f9;
}

.student-avatar {
    width: 36px;
    height: 36px;
    flex: 0 0 36px;
    border-radius: 50%;
    background: var(--lime-light);
    color: var(--lime-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    overflow: hidden;
}

.student-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.student-info strong {
    display: block;
    color: var(--dark-text);
    font-size: 13px;
    font-weight: 600;
}

.student-info span {
    display: block;
    color: var(--slate);
    font-size: 11px;
    margin-top: 2px;
}

.no-students {
    padding: 15px 22px;
    color: var(--slate);
    font-size: 12px;
}

.quick-actions {
    padding: 7px 12px 12px;
}

.quick-action {
    width: 100%;
    border: 0;
    border-bottom: 1px solid #f1f5f9;
    background: transparent;
    display: flex;
    align-items: center;
    gap: 12px;
    text-align: left;
    padding: 14px 10px;
    transition: background 0.2s ease;
    color: inherit;
    text-decoration: none;
}

.quick-action:last-child {
    border-bottom: 0;
}

.quick-action:hover {
    background: var(--off-white);
}

.quick-action-icon {
    width: 38px;
    height: 38px;
    flex: 0 0 38px;
    border-radius: 8px;
    background: var(--lime-light);
    color: var(--lime-dark);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.quick-action-content {
    flex: 1;
    min-width: 0;
}

.quick-action-content strong {
    display: block;
    color: var(--dark-text);
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 2px;
}

.quick-action-content span {
    display: block;
    color: var(--slate);
    font-size: 11px;
}

.quick-action-arrow {
    color: var(--slate);
    font-size: 13px;
}

.alert-empty {
    padding: 30px;
    text-align: center;
    color: var(--slate);
    font-size: 13px;
}

@media (max-width: 767.98px) {

    .dashboard-header-row {
        flex-direction: column;
    }

    .dashboard-date {
        width: 100%;
        justify-content: center;
    }

    .institute-info {
        flex-direction: column;
    }

    .institute-details {
        grid-template-columns: 1fr;
    }

    .subject-section {
        border-left: 0;
        border-top: 1px solid var(--slate-light);
    }

    .student-list {
        grid-template-columns: 1fr;
    }

}

</style>

@endpush


@push('scripts')

<script>

document.getElementById('currentDate').textContent =
    new Date().toLocaleDateString('en-US', {
        weekday: 'short',
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });


function esc(text) {
    return $('<div>').text(text ?? '').html();
}


function initials(name) {

    return (name || '?')
        .split(' ')
        .map(w => w[0])
        .slice(0, 2)
        .join('')
        .toUpperCase();

}


function statusClass(status) {

    if (status === 'active') {
        return 'status-active';
    }

    if (status === 'suspended') {
        return 'status-warning';
    }

    return 'status-danger';

}


$.ajax({

    url: '/api/instituteAdmin/dashboard',

    type: 'GET',

    headers: {
        'Authorization': 'Bearer ' + token
    },

    success: function(response) {

        console.log(response);

        const data = response.data || {};

        const institute = data.institute || {};

        const classes =
            data["Classes with students"] || [];

        const teachers =
            data["teacher assigned to classes and subjects"] || [];


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $('#totalClasses')
            .text(classes.length);

        $('#totalStudents')
            .text(data.students_count ?? 0);

        $('#totalTeachers')
            .text(data.teachers_count ?? 0);

        $('#totalSubjects')
            .text(data.total_subjects.length?? 0);


        /*
        |--------------------------------------------------------------------------
        | Institute Information
        |--------------------------------------------------------------------------
        */

        $('#instituteName')
            .text(institute.name || '—');

        $('#instituteEmail')
            .text(institute.email || '—');

        $('#instituteContact')
            .text(institute.Contact || '—');

        $('#instituteAddress')
            .text(institute.address || '—');


        if (institute.name) {

            $('#welcomeName')
                .text(institute.name);

            $('#sidebarUserName')
                .text('Institute Admin');

            $('#sidebarInitials')
                .text(initials(institute.name));

        }


        if (institute.status) {

            $('#instituteStatus')
                .text(institute.status)
                .removeClass(
                    'status-active status-warning status-danger'
                )
                .addClass(
                    statusClass(institute.status)
                );

        }


        if (institute.logo) {

            $('#instituteLogo').html(
                `<img src="/storage/${institute.logo}" alt="Institute Logo">`
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Classes
        |--------------------------------------------------------------------------
        */

        let classRows = '';

        if (classes.length) {

            classes.forEach(function(item) {

                const studentCount =
                    Array.isArray(item.students)
                        ? item.students.length
                        : 0;


                classRows += `

                    <tr>

                        <td>
                            <strong>
                                ${esc(item.class_name)}
                            </strong>
                        </td>

                        <td>
                            ${esc(item.group || '—')}
                        </td>

                        <td>
                            <span class="assignment-badge">
                                ${studentCount}
                                ${studentCount === 1 ? 'Student' : 'Students'}
                            </span>
                        </td>

                    </tr>

                `;

            });

        } else {

            classRows = `

                <tr>

                    <td colspan="3"
                        class="text-center text-muted py-4">

                        No classes found.

                    </td>

                </tr>

            `;

        }


        $('#classesTable')
            .html(classRows);


        /*
        |--------------------------------------------------------------------------
        | Subjects
        |--------------------------------------------------------------------------
        |
        | Subjects are collected from the teachers' teaching_subjects
        | relationship. This avoids inventing subject data that is not
        | present in the API response.
        |
        */

        const subjectMap = {};


        teachers.forEach(function(teacher) {

            const teachingSubjects =
                Array.isArray(teacher.teaching_subjects)
                    ? teacher.teaching_subjects
                    : [];


            teachingSubjects.forEach(function(subject) {

                if (subject && subject.id) {

                    subjectMap[subject.id] = subject;

                }

            });

        });


        const subjects =
            Object.values(subjectMap);

           
        $('#subjectCount')
            .text(data.total_subjects.length ?? subjects.length);


        let subjectHtml = '';

            //  console.log(subjects);
        if (data.total_subjects.length) {
            const  subjects = data.total_subjects;
            subjects.forEach(function(subject, index) {

                subjectHtml += `

                    <div class="subject-item">

                        <div class="subject-number">
                            ${index + 1}
                        </div>

                        <div class="subject-name">
                            ${esc(subject.name)}
                        </div>

                    </div>

                `;

            });

        } else {

            subjectHtml = `

                <div class="alert-empty">
                    No subject assignment data available.
                </div>

            `;

        }


        $('#subjectsList')
            .html(subjectHtml);


        /*
        |--------------------------------------------------------------------------
        | Teacher Assignments
        |--------------------------------------------------------------------------
        */

        let teacherRows = '';


        if (teachers.length) {

            teachers.forEach(function(teacher) {

                const teachingClasses =
                    Array.isArray(teacher.teaching_classes)
                        ? teacher.teaching_classes
                        : [];


                const teachingSubjects =
                    Array.isArray(teacher.teaching_subjects)
                        ? teacher.teaching_subjects
                        : [];


                const maxRows = Math.max(
                    teachingClasses.length,
                    teachingSubjects.length,
                    1
                );


                for (let i = 0; i < maxRows; i++) {

                    const className =
                        teachingClasses[i]?.class_name || '—';


                    const subjectName =
                        teachingSubjects[i]?.name || '—';


                    const avatar =
                        teacher.profile_image
                            ? `<img src="/storage/${teacher.profile_image}" alt="">`
                            : initials(teacher.name);


                    teacherRows += `

                        <tr>

                            <td>

                                <div class="teacher-name-cell">

                                    <div class="teacher-avatar">
                                        ${avatar}
                                    </div>

                                    <div>

                                        <div class="teacher-name">
                                            ${esc(teacher.name)}
                                        </div>

                                        <span class="teacher-email">
                                            ${esc(teacher.email)}
                                        </span>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <span class="assignment-badge">
                                    ${esc(className)}
                                </span>

                            </td>


                            <td>

                                <span class="assignment-badge">
                                    ${esc(subjectName)}
                                </span>

                            </td>

                        </tr>

                    `;

                }

            });

        } else {

            teacherRows = `

                <tr>

                    <td colspan="3"
                        class="text-center text-muted py-4">

                        No teacher assignments found.

                    </td>

                </tr>

            `;

        }


        $('#teacherTable')
            .html(teacherRows);


        /*
        |--------------------------------------------------------------------------
        | Students By Class
        |--------------------------------------------------------------------------
        */

        let studentsHtml = '';


        if (classes.length) {

            classes.forEach(function(item) {

                const students =
                    Array.isArray(item.students)
                        ? item.students
                        : [];


                studentsHtml += `

                    <div class="student-class-section">

                        <div class="student-class-header">

                            <div class="student-class-name">

                                <i class="bi bi-building"></i>

                                ${esc(item.class_name)}

                            </div>

                            <span class="student-class-group">

                                ${esc(item.group || '')}

                            </span>

                        </div>

                `;


                if (students.length) {

                    studentsHtml += `
                        <div class="student-list">
                    `;


                    students.forEach(function(student) {

                        const avatar =
                            student.profile_image
                                ? `<img src="/storage/${student.profile_image}" alt="">`
                                : initials(student.name);


                        studentsHtml += `

                            <div class="student-item">

                                <div class="student-avatar">
                                    ${avatar}
                                </div>

                                <div class="student-info">

                                    <strong>
                                        ${esc(student.name)}
                                    </strong>

                                    <span>
                                        ${esc(student.email || 'Student')}
                                    </span>

                                </div>

                            </div>

                        `;

                    });


                    studentsHtml += `
                        </div>
                    `;

                } else {

                    studentsHtml += `

                        <div class="no-students">
                            No students enrolled in this class.
                        </div>

                    `;

                }


                studentsHtml += `
                    </div>
                `;

            });

        } else {

            studentsHtml = `

                <div class="alert-empty">
                    No classes found.
                </div>

            `;

        }


        $('#studentsByClass')
            .html(studentsHtml);

    },


    error: function(xhr) {

        console.log(
            'Dashboard error:',
            xhr
        );


        $('#classesTable').html(`

            <tr>

                <td colspan="3"
                    class="text-center text-danger py-4">

                    Could not load dashboard data.

                </td>

            </tr>

        `);


        $('#teacherTable').html(`

            <tr>

                <td colspan="3"
                    class="text-center text-danger py-4">

                    Could not load dashboard data.

                </td>

            </tr>

        `);


        $('#subjectsList').html(`

            <div class="alert-empty text-danger">

                Could not load dashboard data.

            </div>

        `);


        $('#studentsByClass').html(`

            <div class="alert-empty text-danger">

                Could not load dashboard data.

            </div>

        `);

    }

});

</script>

@endpush