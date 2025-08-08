<x-layout>
    <div class="container mx-auto px-4 py-8">
        <x-navigate-back :href="route('member-details.show', $member->id)">
            Back to Member Details
        </x-navigate-back>
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Renew Personal Trainer for {{ $member->full_name }}</h1>

        <x-error-message/>

        <form action="{{ route('renew-membership.update', ['renewalType' => 'personal_trainer', 'id' => $member->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Confirm Renewal Modal placed inside the same form -->
            <x-confirm-modal 
                modalId="confirmRenewalPTModal"
                title="Confirm Personal Trainer Renewal"
                message="Are you sure you want to renew this personal trainer? Please enter staff password to confirm."
                :useSameForm="true"
            />
            <div class="bg-white shadow-md rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Personal Trainer Renewal</h2>
                <div class="flex flex-wrap items-end gap-6 mb-6">
                   <!-- With PT -->
                   <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="with_pt" class="block text-sm font-medium text-gray-700 mb-1">With Personal Trainer <span class="text-red-500">*</span></label>
                            <select id="with_pt" name="with_pt" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="None" {{ old('with_pt', $member->with_pt) == 'None' ? 'selected' : '' }}>None</option>
                                <option value="1 month" {{ old('with_pt', $member->with_pt) == '1 month' ? 'selected' : '' }}>1 Month</option>
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
                </div>
                <!-- Personal Trainer Start Date -->
                <div class="flex flex-wrap gap-6">
                    <!-- Personal Trainer Start Date -->
                    <div class="w-100">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Personal Trainer Start Date</label>
                        <div class="flex items-center space-x-2">
                            <input type="hidden" id="current_end_date_pt" value="{{ $member->pt_end_date }}">
                            <input type="text" id="pt_start_date" name="pt_start_date" readonly
                                class="w-1/2 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700"
                                value="">
                                <span class="text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            <input type="text" id="pt_end_date" name="pt_end_date" readonly
                                class="w-1/2 px-4 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700"
                                value="">
                        </div>
                        @error('pt_start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="flex mt-6">
                    <button type="button" 
                            onclick="document.getElementById('confirmRenewalPTModal').classList.remove('hidden');" 
                            class="bg-black hover:bg-gray-600 text-white py-2 px-4 rounded-md transition-colors duration-200">
                        Renew Personal Trainer
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layout>