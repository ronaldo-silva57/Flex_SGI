<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-calendar-day text-blue-500 mr-2"></i>Detalhes do Evento: {{ $evento->titulo }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('calendario.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('calendario.edit', $evento) }}"
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
                    <span class="block text-sm font-medium text-gray-500">Categoria</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $evento->categoria }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Início</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ optional($evento->data_inicio)->format('d/m/Y H:i') }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $evento->status }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $evento->empresa?->razao_social ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-base text-gray-800">{{ $evento->responsavel?->name ?? 'Não atribuído' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Término</span>
                    <span class="mt-1 text-base text-gray-800">{{ optional($evento->data_fim)->format('d/m/Y H:i') ?? 'N/A' }}</span>
                </div>
            </div>

            @if ($evento->descricao)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Descrição / Detalhes</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $evento->descricao }}</p>
                </div>
            @endif

            <div class="mt-8 pt-6 border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ optional($evento->created_at)->format('d/m/Y H:i') }}
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('calendario.destroy', $evento) }}" method="POST"
                        onsubmit="return confirm('Tem certeza que deseja excluir este evento?')">
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