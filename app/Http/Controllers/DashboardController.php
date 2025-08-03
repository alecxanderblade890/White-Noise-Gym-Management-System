<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyLog;
use App\Models\Member;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // $totalSalesToday = DailyLog::whereDate('date', now())->sum('payment_amount');
        
        // // Get the number of days from the request or default to 7
        // $days = $request->input('days', 7);
        // $days = min(max(1, (int)$days), 30); // Ensure days is between 1 and 30
        
        // // Get memberships expiring within the selected number of days (including today and the end day)
        // $startDate = Carbon::now()->startOfDay();
        // $endDate = Carbon::now()->addDays($days)->endOfDay();
        
        // $expiringMembers = Member::select('id', 'full_name', 'start_date', 'end_date')
        //     ->where('end_date', '>=', $startDate)
        //     ->where('end_date', '<=', $endDate)
        //     ->orderBy('end_date', 'asc')
        //     ->get();

        // $expiredMembers = Member::select('id', 'full_name', 'start_date', 'end_date')
        //     ->whereDate('end_date', '<', now())
        //     ->orderBy('end_date', 'asc')
        //     ->get();

        // return view('pages.dashboard', [
        //     'totalSalesToday' => $totalSalesToday,
        //     'expiringMembers' => $expiringMembers,
        //     'selectedDays' => $days,
        //     'expiredMembers' => $expiredMembers
        // ]);
        return view('pages.dashboard');
    }
}
