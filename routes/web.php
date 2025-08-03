<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DailyLogController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/members', [MemberController::class, 'getMembers'])->name('members.index');
Route::get('/manage-members', [MemberController::class, 'showManageMembers'])->name('manage-members.index');
Route::get('/member-details/{id}', [MemberController::class, 'showMemberDetails'])->name('member-details.show');
Route::get('/register-member', [MemberController::class, 'registerMemberForm'])->name('register-member');
Route::post('/add-member', [MemberController::class, 'addMember'])->name('add-member');
Route::put('/update-member/{id}', [MemberController::class, 'updateMember'])->name('update-member');
Route::delete('/delete-member/{id}', [MemberController::class, 'deletedMember'])->name('delete-member');
Route::post('/add-daily-log', [DailyLogController::class, 'addDailyLog'])->name('add-daily-log');
Route::get('/get-daily-logs', [DailyLogController::class, 'getDailyLogs'])->name('get-daily-logs');
Route::get('/daily-log-details', [DailyLogController::class, 'getDailyLogDetail'])->name('daily-log-details.show');
Route::delete('/daily-logs/{id}', [DailyLogController::class, 'deleteDailyLog'])->name('daily-logs.delete');


