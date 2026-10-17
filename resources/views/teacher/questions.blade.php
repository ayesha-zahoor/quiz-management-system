@extends('layouts.teacher')

@section('title', 'Quiz Questions')
@section('page-title', 'Quiz Questions')
@section('page-description', 'Add questions and answer options to your quiz')

@section('content')

<div class="qz">

    <a href="/teacher/dashboard" class="back-link"><i class="bi bi-arrow-left"></i> Back to My Quizzes</a>

    <div id="message"></div>

    {{-- ================= Quiz header ================= --}}
    <section class="glass quiz-head">

        <div class="quiz-head-main">
            <div class="quiz-head-icon"><i class="bi bi-patch-question"></i></div>

            <div>
                <h4 id="quizTitle">Loading quiz...</h4>
                <div class="quiz-head-meta">
                    <span id="quizStatus" class="pill draft">Draft</span>
                    <span id="quizMarks"></span>
                </div>
                <div id="marksWarning" class="marks-warning" hidden></div>
            </div>
        </div>

        <div class="quiz-head-actions">
            <button type="button" class="btn btn-primary" id="addQuestionBtn" onclick="openQuestionForm()">
                <i class="bi bi-plus-lg me-1"></i> Add Question
            </button>

            <button type="button" class="btn btn-dark" id="publishBtn" onclick="openPublishModal()">
                <i class="bi bi-send-check me-1"></i> Publish Quiz
            </button>
        </div>

    </section>

    <div id="lockedNote" class="locked-note" hidden>
        <i class="bi bi-lock-fill"></i>
        This quiz is published, so its questions can no longer be changed.
    </div>

    {{-- ================= Questions ================= --}}
    <div id="questionList">
        <div class="skeleton"></div>
        <div class="skeleton"></div>
    </div>

</div>


