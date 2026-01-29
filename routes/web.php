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
use App\Http\Controllers\PDFController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
});

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

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenController::class, 'login'])->name('login');
    Route::post("login/authenticate", [AuthenController::class, "authenticate"])->name('login.authenticate');
    Route::get('/register', [AuthenController::class, 'register'])->name('register');
    Route::post("register", [AuthenController::class, "store"])->name('register.authenticate');
});

Route::middleware('auth')->group(function () {
    Route::view('/home', 'home')->name('home');
    Route::any('/logout', [AuthenController::class, 'logout'])->name('logout');
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Chart
    Route::get('chart', [ChartController::class, 'index'])->name('chart.index');
    // Resources
    Route::resource('/students', StudentController::class);
    Route::resource('/teachers', TeacherController::class);
    Route::resource('/profiles', ProfileController::class);

    // PDF Routes
    // 1. วางตัวนี้ก่อน
    Route::get('/teachers/export/pdf', [App\Http\Controllers\TeacherController::class, 'exportPDF'])->name('teachers.pdf');
    Route::get('/chart/pdf', [App\Http\Controllers\ChartController::class, 'exportPDF'])->name('chart.pdf');

    // 2. ตามด้วย Resource
    Route::resource('teachers', App\Http\Controllers\TeacherController::class);
});
