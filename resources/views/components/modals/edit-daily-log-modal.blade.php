<!-- Edit Daily Log Modal -->
<div id="editDailyLogModal-{{ $dailyLog->id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-6xl p-6 relative overflow-y-auto" style="max-height:90vh;">
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
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date<span class="text-red-500">*</span></label>
                                    <input type="date" id="date" name="date" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->date ? $dailyLog->date : '' }}">
                                    @error('date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="time_in" class="block text-sm font-medium text-gray-700 mb-1">Time in<span class="text-red-500">*</span></label>
                                    <input type="time" id="time_in" name="time_in" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->time_in ? Carbon\Carbon::parse($dailyLog->time_in)->format('H:i') : '' }}">
                                    @error('time_in')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="time_out" class="block text-sm font-medium text-gray-700 mb-1">Time out<span class="text-red-500">*</span></label>
                                    <input type="time" id="time_out" name="time_out" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->time_out ? Carbon\Carbon::parse($dailyLog->time_out)->format('H:i') : '' }}">
                                    @error('time_out')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="white_noise_id_form" class="block text-sm font-medium text-gray-700 mb-1">White Noise ID<span class="text-red-500">*</span></label>
                                    <input type="text" id="white_noise_id_form" name="white_noise_id_form" readonly
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->white_noise_id }}">
                                    @error('white_noise_id_form')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name<span class="text-red-500">*</span></label>
                                    <input type="text" id="full_name" name="full_name" readonly
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->full_name }}">
                                    @error('full_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method<span class="text-red-500">*</span></label>
                                    <select id="payment_method" name="payment_method" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black">
                                        <option {{ $dailyLog->payment_method == 'None' ? 'selected' : '' }} value="None">None</option>
                                        <option {{ $dailyLog->payment_method == 'Cash' ? 'selected' : '' }} value="Cash">Cash</option>    
                                        <option {{ $dailyLog->payment_method == 'GCash' ? 'selected' : '' }} value="GCash">GCash</option>
                                        <option {{ $dailyLog->payment_method == 'Bank Transfer' ? 'selected' : '' }} value="Bank Transfer">Bank Transfer</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="payment_amount" class="block text-sm font-medium text-gray-700 mb-1">Payment Amount<span class="text-red-500">*</span></label>
                                    <input type="number" id="payment_amount" name="payment_amount" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->payment_amount ?? '0' }}" placeholder="Enter amount in PHP">
                                    @error('payment_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="staff_assigned" class="block text-sm font-medium text-gray-700 mb-1">Staff Assigned<span class="text-red-500">*</span></label>
                                    <input type="text" id="staff_assigned" name="staff_assigned" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-black focus:border-black"
                                        value="{{ $dailyLog->staff_assigned ?? '' }}">
                                    @error('staff_assigned')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="pt-6">
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

                            <div class="grid grid-cols-1 lg:grid-cols-6 gap-6 mt-5">
                                <!-- Member Type Column -->
                                <div class="lg:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Member Type<span class="text-red-500">*</span></label>
                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center">
                                            <input type="radio" id="member_type_regular" name="member_type" value="Regular" class="h-4 w-4 text-black focus:ring-black border-gray-300"
                                                {{ $dailyLog->member && $dailyLog->member->member_type ? ($dailyLog->member->member_type == 'Regular' ? 'checked' : '') : '' }}>
                                            <label for="member_type_regular" class="ml-2 block text-sm text-gray-700">Regular</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="member_type_student" name="member_type" value="Student" class="h-4 w-4 text-black focus:ring-black border-gray-300"
                                                {{ $dailyLog->member && $dailyLog->member->member_type ? ($dailyLog->member->member_type == 'Student' ? 'checked' : '') : '' }}>
                                            <label for="member_type_student" class="ml-2 block text-sm text-gray-700">Student</label>
                                        </div>
                                    </div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Gym Access<span class="text-red-500">*</span></label>
                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center">
                                            <input type="radio" id="gym_access_none" name="gym_access" value="None" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ $dailyLog->member && $dailyLog->member->membership_term_gym_access ? ($dailyLog->member->membership_term_gym_access == 'None' ? 'checked' : '') : '' }}>
                                            <label for="gym_access_none" class="ml-2 block text-sm text-gray-700">None</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="gym_access_1_month" name="gym_access" value="1 month" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ $dailyLog->member && $dailyLog->member->membership_term_gym_access ? ($dailyLog->member->membership_term_gym_access == '1 month' ? 'checked' : '') : '' }}>
                                            <label for="gym_access_1_month" class="ml-2 block text-sm text-gray-700">1 Month</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="gym_access_3_month" name="gym_access" value="3 months" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ $dailyLog->member && $dailyLog->member->membership_term_gym_access ? ($dailyLog->member->membership_term_gym_access == '3 months' ? 'checked' : '') : '' }}>
                                            <label for="gym_access_3_month" class="ml-2 block text-sm text-gray-700">3 Months</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="gym_access_walk_in" name="gym_access" value="Walk in" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ $dailyLog->member && $dailyLog->member->membership_term_gym_access ? ($dailyLog->member->membership_term_gym_access == 'Walk in' ? 'checked' : '') : '' }}>
                                            <label for="gym_access_walk_in" class="ml-2 block text-sm text-gray-700">Walk in</label>
                                        </div>
                                    </div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Personal Trainer<span class="text-red-500">*</span></label>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" id="personal_trainer_none" name="personal_trainer" value="None" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ $dailyLog->member && $dailyLog->member->with_pt ? ($dailyLog->member->with_pt == 'None' ? 'checked' : '') : '' }}>
                                            <label for="personal_trainer_none" class="ml-2 block text-sm text-gray-700">None</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="radio" id="personal_trainer_1_month" name="personal_trainer" value="1 month" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ $dailyLog->member && $dailyLog->member->with_pt ? ($dailyLog->member->with_pt == '1 month' ? 'checked' : '') : '' }}>
                                            <label for="personal_trainer_1_month" class="ml-2 block text-sm text-gray-700">1 Month</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Purpose of Visit Column -->
                                <div class="lg:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Purpose of Visit<span class="text-red-500">*</span></label>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="checkbox" id="gym_use" name="purpose_of_visit[]" value="Gym Use" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ in_array('Gym Use', $dailyLog->purpose_of_visit) ? 'checked' : '' }}>
                                            <label for="gym_use" class="ml-2 block text-sm text-gray-700">Gym Use</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="membership_payment" name="purpose_of_visit[]" value="Membership Payment" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ in_array('Membership Payment', $dailyLog->purpose_of_visit) ? 'checked' : '' }}>
                                            <label for="membership_payment" class="ml-2 block text-sm text-gray-700">Membership Payment</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="gym_access_payment" name="purpose_of_visit[]" value="Gym Access Payment" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ in_array('Gym Access Payment', $dailyLog->purpose_of_visit) ? 'checked' : '' }}>
                                            <label for="gym_access_payment" class="ml-2 block text-sm text-gray-700">Gym Access Payment</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="pt_payment" name="purpose_of_visit[]" value="Personal Trainer Payment" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ in_array('Personal Trainer Payment', $dailyLog->purpose_of_visit) ? 'checked' : '' }}>
                                            <label for="pt_payment" class="ml-2 block text-sm text-gray-700">Personal Trainer Payment</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="renew_membership" name="purpose_of_visit[]" value="Renew Membership" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ in_array('Renew Membership', $dailyLog->purpose_of_visit) ? 'checked' : '' }}>
                                            <label for="renew_membership" class="ml-2 block text-sm text-gray-700">Renew Membership</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="renew_gym_access" name="purpose_of_visit[]" value="Renew Gym Access" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ in_array('Renew Gym Access', $dailyLog->purpose_of_visit) ? 'checked' : '' }}>
                                            <label for="renew_gym_access" class="ml-2 block text-sm text-gray-700">Renew Gym Access</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="renew_pt" name="purpose_of_visit[]" value="Renew Personal Trainer" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ in_array('Renew Personal Trainer', $dailyLog->purpose_of_visit) ? 'checked' : '' }}>
                                            <label for="renew_pt" class="ml-2 block text-sm text-gray-700">Renew Personal Trainer</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="pt_1_day" name="purpose_of_visit[]" value="Personal Trainer 1 Day" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ in_array('Personal Trainer 1 Day', $dailyLog->purpose_of_visit) ? 'checked' : '' }}>
                                            <label for="pt_1_day" class="ml-2 block text-sm text-gray-700">Personal Trainer 1 Day</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="remove_gym_access" name="purpose_of_visit[]" value="Remove Gym Access" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ in_array('Remove Gym Access', $dailyLog->purpose_of_visit) ? 'checked' : '' }}>
                                            <label for="remove_gym_access" class="ml-2 block text-sm text-gray-700">Remove Gym Access</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" id="remove_pt" name="purpose_of_visit[]" value="Remove Personal Trainer" class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded"
                                                {{ in_array('Remove Personal Trainer', $dailyLog->purpose_of_visit) ? 'checked' : '' }}>
                                            <label for="remove_pt" class="ml-2 block text-sm text-gray-700">Remove Personal Trainer</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="lg:col-span-2">
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

                                <div class="lg:col-span-2">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                    <textarea id="notes" name="notes" rows="12" class="w-full h-[175px] px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        >{{ $dailyLog->notes ?? old('notes') }}</textarea>
                                </div>
                            </div>
            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6">
                <button type="button" onclick="closeEditDailyLogModal({{ $dailyLog->id }})" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" onclick="document.getElementById('confirmEditDailyLogModal-{{ $dailyLog->id }}').classList.remove('hidden')" 
                        class="px-4 py-2 rounded-md text-white bg-black hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black/80">
                    Save Changes
                </button>
                <button type="button" onclick="document.getElementById('confirmDeleteDailyLogModal-{{ $dailyLog->id }}').classList.remove('hidden')" 
                        class="px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete Log
                </button>
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