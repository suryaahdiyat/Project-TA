<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CoupleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\PenghuluController;
use App\Http\Controllers\ThemeViewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Redirect root URL to dashboard
Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('pages.login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/view-announcement', [AnnouncementController::class, 'viewAnnouncement'])->name('view.announcement');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/my-account', [MyAccountController::class, 'editMyAccount'])->name('edit.myAccount');
    Route::put('/my-account/{id}', [MyAccountController::class, 'updateMyAccount']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function () {
        return redirect('/dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('penghulu', PenghuluController::class);
    Route::resource('user', UserController::class);
    Route::resource('couple', CoupleController::class);
    Route::resource('schedule', ScheduleController::class);
    Route::resource('theme-view', ThemeViewController::class);
    Route::resource('announcement', AnnouncementController::class);
    Route::get('/penghulu-available', [ScheduleController::class, 'penghuluAvailable']);


    // Route::patch('/admin/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggle-status');
    Route::patch('/penghulu/{id}/toggle-status', [PenghuluController::class, 'toggleStatus'])->name('penghulu.toggle-status');

    Route::get('/sync-announcement', [AnnouncementController::class, 'sync'])->name('sync.announcement');
});

Route::middleware(['auth', 'penghulu'])->group(function () {
    Route::get('/penghulu-schedule', [PenghuluController::class, 'penghuluSchedule'])->name('penghulu.penghulu-schedule');
});

// Route::get('/', function () {
//     return redirect('/dashboard');
// })->middleware('auth');

// Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');

// Route::get('/login', function () {
//     return view('pages.login');
// })->name('login')->middleware('guest');

// Route::post('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');

// Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Route::get('/my-account', [MyAccountController::class, 'editMyAccount'])->name('edit.myAccount')->middleware('auth');
// Route::put('/my-account/{id}', [MyAccountController::class, 'updateMyAccount'])->middleware('auth');

// Route::get('/penghulu-schedule', [PenghuluController::class, 'penghuluSchedule'])->name('penghulu.penghulu-schedule')->middleware('auth');

// Route::resource('user', UserController::class);
// Route::resource('penghulu', PenghuluController::class)->middleware('auth');
// Route::resource('user', UserController::class)->middleware('auth');
// // Route::post('/user/resetP', [UserController::class, 'resetP']);
// Route::resource('couple', CoupleController::class)->middleware('auth');
// Route::resource('schedule', ScheduleController::class)->middleware('auth');
// Route::resource('theme-view', ThemeViewController::class)->middleware('auth');
// Route::resource('announcement', AnnouncementController::class)->middleware('auth');
// Route::get('/penghulu-available', [ScheduleController::class, 'penghuluAvailable'])->middleware('auth');

// Route::get('/view-announcement', [AnnouncementController::class, 'viewAnnouncement'])->name('view.announcement');

// Route::patch('/admin/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('user.toggle-status');

// Route::patch('/penghulu/{id}/toggle-status', [PenghuluController::class, 'toggleStatus'])->name('penghulu.toggle-status');

// // Route::get('/announcement', [AnnouncementController::class, 'index'])->name('announcement.index');
// Route::get('/sync-announcement', [AnnouncementController::class, 'sync'])->name('sync.announcement');
