@extends('layouts.institute')

@section('title', 'Teacher Management')
@section('user-role', 'Institute Admin')
@section('page-title', 'Teacher Management')
@section('page-description', 'Manage institute teachers and their accounts')

@section('sidebar')
<a href="/instituteAdmin/dashboard" class="nav-link">
    <i class="bi bi-speedometer2"></i>
    <span>Dashboard</span>
</a>

<a href="/instituteAdmin/classes" class="nav-link">
    <i class="bi bi-building"></i>
    <span>Class Management</span>
</a>

<a href="/instituteAdmin/subjects" class="nav-link">
    <i class="bi bi-book"></i>
    <span>Subject Management</span>
</a>

<a href="/instituteAdmin/teachers" class="nav-link active">
    <i class="bi bi-person-badge"></i>
    <span>Teacher Management</span>
</a>

<a href="#" class="nav-link">
    <i class="bi bi-people"></i>
    <span>Student Management</span>
</a>
@endsection

@section('content')

<div class="container-fluid px-0">
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Teachers</h4>
        <p class="text-muted mb-0">
            Manage teachers associated with your institute
        </p>
    </div>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#teacherModal">
        <i class="bi bi-plus-lg me-1"></i>
        Add Teacher
    </button>
</div>


<div class="row g-3 mb-4">

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="icon-box me-3">
                    <i class="bi bi-person-badge"></i>
                </div>

                <div>
                    <small class="text-muted">Total Teachers</small>
                    <h4 class="mb-0" id="totalTeachers">0</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="icon-box me-3">
                    <i class="bi bi-person-check"></i>
                </div>

                <div>
                    <small class="text-muted">Active Teachers</small>
                    <h4 class="mb-0" id="activeTeachers">0</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="icon-box me-3">
                    <i class="bi bi-person-x"></i>
                </div>

                <div>
                    <small class="text-muted">Inactive Teachers</small>
                    <h4 class="mb-0" id="inactiveTeachers">0</h4>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-header bg-white border-0 py-3">
        <div class="d-flex justify-content-between align-items-center">

            <div>
                <h5 class="mb-1">Teacher List</h5>
                <small class="text-muted">
                    Teachers registered in this institute
                </small>
            </div>

            <div class="input-group search-box">
                <span class="input-group-text bg-white">
                    <i class="bi bi-search"></i>
                </span>
                <input
                    type="text"
                    class="form-control"
                    id="teacherSearch"
                    placeholder="Search teachers..."
                >
            </div>

        </div>
    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th class="ps-4">#</th>
                        <th>Teacher</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>

                <tbody id="TableBody">

                    <tr>
                        <td colspan="6" class="text-center py-5">

                            <div class="empty-state">
                                <i class="bi bi-person-badge"></i>

                                <h6 class="mt-3 mb-1">
                                    No teachers found
                                </h6>

                                <p class="text-muted mb-0">
                                    Add a teacher to begin managing your teaching staff.
                                </p>
                            </div>

                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>

<!-- Add/Edit Teacher Modal -->

<div class="modal fade" id="teacherModal" tabindex="-1" aria-hidden="true">


<div class="modal-dialog modal-lg modal-dialog-centered">

    <div class="modal-content border-0 shadow">

        <div class="modal-header">

            <div>
                <h5 class="modal-title" id="teacherModalTitle">
                    Add Teacher
                </h5>

                <small class="text-muted">
                    Create a teacher account for your institute
                </small>
            </div>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal">
            </button>

        </div>


        <form id="teacherForm">

            <div class="modal-body">

                <input type="hidden" id="editTeacherId">


                <div class="row g-3">

                    <div class="col-md-6">

                        <label for="teacherName" class="form-label">
                            Teacher Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="teacherName"
                            placeholder="Enter teacher name"
                            required
                        >

                    </div>


                    <div class="col-md-6">

                        <label for="teacherEmail" class="form-label">
                            Email Address
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="teacherEmail"
                            placeholder="teacher@example.com"
                            required
                        >

                    </div>


                    <div class="col-md-6" id="passwordField">

                        <label for="teacherPassword" class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="teacherPassword"
                            placeholder="Enter password"
                        >

                    </div>


                    <div class="col-md-6" id="confirmPasswordField">

                        <label for="teacherPasswordConfirmation" class="form-label">
                            Confirm Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="teacherPasswordConfirmation"
                            placeholder="Confirm password"
                        >

                    </div>


                    <div class="col-md-6">

                        <label for="teacherStatus" class="form-label">
                            Status
                        </label>

                        <select class="form-select" id="teacherStatus">

                            <option value="active">
                                Active
                            </option>

                            <option value="inactive">
                                Inactive
                            </option>

                        </select>

                    </div>


                    <div class="col-md-6">

                        <label for="teacherPhone" class="form-label">
                            Phone Number
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="teacherPhone"
                            placeholder="Enter phone number"
                        >

                    </div>

                </div>

            </div>


            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button
                    type="submit"
                    class="btn btn-primary">
                    <i class="bi bi-check-lg me-1"></i>
                    Save Teacher
                </button>

            </div>

        </form>

    </div>

