<!-- Delete Member Modal -->
<div id="{{ $modalId }}" class="fixed inset-0 z-60 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-4 md:p-8 relative">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ $title }}</h2>
        <p>{{ $message }}</p>
        <div class="flex justify-end space-x-4 mt-8">
            <button type="button" onclick="document.getElementById('{{ $modalId }}').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">Cancel</button>
            <form action="{{ route($routeName, $itemId) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 rounded-md text-white bg-red-600 hover:bg-red-700">Delete</button>
            </form>
        </div>
    </div>
</div>