@extends('layouts.teacher')

@section('title', 'Create Quiz')
@section('page-title', 'Create Quiz')
@section('page-description', 'Set up a new quiz for your class')

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

        <span class="badge rounded-pill px-3 py-2" style="background:#ecfccb;color:#3f6212;">
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
                        <p class="text-secondary small mb-0">Enter the basic information for your quiz.</p>
                    </div>

                    <form id="quizForm">

                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">Quiz Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg" id="title" name="title"
                                   placeholder="e.g. Mathematics Chapter 1 Quiz" maxlength="255" required>
                            <div class="form-text">Use a clear title that describes the quiz.</div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="class_id" class="form-label fw-semibold">Class <span class="text-danger">*</span></label>
                                <select class="form-select" id="class_id" name="class_id" required>
                                    <option value="">Loading classes...</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="subject_id" class="form-label fw-semibold">Subject <span class="text-danger">*</span></label>
                                <select class="form-select" id="subject_id" name="subject_id" required>
                                    <option value="">Select a class first</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="time_limit_minutes" class="form-label fw-semibold">Time Limit <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="time_limit_minutes" name="time_limit_minutes"
                                       min="1" max="600" placeholder="30" required>
                                <span class="input-group-text">Minutes</span>
                            </div>
                            <div class="form-text">Enter the time students will have to complete the quiz.</div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="total_marks" class="form-label fw-semibold">Total Marks <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="total_marks" name="total_marks"
                                       min="1" step="0.01" placeholder="20" required>
                            </div>

                            <div class="col-md-6">
                                <label for="pass_marks" class="form-label fw-semibold">Pass Marks <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="pass_marks" name="pass_marks"
                                       min="0" step="0.01" placeholder="10" required>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap justify-content-end gap-2 pt-3 border-top">
                            <a href="/teacher/dashboard" class="btn btn-light border px-4 py-2">Cancel</a>

                            <button type="submit" class="btn px-4 py-2 fw-semibold text-dark" id="saveQuizBtn" style="background:#a3e635;">
                                <i class="bi bi-check2-circle me-1"></i> Save Quiz
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
                    <p class="text-secondary small">After saving your quiz, add questions and their answer options.</p>

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

            <div class="card border-0 rounded-4" style="background:#f7fee7;">
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
    .form-select { border-color: #e5e7eb; border-radius: 10px; padding: 12px 14px; }

    .form-control:focus,
    .form-select:focus { border-color: #84cc16; box-shadow: 0 0 0 0.2rem rgba(132, 204, 22, 0.15); }

    .btn { border-radius: 10px; }
    .card { overflow: hidden; }
</style>
@endpush

@push('scripts')
<script>
$(function () {

    const token = window.token;

    /*
     * STEP 2: one place to keep everything we learn about the teacher's classes.
     * Shape:  { 5: { id: 5, name: 'Class 5', subjects: { 12: 'Maths', 14: 'Science' } } }
     * It is an object keyed by the class id, so a class never appears twice
     * and we always keep the id (the quiz needs the id, not the name).
     */
    const classes = {};

    // Subjects the teacher is assigned to (only used as a backup, see Step 6)
    let assignedSubjects = [];


    function showMessage(message, type) {
        $('#message').html(
            $('<div>')
                .addClass('alert alert-' + type + ' alert-dismissible fade show')
                .attr('role', 'alert')
                .text(message)
                .append($('<button>').attr({ type: 'button', 'data-bs-dismiss': 'alert', 'aria-label': 'Close' }).addClass('btn-close'))
        );

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function headers() {
        return { 'Authorization': 'Bearer ' + token, 'Accept': 'application/json' };
    }


    /* ------------------------------------------------------------------
       Small helpers that fill the "classes" object
    ------------------------------------------------------------------ */

    function addClass(id, name) {
        if (!id) return;

        if (!classes[id]) {
            classes[id] = { id: id, name: name || 'Class ' + id, subjects: {} };
        }
    }

    function addSubject(classId, subjectId, subjectName) {
        if (!classes[classId] || !subjectId) return;

        classes[classId].subjects[subjectId] = subjectName || 'Subject ' + subjectId;
    }


    /* ------------------------------------------------------------------
       STEP 3: read the quizzes API. Every quiz knows its class and subject,
       so together they tell us which class + subject pairs the teacher uses.
    ------------------------------------------------------------------ */

    function readQuizzes(response) {
        // The list may come as [..] or { data: [..] } (a paginator)
        const list = Array.isArray(response.data) ? response.data : (response.data && response.data.data) || [];

        console.log('First quiz from the API (check the field names here):', list[0]);

        list.forEach(function (quiz) {
            const className = quiz.academic_class ? quiz.academic_class.class_name : null;
            const subject = quiz.subject || {};

            addClass(quiz.class_id, className);
            addSubject(quiz.class_id, quiz.subject_id, subject.subject_name || subject.name);
        });
    }


    /* ------------------------------------------------------------------
       STEP 4 and 5: fill the dropdowns (always AFTER the data has arrived)
    ------------------------------------------------------------------ */

    function fillClasses() {
        const chosen = $('#class_id').val();                 // keep the choice if we refill
        const all = Object.values(classes);
        const $select = $('#class_id').empty();

        if (!all.length) {
            $select.append($('<option>').val('').text('No classes found'));
            return;
        }

        $select.append($('<option>').val('').text('Select Class'));

        all.forEach(function (item) {
            $select.append($('<option>').val(item.id).text(item.name));
        });

        if (chosen) $select.val(chosen);
    }

    function fillSubjects(classId) {
        const $select = $('#subject_id').empty().append($('<option>').val('').text('Select Subject'));

        if (!classId || !classes[classId]) return;

        // Subjects we have seen in this class's quizzes
        let subjects = Object.entries(classes[classId].subjects).map(function (pair) {
            return { id: pair[0], name: pair[1] };
        });

        // STEP 6 backup: a class with no quizzes yet uses the subjects assigned to the teacher
        if (!subjects.length) {
            subjects = assignedSubjects.map(function (item) {
                return { id: item.id, name: item.subject_name || item.name };
            });
        }

        if (!subjects.length) {
            $select.empty().append($('<option>').val('').text('No subjects found for this class'));
            return;
        }

        subjects.forEach(function (item) {
            $select.append($('<option>').val(item.id).text(item.name));
        });
    }

    $('#class_id').on('change', function () {
        fillSubjects($(this).val());
    });


    /* ------------------------------------------------------------------
       Load the data
    ------------------------------------------------------------------ */

    // The quizzes the teacher already made
    $.ajax({ url: '/api/teacher/quizzes', method: 'GET', headers: headers() })
        .done(readQuizzes)
        .fail(function () { showMessage('Could not load your quizzes to find your classes.', 'warning'); })
        .always(fillClasses);

    // STEP 6: the classes assigned to the teacher. This is what lets a teacher with no quizzes yet
    // create the first one. The layout already made this request, so there is no extra call.
    window.teacherDashboard
        .done(function (response) {
            const data = (response && response.data) || {};

            (data.classes || []).forEach(function (item) {
                addClass(item.id, item.class_name);
            });

            assignedSubjects = data.subjects || [];
        })
        .always(fillClasses);


    /* ------------------------------------------------------------------
       STEP 7: send the quiz to the API
    ------------------------------------------------------------------ */

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
            pass_marks: passMarks,
            is_published: 0              // always a draft: questions can only be added before publishing
        };

        const button = $('#saveQuizBtn');
        const buttonHtml = button.html();

        button.prop('disabled', true).text('Saving...');

        $.ajax({
            url: '/api/teacher/quizzes',
            method: 'POST',
            headers: headers(),
            contentType: 'application/json',
            data: JSON.stringify(body),

            success: function (response) {
                const quiz = (response.data && response.data.quiz) || response.data || response.quiz || {};

                if (quiz.id) {
                    // Go straight to adding questions
                    window.location.href = '/teacher/' + quiz.id + '/questions';
                    return;
                }

                showMessage('Quiz saved.', 'success');
                setTimeout(function () { window.location.href = '/teacher/quizzes'; }, 1200);
            },

            error: function (xhr) {
                const response = xhr.responseJSON || {};
                let message = response.message || 'Could not save the quiz.';

                if (response.errors) {
                    message = Object.values(response.errors).flat().join(' ');
                }

                showMessage(message, 'danger');
                button.prop('disabled', false).html(buttonHtml);
            }
        });
    });

});
</script>
@endpush