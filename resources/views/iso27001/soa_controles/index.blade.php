<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-clipboard-check text-purple-600"></i>
                SoA – Declaração de Aplicabilidade
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('iso27001.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('soa_controles.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Novo Controle SoA
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
            <form method="GET" action="{{ route('soa_controles.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                <div class="md:col-span-4">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Buscar por código, domínio, título..."
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label for="dominio" class="block text-xs text-gray-500 mb-1">Domínio</label>
                    <select name="dominio" id="dominio"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="">Todos</option>
                        @foreach($dominios as $d)
                            <option value="{{ $d }}" {{ request('dominio') == $d ? 'selected' : '' }}>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="aplicavel" class="block text-xs text-gray-500 mb-1">Aplicável</label>
                    <select name="aplicavel" id="aplicavel"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="">Todos</option>
                        <option value="1" {{ request('aplicavel') === '1' ? 'selected' : '' }}>Sim</option>
                        <option value="0" {{ request('aplicavel') === '0' ? 'selected' : '' }}>Não</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="status_implementacao" class="block text-xs text-gray-500 mb-1">Status</label>
                    <select name="status_implementacao" id="status_implementacao"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                        <option value="">Todos</option>
                        @foreach($statuses as $s)
                            <option value="{{ $s }}" {{ request('status_implementacao') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-1 flex gap-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center w-full px-3 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition text-sm">
                        <i class="fas fa-filter"></i>
                    </button>
                    @if(request()->anyFilled(['search','dominio','aplicavel','status_implementacao']))
                        <a href="{{ route('soa_controles.index') }}"
                           class="inline-flex items-center justify-center w-full px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition text-sm"
                           title="Limpar filtros">
                            <i class="fas fa-times"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabela --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Anexo A</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Domínio</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Título</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wide">Aplicável</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($controles as $controle)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-purple-700">
                                    {{ $controle->codigo_anexo_a }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $controle->dominio }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900">
                                    {{ \Illuminate\Support\Str::limit($controle->titulo, 70) }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-center">
                                    @if($controle->aplicavel)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>Sim
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-200 text-gray-700">
                                            <i class="fas fa-ban mr-1"></i>Não
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'Não iniciado'     => 'bg-gray-400 text-white',
                                            'Em implementacao' => 'bg-yellow-500 text-white',
                                            'Implementado'     => 'bg-green-500 text-white',
                                            'Não aplicável'    => 'bg-slate-500 text-white',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide {{ $statusColors[$controle->status_implementacao] ?? 'bg-gray-400 text-white' }}">
                                        {{ $controle->status_implementacao }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('soa_controles.show', $controle) }}"
                                           class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                           title="Visualizar">
                                            <i class="fas fa-eye mr-1"></i>Ver
                                        </a>
                                        <a href="{{ route('soa_controles.edit', $controle) }}"
                                           class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                           title="Editar">
                                            <i class="fas fa-edit mr-1"></i>Editar
                                        </a>
                                        <form action="{{ route('soa_controles.destroy', $controle) }}"
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este controle SoA?');">
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
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl block mb-3 text-gray-300"></i>
                                    Nenhum controle SoA cadastrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($controles->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $controles->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>