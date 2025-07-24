<nav x-data="{ open: false }" class="bg-gray-800 text-white">
    <!-- Mobile menu button -->
    <div class="flex items-center justify-between p-4 md:hidden">
        <div class="text-xl font-bold">White Noise Gym</div>
        <button @click="open = !open" class="text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <!-- Sidebar -->
    <div class="md:flex md:flex-shrink-0">
        <div :class="{'block': open, 'hidden': !open}" class="w-full md:block md:w-64 bg-gray-800 min-h-screen transition-all duration-300 ease-in-out">
            <div class="p-4">
                <div class="hidden md:block text-xl font-bold mb-6">White Noise Gym</div>
                
                <!-- Navigation Links -->
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('members.index') }}" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 rounded-md transition-colors">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Members
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>