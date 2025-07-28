<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\DailyLog;
use App\Models\Member;

class DailyLogController extends Controller
{

    public function addDailyLog(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i',
            'member_id' => 'required|integer|exists:members,id',
            'payment_method' => 'required|in:cash,card,online',
            'payment_amount' => 'required|integer|min:0',
            'purpose_of_visit' => 'required|string|max:255',
            'staff_assigned' => 'required|string|max:255',
            'upgrade_gym_access' => 'required|in:yes,no',
            'notes' => 'required|string',
        ]);

        try {
            // Get the member first
            $member = Member::findOrFail($validated['member_id']);

            $upgradeGymAccess = $validated['upgrade_gym_access'] === 'yes' ? 1 : 0;

            DailyLog::create([
                'date' => $validated['date'],
                'time_in' => $validated['time_in'],
                'time_out' => $validated['time_out'],
                'member_id' => $validated['member_id'],
                'full_name' => $member->full_name,
                'membership_term_gym_access' => $member->membership_term_gym_access,
                'payment_method' => $validated['payment_method'],
                'payment_amount' => $validated['payment_amount'],
                'purpose_of_visit' => $validated['purpose_of_visit'],
                'staff_assigned' => $validated['staff_assigned'],
                'upgrade_gym_access' => $upgradeGymAccess,
                'notes' => $validated['notes'],
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
        $dailyLogs = DailyLog::all();
        return view('pages.daily-logs', compact('dailyLogs'));
    }

    public function deleteDailyLog(Request $request)
    {
        $dailyLog = DailyLog::find($request->id);
        if ($dailyLog) {
            $dailyLog->delete();
            return redirect()->route('get-daily-logs')->with('success', 'Daily log deleted successfully!');
        }
        return redirect()->route('get-daily-logs')->with('error', 'Daily log not found!');
    }
}

