<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Daily Logs</h1>

        <x-alert />
        <x-edit-daily-log-modal />

        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <details {{ $errors->any() ? 'open' : '' }}>
                <summary class="text-xl font-semibold text-gray-700 mb-4 cursor-pointer">Add New Log</summary>

                <x-error-message/>
    
                <form action="{{route('add-daily-log')}}" method="POST" class="space-y-6" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date<span class="text-red-500">*</span></label>
                            <input type="date" id="date" name="date" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ date('Y-m-d') }}">
                            @error('date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="time_in" class="block text-sm font-medium text-gray-700 mb-1">Time in<span class="text-red-500">*</span></label>
                            <input type="time" id="time_in" name="time_in" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ date('H:i', time());}}">
                            @error('time_in')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="member_id" class="block text-sm font-medium text-gray-700 mb-1">Member ID<span class="text-red-500">*</span></label>
                            <input type="number" id="member_id" name="member_id" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('member_id') }}">
                            @error('member_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method<span class="text-red-500">*</span></label>
                            <select id="payment_method" name="payment_method" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="Cash">Cash</option>    
                                <option value="GCash">GCash</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                            </select>
                        </div>

                        <div>
                            <label for="payment_amount" class="block text-sm font-medium text-gray-700 mb-1">Payment Amount<span class="text-red-500">*</span></label>
                            <input type="number" id="payment_amount" name="payment_amount" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('payment_amount', '0') }}" placeholder="Enter amount in PHP">
                            @error('payment_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="purpose_of_visit" class="block text-sm font-medium text-gray-700 mb-1">Purpose of Visit<span class="text-red-500">*</span></label>
                            <input type="text" id="purpose_of_visit" name="purpose_of_visit" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   value="{{ old('purpose_of_visit', 'General Workout') }}">
                            @error('purpose_of_visit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="staff_assigned" class="block text-sm font-medium text-gray-700 mb-1">Staff Assigned<span class="text-red-500">*</span></label>
                            <input type="text" id="staff_assigned" name="staff_assigned" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
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
                                        'Bottled Water',
                                        'Other'
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
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-black hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                            Add Log
                        </button>
                    </div>
                </form>
            </details>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <h2 class="text-xl font-semibold text-gray-700 p-4">Daily Log List</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Photo
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Time In
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Time Out
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Member ID
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Membership Term
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Purpose
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Items Bought
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Amount Paid
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dailyLogsToday as $dailyLog)
                        <tr class="hover:bg-gray-50 cursor-pointer" 
                            onclick="openEditDailyLogModal({{ $dailyLog }})">
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <img src="{{$dailyLog->member->photo_url ? $dailyLog->member->photo_url : asset('images/placeholder_profile.png')}}" class="w-12 h-12 rounded-full">
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{ \Carbon\Carbon::parse($dailyLog->date)->format('M d, Y') }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{ \Carbon\Carbon::parse($dailyLog->time_in)->format('h:i A') }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <form action="{{ route('daily-logs.update-time-out', $dailyLog->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to update the time out status?')">
                                    @csrf
                                    @method('POST')
                                    <select 
                                        name="time_out_status" 
                                        class="border rounded px-2 py-1 text-sm" 
                                        onchange="this.form.submit()"
                                        onclick="event.stopPropagation()">
                                        <option value="in_session" {{ is_null($dailyLog->time_out) ? 'selected' : '' }}>In Session</option>
                                        <option value="time_out" {{ !is_null($dailyLog->time_out) ? 'selected' : '' }}>Time Out</option>
                                    </select>
                                </form>
                                <span class="time-out-display ml-2">
                                    {{ $dailyLog->time_out ? '('.\Carbon\Carbon::parse($dailyLog->time_out)->format('h:i A').')' : '' }}
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{ $dailyLog->member_id ?? 'N/A' }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{ $dailyLog->member->membership_term_gym_access ?? 'None' }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{ $dailyLog->purpose_of_visit }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    @foreach ($dailyLog->items_bought as $item)
                                    <li>{{ $item }}</li>
                                    @endforeach
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    P{{ $dailyLog->payment_amount }}
                                </p>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>