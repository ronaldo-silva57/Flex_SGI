<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-chart-line text-indigo-500"></i> Detalhes do Monitoramento ESG
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('esg_monitoramentos.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('esg_monitoramentos.edit', $esgMonitoramento) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Cabeçalho com indicador, período, responsável e status --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Indicador</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $esgMonitoramento->indicador->codigo }} - {{ $esgMonitoramento->indicador->nome }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Período</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ \Carbon\Carbon::parse($esgMonitoramento->periodo_referencia)->format('d/m/Y') }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $esgMonitoramento->responsavel?->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $cor = match($esgMonitoramento->status) {
                            'No prazo' => 'yellow',
                            'Atrasado' => 'red',
                            'Concluído' => 'green',
                            default => 'gray',
                        };
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $cor }}-100 text-{{ $cor }}-800">
                        <i class="fas fa-circle mr-1 text-{{ $cor }}-500"></i>
                        {{ $esgMonitoramento->status }}
                    </span>
                </div>
            </div>

            {{-- Valores --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Valor Realizado</span>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $esgMonitoramento->valor_realizado !== null ? number_format($esgMonitoramento->valor_realizado, 2, ',', '.') : 'Não informado' }}
                    </p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Meta</span>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $esgMonitoramento->valor_meta !== null ? number_format($esgMonitoramento->valor_meta, 2, ',', '.') : 'Não informada' }}
                    </p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Atingimento</span>
                    @php
                        $atingimento = null;
                        if ($esgMonitoramento->valor_realizado !== null && $esgMonitoramento->valor_meta !== null && $esgMonitoramento->valor_meta != 0) {
                            $atingimento = ($esgMonitoramento->valor_realizado / $esgMonitoramento->valor_meta) * 100;
                        }
                    @endphp
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $atingimento !== null ? number_format($atingimento, 2, ',', '.') . '%' : 'N/A' }}
                    </p>
                </div>
            </div>

            {{-- Análise --}}
            @if($esgMonitoramento->analise)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Análise / Comentários</span>
                    <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                        {{ $esgMonitoramento->analise }}
                    </div>
                </div>
            @endif

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Criado em: {{ $esgMonitoramento->created_at?->format('d/m/Y H:i') }}
                    @if($esgMonitoramento->updated_at && $esgMonitoramento->updated_at != $esgMonitoramento->created_at)
                        <br>Última atualização: {{ $esgMonitoramento->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
                <div>
                    <form action="{{ route('esg_monitoramentos.destroy', $esgMonitoramento) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este monitoramento?')">
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