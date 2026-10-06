@extends('layouts.institute')

@section('title', 'Class Management')

@section('user-role', 'Institute Admin')

@section('page-title', 'Class Management')

@section('page-description', 'Manage classes and academic groups')

@section('sidebar')

    <a href="/instituteAdmin/dashboard" class="nav-link">
        <i class="bi bi-speedometer2"></i>
        <span>Dashboard</span>
    </a>

    <a href="/instituteAdmin/classes" class="nav-link active">
        <i class="bi bi-mortarboard-fill"></i>
        <span>Classes</span>
    </a>

    <a href="#" class="nav-link">
        <i class="bi bi-book"></i>
        <span>Subjects</span>
    </a>

    <a href="#" class="nav-link">
        <i class="bi bi-person-badge"></i>
        <span>Teachers</span>
    </a>

    <a href="#" class="nav-link">
        <i class="bi bi-people-fill"></i>
        <span>Students</span>
    </a>

@endsection

@section('content')

<div class="class-management">

    <div class="section-header">
        <div>
            <h2>Classes</h2>
            <p>Create and manage classes for your institute.</p>
        </div>

        {{-- <button
            type="button"
            class="btn-lime"
            id="addClassBtn"
        >
            <i class="bi bi-plus-lg me-1"></i>
            Add Class
        </button> --}}
    </div>


    <div class="row g-4">

        <!-- Add / Edit Class -->

        <div class="col-lg-12">
            <div class="content-card">

                <div class="class-list-header">

                    <div>
                        <h3>Institute Classes</h3>

                        <p>
                            All classes registered in your institute.
                        </p>
                    </div>

                    <div class="class-count">
                        <span id="classCount"></span>
                        Classes
                    </div>

                </div>


                <div class="table-responsive">

                    <table class="table class-table">

                        <thead>

                            <tr>
                                <th>#</th>
                                <th>Class Name</th>
                                <th>Group</th>
                                <th>Order</th>
                                <th class="text-end">Actions</th>
                            </tr>

                        </thead>

                        <tbody id="classesTableBody">

                            

                        </tbody>

                    </table>

                </div>


                <div
                    class="empty-state"
                    id="emptyState"
                    style="display: none;"
                >

                    <div class="empty-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>

                    <h4>No Classes Found</h4>

                    <p>
                        Add your first class to start managing your institute.
                    </p>

                    <button
                        type="button"
                        class="btn-lime"
                    >
                        <i class="bi bi-plus-lg me-1"></i>
                        Update Class
                    </button>

                </div>

            </div>

        </div>


        <!-- Classes List -->

        <div class="col-lg-6 mx-auto">
            
            <div class="content-card class-form-card">

                <div class="class-card-header">

                    <div>
                        <h3 id="formTitle">Update Class</h3>

                        <p id="formDescription">
                            Enter the class details below.
                        </p>
                    </div>

                    <div class="class-header-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>

                </div>


                <form id="classForm">
                    <input type="hidden" id="editId">
                    <div class="mb-3">

                        <label
                            for="className"
                            class="form-label"
                        >
                            Class Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="className"
                            name="class_name"
                            placeholder="e.g. Class 5"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label
                            for="classGroup"
                            class="form-label"
                        >
                            Group
                        </label>

                        <select
                            class="form-select"
                            id="classGroup"
                            name="group"
                            required
                        >   
                        </select>

                    </div>


                    <div class="mb-4">

                        <label
                            for="sortOrder"
                            class="form-label"
                        >
                            Sort Order
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            id="sortOrder"
                            name="sort_order"
                            min="0"
                            placeholder="e.g. 1"
                            required
                        >

                        <div class="form-help">
                            Determines the display order of classes.
                        </div>

                    </div>
                    <div class="class-form-actions">

                        <button
                            type="submit"
                            class="btn-lime"
                            id="saveClassBtn"
                        >
                            <i class="bi bi-check-lg me-1"></i>
                            Update Class
                        </button>

                        <button
                            type="button"
                            class="btn-cancel"
                            id="cancelEditBtn"
                            style="display: none;"
                        >
                            Cancel
                        </button>

                    </div>

                </form>

            </div>

           

        </div>

    </div>

</div>
{{-- result model
 --}}

 <!-- Update Result Modal -->
<div class="result-modal-overlay" id="resultModal">

    <div class="result-modal">

        <button type="button" class="result-modal-close" id="closeResultModal">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="result-modal-icon" id="resultModalIcon">
            <i class="bi bi-check-lg"></i>
        </div>

        <h3 id="resultModalTitle">Class Updated</h3>

        <p id="resultModalMessage">
            The class has been updated successfully.
        </p>

        <button type="button" class="btn-lime result-modal-btn" id="resultModalOk">
            OK
        </button>

    </div>

</div>
@endsection


