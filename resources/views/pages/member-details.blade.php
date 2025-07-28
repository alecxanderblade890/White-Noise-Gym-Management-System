<x-layout>
    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-4 md:p-8 relative overflow-y-auto" style="max-height:90vh;">
            <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Member Profile</h2>

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
            <form action="{{ route('update-member', $member->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Date (Membership)</label>
                        <input type="date" name="payment_date_membership" value="{{ $member->payment_date_membership }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Date (Gym Access)</label>
                        <input type="date" name="payment_date_gym_access" value="{{ $member->payment_date_gym_access }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Membership Term (months)</label>
                        <input type="number" name="membership_term_gym_access" value="{{ $member->membership_term_gym_access }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date" name="start_date" value="{{ $member->start_date }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date" name="end_date" value="{{ $member->end_date }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Billing Rate</label>
                        <input type="number" name="billing_rate" value="{{ $member->billing_rate }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                        <input type="text" name="notes" value="{{ $member->notes }}" class="w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
                <div class="flex justify-end space-x-4 pt-6">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Delete Member Modal -->
    <x-delete-modal 
        modalId="deleteMemberModal"
        title="Delete Member"
        message="Are you sure you want to delete this member?"
        routeName="delete-member"
        :itemId="$member->id"
    />
    <div class="container mx-auto px-4 py-8">
        <!-- Back button -->
        <a href="{{ route('members.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Members
        </a>

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Profile Photo -->
                <div class="md:w-1/4 bg-gray-100 p-6 flex flex-col items-center py-10">
                    <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-white shadow-md">
                        @if($member->photo_url)
                            <img src="{{ $member->photo_url }}" alt="{{ $member->full_name }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/default_avatar.png') }}" alt="Default Avatar" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <h1 class="mt-4 text-2xl font-bold text-gray-800 text-center pb-5">{{ $member->full_name }}</h1>
                    <p class="text-gray-600">Member Since {{ \Carbon\Carbon::parse($member->created_at)->format('M Y') }}</p>
                    
                    <!-- Membership Status Badge -->
                    @php
                        $isActive = \Carbon\Carbon::parse($member->end_date)->isFuture();
                    @endphp
                    <span class="mt-2 px-4 py-1 rounded-full text-sm font-medium {{ $isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $isActive ? 'Active' : 'Expired' }} Membership
                    </span>
                </div>

                <!-- Member Details -->
                <div class="md:w-3/4 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Contact Information -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Contact Information</h2>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $member->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Phone</p>
                                <p class="font-medium">{{ $member->phone_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Address</p>
                                <p class="font-medium">{{ $member->address }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Date of Birth</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($member->date_of_birth)->format('F j, Y') }} ({{ \Carbon\Carbon::parse($member->date_of_birth)->age }} years old)</p>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Emergency Contact</h2>
                            <div>
                                <p class="text-sm text-gray-500">Contact Person</p>
                                <p class="font-medium">{{ $member->emergency_contact_person }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Contact Number</p>
                                <p class="font-medium">{{ $member->emergency_contact_number }}</p>
                            </div>
                        </div>

                        <!-- Membership Details -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Membership Details</h2>
                            <div>
                                <p class="text-sm text-gray-500">Membership Term</p>
                                <p class="font-medium">{{ $member->membership_term_gym_access }} months</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Start Date</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($member->start_date)->format('F j, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">End Date</p>
                                <p class="font-medium {{ $isActive ? 'text-green-600' : 'text-red-600' }}">
                                    {{ \Carbon\Carbon::parse($member->end_date)->format('F j, Y') }}
                                    @if($isActive)
                                        ({{ round(now()->diffInDays(\Carbon\Carbon::parse($member->end_date))) }} days remaining)
                                    @else
                                        (Expired {{ round(now()->diffInDays(\Carbon\Carbon::parse($member->end_date)) * -1) }} days ago)
                                    @endif
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Billing Rate</p>
                                <p class="font-medium">₱{{ number_format($member->billing_rate, 2) }}</p>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="space-y-4">
                            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Additional Information</h2>
                            <div>
                                <p class="text-sm text-gray-500">ID Presented</p>
                                <p class="font-medium">{{ $member->id_presented }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">ID Number</p>
                                <p class="font-medium">{{ $member->id_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Height</p>
                                <p class="font-medium">{{ $member->height_cm }} cm</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Weight</p>
                                <p class="font-medium">{{ $member->weight_kg }} kg</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    @if($member->notes)
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h2 class="text-lg font-semibold text-gray-700 mb-2">Notes</h2>
                            <p class="text-gray-700">{{ $member->notes }}</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-8 flex space-x-2">
                        <a href="#" data-edit-profile class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Edit Profile
                        </a>
                        <a href="#" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                            Print Details
                        </a>
                        <a href="#" data-delete-member class="px-4 py-2 text-white rounded-md hover:bg-red-700 bg-red-600 transition-colors">
                            Delete Member
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>