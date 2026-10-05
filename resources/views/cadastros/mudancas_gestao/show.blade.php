<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-exchange-alt text-blue-500"></i>
                Mudança: {{ $mudancaGestao->codigo }} — {{ $mudancaGestao->titulo }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('mudancas_gestao.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('mudancas_gestao.edit', $mudancaGestao) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $badge = match($mudancaGestao->status) {
            'Proposta'          => 'bg-gray-100 text-gray-800',
            'Em analise'        => 'bg-blue-100 text-blue-800',
            'Aprovada'          => 'bg-green-100 text-green-800',
            'Rejeitada'         => 'bg-red-100 text-red-800',
            'Em implementação'  => 'bg-yellow-100 text-yellow-800',
            'Concluída'         => 'bg-emerald-100 text-emerald-800',
            'Cancelada'         => 'bg-gray-200 text-gray-700',
            default             => 'bg-gray-100 text-gray-800',
        };
    @endphp

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Identificação --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-md font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-info-circle text-blue-500"></i>Identificação
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 block text-lg font-semibold">{{ $mudancaGestao->empresa->razao_social ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Código</span>
                    <span class="mt-1 block text-lg font-semibold">{{ $mudancaGestao->codigo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 block text-lg font-semibold">{{ $mudancaGestao->tipo }}</span>
                </div>
                <div class="lg:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Título</span>
                    <span class="mt-1 block text-lg font-semibold">{{ $mudancaGestao->titulo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Processo</span>
                    <span class="mt-1 block text-lg font-semibold">
                        {{ $mudancaGestao->processo->nome ?? $mudancaGestao->processo->codigo ?? '—' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $badge }}">
                        {{ $mudancaGestao->status }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data Prevista</span>
                    <span class="mt-1 block text-lg font-semibold">
                        {{ optional($mudancaGestao->data_prevista)->format('d/m/Y') ?? '—' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Implementação</span>
                    <span class="mt-1 block text-lg font-semibold">
                        {{ optional($mudancaGestao->data_implementacao)->format('d/m/Y') ?? '—' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Descrição / Justificativa --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-md font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-file-alt text-blue-500"></i>Descrição e Justificativa
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Descrição da Mudança</span>
                    <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $mudancaGestao->descricao_mudanca ?: '—' }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Justificativa</span>
                    <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $mudancaGestao->justificativa ?: '—' }}</p>
                </div>
            </div>
        </div>

        {{-- Impactos SGI --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-md font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-shield-alt text-blue-500"></i>Avaliação de Impacto do SGI
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach([
                    'impacto_qualidade'            => ['Qualidade',              'fa-award'],
                    'impacto_ambiental'            => ['Meio Ambiente',          'fa-leaf'],
                    'impacto_sso'                  => ['SSO',                    'fa-hard-hat'],
                    'impacto_seguranca_informacao' => ['Segurança da Informação','fa-lock'],
                ] as $campo => [$label, $icone])
                    <div class="p-4 rounded-md bg-gray-50 border border-gray-100">
                        <span class="block text-sm font-medium text-gray-500 flex items-center gap-2">
                            <i class="fas {{ $icone }} text-gray-400"></i>{{ $label }}
                        </span>
                        <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $mudancaGestao->{$campo} ?: '—' }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Aprovação --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-md font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <i class="fas fa-user-shield text-blue-500"></i>Fluxo de Aprovação
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Solicitante</span>
                    <span class="mt-1 block text-lg font-semibold">{{ $mudancaGestao->solicitante->name ?? '—' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável pela Aprovação</span>
                    <span class="mt-1 block text-lg font-semibold">{{ $mudancaGestao->responsavelAprovacao->name ?? '—' }}</span>
                </div>
            </div>
            @if($mudancaGestao->parecer_aprovacao)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <span class="block text-sm font-medium text-gray-500">Parecer da Aprovação</span>
                    <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $mudancaGestao->parecer_aprovacao }}</p>
                </div>
            @endif
        </div>

        <div class="flex justify-end gap-3">
            <form action="{{ route('mudancas_gestao.destroy', $mudancaGestao) }}" method="POST"
                  onsubmit="return confirm('Tem certeza que deseja excluir esta gestão de mudança?')">
                @csrf @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition shadow-sm">
                    <i class="fas fa-trash mr-2"></i>Excluir
                </button>
            </form>
        </div>
    </div>
</x-app-layout>