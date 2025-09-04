<!-- Edit Daily Log Modal -->
<div id="editDayPassModal-{{ $dailyLog->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-6xl p-6 relative overflow-y-auto" style="max-height:90vh;">
        <button onclick="closeEditDayPassModal({{ $dailyLog->id }})" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Day Pass</h2>

        <x-alert/>

        <form action="{{route('daily-log.update-day-pass', $dailyLog->id)}}" method="POST" enctype="multipart/form-data" class="space-y-6" id="dayPassForm">
            @csrf
            @method('PUT')
            <x-modals.confirm-modal 
                :modalId="'confirmEditDayPassModal-' . $dailyLog->id"
                title="Confirm Edit Day Pass"
                message="Are you sure you want to apply changes to this day pass? Please enter password to confirm."
                :useSameForm="true"
            />
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <div>
                                    <label for="date_day_pass" class="block text-sm font-medium text-gray-700 mb-1">Date<span class="text-red-500">*</span></label>
                                    <input type="date" id="date_day_pass" name="date_day_pass" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->date }}">
                                    @error('date_day_pass')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="time_in_day_pass" class="block text-sm font-medium text-gray-700 mb-1">Time in<span class="text-red-500">*</span></label>
                                    <input type="time" id="time_in_day_pass" name="time_in_day_pass" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->time_in ? Carbon\Carbon::parse($dailyLog->time_in)->format('H:i') : '' }}">
                                    @error('time_in_day_pass')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="time_out_day_pass" class="block text-sm font-medium text-gray-700 mb-1">Time out<span class="text-red-500">*</span></label>
                                    <input type="time" id="time_out_day_pass" name="time_out_day_pass" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->time_out ? Carbon\Carbon::parse($dailyLog->time_out)->format('H:i') : '' }}">
                                    @error('time_out_day_pass')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="full_name_day_pass" class="block text-sm font-medium text-gray-700 mb-1">Full Name<span class="text-red-500">*</span></label>
                                    <input type="text" id="full_name_day_pass" name="full_name_day_pass"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->full_name }}">
                                    @error('full_name_day_pass')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="payment_method_day_pass" class="block text-sm font-medium text-gray-700 mb-1">Payment Method<span class="text-red-500">*</span></label>
                                    <select id="payment_method_day_pass" name="payment_method_day_pass" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black">
                                        <option {{ $dailyLog->payment_method == 'None' ? 'selected' : '' }} value="None">None</option>
                                        <option {{ $dailyLog->payment_method == 'Cash' ? 'selected' : '' }} value="Cash">Cash</option>    
                                        <option {{ $dailyLog->payment_method == 'GCash' ? 'selected' : '' }} value="GCash">GCash</option>
                                        <option {{ $dailyLog->payment_method == 'Bank Transfer' ? 'selected' : '' }} value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="payment_amount_day_pass" class="block text-sm font-medium text-gray-700 mb-1">Payment Amount<span class="text-red-500">*</span></label>
                                    <input type="number" id="payment_amount_day_pass" name="payment_amount_day_pass" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->payment_amount }}" placeholder="Enter amount in PHP">
                                    @error('payment_amount_day_pass')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="staff_assigned_day_pass" class="block text-sm font-medium text-gray-700 mb-1">Staff Assigned<span class="text-red-500">*</span></label>
                                    <input type="text" id="staff_assigned_day_pass" name="staff_assigned_day_pass" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->staff_assigned }}">
                                    @error('staff_assigned_day_pass')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-6 gap-6 mt-5">
                                <!-- Purpose of Visit Column
                                <div class="lg:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Purpose of Visit<span class="text-red-500">*</span></label>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="gym_use_day_pass" name="purpose_of_visit_day_pass[]" value="Gym Use" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                                            <label for="gym_use_day_pass" class="ml-2 block text-sm text-gray-700">Gym Use</label>
                                        </div>
                                    </div>
                                </div> -->

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
                                                    <input id="item-{{ $loop->index }}" name="items_day_pass[]" type="checkbox" value="{{ $item }}" 
                                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                        {{ in_array($item, $dailyLog->items_bought) ? 'checked' : '' }}>
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
                                                    <input id="tshirt-{{ $index }}" name="t_shirts_day_pass[]" type="checkbox" value="{{ $tShirt }}" 
                                                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                        {{ in_array($tShirt, $dailyLog->items_bought) ? 'checked' : '' }}>
                                                    <label for="tshirt-{{ $index }}" class="ml-2 block text-sm text-gray-700">
                                                        {{ $tShirt }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:col-span-2">
                                    <label for="notes_day_pass" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                    <textarea id="notes_day_pass" name="notes_day_pass" rows="12" class="w-full h-[175px] px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ $dailyLog->notes }}</textarea>
                                </div>
                            </div>
            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6">
                <button type="button" onclick="closeEditDayPassModal({{ $dailyLog->id }})" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" onclick="document.getElementById('confirmEditDayPassModal-{{ $dailyLog->id }}').classList.remove('hidden')" 
                        class="px-4 py-2 rounded-md text-white bg-black hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black/80">
                    Save Changes
                </button>
                <button type="button" onclick="document.getElementById('confirmDeleteDayPassModal-{{ $dailyLog->id }}').classList.remove('hidden')" 
                        class="px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete Log
                </button>
            </div>
        </form>
        <x-modals.delete-modal 
            :modalId="'confirmDeleteDayPassModal-' . $dailyLog->id"
            title="Confirm Delete Day Pass"
            message="Are you sure you want to delete this day pass? Please enter password to confirm."
            :useSameForm="true"
            :routeName="'daily-log.delete'"
            :itemId="$dailyLog->id"
        />
    </div>
</div>