</div>
</div>

<!-- Delete Confirmation Modal -->

<div class="modal fade" id="deleteTeacherModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">

    <div class="modal-content border-0 shadow">

        <div class="modal-body text-center p-4">

            <div class="delete-icon mb-3">
                <i class="bi bi-trash"></i>
            </div>

            <h5>Delete Teacher?</h5>

            <p class="text-muted mb-4">
                Are you sure you want to delete this teacher?
                This action cannot be undone.
            </p>

            <input type="hidden" id="deleteTeacherId">

            <div class="d-flex justify-content-center gap-2">

                <button
                    type="button"
                    class="btn btn-light px-4"
                    data-bs-dismiss="modal">
                    Cancel
                </button>

                <button
                    type="button"
                    class="btn btn-danger px-4"
                    id="confirmDeleteTeacher">
                    Delete
                </button>

            </div>

        </div>

    </div>

</div>

</div>

<style>

    .icon-box {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        background: rgba(132, 204, 22, 0.12);
        color: #65a30d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .search-box {
        width: 260px;
    }

    .search-box .form-control {
        border-left: 0;
    }

    .search-box .input-group-text {
        border-right: 0;
    }

    .table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .table tbody td {
        font-size: 14px;
    }

    .teacher-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #ecfccb;
        color: #4d7c0f;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
    }

    .empty-state {
        color: #64748b;
    }

    .empty-state i {
        font-size: 42px;
        color: #94a3b8;
    }

    .delete-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin: auto;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fee2e2;
        color: #dc2626;
        font-size: 25px;
    }

    .badge-active {
        background: #dcfce7;
        color: #15803d;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .badge-inactive {
        background: #f1f5f9;
        color: #64748b;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    @media (max-width: 768px) {

        .search-box {
            width: 100%;
            margin-top: 15px;
        }

        .card-header .d-flex {
            flex-direction: column;
            align-items: stretch !important;
        }

    }

</style>
@endsection
@push('scripts')
<script>
    function loadTeachers(){
        $.ajax({
            url:'/api/teachers',
            type:'Get',
            headers:{
                'Authorization':'Bearer '+ token,
                'Accept': 'application/json'
            },
            success:function(response){
                const teachers = response.data.data;
                console.log("teacher's response: ",teachers);
                let tableRow = '';
                teachers.forEach((item,index) => {
                      tableRow +=`
                          <tr>

                                <td>${index + 1}</td>

                                <td>
                                    <div class="class-name-cell">

                                        <div class="class-icon">
                                            <i class="bi bi-mortarboard"></i>
                                        </div>

                                        <div>
                                            <strong>${item.name}</strong>
                                     
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <span class="group-badge">
                                        ${item.email}
                                    </span>
                                </td>
                                <td class="text-end">

                                    <div class="action-buttons">

                                         <button
                                            type="button"
                                            class="action-btn edit-btn"
                                            data-id="${item.id}"
                                        >
                                            <i class="bi bi-pencil"></i>
                                            Edit
                                        </button>
                                           <button
                                            type="button"
                                            class="action-btn delete-btn"
                                            data-id="${item.id}"
                                        >
                                            <i class="bi bi-trash"></i>
                                            Delete
                                        </button>
                                      
                                    </div>

                                </td>

                            </tr>
                      `;
                     
                      
                    });
                    $('#TableBody').html(tableRow);

        },
        error: function(xhr) {
            console.log(xhr.responseJSON);
        },

        });
    }
$(document).ready(function(){
    loadTeachers();
});
    </script>
@endpush
