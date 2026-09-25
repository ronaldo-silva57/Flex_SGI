<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-user-graduate text-indigo-600"></i>
                Treinamentos - Participações
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('cadastros.dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('treinamentos_usuarios.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i> Nova Participação
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
            <form method="GET" action="{{ route('treinamentos_usuarios.index') }}"
                  class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Buscar por Treinamento ou Usuário..."
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="w-[200px]">
                    <select name="treinamento_id" class="block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Todos os treinamentos</option>
                        @foreach($treinamentos as $t)
                            <option value="{{ $t->id }}" {{ request('treinamento_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->titulo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-[160px]">
                    <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Todos os status</option>
                        @foreach(['Pendente', 'Em andamento', 'Concluído', 'Vencido'] as $s)
                            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition">
                    <i class="fas fa-search mr-2"></i> Buscar
                </button>
                @if(request()->anyFilled(['search', 'status', 'treinamento_id']))
                    <a href="{{ route('treinamentos_usuarios.index') }}"
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"><i class="fas fa-graduation-cap mr-1"></i>Treinamento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"><i class="fas fa-user mr-1"></i>Usuário</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"><i class="fas fa-calendar-check mr-1"></i>Conclusão</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"><i class="fas fa-calendar-times mr-1"></i>Validade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"><i class="fas fa-star mr-1"></i>Nota</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"><i class="fas fa-toggle-on mr-1"></i>Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase"><i class="fas fa-tools mr-1"></i>Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($participacoes as $p)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $p->treinamento->titulo ?? '--' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $p->usuario->name ?? '--' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $p->data_conclusao?->format('d/m/Y') ?? '--' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm {{ $p->esta_vencido ? 'text-red-600 font-semibold' : 'text-gray-600' }}">
                                    {{ $p->validade_ate?->format('d/m/Y') ?? '--' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $p->nota !== null ? number_format($p->nota, 2, ',', '.') : '--' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $p->status_badge }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('treinamentos_usuarios.show', $p) }}" class="text-blue-600 hover:text-blue-900" title="Visualizar">
                                            <i class="fas fa-eye"></i>Visualizar
                                        </a>
                                        <a href="{{ route('treinamentos_usuarios.edit', $p) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar">
                                            <i class="fas fa-edit"></i>Editar
                                        </a>
                                        <form action="{{ route('treinamentos_usuarios.destroy', $p) }}" method="POST"
                                              onsubmit="return confirm('Excluir esta participação?');">
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
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl block mb-3 text-gray-300"></i>
                                    Nenhuma participação registrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($participacoes->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $participacoes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>