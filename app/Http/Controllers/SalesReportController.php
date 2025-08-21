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

        $studentMemberships1month = Member::whereBetween('created_at', [$startDate, $endDate])->where('member_type', 'Student')->where('membership_term_gym_access', '1 month')->get();
        $studentMemberships3month = Member::whereBetween('created_at', [$startDate, $endDate])->where('member_type', 'Student')->where('membership_term_gym_access', '3 months')->get();
        $regularMemberships1month = Member::whereBetween('created_at', [$startDate, $endDate])->where('member_type', 'Regular')->where('membership_term_gym_access', '1 month')->get();
        $regularMemberships3month = Member::whereBetween('created_at', [$startDate, $endDate])->where('member_type', 'Regular')->where('membership_term_gym_access', '3 months')->get();

        $walkinMembershipsStudent = Member::whereBetween('created_at', [$startDate, $endDate])->where('member_type', 'Student')->where('membership_term_gym_access', 'Walk in')->get();
        $walkinMembershipsRegular = Member::whereBetween('created_at', [$startDate, $endDate])->where('member_type', 'Regular')->where('membership_term_gym_access', 'Walk in')->get();

        $ptSales = Member::whereBetween('created_at', [$startDate, $endDate])->where('with_pt', '1 month')->get();

        $itemSales = DailyLog::whereBetween('created_at', [$startDate, $endDate])
                    ->whereNotNull('items_bought')
                    ->get()
                    ->flatMap(function($log) {
                        // If it's a JSON string, decode it, otherwise use as is
                        $items = is_string($log->items_bought) 
                            ? json_decode($log->items_bought, true) 
                            : $log->items_bought;
                            
                        // Ensure we have an array and filter out any empty values
                        return is_array($items) ? array_filter($items) : [];
                    })
                    ->toArray();

        $itemSalesCount = count($itemSales);
        
        // Calculate total memberships and total amount
        $membershipCount = $memberships->count();
        $studentMembershipsCount = $studentMemberships1month->count();
        $studentMemberships3monthCount = $studentMemberships3month->count();
        $regularMembershipsCount = $regularMemberships1month->count();
        $regularMemberships3monthCount = $regularMemberships3month->count();
        $walkinMembershipsStudentCount = $walkinMembershipsStudent->count();
        $walkinMembershipsRegularCount = $walkinMembershipsRegular->count();
        $ptSalesCount = $ptSales->count();

        $totalMembershipAmount = $membershipCount * 500;
        $totalStudentMemberships1monthAmount = $studentMemberships1month->count() * 1000;
        $totalStudentMemberships3monthAmount = $studentMemberships3month->count() * 2500;
        $totalRegularMemberships1monthAmount = $regularMemberships1month->count() * 1500;
        $totalRegularMemberships3monthAmount = $regularMemberships3month->count() * 4500;

        $totalWalkinMembershipsStudentAmount = $walkinMembershipsStudent->count() * 100;
        $totalWalkinMembershipsRegularAmount = $walkinMembershipsRegular->count() * 150;

        $totalPTSalesAmount = $ptSales->count() * 300;

        $totalAmount = $totalMembershipAmount + $totalStudentMemberships1monthAmount + $totalStudentMemberships3monthAmount + $totalRegularMemberships1monthAmount + $totalRegularMemberships3monthAmount + $totalWalkinMembershipsStudentAmount + $totalWalkinMembershipsRegularAmount + $totalPTSalesAmount;
        $totalClients = $membershipCount + $studentMembershipsCount + $studentMemberships3monthCount + $regularMembershipsCount + $regularMemberships3monthCount + $walkinMembershipsStudentCount + $walkinMembershipsRegularCount + $ptSalesCount;

        return view('pages.sales-report', [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'membershipCount' => $membershipCount,
            'studentMembershipsCount' => $studentMembershipsCount,
            'studentMemberships3monthCount' => $studentMemberships3monthCount,
            'regularMembershipsCount' => $regularMembershipsCount,
            'regularMemberships3monthCount' => $regularMemberships3monthCount,
            'walkinMembershipsStudentCount' => $walkinMembershipsStudentCount,
            'walkinMembershipsRegularCount' => $walkinMembershipsRegularCount,
            'ptSalesCount' => $ptSalesCount,
            'totalMembershipAmount' => $totalMembershipAmount,
            'totalStudentMemberships1monthAmount' => $totalStudentMemberships1monthAmount,
            'totalStudentMemberships3monthAmount' => $totalStudentMemberships3monthAmount,
            'totalRegularMemberships1monthAmount' => $totalRegularMemberships1monthAmount,
            'totalRegularMemberships3monthAmount' => $totalRegularMemberships3monthAmount,
            'totalWalkinMembershipsStudentAmount' => $totalWalkinMembershipsStudentAmount,
            'totalWalkinMembershipsRegularAmount' => $totalWalkinMembershipsRegularAmount,
            'totalPTSalesAmount' => $totalPTSalesAmount,
            'itemSales' => $itemSales,
            'itemSalesCount' => $itemSalesCount,
            'totalAmount' => $totalAmount,
            'totalClients' => $totalClients,
        ]);
    }
}
