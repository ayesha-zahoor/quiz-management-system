<?php

use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\Api\SuperAdmin\InstituteController;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/superAdmin/dashboard', function () {
    return view('superAdmin.dashboard');
});

Route::get('/instituteAdmin/dashboard', function () {
    return view('InstituteAdmin.dashboard');
});
Route::get('/superadmin/addInstitute', function () {
    return view('superadmin.addInstitute');
    });
    
    Route::get('/superAdmin/edit/{id}',[InstituteController::class, 'edit']);
    Route::get('/super-admin/profile/{id}',[ProfileController::class, 'editProfile']);
    
    Route::get('/instituteAdmin/subjects', function () {
        return view('InstituteAdmin.subjects');
    });
    Route::get('/instituteAdmin/classes', function () {
        return view('InstituteAdmin.classes');
    });
    Route::get('/instituteAdmin/teachers', function () {
        return view('InstituteAdmin.teachers');
    });
