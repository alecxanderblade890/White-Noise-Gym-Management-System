<!-- Edit Daily Log Modal -->
<div id="editDailyLogModal-{{ $dailyLog->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-4 md:p-8 relative overflow-y-auto" style="max-height:90vh;">
        <button onclick="closeEditDailyLogModal({{ $dailyLog->id }})" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Daily Log</h2>

        <x-alert/>

        <form action="{{ route('daily-log.update', $dailyLog->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="editDailyLogForm">
            @csrf
            @method('PUT')

            <x-modals.confirm-modal 
                :modalId="'confirmEditDailyLogModal-' . $dailyLog->id"
                title="Confirm Edit Daily Log"
                message="Are you sure you want to apply changes to this daily log? Please enter password to confirm."
                :useSameForm="true"
            />
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" id="date" name="date" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               value="{{$dailyLog->date}}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Time In</label>
                        <input type="time" id="time_in" name="time_in" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               value="{{ \Carbon\Carbon::parse($dailyLog->time_in)->format('H:i') }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Time Out</label>
                        <input type="time" id="time_out" name="time_out" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               value="{{ $dailyLog->time_out ? \Carbon\Carbon::parse($dailyLog->time_out)->format('H:i') : '' }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Member ID</label>
                        <input type="text" id="form_member_id" name="form_member_id" required readonly
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               value="{{$dailyLog->member_id}}">
                    </div>
                </div>

                <!-- Middle Column -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <select id="payment_method" name="payment_method" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500">
                            <option value="None" {{ $dailyLog->payment_method === 'None' ? 'selected' : '' }}>None</option>
                            <option value="Cash" {{ $dailyLog->payment_method === 'Cash' ? 'selected' : '' }}>Cash</option>    
                            <option value="GCash" {{ $dailyLog->payment_method === 'GCash' ? 'selected' : '' }}>GCash</option>
                            <option value="Bank Transfer" {{ $dailyLog->payment_method === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Amount</label>
                        <input type="number" id="payment_amount" name="payment_amount" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               placeholder="0.00"
                               value="{{$dailyLog->payment_amount}}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Staff Assigned</label>
                        <input type="text" id="staff_assigned" name="staff_assigned" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               value="{{$dailyLog->staff_assigned}}">
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <label for="purpose_of_visit" class="block text-sm font-medium text-gray-700 mb-1">Purpose of Visit<span class="text-red-500">*</span></label>
                        <select id="purpose_of_visit" name="purpose_of_visit" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black">
                            <option value="Membership" {{ $dailyLog->purpose_of_visit === 'Membership' ? 'selected' : '' }}>Membership</option>    
                            <option value="Membership Term" {{ $dailyLog->purpose_of_visit === 'Membership Term' ? 'selected' : '' }}>Membership Term</option>    
                            <option value="Personal Trainer" {{ $dailyLog->purpose_of_visit === 'Personal Trainer' ? 'selected' : '' }}>Personal Trainer</option>   
                            <option value="Gym Use" {{ $dailyLog->purpose_of_visit === 'Gym Use' ? 'selected' : '' }}>Gym Use</option>     
                            <option value="Gym Use & Membership Payment" {{ $dailyLog->purpose_of_visit === 'Gym Use & Membership Payment' ? 'selected' : '' }}>Gym Use & Membership Payment</option>    
                            <option value="Gym Use & Membership Term Payment" {{ $dailyLog->purpose_of_visit === 'Gym Use & Membership Term Payment' ? 'selected' : '' }}>Gym Use & Membership Term Payment</option>    
                            <option value="Gym Use & Personal Trainer Payment" {{ $dailyLog->purpose_of_visit === 'Gym Use & Personal Trainer Payment' ? 'selected' : '' }}>Gym Use & Personal Trainer Payment</option>    
                        </select>
                        @error('purpose_of_visit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Items Bought</label>
                        <div class="space-y-4">
                            @php
                                $commonItems = [
                                    'Pocari Sweat',
                                    'Gatorade Blue',
                                    'Gatorade Red',
                                    'Bottled Water'
                                ];
                                
                                $tShirts = [
                                    'White - Large',
                                    'White - XL',
                                    'Black - Large',
                                    'Black - XL',
                                    'Black - XS',
                                    'Black - Medium',
                                ];
                            @endphp
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Drinks</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($commonItems as $item)
                                        <div class="flex items-center">
                                            <input id="edit-item-{{ $loop->index }}" name="items[]" type="checkbox" value="{{ $item }}" 
                                                   class="item-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                   {{ in_array($item, $dailyLog->items_bought) ? 'checked' : '' }}>
                                            <label for="edit-item-{{ $loop->index }}" class="ml-2 block text-sm text-gray-700">
                                                {{ $item }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="pt-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">T-Shirts</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($tShirts as $shirt)
                                        <div class="flex items-center">
                                            <input id="edit-tshirt-{{ $loop->index }}" name="t_shirts[]" type="checkbox" value="{{ $shirt }}" 
                                                   class="tshirt-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                   {{ in_array($shirt, $dailyLog->items_bought) ? 'checked' : '' }}>
                                            <label for="edit-tshirt-{{ $loop->index }}" class="ml-2 block text-sm text-gray-700">
                                                {{ $shirt }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <textarea id="notes" name="notes" rows="3"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500"
                               placeholder="Additional notes">{{ $dailyLog->notes }}</textarea>
                    </div>
                    <div class="pt-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="upgrade_gym_access" name="upgrade_gym_access" 
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   {{ $dailyLog->upgrade_gym_access ? 'checked' : '' }}>
                            <label for="upgrade_gym_access" class="ml-2 block text-sm text-gray-700">
                                Upgrade Gym Access
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6">
                <button type="button" onclick="closeEditDailyLogModal({{ $dailyLog->id }})" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" onclick="document.getElementById('confirmEditDailyLogModal-{{ $dailyLog->id }}').classList.remove('hidden')" class="px-4 py-2 rounded-md text-white bg-black hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black/80">Save Changes</button>
                <button type="button" onclick="document.getElementById('confirmDeleteDailyLogModal-{{ $dailyLog->id }}').classList.remove('hidden')" class="px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Delete Log</button>
            </div>
        </form>
       <x-modals.delete-modal 
            :modalId="'confirmDeleteDailyLogModal-' . $dailyLog->id"
            title="Confirm Delete Daily Log"
            message="Are you sure you want to delete this daily log? Please enter password to confirm."
            :useSameForm="true"
            :routeName="'daily-log.delete'"
            :itemId="$dailyLog->id"
        />
    </div>
</div>