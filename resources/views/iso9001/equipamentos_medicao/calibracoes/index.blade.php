<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-clipboard-check text-blue-600"></i>
                Calibrações
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('iso9001.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('calibracoes.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Nova Calibração
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>{{ session('success') }}
            </div>
        @endif

        {{-- Filtros --}}
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('calibracoes.index') }}"
                  class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[220px]">
                    <label class="sr-only">Busca</label>
                    <input type="text" name="busca" value="{{ request('busca') }}"
                           placeholder="Laboratório ou nº do certificado..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="min-w-[220px]">
                    <label class="sr-only">Equipamento</label>
                    <select name="equipamento_id" class="block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Todos os equipamentos</option>
                        @foreach($equipamentos as $eq)
                            <option value="{{ $eq->id }}" @selected(request('equipamento_id') == $eq->id)>
                                {{ $eq->codigo }} — {{ $eq->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-[180px]">
                    <label class="sr-only">Resultado</label>
                    <select name="resultado" class="block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Todos os resultados</option>
                        @foreach(['Aprovado','Aprovado com restrição','Reprovado'] as $r)
                            <option value="{{ $r }}" @selected(request('resultado') === $r)>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition">
                    <i class="fas fa-filter mr-2"></i>Filtrar
                </button>

                @if(request()->hasAny(['busca','equipamento_id','resultado']))
                    <a href="{{ route('calibracoes.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i>Limpar
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabela --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            @foreach([
                                'Equipamento','Data calibração','Validade','Laboratório',
                                'Certificado','Resultado','Responsável'
                            ] as $h)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                            @endforeach
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($calibracoes as $c)
                            @php
                                $dias = now()->diffInDays($c->data_validade, false);
                            @endphp
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-indigo-50 transition">
                                <td class="px-6 py-4 text-sm">
                                    @if($c->equipamento)
                                        <a href="{{ route('equipamentos_medicao.show', $c->equipamento) }}"
                                           class="font-medium text-indigo-600 hover:underline">
                                            {{ $c->equipamento->nome }}
                                        </a>
                                        <div class="text-xs text-gray-500 font-mono">{{ $c->equipamento->codigo }}</div>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $c->data_calibracao->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <div>{{ $c->data_validade->format('d/m/Y') }}</div>
                                    @if($dias < 0)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-clock mr-1"></i>{{ abs($dias) }}d em atraso
                                        </span>
                                    @elseif($dias <= 30)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i>{{ $dias }}d restantes
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $c->laboratorio ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm font-mono">
                                    @if($c->certificado_path)
                                        <a href="{{ Storage::disk('public')->url($c->certificado_path) }}"
                                           target="_blank" class="text-indigo-600 hover:underline">
                                            {{ $c->certificado_numero ?? 'Ver' }}
                                        </a>
                                    @else
                                        {{ $c->certificado_numero ?? '—' }}
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium
                                        @if($c->resultado === 'Aprovado') bg-green-100 text-green-800
                                        @elseif($c->resultado === 'Aprovado com restrição') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $c->resultado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $c->responsavel?->name ?? '—' }}</td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('calibracoes.show', $c) }}"
                                           class="text-blue-600 hover:text-blue-900" title="Ver">
                                            <i class="fas fa-eye"></i>Visualizar
                                        </a>
                                        <a href="{{ route('calibracoes.edit', $c) }}"
                                           class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                            <i class="fas fa-edit"></i>Editar
                                        </a>
                                        <form action="{{ route('calibracoes.destroy', $c) }}" method="POST"
                                              onsubmit="return confirm('Excluir esta calibração?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Excluir">
                                                <i class="fas fa-trash-alt"></i>Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                                    <i class="fas fa-inbox text-3xl mb-2 block text-gray-300"></i>
                                    Nenhuma calibração encontrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($calibracoes->total() > 0)
                <div class="px-6 py-4 border-t border-gray-200">{{ $calibracoes->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>