<x-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Back button -->
        <x-navigate-back :href="route('manage-members.index')">
            Back
        </x-navigate-back>
        
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Register New Member</h1>

        <x-alert/>
        
        <form id="member-registration-form" action="{{route('add-member')}}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <!-- Photo Upload -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Profile Photo</h2>
                
                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        <img id="photo-preview" class="h-20 w-20 rounded-full object-cover" src="{{ asset('images/placeholder_profile.png') }}" alt="Profile photo preview">
                    </div>
                    <label class="block">
                    <span class="sr-only">Choose profile photo</span>
                    <input type="file" id="photo" name="photo" accept="image/*" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-gray-200 file:text-gray-700
                        hover:file:bg-gray-300"
                        onchange="document.getElementById('photo-preview').src = window.URL.createObjectURL(this.files[0])" require>
                    </label>
                </div>
                @error('photo')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <!-- Personal Information Section -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Personal Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- First Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="full_name" name="full_name" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('full_name') }}">
                        @error('full_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Phone -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" id="phone_number" name="phone_number" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('phone_number')}}">
                        @error('phone_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Date of Birth -->
                    <div>
                        <?php
                            $minAge = 13;
                            $maxDate = \Carbon\Carbon::now()->subYears($minAge)->format('Y-m-d');
                        ?>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" id="date_of_birth" name="date_of_birth" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('date_of_birth') }}"">
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Weight (Kg) -->
                    <div>
                        <label for="weight_kg" class="block text-sm font-medium text-gray-700 mb-1">Weight (kg) <span class="text-red-500">*</span></label>
                        <input type="number" id="weight_kg" name="weight_kg"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('weight_kg') }}">
                        @error('weight_kg')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Height (cm) -->
                    <div>
                        <label for="height_cm" class="block text-sm font-medium text-gray-700 mb-1">Height (cm)<span class="text-red-500">*</span></label>
                        <input type="number" id="height_cm" name="height_cm"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('height_cm') }}">
                        @error('height_cm')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- ID Type -->
                    <div>
                        <label for="id_presented" class="block text-sm font-medium text-gray-700 mb-1">ID Type <span class="text-red-500">*</span></label>
                        <input type="text" id="id_presented" name="id_presented" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('id_presented')}}">
                        @error('id_presented')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- ID Number -->
                    <div>
                        <label for="id_number" class="block text-sm font-medium text-gray-700 mb-1">ID Number <span class="text-red-500">*</span></label>
                        <input type="number" id="id_number" name="id_number"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('id_number') }}">
                        @error('id_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Gender -->
                    <!-- <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gender <span class="text-red-500">*</span></label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="male" class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                       {{ old('gender') == 'male' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Male</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="female" class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                       {{ old('gender') == 'female' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Female</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="other" class="h-4 w-4 text-blue-600 focus:ring-blue-500"
                                       {{ old('gender') == 'other' ? 'checked' : '' }}>
                                <span class="ml-2 text-gray-700">Other</span>
                            </label>
                        </div>
                        @error('gender')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> -->
                </div>
            </div>
            
            <!-- Address Section -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Address Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Street Address -->
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-500">*</span></label>
                        <input type="text" id="address" name="address" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('address') }}">
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Membership Section -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Membership Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Member Type -->
                    <div>
                        <label for="member_type" class="block text-sm font-medium text-gray-700 mb-1">Member Type <span class="text-red-500">*</span></label>
                        <select id="member_type" name="member_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Student" {{ old('member_type') == 'Student' ? 'selected' : '' }}>Student</option>
                            <option value="Regular" {{ old('member_type') == 'Regular' ? 'selected' : '' }}>Regular</option>
                        </select>
                        @error('member_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                     <!-- Membership Term (Gym Access) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="membership_term_gym_access" class="block text-sm font-medium text-gray-700 mb-1">Membership Term (Gym Access) <span class="text-red-500">*</span></label>
                            <select id="membership_term_gym_access" name="membership_term_gym_access" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="None" {{ old('membership_term_gym_access') == 'None' ? 'selected' : '' }}>None</option>
                                <option value="1 month" {{ old('membership_term_gym_access') == '1 month' ? 'selected' : '' }}>1 Month</option>
                                <option value="3 months" {{ old('membership_term_gym_access') == '3 months' ? 'selected' : '' }}>3 Months</option>
                                <option value="Walk in" {{ old('membership_term_gym_access') == 'Walk in' ? 'selected' : '' }}>Walk In</option>
                            </select>
                            @error('membership_term_gym_access')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Membership Term Billing Rate -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Membership Term Billing Rate</label>
                            <div class="mt-1 flex items-center">
                                <input type="hidden" id="membership_term_billing_rate_hidden" name="membership_term_billing_rate" value="0">
                                <input type="text" id="membership_term_billing_rate" readonly
                                    class="w-full pl-4 py-2 border border-gray-300 rounded-l-md bg-gray-50 text-gray-700 focus:outline-none"
                                    value="₱0">
                                <span id="billing-rate-suffix" class="flex-1 px-4 py-2 border border-gray-300 rounded-r-md bg-gray-50 text-gray-700 focus:outline-none">
                                    /month
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- With PT -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <input type="hidden" id="pt_start_date" name="pt_start_date" value="">
                            <input type="hidden" id="pt_end_date" name="pt_end_date" value="">
                            <input type="hidden" id="current_end_date_pt" name="current_end_date_pt" value="">
                            <label for="with_pt" class="block text-sm font-medium text-gray-700 mb-1">With Personal Trainer <span class="text-red-500">*</span></label>
                            <select id="with_pt" name="with_pt" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="None" {{ old('with_pt') == 'None' ? 'selected' : '' }}>None</option>
                                <option value="1 month" {{ old('with_pt') == '1 month' ? 'selected' : '' }}>1 Month</option>
                            </select>
                            @error('with_pt')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- With PT Billing Rate -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">With Personal Trainer Billing Rate</label>
                            <div class="mt-1 flex items-center">
                                <input type="hidden" id="with_pt_billing_rate_hidden" name="with_pt_billing_rate" value="0">
                                <input type="text" id="with_pt_billing_rate" readonly
                                    class="flex-1 pl-4 py-2 border border-gray-300 rounded-l-md bg-gray-50 text-gray-700 focus:outline-none"
                                    value="₱0">
                                <span id="billing-rate-suffix" class="flex-1 px-4 py-2 border border-gray-300 rounded-r-md bg-gray-50 text-gray-700 focus:outline-none">
                                    /month
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Membership Period -->
                    <div>
                        <input type="hidden" id="current_end_date" value="">
                        <input type="hidden" id="gym_access_end_date" class="hidden" readonly>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Membership Period <span class="text-red-500">*</span></label>
                        <div class="flex items-center space-x-2">
                            <input type="text" readonly
                                   class="w-1/2 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700"
                                   value="{{ now()->format('F d, Y') }}">
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input type="text" readonly
                                   class="w-1/2 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700"
                                   value="{{ now()->addYear()->format('F d, Y') }}">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">1 Year Membership Period</p>
                        @error('payment_date_membership')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Payment Date (Gym Access) -->
                    <div>
                        <label for="gym_access_start_date" class="block text-sm font-medium text-gray-700 mb-1">Payment Date (Gym Access)</label>
                        <input type="text" id="gym_access_start_date" name="gym_access_start_date" readonly
                               class="w-full px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700"
                               value="{{ old('gym_access_start_date') }}">
                        @error('gym_access_start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Emergency Contact Section -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Emergency Contact</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Emergency Contact Name -->
                    <div>
                        <label for="emergency_contact_person" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                        <input type="text" id="emergency_contact_person" name="emergency_contact_person" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('emergency_contact_person') }}">
                        @error('emergency_contact_person')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Emergency Contact Phone -->
                    <div>
                        <label for="emergency_contact_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" id="emergency_contact_number" name="emergency_contact_number" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('emergency_contact_number') }}">
                        @error('emergency_contact_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- Notes -->
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Notes</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
                        <input type="text" id="notes" name="notes"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('notes') }}">
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> 
                </div>
            </div>
            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6">
                <a href="{{ route('manage-members.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" 
                        id="register-button"
                        class="inline-flex items-center justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-black hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg id="spinner" class="hidden -ml-1 mr-2 h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="button-text">Register Member</span>
                </button>
            </div>
        </form>
    </div>
</x-layout>