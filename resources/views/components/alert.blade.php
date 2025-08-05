@props(['type' => 'success', 'dismissible' => true])

@php
    $colors = [
        'success' => 'bg-green-200 text-green-800',
        'error' => 'bg-red-200 text-red-800',
        'warning' => 'bg-yellow-200 text-yellow-800',
        'info' => 'bg-blue-200 text-blue-800',
    ];
    
    $iconColors = [
        'success' => 'text-green-700 hover:text-green-900',
        'error' => 'text-red-700 hover:text-red-900',
        'warning' => 'text-yellow-700 hover:text-yellow-900',
        'info' => 'text-blue-700 hover:text-blue-900',
    ];
    
    $icon = [
        'success' => '✓',
        'error' => '✕',
        'warning' => '!',
        'info' => 'i',
    ];
    
    $color = $colors[$type] ?? $colors['success'];
    $iconColor = $iconColors[$type] ?? $iconColors['success'];
    $iconSymbol = $icon[$type] ?? $icon['success'];
@endphp

@if(session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
    @php
        $messageType = session('success') ? 'success' : 
                      (session('error') ? 'error' : 
                      (session('warning') ? 'warning' : 'info'));
        $message = session($messageType);
    @endphp
    
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 5000)"
         {{ $attributes->merge(['class' => "$color p-4 mb-4 rounded-md flex items-start"]) }}>
        <span class="mr-2">{{ $iconSymbol }}</span>
        <span class="flex-1">{{ $message }}</span>
        @if($dismissible)
            <button @click="show = false" 
                    class="ml-2 $iconColor font-bold text-xl leading-none">
                &times;
            </button>
        @endif
    </div>
@endif
