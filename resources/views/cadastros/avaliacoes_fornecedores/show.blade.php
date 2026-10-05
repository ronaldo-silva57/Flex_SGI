<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-clipboard-check text-blue-500"></i>
                Avaliação: {{ $avaliacaoFornecedor->fornecedor->razao_social ?? 'N/A' }}
                <span class="text-sm text-gray-500 font-normal">
                    ({{ $avaliacaoFornecedor->periodo_referencia }})
                </span>
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('avaliacoes_fornecedores.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('avaliacoes_fornecedores.edit', $avaliacaoFornecedor) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $badge = match($avaliacaoFornecedor->status_qualificacao) {
            'Aprovado'               => 'bg-green-100 text-green-800',
            'Aprovado com Restrição' => 'bg-yellow-100 text-yellow-800',
            'Reprovado'              => 'bg-red-100 text-red-800',
            'Em observação'          => 'bg-blue-100 text-blue-800',
            default                  => 'bg-gray-100 text-gray-800',
        };
    @endphp

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        {{-- Dados gerais --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-md font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500"></i>Informações Gerais
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 block text-lg font-semibold">{{ $avaliacaoFornecedor->empresa->razao_social ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Fornecedor</span>
                    <span class="mt-1 block text-lg font-semibold">{{ $avaliacaoFornecedor->fornecedor->razao_social ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Avaliador</span>
                    <span class="mt-1 block text-lg font-semibold">{{ $avaliacaoFornecedor->avaliador->name ?? '—' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Período de Referência</span>
                    <span class="mt-1 block text-lg font-semibold">{{ $avaliacaoFornecedor->periodo_referencia }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status de Qualificação</span>
                    <span class="mt-1 inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $badge }}">
                        {{ $avaliacaoFornecedor->status_qualificacao }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Criada em</span>
                    <span class="mt-1 block text-lg font-semibold">
                        {{ optional($avaliacaoFornecedor->created_at)->format('d/m/Y H:i') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Notas --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-md font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-star text-yellow-500"></i>Notas
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 text-center">
                @foreach([
                    'Qualidade'     => $avaliacaoFornecedor->nota_qualidade,
                    'Prazo'         => $avaliacaoFornecedor->nota_prazo,
                    'Atendimento'   => $avaliacaoFornecedor->nota_atendimento,
                    'ESG Ambiental' => $avaliacaoFornecedor->nota_esg_ambiental,
                ] as $label => $valor)
                    <div class="p-4 rounded-md bg-gray-50 border border-gray-100">
                        <span class="block text-xs font-medium text-gray-500 uppercase">{{ $label }}</span>
                        <span class="mt-1 block text-2xl font-bold text-gray-800">
                            {{ $valor !== null ? number_format((float) $valor, 2, ',', '.') : '—' }}
                        </span>
                    </div>
                @endforeach
                <div class="p-4 rounded-md bg-indigo-50 border border-indigo-200">
                    <span class="block text-xs font-medium text-indigo-600 uppercase">Nota Final</span>
                    <span class="mt-1 block text-2xl font-bold text-indigo-700">
                        {{ $avaliacaoFornecedor->nota_final !== null
                            ? number_format((float) $avaliacaoFornecedor->nota_final, 2, ',', '.')
                            : '—' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Observações --}}
        @if($avaliacaoFornecedor->observacoes || $avaliacaoFornecedor->plano_acao_exigido)
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-md font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <i class="fas fa-comment-dots text-blue-500"></i>Observações e Plano de Ação
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Observações</span>
                        <p class="mt-1 text-gray-700 whitespace-pre-line">
                            {{ $avaliacaoFornecedor->observacoes ?: '—' }}
                        </p>
                    </div>
                    <div>
                        <span class="block text-sm font-medium text-gray-500">Plano de Ação Exigido</span>
                        <p class="mt-1 text-gray-700 whitespace-pre-line">
                            {{ $avaliacaoFornecedor->plano_acao_exigido ?: '—' }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex justify-end gap-3">
            <form action="{{ route('avaliacoes_fornecedores.destroy', $avaliacaoFornecedor) }}"
                  method="POST"
                  onsubmit="return confirm('Tem certeza que deseja excluir esta avaliação?')">
                @csrf @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition shadow-sm">
                    <i class="fas fa-trash mr-2"></i>Excluir
                </button>
            </form>
        </div>
    </div>
</x-app-layout>