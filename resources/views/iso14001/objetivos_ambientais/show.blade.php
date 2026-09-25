<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-bullseye text-green-500"></i> Objetivo: {{ $objetivoAmbiental->codigo }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('objetivos_ambientais.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('objetivos_ambientais.edit', $objetivoAmbiental) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div><span class="block text-sm font-medium text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $objetivoAmbiental->codigo }}</span></div>
                <div><span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">{{ $objetivoAmbiental->status }}</span></div>
                <div><span class="block text-sm font-medium text-gray-500">Título</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $objetivoAmbiental->titulo }}</span></div>
                <div><span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg text-gray-800">{{ $objetivoAmbiental->responsavel?->name ?? '—' }}</span></div>
                <div><span class="block text-sm font-medium text-gray-500">Aspecto Ambiental</span>
                    <span class="mt-1 text-lg text-gray-800">{{ $objetivoAmbiental->aspectoAmbiental?->descricao ?? '—' }}</span></div>
                <div><span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg text-gray-800">{{ $objetivoAmbiental->empresa?->razao_social ?? '—' }}</span></div>
                <div><span class="block text-sm font-medium text-gray-500">Indicador</span>
                    <span class="mt-1 text-gray-800">{{ $objetivoAmbiental->indicador ?? '—' }}</span></div>
                <div><span class="block text-sm font-medium text-gray-500">Meta</span>
                    <span class="mt-1 text-gray-800">
                        {{ $objetivoAmbiental->meta ?? '—' }} {{ $objetivoAmbiental->unidade_medida }}
                    </span></div>
                <div><span class="block text-sm font-medium text-gray-500">Progresso</span>
                    <div class="mt-1 flex items-center gap-2">
                        <div class="w-40 bg-gray-200 rounded-full h-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ (int)$objetivoAmbiental->progresso }}%"></div>
                        </div>
                        <span class="text-sm text-gray-700">{{ (int)$objetivoAmbiental->progresso }}%</span>
                    </div>
                </div>
                <div><span class="block text-sm font-medium text-gray-500">Início</span>
                    <span class="mt-1 text-gray-800">{{ optional($objetivoAmbiental->data_inicio)->format('d/m/Y') ?? '—' }}</span></div>
                <div><span class="block text-sm font-medium text-gray-500">Prazo</span>
                    <span class="mt-1 text-gray-800">{{ optional($objetivoAmbiental->prazo)->format('d/m/Y') ?? '—' }}</span></div>
                <div><span class="block text-sm font-medium text-gray-500">Conclusão</span>
                    <span class="mt-1 text-gray-800">{{ optional($objetivoAmbiental->data_conclusao)->format('d/m/Y') ?? '—' }}</span></div>
            </div>

            @foreach(['descricao' => 'Descrição', 'recursos_necessarios' => 'Recursos Necessários',
                      'responsaveis_execucao' => 'Responsáveis pela Execução', 'evidencia' => 'Evidência'] as $field => $label)
                @if($objetivoAmbiental->$field)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <span class="block text-sm font-medium text-gray-500 mb-1">{{ $label }}</span>
                        <p class="text-gray-700 whitespace-pre-line">{{ $objetivoAmbiental->$field }}</p>
                    </div>
                @endif
            @endforeach

            <div class="mt-8 pt-6 border-t flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Criado em: {{ $objetivoAmbiental->created_at?->format('d/m/Y H:i') }}
                </div>
                <form action="{{ route('objetivos_ambientais.destroy', $objetivoAmbiental) }}" method="POST"
                      onsubmit="return confirm('Excluir este objetivo?')">
                    @csrf @method('DELETE')
                    <button class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>