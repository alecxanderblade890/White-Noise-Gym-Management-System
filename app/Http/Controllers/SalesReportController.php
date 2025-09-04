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
        $memberships = Member::whereBetween('membership_start_date', [$startDate, $endDate])->get();

        $studentMemberships1month = Member::whereDate('gym_access_start_date', '>=', $startDate)
            ->whereDate('gym_access_start_date', '<=', $endDate)
            ->where('member_type', 'Student')
            ->where('membership_term_gym_access', '1 month')
            ->get();
        $studentMemberships3month = Member::whereDate('gym_access_start_date', '>=', $startDate)
            ->whereDate('gym_access_start_date', '<=', $endDate)
            ->where('member_type', 'Student')
            ->where('membership_term_gym_access', '3 months')
            ->get();
        $regularMemberships1month = Member::whereDate('gym_access_start_date', '>=', $startDate)
            ->whereDate('gym_access_start_date', '<=', $endDate)
            ->where('member_type', 'Regular')
            ->where('membership_term_gym_access', '1 month')
            ->get();
        $regularMemberships3month = Member::whereDate('gym_access_start_date', '>=', $startDate)
            ->whereDate('gym_access_start_date', '<=', $endDate)
            ->where('member_type', 'Regular')
            ->where('membership_term_gym_access', '3 months')
            ->get();

        $walkinMembershipsStudent = Member::whereDate('gym_access_start_date', '>=', $startDate)
            ->whereDate('gym_access_start_date', '<=', $endDate)
            ->where('member_type', 'Student')
            ->where('membership_term_gym_access', 'Walk in')
            ->get();
        $walkinMembershipsRegular = Member::whereDate('gym_access_start_date', '>=', $startDate)
            ->whereDate('gym_access_start_date', '<=', $endDate)
            ->where('member_type', 'Regular')
            ->where('membership_term_gym_access', 'Walk in')
            ->get();

        $ptSales1month = Member::whereDate('pt_start_date', '>=', $startDate)
            ->whereDate('pt_start_date', '<=', $endDate)
            ->where('with_pt', '1 month')
            ->get();
        $ptSales1day = DailyLog::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->whereJsonContains('purpose_of_visit', 'Personal Trainer 1 Day')
            ->get();
        $walkinsDailyStudent = DailyLog::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->where('gym_access', 'Walk in')
            ->where('member_type', 'Student')
            ->whereJsonContains('purpose_of_visit', 'Gym Use')
            ->get();
        $walkinsDailyRegular = DailyLog::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->where('gym_access', 'Walk in')
            ->where('member_type', 'Regular')
            ->whereJsonContains('purpose_of_visit', 'Gym Use')
            ->get();
    
        $dayPasses = DailyLog::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->whereJsonContains('purpose_of_visit', 'AA')
            ->get();

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

        $itemSales = DailyLog::whereDate('date', '>=', $startDate)
                    ->whereDate('date', '<=', $endDate)
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

        $totalItemsSalesAmount = 0;
        foreach ($itemSales as $item) {
            if (isset($itemPrices[$item])) {
                $totalItemsSalesAmount += $itemPrices[$item];
            }
        }

        $membershipCount = $memberships->count();
        $studentMembershipsCount = $studentMemberships1month->count();
        $studentMemberships3monthCount = $studentMemberships3month->count();
        $regularMembershipsCount = $regularMemberships1month->count();
        $regularMemberships3monthCount = $regularMemberships3month->count();
        $walkinMembershipsStudentCount = $walkinMembershipsStudent->count();
        $walkinMembershipsRegularCount = $walkinMembershipsRegular->count();
        $ptSales1monthCount = $ptSales1month->count();
        $ptSales1dayCount = $ptSales1day->count();
        $walkinsDailyStudentCount = $walkinsDailyStudent->count();
        $walkinsDailyRegularCount = $walkinsDailyRegular->count();
        $dayPassesCount = $dayPasses->count();

        $totalMembershipAmount = $membershipCount * 500;
        $totalStudentMemberships1monthAmount = $studentMemberships1month->count() * 1000;
        $totalStudentMemberships3monthAmount = $studentMemberships3month->count() * 2500;
        $totalRegularMemberships1monthAmount = $regularMemberships1month->count() * 1500;
        $totalRegularMemberships3monthAmount = $regularMemberships3month->count() * 4500;

        $totalWalkinMembershipsStudentAmount = $walkinMembershipsStudent->count() * 100;
        $totalWalkinMembershipsRegularAmount = $walkinMembershipsRegular->count() * 150;

        $totalWalkinsDailyStudentAmount = $walkinsDailyStudent->count() * 100;
        $totalWalkinsDailyRegularAmount = $walkinsDailyRegular->count() * 150;

        $totalPTSales1monthAmount = $ptSales1month->count() * 3000;
        $totalPTSales1dayAmount = $ptSales1day->count() * 300;

        $totalDayPassesAmount = $dayPasses->count() * 200;

        $totalAmount = $totalMembershipAmount + $totalStudentMemberships1monthAmount + $totalStudentMemberships3monthAmount + $totalRegularMemberships1monthAmount + $totalRegularMemberships3monthAmount + $totalWalkinMembershipsStudentAmount + $totalWalkinMembershipsRegularAmount + $totalPTSales1monthAmount + $totalPTSales1dayAmount + $totalItemsSalesAmount + $totalWalkinsDailyStudentAmount + $totalWalkinsDailyRegularAmount + $totalDayPassesAmount;
        $totalClients = $membershipCount + $studentMembershipsCount + $studentMemberships3monthCount + $regularMembershipsCount + $regularMemberships3monthCount + $walkinMembershipsStudentCount + $walkinMembershipsRegularCount + $ptSales1monthCount + $ptSales1dayCount + $walkinsDailyStudentCount + $walkinsDailyRegularCount + $dayPassesCount;

        return view('pages.sales-report', [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'membershipCount' => $membershipCount,
            'studentMembershipsCount' => $studentMembershipsCount,
            'studentMemberships3monthCount' => $studentMemberships3monthCount,
            'regularMembershipsCount' => $regularMembershipsCount,
            'regularMemberships3monthCount' => $regularMemberships3monthCount,
            'walkinMembershipsStudentCount' => $walkinMembershipsStudentCount + $walkinsDailyStudentCount,
            'walkinMembershipsRegularCount' => $walkinMembershipsRegularCount + $walkinsDailyRegularCount,
            'ptSales1monthCount' => $ptSales1monthCount,
            'ptSales1dayCount' => $ptSales1dayCount,
            'totalMembershipAmount' => $totalMembershipAmount,
            'totalStudentMemberships1monthAmount' => $totalStudentMemberships1monthAmount,
            'totalStudentMemberships3monthAmount' => $totalStudentMemberships3monthAmount,
            'totalRegularMemberships1monthAmount' => $totalRegularMemberships1monthAmount,
            'totalRegularMemberships3monthAmount' => $totalRegularMemberships3monthAmount,
            'totalWalkinMembershipsStudentAmount' => $totalWalkinMembershipsStudentAmount + $totalWalkinsDailyStudentAmount,
            'totalWalkinMembershipsRegularAmount' => $totalWalkinMembershipsRegularAmount + $totalWalkinsDailyRegularAmount,
            'totalPTSales1monthAmount' => $totalPTSales1monthAmount,
            'totalPTSales1dayAmount' => $totalPTSales1dayAmount,
            'dayPassesCount' => $dayPassesCount,
            'totalDayPassesAmount' => $totalDayPassesAmount,
            'itemSales' => $itemSales,
            'totalItemsSalesAmount' => $totalItemsSalesAmount,
            'totalAmount' => $totalAmount,
            'totalClients' => $totalClients,
        ]);
    }
}
