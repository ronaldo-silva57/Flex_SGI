<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-hand-holding-heart text-indigo-500"></i> Detalhes do Projeto Social ESG
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('esg_projetos.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('esg_projetos.edit', $esgProjetoSocial) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Cabeçalho: Nome, Status, Localidade, Empresa --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Nome do Projeto</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $esgProjetoSocial->nome_projeto }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $cor = match($esgProjetoSocial->status) {
                            'Planejado'    => 'blue',
                            'Em Andamento' => 'yellow',
                            'Concluído'    => 'green',
                            'Cancelado'    => 'red',
                            default        => 'gray',
                        };
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $cor }}-100 text-{{ $cor }}-800">
                        {{ $esgProjetoSocial->status }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Localidade</span>
                    <span class="mt-1 text-gray-800">
                        <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                        {{ $esgProjetoSocial->localidade ?? '—' }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-gray-800">
                        <i class="fas fa-building text-gray-400 mr-1"></i>
                        {{ $esgProjetoSocial->empresa->razao_social ?? '—' }}
                    </span>
                </div>
            </div>

            {{-- Responsável / Período / Orçamento / Beneficiários --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-gray-800">
                        <i class="fas fa-user text-gray-400 mr-1"></i>
                        {{ $esgProjetoSocial->responsavel->name ?? '—' }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Período</span>
                    <span class="mt-1 text-gray-800">
                        <i class="fas fa-calendar-alt text-gray-400 mr-1"></i>
                        {{ $esgProjetoSocial->data_inicio?->format('d/m/Y') ?? '—' }}
                        @if($esgProjetoSocial->data_fim)
                            → {{ $esgProjetoSocial->data_fim->format('d/m/Y') }}
                        @endif
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Orçamento Investido</span>
                    <span class="mt-1 text-gray-800 font-semibold">
                        <i class="fas fa-dollar-sign text-gray-400 mr-1"></i>
                        R$ {{ number_format((float) $esgProjetoSocial->orcamento_investido, 2, ',', '.') }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Beneficiários Diretos</span>
                    <span class="mt-1 text-gray-800 font-semibold">
                        <i class="fas fa-users text-gray-400 mr-1"></i>
                        {{ number_format((int) $esgProjetoSocial->beneficiarios_diretos, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Descrição --}}
            @if($esgProjetoSocial->descricao)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Descrição</span>
                    <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                        {{ $esgProjetoSocial->descricao }}
                    </div>
                </div>
            @endif

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Criado em: {{ $esgProjetoSocial->created_at?->format('d/m/Y H:i') }}
                    @if($esgProjetoSocial->updated_at && $esgProjetoSocial->updated_at != $esgProjetoSocial->created_at)
                        <br>Última atualização: {{ $esgProjetoSocial->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
                <div>
                    <form action="{{ route('esg_projetos.destroy', $esgProjetoSocial) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este projeto social?')">
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