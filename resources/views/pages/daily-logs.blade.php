<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Daily Logs</h1>

        <x-alert />

        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <details {{ $errors->any() ? 'open' : '' }}>
                <summary class="text-xl font-semibold text-gray-700 mb-4 cursor-pointer">Add New Log</summary>

                @if ($errors->any())
                    <div class="mb-4">
                        <div class="text-red-600 font-semibold">Please fix the following errors:</div>
                        <ul class="list-disc list-inside text-red-500">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
    
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
                                <option value="Gcash">Gcash</option>
                                <option value="Card">Card</option>
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

                        <div>
                            <label for="upgrade_gym_access" class="block text-sm font-medium text-gray-700 mb-1">Modify Gym Access<span class="text-red-500">*</span></label>
                            <select id="upgrade_gym_access" name="upgrade_gym_access" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="no" {{ old('upgrade_gym_access') == 'no' ? 'selected' : '' }}>No</option>    
                                <option value="yes">Yes</option>
                            </select>
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
                                <div class="mt-2">
                                    <label for="custom_item" class="block text-sm font-medium text-gray-700 mb-1">Custom Item</label>
                                    <input type="text" id="custom_item" name="custom_item" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter custom item">
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
                        @foreach ($dailyLogs as $dailyLog)
                        <tr class="hover:bg-gray-50" onclick="showLogDetailsModal({
                                id: '{{ $dailyLog->id }}',
                                date: '{{ \Carbon\Carbon::parse($dailyLog->date)->format('M d, Y') }}',
                                time_in: '{{ \Carbon\Carbon::parse($dailyLog->time_in)->format('h:i A') }}',
                                time_out: '{{ $dailyLog->time_out ? \Carbon\Carbon::parse($dailyLog->time_out)->format('h:i A') : 'In Session' }}',
                                member_id: '{{ $dailyLog->member_id ?? 'Not a Member Anymore' }}',
                                full_name: '{{ $dailyLog->full_name ?? '' }}',
                                membership_term_gym_access: '{{ $dailyLog->member->membership_term_gym_access ?? '0' }}',
                                payment_method: '{{ $dailyLog->payment_method ?? '' }}',
                                payment_amount: '{{ $dailyLog->payment_amount ?? '' }}',
                                purpose_of_visit: '{{ $dailyLog->purpose_of_visit }}',
                                staff_assigned: '{{ $dailyLog->staff_assigned ?? '' }}',
                                upgrade_gym_access: '{{ $dailyLog->upgrade_gym_access ?? '' }}',
                                items_bought: [
                                    @foreach($dailyLog->items_bought as $item)
                                        '{{ $item }}'{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                ],
                                notes: '{{ $dailyLog->notes ?? '' }}'
                            })">
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
                                    {{ $dailyLog->member_id ?? 'Not a Member Anymore' }}
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
                        <!-- Delete Log Modal -->
                        <x-delete-modal 
                            modalId="deleteLogModal{{ $dailyLog->id }}"
                            title="Delete Log"
                            message="Are you sure you want to delete this log?"
                            routeName="daily-logs.delete"
                            :itemId="$dailyLog->id"
                        />
                        @endforeach
                        
                    </tbody>
                </table>
                <div id="logDetailsModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-auto p-6 relative">
                        <button onclick="closeLogDetailsModal()" class="absolute top-6 right-6 text-gray-500 hover:text-gray-700">&times;</button>
                        <h3 class="text-xl font-semibold mb-4">Log Details</h3>
                        <div id="logDetailsContent">
                            
                        </div>
                        <button type="button" class="px-2 py-2 mt-5 text-white rounded-md hover:bg-red-700 bg-red-600 transition-colors" id="deleteLogButton">                                    
                            Delete
                        </button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-layout>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>