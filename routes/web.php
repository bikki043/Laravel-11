<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\JoinController;
use App\Http\Controllers\AuthenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ChartController;

// --- Public Routes ---
Route::get('/', function () {
    return view('welcome');
});

// --- Guest Only (Login/Register) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenController::class, 'login'])->name('login');
    Route::post("login/authenticate", [AuthenController::class, "authenticate"])->name('login.authenticate');
    Route::get('/register', [AuthenController::class, 'register'])->name('register');
    Route::post("register", [AuthenController::class, "store"])->name('register.authenticate');
});

// --- Protected Routes (Must be Logged In) ---
Route::middleware('auth')->group(function () {
    
    Route::view('/home', 'home')->name('home');
    Route::any('/logout', [AuthenController::class, 'logout'])->name('logout');
    
    // Dashboard & Analytics
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('chart', [ChartController::class, 'index'])->name('chart.index');

    // --- PDF Export Routes (ต้องวางก่อน Resource) ---
    Route::get('students/export-pdf', [StudentController::class, 'exportPDF'])->name('students.pdf');
    Route::get('teachers/export-pdf', [TeacherController::class, 'exportPDF'])->name('teachers.export-pdf');
    Route::get('chart/pdf', [ChartController::class, 'exportPDF'])->name('chart.pdf');

    // --- Resource Routes ---
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('profiles', ProfileController::class);

    // --- Other Controllers ---
    Route::controller(PostController::class)->group(function () {
        Route::get('main', 'index');
        Route::get('create', 'create');
    });

    Route::controller(JoinController::class)->group(function () {
        Route::get('left-join', 'LeftJoin');
        Route::get('right-join', 'RightJoin');
        Route::get('inner-join', 'InnerJoin');
        Route::get('full-outer-join', 'FullOuterJoin');
    });
});