<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-user-circle text-blue-500"></i> Detalhes do Stakeholder
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('stakeholders.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('stakeholders.edit', $stakeholder) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Cabeçalho --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Nome</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $stakeholder->nome }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    @php
                        $cor = match($stakeholder->tipo) {
                            'Cliente' => 'blue',
                            'Colaborador' => 'green',
                            'Fornecedor' => 'yellow',
                            'Comunidade' => 'purple',
                            'Investidor' => 'indigo',
                            'Governo' => 'red',
                            default => 'gray',
                        };
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $cor }}-100 text-{{ $cor }}-800">
                        {{ $stakeholder->tipo }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Prioridade</span>
                    @if($stakeholder->prioridade)
                        @php
                            $cores = ['gray', 'yellow', 'orange', 'red', 'red'];
                            $labels = ['Muito Baixa', 'Baixa', 'Média', 'Alta', 'Muito Alta'];
                            $idx = $stakeholder->prioridade - 1;
                        @endphp
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $cores[$idx] }}-100 text-{{ $cores[$idx] }}-800">
                            {{ $stakeholder->prioridade }} - {{ $labels[$idx] }}
                        </span>
                    @else
                        <span class="text-gray-400">N/A</span>
                    @endif
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @if($stakeholder->ativo)
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Ativo
                        </span>
                    @else
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">
                            <i class="fas fa-times-circle mr-1"></i> Inativo
                        </span>
                    @endif
                </div>
            </div>

            {{-- Contato --}}
            @if($stakeholder->contato)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Contato</span>
                    <p class="text-gray-700">{{ $stakeholder->contato }}</p>
                </div>
            @endif

            {{-- Expectativas --}}
            @if($stakeholder->expectativas)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Expectativas</span>
                    <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                        {{ $stakeholder->expectativas }}
                    </div>
                </div>
            @endif

            {{-- Necessidades --}}
            @if($stakeholder->necessidades)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Necessidades</span>
                    <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                        {{ $stakeholder->necessidades }}
                    </div>
                </div>
            @endif

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Criado em: {{ $stakeholder->created_at?->format('d/m/Y H:i') }}
                    @if($stakeholder->updated_at && $stakeholder->updated_at != $stakeholder->created_at)
                        <br>Última atualização: {{ $stakeholder->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
                <div>
                    <form action="{{ route('stakeholders.destroy', $stakeholder) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este stakeholder?')">
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