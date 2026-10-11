<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Painel Geral e Estrutura') }}
            </h2>
            <a href="{{ route('dashboard') }}"
               class="text-sm text-slate-700 hover:underline">← Voltar aos módulos</a>
        </div>
<div class="flex gap-2">
    <a href="{{ route('relatorios.revisao-direcao.preview') }}" target="_blank"
       class="inline-flex items-center gap-2 px-3 py-1.5 text-sm bg-white text-gray-700 border rounded-lg hover:bg-gray-50">
        <i class="fas fa-eye"></i> Pré-visualizar
    </a>
    <a href="{{ route('relatorios.revisao-direcao.baixar') }}"
       class="inline-flex items-center gap-2 px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">
        <i class="fas fa-file-pdf"></i> Exportar PDF
    </a>
</div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===== KPIs ===== --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    ['label' => 'Departamentos',  'valor' => $kpis['departamentos_ativos'], 'icone' => 'fa-sitemap',    'cor' => 'bg-slate-700'],
                    ['label' => 'Clientes ativos','valor' => $kpis['clientes_ativos'],      'icone' => 'fa-users',      'cor' => 'bg-blue-600'],
                    ['label' => 'Fornecedores',   'valor' => $kpis['fornecedores_ativos'],  'icone' => 'fa-truck',      'cor' => 'bg-cyan-600'],
                    ['label' => 'Docs aprovados', 'valor' => $kpis['documentos_aprovados'], 'icone' => 'fa-file-lines', 'cor' => 'bg-emerald-600'],
                ] as $kpi)
                    <div class="bg-white rounded-xl shadow-sm p-4 flex items-center gap-3">
                        <div class="w-11 h-11 rounded-lg {{ $kpi['cor'] }} text-white flex items-center justify-center">
                            <i class="fas {{ $kpi['icone'] }}"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase">{{ $kpi['label'] }}</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $kpi['valor'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ===== ALERTAS ===== --}}
            @php
                $alertasConfig = [
                    'nc_abertas'              => ['label' => 'NCs abertas',           'cor' => 'red',   'rota' => route('nao_conformidades.index')],
                    'nc_atrasadas'            => ['label' => 'NCs atrasadas',         'cor' => 'red',   'rota' => route('nao_conformidades.index')],
                    'nc_graves_abertas'       => ['label' => 'NCs Alta/Crítica',      'cor' => 'red',   'rota' => route('nao_conformidades.index')],
                    'auditorias_abertas'      => ['label' => 'Auditorias abertas',    'cor' => 'blue',  'rota' => route('auditorias.index')],
                    'auditorias_atrasadas'    => ['label' => 'Auditorias atrasadas',  'cor' => 'amber', 'rota' => route('auditorias.index')],
                    'documentos_revisao'      => ['label' => 'Docs em revisão',       'cor' => 'amber', 'rota' => route('documentos.index')],
                    'documentos_vencidos'     => ['label' => 'Docs p/ revisar',       'cor' => 'amber', 'rota' => route('documentos.index')],
                    'treinamentos_vencidos'   => ['label' => 'Treinam. vencidos',     'cor' => 'red',   'rota' => route('treinamentos_usuarios.index')],
                    'treinamentos_pendentes'  => ['label' => 'Treinam. pendentes',    'cor' => 'amber', 'rota' => route('treinamentos_usuarios.index')],
                    'planos_atrasados'        => ['label' => 'Planos atrasados',      'cor' => 'red',   'rota' => route('planos_acao.index')],
                    'mudancas_pendentes'      => ['label' => 'Mudanças pendentes',    'cor' => 'amber', 'rota' => route('mudancas_gestao.index')],
                    'fornecedores_reprovados' => ['label' => 'Fornec. reprovados',    'cor' => 'red',   'rota' => route('avaliacoes_fornecedores.index')],
                ];
                $cores = [
                    'red'   => 'border-red-400 bg-red-50 text-red-700',
                    'amber' => 'border-amber-400 bg-amber-50 text-amber-700',
                    'blue'  => 'border-blue-400 bg-blue-50 text-blue-700',
                ];
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($alertasConfig as $key => $cfg)
                    @php
                        $valor = $alertas[$key] ?? 0;
                        $destacar = $valor > 0 && in_array($cfg['cor'], ['red','amber']);
                    @endphp
                    <a href="{{ $cfg['rota'] }}"
                       class="rounded-lg border-l-4 p-3 {{ $cores[$cfg['cor']] }} {{ $destacar ? 'animate-pulse' : '' }} hover:shadow">
                        <p class="text-2xl font-bold">{{ $valor }}</p>
                        <p class="text-[11px] font-medium leading-tight">{{ $cfg['label'] }}</p>
                    </a>
                @endforeach
            </div>

            {{-- ===== GRÁFICOS LINHA 1 ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">NCs por Origem</h3>
                    <canvas id="chartNcOrigem" height="140"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">NCs por Status</h3>
                    <canvas id="chartNcStatus" height="140"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">NCs por Gravidade</h3>
                    <canvas id="chartNcGrav" height="140"></canvas>
                </div>
            </div>

            {{-- ===== GRÁFICOS LINHA 2 ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Auditorias por Tipo</h3>
                    <canvas id="chartAudTipo" height="140"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Documentos por Status</h3>
                    <canvas id="chartDocStatus" height="140"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Planos de Ação por Status</h3>
                    <canvas id="chartPlanos" height="140"></canvas>
                </div>
            </div>

            {{-- ===== GRÁFICOS LINHA 3 ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Treinamentos</h3>
                    <canvas id="chartTrein" height="130"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Avaliação de Fornecedores</h3>
                    <canvas id="chartAvalFornec" height="130"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Riscos vs Oportunidades</h3>
                    <canvas id="chartRiscOport" height="130"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Auditorias por Status</h3>
                    <canvas id="chartAudStatus" height="130"></canvas>
                </div>
            </div>

            {{-- ===== Auditorias 12 meses ===== --}}
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="font-semibold text-gray-700 mb-3">Auditorias (12 meses)</h3>
                <canvas id="chartAudMes" height="90"></canvas>
            </div>

            {{-- ===== LISTAS ACIONÁVEIS ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">🚨 NCs Atrasadas</h3>
                    @forelse($ncAtrasadas as $nc)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium">{{ $nc->codigo }} — {{ $nc->titulo }}</p>
                                <p class="text-xs text-gray-500">
                                    Prazo: {{ \Carbon\Carbon::parse($nc->prazo_tratamento)->format('d/m/Y') }}
                                    · {{ $nc->gravidade }}
                                </p>
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">{{ $nc->status }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhuma NC atrasada. 🎉</p>
                    @endforelse
                </div>

                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">📋 Planos de Ação Atrasados</h3>
                    @forelse($planosAtrasados as $pa)
                        <div class="py-2 border-b last:border-0">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="font-medium">{{ $pa->codigo ?? '—' }} · {{ $pa->titulo }}</span>
                                <span class="text-red-600 font-semibold">
                                    {{ \Carbon\Carbon::parse($pa->prazo_fim)->format('d/m/Y') }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ $pa->progresso }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhum plano atrasado. 🎉</p>
                    @endforelse
                </div>

                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">📄 Documentos em Revisão</h3>
                    @forelse($documentosRevisao as $d)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium">{{ $d->codigo }} — {{ $d->titulo }}</p>
                                <p class="text-xs text-gray-500">v{{ $d->versao }}</p>
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full
                                {{ $d->status === 'Rascunho' ? 'bg-gray-100 text-gray-600' : 'bg-amber-100 text-amber-700' }}">
                                {{ $d->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhum documento em revisão.</p>
                    @endforelse
                </div>

                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">🎓 Treinamentos a Vencer (60d)</h3>
                    @forelse($treinamentosVencendo as $t)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium">{{ $t->treinamento->titulo ?? '—' }}</p>
                                <p class="text-xs text-gray-500">{{ $t->usuario->name ?? '—' }}</p>
                            </div>
                            <span class="text-xs font-semibold text-amber-600">
                                {{ \Carbon\Carbon::parse($t->validade_ate)->format('d/m/Y') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhum treinamento a vencer.</p>
                    @endforelse
                </div>

                <div class="bg-white rounded-xl shadow-sm p-5 lg:col-span-2">
                    <h3 class="font-semibold text-gray-700 mb-3">📅 Próximas Auditorias</h3>
                    @forelse($proximasAuditorias as $a)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium">{{ $a->tipo }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $a->data_inicio ? \Carbon\Carbon::parse($a->data_inicio)->format('d/m/Y') : '—' }}
                                    @if($a->data_fim) → {{ \Carbon\Carbon::parse($a->data_fim)->format('d/m/Y') }} @endif
                                </p>
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-700">{{ $a->status }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhuma auditoria planejada.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const palette = ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#0ea5e9','#14b8a6','#94a3b8'];

        const buildChart = (id, type, data, cores = palette, extra = {}) => {
            const labels = Object.keys(data);
            const valores = Object.values(data);
            if (!labels.length) return;
            new Chart(document.getElementById(id), {
                type,
                data: { labels, datasets: [{ data: valores,
                    backgroundColor: type === 'doughnut' || type === 'pie' ? cores : cores[0] }] },
                options: Object.assign({
                    plugins: { legend: { position: type === 'doughnut' ? 'bottom' : 'none' } },
                    scales: type === 'doughnut' || type === 'pie' ? {} :
                        { y: { beginAtZero: true, ticks: { precision: 0 } } }
                }, extra)
            });
        };

        buildChart('chartNcOrigem',  'doughnut', @json($ncPorOrigem));
        buildChart('chartNcStatus',  'bar',      @json($ncPorStatus),      ['#3b82f6']);
        buildChart('chartNcGrav',    'bar',      @json($ncPorGravidade),   ['#ef4444']);
        buildChart('chartAudTipo',   'doughnut', @json($auditoriasPorTipo));
        buildChart('chartDocStatus', 'doughnut', @json($documentosPorStatus));
        buildChart('chartPlanos',    'bar',      @json($planosPorStatus),  ['#10b981']);
        buildChart('chartTrein',     'doughnut', @json($treinamentosPorStatus));
        buildChart('chartAvalFornec','bar',      @json($avalFornec),       ['#0ea5e9']);
        buildChart('chartRiscOport', 'doughnut', @json($riscosOport),      ['#ef4444','#10b981']);
        buildChart('chartAudStatus', 'doughnut', @json($auditoriasPorStatus));

        // Auditorias por mês
        const audMes = @json($auditoriasMes->pluck('total','mes'));
        if (Object.keys(audMes).length) {
            new Chart(document.getElementById('chartAudMes'), {
                type: 'line',
                data: { labels: Object.keys(audMes),
                    datasets: [{ label:'Auditorias', data: Object.values(audMes),
                        borderColor:'#6366f1', backgroundColor:'rgba(99,102,241,.15)',
                        tension:.3, fill:true }] },
                options: { plugins: { legend: { display:false } } }
            });
        }
    </script>
</x-app-layout>