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

            $today = now()->startOfDay();

            if(!in_array('Membership Payment', $validated['purpose_of_visit']) &&
                !in_array('Renew Membership', $validated['purpose_of_visit']) && 
                !in_array('Gym Access Payment', $validated['purpose_of_visit']) && 
                !in_array('Renew Gym Access', $validated['purpose_of_visit']) && 
                !in_array('Personal Trainer Payment', $validated['purpose_of_visit']) && 
                !in_array('Renew Personal Trainer', $validated['purpose_of_visit'])){

                // Check gym access if it exists
                if ($member->gym_access_end_date) {
                    $gymAccessEndDate = \Carbon\Carbon::parse($member->gym_access_end_date)->startOfDay();
                    if ($today->gt($gymAccessEndDate)) {
                        return redirect()->back()
                            ->with('error', "This member's gym access term has expired. Please renew to proceed.")
                            ->withInput();
                    }
                }
                
                // Check membership if it exists
                if ($member->membership_end_date) {
                    $membershipEndDate = \Carbon\Carbon::parse($member->membership_end_date)->startOfDay();
                    if ($today->gt($membershipEndDate)) {
                        return redirect()->back()
                            ->with('error', "This member's membership has expired. Please renew to proceed.")
                            ->withInput();
                    }
                }
                
            }

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
            $isRemoveGymAccess = in_array('Remove Gym Access', $purposeOfVisit);
            $isRemovePT = in_array('Remove Personal Trainer', $purposeOfVisit);

            $paymentHistory = json_decode($member->payment_history, true) ?? [];

            if ($isRenewMembership) {
                $member->update([
                    'membership_start_date' => now()->toDateString(),
                    'membership_end_date' => Carbon::parse($member->membership_end_date)->addDays(365)->toDateString(),
                ]);
            }

            // Handle gym access updates
            if ($validated['gym_access'] === 'None' && $isRemoveGymAccess) {
                $member->update([
                    'gym_access_start_date' => null,
                    'gym_access_end_date' => null,
                ]);
            } 
            // Handle new gym access or renewals
            elseif ($isGymAccess || $isRenewGymAccess) {
                $updates = ['gym_access_start_date' => now()->toDateString()];
                
                if ($validated['gym_access'] === 'Walk in') {
                    $updates['gym_access_end_date'] = null;
                } else {
                    $daysToAdd = $validated['gym_access'] === '1 month' ? 30 : 90;
                    $currentEndDate = $member->gym_access_end_date ? Carbon::parse($member->gym_access_end_date) : null;
                    $isExpired = !$currentEndDate || $currentEndDate->isPast();
                    
                    $updates['gym_access_end_date'] = $isExpired
                        ? now()->addDays($daysToAdd)->toDateString()
                        : $currentEndDate->addDays($daysToAdd)->toDateString();
                }

                $newPaymentPurpose = '';
                $newPaymentAmount = 0;

                if($validated['gym_access'] === '1 month'){
                    $newPaymentPurpose = 'Gym Access 1 month';
                    $newPaymentAmount = $validated['member_type'] === 'Student' ? 1000: 1500; // Example amount for 1 month
                }
                else if($validated['gym_access'] === '3 months'){
                    $newPaymentPurpose = 'Gym Access 3 months';
                    $newPaymentAmount = $validated['member_type'] === 'Student' ? 2500: 4500; // Example amount for 3 months
                }
                $newPayment = [
                    'date' => now()->toDateString(), // Use the current date
                    'purpose' => $newPaymentPurpose,
                    'amount' => (int) $newPaymentAmount,
                ];

                // Append the new payment to the array
                $paymentHistory[] = $newPayment;
                // Re-encode the array back to JSON and add it to the validated data
                $updates['payment_history'] = json_encode($paymentHistory);
                
                $member->update($updates);
            }
            
            if($validated['personal_trainer'] == 'None' && $isRemovePT){
                $member->update([
                    'pt_start_date' => null,
                    'pt_end_date' => null,
                ]);
            }
            else if($validated['personal_trainer'] == '1 month' && ($isRenewPT || $isPersonalTrainer)){
                $currentEndDate = $member->pt_end_date ? Carbon::parse($member->pt_end_date) : null;
                $isExpired = !$currentEndDate || $currentEndDate->isPast();

                $paymentHistory[] = [
                    'date' => now()->toDateString(),
                    'purpose' => 'Personal Trainer 1 month',
                    'amount' => 3000, // Example amount for PT
                ];
                
                $member->update([
                    'pt_start_date' => now()->toDateString(),
                    'pt_end_date' => $isExpired 
                        ? now()->addDays(30)->toDateString() 
                        : $currentEndDate->addDays(30)->toDateString(),
                    'payment_history' => json_encode($paymentHistory),
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
    public function addDailyLogDayPass(Request $request){
        try {
            $validated = $request->validate([
                'date_day_pass' => 'required|date',
                'full_name_day_pass' => 'required|string',
                'time_in_day_pass' => 'required|date_format:H:i',
                'time_out_day_pass' => 'nullable|date_format:H:i',
                'payment_method_day_pass' => 'required|in:None,Cash,GCash,Bank Transfer',
                'payment_amount_day_pass' => 'required|integer|min:0',
                'staff_assigned_day_pass' => 'required|string',
            ]);

            $items = $request->input('items_day_pass', []);
            $tShirts = $request->input('t_shirts_day_pass', []);
            
            // Combine items and t-shirts into a single array for storage
            $allItems = array_merge($items, $tShirts);
            
            // Remove duplicate items and reindex array
            $allItems = array_values(array_unique($allItems));

            DailyLog::create([
                'date' => $validated['date_day_pass'],
                'time_in' => $validated['time_in_day_pass'],
                'time_out' => $validated['time_out_day_pass'] ?? null,
                'white_noise_id' => null,
                'full_name' => $validated['full_name_day_pass'],
                'payment_method' => $validated['payment_method_day_pass'],
                'payment_amount' => $validated['payment_amount_day_pass'],
                'purpose_of_visit' => ['Gym Use (Day Pass)'],
                'staff_assigned' => $validated['staff_assigned_day_pass'],
                'upgrade_gym_access' => false,
                'notes' => '',
                'items_bought' => $allItems,
                'member_type' => 'Regular',
                'gym_access' => 'None',
                'personal_trainer' => 'None'
            ]);
            return redirect()->route('get-daily-logs')->with('success', 'Daily log added successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add daily log: ' . $e->getMessage());
        }
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

    public function updateDailyLogDayPass(Request $request, $id){
        try {
            $validated = $request->validate([
                'date_day_pass' => 'required|date',
                'time_in_day_pass' => 'required|date_format:H:i',
                'time_out_day_pass' => 'nullable|date_format:H:i',
                'full_name_day_pass' => 'required|string|max:255',
                'payment_method_day_pass' => 'required|in:None,Cash,GCash,Bank Transfer',
                'payment_amount_day_pass' => 'required|integer|min:0',
                'staff_assigned_day_pass' => 'required|string|max:255',
                'items_day_pass' => 'nullable|array',
                't_shirts_day_pass' => 'nullable|array',
                'notes_day_pass' => 'nullable|string',
            ]);

            $staffUser = User::where('username', 'staff_access')->first();

            // Verify staff password using Hash::check to compare against hashed password
            if (!$staffUser || $request->password !== $staffUser->password) {
                return redirect()->back()->with('error', 'Incorrect staff password. Update cancelled.');
            }

            $dailyLog = DailyLog::findOrFail($id);
            $items = $request->input('items_day_pass', []);
            $tShirts = $request->input('t_shirts_day_pass', []);
            
            // Combine items and t-shirts into a single array for storage
            $allItems = array_merge($items, $tShirts);
            
            // Remove duplicate items and reindex array
            $allItems = array_values(array_unique($allItems));

            $dailyLog->update([
                'date' => $validated['date_day_pass'],
                'time_in' => $validated['time_in_day_pass'],
                'time_out' => $validated['time_out_day_pass'] ?? null,
                'full_name' => $validated['full_name_day_pass'],
                'payment_method' => $validated['payment_method_day_pass'],
                'payment_amount' => $validated['payment_amount_day_pass'],
                'purpose_of_visit' => ['Gym Use (Day Pass)'],
                'staff_assigned' => $validated['staff_assigned_day_pass'],
                'notes' => $validated['notes_day_pass'],
                'items_bought' => $allItems,
            ]);

            return redirect()->route('get-daily-logs')->with('success', 'Daily log updated successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update daily log: ' . $e->getMessage());
        }
    }

    public function deleteDailyLog(Request $request, $id){
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
