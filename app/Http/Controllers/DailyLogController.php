<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\DailyLog;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;  

class DailyLogController extends Controller
{

    public function addDailyLog(Request $request)
    {
        try {
            // Convert checkbox value to proper boolean
            $request->merge([
                'upgrade_gym_access' => $request->has('upgrade_gym_access')
            ]);

            $validated = $request->validate([
                'date' => 'required|date',
                'time_in' => 'required|date_format:H:i',
                'time_out' => 'nullable|date_format:H:i',
                'white_noise_id_form' => 'required|exists:members,white_noise_id',
                'payment_method' => 'required|in:None,Cash,GCash,Bank Transfer',
                'payment_amount' => 'required|integer|min:0',
                'member_type' => 'required|in:Regular,Student',
                'gym_access' => 'required|in:None,1 month,3 months,Walk in',
                'personal_trainer' => 'required|in:None,1 month',
                'purpose_of_visit' => 'required|array',
                'staff_assigned' => 'required|string|max:255',
                'upgrade_gym_access' => 'required|boolean',
                'items' => 'nullable|array',
                'notes' => 'nullable|string'
            ]); 
            
            // Get the member first
            $member = Member::where('white_noise_id', $validated['white_noise_id_form'])->first();

            // if($member->gym_access_start_date != null){
            //     // Check if member's gym access has expired
            //     $today = now()->startOfDay();
            //     $gymAccessEndDate = $member->gym_access_end_date ? \Carbon\Carbon::parse($member->gym_access_end_date)->startOfDay() : null;
            //     $membershipEndDate = $member->membership_end_date ? \Carbon\Carbon::parse($member->membership_end_date)->startOfDay() : null;
                
            //     if (!$gymAccessEndDate || $today->gt($gymAccessEndDate)) {
            //         return redirect()->back()
            //             ->with('error', "This member's gym access term has expired. Please renew to proceed.")
            //             ->withInput();
            //     }
            //     else if (!$membershipEndDate || $today->gt($membershipEndDate)) {
            //         return redirect()->back()
            //             ->with('error', "This member's membership has expired. Please renew to proceed.")
            //             ->withInput();
            //     }
            // }

            $upgradeGymAccess = $validated['upgrade_gym_access'] ? 1 : 0;

            $purposeOfVisit = $request->input('purpose_of_visit', []);
            $items = $request->input('items', []);
            $tShirts = $request->input('t_shirts', []);
            
            // Combine items and t-shirts into a single array for storage
            $allItems = array_merge($items, $tShirts);
            
            // Remove duplicate items and reindex array
            $allItems = array_values(array_unique($allItems));
            
            DailyLog::create([
                'date' => $validated['date'],
                'time_in' => $validated['time_in'],
                'time_out' => $validated['time_out'] ?? null,
                'white_noise_id' => $validated['white_noise_id_form'],
                'full_name' => $member->full_name,
                'payment_method' => $validated['payment_method'],
                'payment_amount' => $validated['payment_amount'],
                'purpose_of_visit' => $purposeOfVisit,
                'staff_assigned' => $validated['staff_assigned'],
                'upgrade_gym_access' => $upgradeGymAccess,
                'notes' => $validated['notes'],
                'items_bought' => $allItems,
                'member_type' => $validated['member_type'],
                'gym_access' => $validated['gym_access'],
                'personal_trainer' => $validated['personal_trainer']
            ]);

            $isGymAccess = in_array('Gym Access Payment', $purposeOfVisit);
            $isPersonalTrainer = in_array('Personal Trainer Payment', $purposeOfVisit);
            $isRenewMembership = in_array('Renew Membership', $purposeOfVisit);
            $isRenewGymAccess = in_array('Renew Gym Access', $purposeOfVisit);
            $isRenewPT = in_array('Renew Personal Trainer', $purposeOfVisit);

            if ($validated['gym_access'] == 'None') {
                $member->update([
                    'gym_access_start_date' => null,
                    'gym_access_end_date' => null,
                ]);
            }
            else if ($isGymAccess && $validated['gym_access'] == '1 month') {
                $member->update([
                    'gym_access_start_date' => now()->toDateString(),
                    'gym_access_end_date' => Carbon::parse($member->gym_access_end_date)->addDays(30)->toDateString(),
                ]);
            }
            else if ($isGymAccess && $validated['gym_access'] == '3 months') {
                $member->update([
                    'gym_access_start_date' => now()->toDateString(),
                    'gym_access_end_date' => Carbon::parse($member->gym_access_end_date)->addDays(90)->toDateString(),
                ]);
            }
            else if ($isGymAccess && $validated['gym_access'] == 'Walk in') {
                $member->update([
                    'gym_access_start_date' => now()->toDateString(),
                    'gym_access_end_date' => null,
                ]);
            }

            if ($isPersonalTrainer) {
                $member->update([
                    'pt_start_date' => now()->toDateString(),
                    'pt_end_date' => Carbon::parse($member->pt_end_date)->addDays(365)->toDateString(),
                ]);
            }

            if ($isRenewMembership) {
                $member->update([
                    'membership_start_date' => now()->toDateString(),
                    'membership_end_date' => Carbon::parse($member->membership_end_date)->addDays(365)->toDateString(),
                ]);
            }
            
            else if($validated['gym_access'] == 'Walk in' && $isRenewGymAccess){
                $member->update([
                    'gym_access_start_date' => now()->toDateString(),
                    'gym_access_end_date' => null,
                ]);
            }
            else if($validated['gym_access'] == '1 month' && $isRenewGymAccess){
                $currentEndDate = $member->gym_access_end_date ? Carbon::parse($member->gym_access_end_date) : null;
                $isExpired = !$currentEndDate || $currentEndDate->isPast();
                
                $member->update([
                    'gym_access_start_date' => now()->toDateString(),
                    'gym_access_end_date' => $isExpired 
                        ? now()->addDays(30)->toDateString() 
                        : $currentEndDate->addDays(30)->toDateString(),
                ]);
            }
            else if($validated['gym_access'] == '3 months' && $isRenewGymAccess){
                $currentEndDate = $member->gym_access_end_date ? Carbon::parse($member->gym_access_end_date) : null;
                $isExpired = !$currentEndDate || $currentEndDate->isPast();
                
                $member->update([
                    'gym_access_start_date' => now()->toDateString(),
                    'gym_access_end_date' => $isExpired 
                        ? now()->addDays(90)->toDateString() 
                        : $currentEndDate->addDays(90)->toDateString(),
                ]);
            }
            
            if($validated['personal_trainer'] == 'None' && $isRenewPT){
                $member->update([
                    'pt_start_date' => null,
                    'pt_end_date' => null,
                ]);
            }
            else if($validated['personal_trainer'] == '1 month' && $isRenewPT){
                $currentEndDate = $member->pt_end_date ? Carbon::parse($member->pt_end_date) : null;
                $isExpired = !$currentEndDate || $currentEndDate->isPast();
                
                $member->update([
                    'pt_start_date' => now()->toDateString(),
                    'pt_end_date' => $isExpired 
                        ? now()->addDays(30)->toDateString() 
                        : $currentEndDate->addDays(30)->toDateString(),
                ]);
            }

            $member->update([
                'member_type' => $validated['member_type'],
                'membership_term_gym_access' => $validated['gym_access'],
                'with_pt' => $validated['personal_trainer'],
            ]);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add daily log: ' . $e->getMessage());
        }
        return redirect()->route('get-daily-logs')->with('success', 'Daily log added successfully!');
    }
    public function getDailyLogs()
    {
        $start_date = now()->toDateString();
        $end_date = now()->toDateString();
        
        $dailyLogs = DailyLog::with('member')
            ->whereDate('date', $start_date)
            ->orderBy('time_in', 'desc')
            ->paginate(10);
        $totalSales = DailyLog::whereBetween('date', [$start_date, $end_date])
            ->sum('payment_amount');
    
        return view('pages.daily-logs', compact('dailyLogs', 'start_date', 'end_date', 'totalSales'));
    }
    
