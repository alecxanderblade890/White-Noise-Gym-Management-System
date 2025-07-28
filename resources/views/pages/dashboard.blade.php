<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h1>
        <div class="bg-white mx-auto shadow-md rounded-lg p-6 mb-8">
            <details>
                <summary class="text-xl font-semibold text-gray-700 mb-4 cursor-pointer">Total Sales Today: </summary>
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
                
            </details>
        </div>
    </div>
</x-layout>