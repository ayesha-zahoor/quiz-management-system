@extends('layouts.teacher')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <a href="/teacher/dashboard" class="text-decoration-none text-secondary small">
                <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
            </a>
            <h2 class="fw-bold mt-2 mb-1">Create New Quiz</h2>
            <p class="text-secondary mb-0">Set up your quiz before adding questions and answer options.</p>
        </div>

        <span class="badge rounded-pill px-3 py-2"
              style="background:#ecfccb;color:#3f6212;">
            <i class="bi bi-file-earmark-plus me-1"></i> New Quiz
        </span>
    </div>

    <div id="message"></div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-lg-5">

                    <div class="mb-4">
                        <h5 class="fw-bold mb-1">Quiz Details</h5>
                        <p class="text-secondary small mb-0">
                            Enter the basic information for your quiz.
                        </p>
                    </div>

                    <form id="quizForm">
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">
                                Quiz Title <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control form-control-lg"
                                   id="title"
                                   name="title"
                                   placeholder="e.g. Mathematics Chapter 1 Quiz"
                                   maxlength="255"
                                   required>
                            <div class="form-text">Use a clear title that describes the quiz.</div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="class_id" class="form-label fw-semibold">
                                    Class <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="class_id" name="class_id" required>
                                    <option value="">Select Class</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="subject_id" class="form-label fw-semibold">
                                    Subject <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="subject_id" name="subject_id" required>
                                    <option value="">Select Subject</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="time_limit_minutes" class="form-label fw-semibold">
                                Time Limit <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       class="form-control"
                                       id="time_limit_minutes"
                                       name="time_limit_minutes"
                                       min="1"
                                       max="600"
                                       placeholder="30"
                                       required>
                                <span class="input-group-text">Minutes</span>
                            </div>
                            <div class="form-text">Enter the time students will have to complete the quiz.</div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="total_marks" class="form-label fw-semibold">
                                    Total Marks <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       class="form-control"
                                       id="total_marks"
                                       name="total_marks"
                                       min="1"
                                       step="0.01"
                                       placeholder="20"
                                       required>
                            </div>

                            <div class="col-md-6">
                                <label for="pass_marks" class="form-label fw-semibold">
                                    Pass Marks <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       class="form-control"
                                       id="pass_marks"
                                       name="pass_marks"
                                       min="0"
                                       step="0.01"
                                       placeholder="10"
                                       required>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 pt-3 border-top">
                            <a href="/teacher/dashboard"
                               class="btn btn-light border px-4 py-2">
                                Cancel
                            </a>

                            <button type="submit"
                                    class="btn px-4 py-2 fw-semibold text-dark"
                                    id="saveQuizBtn"
                                    style="background:#a3e635;">
                                <i class="bi bi-check2-circle me-1"></i>
                                Save Quiz
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <div class="rounded-3 d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:48px;height:48px;background:#ecfccb;color:#4d7c0f;">
                        <i class="bi bi-list-check fs-4"></i>
                    </div>

                    <h5 class="fw-bold">What's Next?</h5>
                    <p class="text-secondary small">
                        After saving your quiz, add questions and their answer options.
                    </p>

                    <div class="d-flex gap-3 mb-3">
                        <span class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                              style="width:30px;height:30px;background:#ecfccb;color:#3f6212;">1</span>
                        <div>
                            <div class="fw-semibold">Create Quiz</div>
                            <div class="small text-secondary">Enter the quiz details.</div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-3">
                        <span class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                              style="width:30px;height:30px;background:#f3f4f6;color:#4b5563;">2</span>
                        <div>
                            <div class="fw-semibold">Add Questions</div>
                            <div class="small text-secondary">Write questions and assign marks.</div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <span class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                              style="width:30px;height:30px;background:#f3f4f6;color:#4b5563;">3</span>
                        <div>
                            <div class="fw-semibold">Add Options & Publish</div>
                            <div class="small text-secondary">Set correct answers and publish when ready.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 rounded-4"
                 style="background:#f7fee7;">
                <div class="card-body p-4">
                    <i class="bi bi-lightbulb fs-4 mb-2 d-block" style="color:#65a30d;"></i>
                    <h6 class="fw-bold">Before You Save</h6>
                    <p class="small text-secondary mb-0">
                        Make sure the selected class and subject are assigned to you.
                        The total marks should match the marks assigned to your questions
                        when you finish preparing the quiz.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-control,
    .form-select {
        border-color: #e5e7eb;
        border-radius: 10px;
        padding: 12px 14px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #84cc16;
        box-shadow: 0 0 0 0.2rem rgba(132, 204, 22, 0.15);
    }

    .btn {
        border-radius: 10px;
    }

    .card {
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    const token = window.token;

    function showMessage(message, type) {
        $('#message').html(
            $('<div>')
                .addClass('alert alert-' + type + ' alert-dismissible fade show')
                .attr('role', 'alert')
                .text(message)
                .append(
                    $('<button>')
                        .attr({
                            type: 'button',
                            'data-bs-dismiss': 'alert',
                            'aria-label': 'Close'
                        })
                        .addClass('btn-close')
                )
        );
    }

    function loadClasses() {
        $.ajax({
            url: '/api/teacher/classes',
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function (res) {
                console.log(res);
                const classes = res.data || [];

                $('#class_id').empty().append(
                    $('<option>').val('').text('Select Class')
                );

                classes.forEach(function (item) {
                    $('#class_id').append(
                        $('<option>').val(item.id).text(item.class_name)
                    );
                });
            },
            error: function () {
                showMessage('Could not load your assigned classes.', 'danger');
            }
        });
    }

    function loadSubjects(classId) {
        $('#subject_id').empty().append(
            $('<option>').val('').text('Select Subject')
        );

        if (!classId) {
            return;
        }

        $.ajax({
            url: '/api/teacher/classes/' + classId + '/subjects',
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            success: function (res) {
                const subjects = res.data || [];

                subjects.forEach(function (item) {
                    $('#subject_id').append(
                        $('<option>').val(item.id).text(item.name || item.subject_name)
                    );
                });
            },
            error: function () {
                showMessage('Could not load subjects for this class.', 'danger');
            }
        });
    }

    $('#class_id').on('change', function () {
        loadSubjects($(this).val());
    });

    $('#quizForm').on('submit', function (event) {
        event.preventDefault();

        const totalMarks = Number($('#total_marks').val());
        const passMarks = Number($('#pass_marks').val());

        if (passMarks > totalMarks) {
            showMessage('Pass marks cannot be greater than total marks.', 'warning');
            return;
        }

        const body = {
            title: $('#title').val().trim(),
            class_id: Number($('#class_id').val()),
            subject_id: Number($('#subject_id').val()),
            time_limit_minutes: Number($('#time_limit_minutes').val()),
            total_marks: totalMarks,
            pass_marks: passMarks
        };

        const button = $('#saveQuizBtn');

        button.prop('disabled', true).text('Saving...');

        $.ajax({
            url: '/api/teacher/quizzes',
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            },
            contentType: 'application/json',
            data: JSON.stringify(body),

            success: function (res) {
                const quiz = res.data && res.data.quiz
                    ? res.data.quiz
                    : res.data || res.quiz;

                if (!quiz || !quiz.id) {
                    showMessage('Quiz was saved, but its ID was not returned by the API.', 'warning');
                    return;
                }

                window.location.href = '/teacher/quizzes/' + quiz.id + '/questions';
            },

            error: function (xhr) {
                const response = xhr.responseJSON || {};
                let message = response.message || 'Could not save the quiz.';

                if (response.errors) {
                    message = Object.values(response.errors).flat().join(' ');
                }

                showMessage(message, 'danger');
            },

            complete: function () {
                button.prop('disabled', false).html(
                    '<i class="bi bi-check2-circle me-1"></i> Save Quiz'
                );
            }
        });
    });

    loadClasses();
});
</script>
@endpush