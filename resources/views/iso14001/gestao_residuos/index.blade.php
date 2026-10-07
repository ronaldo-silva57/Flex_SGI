<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-recycle text-green-600"></i> Gestão de Resíduos
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('iso14001.dashboard') }}" class="px-4 py-2 bg-blue-50 text-blue-700 border border-blue-200 rounded-md hover:bg-blue-100 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('gestao_residuos.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Novo Resíduo
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
            <form method="GET" action="{{ route('gestao_residuos.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Buscar por código, descrição ou fonte..."
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <select name="tipo" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos os Tipos</option>
                        @foreach(\App\Models\GestaoResiduo::TIPOS as $t)
                            <option value="{{ $t }}" {{ request('tipo') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>>
                </div>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition">
                    <i class="fas fa-search mr-2"></i> Filtrar
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('gestao_residuos.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i> Limpar
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabela --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código / Descrição</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo / Classe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qtd. Estimada</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Destino Final</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($residuos as $residuo)
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900 block">{{ $residuo->codigo }}</span>
                                <span class="text-sm text-gray-600">{{ $residuo->descricao }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800 block w-max mb-1">{{ $residuo->tipo }}</span>
                                <span class="text-xs text-gray-500">{{ $residuo->classe ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                {{ $residuo->quantidade_gerada ? $residuo->quantidade_gerada . ' ' . $residuo->unidade_medida : '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $residuo->destino_final ?? 'Não informado' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs rounded-full font-bold {{ $residuo->status == 'Ativo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $residuo->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <div class="flex justify-end gap-3">
                                    <a href="{{ route('gestao_residuos.show', $residuo) }}"
                                    class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                    title="Visualizar">
                                        <i class="fas fa-eye"></i>Visualizar
                                    </a>
                                    <a href="{{ route('gestao_residuos.edit', $residuo) }}"
                                    class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                    title="Editar">
                                        <i class="fas fa-edit"></i>Editar
                                    </a>
                                    <form action="{{ route('gestao_residuos.destroy', $residuo) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir esta licença?');">
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
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Nenhum resíduo cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $residuos->links() }}
        </div>
    </div>
</x-app-layout>