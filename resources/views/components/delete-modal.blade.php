<!-- Delete Confirmation Modal -->
<div id="{{ $modalId }}" class="fixed inset-0 z-60 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-4 md:p-8 relative">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $title }}</h2>
        <p class="mb-4">{{ $message }}</p>
        
        <form id="deleteForm-{{ $modalId }}" action="{{ route($routeName, $itemId) }}" method="POST" class="space-y-4">
            @csrf
            @method('DELETE')
            
            <div>
                <label for="password-{{ $modalId }}" class="block text-sm font-medium text-gray-700">Enter admin password to confirm:</label>
                <input type="password" 
                       id="password-{{ $modalId }}" 
                       name="password" 
                       required
                       class="block w-full rounded-md mt-5 bg-gray-100 px-3 py-1.5 text-base text-black outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-white sm:text-sm/6">
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
                        class="px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Confirm Delete
                </button>
            </div>
        </form>
    </div>
</div>