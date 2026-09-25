<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-sitemap text-indigo-600"></i>Análises de Causa Raiz
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('cadastros.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
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

        {{-- Filtro --}}
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('analises_causa.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Método, status, objetivo..." class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition">
                    <i class="fas fa-search mr-2"></i> Buscar
                </button>
            </form>
        </div>

        {{-- Tabela --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Não Conformidade</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Responsável</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data Início</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($analises as $analise)
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="px-4 py-4 text-sm font-semibold text-gray-900">
                                    {{ $analise->naoConformidade->codigo ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-800">{{ $analise->metodo }}</td>
                                <td class="px-4 py-4 text-sm text-gray-600">{{ $analise->responsavel->name ?? '-' }}</td>
                                <td class="px-4 py-4 text-sm">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        {{ $analise->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600">{{ optional($analise->data_inicio)->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-4 py-4 text-right text-sm">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('analises_causa.show', $analise) }}" class="text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></a>Visualizar / Editar
                                        <form action="{{ route('analises_causa.destroy', $analise) }}" method="POST" onsubmit="return confirm('Excluir esta análise?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt mr-2"></i></button>Excluir
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Nenhuma análise cadastrada.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t">{{ $analises->links() }}</div>
        </div>
    </div>
</x-app-layout>