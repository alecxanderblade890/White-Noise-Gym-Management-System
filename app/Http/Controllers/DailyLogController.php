<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\DailyLog;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DailyLogController extends Controller
{

    public function addDailyLog(Request $request)
    {
        // Convert checkbox value to proper boolean
        $request->merge([
            'upgrade_gym_access' => $request->has('upgrade_gym_access')
        ]);

        $validated = $request->validate([
            'date' => 'required|date',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            'form_member_id' => 'required|integer|exists:members,id',
            'payment_method' => 'required|in:Cash,GCash,Bank Transfer',
            'payment_amount' => 'required|integer|min:0',
            'purpose_of_visit' => 'required|string|max:255',
            'staff_assigned' => 'required|string|max:255',
            'upgrade_gym_access' => 'required|boolean',
            'items' => 'nullable|array',
            'notes' => 'nullable|string'
        ]); 

        try {
            // Get the member first
            $member = Member::findOrFail($validated['form_member_id']);

            // Check if member's gym access has expired
            $today = now()->startOfDay();
            $gymAccessEndDate = $member->gym_access_end_date ? \Carbon\Carbon::parse($member->gym_access_end_date)->startOfDay() : null;
            $membershipEndDate = $member->membership_end_date ? \Carbon\Carbon::parse($member->membership_end_date)->startOfDay() : null;
            
            if (!$gymAccessEndDate || $today->gt($gymAccessEndDate)) {
                return redirect()->back()
                    ->with('error', "This member's gym access term has expired. Please renew to proceed.")
                    ->withInput();
            }
            else if (!$membershipEndDate || $today->gt($membershipEndDate)) {
                return redirect()->back()
                    ->with('error', "This member's membership has expired. Please renew to proceed.")
                    ->withInput();
            }

            $upgradeGymAccess = $validated['upgrade_gym_access'] ? 1 : 0;

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
                'member_id' => $validated['form_member_id'],
                'full_name' => $member->full_name,
                'payment_method' => $validated['payment_method'],
                'payment_amount' => $validated['payment_amount'],
                'purpose_of_visit' => $validated['purpose_of_visit'],
                'staff_assigned' => $validated['staff_assigned'],
                'upgrade_gym_access' => $upgradeGymAccess,
                'notes' => $validated['notes'],
                'items_bought' => $allItems
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
    
        return view('pages.daily-logs', compact('dailyLogs', 'start_date', 'end_date'));
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

            return view('pages.daily-logs', compact('dailyLogs', 'start_date', 'end_date'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid date range. Please try again.');
        }
    }  

    public function updateDailyLog(Request $request, $id)
    {
        // Convert checkbox value to proper boolean
        $request->merge([
            'upgrade_gym_access' => $request->has('upgrade_gym_access')
        ]);

        $validated = $request->validate([
            'date' => 'required|date',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            'form_member_id' => 'required|integer|exists:members,id',
            'payment_method' => 'required|in:Cash,GCash,Bank Transfer',
            'payment_amount' => 'required|integer|min:0',
            'purpose_of_visit' => 'required|string|max:255',
            'staff_assigned' => 'required|string|max:255',
            'upgrade_gym_access' => 'required|boolean',
            'items' => 'nullable|array',
            'notes' => 'nullable|string'
        ]);

        try {

            $staffUser = User::where('username', 'staff_access')->first();

            // Verify staff password using Hash::check to compare against hashed password
            if (!$staffUser || $request->password !== $staffUser->password) {
                return redirect()->back()->with('error', 'Incorrect staff password. Update cancelled.');
            }

            // Prepare additional / transformed data that are not part of the validator keys
            $items = $request->input('items', []);
            $tShirts = $request->input('t_shirts', []);
            $allItems = array_values(array_unique(array_merge($items, $tShirts)));

            $dailyLog = DailyLog::findOrFail($id);
            $dailyLog->update([
                'date' => $validated['date'],
                'time_in' => $validated['time_in'],
                'time_out' => $validated['time_out'] ?? null,
                'member_id' => $validated['form_member_id'],
                'payment_method' => $validated['payment_method'],
                'payment_amount' => $validated['payment_amount'],
                'purpose_of_visit' => $validated['purpose_of_visit'],
                'staff_assigned' => $validated['staff_assigned'],
                'upgrade_gym_access' => $validated['upgrade_gym_access'] ? 1 : 0,
                'notes' => $validated['notes'],
                'items_bought' => $allItems
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

