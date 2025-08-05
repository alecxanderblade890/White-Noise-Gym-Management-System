<x-layout>
    <div class="container mx-auto px-2 sm:px-4 py-4 sm:py-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">{{Auth::user()->username == 'admin_access' ? 'Admin Dashboard' : 'Staff Dashboard'}}</h1>
    </div>
</x-layout>