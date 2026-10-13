<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-calendar-alt text-blue-600"></i>
                Calendário de Eventos
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('cadastros.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('calendario.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Novo Evento
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

        {{-- Filtro --}}
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('calendario.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Buscar por Título do Evento..."
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                {{-- Filtro por Categoria --}}
                <div class="min-w-[180px]">
                    <label for="categoria" class="sr-only">Categoria</label>
                    <select name="categoria" id="categoria"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todas as categorias</option>
                        @foreach(['Auditoria', 'Prazo SGI', 'Reunião', 'Treinamento', 'Manutenção', 'Outros'] as $cat)
                            <option value="{{ $cat }}" @selected(request('categoria') === $cat)>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    <i class="fas fa-search mr-2"></i> Buscar
                </button>

                @if(request('search') || request('categoria'))
                    <a href="{{ route('calendario.index') }}"
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
                                <i class="fas fa-calendar-day mr-1"></i>Data Início
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-heading mr-1"></i>Título
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-folder mr-1"></i>Categoria
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-user mr-1"></i>Responsável
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-info-circle mr-1"></i>Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-tools mr-1"></i>Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($eventos as $evento)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                    {{ optional($evento->data_inicio)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                    {{ $evento->titulo }}
                                    @if($evento->descricao)
                                    <p class="text-xs text-gray-500 mt-0.5 max-w-xs whitespace-pre-line">
                                        {!! nl2br(e($evento->descricao)) !!}
                                    </p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $evento->categoria }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                    {{ $evento->responsavel?->name ?? 'Não atribuído' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = match($evento->status) {
                                            'Agendado'   => 'bg-amber-100 text-amber-800',
                                            'Realizado'  => 'bg-green-100 text-green-800',
                                            'Cancelado'  => 'bg-red-100 text-red-800',
                                            'Adiado'     => 'bg-purple-100 text-purple-800',
                                            default      => 'bg-gray-100 text-gray-800',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses }}">
                                        {{ $evento->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('calendario.show', $evento) }}"
                                           class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                           title="Visualizar">
                                            <i class="fas fa-eye mr-1"></i>Visualizar
                                        </a>
                                        <a href="{{ route('calendario.edit', $evento) }}"
                                           class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                           title="Editar">
                                            <i class="fas fa-edit mr-1"></i>Editar
                                        </a>
                                        <form action="{{ route('calendario.destroy', $evento) }}"
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este evento?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-2 py-1 bg-red-50 text-red-700 rounded hover:bg-red-100"
                                                    title="Excluir">
                                                <i class="fas fa-trash mr-1"></i>Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    <i class="fas fa-calendar-times text-3xl text-gray-300 block mb-2"></i>
                                    Nenhum evento cadastrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($eventos->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $eventos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>