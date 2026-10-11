<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Painel ISO 14001 — Gestão Ambiental') }}
            </h2>
            <a href="{{ route('dashboard') }}"
               class="text-sm text-emerald-700 hover:underline">← Voltar aos módulos</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===== KPIs ===== --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    ['label' => 'Licenças vigentes',    'valor' => $kpis['licencas_vigentes'], 'icone' => 'fa-file-shield',   'cor' => 'bg-emerald-600'],
                    ['label' => 'Aspectos significativos','valor' => $kpis['aspectos_signif'],  'icone' => 'fa-leaf',          'cor' => 'bg-green-600'],
                    ['label' => 'Objetivos ativos',     'valor' => $kpis['objetivos_ativos'],  'icone' => 'fa-bullseye',      'cor' => 'bg-teal-600'],
                    ['label' => 'NCs abertas',          'valor' => $kpis['nc_abertas'],        'icone' => 'fa-triangle-exclamation', 'cor' => 'bg-amber-600'],
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
                    'licencas_vencidas'        => ['label' => 'Licenças vencidas',       'cor' => 'red',   'rota' => route('licencas_ambientais.index')],
                    'licencas_30dias'          => ['label' => 'Licenças vencendo 30d',   'cor' => 'red',   'rota' => route('licencas_ambientais.index')],
                    'licencas_60dias'          => ['label' => 'Licenças vencendo 60d',   'cor' => 'amber', 'rota' => route('licencas_ambientais.index')],
                    'objetivos_atrasados'      => ['label' => 'Objetivos atrasados',     'cor' => 'red',   'rota' => route('objetivos_ambientais.index')],
                    'nc_alta_gravidade'        => ['label' => 'NCs Alta/Crítica',        'cor' => 'red',   'rota' => route('nao_conformidades_ambientais.index')],
                    //'monitoramentos_atrasados' => ['label' => 'Monit. atrasados',        'cor' => 'amber', 'rota' => route('monitoramentos_ambientais.index')],
                    'quimicos_vencidos'        => ['label' => 'Químicos vencidos',       'cor' => 'amber', 'rota' => route('produtos_quimicos.index')],
                    'registros_em_revisao'     => ['label' => 'Registros em revisão',    'cor' => 'blue',  'rota' => route('registros_legais.index')],
                ];
                $cores = [
                    'red'   => 'border-red-400 bg-red-50 text-red-700',
                    'amber' => 'border-amber-400 bg-amber-50 text-amber-700',
                    'blue'  => 'border-blue-400 bg-blue-50 text-blue-700',
                ];
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3">
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
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Monitoramentos Ambientais (12 meses)</h3>
                    <canvas id="chartMonitoramentos" height="110"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Licenças por Status</h3>
                    <canvas id="chartLicencasStatus" height="140"></canvas>
                </div>
            </div>

            {{-- ===== GRÁFICOS LINHA 2 ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Resíduos por Classe (NBR 10.004)</h3>
                    <canvas id="chartResiduosClasse" height="140"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Resíduos por Destino Final</h3>
                    <canvas id="chartResiduosDestino" height="140"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">NCs Ambientais por Origem</h3>
                    <canvas id="chartNcOrigem" height="140"></canvas>
                </div>
            </div>

            {{-- ===== GRÁFICOS LINHA 3 ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Aspectos Ambientais por Significância</h3>
                    <canvas id="chartAspectosSig" height="120"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Objetivos em Risco / Atraso</h3>
                    @forelse($objetivosEmRisco as $obj)
                        <div class="mb-2">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span class="font-medium truncate">{{ $obj->codigo }} — {{ $obj->titulo }}</span>
                                <span>{{ $obj->progresso }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="h-2 rounded-full
                                    {{ $obj->progresso >= 75 ? 'bg-emerald-500' : ($obj->progresso >= 40 ? 'bg-amber-500' : 'bg-red-500') }}"
                                    style="width: {{ $obj->progresso }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhum objetivo em risco. 🎉</p>
                    @endforelse
                </div>
            </div>

            {{-- ===== LISTAS ACIONÁVEIS ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                {{-- Próximas licenças --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">📄 Licenças a vencer (90 dias)</h3>
                    @forelse($proximasLicencas as $lic)
                        @php
                            $dias = (int) now()->diffInDays($lic->data_validade, false);
                            $cor  = $dias <= 30 ? 'text-red-600' : ($dias <= 60 ? 'text-amber-600' : 'text-gray-500');
                        @endphp
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium">{{ $lic->tipo }} — {{ $lic->numero }}</p>
                                <p class="text-xs text-gray-500">{{ $lic->orgao_emissor }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-semibold {{ $cor }}">
                                    {{ \Carbon\Carbon::parse($lic->data_validade)->format('d/m/Y') }}
                                </p>
                                <p class="text-[11px] text-gray-400">{{ $dias }} dias</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhuma licença a vencer nos próximos 90 dias.</p>
                    @endforelse
                </div>

                {{-- NCs críticas --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">🚨 Não Conformidades Críticas</h3>
                    @forelse($ncCriticas as $nc)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium">{{ $nc->codigo }} — {{ $nc->titulo }}</p>
                                <p class="text-xs text-gray-500">
                                    Prazo: {{ $nc->prazo_tratamento ? \Carbon\Carbon::parse($nc->prazo_tratamento)->format('d/m/Y') : '—' }}
                                </p>
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full
                                {{ $nc->gravidade === 'Crítica' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $nc->gravidade }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhuma NC crítica aberta. 🎉</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const palette = ['#10b981','#0ea5e9','#f59e0b','#ef4444','#6366f1','#14b8a6','#94a3b8','#f43f5e'];

        // Monitoramentos ambientais
        const mData   = @json($monitoramentosMes->pluck('total', 'mes'));
        const mLabels = Object.keys(mData);
        const mAtras  = @json($monitoramentosMes->pluck('atrasados', 'mes'));

        new Chart(document.getElementById('chartMonitoramentos'), {
            type: 'line',
            data: {
                labels: mLabels,
                datasets: [
                    { label: 'Total',     data: Object.values(mData),
                      borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,.15)', tension: .3, fill: true },
                    { label: 'Atrasados', data: mLabels.map(m => mAtras[m] || 0),
                      borderColor: '#ef4444', backgroundColor: 'rgba(239,68,68,.15)', tension: .3, fill: true }
                ]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        // Licenças por status
        const licStatus = @json($licencasPorStatus);
        new Chart(document.getElementById('chartLicencasStatus'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(licStatus),
                datasets: [{ data: Object.values(licStatus), backgroundColor: palette }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        // Resíduos por classe
        const resClasse = @json($residuosPorClasse);
        new Chart(document.getElementById('chartResiduosClasse'), {
            type: 'bar',
            data: {
                labels: Object.keys(resClasse),
                datasets: [{ data: Object.values(resClasse),
                    backgroundColor: ['#ef4444','#f59e0b','#10b981','#0ea5e9'] }]
            },
            options: { plugins: { legend: { display: false } },
                       scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });

        // Resíduos por destino
        const resDestino = @json($residuosPorDestino);
        new Chart(document.getElementById('chartResiduosDestino'), {
            type: 'bar',
            data: {
                labels: Object.keys(resDestino),
                datasets: [{ data: Object.values(resDestino), backgroundColor: '#14b8a6' }]
            },
            options: { indexAxis: 'y',
                       plugins: { legend: { display: false } },
                       scales: { x: { beginAtZero: true, ticks: { precision: 0 } } } }
        });

        // NCs por origem
        const ncOrigem = @json($ncPorOrigem);
        new Chart(document.getElementById('chartNcOrigem'), {
            type: 'bar',
            data: {
                labels: Object.keys(ncOrigem),
                datasets: [{ data: Object.values(ncOrigem), backgroundColor: '#6366f1' }]
            },
            options: { plugins: { legend: { display: false } },
                       scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });

        // Aspectos por significância
        const aspSig = @json($aspectosSignificancia);
        const sigLabels = Object.keys(aspSig).map(s => 'Nível ' + s);
        const sigCores  = Object.keys(aspSig).map(s => s >= 4 ? '#ef4444' : (s == 3 ? '#f59e0b' : '#10b981'));
        new Chart(document.getElementById('chartAspectosSig'), {
            type: 'bar',
            data: { labels: sigLabels,
                    datasets: [{ data: Object.values(aspSig), backgroundColor: sigCores }] },
            options: { plugins: { legend: { display: false } },
                       scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });
    </script>
</x-app-layout>