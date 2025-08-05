@props(['dismissible' => true])

@php
    $colors = [
        'success' => 'bg-green-200 text-green-800',
        'error' => 'bg-red-200 text-red-800',
        'warning' => 'bg-yellow-200 text-yellow-800',
        'info' => 'bg-blue-200 text-blue-800',
    ];
    
    $icons = [
        'success' => '✓',
        'error' => '✕',
        'warning' => '!',
        'info' => 'i',
    ];
    
    // Get the first available message type from the session
    $messageType = collect(['success', 'error', 'warning', 'info'])
        ->first(fn($type) => session()->has($type));
    
    // If no message type found, don't show anything
    if (!$messageType) {
        return;
    }
    
    $message = session($messageType);
    $color = $colors[$messageType];
    $icon = $icons[$messageType];
    $dismissButtonClass = str_replace('text-', 'hover:', $color) . ' font-bold text-xl leading-none';
@endphp

<div x-data="{ show: true }" 
     x-show="show" 
     x-init="setTimeout(() => show = false, 5000)"
     class="{{ $color }} p-4 mb-4 rounded-md flex items-start">
    <span class="mr-2">{{ $icon }}</span>
    <span class="flex-1">{{ $message }}</span>
    @if($dismissible)
        <button @click="show = false" 
                class="ml-2 {{ $dismissButtonClass }}">
            &times;
        </button>
    @endif
</div>
