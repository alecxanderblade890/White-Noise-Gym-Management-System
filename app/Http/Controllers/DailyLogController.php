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
        $validated = $request->validate([
            'date' => 'required|date',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
            'member_id' => 'required|integer|exists:members,id',
            'payment_method' => 'required|in:Gcash,Card,Bank Transfer',
            'payment_amount' => 'required|integer|min:0',
            'purpose_of_visit' => 'required|string|max:255',
            'staff_assigned' => 'required|string|max:255',
            'upgrade_gym_access' => 'required|in:yes,no',
            'items' => 'nullable|array',
            'custom_item' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        try {
            // Get the member first
            $member = Member::findOrFail($validated['member_id']);

            // Check if member's gym access has expired
            $today = now()->startOfDay();
            $gymAccessEndDate = $member->gym_access_end_date ? \Carbon\Carbon::parse($member->gym_access_end_date)->startOfDay() : null;
            
            if (!$gymAccessEndDate || $today->gt($gymAccessEndDate)) {
                return redirect()->back()
                    ->withErrors(['member_id' => "This member's gym access term has expired. Please renew their gym access term."])
                    ->withInput();
            }

            $upgradeGymAccess = $validated['upgrade_gym_access'] === 'yes' ? 1 : 0;

            $items = $request->input('items', []);
            $tShirts = $request->input('t_shirts', []);

            // Check if a custom item was provided and add it to the items array
            if ($request->filled('custom_item')) {
                $items[] = $request->input('custom_item');
            }
            
            // Combine items and t-shirts into a single array for storage
            $allItems = array_merge($items, $tShirts);
            
            // Remove duplicate items and reindex array
            $allItems = array_values(array_unique($allItems));
            
            DailyLog::create([
                'date' => $validated['date'],
                'time_in' => $validated['time_in'],
                'time_out' => $validated['time_out'] ?? null,
                'member_id' => $validated['member_id'],
                'full_name' => $member->full_name,
                'payment_method' => $validated['payment_method'],
                'payment_amount' => $validated['payment_amount'],
                'purpose_of_visit' => $validated['purpose_of_visit'],
                'staff_assigned' => $validated['staff_assigned'],
                'upgrade_gym_access' => $upgradeGymAccess,
                'notes' => $validated['notes'],
                'items_bought' => $allItems
            ]);
            
            session()->flash('success', 'Daily Log added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to add daily log: ' . $e->getMessage()])
                ->withInput();
        }
        return redirect()->route('get-daily-logs')->with('success', 'Log added successfully!');
    }
    public function getDailyLogs()
    {
        $dailyLogs = DailyLog::with('member')->get();
        return view('pages.daily-logs', compact('dailyLogs'));
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

