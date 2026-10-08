<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-shield-alt text-indigo-600"></i> Detalhes do Risco: {{ Str::limit($analisesRiscoTi->ameaca, 30) }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('analises_risco_ti.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('analises_risco_ti.edit', $analisesRiscoTi) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Ativo de Informação</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $analisesRiscoTi->ativo?->nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Ameaça</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $analisesRiscoTi->ameaca }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Vulnerabilidade</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $analisesRiscoTi->vulnerabilidade }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Pilares Afetados</span>
                    <div class="mt-1 flex gap-2">
                        @if($analisesRiscoTi->afeta_confidencialidade) <span class="px-2 py-0.5 text-xs font-bold bg-indigo-100 text-indigo-800 rounded">Confidencialidade</span> @endif
                        @if($analisesRiscoTi->afeta_integridade) <span class="px-2 py-0.5 text-xs font-bold bg-indigo-100 text-indigo-800 rounded">Integridade</span> @endif
                        @if($analisesRiscoTi->afeta_disponibilidade) <span class="px-2 py-0.5 text-xs font-bold bg-indigo-100 text-indigo-800 rounded">Disponibilidade</span> @endif
                    </div>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Risco Inerente</span>
                    @php $score = $analisesRiscoTi->nivel_risco_inerente ?? ($analisesRiscoTi->probabilidade * $analisesRiscoTi->impacto); @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-bold {{ $score >= 15 ? 'bg-red-100 text-red-800' : ($score >= 8 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                        Nível {{ $score }} (P: {{ $analisesRiscoTi->probabilidade }} x I: {{ $analisesRiscoTi->impacto }})
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                        {{ $analisesRiscoTi->status }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Opção de Tratamento</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $analisesRiscoTi->opcao_tratamento }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Risco Residual</span>
                    @if($analisesRiscoTi->nivel_risco_residual)
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">
                            Nível {{ $analisesRiscoTi->nivel_risco_residual }}
                        </span>
                    @else
                        <span class="mt-1 text-gray-500">Não avaliado</span>
                    @endif
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $analisesRiscoTi->responsavel?->name ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($analisesRiscoTi->controles_existentes)
                    <div>
                        <span class="block text-sm font-medium text-gray-500 mb-1">Controles Existentes</span>
                        <p class="text-gray-700 whitespace-pre-line">{{ $analisesRiscoTi->controles_existentes }}</p>
                    </div>
                @endif

                @if($analisesRiscoTi->plano_tratamento)
                    <div>
                        <span class="block text-sm font-medium text-gray-500 mb-1">Plano de Tratamento</span>
                        <p class="text-gray-700 whitespace-pre-line">{{ $analisesRiscoTi->plano_tratamento }}</p>
                    </div>
                @endif
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ $analisesRiscoTi->created_at?->format('d/m/Y H:i') }}
                    @if($analisesRiscoTi->updated_at)
                        <br>Atualizado em: {{ $analisesRiscoTi->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>

                <form action="{{ route('analises_risco_ti.destroy', $analisesRiscoTi) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i> Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>