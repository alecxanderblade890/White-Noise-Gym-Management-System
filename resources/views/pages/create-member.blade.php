<x-layout>
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <!-- Back button -->
        <a href="{{ route('members.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Register New Member</h1>
        
        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <!-- Photo Upload -->
            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Profile Photo</h2>
                
                <div class="flex items-center space-x-6">
                    <div class="shrink-0">
                        <img id="photo-preview" class="h-20 w-20 rounded-full object-cover" src="{{ asset('images/default-avatar.png') }}" alt="Profile photo preview">
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
            <!-- Personal Information Section -->
            <div class="bg-gray-50 p-6 rounded-lg mb-6">
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
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" id="phone" name="phone" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('phone') }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Date of Birth -->
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Date of Birth <span class="text-red-500">*</span></label>
                        <input type="date" id="date_of_birth" name="date_of_birth" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('date_of_birth') }}">
                        @error('date_of_birth')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- ID Type -->
                    <div>
                        <label for="id_type" class="block text-sm font-medium text-gray-700 mb-1">ID Type <span class="text-red-500">*</span></label>
                        <input type="text" id="id_type" name="id_type" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('id_type') }}">
                        @error('id_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- ID Number -->
                    <div>
                        <label for="id_number" class="block text-sm font-medium text-gray-700 mb-1">ID Number <span class="text-red-500">*</span></label>
                        <input type="text" id="id_number" name="id_number"
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
            <div class="bg-gray-50 p-6 rounded-lg mb-6">
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
            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Membership Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date <span class="text-red-500">*</span></label>
                        <input type="date" id="start_date" name="start_date" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('start_date', now()->format('Y-m-d')) }}">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- End Date -->
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date <span class="text-red-500">*</span></label>
                        <input type="date" id="end_date" name="end_date" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('end_date', now()->format('Y-m-d')) }}">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Billing Rate -->
                    <div>
                        <label for="billing_rate" class="block text-sm font-medium text-gray-700 mb-1">Billing Rate <span class="text-red-500">*</span></label>
                        <input type="number" id="billing_rate" name="billing_rate" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('billing_rate') }}" placeholder="Enter billing rate in Php">
                        @error('billing_rate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Payment Date (Membership) -->
                    <div>
                        <label for="payment_date_membership" class="block text-sm font-medium text-gray-700 mb-1">Payment Date (Membership) <span class="text-red-500">*</span></label>
                        <input type="date" id="payment_date_membership" name="payment_date_membership" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('payment_date_membership') }}" placeholder="Enter payment date">
                        @error('payment_date_membership')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Payment Date (Gym Access) -->
                    <div>
                        <label for="payment_date_gym_access" class="block text-sm font-medium text-gray-700 mb-1">Payment Date (Gym Access) <span class="text-red-500">*</span></label>
                        <input type="date" id="payment_date_gym_access" name="payment_date_gym_access" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('payment_date_gym_access') }}" placeholder="Enter payment date">
                        @error('payment_date_gym_access')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Membership Term (Gym Access) -->
                    <div>
                        <label for="membership_term" class="block text-sm font-medium text-gray-700 mb-1">Membership Term <span class="text-red-500">*</span></label>
                        <input type="text" id="membership_term" name="membership_term" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('membership_term') }}" placeholder="Enter membership term">
                        @error('membership_term')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Emergency Contact Section -->
            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Emergency Contact</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Emergency Contact Name -->
                    <div>
                        <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('emergency_contact_name') }}">
                        @error('emergency_contact_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Emergency Contact Relationship -->
                    <div>
                        <label for="emergency_contact_relationship" class="block text-sm font-medium text-gray-700 mb-1">Relationship <span class="text-red-500">*</span></label>
                        <input type="text" id="emergency_contact_relationship" name="emergency_contact_relationship" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('emergency_contact_relationship') }}" placeholder="e.g., Spouse, Parent, Sibling">
                        @error('emergency_contact_relationship')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Emergency Contact Phone -->
                    <div>
                        <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" required
                               class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="{{ old('emergency_contact_phone') }}">
                        @error('emergency_contact_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- Notes -->
            <div class="bg-gray-50 p-6 rounded-lg mb-6">
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
                <a href="{{ route('members.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Register Member
                </button>
            </div>
        </form>
    </div>
    
    @push('scripts')
    <script>
        // Initialize date pickers with appropriate max dates
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            
            // // Set max date for date of birth (must be at least 13 years old)
            // const dobInput = document.getElementById('date_of_birth');
            // if (dobInput) {
            //     const maxDob = new Date();
            //     maxDob.setFullYear(maxDob.getFullYear() - 13);
            //     dobInput.max = maxDob.toISOString().split('T')[0];
            // }
            
            // Set min date for start date (today)
            const startDateInput = document.getElementById('start_date');
            if (startDateInput) {
                startDateInput.min = today;
            }
        });
    </script>
    @endpush
</x-layout>