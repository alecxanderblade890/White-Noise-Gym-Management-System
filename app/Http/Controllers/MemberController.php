<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        return view('pages.members');
    }

    public function getMembers()
    {
        $members = Member::all();
        return view('pages.manage-members', compact('members'));
    }
    public function showMemberDetails($id)
    {
        $member = Member::find($id);
        return view('pages.member-details', compact('member'));
    }   
    public function registerMemberForm()
    {
        return view('pages.create-member');
    }
}
