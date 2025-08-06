<!-- Membership Renewal Confirmation Modal -->
<div id="{{ $modalId }}" class="fixed inset-0 z-60 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-4 md:p-8 relative">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $title }}</h2>
        <p class="mb-4">{{ $message }}</p>
        
        <form id="confirmForm-{{ $modalId }}" action="{{ route($routeName, $itemId) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="password-{{ $modalId }}" class="block text-sm font-medium text-gray-700">Enter password to confirm:</label>
                <input type="password" 
                       id="password-{{ $modalId }}" 
                       name="password" 
                       required
                       class="block w-full rounded-md mt-5 bg-gray-100 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-white sm:text-sm/6">
                <!-- Hidden fields populated via JS -->
                <input type="hidden" id="modal-member-type-{{ $modalId }}" name="member_type" value="">
                <input type="hidden" id="modal-membership-term-{{ $modalId }}" name="membership_term_gym_access" value="">
                <input type="hidden" id="modal-billing-rate-{{ $modalId }}" name="membership_term_billing_rate" value="">
                <input type="hidden" id="modal-gym-access-start-date-{{ $modalId }}" name="membership_start_date" value="">
                <input type="hidden" id="modal-gym-access-end-date-{{ $modalId }}" name="membership_end_date" value="">

                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" 
                        onclick="document.getElementById('{{ $modalId }}').classList.add('hidden')" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 rounded-md text-white bg-black hover:bg-black/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black/80">
                    Confirm Renewal
                </button>
            </div>
        </form>
    </div>
</div>