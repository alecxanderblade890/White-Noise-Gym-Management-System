<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/manage-members', [MemberController::class, 'getMembers'])->name('manage-members.index');
Route::get('/member-details/{id}', [MemberController::class, 'showMemberDetails'])->name('member-details.show');
Route::get('/register-member', [MemberController::class, 'registerMemberForm'])->name('register-member');
