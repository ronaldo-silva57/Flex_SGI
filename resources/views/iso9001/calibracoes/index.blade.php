<h1>Em construção</h1><x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-ruler-combined text-blue-600"></i>
                ISO 9001 · 7.1.5 — Equipamentos de Medição
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('iso9001.dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('equipamentos_medicao.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Novo Equipamento
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

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 text-red-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('equipamentos_medicao.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[220px]">
                    <label for="busca" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="busca" id="busca" value="{{ request('busca') }}"
                               placeholder="Buscar por código, nome ou nº de série..."
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="min-w-[180px]">
                    <label for="filtro" class="sr-only">Calibração</label>
                    <select name="filtro" id="filtro" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todas as calibrações</option>
                        <option value="vencidos" @selected(request('filtro') === 'vencidos')>Calibração vencida</option>
                        <option value="30d" @selected(request('filtro') === '30d')>Vence em 30 dias</option>
                    </select>
                </div>

                <div class="min-w-[170px]">
                    <label for="status" class="sr-only">Status</label>
                    <select name="status" id="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos os status</option>
                        @foreach(['Ativo','Em manutenção','Inativo','Descartado'] as $s)
                            <option value="{{ $s }}" @selected(request('status') === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    <i class="fas fa-filter mr-2"></i>Filtrar
                </button>

                @if(request('busca') || request('filtro') || request('status'))
                    <a href="{{ route('equipamentos_medicao.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i>Limpar
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide"><i class="fas fa-hashtag mr-1"></i>Código</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide"><i class="fas fa-ruler-combined mr-1"></i>Equipamento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide"><i class="fas fa-user mr-1"></i>Responsável</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide"><i class="fas fa-calendar-check mr-1"></i>Última calibração</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide"><i class="fas fa-calendar-alt mr-1"></i>Próxima calibração</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide"><i class="fas fa-toggle-on mr-1"></i>Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide"><i class="fas fa-tools mr-1"></i>Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($equipamentos as $e)
                            @php $dias = $e->dias_para_proxima_calibracao; @endphp
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-indigo-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 font-mono">{{ $e->codigo }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="{{ route('equipamentos_medicao.show', $e) }}" class="font-medium text-indigo-600 hover:text-indigo-900 hover:underline">{{ $e->nome }}</a>
                                    <div class="text-xs text-gray-500">{{ trim($e->marca.' '.$e->modelo) ?: '—' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $e->responsavel?->name ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $e->ultima_calibracao?->format('d/m/Y') ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    @if($e->proxima_calibracao)
                                        <div>{{ $e->proxima_calibracao->format('d/m/Y') }}</div>
                                        @if($dias !== null)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium @if($dias < 0) bg-red-100 text-red-800 @elseif($dias <= 30) bg-yellow-100 text-yellow-800 @else bg-green-100 text-green-800 @endif">
                                                <i class="fas fa-clock mr-1"></i>{{ $dias < 0 ? abs($dias).'d em atraso' : $dias.'d restantes' }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium @if($e->status === 'Ativo') bg-green-100 text-green-800 @elseif($e->status === 'Em manutenção') bg-yellow-100 text-yellow-800 @elseif($e->status === 'Inativo') bg-gray-100 text-gray-800 @else bg-red-100 text-red-800 @endif">{{ $e->status }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('equipamentos_medicao.show', $e) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-900 transition" title="Visualizar"><i class="fas fa-eye"></i><span class="hidden sm:inline">Visualizar</span></a>
                                        <a href="{{ route('equipamentos_medicao.edit', $e) }}" class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-900 transition" title="Editar"><i class="fas fa-edit"></i><span class="hidden sm:inline">Editar</span></a>
                                        <form action="{{ route('equipamentos_medicao.destroy', $e) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este equipamento?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 text-red-600 hover:text-red-900 transition" title="Excluir"><i class="fas fa-trash-alt"></i><span class="hidden sm:inline">Excluir</span></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-10 text-center text-gray-500"><i class="fas fa-inbox text-3xl mb-2 block text-gray-300"></i>Nenhum equipamento encontrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
