<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-eye text-blue-500"></i>Detalhes: {{ $monitoramento->indicador->nome}}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('monitoramentos.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('monitoramentos.edit', $monitoramento) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offsert-2 transition">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Indicador</span>
                    <span class="mt-1 text-lg font-semibold">{{ $monitoramento->responsavel->name }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Período</span>
                    <span class="mt-1 text-lg font-semibold">{{ $monitoramento->periodo_referencia }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Valor</span>
                    <span class="mt-1 text-lg font-semibold">{{ $monitoramento->valor_realizado }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Meta</span>
                    <span class="mt-1 text-lg font-semibold">{{ $monitoramento->valor_meta}}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Análise</span>
                    <span class="mt-1 text-lg font-semibold">{{ $monitoramento->analise }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Ações necessárias</span>
                    <span class="mt-1 text-lg font-semibold">{{ $monitoramento->acao_necessaria }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    
                    @php
                        $statusStyle = [
                            'No prazo'  => 'bg-blue-100 text-blue-800',
                            'Atrasado'  => 'bg-red-100 text-red-800',
                            'Concluído' => 'bg-green-100 text-green-800',
                        ][$monitoramento->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp

                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusStyle }}">
                        {{ $monitoramento->status }}
                    </span>
                </div>
            </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <form action="{{ route('monitoramentos.destroy', $monitoramento) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este processo?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i> Excluir
                        </button>
                    </form>
                </div>
        </div>
        </div>
    </div>
</x-app-layout>