@push('styles')

<style>
    .result-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.45);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
}

.result-modal-overlay.show {
    display: flex;
}

.result-modal {
    position: relative;
    width: 100%;
    max-width: 390px;
    background: var(--white);
    border-radius: 14px;
    padding: 32px 28px;
    text-align: center;
    box-shadow: 0 20px 50px rgba(15, 23, 42, 0.18);
    animation: resultModalShow 0.2s ease;
}

.result-modal-close {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 30px;
    height: 30px;
    border: 0;
    background: transparent;
    color: var(--slate);
    font-size: 13px;
    border-radius: 50%;
    cursor: pointer;
}

.result-modal-close:hover {
    background: var(--off-white);
    color: var(--text-color);
}

.result-modal-icon {
    width: 58px;
    height: 58px;
    margin: 0 auto 17px;
    border-radius: 50%;
    background: var(--primary-light);
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
}

.result-modal h3 {
    margin: 0 0 8px;
    color: var(--text-color);
    font-size: 19px;
    font-weight: 700;
}

.result-modal p {
    margin: 0 auto 22px;
    max-width: 290px;
    color: var(--slate);
    font-size: 13px;
    line-height: 1.6;
}

.result-modal-btn {
    min-width: 90px;
}

.result-modal.error .result-modal-icon {
    background: rgba(220, 38, 38, 0.1);
    color: var(--danger);
}

.result-modal.error .result-modal-btn {
    background: var(--danger);
    border-color: var(--danger);
}

