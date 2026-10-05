<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-clipboard-check text-blue-500"></i>Avaliações de Fornecedores
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('cadastros.dashboard') }}"			    
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('avaliacoes_fornecedores.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    Nova Avaliação
                </a>
            </div>
        </div>
    </x-slot>
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-3 rounded-md bg-green-100 text-green-800 border border-green-200">
                <i class="fas fa-check-circle mr-1"></i>{{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Período</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Fornecedor</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Empresa</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Avaliador</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Nota Final</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($avaliacoes as $avaliacao)
                            @php
                                $badge = match($avaliacao->status_qualificacao) {
                                    'Aprovado'                 => 'bg-green-100 text-green-800',
                                    'Aprovado com Restrição'   => 'bg-yellow-100 text-yellow-800',
                                    'Reprovado'                => 'bg-red-100 text-red-800',
                                    'Em observação'            => 'bg-blue-100 text-blue-800',
                                    default                    => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                    {{ $avaliacao->periodo_referencia }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $avaliacao->fornecedor->razao_social ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $avaliacao->empresa->razao_social ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    {{ $avaliacao->avaliador->name ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-center font-semibold text-gray-900">
                                    {{ number_format((float) $avaliacao->nota_final, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                                        {{ $avaliacao->status_qualificacao }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="inline-flex gap-1">
                                        <a href="{{ route('avaliacoes_fornecedores.show', $avaliacao) }}"
                                           class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                           title="Visualizar">
                                            <i class="fas fa-eye"></i>Visualizar
                                        </a>
                                        <a href="{{ route('avaliacoes_fornecedores.edit', $avaliacao) }}"
                                           class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>Editar
                                        </a>
                                        <form action="{{ route('avaliacoes_fornecedores.destroy', $avaliacao) }}"
                                              method="POST"
                                              onsubmit="return confirm('Excluir esta avaliação?')">
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
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <i class="fas fa-inbox text-3xl mb-2 block"></i>
                                    Nenhuma avaliação registrada.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($avaliacoes->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $avaliacoes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>