<?php

use App\Http\Controllers\Api\AuthController;
// use App\Http\Controllers\Api\QuizAttemptController;
// use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\InstituteAdmin\InstituteAdminController;
use App\Http\Controllers\Api\InstituteAdmin\ClassController;
use App\Http\Controllers\Api\InstituteAdmin\SubjectController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\Api\InstituteAdmin\DashboardController as InstituteAdminDashboardController;
use App\Http\Controllers\Api\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Api\Student\DashboardController as StudentDashboardController;
use Illuminate\Http\Request;
 use App\Http\Controllers\Api\SuperAdmin\InstituteController;
use App\Http\Controllers\Api\SuperAdmin\InstituteConfigurationController;
use App\Http\Controllers\Api\SuperAdmin\UserController;
    use App\Http\Controllers\Api\InstituteAdmin\TeacherController;
    use App\Http\Controllers\Api\InstituteAdmin\StudentController;
    use App\Http\Controllers\Api\InstituteAdmin\TeacherClassController;
    use App\Http\Controllers\Api\InstituteAdmin\StudentClassController;
    use App\Http\Controllers\Api\Teacher\QuizController;
    use App\Http\Controllers\Api\Teacher\QuestionController;
    use App\Http\Controllers\API\Teacher\OptionController;
    use App\Http\Controllers\API\Student\QuizAttemptController;
    use App\Http\Controllers\API\Student\StudentAnswerController;
use App\Http\Controllers\API\Student\QuizController as StudentQuizController;



use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::POST('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    // Route::get('/superadmin/dashboard', [SuperAdminDashboardController::class, 'dashboard'])->name('superAdmin.dashboard');

    Route::middleware('system.admin')->post('/addInstitute', [InstituteController::class, 'store']);
    Route::middleware('system.admin')->get('/getInstitutes', [InstituteController::class, 'index']);
Route::middleware('system.admin')->get('/show/{institute}', [InstituteController::class, 'show']);
Route::middleware('system.admin')->post('/updateInstitute/{institute}', [InstituteController::class, 'update']);
Route::middleware('system.admin')->delete('/destroy/{institute}', [InstituteController::class, 'destroy']);

Route::middleware(['auth:sanctum', 'system.admin'])->group(function () {

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus']);
    Route::get('/institutes/{institute}/configuration', [InstituteConfigurationController::class, 'show']);
    Route::put('/institutes/{institute}/configuration', [InstituteConfigurationController::class, 'update']);
});


Route::middleware(['auth:sanctum', 'institute.admin'])
    ->group(function () {
        Route::get('/instituteAdmin/dashboard', [
            InstituteAdminController::class,
            'dashboard'
        ]);
         Route::apiResource('classes', ClassController::class);
           Route::apiResource('subjects', SubjectController::class);
           Route::post('teachers/{teacher}/classes', [TeacherClassController::class,'store']);
           Route::Get('teachers/{teacher}/classes', [TeacherClassController::class,'index']);
           Route::post('students/{student}/classes', [StudentClassController::class,'store']);
           Route::Get('students/{student}/classes', [StudentClassController::class,'index']);
    });

Route::middleware(['auth:sanctum', 'institute.admin'])
    ->group(function () {

        Route::get('/teachers', [
            TeacherController::class,
            'index'
        ]);

        Route::post('/teachers', [
            TeacherController::class,
            'store'
        ]);

        Route::get('/teachers/{user}', [
            TeacherController::class,
            'show'
        ]);

        Route::put('/teachers/{user}', [
            TeacherController::class,
            'update'
        ]);

        Route::patch('/teachers/{user}/password', [
            TeacherController::class,
            'updatePassword'
        ]);

        Route::delete('/teachers/{user}', [
            TeacherController::class,
            'destroy'
        ]);

        // student

         Route::get('/admingettingStudents', [
            StudentController::class,
            'index'
        ]);

        Route::post('/students', [
            StudentController::class,
            'store'
        ]);

        Route::get('/students/{user}', [
            StudentController::class,
            'show'
        ]);

        Route::put('/students/{user}', [
            StudentController::class,
            'update'
        ]);

        Route::patch('/students/{user}/password', [
            StudentController::class,
            'updatePassword'
        ]);

        Route::delete('/students/{user}', [
            StudentController::class,
            'destroy'
        ]);
    });
    // return response()->json([
    //     'success' => true,
    //     'message' => 'System Admin access confirmed.',
    //     'user' => $request->user()
    // ]);
    // Route::get('/quizzes', [QuizController::class, 'index']);
    // Route::post('/quizzes', [QuizController::class, 'store']);
    // Route::get('/quizzes/{quiz}', [QuizController::class, 'show']);
    // Route::post('/quizzes/{quiz}/attempts', [QuizAttemptController::class, 'start']);
    // Route::post('/attempts/{attempt}/submit', [QuizAttemptController::class, 'submit']);
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
    Route::get('/teacher/quizzes', [QuizController::class, 'index']);
    Route::post('/teacher/quizzes', [QuizController::class, 'store']);
    Route::get('/teacher/quizzes/{quiz}', [QuizController::class, 'show']);
    Route::put('/teacher/quizzes/{quiz}', [QuizController::class, 'update']);
    Route::delete('/teacher/quizzes/{quiz}', [QuizController::class, 'destroy']);
    Route::put('/teacher/quizzes/{quiz}/publish', [QuizController::class, 'publish']);
    // questions
     Route::post('/teacher/quizzes/{quiz}/questions', [QuestionController::class, 'store']);
    Route::get('/teacher/quizzes/{quiz}/questions', [QuestionController::class, 'index']);
    Route::get('/teacher/questions/{question}', [QuestionController::class, 'show']);

Route::put('/teacher/questions/{question}', [QuestionController::class, 'update']);

Route::delete('/teacher/questions/{question}', [QuestionController::class, 'destroy']);

// options
        Route::post('/teacher/questions/{question}/options', [OptionController::class, 'store']);
    Route::get('/teacher/questions/{question}/options', [OptionController::class, 'index']);
    Route::get('/teacher/options/{option}', [OptionController::class, 'show']);

Route::put('/teacher/options/{option}', [OptionController::class, 'update']);

Route::delete('/teacher/options/{option}', [OptionController::class, 'destroy']);

    
});
Route::middleware(['auth:sanctum', 'student'])->group(function () {
    Route::get('/student/quizzes', [QuizAttemptController::class, 'getQuiz']);
    // Route::post('/student/quizzes', [QuizAttemptController::class, 'start']);
    Route::post('/student/quizzes/{quiz}/start', [QuizAttemptController::class, 'start']);
    Route::post('/student/quizzesAttempt', [StudentAnswerController::class, 'store']);
    Route::post('/student/submit-quiz', [StudentAnswerController::class, 'submit']);
    Route::get('/student/result-quiz/{quiz}', [StudentAnswerController::class, 'result']);
});