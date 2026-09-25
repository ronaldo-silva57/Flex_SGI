<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-user-graduate text-blue-500"></i>
                Detalhes da Participação
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('treinamentos_usuarios.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('treinamentos_usuarios.edit', $participacao) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Treinamento</span>
                    <span class="mt-1 text-lg font-semibold">{{ $participacao->treinamento->titulo ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Usuário</span>
                    <span class="mt-1 text-lg font-semibold">{{ $participacao->usuario->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Conclusão</span>
                    <span class="mt-1 text-lg font-semibold">{{ $participacao->data_conclusao?->format('d/m/Y') ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Válido até</span>
                    <span class="mt-1 text-lg font-semibold {{ $participacao->esta_vencido ? 'text-red-600' : '' }}">
                        {{ $participacao->validade_ate?->format('d/m/Y') ?? 'Sem expiração' }}
                        @if($participacao->esta_vencido) <i class="fas fa-exclamation-triangle ml-1"></i> @endif
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Nota</span>
                    <span class="mt-1 text-lg font-semibold">
                        {{ $participacao->nota !== null ? number_format($participacao->nota, 2, ',', '.') : 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $participacao->status_badge }}">
                        {{ $participacao->status }}
                    </span>
                </div>
            </div>

            @if($participacao->certificado_path)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500">Certificado</span>
                    <a href="{{ Storage::disk('public')->url($participacao->certificado_path) }}"
                       target="_blank"
                       class="mt-1 inline-flex items-center text-indigo-600 hover:underline">
                        <i class="fas fa-file-pdf mr-2"></i> Visualizar Certificado
                    </a>
                </div>
            @endif

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('treinamentos_usuarios.destroy', $participacao) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir esta participação?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i> Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>