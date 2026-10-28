
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\Api\SuperAdmin\InstituteController;
use App\Http\Controllers\Api\SuperAdmin\InstituteConfigurationController;
use App\Http\Controllers\Api\SuperAdmin\UserController;
use App\Http\Controllers\Api\SuperAdmin\PermissionController;
use App\Http\Controllers\Api\SuperAdmin\IndividualPermissionController;

use App\Http\Controllers\Api\InstituteAdmin\InstituteAdminController;
use App\Http\Controllers\Api\InstituteAdmin\DashboardController as InstituteAdminDashboardController;
use App\Http\Controllers\Api\InstituteAdmin\ClassController;
use App\Http\Controllers\Api\InstituteAdmin\SubjectController;
use App\Http\Controllers\Api\InstituteAdmin\TeacherController;
use App\Http\Controllers\Api\InstituteAdmin\StudentController;
use App\Http\Controllers\Api\InstituteAdmin\TeacherClassController;
use App\Http\Controllers\Api\InstituteAdmin\StudentClassController;
use App\Http\Controllers\Api\InstituteAdmin\InstituteresultController;
use App\Http\Controllers\Api\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Api\Teacher\QuizController;
use App\Http\Controllers\Api\Teacher\QuestionController;
use App\Http\Controllers\Api\Teacher\OptionController;
use App\Http\Controllers\Api\Teacher\TeacherResultController;
use App\Http\Controllers\Api\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Api\Student\QuizAttemptController;
use App\Http\Controllers\Api\Student\StudentAnswerController;
use App\Http\Controllers\Api\Student\SpeechController;
use App\Http\Controllers\Api\Student\Studentprofilecontroller;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/me/permissions', [AuthController::class, 'permissions']);
    // Route::get('/me/permissions', [PermissionController::class, 'mine']);   
});

Route::middleware(['auth:sanctum', 'system.admin'])->group(function () {
    Route::post('/addInstitute', [InstituteController::class, 'store']);
    Route::get('/getInstitutes', [InstituteController::class, 'index']);
    Route::get('/show/{institute}', [InstituteController::class, 'show']);
    Route::post('/updateInstitute/{institute}', [InstituteController::class, 'update']);
    Route::delete('/destroy/{institute}', [InstituteController::class, 'destroy']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus']);

    Route::get('/institutes/{institute}/configuration', [InstituteConfigurationController::class, 'show']);
    Route::put('/institutes/{institute}/configuration', [InstituteConfigurationController::class, 'update']);

    Route::get('/permissions', [PermissionController::class, 'index']);
    Route::put('/permissions', [PermissionController::class, 'update']);
    Route::get('/users/{user}/permissions', [
    IndividualPermissionController::class,
    'show'
]);

Route::put('/users/{user}/permissions', [
    IndividualPermissionController::class,
    'update'
]);
Route::get('/permission-users', [IndividualPermissionController::class, 'users']);
});

Route::middleware(['auth:sanctum', 'institute.admin'])->group(function () {
    Route::get('/instituteAdmin/dashboard', [InstituteAdminController::class, 'dashboard']);

    Route::get('/classes', [ClassController::class, 'index'])
        ->middleware('permission:view_classes');
    Route::get('/classes/{class}', [ClassController::class, 'show'])
        ->middleware('permission:view_classes');
    Route::post('/classes', [ClassController::class, 'store'])
        ->middleware('permission:create_classes');
    Route::put('/classes/{class}', [ClassController::class, 'update'])
        ->middleware('permission:edit_classes');
    Route::patch('/classes/{class}', [ClassController::class, 'update'])
        ->middleware('permission:edit_classes');
    Route::delete('/classes/{class}', [ClassController::class, 'destroy'])
        ->middleware('permission:delete_classes');

    Route::get('/subjects', [SubjectController::class, 'index'])
        ->middleware('permission:view_subjects');
    Route::get('/subjects/{subject}', [SubjectController::class, 'show'])
        ->middleware('permission:view_subjects');
    Route::post('/subjects', [SubjectController::class, 'store'])
        ->middleware('permission:create_subjects');
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])
        ->middleware('permission:edit_subjects');
    Route::patch('/subjects/{subject}', [SubjectController::class, 'update'])
        ->middleware('permission:edit_subjects');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])
        ->middleware('permission:delete_subjects');

    Route::get('/institute/profile', [ProfileController::class, 'show']);

    Route::post('/teachers/{teacher}/classes', [TeacherClassController::class, 'store'])
        ->middleware('permission:assign_teacher_classes');
    Route::get('/teachers/{teacher}/classes', [TeacherClassController::class, 'index'])
        ->middleware('permission:assign_teacher_classes');
    Route::delete('/teachers/{teacher}/classes/{class}', [TeacherClassController::class, 'destroy'])
        ->middleware('permission:assign_teacher_classes');

    Route::post('/students/{student}/classes', [StudentClassController::class, 'store'])
        ->middleware('permission:assign_student_classes');
    Route::get('/students/{student}/classes', [StudentClassController::class, 'index'])
        ->middleware('permission:assign_student_classes');

    Route::get('/instituteAdmin/results', [InstituteresultController::class, 'index'])
        ->middleware('permission:view_results');
});

