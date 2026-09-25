<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-recycle text-green-600"></i> Detalhes: {{ Str::limit($residuo->descricao, 30) }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('gestao_residuos.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('gestao_residuos.edit', $residuo) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Grid principal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $residuo->codigo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Descrição</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $residuo->descricao }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Classe</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                        {{ $residuo->classe ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-cyan-100 text-cyan-800">
                        {{ $residuo->tipo }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Fonte Geradora</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $residuo->fonte_geradora ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Quantidade Gerada</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $residuo->quantidade_gerada ? $residuo->quantidade_gerada.' '.$residuo->unidade_medida : 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Frequência de Geração</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $residuo->frequencia_geracao ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Destino Final</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $residuo->destino_final ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Transportador</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $residuo->transportador ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Destinador</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $residuo->destinador ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Número MTR</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $residuo->numero_mtr ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $residuo->status == 'Ativo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $residuo->status }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Processo</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $residuo->processo?->nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $residuo->responsavel?->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $residuo->empresa?->razao_social ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- Observações e Forma de Armazenamento --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($residuo->forma_armazenamento)
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Forma de Armazenamento</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $residuo->forma_armazenamento }}</p>
                </div>
                @endif

                @if($residuo->observacoes)
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Observações</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $residuo->observacoes }}</p>
                </div>
                @endif
            </div>

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ $residuo->created_at?->format('d/m/Y H:i') }}
                    @if($residuo->updated_at)
                        <br>Atualizado em: {{ $residuo->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>

                <form action="{{ route('gestao_residuos.destroy', $residuo) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este registro de resíduo?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i> Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
