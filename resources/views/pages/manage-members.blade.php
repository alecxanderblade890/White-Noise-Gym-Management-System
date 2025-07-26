<x-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">Members Management</h1>
        
        <div class="flex flex-col md:flex-row gap-20 py-8 items-center justify-center">
            <!-- Add New Member Card -->
            <a href="{{ route('register-member') }}" class="block group">
                <div class="bg-white rounded-lg shadow-md p-4 h-full border-2 border-transparent hover:border-blue-500 transition-all duration-300 transform hover:scale-105 max-w-xs w-full">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-200 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Add New Member</h3>
                        <p class="text-gray-600">Register a new gym member and add their details to the system.</p>
                    </div>
                </div>
            </a>

            <!-- View Members Card -->
            <a href="{{ route('members.index') }}" class="block group">
                <div class="bg-white rounded-lg shadow-md p-4 h-full border-2 border-transparent hover:border-green-500 transition-all duration-300 transform hover:scale-105 max-w-xs w-full">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4 group-hover:bg-green-200 transition-colors duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">View All Members</h3>
                        <p class="text-gray-600">Browse, search, and manage all registered gym members.</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-layout>