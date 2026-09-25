<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-eye text-blue-500"></i>Detalhes da Ação Corretiva
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('acoes_corretivas.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('acoes_corretivas.edit', $acaoCorretiva) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Não Conformidade</span>
                    <span class="mt-1 text-lg font-semibold">{{ $acaoCorretiva->naoConformidade->descricao ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold">{{ $acaoCorretiva->responsavel->name ?? 'Não definido' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Etapa</span>
                    @php
                        $etapaClasses = [
                            'Contenção'    => 'bg-blue-100 text-blue-800',
                            'Causa raiz'   => 'bg-purple-100 text-purple-800',
                            'Correção'     => 'bg-indigo-100 text-indigo-800',
                            'Verificação'  => 'bg-yellow-100 text-yellow-800',
                            'Conclusão'    => 'bg-green-100 text-green-800',
                        ][$acaoCorretiva->etapa] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $etapaClasses }}">
                        {{ $acaoCorretiva->etapa }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusClasses = [
                            'Pendente'       => 'bg-red-100 text-red-800',
                            'Em andamento'   => 'bg-yellow-100 text-yellow-800',
                            'Concluída'      => 'bg-green-100 text-green-800',
                            'Reprovada'      => 'bg-gray-100 text-gray-800',
                        ][$acaoCorretiva->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClasses }}">
                        {{ $acaoCorretiva->status }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Prazo</span>
                    <span class="mt-1 text-lg font-semibold">{{ $acaoCorretiva->prazo ? $acaoCorretiva->prazo->format('d/m/Y') : '---' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Execução</span>
                    <span class="mt-1 text-lg font-semibold">{{ $acaoCorretiva->data_execucao ? $acaoCorretiva->data_execucao->format('d/m/Y') : '---' }}</span>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Descrição</span>
                    <p class="mt-1 text-gray-800">{{ $acaoCorretiva->descricao }}</p>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Evidência</span>
                    <p class="mt-1 text-gray-800">{{ $acaoCorretiva->evidencia ?? 'Não informada' }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Ação eficaz?</span>
                    <span class="mt-1 text-lg font-semibold">
                        @if($acaoCorretiva->eficaz === true)
                            <span class="text-green-600"><i class="fas fa-check-circle"></i> Sim</span>
                        @elseif($acaoCorretiva->eficaz === false)
                            <span class="text-red-600"><i class="fas fa-times-circle"></i> Não</span>
                        @else
                            <span class="text-gray-400">Não avaliado</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Criado em</span>
                    <span class="mt-1 text-sm text-gray-600">{{ $acaoCorretiva->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Última atualização</span>
                    <span class="mt-1 text-sm text-gray-600">{{ $acaoCorretiva->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('acoes_corretivas.destroy', $acaoCorretiva) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir esta ação corretiva?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i> Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>