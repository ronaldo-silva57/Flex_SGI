@props([
    'titulo',
    'valor',
    'icon'  => 'fa-chart-simple',
    'cor'   => 'gray',   // gray | red | blue | green | orange | purple
    'href'  => null,
])

@php
    $cores = [
        'gray'   => ['bg-gray-50',   'text-gray-600',   'border-gray-200'],
        'red'    => ['bg-red-50',    'text-red-600',    'border-red-200'],
        'blue'   => ['bg-blue-50',   'text-blue-600',   'border-blue-200'],
        'green'  => ['bg-green-50',  'text-green-600',  'border-green-200'],
        'orange' => ['bg-orange-50', 'text-orange-600', 'border-orange-200'],
        'purple' => ['bg-purple-50', 'text-purple-600', 'border-purple-200'],
    ];
    [$bg, $txt, $border] = $cores[$cor] ?? $cores['gray'];
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    {{ $attributes->merge([
        'class' => "block p-4 rounded-lg border {$border} {$bg} hover:shadow-md transition-shadow"
    ]) }}
>
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ $titulo }}</p>
            <p class="mt-1 text-2xl font-bold {{ $txt }}">{{ $valor }}</p>
        </div>
        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $bg }}">
            <i class="fas {{ $icon }} {{ $txt }}"></i>
        </div>
    </div>
</{{ $tag }}>