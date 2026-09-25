<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-eye text-blue-500"></i>Detalhes do Documento
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('documentos.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('documentos.edit', $documento) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->codigo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Título</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->titulo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold">
                        {{ $documento->empresa->nome_fantasia ?? $documento->empresa->razao_social ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Processo</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->processo->nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Norma</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->norma->codigo ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->responsavel->name ?? 'Não definido' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 text-lg font-semibold">
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $documento->tipo }}
                        </span>
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Versão</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->versao }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusClasses = [
                            'Rascunho' => 'bg-gray-100 text-gray-800',
                            'Em revisão' => 'bg-yellow-100 text-yellow-800',
                            'Aprovado' => 'bg-green-100 text-green-800',
                            'Obsoleto' => 'bg-red-100 text-red-800',
                        ][$documento->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClasses }}">
                        {{ $documento->status }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Aprovação</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->data_aprovacao ? $documento->data_aprovacao->format('d/m/Y') : '---' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Revisão</span>
                    <span class="mt-1 text-lg font-semibold">{{ $documento->data_revisao ? $documento->data_revisao->format('d/m/Y') : '---' }}</span>
                </div>
                @if($documento->arquivo_path)
                    <div class="md:col-span-2">
                        <span class="block text-sm font-medium text-gray-500">Arquivo</span>
                        <a href="{{ asset('storage/' . $documento->arquivo_path) }}" target="_blank"
                           class="mt-1 text-blue-600 hover:underline inline-flex items-center gap-2">
                            <i class="fas fa-file-download"></i> Baixar arquivo
                        </a>
                    </div>
                @endif
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Conteúdo</span>
                    <p class="mt-1 text-gray-800">{{ $documento->conteudo ?? 'Não informado' }}</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('documentos.destroy', $documento) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este documento?')">
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