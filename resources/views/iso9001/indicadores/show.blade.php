<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-sitemap text-blue-500"></i> Detalhes: {{ $indicador->nome }}
            </h2>
            <div>
                <a href="{{ route('indicadores.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('indicadores.edit', $indicador) }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold">{{ $indicador->codigo ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Processo</span>
                    <span class="mt-1 text-lg font-semibold">{{ $indicador->processo->nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Norma</span>
                    <span class="mt-1 text-lg font-semibold">{{ $indicador->norma->nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold">{{ $indicador->responsavel->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Meta</span>
                    <span class="mt-1 text-lg font-semibold">{{ $indicador->meta ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo de Meta</span>
                    <span class="mt-1 text-lg font-semibold">{{ $indicador->tipo_meta ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Unidade de Medida</span>
                    <span class="mt-1 text-lg font-semibold">{{ $indicador->unidade_medida ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Frequência</span>
                    <span class="mt-1 text-lg font-semibold">{{ $indicador->frequencia ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $indicador->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $indicador->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>
            </div>

            @if($indicador->descricao)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500">Descrição</span>
                    <p class="mt-1 text-gray-700">{{ $indicador->descricao }}</p>
                </div>
            @endif

            <div class="mt-6 flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <a href="{{ route('indicadores.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar
                </a>
                <form action="{{ route('indicadores.destroy', $indicador) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este indicador?')">
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