@props(['status'])

@php
    $map = [
        // NC
        'Aberta'          => 'bg-red-100 text-red-800',
        'Em analise'      => 'bg-yellow-100 text-yellow-800',
        'Em ação'         => 'bg-blue-100 text-blue-800',
        'Verificação'     => 'bg-purple-100 text-purple-800',
        'Fechada'         => 'bg-green-100 text-green-800',
        // Ações
        'Pendente'        => 'bg-red-100 text-red-800',
        'Em andamento'    => 'bg-yellow-100 text-yellow-800',
        'Concluída'       => 'bg-green-100 text-green-800',
        'Reprovada'       => 'bg-gray-100 text-gray-800',
        // Análise
        'Concluida'       => 'bg-green-100 text-green-800',
        // Análise de Causa
        'Em andamento'  => 'bg-yellow-100 text-yellow-800',
        'Em análise'    => 'bg-yellow-100 text-yellow-800',
        'Concluída'     => 'bg-green-100 text-green-800',
        'Cancelada'     => 'bg-gray-100 text-gray-800'
    ];
    $cls = $map[$status] ?? 'bg-gray-100 text-gray-800';
@endphp

<span {{ $attributes->merge([
    'class' => "inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {$cls}"
]) }}>
    {{ $status }}
</span>