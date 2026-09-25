<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-eye text-blue-500"></i>Detalhes do Item de Auditoria
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('auditorias_itens.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('auditorias_itens.edit', $auditoriaItem) }}"
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
    <span class="block text-sm font-medium text-gray-500">Auditoria</span>
    <span class="mt-1 text-lg font-semibold">
        {{ $auditoriaItem->auditoria->escopo ?? $auditoriaItem->auditoria->empresa->nome ?? 'Auditoria #' . $auditoriaItem->auditoria_id }}
    </span>
</div>

<!-- Cláusula -->
<div>
    <span class="block text-sm font-medium text-gray-500">Cláusula</span>
    <span class="mt-1 text-lg font-semibold">
        {{ $auditoriaItem->clausula->codigo ?? '-' }}
        @if($auditoriaItem->clausula)
            <span class="text-sm font-normal text-gray-500"> - {{ $auditoriaItem->clausula->titulo }}</span>
        @endif
    </span>
</div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Processo</span>
                    <span class="mt-1 text-lg font-semibold">{{ $auditoriaItem->processo->nome ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Auditor</span>
                    <span class="mt-1 text-lg font-semibold">{{ $auditoriaItem->auditor->name ?? 'Não definido' }}</span>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Descrição da Verificação</span>
                    <p class="mt-1 text-gray-800">{{ $auditoriaItem->descricao_verificacao }}</p>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Evidência Coletada</span>
                    <p class="mt-1 text-gray-800">{{ $auditoriaItem->evidencia_coletada ?? 'Não informada' }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Conformidade</span>
                    @php
                        $conformidadeClasses = [
                            'conforme'              => 'bg-green-100 text-green-800',
                            'nao_conforme'          => 'bg-red-100 text-red-800',
                            'oportunidade_melhoria' => 'bg-yellow-100 text-yellow-800',
                            'nao_aplicavel'         => 'bg-gray-100 text-gray-800',
                        ][$auditoriaItem->conformidade] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $conformidadeClasses }}">
                        {{ $auditoriaItem->conformidade ? str_replace('_', ' ', $auditoriaItem->conformidade) : '---' }}
                    </span>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Observações</span>
                    <p class="mt-1 text-gray-800">{{ $auditoriaItem->observacoes ?? 'Não informado' }}</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('auditorias_itens.destroy', $auditoriaItem) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este item?')">
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