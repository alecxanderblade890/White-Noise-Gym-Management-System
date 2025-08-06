<x-layout>
    <div class="container mx-auto px-4 py-8">
        <x-navigate-back :href="route('member-details.show', $member->id)">
            Back to Members
        </x-navigate-back>
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Renew Membership for {{ $member->full_name }}</h1>

        <x-error-message/>

        <!-- Confirm Renewal Modal -->
        <x-confirm-modal 
            modalId="confirmRenewalModal"
            title="Confirm Membership Renewal"
            message="Are you sure you want to renew this membership? Please enter your password to confirm."
            :routeName="'renew-membership.update'"
            :itemId="['renewalType' => 'membership', 'id' => $member->id]"
        />

        <form id="renewalForm" action="{{ route('renew-membership.update', ['renewalType' => 'membership', 'id' => $member->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Membership Renewal</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Membership Period -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Membership Period <span class="text-red-500">*</span></label>
                        <div class="flex items-center space-x-2">
                            <input type="hidden" name="membership_start_date" value="{{ now()->format('Y-m-d') }}">
                            <input type="text" id="membership_start_date" readonly
                                   class="w-1/2 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700"
                                   value="{{ now()->format('F d, Y') }}">
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input type="hidden" name="membership_end_date" value="{{ \Carbon\Carbon::parse($member->membership_end_date)->addYear()->format('Y-m-d') }}">
                            <input type="text" id="membership_end_date" readonly
                                   class="w-1/2 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700"
                                   value="{{ \Carbon\Carbon::parse($member->membership_end_date)->addYear()->format('F d, Y') }}">
                        </div>
                        <p class="mt-1 ml-3 text-xs text-gray-500">1 Year Membership Period</p>
                        @error('payment_date_membership')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex mt-6">
                    <button type="button" 
                            onclick="document.getElementById('confirmRenewalModal').classList.remove('hidden')" 
                            class="bg-black hover:bg-gray-600 text-white py-2 px-4 rounded-md transition-colors duration-200">
                        Renew Membership
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layout>