<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use Carbon\Carbon;

class MembershipController extends Controller
{
    public function index($renewalType, $id)
    {
        $member = Member::findOrFail($id);
        return view($renewalType == 'membership' ? 'pages.renew-membership' : ($renewalType == 'membership_term' ? 'pages.renew-membership-term' : 'pages.renew-personal-trainer'), compact('member'));
    }

    public function renewMembership(Request $request, $renewalType, $id)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        $member = Member::findOrFail($id);
        $staffUser = User::where('username', 'staff_access')->first();

        try {
            $gym_access_start_date = null;
            $gym_access_end_date = null;
            if($request->password === $staffUser->password){
                if($renewalType == 'membership'){
                    $member->update([
                        'membership_start_date' => $request->membership_start_date,
                        'membership_end_date' => $request->membership_end_date,
                    ]);
                }
                else if($renewalType == 'membership_term'){
                    $gym_access_start_date = now()->toDateString();
                    
                    if ($request->membership_term_gym_access === 'None') {
                        $gym_access_start_date = null;
                        $gym_access_end_date = null;
                    }
                    else if ($request->membership_term_gym_access === '1 month') {
                        $gym_access_end_date = Carbon::parse($member->gym_access_end_date)->addMonth(1)->toDateString();
                    }
                    else if ($request->membership_term_gym_access === '3 months') {
                        $gym_access_end_date = Carbon::parse($member->gym_access_end_date)->addMonths(3)->toDateString();
                    }
        
                    $member->update([
                        'member_type' => $request->member_type,
                        'membership_term_gym_access' => $request->membership_term_gym_access,
                        'gym_access_start_date' => $gym_access_start_date,
                        'gym_access_end_date' => $gym_access_end_date,
                    ]);
                }
                else if($renewalType == 'personal_trainer'){
                    $member->update([
                        'with_pt' => $request->with_pt == '1 month' ? '1 month' : 'None',
                        'pt_start_date' => $request->pt_start_date ? Carbon::parse($request->pt_start_date)->toDateString() : null,
                        'pt_end_date' => $request->pt_end_date ? Carbon::parse($request->pt_end_date)->toDateString() : null,
                    ]);
                }
            }
            else{
                return redirect()->route('member-details.show', $member->id)->with('error', 'Incorrect staff password. Renewal cancelled.');
            }            

            return redirect()->route('member-details.show', $member->id)->with('success', 'Member membership renewed successfully');
            
        } catch (\Throwable $th) {
            return redirect()->route('member-details.show', $member->id)->with('error', $th->getMessage());
        }    
    }
}
