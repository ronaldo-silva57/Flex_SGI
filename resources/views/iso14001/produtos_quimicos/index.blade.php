<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-flask text-green-600"></i> Produtos Químicos
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('iso14001.dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('produtos_quimicos.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Novo Produto
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
            <form method="GET" action="{{ route('produtos_quimicos.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Buscar por nome, CAS ou fabricante..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos</option>
                        @foreach(['Ativo','Inativo','Descontinuado'] as $st)
                            <option value="{{ $st }}" {{ request('status')==$st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('produtos_quimicos.index') }}"
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CAS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fabricante</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estoque</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Validade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">FISPQ</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($produtos as $p)
                            @php
                                $stClasses = [
                                    'Ativo'         => 'bg-green-100 text-green-800',
                                    'Inativo'       => 'bg-gray-100 text-gray-700',
                                    'Descontinuado' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $p->nome }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $p->numero_cas ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $p->fabricante ?? '—' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $p->quantidade_estoque ? $p->quantidade_estoque.' '.$p->unidade_medida : '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $p->data_validade ? \Carbon\Carbon::parse($p->data_validade)->format('d/m/Y') : '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $stClasses[$p->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($p->arquivo_fispq_path)
                                        <a href="{{ route('produtos_quimicos.fispq.download', $p) }}"
                                           class="text-blue-600 hover:text-blue-800" title="Baixar FISPQ">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs">Sem arquivo</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('produtos_quimicos.show', $p) }}"
                                        class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                        title="Visualizar">
                                            <i class="fas fa-eye"></i>Visualizar
                                        </a>
                                        <a href="{{ route('produtos_quimicos.edit', $p) }}"
                                        class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                        title="Editar">
                                            <i class="fas fa-edit"></i>Editar
                                        </a>
                                        <form action="{{ route('produtos_quimicos.destroy', $p) }}" method="POST"
                                              onsubmit="return confirm('Excluir este produto?');" class="inline">
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
                            <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Nenhum produto cadastrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $produtos->links() }}</div>
    </div>
</x-app-layout>