Route::middleware(['auth:sanctum', 'institute.admin'])->group(function () {
    Route::get('/teachers', [TeacherController::class, 'index'])
        ->middleware('permission:view_teachers');
    Route::post('/teachers', [TeacherController::class, 'store'])
        ->middleware('permission:create_teachers');
    Route::get('/teachers/{user}', [TeacherController::class, 'show'])
        ->middleware('permission:view_teachers');
    Route::put('/teachers/{user}', [TeacherController::class, 'update'])
        ->middleware('permission:edit_teachers');
    Route::patch('/teachers/{user}/password', [TeacherController::class, 'updatePassword'])
        ->middleware('permission:edit_teachers');
    Route::delete('/teachers/{user}', [TeacherController::class, 'destroy'])
        ->middleware('permission:delete_teachers');

    Route::get('/students', [StudentController::class, 'index'])
        ->middleware('permission:view_students');
    Route::post('/students', [StudentController::class, 'store'])
        ->middleware('permission:create_students');
    Route::get('/students/{user}', [StudentController::class, 'show'])
        ->middleware('permission:view_students');
    Route::put('/students/{user}', [StudentController::class, 'update'])
        ->middleware('permission:edit_students');
    Route::patch('/students/{user}/password', [StudentController::class, 'updatePassword'])
        ->middleware('permission:edit_students');
    Route::delete('/students/{user}', [StudentController::class, 'destroy'])
        ->middleware('permission:delete_students');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/superAdmin/profile', [ProfileController::class, 'show']);
    Route::post('/superAdmin/updateProfile/{id}', [ProfileController::class, 'update']);
    Route::put('/profile/password', [ProfileController::class, 'updatePassword']);

    Route::get('/superadmin/dashboard', [SuperAdminDashboardController::class, 'index']);
    Route::get('/institute-admin/dashboard', [InstituteAdminDashboardController::class, 'index']);
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index']);
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'teacher'])->group(function () {
    Route::get('/teacher/quizzes', [QuizController::class, 'index'])
        ->middleware('permission:view_quizzes');
    Route::post('/teacher/quizzes', [QuizController::class, 'store'])
        ->middleware('permission:create_quizzes');
    Route::get('/teacher/quizzes/{quiz}', [QuizController::class, 'show'])
        ->middleware('permission:view_quizzes');
    Route::put('/teacher/quizzes/{quiz}', [QuizController::class, 'update'])
        ->middleware('permission:edit_quizzes');
    Route::delete('/teacher/quizzes/{quiz}', [QuizController::class, 'destroy'])
        ->middleware('permission:delete_quizzes');
    Route::put('/teacher/quizzes/{quiz}/publish', [QuizController::class, 'publish'])
        ->middleware('permission:publish_quizzes');
    Route::put('/teacher/quizzes/{quiz}/unpublish', [QuizController::class, 'unpublish'])
        ->middleware('permission:unpublish_quizzes');

    Route::post('/teacher/quizzes/{quiz}/questions', [QuestionController::class, 'store'])
        ->middleware('permission:create_questions');
    Route::get('/teacher/quizzes/{quiz}/questions', [QuestionController::class, 'index'])
        ->middleware('permission:view_questions');
    Route::get('/teacher/questions/{question}', [QuestionController::class, 'show'])
        ->middleware('permission:view_questions');
    Route::put('/teacher/questions/{question}', [QuestionController::class, 'update'])
        ->middleware('permission:edit_questions');
    Route::delete('/teacher/questions/{question}', [QuestionController::class, 'destroy'])
        ->middleware('permission:delete_questions');

    Route::post('/teacher/questions/{question}/options', [OptionController::class, 'store'])
        ->middleware('permission:create_options');
    Route::get('/teacher/questions/{question}/options', [OptionController::class, 'index'])
        ->middleware('permission:view_options');
    Route::get('/teacher/options/{option}', [OptionController::class, 'show'])
        ->middleware('permission:view_options');
    Route::put('/teacher/options/{option}', [OptionController::class, 'update'])
        ->middleware('permission:edit_options');
    Route::delete('/teacher/options/{option}', [OptionController::class, 'destroy'])
        ->middleware('permission:delete_options');

    Route::get('/teacher/results', [TeacherResultController::class, 'index'])
        ->middleware('permission:view_results');
    Route::get('/teacher/results/{quiz}', [TeacherResultController::class, 'show'])
        ->middleware('permission:view_results');
});

Route::middleware(['auth:sanctum', 'student'])->group(function () {
    Route::get('/student/quizzes', [QuizAttemptController::class, 'getQuiz'])
        ->middleware('permission:view_quizzes');
    Route::post('/student/quizzes/{quiz}/start', [QuizAttemptController::class, 'start'])
        ->middleware('permission:take_quizzes');
    Route::post('/student/quizzesAttempt', [StudentAnswerController::class, 'store'])
        ->middleware('permission:take_quizzes');
    Route::post('/student/submit-quiz', [StudentAnswerController::class, 'submit'])
        ->middleware('permission:submit_quizzes');
    Route::get('/student/result-quiz/{quiz}', [StudentAnswerController::class, 'result'])
        ->middleware('permission:view_own_results');
    Route::get('/student/attempts/{attemptId}', [QuizAttemptController::class, 'show'])
        ->middleware('permission:take_quizzes');

    Route::post('/student/speech', [SpeechController::class, 'speak']);
    Route::get('/student/profile', [Studentprofilecontroller::class, 'show']);
    Route::post('/student/profile', [Studentprofilecontroller::class, 'update']);
    Route::put('/student/profile/password', [Studentprofilecontroller::class, 'updatePassword']);
});
