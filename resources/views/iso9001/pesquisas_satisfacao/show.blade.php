<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-clipboard-list text-blue-500"></i>
                Detalhes: {{ $pesquisaSatisfacao->titulo }}
            </h2>
            <div class="space-x-4">
                <a href="{{ route('pesquisas_satisfacao.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('pesquisas_satisfacao.edit', $pesquisaSatisfacao) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    @php
        /* ============ Cálculo NPS ============ */
        $respostasCol = $pesquisaSatisfacao->respostas;
        $total = $respostasCol->count();

        $promotores = $respostasCol->where('classificacao', 'Promotor')->count();
        $neutros    = $respostasCol->where('classificacao', 'Neutro')->count();
        $detratores = $respostasCol->where('classificacao', 'Detrator')->count();

        $percProm = $total > 0 ? round(($promotores / $total) * 100, 1) : 0;
        $percNeut = $total > 0 ? round(($neutros    / $total) * 100, 1) : 0;
        $percDetr = $total > 0 ? round(($detratores / $total) * 100, 1) : 0;

        $nps = $total > 0 ? round($percProm - $percDetr, 1) : null;

        $npsCor = match(true) {
            $nps === null => ['bg-gray-50','text-gray-700','border-gray-200'],
            $nps >= 75    => ['bg-emerald-50','text-emerald-700','border-emerald-200'],
            $nps >= 50    => ['bg-green-50','text-green-700','border-green-200'],
            $nps >= 0     => ['bg-amber-50','text-amber-700','border-amber-200'],
            default       => ['bg-rose-50','text-rose-700','border-rose-200'],
        };
        $npsLabel = match(true) {
            $nps === null => 'Sem dados',
            $nps >= 75    => 'Excelente',
            $nps >= 50    => 'Muito Bom',
            $nps >= 0     => 'Razoável',
            default       => 'Crítico',
        };

        $notaMedia = $total > 0 ? round($respostasCol->avg('nota'), 2) : null;
    @endphp

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- ============ Widgets de Resumo ============ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- Card NPS --}}
            <div class="bg-white rounded-lg shadow-sm border {{ $npsCor[2] }} p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-500">NPS</span>
                    <i class="fas fa-chart-line {{ $npsCor[1] }}"></i>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold {{ $npsCor[1] }}">
                        {{ $nps === null ? '—' : number_format($nps, 1, ',', '.') }}
                    </span>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $npsCor[0] }} {{ $npsCor[1] }}">
                        {{ $npsLabel }}
                    </span>
                </div>
                <p class="text-xs text-gray-500 mt-1">% Promotores − % Detratores</p>
            </div>

            {{-- Card Nota Média --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-500">Nota média</span>
                    <i class="fas fa-star text-amber-500"></i>
                </div>
                <span class="text-3xl font-bold text-gray-900">
                    {{ $notaMedia !== null ? number_format($notaMedia, 2, ',', '.') : '—' }}
                </span>
                <p class="text-xs text-gray-500 mt-1">Escala 0–10</p>
            </div>

            {{-- Card Total --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-500">Total de respostas</span>
                    <i class="fas fa-comments text-blue-500"></i>
                </div>
                <span class="text-3xl font-bold text-gray-900">{{ $total }}</span>
                <p class="text-xs text-gray-500 mt-1">Respostas coletadas</p>
            </div>

            {{-- Card Composição --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-500">Composição</span>
                    <i class="fas fa-users text-indigo-500"></i>
                </div>
                <div class="space-y-1 text-xs">
                    <div class="flex justify-between">
                        <span class="text-emerald-700 font-medium">
                            <i class="fas fa-circle text-[8px] mr-1"></i>Promotores
                        </span>
                        <span class="font-semibold">{{ $promotores }} ({{ $percProm }}%)</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-amber-700 font-medium">
                            <i class="fas fa-circle text-[8px] mr-1"></i>Neutros
                        </span>
                        <span class="font-semibold">{{ $neutros }} ({{ $percNeut }}%)</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-rose-700 font-medium">
                            <i class="fas fa-circle text-[8px] mr-1"></i>Detratores
                        </span>
                        <span class="font-semibold">{{ $detratores }} ({{ $percDetr }}%)</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ Detalhes + Respostas ============ --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Coluna principal --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Card: Detalhes --}}
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-500"></i>Informações
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Código</span>
                            <span class="mt-1 text-lg font-semibold font-mono">{{ $pesquisaSatisfacao->codigo ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Tipo</span>
                            <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">
                                <i class="fas fa-tag mr-1"></i>{{ $pesquisaSatisfacao->tipo }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Cliente</span>
                            <span class="mt-1 text-base">{{ $pesquisaSatisfacao->cliente?->nome ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Responsável</span>
                            <span class="mt-1 text-base">{{ $pesquisaSatisfacao->responsavel?->name ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Canal</span>
                            <span class="mt-1 text-base">{{ $pesquisaSatisfacao->canal ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Status</span>
                            @php
                                $statusColors = [
                                    'Planejada'    => 'bg-gray-100 text-gray-800',
                                    'Em andamento' => 'bg-yellow-100 text-yellow-800',
                                    'Concluída'    => 'bg-green-100 text-green-800',
                                    'Cancelada'    => 'bg-red-100 text-red-800',
                                ];
                                $cor = $statusColors[$pesquisaSatisfacao->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $cor }}">
                                {{ $pesquisaSatisfacao->status }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Data de início</span>
                            <span class="mt-1 text-base">{{ $pesquisaSatisfacao->data_inicio?->format('d/m/Y') ?? '—' }}</span>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Data de encerramento</span>
                            <span class="mt-1 text-base">{{ $pesquisaSatisfacao->data_fim?->format('d/m/Y') ?? '—' }}</span>
                        </div>
                    </div>

                    @if($pesquisaSatisfacao->descricao)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <span class="block text-sm font-medium text-gray-500">Descrição</span>
                            <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $pesquisaSatisfacao->descricao }}</p>
                        </div>
                    @endif

                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                        <form action="{{ route('pesquisas_satisfacao.destroy', $pesquisaSatisfacao) }}" method="POST"
                              onsubmit="return confirm('Tem certeza que deseja excluir esta pesquisa?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                <i class="fas fa-trash mr-2"></i> Excluir
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Card: Respostas --}}
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b flex items-center justify-between flex-wrap gap-2">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2">
                            <i class="fas fa-comments text-blue-500"></i>
                            Respostas ({{ $total }})
                        </h3>
                        <div class="flex items-center gap-2">
                            {{-- Exportar CSV desta pesquisa --}}
                            <a href="{{ route('respostas_pesquisa.export', ['pesquisa_satisfacao_id' => $pesquisaSatisfacao->id]) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-md hover:bg-emerald-100 text-sm transition">
                                <i class="fas fa-file-csv mr-1.5"></i>Exportar CSV
                            </a>
                            {{-- Nova resposta pré-preenchida --}}
                            <a href="{{ route('pesquisas_satisfacao_respostas.create', ['pesquisa_satisfacao_id' => $pesquisaSatisfacao->id]) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm transition shadow-sm">
                                <i class="fas fa-plus mr-1.5"></i>Nova resposta
                            </a>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                        <i class="fas fa-user mr-1"></i>Respondente
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                        <i class="fas fa-user-tie mr-1"></i>Cliente
                                    </th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wide">
                                        <i class="fas fa-star mr-1"></i>Nota
                                    </th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wide">
                                        <i class="fas fa-flag mr-1"></i>Classificação
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                        <i class="fas fa-comment mr-1"></i>Comentário
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($pesquisaSatisfacao->respostas as $r)
                                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-indigo-50 transition duration-150">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $r->respondente?->name ?? '—' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $r->cliente?->nome ?? '—' }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-center font-semibold text-gray-900">
                                            {{ number_format($r->nota, 2, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            @if($r->classificacao)
                                                @php $cor = ['Promotor'=>'green','Neutro'=>'yellow','Detrator'=>'red'][$r->classificacao] ?? 'gray'; @endphp
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-{{ $cor }}-100 text-{{ $cor }}-800">
                                                    {{ $r->classificacao }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-600">
                                            {{ \Illuminate\Support\Str::limit($r->comentario, 80) ?: '—' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-10 text-center text-gray-500">
                                            <i class="fas fa-inbox text-3xl mb-2 block text-gray-300"></i>
                                            Nenhuma resposta registrada ainda.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Coluna lateral: Nova resposta --}}
            <div>
                <div class="bg-white p-6 rounded-lg shadow-sm sticky top-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-plus-circle text-blue-500"></i>Registrar resposta
                    </h3>

                    <form method="POST"
                          action="{{ route('pesquisas_satisfacao.respostas.store', $pesquisaSatisfacao) }}"
                          class="space-y-4">
                        @csrf

                        <div>
                            <label for="nota" class="block text-sm font-medium text-gray-700">
                                Nota (0–10) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-star text-gray-400"></i>
                                </div>
                                <input type="number" step="0.01" min="0" max="10" id="nota" name="nota" required
                                       class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>

                        <div>
                            <label for="comentario" class="block text-sm font-medium text-gray-700">Comentário</label>
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-start pointer-events-none">
                                    <i class="fas fa-comment-alt text-gray-400 mt-2"></i>
                                </div>
                                <textarea id="comentario" name="comentario" rows="4"
                                          class="pl-10 block w-full resize rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                            <i class="fas fa-save mr-2"></i>Salvar resposta
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>