<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-smog text-purple-600"></i>
                Inventário de Emissões GEE
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('esg.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('inventario_gee.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Novo Registro
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Filtros --}}
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('inventario_gee.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Buscar por código ou fonte de emissão..."
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                    </div>
                </div>

                <div>
                    <label for="ano_referencia" class="sr-only">Ano</label>
                    <input type="number" name="ano_referencia" id="ano_referencia" value="{{ request('ano_referencia') }}"
                           placeholder="Ano ref." min="1900" max="2100"
                           class="block w-32 rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div>
                    <label for="escopo" class="sr-only">Escopo</label>
                    <select name="escopo" id="escopo"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Todos os escopos</option>
                        @foreach(['1' => 'Escopo 1', '2' => 'Escopo 2', '3' => 'Escopo 3'] as $val => $label)
                            <option value="{{ $val }}" {{ request('escopo') == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="sr-only">Status</label>
                    <select name="status" id="status"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Todos os status</option>
                        @foreach(['Rascunho', 'Em revisão', 'Verificado', 'Publicado'] as $st)
                            <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    <i class="fas fa-search mr-2"></i> Buscar
                </button>
                @if(request('search') || request('escopo') || request('status') || request('ano_referencia'))
                    <a href="{{ route('inventario_gee.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i> Limpar
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabela --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Código</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Fonte de Emissão</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wide">Ano</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wide">Escopo</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">Emissão (tCO₂e)</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Responsável</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($inventarios as $item)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $item->codigo }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-800">
                                    {{ $item->fonte_emissao }}
                                    @if($item->categoria)
                                        <div class="text-xs text-gray-500">
                                            <i class="fas fa-tag mr-1"></i>{{ $item->categoria }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 text-center">
                                    {{ $item->ano_referencia }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    @php
                                        $coresEscopo = [
                                            '1' => 'red',
                                            '2' => 'orange',
                                            '3' => 'blue',
                                        ];
                                        $corEsc = $coresEscopo[$item->escopo] ?? 'gray';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $corEsc }}-100 text-{{ $corEsc }}-800">
                                        Escopo {{ $item->escopo }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-right text-gray-900">
                                    {{ number_format((float) $item->emissao_tco2e, 3, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @php
                                        $coresStatus = [
                                            'Rascunho'    => 'gray',
                                            'Em revisão'  => 'yellow',
                                            'Verificado'  => 'blue',
                                            'Publicado'   => 'green',
                                        ];
                                        $corSt = $coresStatus[$item->status] ?? 'gray';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $corSt }}-100 text-{{ $corSt }}-800">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $item->responsavel?->name ?? '—' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('inventario_gee.show', $item) }}"
                                           class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                           title="Visualizar">
                                            <i class="fas fa-eye"></i>Visualizar
                                        </a>
                                        <a href="{{ route('inventario_gee.edit', $item) }}"
                                           class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>Editar
                                        </a>
                                        <form action="{{ route('inventario_gee.destroy', $item) }}"
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este registro?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-2 py-1 bg-red-50 text-red-700 rounded hover:bg-red-100"
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl block mb-3 text-gray-300"></i>
                                    Nenhum registro de inventário GEE cadastrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($inventarios->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $inventarios->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>