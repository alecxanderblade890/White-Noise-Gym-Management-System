<x-layout>
    <x-modals.day-pass-modal/>
    <div class="container mx-auto px-2 sm:px-4 py-4 sm:py-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">{{Auth::user()->username == 'admin_access' ? 'Admin Dashboard' : 'Staff Dashboard'}}</h1>
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <details class="w-full group transition-all duration-200 ease-in-out overflow-hidden">
                <summary class="text-lg sm:text-xl font-semibold text-gray-700 cursor-pointer flex justify-between items-center list-none">
                    <div class="flex space-x-2">
                        <span>Total Sales Today: <span class="text-gray-700">₱ {{number_format($totalSalesToday, 2)}}</span></span>
                    </div>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200 group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </summary>
                <div class="flex space-x-10">
                    <div class="mt-4 space-y-2 transform-gpu origin-top scale-y-0 opacity-0 transition-all duration-300 ease-in-out group-open:scale-y-100 group-open:opacity-100">
                        <div class="flex text-gray-700">
                            <span>Cash:</span>
                            <span class="font-medium ml-2">₱ {{ number_format($cashTotal, 2) }}</span>
                        </div>
                        <div class="flex text-gray-700">
                            <span>GCash:</span>
                            <span class="font-medium ml-2">₱ {{ number_format($gcashTotal, 2) }}</span>
                        </div>
                        <div class="flex text-gray-700">
                            <span>Bank Transfer:</span>
                            <span class="font-medium ml-2">₱ {{ number_format($bankTransferTotal, 2) }}</span>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2 transform-gpu origin-top scale-y-0 opacity-0 transition-all duration-300 ease-in-out group-open:scale-y-100 group-open:opacity-100">
                        <div class="flex text-gray-700">
                            <span>New/Renewal Memberships Today:</span>
                            <span class="font-medium ml-2">₱ {{ number_format($totalNewMemberships * 500, 2)}} ({{$totalNewMemberships}}) </span>
                        </div>
                        <div class="flex text-gray-700">
                            <span>New/Renewal Gym Access Today:</span>
                            <span class="font-medium ml-2">₱ {{ number_format($totalNewGymAccessAmount, 2)}} ({{$totalNewGymAccess}}) </span>
                        </div>
                        <div class="flex text-gray-700">
                            <span>New/Renewal Personal Trainer Today:</span>
                            <span class="font-medium ml-2">₱ {{ number_format($totalNewPersonalTrainer * 3000, 2)}} ({{$totalNewPersonalTrainer}}) </span>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2 transform-gpu origin-top scale-y-0 opacity-0 transition-all duration-300 ease-in-out group-open:scale-y-100 group-open:opacity-100">
                        <div class="flex text-gray-700">
                            <span>Total Clients Today:</span>
                            <span class="font-medium ml-2">{{ $totalClientsToday }}</span>
                        </div>
                        <div class="flex text-gray-700">
                            <span>Total Items Sold Today:</span>
                            <span class="font-medium ml-2">₱ {{ number_format($totalItemsSalesAmount, 2)}} ({{$totalItemsSalesCount}}) </span>
                        </div>
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
                        <label for="white_noise_id" class="block text-sm font-medium text-gray-700 mb-1 ml-1">Member ID / Full Name<span class="text-red-500">*</span></label>
                        <input type="text" id="white_noise_id" name="white_noise_id" required
                            class="w-70 px-4 py-2 ml-1 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                            value="{{ old('white_noise_id') }}">
                        @error('white_noise_id')
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
                        <button type="button" 
                                id="day-pass-btn"
                                class="inline-flex items-center justify-center ml-2 py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-black hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black/80">
                            <svg id="day-pass-spinner" class="hidden -ml-1 mr-2 h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Day Pass
                        </button>
                    </div>
                    <label id="label_text" class="text-sm"></label>
                    <div id="daily-log-form" class="hidden">
                        <form id="daily-log-form" action="{{route('add-daily-log')}}" method="POST" class="space-y-6" enctype="multipart/form-data">
                            @csrf
                            <input type="text" id="white_noise_id_form" name="white_noise_id_form" required hidden>
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
                                        value="{{ date('H:i', time()) }}">
                                    @error('time_in')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name<span class="text-red-500">*</span></label>
                                    <input type="text" id="full_name" name="full_name" readonly
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="">
                                    @error('full_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method<span class="text-red-500">*</span></label>
                                    <select id="payment_method" name="payment_method" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black">
                                        <option value="None">None</option>
                                        <option value="Cash">Cash</option>    
                                        <option value="GCash">GCash</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="payment_amount" class="block text-sm font-medium text-gray-700 mb-1">Payment Amount<span class="text-red-500">*</span></label>
                                    <input type="number" id="payment_amount" name="payment_amount" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ old('payment_amount', '0') }}" placeholder="Enter amount in PHP">
                                    @error('payment_amount')
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

                            <div class="grid grid-cols-1 lg:grid-cols-6 gap-6">
                                <!-- Member Type Column -->
                                <div class="lg:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Member Type<span class="text-red-500">*</span></label>
                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center">
                                            <input type="radio" id="member_type_regular" name="member_type" value="Regular" class="h-4 w-4 text-black focus:ring-black border-gray-300">
                                            <label for="member_type_regular" class="ml-2 block text-sm text-gray-700">Regular</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="member_type_student" name="member_type" value="Student" class="h-4 w-4 text-black focus:ring-black border-gray-300">
                                            <label for="member_type_student" class="ml-2 block text-sm text-gray-700">Student</label>
                                        </div>
                                    </div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gym Access<span class="text-red-500">*</span></label>
                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center">
                                            <input type="radio" id="gym_access_none" name="gym_access" value="None" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="gym_access_none" class="ml-2 block text-sm text-gray-700">None</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="gym_access_1_month" name="gym_access" value="1 month" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="gym_access_1_month" class="ml-2 block text-sm text-gray-700">1 Month</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="gym_access_3_month" name="gym_access" value="3 months" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="gym_access_3_month" class="ml-2 block text-sm text-gray-700">3 Months</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="gym_access_walk_in" name="gym_access" value="Walk in" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="gym_access_walk_in" class="ml-2 block text-sm text-gray-700">Walk in</label>
                                        </div>
                                    </div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Personal Trainer<span class="text-red-500">*</span></label>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" id="personal_trainer_none" name="personal_trainer" value="None" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded" checked>
                                            <label for="personal_trainer_none" class="ml-2 block text-sm text-gray-700">None</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="personal_trainer_1_month" name="personal_trainer" value="1 month" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="personal_trainer_1_month" class="ml-2 block text-sm text-gray-700">1 Month</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Purpose of Visit Column -->
                                <div class="lg:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Purpose of Visit<span class="text-red-500">*</span></label>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="gym_use" name="purpose_of_visit[]" value="Gym Use" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="gym_use" class="ml-2 block text-sm text-gray-700">Gym Use</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="membership_payment" name="purpose_of_visit[]" value="Membership Payment" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="membership_payment" class="ml-2 block text-sm text-gray-700">Membership Payment</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="gym_access_payment" name="purpose_of_visit[]" value="Gym Access Payment" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="gym_access_payment" class="ml-2 block text-sm text-gray-700">Gym Access Payment</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="pt_payment" name="purpose_of_visit[]" value="Personal Trainer Payment" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="pt_payment" class="ml-2 block text-sm text-gray-700">Personal Trainer Payment</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="renew_membership" name="purpose_of_visit[]" value="Renew Membership" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="renew_membership" class="ml-2 block text-sm text-gray-700">Renew Membership</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="renew_gym_access" name="purpose_of_visit[]" value="Renew Gym Access" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="renew_gym_access" class="ml-2 block text-sm text-gray-700">Renew Gym Access</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="renew_pt" name="purpose_of_visit[]" value="Renew Personal Trainer" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="renew_pt" class="ml-2 block text-sm text-gray-700">Renew Personal Trainer</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="pt_1_day" name="purpose_of_visit[]" value="Personal Trainer 1 Day" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="pt_1_day" class="ml-2 block text-sm text-gray-700">Personal Trainer 1 Day</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="remove_gym_access" name="purpose_of_visit[]" value="Remove Gym Access" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="remove_gym_access" class="ml-2 block text-sm text-gray-700">Remove Gym Access</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="remove_pt" name="purpose_of_visit[]" value="Remove Personal Trainer" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="remove_pt" class="ml-2 block text-sm text-gray-700">Remove Personal Trainer</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Items Column -->
                                <div class="lg:col-span-2">
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
                                <div class="lg:col-span-2">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                    <textarea id="notes" name="notes" rows="12" class="w-full h-[175px] px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
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
                @if($membersExpiring->count() > 0)
                    <p class="text-sm text-gray-600">Showing {{ $membersExpiring->count() }} members with Memberships/Gym Access/Personal Trainers expiring in the next 7 days</p>
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
                                    Gym Access Duration
                                </th>
                                <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Personal Trainer Duration
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($membersExpiring as $member)
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
                                        {{ $member->white_noise_id }}
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
                                            ({{ (int)abs(\Carbon\Carbon::parse($member->membership_end_date)->addDay()->diffInDays(now())) }} day/s remaining)
                                        @elseif($member->membership_start_date != null && !$isActiveMembership)
                                            (Expired {{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->membership_end_date))) }} day/s ago)
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
                                            ({{ (int)abs(\Carbon\Carbon::parse($member->gym_access_end_date)->addDay()->diffInDays(now())) }} day/s remaining)
                                        @elseif($member->gym_access_start_date != null && !$isActiveGymAccess)
                                            (Expired {{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->gym_access_end_date))) }} day/s ago)
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
                                            ({{ (int)abs(\Carbon\Carbon::parse($member->pt_end_date)->addDay()->diffInDays(now())) }} day/s remaining)
                                        @elseif($member->pt_start_date != null && !$isActivePT)
                                            (Expired {{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->pt_end_date))) }} day/s ago)
                                        @endif
                                        </p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-3 py-8 text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center justify-center py-4">
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

        <!-- Expired Memberships Table -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden mt-8">
            <div class="px-4 pt-4 pb-2">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-700">Expired Memberships</h2>
                    <span class="text-sm text-gray-500">As of {{ now()->format('M d, Y') }}</span>
                </div>
                @if($membersExpired->count() > 0)
                    <p class="text-sm text-gray-600">Showing {{ $membersExpired->count() }} members with expired Memberships/Gym Access/Personal Trainers</p>
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
                                    Membership
                                </th>
                                <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Gym Access
                                </th>
                                <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Personal Trainer
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($membersExpired as $member)
                            @php
                                $isMembershipExpired = $member->membership_end_date < now();
                                $isGymAccessExpired = $member->gym_access_end_date ? $member->gym_access_end_date < now() : false;
                                $isPTExpired = $member->pt_end_date ? $member->pt_end_date < now() : false;
                                
                                $expiredMemberships = [];
                                if ($isMembershipExpired) $expiredMemberships[] = 'Membership';
                                if ($isGymAccessExpired) $expiredMemberships[] = 'Gym Access';
                                if ($isPTExpired) $expiredMemberships[] = 'Personal Training';
                            @endphp
                                <tr class="hover:bg-gray-50 transition-colors text-center">
                                    <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $member->white_noise_id }}
                                    </td>
                                    <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                        <div class="font-semibold">{{ $member->full_name }}</div>
                                        @if(count($expiredMemberships) > 0)
                                            <div class="text-xs text-red-600 mt-1">
                                                Expired: {{ implode(', ', $expiredMemberships) }}
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td class="px-3 py-4 whitespace-nowrap text-sm hidden sm:table-cell {{ $member->membership_start_date != null ? ($isMembershipExpired ? 'text-red-600' : 'text-green-600') : 'text-gray-600' }}">
                                        {{ $member->membership_start_date ? \Carbon\Carbon::parse($member->membership_start_date)->format('M d, Y') : 'N/A' }} 
                                        -> 
                                        {{ $member->membership_end_date ? \Carbon\Carbon::parse($member->membership_end_date)->format('M d, Y') : 'N/A' }}
                                        <br>
                                        @if($member->membership_start_date != null)
                                            @if($isMembershipExpired)
                                                <span class="font-medium text-red-600">
                                                    (Expired {{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->membership_end_date))) }} day/s ago)
                                                </span>
                                            @else
                                                <span class="font-medium text-green-600">
                                                    ({{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->membership_end_date)))}} day/s remaining)
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                    
                                    <td class="px-3 py-4 whitespace-nowrap text-sm {{ $member->gym_access_start_date != null ? ($isGymAccessExpired ? 'text-red-600' : 'text-green-600') : 'text-gray-600' }}">
                                        {{ $member->gym_access_start_date ? \Carbon\Carbon::parse($member->gym_access_start_date)->format('M d, Y') : 'N/A' }} 
                                        -> 
                                        {{ $member->gym_access_end_date ? \Carbon\Carbon::parse($member->gym_access_end_date)->format('M d, Y') : 'N/A' }}
                                        <br>
                                        @if($member->gym_access_start_date != null)
                                            @if($isGymAccessExpired)
                                                <span class="font-medium text-red-600">
                                                    (Expired {{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->gym_access_end_date))) }} day/s ago)
                                                </span>
                                            @else
                                                <span class="font-medium text-green-600">
                                                    ({{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->gym_access_end_date)))}} day/s remaining)
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                    
                                    <td class="px-3 py-4 whitespace-nowrap text-sm {{ $member->pt_start_date != null ? ($isPTExpired ? 'text-red-600' : 'text-green-600') : 'text-gray-600' }}">
                                        {{ $member->pt_start_date ? \Carbon\Carbon::parse($member->pt_start_date)->format('M d, Y') : 'N/A' }} 
                                        -> 
                                        {{ $member->pt_end_date ? \Carbon\Carbon::parse($member->pt_end_date)->format('M d, Y') : 'N/A' }}
                                        <br>
                                        @if($member->pt_start_date != null)
                                            @if($isPTExpired)
                                                <span class="font-medium text-red-600">
                                                    (Expired {{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->pt_end_date))) }} day/s ago)
                                                </span>
                                            @else
                                                <span class="font-medium text-green-600">
                                                    ({{ (int)abs(now()->diffInDays(\Carbon\Carbon::parse($member->pt_end_date)))}} day/s remaining)
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-3 py-8 text-sm text-gray-500 text-center">
                                        <div class="flex flex-col items-center justify-center py-4">
                                            <p class="mt-2 text-sm font-medium text-gray-600">No expired memberships found</p>
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