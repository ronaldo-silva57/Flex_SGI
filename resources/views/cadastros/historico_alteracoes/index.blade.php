<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-history text-slate-600"></i>
                Histórico de Alterações
            </h2>
            <a href="{{ route('cadastros.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Filtros --}}
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('historico_alteracoes.index') }}"
                  class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

                {{-- Busca livre --}}
                <div class="md:col-span-4">
                    <label for="search" class="block text-xs font-medium text-gray-500 uppercase mb-1">
                        Busca (tabela ou ID)
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Ex: esg_indicadores ou 12"
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-slate-500 focus:border-slate-500">
                    </div>
                </div>

                {{-- Tabela --}}
                <div class="md:col-span-3">
                    <label for="tabela" class="block text-xs font-medium text-gray-500 uppercase mb-1">Tabela</label>
                    <select name="tabela" id="tabela"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-slate-500 focus:border-slate-500">
                        <option value="">Todas</option>
                        @foreach($tabelasDisponiveis as $tbl)
                            <option value="{{ $tbl }}" {{ request('tabela') == $tbl ? 'selected' : '' }}>
                                {{ $tbl }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Ação --}}
                <div class="md:col-span-2">
                    <label for="acao" class="block text-xs font-medium text-gray-500 uppercase mb-1">Ação</label>
                    <select name="acao" id="acao"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-slate-500 focus:border-slate-500">
                        <option value="">Todas</option>
                        <option value="insert" {{ request('acao') == 'insert' ? 'selected' : '' }}>Inserção</option>
                        <option value="update" {{ request('acao') == 'update' ? 'selected' : '' }}>Atualização</option>
                        <option value="delete" {{ request('acao') == 'delete' ? 'selected' : '' }}>Exclusão</option>
                    </select>
                </div>

                {{-- Data início --}}
                <div class="md:col-span-1">
                    <label for="data_inicio" class="block text-xs font-medium text-gray-500 uppercase mb-1">De</label>
                    <input type="date" name="data_inicio" id="data_inicio"
                           value="{{ request('data_inicio') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-slate-500 focus:border-slate-500 text-sm">
                </div>

                {{-- Data fim --}}
                <div class="md:col-span-1">
                    <label for="data_fim" class="block text-xs font-medium text-gray-500 uppercase mb-1">Até</label>
                    <input type="date" name="data_fim" id="data_fim"
                           value="{{ request('data_fim') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-slate-500 focus:border-slate-500 text-sm">
                </div>

                {{-- Botões --}}
                <div class="md:col-span-1 flex gap-2">
                    <button type="submit"
                            class="inline-flex items-center px-3 py-2 bg-slate-800 text-white rounded-md hover:bg-slate-700 transition"
                            title="Buscar">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request()->anyFilled(['search', 'tabela', 'acao', 'data_inicio', 'data_fim']))
                        <a href="{{ route('historico_alteracoes.index') }}"
                           class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition"
                           title="Limpar filtros">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabela --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-clock mr-1"></i>Data / Hora
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-table mr-1"></i>Tabela
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-hashtag mr-1"></i>Registro
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-bolt mr-1"></i>Ação
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-user mr-1"></i>Usuário
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-network-wired mr-1"></i>IP
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($historicos as $historico)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $historico->created_at?->format('d/m/Y H:i:s') ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $historico->tabela }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    #{{ $historico->registro_id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $acaoCor = match($historico->acao) {
                                            'insert' => 'green',
                                            'update' => 'blue',
                                            'delete' => 'red',
                                            default  => 'gray',
                                        };
                                        $acaoIcone = match($historico->acao) {
                                            'insert' => 'fa-plus-circle',
                                            'update' => 'fa-pen',
                                            'delete' => 'fa-trash',
                                            default  => 'fa-circle',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $acaoCor }}-100 text-{{ $acaoCor }}-800">
                                        <i class="fas {{ $acaoIcone }} mr-1"></i>
                                        {{ $historico->acao_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $historico->usuario?->name ?? 'Sistema' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                    {{ $historico->ip_address ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <a href="{{ route('historico_alteracoes.show', $historico) }}"
                                       class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-900 transition"
                                       title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                        <span class="hidden sm:inline">Detalhes</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl block mb-3 text-gray-300"></i>
                                    Nenhum registro de alteração encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($historicos->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $historicos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>