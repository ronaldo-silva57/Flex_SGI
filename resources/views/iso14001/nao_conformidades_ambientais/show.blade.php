<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-red-500"></i> NC: {{ $naoConformidadeAmbiental->codigo }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('nao_conformidades_ambientais.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('nao_conformidades_ambientais.edit', $naoConformidadeAmbiental) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div><span class="block text-sm text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $naoConformidadeAmbiental->codigo }}</span></div>
                <div><span class="block text-sm text-gray-500">Título</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $naoConformidadeAmbiental->titulo }}</span></div>
                <div><span class="block text-sm text-gray-500">Status</span>
                    <span class="mt-1 inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">{{ $naoConformidadeAmbiental->status }}</span></div>
                <div><span class="block text-sm text-gray-500">Origem</span>
                    <span class="mt-1 text-gray-800">{{ $naoConformidadeAmbiental->origem }}</span></div>
                <div><span class="block text-sm text-gray-500">Gravidade</span>
                    <span class="mt-1 text-gray-800">{{ $naoConformidadeAmbiental->gravidade ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Prioridade</span>
                    <span class="mt-1 text-gray-800">{{ $naoConformidadeAmbiental->prioridade ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Local</span>
                    <span class="mt-1 text-gray-800">{{ $naoConformidadeAmbiental->local_ocorrencia ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Recorrente</span>
                    <span class="mt-1 text-gray-800">{{ $naoConformidadeAmbiental->recorrente ? 'Sim' : 'Não' }}</span></div>
                <div><span class="block text-sm text-gray-500">Empresa</span>
                    <span class="mt-1 text-gray-800">{{ $naoConformidadeAmbiental->empresa?->razao_social ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Licença Ambiental</span>
                    <span class="mt-1 text-gray-800">{{ $naoConformidadeAmbiental->licencaAmbiental?->titulo ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Aspecto Ambiental</span>
                    <span class="mt-1 text-gray-800">{{ $naoConformidadeAmbiental->aspectoAmbiental?->descricao ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Processo</span>
                    <span class="mt-1 text-gray-800">{{ $naoConformidadeAmbiental->processo?->nome ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Responsável Apuração</span>
                    <span class="mt-1 text-gray-800">{{ $naoConformidadeAmbiental->responsavelApuracao?->name ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Responsável Tratamento</span>
                    <span class="mt-1 text-gray-800">{{ $naoConformidadeAmbiental->responsavelTratamento?->name ?? '—' }}</span></div>
            </div>

            <div class="mt-6 pt-6 border-t grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach([
                    'data_identificacao' => 'Identificação',
                    'data_abertura'      => 'Abertura',
                    'prazo_tratamento'   => 'Prazo Tratamento',
                    'data_analise'       => 'Análise',
                    'data_verificacao'   => 'Verificação',
                    'data_encerramento'  => 'Encerramento',
                ] as $f => $label)
                    <div>
                        <span class="block text-sm text-gray-500">{{ $label }}</span>
                        <span class="text-gray-800">{{ optional($naoConformidadeAmbiental->$f)->format('d/m/Y') ?? '—' }}</span>
                    </div>
                @endforeach
            </div>

            @foreach([
                'descricao'                  => 'Descrição',
                'requisito_nao_atendido'     => 'Requisito não Atendido',
                'evidencia_inicial'          => 'Evidência Inicial',
                'acao_corretiva'             => 'Ação Corretiva',
                'justificativa_encerramento' => 'Justificativa de Encerramento',
            ] as $field => $label)
                @if($naoConformidadeAmbiental->$field)
                    <div class="mt-6 pt-6 border-t">
                        <span class="block text-sm text-gray-500 mb-1">{{ $label }}</span>
                        <p class="text-gray-700 whitespace-pre-line">{{ $naoConformidadeAmbiental->$field }}</p>
                    </div>
                @endif
            @endforeach

            <div class="mt-8 pt-6 border-t flex justify-between items-center">
                <div class="text-xs text-gray-400">Criado em: {{ $naoConformidadeAmbiental->created_at?->format('d/m/Y H:i') }}</div>
                <form action="{{ route('nao_conformidades_ambientais.destroy', $naoConformidadeAmbiental) }}" method="POST"
                      onsubmit="return confirm('Excluir esta não conformidade?')">
                    @csrf @method('DELETE')
                    <button class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>