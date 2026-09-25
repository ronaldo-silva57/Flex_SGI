<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-bullseye text-green-600"></i> Objetivos Ambientais
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('iso14001.dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('objetivos_ambientais.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Novo Objetivo
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-green-500 mr-3"></i><span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('objetivos_ambientais.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Buscar por título ou código..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos os status</option>
                        @foreach(['Planejado','Em andamento','Concluído','Cancelado','Atrasado'] as $st)
                            <option value="{{ $st }}" {{ request('status')==$st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('objetivos_ambientais.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i>Limpar
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Responsável</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prazo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Progresso</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($objetivos as $obj)
                            @php
                                $statusClasses = [
                                    'Planejado'    => 'bg-gray-100 text-gray-700',
                                    'Em andamento' => 'bg-blue-100 text-blue-800',
                                    'Concluído'    => 'bg-green-100 text-green-800',
                                    'Cancelado'    => 'bg-red-100 text-red-800',
                                    'Atrasado'     => 'bg-amber-100 text-amber-800',
                                ];
                            @endphp
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $obj->codigo }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ Str::limit($obj->titulo, 60) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $obj->responsavel?->name ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $obj->prazo ? \Carbon\Carbon::parse($obj->prazo)->format('d/m/Y') : '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-24 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ (int) $obj->progresso }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-600">{{ (int) $obj->progresso }}%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses[$obj->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $obj->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('objetivos_ambientais.show', $obj) }}" class="text-blue-600 hover:text-blue-900" title="Ver"><i class="fas fa-eye"></i></a>Visualizar
                                        <a href="{{ route('objetivos_ambientais.edit', $obj) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar"><i class="fas fa-edit"></i></a>Editar
                                        <form action="{{ route('objetivos_ambientais.destroy', $obj) }}" method="POST"
                                              onsubmit="return confirm('Excluir este objetivo?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Excluir"><i class="fas fa-trash-alt"></i></button> Excluir
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Nenhum objetivo cadastrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $objetivos->links() }}</div>
    </div>
</x-app-layout>