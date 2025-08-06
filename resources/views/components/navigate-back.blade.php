<!-- Back button -->
<a href="{{ $href }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    {{ $slot ?? 'Back' }}
</a>