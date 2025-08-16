<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\DailyLog;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        
        $startDate = $request->input('start_date', $today->format('Y-m-d'));
        $endDate = $request->input('end_date', $today->format('Y-m-d'));

        // Convert string dates to Carbon instances for consistency
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        // Query for memberships created in the date range
        $memberships = Member::whereBetween('created_at', [$startDate, $endDate])->get();
        
        // Initialize counters
        $membershipsOnlyCount = 0;
        $walkInRegularCount = 0;
        $walkInStudentCount = 0;
        $oneMonthRegularCount = 0;
        $oneMonthStudentCount = 0;
        $threeMonthsRegularCount = 0;
        $threeMonthsStudentCount = 0;
        
        // Categorize members
        foreach ($memberships as $member) {
            if ($member->membership_term_gym_access === 'Walk in') {
                if ($member->member_type === 'Regular') {
                    $walkInRegularCount++;
                } else {
                    $walkInStudentCount++;
                }
            } elseif ($member->membership_term_gym_access === '1 month') {
                if ($member->member_type === 'Regular') {
                    $oneMonthRegularCount++;
                } else {
                    $oneMonthStudentCount++;
                }
            } elseif ($member->membership_term_gym_access === '3 months') {
                if ($member->member_type === 'Regular') {
                    $threeMonthsRegularCount++;
                } else {
                    $threeMonthsStudentCount++;
                }
            } else {
                $membershipsOnlyCount++;
            }
        }

        // Query for daily logs in the date range
        $dailyLogs = DailyLog::whereBetween('date', [$startDate, $endDate])->get();
        
        // Initialize walk-in and gym access counters
        $walkInStudentsCount = 0;
        $walkInRegularTotalCount = 0;
        $regularOneMonthCount = 0;
        $regularThreeMonthsCount = 0;
        $studentOneMonthCount = 0;
        $studentThreeMonthsCount = 0;
        
        foreach ($dailyLogs as $log) {
            $member = $log->member;
            
            if ($log->purpose_of_visit === 'Gym Use' || 
                str_contains($log->purpose_of_visit, 'Gym Use')) {
                if ($member) {
                    if ($member->membership_term_gym_access === '1 month') {
                        if ($member->member_type === 'Regular') {
                            $regularOneMonthCount++;
                        } else {
                            $studentOneMonthCount++;
                        }
                    } elseif ($member->membership_term_gym_access === '3 months') {
                        if ($member->member_type === 'Regular') {
                            $regularThreeMonthsCount++;
                        } else {
                            $studentThreeMonthsCount++;
                        }
                    } elseif ($member->membership_term_gym_access === 'Walk in') {
                        if ($member->member_type === 'Regular') {
                            $walkInRegularTotalCount++;
                        } else {
                            $walkInStudentsCount++;
                        }
                    }
                }
            }
        }

        // Calculate amounts based on your pricing structure
        $membershipsOnlyAmount = $membershipsOnlyCount * 500; // Assuming 500 for membership only
        $walkInRegularAmount = $walkInRegularCount * 150;     // 150 per walk-in regular
        $walkInStudentAmount = $walkInStudentCount * 100;     // 100 per walk-in student
        $oneMonthRegularAmount = $oneMonthRegularCount * 1500; // 1500 for 1 month regular
        $oneMonthStudentAmount = $oneMonthStudentCount * 1000; // 1000 for 1 month student
        $threeMonthsRegularAmount = $threeMonthsRegularCount * 4500; // 4500 for 3 months regular
        $threeMonthsStudentAmount = $threeMonthsStudentCount * 2500; // 2500 for 3 months student
        $walkInStudentsAmount = $walkInStudentsCount * 100;   // 100 per student walk-in
        $walkInRegularTotalAmount = $walkInRegularTotalCount * 150; // 150 per regular walk-in
        $regularOneMonthAmount = $regularOneMonthCount * 1500; // 1500 for regular 1 month
        $regularThreeMonthsAmount = $regularThreeMonthsCount * 4500; // 4500 for regular 3 months
        $studentOneMonthAmount = $studentOneMonthCount * 1000; // 1000 for student 1 month
        $studentThreeMonthsAmount = $studentThreeMonthsCount * 2500; // 2500 for student 3 months

        // Calculate totals
        $totalClients = $membershipsOnlyCount + $walkInRegularCount + $walkInStudentCount + 
                       $oneMonthRegularCount + $oneMonthStudentCount + 
                       $threeMonthsRegularCount + $threeMonthsStudentCount +
                       $walkInStudentsCount + $walkInRegularTotalCount +
                       $regularOneMonthCount + $regularThreeMonthsCount +
                       $studentOneMonthCount + $studentThreeMonthsCount;

        $totalAmount = $membershipsOnlyAmount + $walkInRegularAmount + $walkInStudentAmount +
                      $oneMonthRegularAmount + $oneMonthStudentAmount +
                      $threeMonthsRegularAmount + $threeMonthsStudentAmount +
                      $walkInStudentsAmount + $walkInRegularTotalAmount +
                      $regularOneMonthAmount + $regularThreeMonthsAmount +
                      $studentOneMonthAmount + $studentThreeMonthsAmount;

        return view('pages.sales-report', [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'membershipsOnlyCount' => $membershipsOnlyCount,
            'membershipsOnlyAmount' => $membershipsOnlyAmount,
            'walkInRegularCount' => $walkInRegularCount,
            'walkInRegularAmount' => $walkInRegularAmount,
            'walkInStudentCount' => $walkInStudentCount,
            'walkInStudentAmount' => $walkInStudentAmount,
            'oneMonthRegularCount' => $oneMonthRegularCount,
            'oneMonthRegularAmount' => $oneMonthRegularAmount,
            'oneMonthStudentCount' => $oneMonthStudentCount,
            'oneMonthStudentAmount' => $oneMonthStudentAmount,
            'threeMonthsRegularCount' => $threeMonthsRegularCount,
            'threeMonthsRegularAmount' => $threeMonthsRegularAmount,
            'threeMonthsStudentCount' => $threeMonthsStudentCount,
            'threeMonthsStudentAmount' => $threeMonthsStudentAmount,
            'walkInStudentsCount' => $walkInStudentsCount,
            'walkInStudentsAmount' => $walkInStudentsAmount,
            'walkInRegularTotalCount' => $walkInRegularTotalCount,
            'walkInRegularTotalAmount' => $walkInRegularTotalAmount,
            'regularOneMonthCount' => $regularOneMonthCount,
            'regularOneMonthAmount' => $regularOneMonthAmount,
            'regularThreeMonthsCount' => $regularThreeMonthsCount,
            'regularThreeMonthsAmount' => $regularThreeMonthsAmount,
            'studentOneMonthCount' => $studentOneMonthCount,
            'studentOneMonthAmount' => $studentOneMonthAmount,
            'studentThreeMonthsCount' => $studentThreeMonthsCount,
            'studentThreeMonthsAmount' => $studentThreeMonthsAmount,
            'totalClients' => $totalClients,
            'totalAmount' => $totalAmount,
        ]);
    }
}
