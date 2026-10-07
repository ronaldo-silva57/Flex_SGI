{{-- resources/views/iso9001/pesquisas_satisfacao/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-smile text-blue-600"></i>
                Pesquisas de Satisfação
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('iso9001.dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('pesquisas_satisfacao.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Nova Pesquisa
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

        {{-- Filtros --}}
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('pesquisas_satisfacao.index') }}"
                  class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[220px]">
                    <label for="busca" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="busca" id="busca" value="{{ request('busca') }}"
                               placeholder="Buscar por código ou título..."
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="min-w-[160px]">
                    <label for="status" class="sr-only">Status</label>
                    <select name="status" id="status"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos os status</option>
                        @foreach (['Planejada', 'Em andamento', 'Concluída', 'Cancelada'] as $st)
                            <option value="{{ $st }}" @selected(request('status') === $st)>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-[160px]">
                    <label for="tipo" class="sr-only">Tipo</label>
                    <select name="tipo" id="tipo"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos os tipos</option>
                        @foreach (['NPS', 'CSAT', 'Personalizada'] as $tp)
                            <option value="{{ $tp }}" @selected(request('tipo') === $tp)>{{ $tp }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    <i class="fas fa-search mr-2"></i> Filtrar
                </button>

                @if(request()->hasAny(['busca', 'status', 'tipo']))
                    <a href="{{ route('pesquisas_satisfacao.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i> Limpar
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-hashtag mr-1"></i>Código
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-heading mr-1"></i>Título
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-user mr-1"></i>Cliente
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-tag mr-1"></i>Tipo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-toggle-on mr-1"></i>Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-calendar-day mr-1"></i>Início
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-star mr-1"></i>Nota
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-reply-all mr-1"></i>Respostas
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-tools mr-1"></i>Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($pesquisas as $pesquisa)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-indigo-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $pesquisa->codigo ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $pesquisa->titulo }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $pesquisa->cliente->nome ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $tipoCores = [
                                            'NPS'            => 'bg-purple-100 text-purple-800',
                                            'CSAT'           => 'bg-blue-100 text-blue-800',
                                            'Personalizada'  => 'bg-amber-100 text-amber-800',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $tipoCores[$pesquisa->tipo] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $pesquisa->tipo }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusCores = [
                                            'Planejada'    => 'bg-gray-100 text-gray-800',
                                            'Em andamento' => 'bg-blue-100 text-blue-800',
                                            'Concluída'    => 'bg-green-100 text-green-800',
                                            'Cancelada'    => 'bg-red-100 text-red-800',
                                        ];
                                        $statusIcones = [
                                            'Planejada'    => 'fa-clock',
                                            'Em andamento' => 'fa-spinner',
                                            'Concluída'    => 'fa-check-circle',
                                            'Cancelada'    => 'fa-times-circle',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusCores[$pesquisa->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        <i class="fas {{ $statusIcones[$pesquisa->status] ?? 'fa-circle' }} mr-1"></i>
                                        {{ $pesquisa->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ optional($pesquisa->data_inicio)->format('d/m/Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ $pesquisa->nota_media !== null ? number_format($pesquisa->nota_media, 2, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $pesquisa->total_respostas ?? 0 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                    <a href="{{ route('pesquisas_satisfacao.show', $pesquisa) }}"
                                    class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                    title="Visualizar">
                                        <i class="fas fa-eye"></i>Visualizar
                                    </a>
                                    <a href="{{ route('pesquisas_satisfacao.edit', $pesquisa) }}"
                                    class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                    title="Editar">
                                        <i class="fas fa-edit"></i>Editar
                                    </a>
                                        <form action="{{ route('pesquisas_satisfacao.destroy', $pesquisa) }}"
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta pesquisa?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-2 py-1 bg-red-50 text-red-700 rounded hover:bg-red-100"
                                                title="Excluir">
                                                <i class="fas fa-trash"></i>Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-10 text-center text-sm text-gray-500">
                                    <i class="fas fa-inbox text-3xl text-gray-300 block mb-2"></i>
                                    Nenhuma pesquisa de satisfação encontrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pesquisas->total() > 0)
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $pesquisas->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>