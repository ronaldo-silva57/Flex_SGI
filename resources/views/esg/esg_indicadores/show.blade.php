<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-chart-pie text-emerald-500"></i> Detalhes do Indicador ESG
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('esg_indicadores.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('esg_indicadores.edit', $esgIndicador) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Cabeçalho com código, dimensão e status --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $esgIndicador->codigo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Dimensão</span>
                    @php
                        $cor = match($esgIndicador->dimensao) {
                            'Ambiental' => 'green',
                            'Social' => 'blue',
                            'Governança' => 'purple',
                        };
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $cor }}-100 text-{{ $cor }}-800">
                        {{ $esgIndicador->dimensao }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @if($esgIndicador->ativo)
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Ativo
                        </span>
                    @else
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i> Inativo
                        </span>
                    @endif
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $esgIndicador->responsavel?->name ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- Nome e descrição --}}
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Nome</span>
                    <p class="text-lg font-semibold text-gray-800">{{ $esgIndicador->nome }}</p>
                </div>
                @if($esgIndicador->descricao)
                    <div>
                        <span class="block text-sm font-medium text-gray-500 mb-1">Descrição</span>
                        <p class="text-gray-700 whitespace-pre-line">{{ $esgIndicador->descricao }}</p>
                    </div>
                @endif
            </div>

            {{-- Meta e frequência --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Meta</span>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $esgIndicador->meta !== null ? number_format($esgIndicador->meta, 2, ',', '.') : 'Não definida' }}
                    </p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Unidade de Medida</span>
                    <p class="text-lg font-semibold text-gray-800">{{ $esgIndicador->unidade_medida ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Frequência</span>
                    <p class="text-lg font-semibold text-gray-800">{{ $esgIndicador->frequencia }}</p>
                </div>
            </div>

            {{-- Referência GRI --}}
            @if($esgIndicador->referencia_gri)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Referência GRI</span>
                    <p class="text-gray-700">{{ $esgIndicador->referencia_gri }}</p>
                </div>
            @endif

            {{-- Fórmula (se houver) --}}
            @if($esgIndicador->formula)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Fórmula de Cálculo</span>
                    <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                        {{ $esgIndicador->formula }}
                    </div>
                </div>
            @endif

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Criado em: {{ $esgIndicador->created_at?->format('d/m/Y H:i') }}
                    @if($esgIndicador->updated_at && $esgIndicador->updated_at != $esgIndicador->created_at)
                        <br>Última atualização: {{ $esgIndicador->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
                <div>
                    <form action="{{ route('esg_indicadores.destroy', $esgIndicador) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este indicador?')">
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