@keyframes resultModalShow {
    from {
        opacity: 0;
        transform: scale(0.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}
    .class-management {
        width: 100%;
    }

    .class-form-card {
        height: 100%;
    }

    .class-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 25px;
    }

    .class-card-header h3,
    .class-list-header h3 {
        margin: 0;
        color: var(--text-color);
        font-size: 17px;
        font-weight: 700;
    }

    .class-card-header p,
    .class-list-header p {
        margin: 5px 0 0;
        color: var(--slate);
        font-size: 12px;
    }

    .class-header-icon {
        width: 42px;
        height: 42px;
        border-radius: 9px;
        background: var(--primary-light);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .form-help {
        margin-top: 6px;
        color: var(--slate);
        font-size: 11px;
    }

    .class-form-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-cancel {
        border: 1px solid var(--slate-light);
        background: var(--white);
        color: var(--slate);
        padding: 9px 16px;
        border-radius: 7px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-cancel:hover {
        border-color: var(--secondary-color);
        color: var(--secondary-color);
    }

    .class-list-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 20px;
    }

    .class-count {
        background: var(--primary-light);
        color: var(--primary-color);
        border-radius: 20px;
        padding: 7px 12px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .class-table {
        margin-bottom: 0;
        vertical-align: middle;
    }

    .class-table thead th {
        padding: 12px 10px;
        background: var(--off-white);
        color: var(--slate);
        border-bottom: 1px solid var(--slate-light);
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        white-space: nowrap;
    }

    .class-table tbody td {
        padding: 15px 10px;
        border-bottom: 1px solid var(--slate-light);
        color: var(--text-color);
        font-size: 13px;
    }

    .class-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .class-table tbody tr:hover {
        background: var(--primary-light);
    }

    .class-name-cell {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .class-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: var(--primary-light);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .class-name-cell strong {
        display: block;
        color: var(--text-color);
        font-size: 13px;
        font-weight: 700;
    }

    .class-name-cell span {
        display: block;
        margin-top: 2px;
        color: var(--slate);
        font-size: 10px;
    }

    .group-badge {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        background: var(--secondary-color);
        color: var(--white);
        font-size: 10px;
        font-weight: 700;
        text-transform: capitalize;
    }

    .sort-number {
        color: var(--text-color);
        font-weight: 700;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 7px;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 6px;
        padding: 7px 10px;
        font-size: 11px;
        font-weight: 700;
        transition: 0.2s;
    }

    .edit-btn {
        border: 1px solid var(--primary-color);
        background: var(--primary-light);
        color: var(--primary-dark);
    }

    .edit-btn:hover {
        background: var(--primary-color);
        color: var(--white);
    }

    .delete-btn {
        border: 1px solid rgba(220, 38, 38, 0.2);
        background: rgba(220, 38, 38, 0.08);
        color: var(--danger);
    }

    .delete-btn:hover {
        background: var(--danger);
        color: var(--white);
    }

    .empty-state {
        text-align: center;
        padding: 55px 20px;
    }

    .empty-icon {
        width: 58px;
        height: 58px;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: var(--primary-light);
        color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .empty-state h4 {
        margin: 0;
        color: var(--text-color);
        font-size: 16px;
        font-weight: 700;
    }

    .empty-state p {
        margin: 6px 0 18px;
        color: var(--slate);
        font-size: 12px;
    }

    @media (max-width: 991.98px) {

        .class-list-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .class-table {
            min-width: 700px;
        }

    }

    @media (max-width: 575.98px) {

        .class-card-header {
            margin-bottom: 20px;
        }

        .class-form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .class-form-actions .btn-lime,
        .class-form-actions .btn-cancel {
            width: 100%;
        }

    }

</style>

@endpush
@push('scripts')
<script>
    function loadClasses() {
    $.ajax({
        url: '/api/classes',
        type: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        },
        success: function(response) {
            const classes = response;
            console.log(classes);
            let tableRow ='';
            let group = [];
                classes.forEach(item => {
                   group.push(item.group);
});
            var uniqGroup = [...new Set(group)];
               console.log("groups :" , uniqGroup);
               let groupOptions  = '<option value = "" >Select Group</option>';
               uniqGroup.forEach(item =>{
                    groupOptions += `
                    <option value"${item}">${item}</option>
                    
                    `;
               });
               $('#classGroup').html(groupOptions);
            classes.forEach((item,index) => {
                      tableRow +=`
                          <tr>

                                <td>${index + 1}</td>

                                <td>
                                    <div class="class-name-cell">

                                        <div class="class-icon">
                                            <i class="bi bi-mortarboard"></i>
                                        </div>

                                        <div>
                                            <strong>${item.class_name}</strong>
                                            <span>${item.group}</span>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <span class="group-badge">
                                        ${item.group}
                                    </span>
                                </td>

                                <td>
                                    <span class="sort-number">
                                        ${item.sort_order}
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
                                      
                                    </div>

                                </td>

                            </tr>
                      `;
                     
                      
                    });
                    $('#classesTableBody').html(tableRow);

        },
        error: function(xhr) {
            console.log(xhr.responseJSON);
        }

    });
}

//add form


    $(document).on('click','.edit-btn', function(){
        const id = $(this).data('id');
        console.log('editId: ',id);
          $('#editId').val(id);
        //   const edit = $("#editId").val();
        //  console.log("storeditId: ",edit);
            $.ajax({
             url: '/api/classes',
        type: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        },
        success:function(response){

            const givenClassess = response;
            let selectedClass = '';
            givenClassess.forEach(item =>{
                 selectedClass = givenClassess.find(item => item.id === id);
            })
        console.log("selectedClass: ",selectedClass);
        $('#className').val(selectedClass.class_name);
        $('#classGroup').val(selectedClass.group);
        $('#sortOrder').val(selectedClass.sort_order);
        }
         });

    });


    $('#classForm').on('submit',function(e){
            e.preventDefault();
           const classId = document.getElementById('editId').value;
           const formData = new FormData(this);
           formData.append('_method', 'PUT');

   $.ajax({
             url: '/api/classes/' + classId,
        type: 'POST',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        },
        data:formData,
        processData: false,
contentType: false,
        success:function(response){
           console.log('updated successfully');
            showResultModal(
            'success',
            'Class Updated',
            'The class has been updated successfully.'
        );

        },
         error: function(xhr) {

        console.log('update failed');
        console.log(xhr.responseJSON);

        showResultModal(
            'error',
            'Update Failed',
            'The class could not be updated. Please try again.'
        );
    }
         });
    
    });
    function showResultModal(type, title, message) {

    const modal = $('#resultModal');
    const icon = $('#resultModalIcon');
    const modalTitle = $('#resultModalTitle');
    const modalMessage = $('#resultModalMessage');

    modal.removeClass('error');

    if (type === 'success') {
        icon.html('<i class="bi bi-check-lg"></i>');
    } else {
        modal.addClass('error');
        icon.html('<i class="bi bi-x-lg"></i>');
    }

    modalTitle.text(title);
    modalMessage.text(message);

    modal.addClass('show');
}
$('#resultModalOk, #closeResultModal').on('click', function() {
    $('#resultModal').removeClass('show');
});

// delete 
  //      <button
                                        //     type="button"
                                        //     class="action-btn delete-btn"
                                        //     data-id="${item.id}"
                                        // >
                                        //     <i class="bi bi-trash"></i>
                                        //     Delete
                                        // </button>
 $(document).on('click','.delete-btn', function(){
        const id = $(this).data('id');
            $.ajax({
             url: '/api/classes',
        type: 'Delete',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Accept': 'application/json'
        },
        success:function(response){

             showResultModal(
            'success',
            'Class Deleted',
            'The class has been Deleted successfully.'
        );

        },
         error: function(xhr) {

        console.log(xhr.responseJSON);

        showResultModal(
            'error',
            'Delete Failed',
            'The class could not be deleted. Please try again.'
        );
    }
         });

    });
$(document).ready(function() {
    loadClasses();

});
</script>
    
@endpush