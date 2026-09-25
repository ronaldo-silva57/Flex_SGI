<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-gavel text-blue-500"></i> Detalhes: {{ $registro->numero ?? 'Registro Legal' }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('registros_legais.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('registros_legais.edit', $registro) }}"
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
                    <span class="block text-sm font-medium text-gray-500">Número</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $registro->numero ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Órgão</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $registro->orgao ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                        {{ $registro->tipo }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                        @if($registro->status == 'Vigente') bg-green-100 text-green-800
                        @elseif($registro->status == 'Revogado') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ $registro->status }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Publicação</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $registro->data_publicacao ? $registro->data_publicacao->format('d/m/Y') : 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Vigência</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $registro->data_vigencia ? $registro->data_vigencia->format('d/m/Y') : 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $registro->empresa?->razao_social ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Norma Associada</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $registro->norma ? $registro->norma->codigo . ' - ' . $registro->norma->nome : 'N/A' }}
                    </span>
                </div>
                @if($registro->arquivo_path)
                <div>
                    <span class="block text-sm font-medium text-gray-500">Arquivo</span>
                    <a href="{{ $registro->arquivo_path }}" target="_blank" class="mt-1 text-blue-600 hover:underline">
                        <i class="fas fa-file-pdf mr-1"></i> Visualizar
                    </a>
                </div>
                @endif
            </div>

            {{-- Descrição --}}
            @if($registro->descricao)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <span class="block text-sm font-medium text-gray-500 mb-1">Descrição</span>
                <p class="text-gray-700 whitespace-pre-line">{{ $registro->descricao }}</p>
            </div>
            @endif

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ $registro->created_at?->format('d/m/Y H:i') }}
                    @if($registro->updated_at)
                        <br>Atualizado em: {{ $registro->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>

                <form action="{{ route('registros_legais.destroy', $registro) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este registro legal?')">
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