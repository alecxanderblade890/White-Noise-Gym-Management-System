<x-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Back button -->
        <x-navigate-back :href="route('dashboard')">
            Back to Dashboard
        </x-navigate-back>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Sales Report</h1>
            
            <!-- Date Range Selector -->
            <div class="mb-8">
                <form id="salesReportForm" action="{{route('sales-report.index')}}" method="GET" class="flex flex-col sm:flex-row gap-4 items-end">
                    @csrf
                    <div class="w-full sm:w-64">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" id="start_date" name="start_date" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                               value="{{ $startDate }}">
                    </div>
                    <div class="w-full sm:w-64">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" id="end_date" name="end_date" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                               value="{{ $endDate }}">
                    </div>
                    <button type="submit" 
                            class="w-full sm:w-auto px-6 py-2 bg-black text-white rounded-md hover:bg-gray-800 transition-colors">
                        Generate Report
                    </button>
                </form>
            </div>

            <!-- Sales Summary -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Particulars</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">No. of Clients</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!-- New Memberships Section -->
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-6 py-3 font-semibold text-gray-700">New Memberships</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 pl-10">Memberships</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($membershipCount ?? 0) }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 text-right">₱ {{ number_format($totalMembershipAmount ?? 0, 2) }}</td>
                        </tr>
                        <!-- New Memberships Section -->
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-6 py-3 font-semibold text-gray-700">Gym Access Sales</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 pl-10">1 month (Student)</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($studentMembershipsCount ?? 0) }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 text-right">₱ {{ number_format($totalStudentMemberships1monthAmount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 pl-10">1 month (Regular)</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($regularMembershipsCount ?? 0) }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 text-right">₱ {{ number_format($totalRegularMemberships1monthAmount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 pl-10">3 month (Student)</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($studentMemberships3monthCount ?? 0) }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 text-right">₱ {{ number_format($totalStudentMemberships3monthAmount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 pl-10">3 month (Regular)</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($regularMemberships3monthCount ?? 0) }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 text-right">₱ {{ number_format($totalRegularMemberships3monthAmount ?? 0, 2) }}</td>
                        </tr>
                        <!-- Walk-in Sales Section -->
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-6 py-3 font-semibold text-gray-700">Walk-in Sales</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 pl-10">Student</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($walkinMembershipsStudentCount ?? 0) }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 text-right">₱ {{ number_format($totalWalkinMembershipsStudentAmount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 pl-10">Regular</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($walkinMembershipsRegularCount ?? 0) }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 text-right">₱ {{ number_format($totalWalkinMembershipsRegularAmount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 pl-10">Day Pass</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($dayPassesCount ?? 0) }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 text-right">₱ {{ number_format($totalDayPassesAmount ?? 0, 2) }}</td>
                        </tr>
                        <!-- PT Sales Section -->
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-6 py-3 font-semibold text-gray-700">Personal Trainer Sales</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 pl-10">Walk-in</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($ptSales1dayCount ?? 0) }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 text-right">₱ {{ number_format($totalPTSales1dayAmount ?? 0, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 pl-10">1 month</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($ptSales1monthCount ?? 0) }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 text-right">₱ {{ number_format($totalPTSales1monthAmount ?? 0, 2) }}</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td colspan="3" class="px-6 py-3 font-semibold text-gray-700">Gym Use</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 pl-10">Walk-in (Gym Access)</td>
                            <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($gymUseCount ?? 0) }}</td>
                        </tr>
                         <!-- Item Sales Section -->
                         <tr class="bg-gray-50">
                            <td colspan="3" class="px-6 py-3 font-semibold text-gray-700">Item Sales</td>
                        </tr>
                        <tr>
                            @if(count($itemSales) > 0)
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <ul class="list-disc pl-5">
                                        @foreach($itemSales as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                </td>   
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">
                                    <!-- {{ count($itemSales) }} -->
                                </td>
                                <td class="px-6 py-3 whitespace-nowrap text-sm text-gray-900 text-right">₱ {{ number_format($totalItemsSalesAmount ?? 0, 2) }}</td>
                            @else
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No item sales found
                                </td>
                            @endif
                        </tr>
                         <!-- Total Row -->
                         <tr class="bg-gray-100 border-t-2 border-gray-300">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">TOTAL</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">{{ number_format($totalClients ?? 0) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-900 text-right">₱ {{ number_format($totalAmount ?? 0, 2) }}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            <!-- Print and Export Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-end">
                <button onclick="window.print()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Print Report
                </button>
                <button id="exportPdf" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700">
                    Export as PDF
                </button>
                <button id="exportExcel" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                    Export as Excel
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Set default date range to current month if not set
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            
            if (!startDateInput.value) {
                const today = new Date();
                const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
                startDateInput.value = firstDay.toISOString().split('T')[0];
            }
            
            if (!endDateInput.value) {
                endDateInput.value = new Date().toISOString().split('T')[0];
            }
            
            // Export to PDF
            document.getElementById('exportPdf').addEventListener('click', function() {
                alert('Export to PDF functionality will be implemented here');
                // Implementation for PDF export
            });
            
            // Export to Excel
            document.getElementById('exportExcel').addEventListener('click', function() {
                alert('Export to Excel functionality will be implemented here');
                // Implementation for Excel export
            });
        });
    </script>
    @endpush
</x-layout>