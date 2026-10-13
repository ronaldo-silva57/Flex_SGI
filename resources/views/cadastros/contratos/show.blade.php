<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-file-contract text-blue-500 mr-2"></i>Detalhes do Contrato: {{ $contrato->numero_contrato }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('contratos.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('contratos.edit', $contrato) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Número</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $contrato->numero_contrato }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $contrato->tipo }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $contrato->status }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Valor Total</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $contrato->valor_total ? 'R$ ' . number_format($contrato->valor_total, 2, ',', '.') : 'N/A' }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Título</span>
                    <span class="mt-1 text-base text-gray-800 font-medium">{{ $contrato->titulo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Vigência</span>
                    <span class="mt-1 text-base text-gray-800">
                        {{ optional($contrato->data_inicio)->format('d/m/Y') }} até {{ optional($contrato->data_fim)->format('d/m/Y') }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-base text-gray-800">{{ $contrato->empresa?->razao_social ?? 'N/A' }}</span>
                </div>
            </div>

            @if ($contrato->objeto)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Objeto do Contrato</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $contrato->objeto }}</p>
                </div>
            @endif

            @if ($contrato->observacoes)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Observações</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $contrato->observacoes }}</p>
                </div>
            @endif

            <div class="mt-8 pt-6 border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ optional($contrato->created_at)->format('d/m/Y H:i') }}
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('contratos.destroy', $contrato) }}" method="POST"
                        onsubmit="return confirm('Tem certeza que deseja excluir este contrato?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i>Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>