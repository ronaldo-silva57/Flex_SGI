<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-graduation-cap text-blue-500"></i> Detalhes: {{ $treinamento->titulo }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('treinamentos.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('treinamentos.edit', $treinamento) }}" 
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold">{{ $treinamento->empresa->razao_social ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold">{{ $treinamento->responsavel->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 text-lg font-semibold">{{ $treinamento->tipo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Carga Horária</span>
                    <span class="mt-1 text-lg font-semibold">{{ $treinamento->carga_horaria ? $treinamento->carga_horaria . 'h' : 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Validade</span>
                    <span class="mt-1 text-lg font-semibold">{{ $treinamento->validade_meses ? $treinamento->validade_meses . ' meses' : 'Sem expiração' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $treinamento->status === 'Ativo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $treinamento->status }}
                    </span>
                </div>
            </div>

            @if($treinamento->descricao)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500">Descrição</span>
                    <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $treinamento->descricao }}</p>
                </div>
            @endif

            @if($treinamento->conteudo)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500">Conteúdo Programático</span>
                    <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $treinamento->conteudo }}</p>
                </div>
            @endif

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('treinamentos.destroy', $treinamento) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este treinamento?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i> Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>



</x-app-layout>