{{-- ================= Add / edit question ================= --}}
<div class="modal fade" id="questionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form class="modal-content border-0 shadow" onsubmit="saveQuestion(event)">

            <div class="modal-header">
                <h5 class="modal-title" id="questionModalTitle">Add Question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="questionId">

                <div class="mb-3">
                    <label for="questionText" class="form-label fw-semibold">Question</label>
                    <textarea id="questionText" class="form-control" rows="3" placeholder="e.g. What is 2 + 2?" required></textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="questionMarks" class="form-label fw-semibold">Marks</label>
                        <input type="number" id="questionMarks" class="form-control" min="1" value="1" required>
                    </div>
                </div>

                <div class="row g-3 mt-0">
                    {{-- Picture --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Picture <small class="text-secondary fw-normal">(optional)</small></label>

                        <div class="upload">
                            <img id="questionImagePreview" class="upload-img" alt="Picture preview" hidden>

                            <div class="upload-row">
                                <label for="questionImage" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-upload me-1"></i><span id="questionImageLabel">Choose picture</span>
                                </label>
                                <button type="button" class="btn btn-sm btn-link text-danger" id="questionImageRemove" hidden>Remove</button>
                            </div>

                            <input type="file" class="visually-hidden" id="questionImage" accept="image/png,image/jpeg,image/webp">
                            <div class="upload-help">JPG, PNG or WebP, up to 2 MB.</div>
                        </div>
                    </div>

                    {{-- Audio --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Read-aloud audio <small class="text-secondary fw-normal">(optional)</small></label>

                        <div class="upload">
                            <audio id="questionAudioPreview" controls hidden></audio>

                            <div class="upload-row">
                                <label for="questionAudio" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-upload me-1"></i><span id="questionAudioLabel">Choose audio</span>
                                </label>
                                <button type="button" class="btn btn-sm btn-link text-danger" id="questionAudioRemove" hidden>Remove</button>
                            </div>

                            <input type="file" class="visually-hidden" id="questionAudio" accept="audio/*">
                            <div class="upload-help">MP3, WAV, OGG or M4A, up to 5 MB. Students hear this when they press Listen. Record the question in Urdu here if you want it read in Urdu.</div>
                        </div>
                    </div>
                </div>

                <div id="questionError" class="form-error"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="questionSaveBtn">Save Question</button>
            </div>

        </form>
    </div>
</div>


{{-- ================= Add / edit option ================= --}}
<div class="modal fade" id="optionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content border-0 shadow" onsubmit="saveOption(event)">

            <div class="modal-header">
                <h5 class="modal-title" id="optionModalTitle">Add Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="optionId">
                <input type="hidden" id="optionQuestionId">

                <div class="mb-3">
                    <label for="optionText" class="form-label fw-semibold">Answer option</label>
                    <input type="text" id="optionText" class="form-control" placeholder="e.g. 4" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Picture <small class="text-secondary fw-normal">(optional)</small></label>

                    <div class="upload">
                        <img id="optionImagePreview" class="upload-img" alt="Picture preview" hidden>

                        <div class="upload-row">
                            <label for="optionImage" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-upload me-1"></i><span id="optionImageLabel">Choose picture</span>
                            </label>
                            <button type="button" class="btn btn-sm btn-link text-danger" id="optionImageRemove" hidden>Remove</button>
                        </div>

                        <input type="file" class="visually-hidden" id="optionImage" accept="image/png,image/jpeg,image/webp">
                        <div class="upload-help">JPG, PNG or WebP, up to 2 MB.</div>
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" id="optionCorrect" class="form-check-input">
                    <label for="optionCorrect" class="form-check-label fw-semibold">This is the correct answer</label>
                </div>

                <div id="optionError" class="form-error"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" id="optionSaveBtn">Save Option</button>
            </div>

        </form>
    </div>
</div>


{{-- ================= Delete confirmation ================= --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="confirm-icon danger"><i class="bi bi-trash"></i></div>
                <h5>Delete <span id="deleteKind">question</span>?</h5>
                <p class="text-secondary mb-4"><strong id="deleteLabel"></strong> will be removed permanently, together with its picture and audio.</p>

                <div id="deleteError" class="form-error mb-3"></div>

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger px-4" id="deleteConfirmBtn" onclick="confirmDelete()">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- ================= Publish confirmation ================= --}}
<div class="modal fade" id="publishModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center p-4">
                <div class="confirm-icon"><i class="bi bi-send-check"></i></div>
                <h5>Publish this quiz?</h5>
                <p class="text-secondary mb-4">
                    Students will be able to attempt it, and you will not be able to change its questions afterwards.
                </p>

                <div id="publishError" class="form-error mb-3"></div>

                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Not yet</button>
                    <button type="button" class="btn btn-primary px-4" id="publishConfirmBtn" onclick="publishQuiz()">Publish</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@push('styles')
<style>

    .glass {
        background: rgba(255, 255, 255, 0.6);
        -webkit-backdrop-filter: blur(16px) saturate(170%);
        backdrop-filter: blur(16px) saturate(170%);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 20px;
        box-shadow: 0 14px 34px -14px color-mix(in srgb, var(--secondary-color) 40%, transparent), inset 0 1px 0 rgba(255, 255, 255, 0.95);
    }

    .back-link { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 16px; color: var(--slate); font-size: 14px; font-weight: 600; }
    .back-link:hover { color: var(--text-color); }

    /* ---------- Quiz header ---------- */
    .quiz-head { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 18px; padding: 22px 24px; margin-bottom: 20px; }
    .quiz-head-main { display: flex; align-items: center; gap: 16px; min-width: 0; }

    .quiz-head-icon {
        width: 56px;
        height: 56px;
        flex: 0 0 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        color: var(--on-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }

    .quiz-head h4 { margin: 0 0 6px; font-size: 21px; font-weight: 800; overflow-wrap: anywhere; }
    .quiz-head-meta { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; color: var(--slate); font-size: 14px; }
    .quiz-head-actions { display: flex; flex-wrap: wrap; gap: 10px; }

    .marks-warning { margin-top: 6px; color: #92400e; font-size: 13px; }

    .pill { padding: 4px 11px; border-radius: 999px; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .pill.published { background: #dcfce7; color: #166534; }
    .pill.draft { background: #fef3c7; color: #92400e; }

    .locked-note { display: flex; align-items: center; gap: 10px; padding: 12px 16px; margin-bottom: 20px; border-radius: 14px; background: #fef3c7; color: #92400e; font-size: 14px; font-weight: 600; }

    /* ---------- Question cards ---------- */
    .question { padding: 22px 24px; margin-bottom: 18px; }

    .question-top { display: flex; align-items: flex-start; gap: 14px; }

    .q-number {
        width: 38px;
        height: 38px;
        flex: 0 0 38px;
        border-radius: 12px;
        background: var(--primary-color);
        color: var(--on-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
    }

    .q-body { flex: 1; min-width: 0; }
    .q-text { margin: 0 0 8px; font-size: 17px; font-weight: 700; line-height: 1.45; overflow-wrap: anywhere; }

    .q-chip { display: inline-flex; align-items: center; gap: 6px; padding: 3px 10px; border-radius: 999px; background: var(--primary-light); color: var(--primary-dark); font-size: 12px; font-weight: 700; }

    .q-media { margin-top: 12px; }
    .q-media img { max-width: 100%; max-height: 160px; border-radius: 12px; border: 1px solid rgba(15, 23, 42, 0.08); }
    .q-media audio { display: block; width: 100%; max-width: 380px; margin-top: 8px; }

    .q-actions { display: flex; gap: 8px; }

    .icon-btn {
        width: 36px;
        height: 36px;
        border: 0;
        border-radius: 10px;
        background: rgba(15, 23, 42, 0.06);
        color: var(--slate);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .icon-btn:hover { background: var(--primary-light); color: var(--primary-dark); }
    .icon-btn.danger:hover { background: #fee2e2; color: #dc2626; }
    .icon-btn.small { width: 30px; height: 30px; border-radius: 8px; font-size: 13px; }

    /* ---------- Options ---------- */
    .options { margin-top: 16px; padding-top: 16px; border-top: 1px solid rgba(15, 23, 42, 0.07); }

    .option {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        margin-bottom: 8px;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid rgba(15, 23, 42, 0.07);
    }
    .option > i { font-size: 18px; color: var(--slate); }
    .option.correct { background: #f0fdf4; border-color: #86efac; }
    .option.correct > i { color: #16a34a; }
    .option-text { flex: 1; min-width: 0; overflow-wrap: anywhere; font-size: 15px; }
    .option-badge { padding: 2px 9px; border-radius: 999px; background: #dcfce7; color: #166534; font-size: 11px; font-weight: 700; }
    .option-img { height: 44px; width: 44px; object-fit: cover; border-radius: 8px; }

    .option-hint { color: var(--slate); font-size: 13px; padding: 4px 0 10px; }

    /* ---------- Upload boxes ---------- */
    .upload { padding: 12px; border: 1px dashed rgba(15, 23, 42, 0.2); border-radius: 14px; background: rgba(255, 255, 255, 0.6); }
    .upload-img { display: block; max-width: 100%; max-height: 150px; margin-bottom: 10px; border-radius: 10px; border: 1px solid rgba(15, 23, 42, 0.08); }
    .upload audio { display: block; width: 100%; margin-bottom: 10px; }
    .upload-row { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; }
    .upload-help { margin-top: 8px; color: var(--slate); font-size: 12px; line-height: 1.5; }
    .upload:focus-within { border-color: var(--primary-color); }

    /* ---------- Modals ---------- */
    .form-error { margin-top: 12px; color: #dc2626; font-size: 13px; }
    .form-error:empty { display: none; }

    .confirm-icon { width: 60px; height: 60px; margin: 0 auto 14px; border-radius: 50%; background: var(--primary-light); color: var(--primary-dark); display: flex; align-items: center; justify-content: center; font-size: 26px; }
    .confirm-icon.danger { background: #fee2e2; color: #dc2626; }

    /* ---------- Empty / loading ---------- */
    .empty { padding: 50px 20px; text-align: center; color: var(--slate); }
    .empty i { display: block; margin-bottom: 12px; font-size: 44px; color: var(--primary-dark); }
    .empty h5 { color: var(--text-color); font-weight: 700; }

    .skeleton { height: 120px; margin-bottom: 16px; border-radius: 20px; background: linear-gradient(90deg, rgba(255,255,255,.4) 25%, rgba(255,255,255,.85) 50%, rgba(255,255,255,.4) 75%); background-size: 200% 100%; animation: shimmer 1.3s infinite linear; }
    @keyframes shimmer { to { background-position: -200% 0; } }

    @media (max-width: 575.98px) {
        .quiz-head, .question { padding: 18px; }
        .question-top { flex-wrap: wrap; }
        .q-actions { width: 100%; justify-content: flex-end; }
    }

</style>
@endpush


@push('scripts')
<script>
    // The quiz id comes from the page address: /teacher/quizzes/{id}/questions
    const quizId = {{ (int) $quiz }};

    let quiz = {};            // the quiz (title, status, marks)
    let questions = [];       // its questions, each with its options
    let deleteTarget = null;  // what the delete window is about to remove


    /* ---------------------------------------------------------------
       Small helpers
    --------------------------------------------------------------- */

    // Talks to the API and returns the JSON. Throws when the request fails.
    async function api(method, url, body) {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Authorization': 'Bearer ' + window.token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: body ? JSON.stringify(body) : undefined
        });

        const data = await response.json().catch(function () { return {}; });

        if (!response.ok) {
            throw { status: response.status, data: data };
        }

        return data;
    }

    // Same, but sends a form with files. Browsers cannot send files with PUT,
    // so an update is sent as POST with _method=PUT (the same way the student form does it).
    async function apiForm(method, url, formData) {
        if (method === 'PUT') formData.append('_method', 'PUT');

        const response = await fetch(url, {
            method: 'POST',
            headers: { 'Authorization': 'Bearer ' + window.token, 'Accept': 'application/json' },   // no Content-Type: the browser adds it
            body: formData
        });

        const data = await response.json().catch(function () { return {}; });

        if (response.status === 413) {
            throw { status: 413, data: { message: 'The file is too large for the server. Please choose a smaller file.' } };
        }

        if (!response.ok) {
            throw { status: response.status, data: data };
        }

        return data;
    }

    // Turns an API error into one readable sentence
    function errorText(error) {
        if (error.data && error.data.errors) {
            return Object.values(error.data.errors).flat().join(' ');
        }

        return (error.data && error.data.message) || 'Something went wrong. Please try again.';
    }

    // Makes text safe to put inside HTML
    function esc(text) {
        const div = document.createElement('div');
        div.textContent = text == null ? '' : text;
        return div.innerHTML.replace(/"/g, '&quot;');
    }

    // Only allow normal web links or site paths for images and audio
    function safeUrl(url) {
        return /^(https?:)?\/\//i.test(url || '') || /^\//.test(url || '') ? url : '';
    }

    function isTrue(value) {
        return value === true || value === 1 || value === '1';
    }

    function isPublished() {
        return isTrue(quiz.is_published);
    }

    function byId(id) {
        return document.getElementById(id);
    }

    function showModal(id) {
        bootstrap.Modal.getOrCreateInstance(byId(id)).show();
    }

    function hideModal(id) {
        bootstrap.Modal.getOrCreateInstance(byId(id)).hide();
    }

    function showMessage(text, type) {
        byId('message').innerHTML =
            '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
            esc(text) +
            '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }


    /* ---------------------------------------------------------------
       Picture and audio upload boxes
       Each box can: choose a new file, show a preview (also of the file already saved), and remove it.
    --------------------------------------------------------------- */

    const FIELDS = {
        questionImage: { kind: 'image', error: 'questionError', noun: 'picture' },
        questionAudio: { kind: 'audio', error: 'questionError', noun: 'audio' },
        optionImage:   { kind: 'image', error: 'optionError',   noun: 'picture' }
    };

    const FILE_RULES = {
        image: { maxMb: 2, types: ['image/jpeg', 'image/png', 'image/webp'], hint: 'a JPG, PNG or WebP picture' },
        audio: { maxMb: 5, hint: 'an audio file (MP3, WAV, OGG or M4A)' }
    };

    const removeFlags = { questionImage: false, questionAudio: false, optionImage: false };   // true = delete the saved file
    const blobUrls = {};                                                                      // temporary previews to clean up

    function setPreview(field, url) {
        const preview = byId(field + 'Preview');
        const label = byId(field + 'Label');

        if (blobUrls[field] && blobUrls[field] !== url) {
            URL.revokeObjectURL(blobUrls[field]);
            blobUrls[field] = null;
        }

        if (url) {
            preview.src = url;
        } else {
            preview.removeAttribute('src');
            if (preview.load) preview.load();
        }

        preview.hidden = !url;
        byId(field + 'Remove').hidden = !url;
        label.textContent = (url ? 'Change ' : 'Choose ') + FIELDS[field].noun;
    }

    // Empties the box and shows the file that is already saved, if there is one
    function resetFileField(field, savedUrl) {
        byId(field).value = '';
        removeFlags[field] = false;
        setPreview(field, safeUrl(savedUrl));
    }

    function pickFile(field) {
        const config = FIELDS[field];
        const rules = FILE_RULES[config.kind];
        const input = byId(field);
        const file = input.files[0];

        if (!file) return;

        const tooBig = file.size > rules.maxMb * 1024 * 1024;
        const wrongType = config.kind === 'image' ? rules.types.indexOf(file.type) === -1 : file.type.indexOf('audio/') !== 0;

        if (tooBig || wrongType) {
            input.value = '';
            byId(config.error).textContent = tooBig
                ? 'That file is too large. The limit is ' + rules.maxMb + ' MB.'
                : 'Please choose ' + rules.hint + '.';
            return;
        }

        byId(config.error).textContent = '';
        removeFlags[field] = false;

        const url = URL.createObjectURL(file);
        setPreview(field, url);
        blobUrls[field] = url;
    }

    function clearFile(field) {
        byId(field).value = '';
        removeFlags[field] = true;
        setPreview(field, '');
    }

    Object.keys(FIELDS).forEach(function (field) {
        byId(field).addEventListener('change', function () { pickFile(field); });
        byId(field + 'Remove').addEventListener('click', function () { clearFile(field); });
    });


    /* ---------------------------------------------------------------
       Loading
    --------------------------------------------------------------- */

    async function loadQuiz() {
        try {
            const response = await api('GET', '/api/teacher/quizzes/' + quizId);
            quiz = (response.data && response.data.quiz) || response.data || response.quiz || {};
        } catch (error) {
            quiz = {};
        }
    }

    async function loadQuestions() {
        try {
            const response = await api('GET', '/api/teacher/quizzes/' + quizId + '/questions');
            questions = response.data || [];
        } catch (error) {
            byId('questionList').innerHTML =
                '<div class="glass empty"><i class="bi bi-exclamation-circle"></i>' +
                '<h5>Could not load the questions</h5><p class="mb-0">' + esc(errorText(error)) + '</p></div>';
            return;
        }

        renderHeader();
        renderQuestions();
    }


    /* ---------------------------------------------------------------
       Drawing the page
    --------------------------------------------------------------- */

    function renderHeader() {
        const published = isPublished();
        const status = byId('quizStatus');

        byId('quizTitle').textContent = quiz.title || 'Quiz #' + quizId;
        status.textContent = published ? 'Published' : 'Draft';
        status.className = 'pill ' + (published ? 'published' : 'draft');

        // Total marks of all questions
        let total = 0;
        questions.forEach(function (question) {
            total += Number(question.marks_per_question) || 0;
        });

        byId('quizMarks').textContent =
            questions.length + (questions.length === 1 ? ' question' : ' questions') + ' · ' + total + ' marks';

        const warning = byId('marksWarning');

        if (quiz.total_marks && Number(quiz.total_marks) !== total) {
            warning.textContent = 'The questions add up to ' + total + ' marks, but this quiz is set to ' + quiz.total_marks + ' marks.';
            warning.hidden = false;
        } else {
            warning.hidden = true;
        }

        byId('addQuestionBtn').hidden = published;
        byId('publishBtn').hidden = published;
        byId('lockedNote').hidden = !published;
    }

    function optionHtml(option, locked) {
        const correct = isTrue(option.is_correct);
        const image = safeUrl(option.image_url);

        let html = '<div class="option' + (correct ? ' correct' : '') + '">';
        html += '<i class="bi ' + (correct ? 'bi-check-circle-fill' : 'bi-circle') + '"></i>';

        if (image) {
            html += '<a href="' + esc(image) + '" target="_blank" rel="noopener"><img class="option-img" src="' + esc(image) + '" alt=""></a>';
        }

        html += '<span class="option-text">' + esc(option.option_text) + '</span>';

        if (correct) {
            html += '<span class="option-badge">Correct</span>';
        }

        if (!locked) {
            html += '<button type="button" class="icon-btn small" title="Edit option" onclick="openOptionForm(' + option.question_id + ', ' + option.id + ')"><i class="bi bi-pencil"></i></button>';
            html += '<button type="button" class="icon-btn small danger" title="Delete option" onclick="askDelete(\'option\', ' + option.id + ')"><i class="bi bi-trash"></i></button>';
        }

        return html + '</div>';
    }

    function questionHtml(question, number, locked) {
        const options = question.options || [];
        const image = safeUrl(question.image_url);
        const audio = safeUrl(question.tts_audio_url);

        let html = '<article class="glass question"><div class="question-top">';
        html += '<span class="q-number">' + number + '</span>';
        html += '<div class="q-body">';
        html += '<p class="q-text">' + esc(question.question_text) + '</p>';
        html += '<span class="q-chip"><i class="bi bi-patch-check"></i>' + esc(question.marks_per_question) + ' marks</span>';

        if (image || audio) {
            html += '<div class="q-media">';
            if (image) html += '<a href="' + esc(image) + '" target="_blank" rel="noopener"><img src="' + esc(image) + '" alt="Question picture"></a>';
            if (audio) html += '<audio controls preload="none" src="' + esc(audio) + '"></audio>';
            html += '</div>';
        }

        html += '</div>';

        if (!locked) {
            html += '<div class="q-actions">';
            html += '<button type="button" class="icon-btn" title="Edit question" onclick="openQuestionForm(' + question.id + ')"><i class="bi bi-pencil"></i></button>';
            html += '<button type="button" class="icon-btn danger" title="Delete question" onclick="askDelete(\'question\', ' + question.id + ')"><i class="bi bi-trash"></i></button>';
            html += '</div>';
        }

        html += '</div><div class="options">';

        if (!options.length) {
            html += '<div class="option-hint">No answer options yet. Add at least two, and mark one as correct.</div>';
        }

        options.forEach(function (option) {
            html += optionHtml(option, locked);
        });

        if (!locked) {
            html += '<button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="openOptionForm(' + question.id + ')"><i class="bi bi-plus-lg me-1"></i>Add option</button>';
        }

        return html + '</div></article>';
    }

    function renderQuestions() {
        const locked = isPublished();

        if (!questions.length) {
            byId('questionList').innerHTML =
                '<div class="glass empty"><i class="bi bi-patch-question"></i>' +
                '<h5>No questions yet</h5>' +
                '<p class="mb-3">Add your first question, then give it some answer options.</p>' +
                (locked ? '' : '<button type="button" class="btn btn-primary" onclick="openQuestionForm()"><i class="bi bi-plus-lg me-1"></i>Add Question</button>') +
                '</div>';
            return;
        }

        let html = '';

        questions.forEach(function (question, index) {
            html += questionHtml(question, index + 1, locked);
        });

        byId('questionList').innerHTML = html;
    }


    /* ---------------------------------------------------------------
       Questions: add and edit
    --------------------------------------------------------------- */

    function openQuestionForm(id) {
        const question = questions.find(function (item) { return item.id === id; });

        byId('questionId').value = question ? question.id : '';
        byId('questionText').value = question ? question.question_text : '';
        byId('questionMarks').value = question ? question.marks_per_question : 1;
        byId('questionError').textContent = '';
        byId('questionModalTitle').textContent = question ? 'Edit Question' : 'Add Question';

        // A file box cannot be filled with a link, so it shows the saved file as a preview instead
        resetFileField('questionImage', question ? question.image_url : '');
        resetFileField('questionAudio', question ? question.tts_audio_url : '');

        showModal('questionModal');
    }

    async function saveQuestion(event) {
        event.preventDefault();

        const id = byId('questionId').value;
        const button = byId('questionSaveBtn');
        const image = byId('questionImage').files[0];
        const audio = byId('questionAudio').files[0];

        const form = new FormData();
        form.append('question_text', byId('questionText').value.trim());
        form.append('marks_per_question', byId('questionMarks').value);

        if (image) form.append('image', image);
        else if (removeFlags.questionImage) form.append('remove_image', '1');

        if (audio) form.append('audio', audio);
        else if (removeFlags.questionAudio) form.append('remove_audio', '1');

        button.disabled = true;
        button.textContent = (image || audio) ? 'Uploading...' : 'Saving...';
        byId('questionError').textContent = '';

        try {
            if (id) {
                await apiForm('PUT', '/api/teacher/questions/' + id, form);
            } else {
                await apiForm('POST', '/api/teacher/quizzes/' + quizId + '/questions', form);
            }

            hideModal('questionModal');
            await loadQuestions();
            showMessage(id ? 'Question updated.' : 'Question added. Now add its answer options.', 'success');
        } catch (error) {
            byId('questionError').textContent = errorText(error);
        }

        button.disabled = false;
        button.textContent = 'Save Question';
    }


    /* ---------------------------------------------------------------
       Options: add and edit
    --------------------------------------------------------------- */

    function findQuestion(id) {
        return questions.find(function (item) { return item.id === id; });
    }

    function openOptionForm(questionId, optionId) {
        const question = findQuestion(questionId);
        const option = optionId ? (question.options || []).find(function (item) { return item.id === optionId; }) : null;

        byId('optionQuestionId').value = questionId;
        byId('optionId').value = option ? option.id : '';
        byId('optionText').value = option ? option.option_text : '';
        byId('optionCorrect').checked = option ? isTrue(option.is_correct) : false;
        byId('optionError').textContent = '';
        byId('optionModalTitle').textContent = option ? 'Edit Option' : 'Add Option';

        resetFileField('optionImage', option ? option.image_url : '');

        showModal('optionModal');
    }

    async function saveOption(event) {
        event.preventDefault();

        const questionId = Number(byId('optionQuestionId').value);
        const optionId = byId('optionId').value;
        const wantsCorrect = byId('optionCorrect').checked;
        const button = byId('optionSaveBtn');
        const image = byId('optionImage').files[0];

        // A question can only have one correct answer
        const options = findQuestion(questionId).options || [];
        const otherCorrect = options.some(function (item) {
            return isTrue(item.is_correct) && String(item.id) !== String(optionId);
        });

        if (wantsCorrect && otherCorrect) {
            byId('optionError').textContent = 'This question already has a correct answer. Untick it on the other option first.';
            return;
        }

        const form = new FormData();
        form.append('option_text', byId('optionText').value.trim());
        form.append('is_correct', wantsCorrect ? '1' : '0');

        if (image) form.append('image', image);
        else if (removeFlags.optionImage) form.append('remove_image', '1');

        button.disabled = true;
        button.textContent = image ? 'Uploading...' : 'Saving...';
        byId('optionError').textContent = '';

        try {
            if (optionId) {
                await apiForm('PUT', '/api/teacher/options/' + optionId, form);
            } else {
                await apiForm('POST', '/api/teacher/questions/' + questionId + '/options', form);
            }

            hideModal('optionModal');
            await loadQuestions();
            showMessage(optionId ? 'Option updated.' : 'Option added.', 'success');
        } catch (error) {
            byId('optionError').textContent = errorText(error);
        }

        button.disabled = false;
        button.textContent = 'Save Option';
    }


    /* ---------------------------------------------------------------
       Delete (always asks first)
    --------------------------------------------------------------- */

    function askDelete(kind, id) {
        let label = '';

        if (kind === 'question') {
            label = findQuestion(id).question_text;
        } else {
            questions.forEach(function (question) {
                (question.options || []).forEach(function (option) {
                    if (option.id === id) label = option.option_text;
                });
            });
        }

        deleteTarget = { kind: kind, id: id };
        byId('deleteKind').textContent = kind;
        byId('deleteLabel').textContent = label.length > 70 ? label.slice(0, 70) + '...' : label;
        byId('deleteError').textContent = '';

        showModal('deleteModal');
    }

    async function confirmDelete() {
        const button = byId('deleteConfirmBtn');
        const url = deleteTarget.kind === 'question'
            ? '/api/teacher/questions/' + deleteTarget.id
            : '/api/teacher/options/' + deleteTarget.id;

        button.disabled = true;

        try {
            await api('DELETE', url);
            hideModal('deleteModal');
            await loadQuestions();
            showMessage(deleteTarget.kind === 'question' ? 'Question deleted.' : 'Option deleted.', 'success');
        } catch (error) {
            byId('deleteError').textContent = errorText(error);
        }

        button.disabled = false;
    }


    /* ---------------------------------------------------------------
       Publish
    --------------------------------------------------------------- */

    // Finds anything that would stop the quiz from working for students
    function findProblems() {
        const problems = [];

        if (!questions.length) {
            problems.push('Add at least one question.');
        }

        questions.forEach(function (question, index) {
            const options = question.options || [];
            const correct = options.filter(function (option) { return isTrue(option.is_correct); }).length;

            if (options.length < 2) {
                problems.push('Question ' + (index + 1) + ' needs at least 2 options.');
            } else if (correct !== 1) {
                problems.push('Question ' + (index + 1) + ' needs exactly one correct answer.');
            }
        });

        return problems;
    }

    function openPublishModal() {
        const problems = findProblems();

        if (problems.length) {
            showMessage('Before publishing: ' + problems.join(' '), 'warning');
            return;
        }

        byId('publishError').textContent = '';
        showModal('publishModal');
    }

    async function publishQuiz() {
        const button = byId('publishConfirmBtn');
        button.disabled = true;

        try {
            await api('PUT', '/api/teacher/quizzes/' + quizId + '/publish');
            hideModal('publishModal');
            await loadQuiz();
            quiz.is_published = 1;               // in case the quiz request did not return it
            renderHeader();
            renderQuestions();
            showMessage('Quiz published. Students can now attempt it.', 'success');
        } catch (error) {
            byId('publishError').textContent = errorText(error);
        }

        button.disabled = false;
    }


    /* ---------------------------------------------------------------
       Start
    --------------------------------------------------------------- */

    loadQuiz().then(loadQuestions);
</script>
@endpush