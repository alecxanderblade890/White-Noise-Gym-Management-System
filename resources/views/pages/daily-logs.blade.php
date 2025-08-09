<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Daily Logs</h1>

        <x-alert />

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-700">Daily Log List</h2>
                
                <!-- Date Range Filter -->
                <form action="{{ route('daily-logs.filter') }}" method="GET" class="flex items-end space-x-4">
                    <div class="flex items-center space-x-2">
                        <div>
                            <label for="start_date" class="block text-xs font-medium text-gray-500 mb-1">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ $start_date ? $start_date : '' }}" 
                                   class="w-40 px-2 py-1 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <span class="text-gray-400 mt-4">-></span>
                        <div>
                            <label for="end_date" class="block text-xs font-medium text-gray-500 mb-1">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ $end_date ? $end_date : '' }}"
                                   class="w-40 px-2 py-1 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-black hover:bg-black/80 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-black/80">
                            Filter
                        </button>
                    </div>
                </form>
            </div>
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
                        @foreach ($dailyLogsAll as $dailyLog)
                            <tr class="hover:bg-gray-50 cursor-pointer" 
                                onclick="openEditDailyLogModal({{ $dailyLog }})">
                                <x-edit-daily-log-modal :dailyLog="$dailyLog"/>
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
                                    <form action="{{ route('daily-log.update-time-out', $dailyLog->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to update the time out status?')">
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