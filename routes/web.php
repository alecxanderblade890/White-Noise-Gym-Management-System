<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DailyLogController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\MembershipController;


Route::middleware(['guest'])->group(function () {
    Route::get('/', [AuthenticationController::class, 'index'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login.auth');
});

Route::middleware(['auth', 'cache.nocache'])->group(function () {
    Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/members', [MemberController::class, 'getMembers'])->name('members.index');
    Route::get('/manage-members', [MemberController::class, 'showManageMembers'])->name('manage-members.index');
    Route::get('/member-details/{id}', [MemberController::class, 'showMemberDetails'])->name('member-details.show');
    Route::get('/register-member', [MemberController::class, 'registerMemberForm'])->name('register-member');
    Route::post('/add-member', [MemberController::class, 'addMember'])->name('add-member');
    Route::put('/update-member/{id}', [MemberController::class, 'updateMember'])->name('update-member');
    Route::delete('/delete-member/{id}', [MemberController::class, 'deletedMember'])->name('delete-member');
    Route::post('/add-daily-log', [DailyLogController::class, 'addDailyLog'])->name('add-daily-log');
    Route::get('/get-daily-logs', [DailyLogController::class, 'getDailyLogs'])->name('get-daily-logs');
    Route::put('/update-daily-log/{id}', [DailyLogController::class, 'updateDailyLog'])->name('daily-log.update');
    Route::delete('/daily-log/{id}', [DailyLogController::class, 'deleteDailyLog'])->name('daily-log.delete');
    Route::post('/daily-log/update-time-out/{id}', [DailyLogController::class, 'updateTimeOut'])->name('daily-log.update-time-out');
    Route::get('/daily-logs/filter', [DailyLogController::class, 'filterDailyLogs'])->name('daily-logs.filter');
    Route::get('/renew-membership/{renewalType}/{id}', [MembershipController::class, 'index'])->name('renew-membership.index');
    Route::put('/renew-membership/{renewalType}/{id}', [MembershipController::class, 'renewMembership'])->name('renew-membership.update');
});

Route::middleware(['auth', 'cache.nocache', 'role:admin'])->group(function () {
    Route::get('/sales-report', [SalesReportController::class, 'index'])->name('sales-report.index');
});




