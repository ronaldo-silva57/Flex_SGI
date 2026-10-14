<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-file-alt text-indigo-500"></i> Detalhes do Relatório ESG
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('esg_relatorios.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('esg_relatorios.edit', $esgRelatorio) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Cabeçalho --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="lg:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Título</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $esgRelatorio->titulo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Framework</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-50 text-indigo-700">
                        {{ $esgRelatorio->framework }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $cor = match($esgRelatorio->status) {
                            'Rascunho'    => 'gray',
                            'Em Revisão'  => 'yellow',
                            'Auditado'    => 'blue',
                            'Publicado'   => 'green',
                            default       => 'gray',
                        };
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $cor }}-100 text-{{ $cor }}-800">
                        <i class="fas fa-circle mr-1 text-{{ $cor }}-500"></i>
                        {{ $esgRelatorio->status }}
                    </span>
                </div>
            </div>

            {{-- Metadados --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-base font-semibold text-gray-800">
                        {{ $esgRelatorio->empresa?->nome ?? '—' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-base font-semibold text-gray-800">
                        {{ $esgRelatorio->responsavel?->name ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Ano de Referência</span>
                    <span class="mt-1 text-base font-semibold text-gray-800">{{ $esgRelatorio->ano_referencia }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Publicação</span>
                    <span class="mt-1 text-base font-semibold text-gray-800">
                        {{ $esgRelatorio->data_publicacao?->format('d/m/Y') ?? 'Não publicada' }}
                    </span>
                </div>
            </div>

            {{-- Arquivo --}}
            @if($esgRelatorio->arquivo_path)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Arquivo</span>
                    <a href="{{ $esgRelatorio->arquivo_path }}" target="_blank"
                       class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm">
                        <i class="fas fa-paperclip mr-2"></i>{{ $esgRelatorio->arquivo_path }}
                    </a>
                </div>
            @endif

            {{-- Observações --}}
            @if($esgRelatorio->observacoes)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Observações</span>
                    <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                        {{ $esgRelatorio->observacoes }}
                    </div>
                </div>
            @endif

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Criado em: {{ $esgRelatorio->created_at?->format('d/m/Y H:i') }}
                    @if($esgRelatorio->updated_at && $esgRelatorio->updated_at != $esgRelatorio->created_at)
                        <br>Última atualização: {{ $esgRelatorio->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
                <div>
                    <form action="{{ route('esg_relatorios.destroy', $esgRelatorio) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este relatório?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i> Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>