<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                @if($riscos_oportunidade->tipo === 'Risco')
                    <i class="fas fa-exclamation-triangle text-amber-500"></i> Detalhes do Risco
                @else
                    <i class="fas fa-lightbulb text-emerald-500"></i> Detalhes da Oportunidade
                @endif
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('riscos_oportunidades.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('riscos_oportunidades.edit', $riscos_oportunidade) }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            
            {{-- Tipo, Status e Responsável --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $riscos_oportunidade->tipo === 'Risco' ? 'bg-red-100 text-red-800' : 'bg-emerald-100 text-emerald-800' }}">
                        {{ $riscos_oportunidade->tipo }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusClasses = [
                            'Aberto' => 'bg-yellow-100 text-yellow-800',
                            'Em andamento' => 'bg-blue-100 text-blue-800',
                            'Concluído' => 'bg-green-100 text-green-800',
                            'Cancelado' => 'bg-gray-100 text-gray-800',
                        ];
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClasses[$riscos_oportunidade->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $riscos_oportunidade->status }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Processo Vinculado</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $riscos_oportunidade->processo?->nome ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $riscos_oportunidade->responsavel?->name ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- Matriz de Avaliação (Probabilidade, Impacto e Nível) --}}
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Avaliação e Matriz de Risco</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
                    <div class="p-3 bg-white rounded border border-gray-100 shadow-sm">
                        <span class="block text-xs text-gray-500 uppercase">Probabilidade (1 a 5)</span>
                        <span class="text-2xl font-bold text-gray-800">{{ $riscos_oportunidade->probabilidade ?? '-' }}</span>
                    </div>

                    <div class="p-3 bg-white rounded border border-gray-100 shadow-sm">
                        <span class="block text-xs text-gray-500 uppercase">Impacto (1 a 5)</span>
                        <span class="text-2xl font-bold text-gray-800">{{ $riscos_oportunidade->impacto ?? '-' }}</span>
                    </div>

                    <div class="p-3 bg-white rounded border border-gray-100 shadow-sm">
                        <span class="block text-xs text-gray-500 uppercase">Nível de Risco</span>
                        @php
                            $nivel = $riscos_oportunidade->nivel_risco;
                            $corNivel = 'text-gray-800';
                            if ($nivel >= 15) $corNivel = 'text-red-600';
                            elseif ($nivel >= 8) $corNivel = 'text-amber-600';
                            elseif ($nivel) $corNivel = 'text-green-600';
                        @endphp
                        <span class="text-2xl font-bold {{ $corNivel }}">{{ $nivel ?? '-' }}</span>
                    </div>

                    <div class="p-3 bg-white rounded border border-gray-100 shadow-sm">
                        <span class="block text-xs text-gray-500 uppercase">Tratamento</span>
                        <span class="text-lg font-semibold text-gray-800 block mt-1">{{ $riscos_oportunidade->tratamento ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            {{-- Descrição, Causa e Consequência --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Descrição</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $riscos_oportunidade->descricao }}</p>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Causa</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $riscos_oportunidade->causa ?? 'Não informada.' }}</p>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Consequência</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $riscos_oportunidade->consequencia ?? 'Não informada.' }}</p>
                </div>
            </div>

            {{-- Plano de Ação, Prazo e Evidências --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500 mb-1">
                        <i class="fas fa-tasks text-indigo-500 mr-1"></i> Plano de Ação
                    </span>
                    <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                        {{ $riscos_oportunidade->plano_acao ?? 'Nenhum plano de ação registrado.' }}
                    </div>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">
                        <i class="far fa-calendar-alt text-gray-500 mr-1"></i> Prazo de Conclusão
                    </span>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $riscos_oportunidade->prazo ? \Carbon\Carbon::parse($riscos_oportunidade->prazo)->format('d/m/Y') : 'Sem prazo definido' }}
                    </p>
                </div>
            </div>

            @if($riscos_oportunidade->evidencia)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">
                        <i class="fas fa-paperclip text-gray-500 mr-1"></i> Evidências / Observações
                    </span>
                    <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                        {{ $riscos_oportunidade->evidencia }}
                    </div>
                </div>
            @endif

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ $riscos_oportunidade->created_at?->format('d/m/Y H:i') }}
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('riscos_oportunidades.destroy', $riscos_oportunidade) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este registro?')">
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