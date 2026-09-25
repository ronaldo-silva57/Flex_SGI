<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-project-diagram text-blue-500"></i> Detalhes: {{ $processo->nome }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('processos.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('processos.edit', $processo) }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Informações do Cabeçalho / Grid principal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $processo->codigo ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo de Processo</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $processo->tipo ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $processo->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $processo->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $processo->empresa?->razao_social ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Departamento</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $processo->departamento?->nome ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $processo->responsavel?->name ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- Descrição e Objetivo --}}
            @if($processo->descricao || $processo->objetivo)
                <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($processo->descricao)
                        <div>
                            <span class="block text-sm font-medium text-gray-500 mb-1">Descrição</span>
                            <p class="text-gray-700 whitespace-pre-line">{{ $processo->descricao }}</p>
                        </div>
                    @endif

                    @if($processo->objetivo)
                        <div>
                            <span class="block text-sm font-medium text-gray-500 mb-1">Objetivo</span>
                            <p class="text-gray-700 whitespace-pre-line">{{ $processo->objetivo }}</p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Entradas, Saídas e Indicadores Chave --}}
            @if($processo->entradas || $processo->saidas || $processo->indicadores_chave)
                <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <span class="block text-sm font-medium text-gray-500 mb-1">
                            <i class="fas fa-sign-in-alt text-green-500 mr-1"></i> Entradas (Insumos/Gatilhos)
                        </span>
                        <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                            {{ $processo->entradas ?? 'Nenhuma entrada informada.' }}
                        </div>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500 mb-1">
                            <i class="fas fa-sign-out-alt text-blue-500 mr-1"></i> Saídas (Resultados/Entregáveis)
                        </span>
                        <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                            {{ $processo->saidas ?? 'Nenhuma saída informada.' }}
                        </div>
                    </div>

                    <div>
                        <span class="block text-sm font-medium text-gray-500 mb-1">
                            <i class="fas fa-chart-line text-indigo-500 mr-1"></i> Indicadores Chave (Texto)
                        </span>
                        <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                            {{ $processo->indicadores_chave ?? 'Nenhum indicador chave informado.' }}
                        </div>
                    </div>
                </div>
            @endif

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ $processo->created_at?->format('d/m/Y H:i') }}
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('processos.destroy', $processo) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este processo?')">
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