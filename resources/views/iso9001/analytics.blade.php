<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Painel ISO 9001') }}
            </h2>
            <a href="{{ route('dashboard') }}"
               class="text-sm text-indigo-600 hover:underline">← Voltar aos módulos</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===== KPIs ===== --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    ['label' => 'Normas ativas',        'valor' => $kpis['normas_ativas'],      'icone' => 'fa-book',        'cor' => 'bg-blue-600'],
                    ['label' => 'Processos ativos',     'valor' => $kpis['processos_ativos'],   'icone' => 'fa-gears',       'cor' => 'bg-cyan-600'],
                    ['label' => 'Indicadores ativos',   'valor' => $kpis['indicadores_ativos'], 'icone' => 'fa-chart-line',  'cor' => 'bg-emerald-600'],
                    ['label' => 'Reuniões no ano',      'valor' => $kpis['reunioes_ano'],       'icone' => 'fa-users',       'cor' => 'bg-sky-600'],
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
                    'calibracoes_vencidas'           => ['label' => 'Calibrações vencidas',           'cor' => 'red',    'rota' => route('calibracoes.index')],
                    'calibracoes_proximas'           => ['label' => 'Calibrações em 30 dias',        'cor' => 'amber',  'rota' => route('calibracoes.index')],
                    'monitoramentos_atrasados'       => ['label' => 'Monitoramentos atrasados',      'cor' => 'red',    'rota' => route('monitoramentos.index')],
                    'indicadores_sem_monitoramento'  => ['label' => 'Indicadores sem monitoramento', 'cor' => 'amber',  'rota' => route('indicadores.index')],
                    'pesquisas_andamento'            => ['label' => 'Pesquisas em andamento',        'cor' => 'blue',   'rota' => route('pesquisas_satisfacao.index')],
                ];
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                @foreach($alertasConfig as $key => $cfg)
                    @php
                        $valor = $alertas[$key] ?? 0;
                        $destacar = $valor > 0 && in_array($cfg['cor'], ['red','amber']);
                        $cores = [
                            'red'   => 'border-red-400 bg-red-50 text-red-700',
                            'amber' => 'border-amber-400 bg-amber-50 text-amber-700',
                            'blue'  => 'border-blue-400 bg-blue-50 text-blue-700',
                        ];
                    @endphp
                    <a href="{{ $cfg['rota'] }}"
                       class="rounded-lg border-l-4 p-3 {{ $cores[$cfg['cor']] }} {{ $destacar ? 'animate-pulse' : '' }} hover:shadow">
                        <p class="text-2xl font-bold">{{ $valor }}</p>
                        <p class="text-xs font-medium">{{ $cfg['label'] }}</p>
                    </a>
                @endforeach
            </div>

            {{-- ===== GRÁFICOS ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                {{-- Monitoramentos por mês --}}
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Monitoramentos (últimos 12 meses)</h3>
                    <canvas id="chartMonitoramentos" height="110"></canvas>
                </div>

                {{-- NPS --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">NPS (12 meses)</h3>
                    @if($nps['score'] !== null)
                        <p class="text-4xl font-bold
                            {{ $nps['score'] >= 50 ? 'text-emerald-600' : ($nps['score'] >= 0 ? 'text-amber-600' : 'text-red-600') }}">
                            {{ $nps['score'] }}
                        </p>
                        <p class="text-xs text-gray-500 mb-3">Base: {{ $nps['total'] }} respostas</p>
                        <canvas id="chartNps" height="140"></canvas>
                    @else
                        <p class="text-sm text-gray-400">Sem respostas suficientes no período.</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                {{-- Status Equipamentos --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Equipamentos de Medição — Status</h3>
                    <canvas id="chartEquipamentos" height="140"></canvas>
                </div>

                {{-- NPS por pesquisa --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Últimas Pesquisas — Nota Média</h3>
                    @if($npsPorPesquisa->isEmpty())
                        <p class="text-sm text-gray-400">Sem dados.</p>
                    @else
                        <canvas id="chartPesquisas" height="140"></canvas>
                    @endif
                </div>
            </div>

            {{-- ===== LISTAS DE AÇÃO ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                {{-- Próximas calibrações --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">⏰ Próximas Calibrações</h3>
                    @forelse($proximasCalibracoes as $eq)
                        @php
                            $dias = \Carbon\Carbon::parse($eq->proxima_calibracao)->diffInDays(now(), false);
                            $cor  = $dias > 0 ? 'text-red-600' : ($dias > -30 ? 'text-amber-600' : 'text-gray-500');
                        @endphp
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium">{{ $eq->codigo }} — {{ $eq->nome }}</p>
                            </div>
                            <span class="text-xs font-semibold {{ $cor }}">
                                {{ \Carbon\Carbon::parse($eq->proxima_calibracao)->format('d/m/Y') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhuma calibração agendada.</p>
                    @endforelse
                </div>

                {{-- Monitoramentos atrasados --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">🚨 Monitoramentos Atrasados</h3>
                    @forelse($monitoramentosAtrasados as $m)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium">
                                    {{ $m->indicador->nome ?? '—' }}
                                </p>
                                <p class="text-xs text-gray-500">Período: {{ $m->periodo_referencia }}</p>
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full bg-red-100 text-red-700">
                                Atrasado
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhum monitoramento atrasado. 🎉</p>
                    @endforelse
                </div>
            </div>

            {{-- Última reunião --}}
            @if($ultimaReuniao)
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-2">Última Revisão pela Direção</h3>
                    <p class="text-sm text-gray-600">
                        <strong>Data:</strong> {{ \Carbon\Carbon::parse($ultimaReuniao->data_reuniao)->format('d/m/Y') }}
                        @if($ultimaReuniao->proxima_reuniao)
                            · <strong>Próxima:</strong>
                            {{ \Carbon\Carbon::parse($ultimaReuniao->proxima_reuniao)->format('d/m/Y') }}
                        @endif
                    </p>
                </div>
            @endif

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const mesesData    = @json($monitoramentosMes->pluck('total', 'mes'));
        const mesesLabels  = Object.keys(mesesData);
        const mesesTotais  = Object.values(mesesData);
        const mesesAtras   = @json($monitoramentosMes->pluck('atrasados', 'mes'));

        new Chart(document.getElementById('chartMonitoramentos'), {
            type: 'line',
            data: {
                labels: mesesLabels,
                datasets: [
                    {
                        label: 'Total',
                        data: mesesTotais,
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14,165,233,.15)',
                        tension: .3,
                        fill: true
                    },
                    {
                        label: 'Atrasados',
                        data: mesesLabels.map(m => mesesAtras[m] || 0),
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239,68,68,.15)',
                        tension: .3,
                        fill: true
                    }
                ]
            },
            options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
        });

        @if($nps['score'] !== null)
        new Chart(document.getElementById('chartNps'), {
            type: 'doughnut',
            data: {
                labels: ['Promotores', 'Neutros', 'Detratores'],
                datasets: [{
                    data: [{{ $nps['promotores'] }}, {{ $nps['neutros'] }}, {{ $nps['detratores'] }}],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });
        @endif

        const eqStatus = @json($equipamentosStatus);
        new Chart(document.getElementById('chartEquipamentos'), {
            type: 'bar',
            data: {
                labels: Object.keys(eqStatus),
                datasets: [{
                    data: Object.values(eqStatus),
                    backgroundColor: ['#3b82f6', '#f59e0b', '#94a3b8', '#ef4444']
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
            }
        });

        @if(!$npsPorPesquisa->isEmpty())
        new Chart(document.getElementById('chartPesquisas'), {
            type: 'bar',
            data: {
                labels: @json($npsPorPesquisa->pluck('titulo')),
                datasets: [{
                    label: 'Nota Média',
                    data: @json($npsPorPesquisa->pluck('nota_media')),
                    backgroundColor: '#6366f1'
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero: true, max: 10 } }
            }
        });
        @endif
    </script>
</x-app-layout>