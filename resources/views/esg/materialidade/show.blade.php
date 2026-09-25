<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-layer-group text-purple-500"></i> Detalhes da Materialidade
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('materialidade.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('materialidade.edit', $materialidade) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Tema e Indicador --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tema</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $materialidade->tema }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Indicador ESG</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $materialidade->esgIndicador ? $materialidade->esgIndicador->codigo . ' - ' . $materialidade->esgIndicador->nome : 'Não vinculado' }}
                    </span>
                </div>
            </div>

            {{-- Importâncias, Score e Classificação --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Importância Stakeholders</span>
                    <span class="text-2xl font-bold text-gray-800">{{ $materialidade->importancia_stakeholders }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Importância Negócio</span>
                    <span class="text-2xl font-bold text-gray-800">{{ $materialidade->importancia_negocio }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Score</span>
                    <span class="text-2xl font-bold text-gray-800">{{ $materialidade->score }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Classificação</span>
                    @php
                        $cores = [
                            'Baixa' => 'gray',
                            'Média' => 'yellow',
                            'Alta' => 'orange',
                            'Crítica' => 'red',
                        ];
                        $cor = $cores[$materialidade->classificacao] ?? 'gray';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $cor }}-100 text-{{ $cor }}-800">
                        {{ $materialidade->classificacao ?? 'N/A' }}
                    </span>
                </div>
            </div>

            {{-- Ações --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Criado em: {{ $materialidade->created_at?->format('d/m/Y H:i') }}
                    @if($materialidade->updated_at && $materialidade->updated_at != $materialidade->created_at)
                        <br>Última atualização: {{ $materialidade->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
                <div>
                    <form action="{{ route('materialidade.destroy', $materialidade) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este tema?')">
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