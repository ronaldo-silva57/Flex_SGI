<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-chart-line text-indigo-500"></i>
                Dashboard SGI
            </h2>
            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                <i class="fas fa-arrow-left mr-2"></i>Voltar aos Módulos
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- KPIs --}}
        <section class="mb-6">
            <div class="mb-4 flex items-center gap-2">
                <i class="fas fa-gauge-high text-indigo-600"></i>
                <h2 class="text-base font-semibold text-gray-800">
                    Indicadores gerais
                </h2>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- NC Abertas --}}
                <div class="group rounded-xl border-l-4 border-red-500 bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                NC Abertas
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                {{ $kpis->nc_abertas ?? 0 }}
                            </p>
                            <p class="mt-1 text-xs text-gray-400">
                                Não conformidades pendentes
                            </p>
                        </div>
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600">
                            <i class="fas fa-triangle-exclamation"></i>
                        </div>
                    </div>
                </div>

                {{-- Ações Atrasadas --}}
                <div class="group rounded-xl border-l-4 border-amber-500 bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Ações Atrasadas
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                {{ $kpis->acoes_atrasadas ?? 0 }}
                            </p>
                            <p class="mt-1 text-xs text-gray-400">
                                Ações que exigem atenção
                            </p>
                        </div>
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>

                {{-- EPIs Vencidos --}}
                <div class="group rounded-xl border-l-4 border-red-500 bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                EPIs Vencidos
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                {{ $kpis->epis_vencidos ?? 0 }}
                            </p>
                            <p class="mt-1 text-xs text-gray-400">
                                Equipamentos fora da validade
                            </p>
                        </div>
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600">
                            <i class="fas fa-hard-hat"></i>
                        </div>
                    </div>
                </div>

                {{-- EPIs Vencendo --}}
                <div class="group rounded-xl border-l-4 border-amber-500 bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                EPIs Vencendo 30d
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                {{ $kpis->epis_vencendo_30d ?? 0 }}
                            </p>
                            <p class="mt-1 text-xs text-gray-400">
                                Próximos do vencimento
                            </p>
                        </div>
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                            <i class="fas fa-calendar-days"></i>
                        </div>
                    </div>
                </div>

                {{-- Treinamentos --}}
                <div class="group rounded-xl border-l-4 border-red-500 bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Treinamentos Vencidos
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                {{ $kpis->treinamentos_vencidos ?? 0 }}
                            </p>
                            <p class="mt-1 text-xs text-gray-400">
                                Capacitações pendentes
                            </p>
                        </div>
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                    </div>
                </div>

                {{-- Documentos --}}
                <div class="group rounded-xl border-l-4 border-amber-500 bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Docs. p/ Revisão
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                {{ $kpis->documentos_vencidos ?? 0 }}
                            </p>
                            <p class="mt-1 text-xs text-gray-400">
                                Documentos que precisam de revisão
                            </p>
                        </div>
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                            <i class="fas fa-file-circle-exclamation"></i>
                        </div>
                    </div>
                </div>

                {{-- Riscos --}}
                <div class="group rounded-xl border-l-4 border-red-500 bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Riscos Críticos
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                {{ $kpis->riscos_criticos ?? 0 }}
                            </p>
                            <p class="mt-1 text-xs text-gray-400">
                                Riscos de maior prioridade
                            </p>
                        </div>
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600">
                            <i class="fas fa-shield-halved"></i>
                        </div>
                    </div>
                </div>

                {{-- Auditorias --}}
                <div class="group rounded-xl border-l-4 border-emerald-500 bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Auditorias 30d
                            </p>
                            <p class="mt-2 text-3xl font-bold text-gray-800">
                                {{ $kpis->auditorias_30d ?? 0 }}
                            </p>
                            <p class="mt-1 text-xs text-gray-400">
                                Auditorias programadas
                            </p>
                        </div>
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- GRÁFICOS --}}
        <section class="mb-6">
            <div class="mb-4 flex items-center gap-2">
                <i class="fas fa-chart-pie text-indigo-600"></i>
                <h2 class="text-base font-semibold text-gray-800">
                    Análise dos indicadores
                </h2>
            </div>
            <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">
                {{-- 1. Vencimentos por Módulo --}}
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-semibold text-gray-800">
                            Vencimentos por Módulo
                        </h3>
                        <i class="fas fa-chart-column text-gray-400"></i>
                    </div>
                    <div class="relative h-72">
                        <canvas id="chartVencimentos"></canvas>
                    </div>
                </div>

                {{-- 2. NC por Gravidade --}}
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-semibold text-gray-800">
                            NC por Gravidade
                        </h3>
                        <i class="fas fa-chart-pie text-gray-400"></i>
                    </div>
                    <div class="relative h-72">
                        <canvas id="chartGravidade"></canvas>
                    </div>
                </div>

                {{-- 3. NC por Status --}}
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-semibold text-gray-800">
                            NC por Status
                        </h3>
                        <i class="fas fa-chart-bar text-gray-400"></i>
                    </div>
                    <div class="relative h-72">
                        <canvas id="chartNcStatus"></canvas>
                    </div>
                </div>

                {{-- 4. Ações Corretivas por Etapa --}}
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-semibold text-gray-800">
                            Ações Corretivas por Etapa
                        </h3>
                        <i class="fas fa-list-check text-gray-400"></i>
                    </div>
                    <div class="relative h-72">
                        <canvas id="chartAcoes"></canvas>
                    </div>
                </div>

                {{-- 5. Indicadores Meta x Realizado --}}
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-semibold text-gray-800">
                            Indicadores — Meta x Realizado
                        </h3>
                        <i class="fas fa-bullseye text-gray-400"></i>
                    </div>
                    <div class="relative h-72">
                        <canvas id="chartIndicadores"></canvas>
                    </div>
                </div>

                {{-- 6. Matriz de Risco --}}
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-semibold text-gray-800">
                            Matriz de Risco 5×5
                        </h3>
                        <i class="fas fa-table-cells text-gray-400"></i>
                    </div>
                    <div class="relative h-72">
                        <canvas id="chartMatriz"></canvas>
                    </div>
                </div>

                {{-- 7. Incidentes por Mês --}}
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-semibold text-gray-800">
                            Incidentes por Mês
                        </h3>
                        <i class="fas fa-chart-line text-gray-400"></i>
                    </div>
                    <div class="relative h-72">
                        <canvas id="chartIncidentes"></canvas>
                    </div>
                </div>

                {{-- 8. Auditorias por Status --}}
                <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <h3 class="text-base font-semibold text-gray-800">
                            Auditorias por Status
                        </h3>
                        <i class="fas fa-clipboard-check text-gray-400"></i>
                    </div>
                    <div class="relative h-72">
                        <canvas id="chartAuditorias"></canvas>
                    </div>
                </div>
            </div>
        </section>

        {{-- TABELA DE PRÓXIMOS VENCIMENTOS --}}
        <section class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">
            <div class="border-b border-gray-200 px-5 py-4">
                <div class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-800">
                            Próximos Vencimentos
                        </h2>
                        <p class="text-xs text-gray-500">
                            Itens com vencimento previsto para os próximos 30 dias
                        </p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Módulo
                            </th>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Item
                            </th>
                            <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Responsável
                            </th>
                            <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Vencimento
                            </th>
                            <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Dias
                            </th>
                            <th class="whitespace-nowrap px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($proximosVencimentos as $v)
                            <tr class="transition hover:bg-gray-50">
                                <td class="whitespace-nowrap px-5 py-3 font-medium text-gray-700">
                                    {{ $v->modulo }}
                                </td>
                                <td class="max-w-xs truncate px-5 py-3 text-gray-600" title="{{ $v->item }}">
                                    {{ $v->item }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-gray-600">
                                    {{ $v->responsavel }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-gray-600">
                                    {{ \Carbon\Carbon::parse($v->data_vencimento)->format('d/m/Y') }}
                                </td>
                                <td class="whitespace-nowrap px-5 py-3">
                                    @if($v->dias_restantes < 0)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                            <i class="fas fa-circle-exclamation"></i>
                                            {{ $v->dias_restantes }}d
                                        </span>
                                    @elseif($v->dias_restantes <= 7)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                                            <i class="fas fa-clock"></i>
                                            {{ $v->dias_restantes }}d
                                        </span>
                                    @elseif($v->dias_restantes <= 30)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">
                                            <i class="fas fa-clock"></i>
                                            {{ $v->dias_restantes }}d
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                            <i class="fas fa-check"></i>
                                            {{ $v->dias_restantes }}d
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-5 py-3 text-gray-600">
                                    {{ $v->status }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-sm text-gray-500">
                                    <i class="fas fa-calendar-xmark mb-2 block text-2xl text-gray-300"></i>
                                    Nenhum vencimento próximo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- RODAPÉ --}}
        <footer class="mt-6 pb-2 text-center text-xs text-gray-400">
            Sistema de Gestão Integrado — Dashboard
        </footer>

    </div>


    {{-- ============================================================
         SCRIPTS (Chart.js + dados + inicialização)
         O layout tem @stack('scripts') antes de </body>, então
         tudo aqui vai parar no lugar certo.
    ============================================================ --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

        <script>
            const DADOS = {
                vencimentos: @json($vencimentos),
                ncGravidade: @json($ncGravidade),
                ncStatus:    @json($ncStatus),
                acoes:       @json($acoes),
                indicadores: @json($indicadores),
                matriz:      @json($matrizRisco),
                incidentes:  @json($incidentes),
                auditorias:  @json($auditorias),
            };

            const FAIXAS = @json(\App\Http\Controllers\DashboardController::FAIXAS);

            const CORES = {
                azul:    '#3498db',
                verde:   '#27ae60',
                amarelo: '#f39c12',
                vermelho:'#e74c3c',
                roxo:    '#9b59b6',
                cinza:   '#95a5a6',
                laranja: '#e67e22',
                teal:    '#1abc9c',
            };

            Chart.defaults.font.family = "'Segoe UI', Roboto, sans-serif";
            Chart.defaults.font.size = 12;
            Chart.defaults.color = '#64748b';
        </script>

        <script>
            // -------- 1. Vencimentos por Módulo (barras empilhadas) --------
            (function () {
                const raw = DADOS.vencimentos;
                const modulos = [...new Set(raw.map(r => r.modulo))];

                const cores = [
                    CORES.vermelho,
                    CORES.laranja,
                    CORES.amarelo,
                    CORES.azul,
                    CORES.verde
                ];

                const datasets = FAIXAS.map((f, i) => ({
                    label: f,
                    data: modulos.map(m => {
                        const item = raw.find(r => r.modulo === m && r.faixa === f);
                        return item ? Number(item.total) : 0;
                    }),
                    backgroundColor: cores[i],
                    borderWidth: 0,
                }));

                new Chart(document.getElementById('chartVencimentos'), {
                    type: 'bar',
                    data: { labels: modulos, datasets },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { stacked: true, grid: { display: false } },
                            y: { stacked: true, beginAtZero: true }
                        },
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            })();

            // -------- 2. NC por Gravidade (doughnut) --------
            (function () {
                const raw = DADOS.ncGravidade;
                const mapa = {
                    'Baixa': CORES.verde,
                    'Media': CORES.amarelo,
                    'Alta': CORES.laranja,
                    'Crítica': CORES.vermelho
                };

                new Chart(document.getElementById('chartGravidade'), {
                    type: 'doughnut',
                    data: {
                        labels: raw.map(r => r.gravidade ?? '—'),
                        datasets: [{
                            data: raw.map(r => Number(r.total)),
                            backgroundColor: raw.map(r => mapa[r.gravidade] ?? CORES.cinza),
                            borderWidth: 2,
                            borderColor: '#ffffff',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            })();

            // -------- 3. NC por Status (barras horizontais) --------
            (function () {
                const raw = DADOS.ncStatus;
                new Chart(document.getElementById('chartNcStatus'), {
                    type: 'bar',
                    data: {
                        labels: raw.map(r => r.status),
                        datasets: [{
                            label: 'Quantidade',
                            data: raw.map(r => Number(r.total)),
                            backgroundColor: CORES.azul,
                            borderRadius: 5,
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { beginAtZero: true },
                            y: { grid: { display: false } }
                        }
                    }
                });
            })();

            // -------- 4. Ações Corretivas por Etapa --------
            (function () {
                const raw = DADOS.acoes;
                const etapas = [...new Set(raw.map(r => r.etapa))];
                const statusList = [...new Set(raw.map(r => r.status))];
                const coresStatus = {
                    'Pendente': CORES.cinza,
                    'Em andamento': CORES.amarelo,
                    'Concluída': CORES.verde,
                    'Reprovada': CORES.vermelho,
                };

                const datasets = statusList.map(s => ({
                    label: s,
                    data: etapas.map(e => {
                        const item = raw.find(r => r.etapa === e && r.status === s);
                        return item ? Number(item.total) : 0;
                    }),
                    backgroundColor: coresStatus[s] ?? CORES.azul,
                    borderWidth: 0,
                }));

                new Chart(document.getElementById('chartAcoes'), {
                    type: 'bar',
                    data: { labels: etapas, datasets },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { stacked: true, grid: { display: false } },
                            y: { stacked: true, beginAtZero: true }
                        },
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            })();

            // -------- 5. Indicadores Meta x Realizado --------
            (function () {
                const raw = DADOS.indicadores;
                new Chart(document.getElementById('chartIndicadores'), {
                    type: 'bar',
                    data: {
                        labels: raw.map(r => r.codigo + ' (' + (r.periodo_referencia ?? '') + ')'),
                        datasets: [
                            {
                                label: 'Realizado',
                                data: raw.map(r => Number(r.valor_realizado)),
                                backgroundColor: CORES.azul,
                                borderRadius: 5,
                                borderWidth: 0,
                            },
                            {
                                label: 'Meta',
                                data: raw.map(r => Number(r.meta)),
                                backgroundColor: CORES.verde,
                                borderRadius: 5,
                                borderWidth: 0,
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom' } },
                        scales: {
                            y: { beginAtZero: true },
                            x: { grid: { display: false } }
                        }
                    }
                });
            })();

            // -------- 6. Matriz de Risco (bubble) --------
            (function () {
                const raw = DADOS.matriz;
                const pontos = raw.map(r => ({
                    x: Number(r.probabilidade),
                    y: Number(r.impacto),
                    r: Math.max(4, Number(r.total) * 4),
                }));

                new Chart(document.getElementById('chartMatriz'), {
                    type: 'bubble',
                    data: {
                        datasets: [{
                            label: 'Riscos',
                            data: pontos,
                            backgroundColor: pontos.map(p => {
                                const nivel = p.x * p.y;
                                if (nivel >= 15) return 'rgba(231,76,60,.7)';
                                if (nivel >= 8)  return 'rgba(243,156,18,.7)';
                                return 'rgba(39,174,96,.7)';
                            }),
                            borderColor: pontos.map(p => {
                                const nivel = p.x * p.y;
                                if (nivel >= 15) return CORES.vermelho;
                                if (nivel >= 8)  return CORES.amarelo;
                                return CORES.verde;
                            }),
                            borderWidth: 1,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { min: 0, max: 6, title: { display: true, text: 'Probabilidade' } },
                            y: { min: 0, max: 6, title: { display: true, text: 'Impacto' } }
                        }
                    }
                });
            })();

            // -------- 7. Incidentes por Mês (linha) --------
            (function () {
                const raw = DADOS.incidentes;
                new Chart(document.getElementById('chartIncidentes'), {
                    type: 'line',
                    data: {
                        labels: raw.map(r => r.mes),
                        datasets: [
                            {
                                label: 'Incidentes',
                                data: raw.map(r => Number(r.total)),
                                borderColor: CORES.vermelho,
                                backgroundColor: 'rgba(231,76,60,.15)',
                                tension: .35,
                                fill: true,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                            },
                            {
                                label: 'Dias Perdidos',
                                data: raw.map(r => Number(r.dias_perdidos)),
                                borderColor: CORES.amarelo,
                                backgroundColor: 'rgba(243,156,18,.15)',
                                tension: .35,
                                fill: true,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                            },
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom' } },
                        scales: {
                            y: { beginAtZero: true },
                            x: { grid: { display: false } }
                        }
                    }
                });
            })();

            // -------- 8. Auditorias por Status (pie) --------
            (function () {
                const raw = DADOS.auditorias;
                const mapa = {
                    'Planejada': CORES.azul,
                    'Em andamento': CORES.amarelo,
                    'Concluída': CORES.verde,
                    'Cancelada': CORES.vermelho,
                };

                new Chart(document.getElementById('chartAuditorias'), {
                    type: 'pie',
                    data: {
                        labels: raw.map(r => r.status),
                        datasets: [{
                            data: raw.map(r => Number(r.total)),
                            backgroundColor: raw.map(r => mapa[r.status] ?? CORES.cinza),
                            borderWidth: 2,
                            borderColor: '#ffffff',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            })();
        </script>
    @endpush
</x-app-layout>