    public function filterDailyLogs(Request $request)
    {
        try {
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $start_date = $validated['start_date'];
            $end_date = $validated['end_date'];

            $dailyLogs = DailyLog::with('member')
                ->whereBetween('date', [$start_date, $end_date])
                ->orderBy('date', 'desc')
                ->orderBy('time_in', 'desc')
                ->paginate(10);
            
            $totalSales = DailyLog::whereBetween('date', [$start_date, $end_date])
                ->sum('payment_amount');

            return view('pages.daily-logs', compact('dailyLogs', 'start_date', 'end_date', 'totalSales'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid date range. Please try again.');
        }
    }  

    public function updateDailyLog(Request $request, $id)
    {
        try {
            // Convert checkbox value to proper boolean
            $request->merge([
                'upgrade_gym_access' => $request->has('upgrade_gym_access')
            ]);

            $validated = $request->validate([
                'date' => 'required|date',
                'time_in' => 'required|date_format:H:i',
                'time_out' => 'nullable|date_format:H:i',
                'white_noise_id_form' => 'required|exists:members,white_noise_id',
                'payment_method' => 'required|in:None,Cash,GCash,Bank Transfer',
                'payment_amount' => 'required|integer|min:0',
                'purpose_of_visit' => 'required|array',
                'staff_assigned' => 'required|string|max:255',
                'upgrade_gym_access' => 'required|boolean',
                'items' => 'nullable|array',
                'notes' => 'nullable|string',
                'member_type' => 'required|in:Regular,Student',
                'gym_access' => 'required|in:None,1 month,3 months,Walk in',
                'personal_trainer' => 'required|in:None,1 month'
            ]);

            $staffUser = User::where('username', 'staff_access')->first();

            // Verify staff password using Hash::check to compare against hashed password
            if (!$staffUser || $request->password !== $staffUser->password) {
                return redirect()->back()->with('error', 'Incorrect staff password. Update cancelled.');
            }

            // Prepare additional / transformed data that are not part of the validator keys
            $purposeOfVisit = $request->input('purpose_of_visit', []);
            $items = $request->input('items', []);
            $tShirts = $request->input('t_shirts', []);
            $allItems = array_values(array_unique(array_merge($items, $tShirts)));

            $dailyLog = DailyLog::findOrFail($id);
            $dailyLog->update([
                'date' => $validated['date'],
                'time_in' => $validated['time_in'],
                'time_out' => $validated['time_out'] ?? null,
                'white_noise_id' => $validated['white_noise_id_form'],
                'payment_method' => $validated['payment_method'],
                'payment_amount' => $validated['payment_amount'],
                'purpose_of_visit' => $purposeOfVisit,
                'staff_assigned' => $validated['staff_assigned'],
                'upgrade_gym_access' => $validated['upgrade_gym_access'] ? 1 : 0,
                'notes' => $validated['notes'],
                'items_bought' => $allItems,
                'member_type' => $validated['member_type'],
                'gym_access' => $validated['gym_access'],
                'personal_trainer' => $validated['personal_trainer']
            ]);

            // session()->flash('success', 'Daily log updated successfully!');
            return redirect()->route('get-daily-logs')->with('success', 'Daily log updated successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update daily log: ' . $e->getMessage());
        }
    }   

    public function deleteDailyLog(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        // Find the admin user and verify the password
        $adminUser = User::where('username', 'admin_access')->first();
        
        if (!$adminUser || $adminUser->password !== $request->password) {
            return redirect()->back()->with('error', 'Incorrect admin password. Deletion cancelled.');
        }

        $dailyLog = DailyLog::findOrFail($id);
        $dailyLog->delete();
        
        return redirect()->route('get-daily-logs')->with('success', 'Daily log deleted successfully!');
    }

    public function updateTimeOut(Request $request, $id)
    {
        $request->validate([
            'time_out_status' => 'required|in:time_out,in_session'
        ]);

        $dailyLog = DailyLog::findOrFail($id);
        
        if ($request->time_out_status === 'time_out') {
            $dailyLog->time_out = now();
        } else {
            $dailyLog->time_out = null;
        }
        
        $dailyLog->save();

        return redirect()->route('get-daily-logs')->with('success', 'Time out updated successfully!');
    }
}

