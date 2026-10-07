<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-users-between-lines text-blue-500"></i>
                Reuniões da CIPA
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('iso45001.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-100">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>
                <a href="{{ route('cipa_reunioes.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i> Nova Reunião
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">

            {{-- Barra de pesquisa e filtros --}}
            <div class="mb-6">
                <form method="GET" action="{{ route('cipa_reunioes.index') }}" class="flex flex-wrap gap-3 items-center">
                    <div class="flex-1 min-w-[200px]">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Buscar por pauta, gestão ou empresa...">
                        </div>
                    </div>

                    <div class="w-full sm:w-48">
                        <select name="tipo" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-blue-500">
                            <option value="">Todos os tipos</option>
                            @foreach(['Ordinária', 'Extraordinária', 'Inspeção de Campo', 'DDSGeral'] as $t)
                                <option value="{{ $t }}" {{ request('tipo') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="w-full sm:w-44">
                        <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos os status</option>
                            @foreach(['Agendada', 'Realizada', 'Cancelada'] as $s)
                                <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                        <i class="fas fa-search mr-2"></i> Filtrar
                    </button>

                    @if(request()->hasAny(['search', 'tipo', 'status', 'empresa_id']))
                        <a href="{{ route('cipa_reunioes.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times-circle mr-1"></i> Limpar
                        </a>
                    @endif
                </form>
            </div>

            {{-- Tabela --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gestão</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pauta Principal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Presidente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reunioes as $reuniao)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $reuniao->data_reuniao ? \Carbon\Carbon::parse($reuniao->data_reuniao)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $tipoClasses = [
                                            'Ordinária'         => 'bg-blue-100 text-blue-800',
                                            'Extraordinária'    => 'bg-purple-100 text-purple-800',
                                            'Inspeção de Campo' => 'bg-amber-100 text-amber-800',
                                            'DDSGeral'          => 'bg-emerald-100 text-emerald-800',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tipoClasses[$reuniao->tipo] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $reuniao->tipo }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $reuniao->gestao_ano }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 max-w-[260px] truncate">
                                    {{ Str::limit($reuniao->pauta_principal, 60) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $reuniao->presidente?->name ?? 'N/I' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'Agendada'  => 'bg-yellow-100 text-yellow-800',
                                            'Realizada' => 'bg-green-100 text-green-800',
                                            'Cancelada' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$reuniao->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $reuniao->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('cipa_reunioes.show', $reuniao) }}"
                                        class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                        title="Visualizar">
                                            <i class="fas fa-eye"></i>Visualizar
                                        </a>
                                        <a href="{{ route('cipa_reunioes.edit', $reuniao) }}"
                                        class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                        title="Editar">
                                            <i class="fas fa-edit"></i>Editar
                                        </a>
                                        <form action="{{ route('cipa_reunioes.destroy', $reuniao) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja excluir esta reunião?')" class="inline">
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
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Nenhuma reunião da CIPA registrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginação --}}
            <div class="mt-6">
                {{ $reunioes->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
</x-app-layout>