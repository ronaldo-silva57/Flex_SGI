<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-chart-bar text-green-500"></i> {{ $indicador->codigo }} — {{ $indicador->nome }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('indicadores_ambientais.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('indicadores_ambientais.edit', $indicador) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div><span class="block text-sm text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $indicador->codigo }}</span></div>
                <div><span class="block text-sm text-gray-500">Nome</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $indicador->nome }}</span></div>
                <div><span class="block text-sm text-gray-500">Categoria</span>
                    <span class="mt-1 inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-cyan-100 text-cyan-800">{{ $indicador->categoria }}</span></div>
                <div><span class="block text-sm text-gray-500">Meta</span>
                    <span class="mt-1 text-gray-800">{{ $indicador->meta ?? '—' }} {{ $indicador->unidade_medida }}</span></div>
                <div><span class="block text-sm text-gray-500">Tipo de Meta</span>
                    <span class="mt-1 text-gray-800">{{ $indicador->tipo_meta ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Frequência</span>
                    <span class="mt-1 text-gray-800">{{ $indicador->frequencia ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Responsável</span>
                    <span class="mt-1 text-gray-800">{{ $indicador->responsavel?->name ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Empresa</span>
                    <span class="mt-1 text-gray-800">{{ $indicador->empresa?->razao_social ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Status</span>
                    <span class="mt-1 inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $indicador->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $indicador->ativo ? 'Ativo' : 'Inativo' }}
                    </span></div>
            </div>

            @if($indicador->descricao)
                <div class="mt-6 pt-6 border-t">
                    <span class="block text-sm text-gray-500 mb-1">Descrição</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $indicador->descricao }}</p>
                </div>
            @endif
            @if($indicador->formula)
                <div class="mt-4 pt-4 border-t">
                    <span class="block text-sm text-gray-500 mb-1">Fórmula</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $indicador->formula }}</p>
                </div>
            @endif

            <div class="mt-8 pt-6 border-t flex justify-between items-center">
                <div class="text-xs text-gray-400">Criado em: {{ $indicador->created_at?->format('d/m/Y H:i') }}</div>
                <form action="{{ route('indicadores_ambientais.destroy', $indicador) }}" method="POST"
                      onsubmit="return confirm('Excluir este indicador?')">
                    @csrf @method('DELETE')
                    <button class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>