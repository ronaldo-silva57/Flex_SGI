<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-scale-balanced text-blue-600"></i>
                Riscos e Oportunidades
            </h2>
            <div class="flex space-x-4">
                <a
                    href="{{ route('cadastros.dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                        <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('riscos_oportunidades.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Novo Risco ou Oportunidade
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
            <form method="GET" action="{{ route('riscos_oportunidades.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Buscar por Tipo (Risco ou Oportunidade)..." 
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    <i class="fas fa-search mr-2"></i> Buscar
                </button>
                @if(request('search'))
                    <a href="{{ route('riscos_oportunidades.index') }}"
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-diagram-project mr-1"></i>Processo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-align-left mr-1"></i>Descrição
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-tag mr-1"></i>Tipo
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-gauge-high mr-1"></i>Nível
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-calendar-alt mr-1"></i>Prazo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-toggle-on mr-1"></i>Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-tools mr-1"></i>Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($riscos as $risco)
                            <tr class="hover:bg-gray-50 transition">

                                {{-- Processo --}}
                                <td class="whitespace-pre-line px-6 py-3">
                                    @if($risco->processo)
                                        <span class="text-sm text-gray-900">
                                            {{ $risco->processo->nome }}
                                        </span>
                                        <div class="text-xs text-gray-500">
                                            {{ $risco->processo->codigo }}
                                        </div>
                                    @else
                                        <span class="text-xs text-gray-400 italic">— sem processo —</span>
                                    @endif
                                </td>

                                {{-- Descrição (truncada) --}}
                                <td class=" whitespace-pre-linepx-6 py-3 max-w-xs">
                                    <div class="text-sm text-gray-700" title="{{ $risco->descricao }}">
                                        {{ \Illuminate\Support\Str::limit($risco->descricao, 60) }}
                                    </div>
                                </td>

                                {{-- Tipo --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($risco->tipo === 'Risco')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Risco
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-rocket mr-1"></i> Oportunidade
                                        </span>
                                    @endif
                                </td>

                                {{-- Nível de Risco (cor por faixa) --}}
                                <td class="px-6 py-3 whitespace-nowrap text-center">
                                    @php
                                        $nivel = $risco->nivel_risco;
                                        $nivelColor = match(true) {
                                            $nivel === null      => 'gray',
                                            $nivel <= 4          => 'green',
                                            $nivel <= 9          => 'yellow',
                                            $nivel <= 15         => 'orange',
                                            default              => 'red',
                                        };
                                        $nivelLabel = match(true) {
                                            $nivel === null => '—',
                                            $nivel <= 4     => 'Baixo',
                                            $nivel <= 9     => 'Médio',
                                            $nivel <= 15    => 'Alto',
                                            default         => 'Crítico',
                                        };
                                    @endphp

                                    @if($nivel !== null)
                                        <span class="inline-flex flex-col items-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-{{ $nivelColor }}-100 text-{{ $nivelColor }}-800">
                                                {{ $nivel }}
                                            </span>
                                            <span class="text-[10px] uppercase tracking-wide text-{{ $nivelColor }}-600 mt-1">
                                                {{ $nivelLabel }}
                                            </span>
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 italic">—</span>
                                    @endif
                                </td>

                                {{-- Prazo (com destaque para vencidos) --}}
                                <td class="px-6 py-3 whitespace-nowrap">
                                    @if($risco->prazo)
                                        @php
                                            $vencido = $risco->prazo->isPast()
                                                && !in_array($risco->status, ['Concluído', 'Cancelado']);
                                        @endphp
                                        <div class="text-sm {{ $vencido ? 'text-red-600 font-semibold' : 'text-gray-700' }}">
                                            {{ $risco->prazo->format('d/m/Y') }}
                                        </div>
                                        @if($vencido)
                                            <div class="text-xs text-red-500">
                                                <i class="fas fa-triangle-exclamation mr-1"></i>Atrasado
                                            </div>
                                        @else
                                            <div class="text-xs text-gray-400">
                                                {{ $risco->prazo->diffForHumans() }}
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-xs text-gray-400 italic">sem prazo</span>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-3 whitespace-nowrap">
                                    @php
                                        $statusColor = match($risco->status) {
                                            'Aberto'       => 'yellow',
                                            'Em andamento' => 'blue',
                                            'Concluído'    => 'green',
                                            'Cancelado'    => 'red',
                                            default        => 'gray'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                                        <i class="fas fa-circle mr-1 text-{{ $statusColor }}-500 text-[8px]"></i>
                                        {{ $risco->status }}
                                    </span>
                                </td>

                                {{-- Ações (inalterado) --}}
                                <td class="px-6 py-3 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('riscos_oportunidades.show', $risco) }}"
                                        class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-900 transition" title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                            <span class="hidden sm:inline">Visualizar</span>
                                        </a>
                                        <a href="{{ route('riscos_oportunidades.edit', $risco) }}"
                                        class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-900 transition" title="Editar">
                                            <i class="fas fa-edit"></i>
                                            <span class="hidden sm:inline">Editar</span>
                                        </a>
                                        <form action="{{ route('riscos_oportunidades.destroy', $risco) }}"
                                            method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja excluir este Risco / Oportunidade?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 text-red-600 hover:text-red-900 transition" title="Excluir">
                                                <i class="fas fa-trash-alt"></i>
                                                <span class="hidden sm:inline">Excluir</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl block mb-3 text-gray-300"></i>
                                    Nenhum risco ou oportunidade cadastrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            @if($riscos->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $riscos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>