<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-sitemap text-blue-500"></i> Detalhes: {{ $clausula->codigo}} - {{ $clausula->titulo}}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('clausulas.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('clausulas.edit', $clausula) }}"
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
                    <span class="block text-sm font-medium text-gray-500">Item</span>
                    <span class="mt-1 text-lg font-semibold">{{ $clausula->codigo ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Título</span>
                    <span class="mt-1 text-lg font-semibold">{{ $clausula->titulo ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Norma</span>
                    <span class="mt-1 text-lg font-semibold">{{ $clausula->norma->codigo ?? 'N/A' }} – {{ $clausula->norma->nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Cláusula pai</span>
                    <span class="mt-1 text-lg font-semibold">
                        @if($clausula->clausulaPai)
                            {{ $clausula->clausulaPai->codigo }} – {{ $clausula->clausulaPai->titulo }}
                        @else
                            <span class="text-gray-400">Nenhuma</span>
                        @endif
                    </span>
                </div>
            </div>

            @if($clausula->descricao)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500">Descrição</span>
                    <p class="mt-1 text-gray-700">{{ $clausula->norma->descricao }}</p>
                </div>
            @endif

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('clausulas.destroy', $clausula) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir esta clúsula?')">
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