<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-tools text-orange-600"></i>Ações Corretivas
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('cadastros.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('acoes_corretivas.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Nova Ação Corretiva
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
            <form method="GET" action="{{ route('acoes_corretivas.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Descrição, etapa, status..."
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500">
                    </div>
                </div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    <i class="fas fa-search mr-2"></i> Buscar
                </button>
                @if(request('search'))
                    <a href="{{ route('acoes_corretivas.index') }}"
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Não Conformidade
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-user mr-1"></i>Responsável
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-route mr-1"></i>Etapa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-toggle-on mr-1"></i>Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-calendar-alt mr-1"></i>Prazo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-tools mr-1"></i>Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($acoesCorretivas as $acao)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-orange-50 transition duration-150">
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $acao->naoConformidade->descricao ?? 'N/A' }}</span>
                                        <span class="text-xs text-gray-500">ID: {{ $acao->naoConformidade->id ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $acao->responsavel->name ?? 'Não definido' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $etapaClasses = [
                                            'Contenção'    => 'bg-blue-100 text-blue-800',
                                            'Causa raiz'   => 'bg-purple-100 text-purple-800',
                                            'Correção'     => 'bg-indigo-100 text-indigo-800',
                                            'Verificação'  => 'bg-yellow-100 text-yellow-800',
                                            'Conclusão'    => 'bg-green-100 text-green-800',
                                        ][$acao->etapa] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $etapaClasses }}">
                                        {{ $acao->etapa }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'Pendente'       => 'bg-red-100 text-red-800',
                                            'Em andamento'   => 'bg-yellow-100 text-yellow-800',
                                            'Concluída'      => 'bg-green-100 text-green-800',
                                            'Reprovada'      => 'bg-gray-100 text-gray-800',
                                        ][$acao->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusClasses }}">
                                        {{ $acao->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $acao->prazo ? $acao->prazo->format('d/m/Y') : '---' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('acoes_corretivas.show', $acao) }}"
                                           class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-900 transition"
                                           title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                            <span class="hidden sm:inline">Visualizar</span>
                                        </a>
                                        <a href="{{ route('acoes_corretivas.edit', $acao) }}"
                                           class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-900 transition"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                            <span class="hidden sm:inline">Editar</span>
                                        </a>
                                        <form action="{{ route('acoes_corretivas.destroy', $acao) }}"
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta ação corretiva?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 text-red-600 hover:text-red-900 transition"
                                                    title="Excluir">
                                                <i class="fas fa-trash-alt"></i>
                                                <span class="hidden sm:inline">Excluir</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t">
                {{ $acoesCorretivas->links() }}
            </div>
        </div>
    </div>
</x-app-layout>