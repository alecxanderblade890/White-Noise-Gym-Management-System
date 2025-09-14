<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Member;
use App\Models\DailyLog;

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

        // Initialize counters
        $membershipCount = 0;
        $studentMemberships1monthCount = 0;
        $studentMemberships3monthCount = 0;
        $regularMemberships1monthCount = 0;
        $regularMemberships3monthCount = 0;
        $walkinMembershipsStudentCount = 0;
        $walkinMembershipsRegularCount = 0;
        $ptSales1monthCount = 0;
        $ptSales1dayCount = 0;
        $walkinsDailyStudentCount = 0;
        $walkinsDailyRegularCount = 0;
        $dayPassesCount = 0;

        $gymUseCount = 0;

        // Initialize amounts
        $totalMembershipAmount = 0;
        $totalStudentMemberships1monthAmount = 0;
        $totalStudentMemberships3monthAmount = 0;
        $totalRegularMemberships1monthAmount = 0;
        $totalRegularMemberships3monthAmount = 0;
        $totalWalkinMembershipsStudentAmount = 0;
        $totalWalkinMembershipsRegularAmount = 0;
        $totalPTSales1monthAmount = 0;
        $totalPTSales1dayAmount = 0;
        $totalDayPassesAmount = 0;
        $totalClients = 0;

        // Get all members with payment history in the date range
        $members = Member::whereNotNull('payment_history')->get();

        foreach ($members as $member) {
            if (empty($member->payment_history)) {
                continue;
            }

            foreach ($member->payment_history as $payment) {
                // Convert payment date to Carbon for comparison
                $paymentDate = Carbon::parse($payment['date']);

                // Check if payment is within the date range
                if ($paymentDate->between($startDate, $endDate)) {
                    
                    // Categorize by purpose
                    if ($payment['amount'] == 500) {
                        $membershipCount += 1;
                        $totalMembershipAmount += 500;
                    } elseif ($payment['amount'] == 1000) {
                        $studentMemberships1monthCount += 1;
                        $totalStudentMemberships1monthAmount += 1000;
                    } elseif ($payment['amount'] == 1500) {
                        $regularMemberships1monthCount += 1;
                        $totalRegularMemberships1monthAmount += 1500;
                    } elseif ($payment['amount'] == 2500) {
                        $studentMemberships3monthCount += 1;
                        $totalStudentMemberships3monthAmount += 2500;
                    } elseif ($payment['amount'] == 4000) {
                        $regularMemberships3monthCount += 1;
                        $totalRegularMemberships3monthAmount += 4000;
                    } elseif ($payment['amount'] == 3000) {
                        $ptSales1monthCount += 1;
                        $totalPTSales1monthAmount += 3000;
                    }
                }
            }
        }

        $gymUseCount = DailyLog::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->whereJsonContains('purpose_of_visit', 'Gym Use')
            ->get();
        $gymUseCount = $gymUseCount->count();

        // Daily Logs for PT and Walk-ins
        $ptSales1day = DailyLog::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->whereJsonContains('purpose_of_visit', 'Personal Trainer 1 Day')
            ->get();
        $ptSales1dayCount = $ptSales1day->count();
        $totalPTSales1dayAmount = $ptSales1dayCount * 300;

        $walkinsDailyStudent = DailyLog::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->where('gym_access', 'Walk in')
            ->where('member_type', 'Student')
            ->whereJsonContains('purpose_of_visit', 'Gym Use')
            ->get();
        $walkinsDailyStudentCount = $walkinsDailyStudent->count();
        $totalWalkinsDailyStudentAmount = $walkinsDailyStudentCount * 100;

        $walkinsDailyRegular = DailyLog::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->where('gym_access', 'Walk in')
            ->where('member_type', 'Regular')
            ->whereJsonContains('purpose_of_visit', 'Gym Use')
            ->get();
        $walkinsDailyRegularCount = $walkinsDailyRegular->count();
        $totalWalkinsDailyRegularAmount = $walkinsDailyRegularCount * 150;
    
        $dayPasses = DailyLog::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->whereJsonContains('purpose_of_visit', 'Gym Use (Day Pass)')
            ->get();

        $totalClients = DailyLog::whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->get()->count();
            
        $dayPassesCount = $dayPasses->count();
        $totalDayPassesAmount = $dayPassesCount * 200;

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

        $totalAmount = $totalMembershipAmount + $totalStudentMemberships1monthAmount + $totalStudentMemberships3monthAmount + $totalRegularMemberships1monthAmount + $totalRegularMemberships3monthAmount + $totalWalkinMembershipsStudentAmount + $totalWalkinMembershipsRegularAmount + $totalPTSales1monthAmount + $totalPTSales1dayAmount + $totalItemsSalesAmount + $totalWalkinsDailyStudentAmount + $totalWalkinsDailyRegularAmount + $totalDayPassesAmount;
        $totalClients += $dayPassesCount;

        return view('pages.sales-report', [
            'startDate' => $startDate->format('Y-m-d'),
            'endDate' => $endDate->format('Y-m-d'),
            'membershipCount' => $membershipCount,
            'studentMembershipsCount' => $studentMemberships1monthCount,
            'studentMemberships3monthCount' => $studentMemberships3monthCount,
            'regularMembershipsCount' => $regularMemberships1monthCount,
            'regularMemberships3monthCount' => $regularMemberships3monthCount,
            'walkinMembershipsStudentCount' => $walkinMembershipsStudentCount + $walkinsDailyStudentCount,
            'walkinMembershipsRegularCount' => $walkinMembershipsRegularCount + $walkinsDailyRegularCount,
            'ptSales1monthCount' => $ptSales1monthCount,
            'ptSales1dayCount' => $ptSales1dayCount,
            'gymUseCount' => $gymUseCount,
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
    // public function updatePaymentHistory()
    // {
    //     $members = Member::all();

    //     foreach ($members as $member) {
    //         $paymentHistory = $member->payment_history;

    //         if($member->membership_start_date){
    //             $paymentHistory[] = [
    //                 'date' => $member->membership_start_date,
    //                 'purpose' => 'New Membership',
    //                 'amount' => 500,
    //             ];
    //         }

    //         // Check if member has gym access
    //         if ($member->gym_access_start_date) {

    //             $purpose = '';
    //             $amount = 0;

    //             if($member->membership_term_gym_access == '1 month'){
    //                 $purpose = 'Gym Access 1 month';
    //                 $amount = $member->member_type == 'Student' ? 1000 : 1500;
    //             }
    //             else if($member->membership_term_gym_access == '3 months'){
    //                 $purpose = 'Gym Access 3 months';
    //                 $amount = $member->member_type == 'Student' ? 2500 : 4000;
    //             }
    //             // Add gym membership to payment history
    //             $paymentHistory[] = [
    //                 'date' => $member->gym_access_start_date,
    //                 'purpose' => $purpose,
    //                 'amount' => $amount,
    //             ];
    //         }

    //         // Check if member has PT
    //         if ($member->with_pt && $member->pt_start_date) {
    //             // Add PT to payment history
    //             $paymentHistory[] = [
    //                 'date' => $member->pt_start_date,
    //                 'purpose' => 'Personal Training 1 month',
    //                 'amount' => 3000,
    //             ];
    //         }
    //         $member->update(['payment_history' => $paymentHistory]);
    //     }
    // }
}