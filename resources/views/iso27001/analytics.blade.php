<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Painel ISO 27001 — Segurança da Informação') }}
            </h2>
            <a href="{{ route('dashboard') }}"
               class="text-sm text-indigo-700 hover:underline">← Voltar aos módulos</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===== DESTAQUE: SoA ===== --}}
            <div class="bg-gradient-to-r from-indigo-700 to-blue-600 rounded-xl shadow-md p-6 text-white">
                <div class="flex flex-wrap items-center justify-between gap-6">
                    <div>
                        <p class="text-sm uppercase tracking-wide opacity-90">Statement of Applicability (SoA)</p>
                        <p class="text-5xl font-bold">{{ $kpis['soa_pct'] }}%</p>
                        <p class="text-xs opacity-90 mt-1">
                            {{ $soaImpl }} de {{ $soaAplicaveis }} controles aplicáveis implementados
                            · {{ $soaEmImpl }} em implementação
                        </p>
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="w-full bg-white/20 rounded-full h-3">
                            <div class="bg-white h-3 rounded-full transition-all"
                                 style="width: {{ $kpis['soa_pct'] }}%"></div>
                        </div>
                        <div class="flex justify-between text-[11px] opacity-90 mt-1">
                            <span>0%</span><span>Meta: 100%</span>
                        </div>
                    </div>
                    <i class="fas fa-shield-halved text-6xl opacity-20"></i>
                </div>
            </div>

            {{-- ===== KPIs ===== --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    ['label' => 'Ativos ativos',    'valor' => $kpis['ativos_ativos'],  'icone' => 'fa-server',       'cor' => 'bg-indigo-600'],
                    ['label' => 'Ativos confid./restritos', 'valor' => $kpis['ativos_confid'], 'icone' => 'fa-lock',   'cor' => 'bg-blue-600'],
                    ['label' => 'Riscos abertos',   'valor' => $kpis['riscos_abertos'], 'icone' => 'fa-radiation',    'cor' => 'bg-purple-600'],
                    ['label' => 'Riscos críticos (resid. ≥15)', 'valor' => $kpis['riscos_criticos'], 'icone' => 'fa-fire', 'cor' => 'bg-red-600'],
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
                    'incidentes_abertos'      => ['label' => 'Incidentes abertos',       'cor' => 'red',   'rota' => route('incidentes_seguranca.index')],
                    'incidentes_ano'          => ['label' => 'Incidentes no ano',         'cor' => 'blue',  'rota' => route('incidentes_seguranca.index')],
                    'riscos_sem_tratamento'   => ['label' => 'Riscos sem plano',          'cor' => 'red',   'rota' => route('analises_risco_ti.index')],
                    'riscos_residual_alto'    => ['label' => 'Riscos residual alto',      'cor' => 'red',   'rota' => route('analises_risco_ti.index')],
                    'soa_nao_iniciado'        => ['label' => 'Controles não iniciados',   'cor' => 'amber', 'rota' => route('soa_controles.index')],
                    'controles_sem_evidencia' => ['label' => 'Controles sem evidência',   'cor' => 'amber', 'rota' => route('soa_controles.index')],
                    'ativos_sem_responsavel'  => ['label' => 'Ativos sem responsável',    'cor' => 'amber', 'rota' => route('ativos_informacao.index')],
                    'ativos_sem_classificacao'=> ['label' => 'Ativos sem classificação',  'cor' => 'amber', 'rota' => route('ativos_informacao.index')],
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

            {{-- ===== GRÁFICOS LINHA 1: SoA ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Implementação do SoA por Domínio (Anexo A)</h3>
                    <canvas id="chartSoaDominio" height="130"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Distribuição Geral dos Controles</h3>
                    <canvas id="chartSoaGeral" height="140"></canvas>
                </div>
            </div>

            {{-- ===== GRÁFICOS LINHA 2: Risco ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-1">Risco Inerente × Residual</h3>
                    <p class="text-xs text-gray-400 mb-3">◯ inerente · ● residual · linha = mesmo risco</p>
                    <canvas id="chartMatrizRisco" height="180"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Tríade CIA — Riscos que Afetam Cada Pilar</h3>
                    <canvas id="chartCia" height="180"></canvas>
                </div>
            </div>

            {{-- ===== GRÁFICOS LINHA 3: Ativos ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Ativos por Tipo</h3>
                    <canvas id="chartAtivosTipo" height="140"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Ativos por Classificação</h3>
                    <canvas id="chartAtivosClass" height="140"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Incidentes por Tipo (12 meses)</h3>
                    <canvas id="chartIncidentesTipo" height="140"></canvas>
                </div>
            </div>

            {{-- ===== GRÁFICO: Incidentes por mês ===== --}}
            <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="font-semibold text-gray-700 mb-3">Incidentes de Segurança (12 meses)</h3>
                <canvas id="chartIncidentesMes" height="100"></canvas>
            </div>

            {{-- ===== LISTAS ACIONÁVEIS ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                {{-- Incidentes recentes --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">🔐 Incidentes Recentes</h3>
                    @forelse($incidentesRecentes as $inc)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium">{{ $inc->tipo }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($inc->data_ocorrencia)->format('d/m/Y') }}
                                    · Ativo: {{ $inc->ativo->nome ?? '—' }}
                                </p>
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full
                                {{ $inc->status === 'Concluído' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $inc->status }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhum incidente registrado. 🎉</p>
                    @endforelse
                </div>

                {{-- Riscos críticos --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">🚨 Riscos Prioritários</h3>
                    @forelse($riscosCriticos as $r)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div class="truncate mr-2">
                                <p class="text-sm font-medium truncate">{{ $r->ameaca }}</p>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ $r->ativo->nome ?? '—' }} · {{ $r->opcao_tratamento }}
                                </p>
                            </div>
                            <div class="text-right whitespace-nowrap">
                                <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-500 line-through">
                                    {{ $r->nivel_risco_inerente }}
                                </span>
                                <span class="px-2 py-0.5 text-xs rounded-full font-semibold ml-1
                                    {{ $r->nivel_risco_residual >= 15 ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $r->nivel_risco_residual }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhum risco prioritário. 🎉</p>
                    @endforelse
                </div>

                {{-- Domínios pendentes --}}
                <div class="bg-white rounded-xl shadow-sm p-5 lg:col-span-2">
                    <h3 class="font-semibold text-gray-700 mb-3">📋 Domínios com Mais Controles Pendentes</h3>
                    @forelse($dominiosPendentes as $d)
                        <div class="mb-2">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span class="font-medium">{{ $d->dominio }}</span>
                                <span>{{ $d->em_impl + $d->nao_ini }} de {{ $d->total }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2 flex overflow-hidden">
                                <div class="bg-emerald-500 h-2"
                                     style="width: {{ $d->total ? (($d->total - $d->em_impl - $d->nao_ini) / $d->total) * 100 : 0 }}%"></div>
                                <div class="bg-amber-400 h-2"
                                     style="width: {{ $d->total ? ($d->em_impl / $d->total) * 100 : 0 }}%"></div>
                                <div class="bg-red-400 h-2"
                                     style="width: {{ $d->total ? ($d->nao_ini / $d->total) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Todos os domínios implementados. 🎉</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const palette = ['#6366f1','#3b82f6','#8b5cf6','#0ea5e9','#14b8a6','#f59e0b','#ef4444','#94a3b8'];

        // SoA por domínio (barra empilhada horizontal)
        const soaDom = @json($soaPorDominio);
        new Chart(document.getElementById('chartSoaDominio'), {
            type: 'bar',
            data: {
                labels: soaDom.map(d => d.dominio),
                datasets: [
                    { label:'Implementado',   data: soaDom.map(d => d.implementado),  backgroundColor:'#10b981' },
                    { label:'Em implementação', data: soaDom.map(d => d.em_impl),      backgroundColor:'#f59e0b' },
                    { label:'Não iniciado',    data: soaDom.map(d => d.nao_iniciado), backgroundColor:'#ef4444' }
                ]
            },
            options: {
                indexAxis: 'y',
                scales: { x: { stacked:true, beginAtZero:true, ticks:{ precision:0 } },
                          y: { stacked:true } },
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // SoA geral
        new Chart(document.getElementById('chartSoaGeral'), {
            type: 'doughnut',
            data: {
                labels: ['Implementado', 'Em implementação', 'Não iniciado', 'Não aplicável'],
                datasets: [{
                    data: [
                        {{ $soaImpl }},
                        {{ $soaEmImpl }},
                        {{ $alertas['soa_nao_iniciado'] }},
                        {{ $soaTotal - $soaAplicaveis }}
                    ],
                    backgroundColor: ['#10b981','#f59e0b','#ef4444','#94a3b8']
                }]
            },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        // Matriz risco inerente × residual
        const matriz = @json($matrizRisco);
        const inerentes = matriz.map(r => ({ x:r.probabilidade, y:r.impacto }));
        const residuais = matriz.map(r => ({ x:r.probabilidade_residual, y:r.impacto_residual }));

        new Chart(document.getElementById('chartMatrizRisco'), {
            type: 'scatter',
            data: {
                datasets: [
                    { label:'Inerente', data: inerentes,
                      backgroundColor:'rgba(99,102,241,.35)',
                      borderColor:'#6366f1', pointRadius:7, pointStyle:'circle' },
                    { label:'Residual', data: residuais,
                      backgroundColor:'rgba(16,185,129,.85)',
                      borderColor:'#10b981', pointRadius:8, pointStyle:'triangle' }
                ]
            },
            options: {
                plugins: { legend: { position:'bottom' } },
                scales: {
                    x: { min:.5, max:5.5, title:{ display:true, text:'Probabilidade' }, ticks:{ stepSize:1 } },
                    y: { min:.5, max:5.5, title:{ display:true, text:'Impacto' },       ticks:{ stepSize:1 } }
                }
            }
        });

        // CIA
        const cia = @json($triaCia);
        new Chart(document.getElementById('chartCia'), {
            type: 'bar',
            data: {
                labels: ['Confidencialidade', 'Integridade', 'Disponibilidade'],
                datasets: [{
                    data: [cia.confidencialidade, cia.integridade, cia.disponibilidade],
                    backgroundColor: ['#6366f1','#0ea5e9','#14b8a6']
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero:true, ticks:{ precision:0 } } }
            }
        });

        // Ativos por tipo
        const atTipo = @json($ativosPorTipo);
        new Chart(document.getElementById('chartAtivosTipo'), {
            type: 'doughnut',
            data: { labels: Object.keys(atTipo),
                    datasets: [{ data: Object.values(atTipo), backgroundColor: palette }] },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        // Ativos por classificação
        const atClass = @json($ativosPorClassificacao);
        const classOrder = ['Público','Interno','Confidencial','Restrito'];
        const classColors = { 'Público':'#10b981', 'Interno':'#0ea5e9', 'Confidencial':'#f59e0b', 'Restrito':'#ef4444' };
        const classLabels = classOrder.filter(k => atClass[k]);
        new Chart(document.getElementById('chartAtivosClass'), {
            type: 'bar',
            data: {
                labels: classLabels,
                datasets: [{
                    data: classLabels.map(k => atClass[k]),
                    backgroundColor: classLabels.map(k => classColors[k])
                }]
            },
            options: {
                indexAxis: 'y',
                plugins: { legend: { display: false } },
                scales: { x: { beginAtZero:true, ticks:{ precision:0 } } }
            }
        });

        // Incidentes por tipo
        const incTipo = @json($incidentesPorTipo);
        new Chart(document.getElementById('chartIncidentesTipo'), {
            type: 'bar',
            data: { labels: Object.keys(incTipo),
                    datasets: [{ data: Object.values(incTipo), backgroundColor: '#8b5cf6' }] },
            options: { plugins: { legend: { display: false } },
                       scales: { y: { beginAtZero:true, ticks:{ precision:0 } } } }
        });

        // Incidentes por mês
        const incMes = @json($incidentesMes->pluck('total','mes'));
        new Chart(document.getElementById('chartIncidentesMes'), {
            type: 'line',
            data: {
                labels: Object.keys(incMes),
                datasets: [{
                    label: 'Incidentes', data: Object.values(incMes),
                    borderColor:'#6366f1', backgroundColor:'rgba(99,102,241,.15)',
                    tension:.3, fill:true
                }]
            },
            options: { plugins: { legend: { display:false } } }
        });
    </script>
</x-app-layout>