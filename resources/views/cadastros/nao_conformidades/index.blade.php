<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-red-800"></i>
                Não Conformidades
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('cadastros.dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('nao_conformidades.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Nova Não Conformidade
                </a>
            </div>
        </div>
    </x-slot>

    @php
        // Configuração visual dos status (label -> [classe, ícone])
        $statusCfg = [
            'Aberta'      => ['bg-red-100 text-red-800',       'fa-circle-exclamation'],
            'Em analise'  => ['bg-yellow-100 text-yellow-800', 'fa-magnifying-glass'],
            'Em ação'     => ['bg-blue-100 text-blue-800',     'fa-screwdriver-wrench'],
            'Verificação' => ['bg-purple-100 text-purple-800', 'fa-clipboard-check'],
            'Fechada'     => ['bg-green-100 text-green-800',   'fa-circle-check'],
        ];

        $gravidadeCfg = [
            'Baixa'   => 'bg-blue-100 text-blue-800',
            'Media'   => 'bg-yellow-100 text-yellow-800',
            'Alta'    => 'bg-orange-100 text-orange-800',
            'Crítica' => 'bg-red-100 text-red-800',
        ];

        $origens = ['Auditoria', 'Monitoramento', 'Reclamacao', 'Incidente', 'Outros'];

        $totalGeral     = $contadores->sum();
        $statusAtivo    = request('status');
        $gravidadeAtiva = request('gravidade');
        $origemAtiva    = request('origem');
        $apenasVencidas = request()->boolean('apenas_vencidas');
        $temFiltrosAtivos = request()->hasAny(['search', 'status', 'gravidade', 'origem', 'apenas_vencidas']);
    @endphp

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <x-breadcrumb :items="[
            ['label' => 'Cadastros', 'url' => route('cadastros.dashboard')],
            ['label' => 'Não Conformidades'],
        ]" />

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- ============================================================ --}}
        {{-- KPIs                                                        --}}
        {{-- ============================================================ --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <x-kpi
                titulo="Abertas"
                :valor="$contadores['Aberta'] ?? 0"
                icon="fa-circle-exclamation"
                cor="red"
                :href="route('nao_conformidades.index', ['status' => 'Aberta'])"
            />

            <x-kpi
                titulo="Em tratamento"
                :valor="($contadores['Em analise'] ?? 0) + ($contadores['Em ação'] ?? 0)"
                icon="fa-screwdriver-wrench"
                cor="blue"
            />

            <x-kpi
                titulo="Prazo vencido"
                :valor="$vencidas"
                icon="fa-clock"
                cor="orange"
                :href="route('nao_conformidades.index', ['apenas_vencidas' => 1])"
            />

            <x-kpi
                titulo="Fechadas no mês"
                :valor="$fechadasMes"
                icon="fa-circle-check"
                cor="green"
                :href="route('nao_conformidades.index', ['status' => 'Fechada'])"
            />
        </div>

        {{-- ============================================================ --}}
        {{-- Abas de status                                                --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-lg shadow-sm mb-4 overflow-hidden">
            <nav class="flex flex-wrap border-b border-gray-200" role="tablist">
                {{-- Aba "Todas" --}}
                <a href="{{ route('nao_conformidades.index', request()->except('status', 'page')) }}"
                   role="tab"
                   class="px-4 py-3 text-sm font-medium border-b-2 transition inline-flex items-center gap-2
                          {{ !$statusAtivo
                              ? 'border-red-600 text-red-700 bg-red-50/40'
                              : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                    Todas
                    <span class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full font-semibold">
                        {{ $totalGeral }}
                    </span>
                </a>

                @foreach($statusCfg as $status => [$cls, $icon])
                    @php $count = $contadores[$status] ?? 0; @endphp
                    <a href="{{ route('nao_conformidades.index', array_merge(request()->except('status', 'page'), ['status' => $status])) }}"
                       role="tab"
                       class="px-4 py-3 text-sm font-medium border-b-2 transition inline-flex items-center gap-2
                              {{ $statusAtivo === $status
                                  ? 'border-red-600 text-red-700 bg-red-50/40'
                                  : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
                        <i class="fas {{ $icon }} text-xs"></i>
                        {{ $status }}
                        @if($count > 0)
                            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full font-semibold">
                                {{ $count }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </nav>
        </div>

        {{-- ============================================================ --}}
        {{-- Filtros                                                       --}}
        {{-- ============================================================ --}}
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('nao_conformidades.index') }}"
                  class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">

                {{-- Preserva a aba de status ativa --}}
                @if($statusAtivo)
                    <input type="hidden" name="status" value="{{ $statusAtivo }}">
                @endif

                {{-- Busca --}}
                <div class="md:col-span-5">
                    <label for="search" class="block text-xs font-medium text-gray-500 uppercase mb-1">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Código, título, descrição, local..."
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 text-sm">
                    </div>
                </div>

                {{-- Gravidade --}}
                <div class="md:col-span-3">
                    <label for="gravidade" class="block text-xs font-medium text-gray-500 uppercase mb-1">Gravidade</label>
                    <select name="gravidade" id="gravidade"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 text-sm">
                        <option value="">Todas</option>
                        @foreach(array_keys($gravidadeCfg) as $g)
                            <option value="{{ $g }}" @selected($gravidadeAtiva === $g)>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Origem --}}
                <div class="md:col-span-3">
                    <label for="origem" class="block text-xs font-medium text-gray-500 uppercase mb-1">Origem</label>
                    <select name="origem" id="origem"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 text-sm">
                        <option value="">Todas</option>
                        @foreach($origens as $o)
                            <option value="{{ $o }}" @selected($origemAtiva === $o)>{{ $o }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Vencidas --}}
                <div class="md:col-span-1 flex items-center md:pb-2">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer select-none"
                           title="Somente NCs com prazo vencido e em aberto">
                        <input type="checkbox" name="apenas_vencidas" value="1"
                               @checked($apenasVencidas)
                               class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                        <span class="whitespace-nowrap">
                            <i class="fas fa-clock text-orange-500"></i> Vencidas
                        </span>
                    </label>
                </div>

                {{-- Botões --}}
                <div class="md:col-span-12 flex flex-wrap gap-2 justify-end border-t pt-3">
                    @if($temFiltrosAtivos)
                        <a href="{{ route('nao_conformidades.index', $statusAtivo ? ['status' => $statusAtivo] : []) }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-times mr-2"></i> Limpar filtros
                        </a>
                    @endif
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition text-sm">
                        <i class="fas fa-filter mr-2"></i> Aplicar
                    </button>
                </div>
            </form>
        </div>

        {{-- ============================================================ --}}
        {{-- Tabela                                                        --}}
        {{-- ============================================================ --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-1"></i>Código
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-heading mr-1"></i>Título
                            </th>
                            <th class="hidden lg:table-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-building mr-1"></i>Empresa
                            </th>
                            <th class="hidden md:table-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-tag mr-1"></i>Origem
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-exclamation-circle mr-1"></i>Gravidade
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-toggle-on mr-1"></i>Status
                            </th>
                            <th class="hidden md:table-cell px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <i class="fas fa-hourglass-half mr-1"></i>Prazo
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($naoConformidades as $nc)
                            @php
                                $vencida = $nc->prazo_tratamento
                                    && $nc->prazo_tratamento->isPast()
                                    && $nc->status !== 'Fechada';

                                $proximaVencimento = $nc->prazo_tratamento
                                    && !$vencida
                                    && $nc->prazo_tratamento->diffInDays(now()) <= 3;
                            @endphp
                            <tr class="odd:bg-white even:bg-gray-50/60 hover:bg-red-50/40 transition duration-150">
                                {{-- Código --}}
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-mono font-semibold text-gray-900">
                                    {{ $nc->codigo }}
                                </td>

                                {{-- Título + norma/cláusula --}}
                                <td class="px-4 py-4 text-sm text-gray-800">
                                    <div class="font-medium">{{ $nc->titulo }}</div>
                                    @if($nc->norma || $nc->clausula || $nc->processo)
                                        <div class="text-xs text-gray-500 mt-1 flex flex-wrap gap-x-3">
                                            @if($nc->norma)
                                                <span><i class="fas fa-file-alt mr-1"></i>{{ $nc->norma->codigo }}</span>
                                            @endif
                                            @if($nc->clausula)
                                                <span><i class="fas fa-list-ul mr-1"></i>{{ Str::limit($nc->clausula->descricao ?? $nc->clausula->nome, 40) }}</span>
                                            @endif
                                            @if($nc->processo)
                                                <span><i class="fas fa-cogs mr-1"></i>{{ $nc->processo->nome }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                {{-- Empresa --}}
                                <td class="hidden lg:table-cell px-4 py-4 text-sm text-gray-600">
                                    {{ $nc->empresa->razao_social ?? 'N/A' }}
                                </td>

                                {{-- Origem --}}
                                <td class="hidden md:table-cell px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        {{ $nc->origem }}
                                    </span>
                                </td>

                                {{-- Gravidade --}}
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                                 {{ $gravidadeCfg[$nc->gravidade] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $nc->gravidade ?? 'N/A' }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @php [$cls, ] = $statusCfg[$nc->status] ?? ['bg-gray-100 text-gray-800', ''];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $cls }}">
                                        {{ $nc->status }}
                                    </span>
                                </td>

                                {{-- Prazo --}}
                                <td class="hidden md:table-cell px-4 py-4 whitespace-nowrap text-sm">
                                    @if($nc->prazo_tratamento)
                                        <span class="inline-flex items-center gap-1
                                            @if($vencida) text-red-600 font-semibold
                                            @elseif($proximaVencimento) text-orange-600 font-semibold
                                            @else text-gray-600 @endif">
                                            @if($vencida)
                                                <i class="fas fa-exclamation-triangle"></i>
                                            @endif
                                            {{ $nc->prazo_tratamento->format('d/m/Y') }}
                                        </span>
                                        @if($vencida)
                                            <div class="text-[11px] text-red-500">
                                                vencida há {{ $nc->prazo_tratamento->diffInDays(now()) }} dia(s)
                                            </div>
                                        @elseif($proximaVencimento)
                                            <div class="text-[11px] text-orange-500">
                                                vence em {{ $nc->prazo_tratamento->diffInDays(now()) }} dia(s)
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>

                                {{-- Ações --}}
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-1">
                                        <a href="{{ route('nao_conformidades.show', $nc) }}"
                                        class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                        title="Visualizar">
                                            <i class="fas fa-eye"></i>Visualizar
                                        </a>
                                        <a href="{{ route('nao_conformidades.edit', $nc) }}"
                                        class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                        title="Editar">
                                            <i class="fas fa-edit"></i>Editar
                                        </a>
                                        <form action="{{ route('nao_conformidades.destroy', $nc) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Tem certeza que deseja excluir a NC {{ $nc->codigo }}?');">
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
                            {{-- ============================================== --}}
                            {{-- Estado vazio com CTA                          --}}
                            {{-- ============================================== --}}
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="inline-flex flex-col items-center gap-3 max-w-md">
                                        <i class="fas fa-clipboard-check text-5xl text-gray-300"></i>

                                        @if($temFiltrosAtivos)
                                            <p class="text-gray-600 font-medium">
                                                Nenhuma NC encontrada com os filtros atuais.
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Tente ajustar a busca ou remover os filtros aplicados.
                                            </p>
                                            <a href="{{ route('nao_conformidades.index') }}"
                                               class="mt-2 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition text-sm">
                                                <i class="fas fa-times mr-2"></i> Limpar filtros
                                            </a>
                                        @else
                                            <p class="text-gray-700 font-medium">
                                                Nenhuma não conformidade cadastrada ainda.
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Comece registrando a primeira NC para acompanhar tratativas e prazos.
                                            </p>
                                            <a href="{{ route('nao_conformidades.create') }}"
                                               class="mt-2 inline-flex items-center px-5 py-2.5 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition shadow-sm">
                                                <i class="fas fa-plus mr-2"></i> Cadastrar primeira NC
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($naoConformidades->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $naoConformidades->links() }}
                </div>
            @endif

            {{-- Rodapé: contagem atual --}}
            @if($naoConformidades->total() > 0)
                <div class="px-6 py-3 border-t border-gray-100 text-xs text-gray-500 flex justify-between items-center">
                    <span>
                        Mostrando
                        <strong>{{ $naoConformidades->firstItem() }}</strong>
                        a
                        <strong>{{ $naoConformidades->lastItem() }}</strong>
                        de
                        <strong>{{ $naoConformidades->total() }}</strong>
                        {{ Str::plural('registro', $naoConformidades->total()) }}
                    </span>
                    @if($temFiltrosAtivos)
                        <span class="inline-flex items-center gap-1 text-orange-600">
                            <i class="fas fa-filter"></i> filtros aplicados
                        </span>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>