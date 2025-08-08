<x-layout>
    <div class="container mx-auto px-4 py-8">
        <x-navigate-back :href="route('member-details.show', $member->id)">
            Back to Member Details
        </x-navigate-back>
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Renew Membership Term for {{ $member->full_name }}</h1>

        <x-error-message/>

        <form action="{{ route('renew-membership.update', ['renewalType' => 'membership_term', 'id' => $member->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

                <!-- Confirm Renewal Modal placed inside the same form -->
                <x-confirm-modal 
                    modalId="confirmRenewalTermModal"
                    title="Confirm Membership Term Renewal"
                    message="Are you sure you want to renew this membership term? Please enter staff password to confirm."
                    :useSameForm="true"
                />
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Membership Term Renewal</h2>
                <div class="flex flex-wrap items-end gap-6 mb-6">
                    <!-- Member Type -->
                    <div class="w-40">
                        <label for="member_type" class="block text-sm font-medium text-gray-700 mb-1">Member Type <span class="text-red-500">*</span></label>
                        <select id="member_type" name="member_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="Student" {{ (old('member_type', $member->member_type) == 'Student') ? 'selected' : '' }}>Student</option>
                            <option value="Regular" {{ (old('member_type', $member->member_type) == 'Regular') ? 'selected' : '' }}>Regular</option>
                        </select>
                        @error('member_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
                        @enderror
                    </div>
                    
                    <!-- Membership Term -->
                    <div class="w-48">
                        <label for="membership_term_gym_access" class="block text-sm font-medium text-gray-700 mb-1">Membership Term <span class="text-red-500">*</span></label>
                        <select id="membership_term_gym_access" name="membership_term_gym_access" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="None" {{ old('membership_term_gym_access', $member->membership_term_gym_access) == 'None' ? 'selected' : '' }}>None</option>
                            <option value="1 month" {{ old('membership_term_gym_access', $member->membership_term_gym_access) == '1 month' ? 'selected' : '' }}>1 Month</option>
                            <option value="3 months" {{ old('membership_term_gym_access', $member->membership_term_gym_access) == '3 months' ? 'selected' : '' }}>3 Months</option>
                            <option value="Walk in" {{ old('membership_term_gym_access', $member->membership_term_gym_access) == 'Walk in' ? 'selected' : '' }}>Walk In</option>
                        </select>
                        @error('membership_term_gym_access')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Billing Rate -->
                    <div class="w-48">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Billing Rate</label>
                        <div class="flex">
                            <input type="hidden" id="membership_term_billing_rate_hidden" name="membership_term_billing_rate" value="0">
                            <input type="text" id="membership_term_billing_rate" readonly
                                class="w-24 pl-4 py-2 border border-gray-300 rounded-l-md bg-gray-50 text-gray-700 focus:outline-none"
                                value="₱0">
                            <span id="billing-rate-suffix" class="px-4 py-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50 text-gray-700">
                                /month
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Gym Access Start Date -->
                <div class="flex flex-wrap gap-6">
                    <!-- Membership Period -->
                    <div class="w-100">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Membership Term Period</label>
                        <div class="flex items-center space-x-2">
                            <input type="hidden" id="current_end_date" value="{{ $member->gym_access_end_date ? $member->gym_access_end_date : null }}">
                            <input type="text" id="gym_access_start_date" readonly
                                class="w-1/2 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700"
                                value="">
                                <span class="text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            <input type="text" id="gym_access_end_date" readonly
                                class="w-1/2 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700"
                                value="">
                        </div>
                        @error('payment_date_membership')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex mt-6">
                    <button type="button" 
                            onclick="document.getElementById('confirmRenewalTermModal').classList.remove('hidden')" 
                            class="bg-black hover:bg-gray-600 text-white py-2 px-4 rounded-md transition-colors duration-200">
                        Renew Membership Term
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layout>