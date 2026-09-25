<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-leaf text-green-500"></i> Detalhes: {{ Str::limit($aspecto->descricao, 30) }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('aspectos_ambientais.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('aspectos_ambientais.edit', $aspecto) }}"
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
                    <span class="block text-sm font-medium text-gray-500">Descrição</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $aspecto->descricao }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-cyan-100 text-cyan-800">
                        {{ $aspecto->tipo }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $aspecto->status == 'ativo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $aspecto->status == 'ativo' ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Processo</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $aspecto->processo?->nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $aspecto->responsavel?->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Significância</span>
                    <span class="mt-1 inline-flex items-center justify-center w-10 h-10 rounded-full text-lg font-bold
                        @if($aspecto->significancia >= 4) bg-red-100 text-red-700
                        @elseif($aspecto->significancia >= 3) bg-yellow-100 text-yellow-700
                        @elseif($aspecto->significancia) bg-green-100 text-green-700
                        @else bg-gray-100 text-gray-400 @endif">
                        {{ $aspecto->significancia ?? '-' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $aspecto->empresa?->razao_social ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- Impacto, Controles, Programa --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($aspecto->impacto_associado)
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Impacto Associado</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $aspecto->impacto_associado }}</p>
                </div>
                @endif

                @if($aspecto->controle_existente)
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Controle Existente</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $aspecto->controle_existente }}</p>
                </div>
                @endif
            </div>

            @if($aspecto->programa_gestao)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <span class="block text-sm font-medium text-gray-500 mb-1">Programa de Gestão</span>
                <p class="text-gray-700 whitespace-pre-line">{{ $aspecto->programa_gestao }}</p>
            </div>
            @endif

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ $aspecto->created_at?->format('d/m/Y H:i') }}
                    @if($aspecto->updated_at)
                        <br>Atualizado em: {{ $aspecto->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>

                <form action="{{ route('aspectos_ambientais.destroy', $aspecto) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este aspecto ambiental?')">
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