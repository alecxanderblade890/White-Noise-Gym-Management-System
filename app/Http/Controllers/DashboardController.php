<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyLog;
use App\Models\Member;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {

            $today = Carbon::now()->toDateString();
            
            // Get total sales for today
            $totalSalesToday = DailyLog::whereDate('date', $today)->sum('payment_amount');
            $itemPrices = [
                'Pocari Sweat' => 50,
                'Gatorade Blue' => 65,
                'Gatorade Red' => 65,
                'Bottled Water' => 20,
                'White - Large' => 350,
                'White - XL' => 350,
                'Black - Large' => 350,
                'Black - XL' => 350,
                'Black - XS' => 300,
                'Black - Medium' => 300
            ];
    
            $itemSales = DailyLog::whereDate('date', $today)
                        ->whereNotNull('items_bought')
                        ->get()
                        ->flatMap(function($log) use ($itemPrices) {
                            // If it's a JSON string, decode it, otherwise use as is
                            $items = is_string($log->items_bought) 
                                ? json_decode($log->items_bought, true) 
                                : $log->items_bought;
                                
                            // Ensure we have an array and filter out any empty values
                            return is_array($items) ? array_filter($items) : [];
                        });
            $totalItemsSalesCount = $itemSales->count();
            $totalItemsSalesAmount = 0;
            foreach ($itemSales as $item) {
                if (isset($itemPrices[$item])) {
                    $totalItemsSalesAmount += $itemPrices[$item];
                }
            }
        
            // Get total sales by payment mode for today
            $cashTotal = DailyLog::whereDate('date', $today)
                ->where('payment_method', 'Cash')
                ->sum('payment_amount');
                
            $gcashTotal = DailyLog::whereDate('date', $today)
                ->where('payment_method', 'GCash')
                ->sum('payment_amount');
                
            $bankTransferTotal = DailyLog::whereDate('date', $today)
                ->where('payment_method', 'Bank Transfer')
                ->sum('payment_amount');

            $totalClientsToday = DailyLog::whereDate('date', $today)
                ->select('white_noise_id')
                ->distinct()
                ->count();

            $totalWalkinSalesTodayStudent = DailyLog::whereDate('date', $today)
                ->where('gym_access', 'Walk in')
                ->whereJsonContains('purpose_of_visit', 'Gym Use')
                ->where('member_type', 'Student')
                ->get();
                
            $totalWalkinSalesTodayRegular = DailyLog::whereDate('date', $today)
                ->where('gym_access', 'Walk in')
                ->whereJsonContains('purpose_of_visit', 'Gym Use')
                ->where('member_type', 'Regular')
                ->get();
                
            $totalWalkinSalesTodayStudentCount = $totalWalkinSalesTodayStudent->count();
            $totalWalkinSalesTodayRegularCount = $totalWalkinSalesTodayRegular->count();
            
            $totalWalkinSalesTodayStudentAmount = $totalWalkinSalesTodayStudentCount * 100;
            $totalWalkinSalesTodayRegularAmount = $totalWalkinSalesTodayRegularCount * 150;

            $totalWalkinSalesTodayAmount = $totalWalkinSalesTodayStudentAmount + $totalWalkinSalesTodayRegularAmount;
            
            $totalNewMemberships = Member::whereDate('membership_start_date', $today)->count();
            
            // Count new gym access based on payment dates
            $totalNewGymAccess = 0;
            $members = Member::whereNotNull('payment_history')->get();
            
            foreach ($members as $member) {
                if (empty($member->payment_history)) {
                    continue;
                }

                foreach ($member->payment_history as $payment) {
                    $paymentDate = Carbon::parse($payment['date']);
                    if ($paymentDate->isToday() && 
                        in_array($payment['amount'], [1000, 1500, 2500, 4000])) {
                        $totalNewGymAccess++;
                        break; // Count each member only once per day
                    }
                }
            }

            // Calculate total new gym access amount based on payment history
            $totalNewGymAccessAmount = 0;
            $members = Member::whereNotNull('payment_history')->get();
            
            foreach ($members as $member) {
                if (empty($member->payment_history)) {
                    continue;
                }

                foreach ($member->payment_history as $payment) {
                    $paymentDate = Carbon::parse($payment['date']);
                    if ($paymentDate->isToday()) {
                        $amount = $payment['amount'];
                        if (in_array($amount, [1000, 1500, 2500, 4000])) {
                            $totalNewGymAccessAmount += $amount;
                        }
                    }
                }
            }
            
            $totalNewPersonalTrainer = Member::whereDate('pt_start_date', $today)->count();
            // Get current date and 7 days from now
            $now = Carbon::now();
            $sevenDaysFromNow = $now->copy()->addDays(7);
            
            // Get members with active memberships that are expiring in 7 days or less
            $membersExpiring = Member::where(function($query) use ($now, $sevenDaysFromNow) {
                // Check for memberships expiring in the next 7 days
                $query->where(function($q) use ($now, $sevenDaysFromNow) {
                    $q->where('membership_end_date', '>=', $now)
                    ->where('membership_end_date', '<=', $sevenDaysFromNow);
                })->orWhere(function($q) use ($now, $sevenDaysFromNow) {
                    $q->where('gym_access_end_date', '>=', $now)
                    ->where('gym_access_end_date', '<=', $sevenDaysFromNow);
                })->orWhere(function($q) use ($now, $sevenDaysFromNow) {
                    $q->where('pt_end_date', '>=', $now)
                    ->where('pt_end_date', '<=', $sevenDaysFromNow);
                });
            })->orderBy('membership_end_date', 'asc')
            ->paginate(5);

            $membersExpired = Member::where(function($query) use ($now) {
                // Show members where any membership type is expired
                $query->where('membership_end_date', '<', $now)
                    ->orWhere('gym_access_end_date', '<', $now)
                    ->orWhere('pt_end_date', '<', $now);
            })->orderBy('membership_end_date', 'asc')
            ->paginate(5);

            return view('pages.dashboard', [
                'totalSalesToday'       => $totalSalesToday,
                'cashTotal'             => $cashTotal,
                'gcashTotal'            => $gcashTotal,
                'bankTransferTotal'     => $bankTransferTotal,
                'totalClientsToday'     => $totalClientsToday,
                'totalNewMemberships'   => $totalNewMemberships,
                'totalNewGymAccess'     => $totalNewGymAccess,
                'totalNewGymAccessAmount' => $totalNewGymAccessAmount,
                'totalWalkinSalesTodayAmount' => $totalWalkinSalesTodayAmount,
                'totalNewPersonalTrainer' => $totalNewPersonalTrainer,
                'totalItemsSalesAmount' => $totalItemsSalesAmount,
                'totalItemsSalesCount' => $totalItemsSalesCount,
                'membersExpiring'       => $membersExpiring,
                'membersExpired'        => $membersExpired,
                'now'                   => $now,
                'sevenDaysFromNow'      => $sevenDaysFromNow,
            ]);
    }
}
