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
        try {
            $today = Carbon::now()->toDateString();
            
            // Get total sales for today
            $totalSalesToday = DailyLog::whereDate('date', $today)->sum('payment_amount');
        
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

            $totalClientsToday = DailyLog::whereDate('date', $today)->count();
            $totalItemsSoldToday = DailyLog::whereDate('date', $today)->sum('payme');
            
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
            ->get();

            $membersExpired = Member::where(function($query) use ($now) {
                // Show members where any membership type is expired
                $query->where('membership_end_date', '<', $now)
                    ->orWhere('gym_access_end_date', '<', $now)
                    ->orWhere('pt_end_date', '<', $now);
            })->orderBy('membership_end_date', 'asc')
            ->get();

            return view('pages.dashboard', [
                'totalSalesToday'       => $totalSalesToday,
                'cashTotal'             => $cashTotal,
                'gcashTotal'            => $gcashTotal,
                'bankTransferTotal'     => $bankTransferTotal,
                'totalClientsToday'     => $totalClientsToday,
                'membersExpiring'       => $membersExpiring,
                'membersExpired'        => $membersExpired,
                'now'                   => $now,
                'sevenDaysFromNow'      => $sevenDaysFromNow,
            ]);
        } catch (\Exception $e) {
            return view('pages.dashboard', [
                'errors'                => $e->getMessage(),
            ]);
        }
    }
}
