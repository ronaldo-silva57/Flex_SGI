<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-comments text-indigo-600"></i>
                ISO 9001 · Respostas de Pesquisas
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('pesquisas_satisfacao.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Pesquisas
                </a>
                <a href="{{ route('pesquisas_satisfacao_respostas.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Nova Resposta
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        {{-- Filtros --}}
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <form method="GET" action="{{ route('pesquisas_satisfacao_respostas.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="busca" value="{{ request('busca') }}"
                           placeholder="Buscar por código ou título da pesquisa..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="min-w-[180px]">
                    <select name="pesquisa_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todas as pesquisas</option>
                        @foreach($pesquisas as $p)
                            <option value="{{ $p->id }}" @selected(request('pesquisa_id') == $p->id)>{{ $p->codigo }} - {{ $p->titulo }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-[150px]">
                    <select name="classificacao" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todas as notas</option>
                        <option value="Promotor" @selected(request('classificacao') === 'Promotor')>Promotor (9-10)</option>
                        <option value="Neutro" @selected(request('classificacao') === 'Neutro')>Neutro (7-8)</option>
                        <option value="Detrator" @selected(request('classificacao') === 'Detrator')>Detrator (0-6)</option>
                    </select>
                </div>

                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition">
                    <i class="fas fa-filter mr-1"></i> Filtrar
                </button>
            </form>
        </div>

        {{-- Tabela --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pesquisa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Respondente</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nota</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Classificação</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($respostas as $r)
                            <tr class="hover:bg-indigo-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <span class="font-mono text-xs font-bold text-gray-500 block">{{ $r->pesquisa?->codigo }}</span>
                                    {{ $r->pesquisa?->titulo }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $r->cliente?->nome ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $r->respondente?->name ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-center font-bold text-gray-900">{{ number_format($r->nota, 2, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm text-center">
                                    @php
                                        $badge = match($r->classificacao) {
                                            'Promotor' => 'bg-emerald-100 text-emerald-800',
                                            'Neutro'   => 'bg-amber-100 text-amber-800',
                                            'Detrator' => 'bg-rose-100 text-rose-800',
                                            default    => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                                        {{ $r->classificacao }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $r->respondido_em?->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('pesquisas_satisfacao_respostas.edit', $r) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('pesquisas_satisfacao_respostas.destroy', $r) }}" method="POST" onsubmit="return confirm('Excluir esta resposta?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    Nenhuma resposta registrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($respostas->total() > 0)
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $respostas->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>