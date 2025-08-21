 <!-- Edit Profile Modal -->
 <div id="editProfileModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-4 md:p-8 relative overflow-y-auto" style="max-height:90vh;">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Member Profile</h2>

        <x-alert/>

            <form action="{{ route('update-member', $member->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <x-modals.confirm-modal 
                    modalId="confirmEditProfileModal"
                    title="Confirm Edit Profile"
                    message="Are you sure you want to apply changes to this profile? Please enter password to confirm."
                    :useSameForm="true"
                />
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Photo Upload -->
                    <div class="col-span-2">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Profile Photo</h2>
                        <div class="flex items-center space-x-6">
                            <div class="shrink-0">
                                <img id="photo-preview" class="h-20 w-20 rounded-full object-cover" src="{{ $member->photo_url ?? asset('images/default-avatar.png') }}" alt="Profile photo preview">
                            </div>
                            <label class="block">
                                <span class="sr-only">Choose profile photo</span>
                                <input type="file" id="photo" name="photo" accept="image/*" class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100"
                                    onchange="document.getElementById('photo-preview').src = window.URL.createObjectURL(this.files[0])">
                            </label>
                        </div>
                        @error('photo')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="full_name" value="{{ $member->full_name }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ $member->email }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="tel" name="phone_number" value="{{ $member->phone_number }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ $member->date_of_birth }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <input type="text" name="address" value="{{ $member->address }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID Presented</label>
                        <input type="text" name="id_presented" value="{{ $member->id_presented }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">ID Number</label>
                        <input type="text" name="id_number" value="{{ $member->id_number }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Height (cm)</label>
                        <input type="number" name="height_cm" value="{{ $member->height_cm }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Weight (kg)</label>
                        <input type="number" name="weight_kg" value="{{ $member->weight_kg }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Person</label>
                        <input type="text" name="emergency_contact_person" value="{{ $member->emergency_contact_person }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Emergency Contact Number</label>
                        <input type="text" name="emergency_contact_number" value="{{ $member->emergency_contact_number }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Member Type</label>
                        <select id="member_type" name="member_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Student" {{ $member->member_type == 'Student' ? 'selected' : '' }}>Student</option>
                            <option value="Regular" {{ $member->member_type == 'Regular' ? 'selected' : '' }}>Regular</option>
                        </select>                
                    </div>

                    <!-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Membership Start Date</label>
                        <input type="date" name="membership_start_date" value="{{ $member->membership_start_date }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Membership End Date</label>
                        <input type="date" name="membership_end_date" value="{{ $member->membership_end_date }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gym Access Start Date</label>
                        <input type="date" id="gym_access_start_date" name="gym_access_start_date" value="{{ $member->gym_access_start_date }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" onchange="calculateMembershipTerm()">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gym Access End Date</label>
                        <input type="date" id="gym_access_end_date" name="gym_access_end_date" value="{{ $member->gym_access_end_date }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500" onchange="calculateMembershipTerm()">
                    </div> -->
                    <!-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Membership Term (Gym Access)</label>
                        <input type="hidden" id="membership_term_billing_rate_hidden" name="membership_term_billing_rate" value="0">
                        <select id="membership_term_gym_access" name="membership_term_gym_access" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="None" {{ $member->membership_term_gym_access == 'None' ? 'selected' : '' }}>None</option>
                            <option value="1 month" {{ $member->membership_term_gym_access == '1 month' ? 'selected' : '' }}>1 Month</option>
                            <option value="3 months" {{ $member->membership_term_gym_access == '3 months' ? 'selected' : '' }}>3 Months</option>
                            <option value="Walk in" {{ $member->membership_term_gym_access == 'Walk in' ? 'selected' : '' }}>Walk In</option>
                        </select>                
                    </div> -->
                    <!-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">With Personal Trainer</label>
                        <input type="hidden" id="with_pt_billing_rate_hidden" name="with_pt_billing_rate" value="0">
                        <select id="with_pt" name="with_pt" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="None" {{ $member->with_pt == 'None' ? 'selected' : '' }}>None</option>
                            <option value="1 month" {{ $member->with_pt == '1 month' ? 'selected' : '' }}>1 Month</option>
                        </select>                
                    </div> -->
                    <input type="hidden" id="white_noise_id" name="white_noise_id" value="{{ $member->white_noise_id }}">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <input type="text" name="notes" value="{{ $member->notes }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex justify-end space-x-4 pt-6">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</button>
                    <button type="button" onclick="document.getElementById('confirmEditProfileModal').classList.remove('hidden')" class="px-4 py-2 rounded-md text-white bg-black hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black/80">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
