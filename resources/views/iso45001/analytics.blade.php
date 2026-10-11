<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Painel ISO 45001 — Segurança e Saúde no Trabalho') }}
            </h2>
            <a href="{{ route('dashboard') }}"
               class="text-sm text-orange-700 hover:underline">← Voltar aos módulos</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===== DESTAQUE: Dias sem acidente ===== --}}
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-xl shadow-md p-6 text-white flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-wide opacity-90">Dias sem acidente com afastamento</p>
                    <p class="text-5xl font-bold">
                        {{ $diasSemAcidente ?? '—' }}
                    </p>
                    @if($ultimoAcidente)
                        <p class="text-xs opacity-90 mt-1">
                            Último evento: {{ \Carbon\Carbon::parse($ultimoAcidente->data_ocorrencia)->format('d/m/Y') }}
                            — {{ $ultimoAcidente->tipo }}
                        </p>
                    @else
                        <p class="text-xs opacity-90 mt-1">Nenhum acidente registrado 🎉</p>
                    @endif
                </div>
                <i class="fas fa-helmet-safety text-6xl opacity-30"></i>
            </div>

            {{-- ===== KPIs ===== --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    ['label' => 'Perigos ativos',    'valor' => $kpis['perigos_ativos'],      'icone' => 'fa-triangle-exclamation', 'cor' => 'bg-orange-600'],
                    ['label' => 'Alto risco (≥15)',  'valor' => $kpis['perigos_alto_risco'],  'icone' => 'fa-fire',                 'cor' => 'bg-red-600'],
                    ['label' => 'Incidentes no ano', 'valor' => $kpis['incidentes_ano'],      'icone' => 'fa-bolt',                 'cor' => 'bg-amber-600'],
                    ['label' => 'Dias perdidos (ano)','valor' => $kpis['dias_perdidos_ano'],  'icone' => 'fa-calendar-xmark',       'cor' => 'bg-rose-600'],
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
                    'incidentes_abertos'    => ['label' => 'Incidentes abertos',      'cor' => 'red',   'rota' => route('incidentes_acidentes.index')],
                    'perigos_sem_controle'  => ['label' => 'Perigos sem controle',    'cor' => 'red',   'rota' => route('perigos_riscos.index')],
                    'epis_estoque_baixo'    => ['label' => 'EPIs estoque baixo',      'cor' => 'amber', 'rota' => route('epis.index')],
                    'epis_vencidos'         => ['label' => 'EPIs vencidos',           'cor' => 'red',   'rota' => route('epis_usuarios.index')],
                    'epis_vencendo_30d'     => ['label' => 'EPIs vencendo 30d',       'cor' => 'amber', 'rota' => route('epis_usuarios.index')],
                    'aso_vencidos'          => ['label' => 'ASOs vencidos',           'cor' => 'red',   'rota' => route('exames_medicos.index')],
                    'aso_vencendo_60d'      => ['label' => 'ASOs vencendo 60d',       'cor' => 'amber', 'rota' => route('exames_medicos.index')],
                    'cipa_pendentes'        => ['label' => 'Reuniões CIPA atrasadas', 'cor' => 'amber', 'rota' => route('cipa_reunioes.index')],
                ];
                $cores = [
                    'red'   => 'border-red-400 bg-red-50 text-red-700',
                    'amber' => 'border-amber-400 bg-amber-50 text-amber-700',
                ];
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3">
                @foreach($alertasConfig as $key => $cfg)
                    @php
                        $valor = $alertas[$key] ?? 0;
                        $destacar = $valor > 0;
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
                    <h3 class="font-semibold text-gray-700 mb-3">Incidentes e Dias Perdidos (12 meses)</h3>
                    <canvas id="chartIncidentesMes" height="110"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Incidentes por Tipo</h3>
                    <canvas id="chartIncidentesTipo" height="140"></canvas>
                </div>
            </div>

            {{-- ===== GRÁFICOS LINHA 2 ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-1">Matriz de Risco (Probabilidade × Severidade)</h3>
                    <p class="text-xs text-gray-400 mb-3">Tamanho da bolha = quantidade de perigos</p>
                    <canvas id="chartMatriz" height="160"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Perigos por Nível de Risco</h3>
                    <canvas id="chartPerigosNivel" height="160"></canvas>
                </div>
            </div>

            {{-- ===== GRÁFICOS LINHA 3 ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">ASOs Vigentes por Tipo</h3>
                    <canvas id="chartAsos" height="140"></canvas>
                </div>
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">Reuniões CIPA (ano corrente)</h3>
                    <canvas id="chartCipa" height="140"></canvas>
                </div>
            </div>

            {{-- ===== LISTAS ACIONÁVEIS ===== --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                {{-- Incidentes recentes --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">🩹 Incidentes Recentes</h3>
                    @forelse($incidentesRecentes as $inc)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium">{{ $inc->tipo }} — {{ $inc->usuario->name ?? 'Não identificado' }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($inc->data_ocorrencia)->format('d/m/Y') }}
                                    @if($inc->local) · {{ $inc->local }} @endif
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

                {{-- Perigos críticos --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">🚨 Perigos de Alto Risco</h3>
                    @forelse($perigosCriticos as $p)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium truncate">{{ $p->descricao_perigo }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $p->risco_associado }}</p>
                            </div>
                            <span class="px-2 py-0.5 text-xs rounded-full font-semibold
                                {{ $p->nivel_risco >= 20 ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700' }}">
                                R$ {{ $p->nivel_risco }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhum perigo de alto risco. 🎉</p>
                    @endforelse
                </div>

                {{-- Próximos ASOs --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">🩺 Próximos ASOs (60 dias)</h3>
                    @forelse($proximosAsos as $aso)
                        @php
                            $dias = (int) now()->diffInDays($aso->data_vencimento, false);
                            $cor  = $dias <= 30 ? 'text-red-600' : 'text-amber-600';
                        @endphp
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <div>
                                <p class="text-sm font-medium">{{ $aso->usuario->name ?? '—' }}</p>
                                <p class="text-xs text-gray-500">{{ $aso->tipo_aso }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-semibold {{ $cor }}">
                                    {{ \Carbon\Carbon::parse($aso->data_vencimento)->format('d/m/Y') }}
                                </p>
                                <p class="text-[11px] text-gray-400">{{ $dias }} dias</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Nenhum ASO a vencer nos próximos 60 dias.</p>
                    @endforelse
                </div>

                {{-- EPIs em falta --}}
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3">📦 EPIs com Estoque Crítico</h3>
                    @forelse($episCriticos as $epi)
                        <div class="flex justify-between items-center py-2 border-b last:border-0">
                            <p class="text-sm font-medium truncate">{{ $epi->nome }}</p>
                            <div class="text-right text-xs">
                                <p class="font-semibold text-red-600">{{ $epi->estoque_atual }} un.</p>
                                <p class="text-gray-400">mín.: {{ $epi->estoque_minimo }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">Todos os EPIs com estoque adequado. 🎉</p>
                    @endforelse
                </div>
            </div>

            {{-- Próxima CIPA --}}
            @if($proximaCipa)
                <div class="bg-white rounded-xl shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-2">Próxima Reunião CIPA</h3>
                    <p class="text-sm text-gray-600">
                        <strong>{{ $proximaCipa->tipo }}</strong> —
                        {{ \Carbon\Carbon::parse($proximaCipa->data_reuniao)->format('d/m/Y') }}
                        · Gestão {{ $proximaCipa->gestao_ano }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">{{ $proximaCipa->pauta_principal }}</p>
                </div>
            @endif

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        const palette = ['#f97316','#ef4444','#f59e0b','#0ea5e9','#10b981','#6366f1','#14b8a6','#94a3b8'];

        // Incidentes por mês
        const incMes    = @json($incidentesMes->pluck('total', 'mes'));
        const incDias   = @json($incidentesMes->pluck('dias_perdidos', 'mes'));
        const incLabels = Object.keys(incMes);

        new Chart(document.getElementById('chartIncidentesMes'), {
            type: 'bar',
            data: {
                labels: incLabels,
                datasets: [
                    { type:'bar',  label:'Incidentes',    data: Object.values(incMes),  backgroundColor:'#f97316', yAxisID:'y' },
                    { type:'line', label:'Dias perdidos', data: incLabels.map(m => incDias[m] || 0),
                      borderColor:'#ef4444', backgroundColor:'rgba(239,68,68,.15)', tension:.3, fill:true, yAxisID:'y1' }
                ]
            },
            options: {
                plugins: { legend: { position: 'bottom' } },
                scales: {
                    y:  { beginAtZero: true, position:'left',  ticks:{ precision:0 }, title:{ display:true, text:'Incidentes' } },
                    y1: { beginAtZero: true, position:'right', grid:{ drawOnChartArea:false }, title:{ display:true, text:'Dias perdidos' } }
                }
            }
        });

        // Incidentes por tipo
        const incTipo = @json($incidentesPorTipo);
        new Chart(document.getElementById('chartIncidentesTipo'), {
            type: 'doughnut',
            data: { labels: Object.keys(incTipo),
                    datasets: [{ data: Object.values(incTipo), backgroundColor: palette }] },
            options: { plugins: { legend: { position: 'bottom' } } }
        });

        // Matriz de risco (scatter)
        const matriz = @json($matrizRisco);
        const pontos = matriz.map(m => ({
            x: m.probabilidade, y: m.severidade, r: Math.min(6 + m.total * 3, 22), total: m.total
        }));
        new Chart(document.getElementById('chartMatriz'), {
            type: 'bubble',
            data: {
                datasets: [{
                    label: 'Perigos',
                    data: pontos,
                    backgroundColor: ctx => {
                        const p = ctx.raw;
                        const nr = p.x * p.y;
                        return nr >= 15 ? 'rgba(239,68,68,.7)'
                             : nr >= 8  ? 'rgba(245,158,11,.7)'
                                        : 'rgba(16,185,129,.7)';
                    }
                }]
            },
            options: {
                plugins: { legend: { display: false },
                    tooltip: { callbacks: { label: c => `P=${c.raw.x} × S=${c.raw.y} = ${c.raw.x*c.raw.y} (${c.raw.total} perigos)` } } },
                scales: {
                    x: { min:.5, max:5.5, title:{ display:true, text:'Probabilidade' }, ticks:{ stepSize:1 } },
                    y: { min:.5, max:5.5, title:{ display:true, text:'Severidade' },   ticks:{ stepSize:1 } }
                }
            }
        });

        // Perigos por nível
        const perNivel = @json($perigosPorNivel);
        const perLabels = Object.keys(perNivel).map(n => 'NR ' + n);
        const perCores  = Object.keys(perNivel).map(n => n >= 15 ? '#ef4444' : (n >= 8 ? '#f59e0b' : '#10b981'));
        new Chart(document.getElementById('chartPerigosNivel'), {
            type: 'bar',
            data: { labels: perLabels, datasets: [{ data: Object.values(perNivel), backgroundColor: perCores }] },
            options: { plugins: { legend: { display: false } },
                       scales: { y: { beginAtZero: true, ticks: { precision: 0 } } } }
        });

        // ASOs por tipo
        const asos = @json($examesPorTipo);
        new Chart(document.getElementById('chartAsos'), {
            type: 'bar',
            data: { labels: Object.keys(asos),
                    datasets: [{ data: Object.values(asos), backgroundColor: '#0ea5e9' }] },
            options: { indexAxis:'y',
                       plugins: { legend: { display: false } },
                       scales: { x: { beginAtZero: true, ticks: { precision: 0 } } } }
        });

        // CIPA por status
        const cipa = @json($cipaPorStatus);
        new Chart(document.getElementById('chartCipa'), {
            type: 'doughnut',
            data: { labels: Object.keys(cipa),
                    datasets: [{ data: Object.values(cipa), backgroundColor: ['#10b981','#0ea5e9','#94a3b8'] }] },
            options: { plugins: { legend: { position: 'bottom' } } }
        });
    </script>
</x-app-layout>