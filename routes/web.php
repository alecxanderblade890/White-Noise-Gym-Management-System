<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;

Route::get('/', function () {
    return view('pages.dashboard');
})->name('dashboard');

Route::get('/members', [MemberController::class, 'getMembers'])->name('members.index');
Route::get('/manage-members', [MemberController::class, 'index'])->name('manage-members.index');
Route::get('/member-details/{id}', [MemberController::class, 'showMemberDetails'])->name('member-details.show');
Route::get('/register-member', [MemberController::class, 'registerMemberForm'])->name('register-member');
Route::post('/add-member', [MemberController::class, 'addMember'])->name('add-member');
Route::put('/update-member/{id}', [MemberController::class, 'updateMember'])->name('update-member');
Route::delete('/delete-member/{id}', [MemberController::class, 'deletedMember'])->name('delete-member');


