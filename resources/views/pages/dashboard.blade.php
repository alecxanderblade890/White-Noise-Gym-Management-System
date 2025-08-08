<x-layout>
    <div class="container mx-auto px-2 sm:px-4 py-4 sm:py-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">{{Auth::user()->username == 'admin_access' ? 'Admin Dashboard' : 'Staff Dashboard'}}</h1>
        <div class="bg-white shadow-md rounded-lg p-4 sm:p-6 mb-6">

            <x-error-message/>
            <details class="w-full">
                <summary class="text-lg sm:text-xl font-semibold text-gray-700 cursor-pointer flex justify-between items-center">
                    <span>Total Sales Today: <span class="text-indigo-600">PHP {{number_format($totalSalesToday, 2)}}</span></span>
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="mt-4 space-y-2">
                    <div class="flex text-gray-700">
                        <span>Cash:</span>
                        <span class="font-medium ml-2">PHP {{ number_format($cashTotal, 2) }}</span>
                    </div>
                    <div class="flex text-gray-700">
                        <span>GCash:</span>
                        <span class="font-medium ml-2">PHP {{ number_format($gcashTotal, 2) }}</span>
                    </div>
                    <div class="flex text-gray-700">
                        <span>Bank Transfer:</span>
                        <span class="font-medium ml-2">PHP {{ number_format($bankTransferTotal, 2) }}</span>
                    </div>
                </div>

            </details>
        </div>

        <!-- Members Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-4 pt-4 pb-2">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-700">Memberships Expiring Soon (Next 7 Days)</h2>
                    <span class="text-sm text-gray-500">{{ now()->format('M d, Y') }} to {{ $sevenDaysFromNow->format('M d, Y') }}</span>
                </div>
                @if($members->count() > 0)
                    <p class="text-sm text-gray-600">Showing {{ $members->count() }} members with memberships expiring in the next 7 days</p>
                @endif
            </div>
            <div class="overflow-x-auto -mx-2 sm:mx-0">
                <div class="inline-block min-w-full align-middle px-2 sm:px-0">
                    <table class="min-w-full divide-y divide-gray-200 mx-auto">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Membership Duration
                                </th>
                                <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Membership Term Duration
                                </th>
                                <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Personal Trainer Duration
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($members as $member)
                            @php
                                $isActiveMembership = $member->membership_end_date >= now();
                                $isActiveGymAccess = $member->gym_access_end_date >= now();
                                $isActivePT = $member->pt_end_date >= now();
                                
                                // Calculate days remaining for each membership type
                                $membershipDaysLeft = $member->membership_end_date ? now()->diffInDays(\Carbon\Carbon::parse($member->membership_end_date), false) : null;
                                $gymAccessDaysLeft = $member->gym_access_end_date ? now()->diffInDays(\Carbon\Carbon::parse($member->gym_access_end_date), false) : null;
                                $ptDaysLeft = $member->pt_end_date ? now()->diffInDays(\Carbon\Carbon::parse($member->pt_end_date), false) : null;
                                
                                // Find which membership is expiring soonest
                                $expiringMemberships = [];
                                if ($membershipDaysLeft !== null && $membershipDaysLeft <= 7) {
                                    $expiringMemberships[] = 'Membership';
                                }
                                if ($gymAccessDaysLeft !== null && $gymAccessDaysLeft <= 7) {
                                    $expiringMemberships[] = 'Gym Access';
                                }
                                if ($ptDaysLeft !== null && $ptDaysLeft <= 7) {
                                    $expiringMemberships[] = 'Personal Training';
                                }
                            @endphp
                                <tr class="hover:bg-gray-50 transition-colors text-center">
                                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $member->id }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        <div class="font-semibold">{{ $member->full_name }}</div>
                                        @if(count($expiringMemberships) > 0)
                                            <div class="text-xs text-amber-600 mt-1">
                                                Expiring: {{ implode(', ', $expiringMemberships) }}
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td class="px-3 py-4 whitespace-nowrap text-sm hidden sm:table-cell {{ $member->membership_start_date != null ? ($isActiveMembership ? 'text-green-600' : 'text-red-600') : 'text-gray-600' }}">
                                        {{ $member->membership_start_date ? \Carbon\Carbon::parse($member->membership_start_date)->format('M d, Y') : 'N/A' }} 
                                        -> 
                                        {{ $member->membership_end_date ? \Carbon\Carbon::parse($member->membership_end_date)->format('M d, Y') : 'N/A' }}
                                        <br>
                                        <p class="font-medium {{ $member->membership_start_date != null ? ($isActiveMembership ? 'text-green-600' : 'text-red-600') : 'text-gray-600' }}">
                                        @if($member->membership_start_date != null && $isActiveMembership)
                                            ({{ (int)(\Carbon\Carbon::parse($member->membership_end_date)->addDay()->diffInDays(now()) * -1 + 1) }} days remaining)
                                        @elseif($member->membership_start_date != null && !$isActiveMembership)
                                            (Expired {{ round(now()->diffInDays(\Carbon\Carbon::parse($member->membership_end_date))) *-1 }} days ago)
                                        @endif
                                        </p>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm hidden sm:table-cell {{ $member->gym_access_start_date != null ? ($isActiveGymAccess ? 'text-green-600' : 'text-red-600') : 'text-gray-600' }}">
                                        {{ $member->gym_access_start_date ? \Carbon\Carbon::parse($member->gym_access_start_date)->format('M d, Y') : 'N/A' }} 
                                        -> 
                                        {{ $member->gym_access_end_date ? \Carbon\Carbon::parse($member->gym_access_end_date)->format('M d, Y') : 'N/A' }}
                                        <br>
                                        <p class="font-medium {{ $member->gym_access_start_date != null ? ($isActiveGymAccess ? 'text-green-600' : 'text-red-600') : 'text-gray-600' }}">
                                        @if($member->gym_access_start_date != null && $isActiveGymAccess)
                                            ({{ (int)(\Carbon\Carbon::parse($member->gym_access_end_date)->addDay()->diffInDays(now()) * -1 + 1) }} days remaining)
                                        @elseif($member->gym_access_start_date != null && !$isActiveGymAccess)
                                            (Expired {{ round(now()->diffInDays(\Carbon\Carbon::parse($member->gym_access_end_date))) *-1 }} days ago)
                                        @endif
                                        </p>
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm hidden sm:table-cell {{ $member->pt_start_date != null ? ($isActivePT ? 'text-green-600' : 'text-red-600') : 'text-gray-600' }}">
                                        {{ $member->pt_start_date ? \Carbon\Carbon::parse($member->pt_start_date)->format('M d, Y') : 'N/A' }} 
                                        -> 
                                        {{ $member->pt_end_date ? \Carbon\Carbon::parse($member->pt_end_date)->format('M d, Y') : 'N/A' }}
                                        <br>
                                        <p class="font-medium {{ $member->pt_start_date != null ? ($isActivePT ? 'text-green-600' : 'text-red-600') : 'text-gray-600' }}">  
                                        @if($member->pt_start_date != null && $isActivePT)
                                            ({{ (int)(\Carbon\Carbon::parse($member->pt_end_date)->addDay()->diffInDays(now()) * -1 + 1) }} days remaining)
                                        @elseif($member->pt_start_date != null && !$isActivePT)
                                            (Expired {{ round(now()->diffInDays(\Carbon\Carbon::parse($member->pt_end_date))) *-1 }} days ago)
                                        @endif
                                        </p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-3 py-8 text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center justify-center py-4">
                                            <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="mt-2 text-sm font-medium text-gray-600">No memberships expiring in the next 7 days</p>
                                            <p class="text-xs text-gray-500 mt-1">Last checked: {{ now()->format('M d, Y h:i A') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>