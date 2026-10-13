<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-bullhorn text-blue-500 mr-2"></i>Detalhes da Comunicação: {{ $comunicacao->titulo }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('comunicacoes.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('comunicacoes.edit', $comunicacao) }}"
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
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $comunicacao->tipo }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $comunicacao->ativo ? 'Ativo' : 'Inativo' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Autor</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $comunicacao->autor?->name ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $comunicacao->empresa?->razao_social ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Publicado Em</span>
                    <span class="mt-1 text-base text-gray-800">{{ optional($comunicacao->publicado_em)->format('d/m/Y H:i') ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Expirado Em</span>
                    <span class="mt-1 text-base text-gray-800">{{ optional($comunicacao->expirado_em)->format('d/m/Y H:i') ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Exige Ciência?</span>
                    <span class="mt-1 text-base text-gray-800 font-medium">{{ $comunicacao->exige_ciencia ? 'Sim' : 'Não' }}</span>
                </div>
            </div>

            @if ($comunicacao->conteundo)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Conteúdo</span>
                    <p class="text-gray-700 whitespace-pre-line bg-gray-50 p-4 rounded-md border border-gray-100">{{ $comunicacao->conteundo }}</p>
                </div>
            @endif

            {{-- Área de Ciência/Leitura caso o usuário queira registrar leitura direto na tela show --}}
            @if($comunicacao->exige_ciencia)
                <div class="mt-6 pt-6 border-t border-gray-200 flex items-center justify-between bg-blue-50 p-4 rounded-md">
                    <div>
                        <h4 class="text-sm font-semibold text-blue-900">Confirmação de Leitura</h4>
                        <p class="text-xs text-blue-700">Esta comunicação exige confirmação de ciência por parte dos colaboradores.</p>
                    </div>
                    <form action="{{ route('comunicacoes.ler', $comunicacao) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-xs font-semibold rounded hover:bg-blue-700 transition">
                            <i class="fas fa-check mr-1.5"></i> Dar Ciência / Marcar como Lido
                        </button>
                    </form>
                </div>
            @endif

            <div class="mt-8 pt-6 border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ optional($comunicacao->created_at)->format('d/m/Y H:i') }}
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('comunicacoes.destroy', $comunicacao) }}" method="POST"
                        onsubmit="return confirm('Tem certeza que deseja excluir esta comunicação?')">
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