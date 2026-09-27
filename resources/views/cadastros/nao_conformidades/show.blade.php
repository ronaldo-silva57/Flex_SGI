<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2 truncate">
                    <i class="fas fa-exclamation-triangle text-red-700"></i>
                    <span class="truncate">{{ $naoConformidade->titulo }}</span>
                    <span class="text-sm font-mono bg-gray-100 text-gray-700 px-2 py-0.5 rounded shrink-0">
                        {{ $naoConformidade->codigo }}
                    </span>
                </h2>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('nao_conformidades.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('nao_conformidades.edit', $naoConformidade) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-pen mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"
         x-data="{ tab: '{{ request('tab', 'resumo') }}' }">

        <x-breadcrumb :items="[
            ['label' => 'Cadastros', 'url' => route('cadastros.dashboard')],
            ['label' => 'Não Conformidades', 'url' => route('nao_conformidades.index')],
            ['label' => $naoConformidade->codigo],
        ]" />

        {{-- ================================================================= --}}
        {{-- CABEÇALHO / RESUMO EXECUTIVO                                       --}}
        {{-- ================================================================= --}}
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="min-w-0">
                        <h3 class="text-2xl font-bold text-gray-900 break-words">
                            {{ $naoConformidade->titulo }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1 flex flex-wrap items-center gap-3">
                            <span><i class="fas fa-tags mr-1"></i>{{ $naoConformidade->tipo ?? 'Não Conformidade' }}</span>
                            <span><i class="fas fa-tag mr-1"></i>{{ $naoConformidade->origem }}</span>
                            @if($naoConformidade->local_ocorrencia)
                                <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $naoConformidade->local_ocorrencia }}</span>
                            @endif
                            @if($naoConformidade->recorrente)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                    <i class="fas fa-redo mr-1"></i>Recorrente
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <x-badge-gravidade :gravidade="$naoConformidade->gravidade" />
                        <x-badge-status :status="$naoConformidade->status" />
                    </div>
                </div>

                {{-- Métricas rápidas --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-5">
                    <div class="p-3 rounded-md bg-gray-50 border border-gray-100">
                        <div class="text-xs uppercase text-gray-500 font-medium">Abertura</div>
                        <div class="text-sm font-semibold text-gray-800 mt-1">
                            {{ $naoConformidade->data_abertura?->format('d/m/Y') ?? '—' }}
                        </div>
                    </div>
                    <div class="p-3 rounded-md border
                        {{ $naoConformidade->prazo_tratamento
                            && $naoConformidade->prazo_tratamento->isPast()
                            && $naoConformidade->status !== 'Fechada'
                                ? 'bg-red-50 border-red-200'
                                : 'bg-gray-50 border-gray-100' }}">
                        <div class="text-xs uppercase text-gray-500 font-medium">Prazo</div>
                        <div class="text-sm font-semibold mt-1
                            {{ $naoConformidade->prazo_tratamento
                                && $naoConformidade->prazo_tratamento->isPast()
                                && $naoConformidade->status !== 'Fechada'
                                    ? 'text-red-700'
                                    : 'text-gray-800' }}">
                            {{ $naoConformidade->prazo_tratamento?->format('d/m/Y') ?? '—' }}
                        </div>
                    </div>
                    <div class="p-3 rounded-md bg-gray-50 border border-gray-100">
                        <div class="text-xs uppercase text-gray-500 font-medium">Análises</div>
                        <div class="text-sm font-semibold text-gray-800 mt-1">
                            {{ $totais['analises_causa'] }}
                        </div>
                    </div>
                    <div class="p-3 rounded-md border
                        {{ $totais['acoes_atrasadas'] > 0 ? 'bg-orange-50 border-orange-200' : 'bg-gray-50 border-gray-100' }}">
                        <div class="text-xs uppercase text-gray-500 font-medium">Ações pendentes</div>
                        <div class="text-sm font-semibold mt-1
                            {{ $totais['acoes_atrasadas'] > 0 ? 'text-orange-700' : 'text-gray-800' }}">
                            {{ $totais['acoes_pendentes'] }}
                            @if($totais['acoes_atrasadas'] > 0)
                                <span class="text-xs text-red-600 font-normal">
                                    ({{ $totais['acoes_atrasadas'] }} atrasada{{ $totais['acoes_atrasadas'] > 1 ? 's' : '' }})
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ================================================================= --}}
            {{-- ABAS                                                              --}}
            {{-- ================================================================= --}}
            <nav class="flex flex-wrap border-b border-gray-200 bg-gray-50/50" role="tablist">
                @php
                    $tabs = [
                        'resumo'          => ['Resumo',           'fa-circle-info',       null],
                        'analises'        => ['Análises de Causa','fa-magnifying-glass-chart', $totais['analises_causa']],
                        'acoes'           => ['Ações Corretivas', 'fa-screwdriver-wrench', $totais['acoes_corretivas']],
                        'historico'       => ['Histórico',        'fa-clock-rotate-left', $timeline->count()],
                    ];
                @endphp

                @foreach($tabs as $key => [$label, $icon, $count])
                    <button type="button"
                            role="tab"
                            @click="tab = '{{ $key }}'"
                            :class="tab === '{{ $key }}'
                                ? 'border-red-600 text-red-700 bg-white'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-white/60'"
                            class="px-4 py-3 text-sm font-medium border-b-2 transition inline-flex items-center gap-2">
                        <i class="fas {{ $icon }} text-xs"></i>
                        {{ $label }}
                        @if(!is_null($count) && $count > 0)
                            <span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full font-semibold">
                                {{ $count }}
                            </span>
                        @endif
                    </button>
                @endforeach
            </nav>

            {{-- ================================================================= --}}
            {{-- ABA: RESUMO                                                        --}}
            {{-- ================================================================= --}}
            <div x-show="tab === 'resumo'" x-transition.opacity class="p-6 space-y-6">

                {{-- Classificação --}}
                <section>
                    <h4 class="text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-sitemap text-red-500"></i> Classificação
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-4">
                        <div>
                            <span class="block text-xs uppercase text-gray-500 font-medium">Empresa</span>
                            <span class="mt-1 block text-gray-900 font-semibold">
                                {{ $naoConformidade->empresa->razao_social ?? 'N/A' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs uppercase text-gray-500 font-medium">Cliente</span>
                            <span class="mt-1 block text-gray-900">
                                {{ $naoConformidade->cliente->razao_social ?? ($naoConformidade->cliente->nome ?? '—') }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs uppercase text-gray-500 font-medium">Norma</span>
                            <span class="mt-1 block text-gray-900">
                                {{ $naoConformidade->norma->codigo ?? '—' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs uppercase text-gray-500 font-medium">Cláusula</span>
                            <span class="mt-1 block text-gray-900">
                                {{ $naoConformidade->clausula->descricao
                                    ?? $naoConformidade->clausula->nome
                                    ?? '—' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs uppercase text-gray-500 font-medium">Processo</span>
                            <span class="mt-1 block text-gray-900">
                                {{ $naoConformidade->processo->nome ?? '—' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs uppercase text-gray-500 font-medium">Origem</span>
                            <span class="mt-1 block text-gray-900">{{ $naoConformidade->origem }}</span>
                        </div>
                    </div>
                </section>

                <hr class="border-gray-100">

                {{-- Responsáveis --}}
                <section>
                    <h4 class="text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-user-friends text-red-500"></i> Responsáveis
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-md">
                            <div class="w-10 h-10 rounded-full bg-red-100 text-red-700 flex items-center justify-center font-bold">
                                {{ strtoupper(substr($naoConformidade->responsavelApuracao->name ?? '—', 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-xs uppercase text-gray-500 font-medium">Apuração</div>
                                <div class="text-sm font-semibold text-gray-800">
                                    {{ $naoConformidade->responsavelApuracao->name ?? 'Não atribuído' }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-md">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                                {{ strtoupper(substr($naoConformidade->responsavelTratamento->name ?? '—', 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-xs uppercase text-gray-500 font-medium">Tratamento</div>
                                <div class="text-sm font-semibold text-gray-800">
                                    {{ $naoConformidade->responsavelTratamento->name ?? 'Não atribuído' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <hr class="border-gray-100">

                {{-- Descrição --}}
                <section>
                    <h4 class="text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-clipboard-list text-red-500"></i> Descrição da Ocorrência
                    </h4>
                    <div class="space-y-4">
                        <div>
                            <span class="block text-xs uppercase text-gray-500 font-medium mb-1">Descrição</span>
                            <p class="text-gray-800 whitespace-pre-line bg-gray-50 p-3 rounded-md border border-gray-100">
                                {{ $naoConformidade->descricao }}
                            </p>
                        </div>
                        @if($naoConformidade->requisito_nao_atendido)
                            <div>
                                <span class="block text-xs uppercase text-gray-500 font-medium mb-1">Requisito não atendido</span>
                                <p class="text-gray-800 whitespace-pre-line bg-gray-50 p-3 rounded-md border border-gray-100">
                                    {{ $naoConformidade->requisito_nao_atendido }}
                                </p>
                            </div>
                        @endif
                        @if($naoConformidade->evidencia_inicial)
                            <div>
                                <span class="block text-xs uppercase text-gray-500 font-medium mb-1">Evidência inicial</span>
                                <p class="text-gray-800 whitespace-pre-line bg-gray-50 p-3 rounded-md border border-gray-100">
                                    {{ $naoConformidade->evidencia_inicial }}
                                </p>
                            </div>
                        @endif
                    </div>
                </section>

                <hr class="border-gray-100">

                {{-- Datas --}}
                <section>
                    <h4 class="text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-red-500"></i> Linha do tempo (datas-chave)
                    </h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @php
                            $datas = [
                                ['Identificação', $naoConformidade->data_identificacao, 'fa-search'],
                                ['Abertura',      $naoConformidade->data_abertura,       'fa-calendar-plus'],
                                ['Prazo',         $naoConformidade->prazo_tratamento,    'fa-hourglass-half'],
                                ['Análise',       $naoConformidade->data_analise,        'fa-clipboard-check'],
                                ['Verificação',   $naoConformidade->data_verificacao,    'fa-check-double'],
                                ['Encerramento',  $naoConformidade->data_encerramento,   'fa-flag-checkered'],
                            ];
                        @endphp
                        @foreach($datas as [$label, $valor, $icon])
                            <div class="flex items-center gap-2 p-3 rounded-md border border-gray-100 bg-white">
                                <i class="fas {{ $icon }} text-gray-400 w-4"></i>
                                <div>
                                    <div class="text-xs uppercase text-gray-500 font-medium">{{ $label }}</div>
                                    <div class="text-sm font-semibold text-gray-800">
                                        {{ $valor?->format('d/m/Y') ?? '—' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                @if($naoConformidade->justificativa_encerramento)
                    <hr class="border-gray-100">
                    <section>
                        <h4 class="text-base font-semibold text-gray-800 mb-3 flex items-center gap-2">
                            <i class="fas fa-flag-checkered text-red-500"></i> Justificativa de encerramento
                        </h4>
                        <p class="text-gray-800 whitespace-pre-line bg-green-50 p-3 rounded-md border border-green-100">
                            {{ $naoConformidade->justificativa_encerramento }}
                        </p>
                    </section>
                @endif
            </div>

            {{-- ================================================================= --}}
            {{-- ABA: ANÁLISES DE CAUSA                                            --}}
            {{-- ================================================================= --}}
            <div x-show="tab === 'analises'" x-transition.opacity class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-base font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-magnifying-glass-chart text-purple-500"></i>
                        Análises de Causa
                    </h4>
                    <a href="{{ route('analises_causa.create', $naoConformidade) }}"
                       class="inline-flex items-center px-3 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition shadow-sm text-sm">
                        <i class="fas fa-plus mr-2"></i>Nova Análise
                    </a>
                </div>

                @if($naoConformidade->analisesCausa->isEmpty())
                    <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-lg">
                        <i class="fas fa-magnifying-glass-chart text-4xl text-gray-300"></i>
                        <p class="mt-3 text-gray-600 font-medium">Nenhuma análise de causa registrada.</p>
                        <p class="text-sm text-gray-500 mt-1">
                            Use 5 Porquês ou Ishikawa para chegar à causa raiz.
                        </p>
                        <a href="{{ route('analises_causa.create', ['nao_conformidade_id' => $naoConformidade->id]) }}"
                           class="mt-4 inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition shadow-sm">
                            <i class="fas fa-plus mr-2"></i>Iniciar primeira análise
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($naoConformidade->analisesCausa as $analise)
                            <div class="flex flex-wrap items-center justify-between gap-3 p-4 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50/30 transition">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-700 flex items-center justify-center">
                                        <i class="fas fa-diagram-project"></i>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-semibold text-gray-900">{{ $analise->metodo }}</span>
                                            <x-badge-status :status="$analise->status" />
                                            @if($analise->ishikawa)
                                                <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full font-semibold">
                                                    <i class="fas fa-fish-fins mr-1"></i>Ishikawa
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Responsável: <strong>{{ $analise->responsavel->name ?? '—' }}</strong>
                                            @if($analise->data_inicio)
                                                · Início: {{ $analise->data_inicio->format('d/m/Y') }}
                                            @endif
                                            @if($analise->data_conclusao)
                                                · Concluída: {{ $analise->data_conclusao->format('d/m/Y') }}
                                            @endif
                                        </div>
                                        @if($analise->objetivo)
                                            <p class="text-sm text-gray-600 mt-1 line-clamp-1">
                                                {{ Str::limit($analise->objetivo, 120) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('analises_causa.show', [$naoConformidade, $analise]) }}"
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-md transition"
                                       title="Visualizar">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('analises_causa.edit', [$naoConformidade, $analise]) }}"
                                       class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-md transition"
                                       title="Editar">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- ================================================================= --}}
            {{-- ABA: AÇÕES CORRETIVAS                                              --}}
            {{-- ================================================================= --}}
            <div x-show="tab === 'acoes'" x-transition.opacity class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-base font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-screwdriver-wrench text-orange-500"></i>
                        Ações Corretivas
                    </h4>
                    <a href="{{ route('acoes_corretivas.create', ['nao_conformidade_id' => $naoConformidade->id]) }}"
                       class="inline-flex items-center px-3 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition shadow-sm text-sm">
                        <i class="fas fa-plus mr-2"></i>Nova Ação
                    </a>
                </div>

                @if($naoConformidade->acoesCorretivas->isEmpty())
                    <div class="text-center py-12 border-2 border-dashed border-gray-200 rounded-lg">
                        <i class="fas fa-screwdriver-wrench text-4xl text-gray-300"></i>
                        <p class="mt-3 text-gray-600 font-medium">Nenhuma ação corretiva registrada.</p>
                        <p class="text-sm text-gray-500 mt-1">
                            Defina contenção, correção e verificação de eficácia.
                        </p>
                        <a href="{{ route('acoes_corretivas.create', ['naoConformidade' => $naoConformidade->id]) }}"
                           class="mt-4 inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition shadow-sm">
                            <i class="fas fa-plus mr-2"></i>Criar primeira ação
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Etapa</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Descrição</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Responsável</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prazo</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach($naoConformidade->acoesCorretivas as $acao)
                                    @php
                                        $atrasada = $acao->prazo
                                            && $acao->prazo->isPast()
                                            && !in_array($acao->status, ['Concluída', 'Reprovada']);
                                        $etapaCls = [
                                            'Contenção'    => 'bg-blue-100 text-blue-800',
                                            'Causa raiz'   => 'bg-purple-100 text-purple-800',
                                            'Correção'     => 'bg-indigo-100 text-indigo-800',
                                            'Verificação'  => 'bg-yellow-100 text-yellow-800',
                                            'Conclusão'    => 'bg-green-100 text-green-800',
                                        ][$acao->etapa] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <tr class="hover:bg-orange-50/40 transition">
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $etapaCls }}">
                                                {{ $acao->etapa }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-800">
                                            {{ Str::limit($acao->descricao, 80) }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                            {{ $acao->responsavel->name ?? '—' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <x-badge-status :status="$acao->status" />
                                            @if($acao->eficaz === true)
                                                <span class="ml-1 inline-flex items-center text-green-600 text-xs" title="Ação eficaz">
                                                    <i class="fas fa-check-circle"></i>
                                                </span>
                                            @elseif($acao->eficaz === false)
                                                <span class="ml-1 inline-flex items-center text-red-600 text-xs" title="Ação não eficaz">
                                                    <i class="fas fa-times-circle"></i>
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                                            @if($acao->prazo)
                                                <span class="{{ $atrasada ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                                    @if($atrasada)<i class="fas fa-exclamation-triangle mr-1"></i>@endif
                                                    {{ $acao->prazo->format('d/m/Y') }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-right">
                                            <div class="flex justify-end gap-1">
                                                <a href="{{ route('acoes_corretivas.show', $acao) }}"
                                                   class="p-2 text-blue-600 hover:bg-blue-50 rounded-md transition"
                                                   title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('acoes_corretivas.edit', $acao) }}"
                                                   class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-md transition"
                                                   title="Editar">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- ================================================================= --}}
            {{-- ABA: HISTÓRICO / TIMELINE                                          --}}
            {{-- ================================================================= --}}
            <div x-show="tab === 'historico'" x-transition.opacity class="p-6">
                <h4 class="text-base font-semibold text-gray-800 flex items-center gap-2 mb-4">
                    <i class="fas fa-clock-rotate-left text-gray-500"></i> Histórico
                </h4>

                @if($timeline->isEmpty())
                    <p class="text-sm text-gray-500">Nenhum evento registrado.</p>
                @else
                    @php
                        $corMap = [
                            'red'    => ['bg-red-100 text-red-700',       'border-red-200'],
                            'purple' => ['bg-purple-100 text-purple-700', 'border-purple-200'],
                            'orange' => ['bg-orange-100 text-orange-700', 'border-orange-200'],
                            'green'  => ['bg-green-100 text-green-700',   'border-green-200'],
                            'yellow' => ['bg-yellow-100 text-yellow-700', 'border-yellow-200'],
                        ];
                    @endphp
                    <ol class="relative border-l-2 border-gray-100 ml-4 space-y-6">
                        @foreach($timeline as $evento)
                            @php [$badgeBg, $badgeBorder] = $corMap[$evento['cor']] ?? $corMap['red']; @endphp
                            <li class="ml-6">
                                <span class="absolute -left-[13px] w-6 h-6 rounded-full flex items-center justify-center border-2 {{ $badgeBg }} {{ $badgeBorder }}">
                                    <i class="fas {{ $evento['icone'] }} text-[10px]"></i>
                                </span>
                                <div class="flex flex-wrap items-baseline gap-2">
                                    <time class="text-xs uppercase text-gray-400 font-medium tracking-wide">
                                        {{ optional($evento['data'])->format('d/m/Y') ?? '—' }}
                                    </time>
                                    <span class="text-sm font-semibold text-gray-800">
                                        {{ $evento['titulo'] }}
                                    </span>
                                </div>
                                @if(!empty($evento['desc']))
                                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($evento['desc'], 200) }}</p>
                                @endif
                                @if(!empty($evento['url']))
                                    <a href="{{ $evento['url'] }}"
                                       class="text-xs text-blue-600 hover:underline mt-1 inline-block">
                                        Ver detalhes <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>

        {{-- ================================================================= --}}
        {{-- RODAPÉ: METADADOS E EXCLUIR                                        --}}
        {{-- ================================================================= --}}
        <div class="bg-white p-4 rounded-lg shadow-sm flex flex-wrap justify-between items-center gap-3">
            <div class="text-xs text-gray-500">
                <div>Criado em: <strong>{{ $naoConformidade->created_at?->format('d/m/Y H:i') }}</strong></div>
                <div>Atualizado em: <strong>{{ $naoConformidade->updated_at?->format('d/m/Y H:i') }}</strong></div>
            </div>


            <a href="{{ route('nao_conformidades.relatorio.pdf', $naoConformidade) }}"
            target="_blank"
            class="inline-flex items-center px-4 py-2 bg-red-50 text-red-700 rounded-md hover:bg-red-100 border border-red-200 transition shadow-sm">
                <i class="fas fa-file-pdf mr-2"></i>Gerar PDF
            </a>

            <form action="{{ route('nao_conformidades.destroy', $naoConformidade) }}" method="POST"
                  onsubmit="return confirm('Tem certeza que deseja excluir a NC {{ $naoConformidade->codigo }}?\nAções e análises vinculadas também serão removidas.');">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                    <i class="fas fa-trash mr-2"></i> Excluir NC
                </button>
            </form>
        </div>
    </div>
</x-app-layout>