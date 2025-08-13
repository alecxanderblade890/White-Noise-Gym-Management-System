<x-layout>
    <div class="container mx-auto px-2 sm:px-4 py-4 sm:py-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">{{Auth::user()->username == 'admin_access' ? 'Admin Dashboard' : 'Staff Dashboard'}}</h1>
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <details class="w-full group transition-all duration-200 ease-in-out overflow-hidden">
                <summary class="text-lg sm:text-xl font-semibold text-gray-700 cursor-pointer flex justify-between items-center list-none">
                    <span>Total Sales Today: <span class="text-gray-700">PHP {{number_format($totalSalesToday, 2)}}</span></span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="mt-4 space-y-2 transform-gpu origin-top scale-y-0 opacity-0 transition-all duration-300 ease-in-out group-open:scale-y-100 group-open:opacity-100">
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
        <x-alert/>
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <details class="w-full group transition-all duration-200 ease-in-out overflow-hidden" open>
                <summary class="text-xl font-semibold text-gray-700 cursor-pointer flex justify-between items-center list-none">
                    <span class="ml-1">Add New Log</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="mt-4 transition-all duration-200 ease-in-out transform origin-top">
                    <div class="mb-2">
                        <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1 ml-1">Member ID<span class="text-red-500">*</span></label>
                        <input type="number" id="member_id" name="member_id" required
                            class="w-70 px-4 py-2 ml-1 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                            value="{{ old('member_id') }}">
                        @error('member_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <button type="button" 
                                id="validate-member-btn"
                                class="inline-flex items-center justify-center ml-2 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-black hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black/80">
                            <svg id="validate-member-spinner" class="hidden -ml-1 mr-2 h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Validate Member ID
                        </button>
                    </div>
                    <label id="label_text" class="text-sm"></label>
                    <div id="daily-log-form" class="hidden">
                        <form id="daily-log-form" action="{{route('add-daily-log')}}" method="POST" class="space-y-6" enctype="multipart/form-data">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date<span class="text-red-500">*</span></label>
                                    <input type="date" id="date" name="date" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ date('Y-m-d') }}">
                                    @error('date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="time_in" class="block text-sm font-medium text-gray-700 mb-1">Time in<span class="text-red-500">*</span></label>
                                    <input type="time" id="time_in" name="time_in" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ date('H:i', time());}}">
                                    @error('time_in')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="form_member_id" class="block text-sm font-medium text-gray-700 mb-1">Member ID<span class="text-red-500">*</span></label>
                                    <input type="number" id="form_member_id" name="form_member_id" readonly
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ old('form_member_id') }}">
                                    @error('form_member_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method<span class="text-red-500">*</span></label>
                                    <select id="payment_method" name="payment_method" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black">
                                        <option value="Cash">Cash</option>    
                                        <option value="GCash">GCash</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="payment_amount" class="block text-sm font-medium text-gray-700 mb-1">Payment Amount<span class="text-red-500">*</span></label>
                                    <input type="number" id="payment_amount" name="payment_amount" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ old('payment_amount', '500') }}" placeholder="Enter amount in PHP">
                                    @error('payment_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="purpose_of_visit" class="block text-sm font-medium text-gray-700 mb-1">Purpose of Visit<span class="text-red-500">*</span></label>
                                    <select id="purpose_of_visit" name="purpose_of_visit" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black">
                                        <option value="Membership">Membership</option>    
                                        <option value="Membership Term">Membership Term</option>
                                        <option value="Personal Trainer">Personal Trainer</option>
                                        <option value="Gym Use">Gym Use</option>
                                        <option value="Gym Use & Membership">Gym Use & Membership</option>
                                        <option value="Gym Use & Membership Term">Gym Use & Membership Term</option>
                                        <option value="Gym Use & Personal Trainer">Gym Use & Personal Trainer</option>
                                    </select>
                                    @error('purpose_of_visit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="staff_assigned" class="block text-sm font-medium text-gray-700 mb-1">Staff Assigned<span class="text-red-500">*</span></label>
                                    <input type="text" id="staff_assigned" name="staff_assigned" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ old('staff_assigned') }}">
                                    @error('staff_assigned')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-6">
                                <div class="flex items-center">
                                    <input type="checkbox" id="upgrade_gym_access" name="upgrade_gym_access" 
                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="upgrade_gym_access" class="ml-2 block text-sm text-gray-700">
                                        Upgrade Gym Access
                                    </label>
                                </div>
                            </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Items</label>
                                    <div class="space-y-2">
                                        @php
                                            $commonItems = [
                                                'Pocari Sweat',
                                                'Gatorade Blue',
                                                'Gatorade Red',
                                                'Bottled Water'
                                            ];

                                        @endphp
                                        
                                        <div class="grid grid-cols-2 gap-2">
                                            @foreach($commonItems as $item)
                                                <div class="flex items-center">
                                                    <input id="item-{{ $loop->index }}" name="items[]" type="checkbox" value="{{ $item }}" 
                                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <label for="item-{{ $loop->index }}" class="ml-2 block text-sm text-gray-700">
                                                        {{ $item }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2 mt-4">T-Shirts</label>
                                    <div class="space-y-2">
                                        @php
                                        $tShirts = [
                                                'White - Large',
                                                'White - XL',
                                                'Black - Large',
                                                'Black - XL',
                                                'Black - XS',
                                                'Black - Medium',
                                            ];
                                        @endphp
                                        <div class="grid grid-cols-2 gap-2">
                                            @foreach($tShirts as $index => $tShirt)
                                                <div class="flex items-center">
                                                    <input id="tshirt-{{ $index }}" name="t_shirts[]" type="checkbox" value="{{ $tShirt }}" 
                                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                                    <label for="tshirt-{{ $index }}" class="ml-2 block text-sm text-gray-700">
                                                        {{ $tShirt }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                    <textarea id="notes" name="notes" rows="3" class="w-full h-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>
                            </div>

                            <div>
                            <button type="button" 
                                    id="add-log-btn"
                                    class="inline-flex items-center justify-center ml-2 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-black hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black/80">
                                <svg id="add-log-spinner" class="hidden -ml-1 mr-2 h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Add Log
                            </button>
                            </div>
                        </form>
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
    @push('scripts')
        @vite('resources/js/components/dashboard.js')
    @endpush
</x-layout>