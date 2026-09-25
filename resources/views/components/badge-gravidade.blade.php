@props(['gravidade'])

@php
    $map = [
        'Baixa'   => 'bg-blue-100 text-blue-800',
        'Media'   => 'bg-yellow-100 text-yellow-800',
        'Alta'    => 'bg-orange-100 text-orange-800',
        'Crítica' => 'bg-red-100 text-red-800',
    ];
    $cls = $map[$gravidade] ?? 'bg-gray-100 text-gray-800';
@endphp

<span {{ $attributes->merge([
    'class' => "inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {$cls}"
]) }}>
    {{ $gravidade ?? 'N/A' }}
</span>