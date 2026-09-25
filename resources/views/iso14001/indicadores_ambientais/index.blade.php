<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-chart-bar text-green-600"></i> Indicadores Ambientais
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('iso14001.dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('indicadores_ambientais.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Novo Indicador
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-green-500 mr-3"></i><span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('indicadores_ambientais.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Buscar por código, nome ou descrição..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <select name="categoria" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todas as categorias</option>
                        @foreach(['Emissões Atmosféricas','Recursos Hídricos','Energia','Resíduos','Biodiversidade','Uso do Solo','Ruído','Outros'] as $cat)
                            <option value="{{ $cat }}" {{ request('categoria')==$cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
                @if(request('search') || request('categoria'))
                    <a href="{{ route('indicadores_ambientais.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Meta</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Frequência</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($indicadores as $ind)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $ind->codigo }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $ind->nome }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-800">{{ $ind->categoria }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $ind->meta ? $ind->meta.' '.$ind->unidade_medida : '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $ind->frequencia ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($ind->ativo)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i>Ativo</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800"><i class="fas fa-times-circle mr-1"></i>Inativo</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('indicadores_ambientais.show', $ind) }}" class="text-blue-600 hover:text-blue-900"><i class="fas fa-eye"></i></a>Visualizar
                                        <a href="{{ route('indicadores_ambientais.edit', $ind) }}" class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-edit"></i></a>Editar
                                        <form action="{{ route('indicadores_ambientais.destroy', $ind) }}" method="POST"
                                              onsubmit="return confirm('Excluir este indicador?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i></button> Excluir
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Nenhum indicador cadastrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $indicadores->links() }}</div>
    </div>
</x-app-layout>