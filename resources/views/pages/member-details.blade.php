<x-layout>
<div class="container mx-auto px-4 py-8">
        <!-- Back button -->
        <a href="{{ route('manage-members.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Members
        </a>

        <!-- Profile Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Profile Photo -->
                <div class="md:w-1/4 bg-gray-100 p-6 flex flex-col items-center justify-center">
                    <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-white shadow-md">
                        @if($member->photo_url)
                            <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/default_avatar.png') }}" alt="Default Avatar" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <h1 class="mt-4 text-2xl font-bold text-gray-800">{{ $member->name }}</h1>
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
                                <p class="font-medium">{{ $member->contact_person }}</p>
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
                                        ({{ now()->diffInDays(\Carbon\Carbon::parse($member->end_date)) }} days remaining)
                                    @else
                                        (Expired {{ now()->diffInDays(\Carbon\Carbon::parse($member->end_date)) * -1 }} days ago)
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
                    <div class="mt-8 flex space-x-4">
                        <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Edit Profile
                        </a>
                        <a href="#" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors">
                            Print Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>