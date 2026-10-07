<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-chart-pie text-emerald-600"></i>
                Indicadores ESG
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('esg.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('esg_indicadores.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Novo Indicador
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
            <form method="GET" action="{{ route('esg_indicadores.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Buscar por Código ou Nome..." 
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>
                <div>
                    <label for="dimensao" class="sr-only">Dimensão</label>
                    <select name="dimensao" id="dimensao"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Todas as dimensões</option>
                        @foreach(['Ambiental', 'Social', 'Governança'] as $dim)
                            <option value="{{ $dim }}" {{ request('dimensao') == $dim ? 'selected' : '' }}>
                                {{ $dim }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    <i class="fas fa-search mr-2"></i> Buscar
                </button>
                @if(request('search') || request('dimensao'))
                    <a href="{{ route('esg_indicadores.index') }}"
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Código</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Dimensão</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Frequência</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($indicadores as $indicador)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $indicador->codigo }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $indicador->nome }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $cor = match($indicador->dimensao) {
                                            'Ambiental' => 'green',
                                            'Social' => 'blue',
                                            'Governança' => 'purple',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $cor }}-100 text-{{ $cor }}-800">
                                        {{ $indicador->dimensao }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $indicador->frequencia }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($indicador->ativo)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Ativo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i> Inativo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('esg_indicadores.show', $indicador) }}"
                                        class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                        title="Visualizar">
                                            <i class="fas fa-eye"></i>Visualizar
                                        </a>
                                        <a href="{{ route('esg_indicadores.edit', $indicador) }}"
                                        class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                        title="Editar">
                                            <i class="fas fa-edit"></i>Editar
                                        </a>
                                        <form action="{{ route('esg_indicadores.destroy', $indicador) }}"
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este indicador?');">
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
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl block mb-3 text-gray-300"></i>
                                    Nenhum indicador ESG cadastrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($indicadores->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $indicadores->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>