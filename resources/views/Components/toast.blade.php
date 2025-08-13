{{-- <div>
    <div id="toast"
        class="fixed z-50 px-6 py-3 text-center transform -translate-x-1/2 rounded-lg shadow-lg top-10 text-primary bg-secondary left-1/2 animate-fade-in-down">
        {{ $slot }}👌
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.display = 'none';
            }
        }, 3000);
    </script>
</div> --}}

@props(['type' => 'success'])

@php
    $types = [
        'success' => 'bg-green-100 text-green-800',
        'error' => 'bg-red-100 text-red-800',
        'warning' => 'bg-yellow-100 text-yellow-800',
        'info' => 'bg-blue-100 text-blue-800',
    ];

    $icons = [
        'success' => '✅',
        'error' => '❌',
        'warning' => '⚠️',
        'info' => 'ℹ️',
    ];

    $colorClass = $types[$type] ?? $types['success'];
    $icon = $icons[$type] ?? $icons['success'];
@endphp

<div>
    <div id="toast"
        class="fixed z-50 px-6 py-3 text-center transform -translate-x-1/2 rounded-lg shadow-lg top-10 left-1/2 animate-fade-in-down {{ $colorClass }}">
        <span class="font-semibold">{{ $icon }}</span>
        <span>{{ $slot }}</span>
    </div>
    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.style.display = 'none';
            }
        }, 3000);
    </script>
</div>
