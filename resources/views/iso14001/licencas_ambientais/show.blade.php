<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-file-contract text-green-600"></i> Licença: {{ $licenca->numero }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('licencas_ambientais.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md border border-blue-200 hover:bg-blue-100">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('licencas_ambientais.edit', $licenca) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    <i class="fas fa-edit mr-2"></i>Editar Licença
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        {{-- Detalhes da Licença --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm text-gray-500 font-medium">Número da Licença</span>
                    <span class="text-lg font-semibold text-gray-800">{{ $licenca->numero }}</span>
                </div>
                <div>
                    <span class="block text-sm text-gray-500 font-medium">Tipo</span>
                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">{{ $licenca->tipo }}</span>
                </div>
                <div>
                    <span class="block text-sm text-gray-500 font-medium">Órgão Emissor</span>
                    <span class="text-lg font-semibold text-gray-800">{{ $licenca->orgao_emissor }}</span>
                </div>
                <div>
                    <span class="block text-sm text-gray-500 font-medium">Data de Emissão</span>
                    <span class="text-gray-800 font-semibold">{{ $licenca->data_emissao?->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="block text-sm text-gray-500 font-medium">Data de Validade</span>
                    <span class="text-gray-800 font-semibold">{{ $licenca->data_validade?->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="block text-sm text-gray-500 font-medium">Data para Renovação</span>
                    <span class="text-gray-800 font-semibold">{{ $licenca->data_renovacao?->format('d/m/Y') ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm text-gray-500 font-medium">Status</span>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">{{ $licenca->status }}</span>
                </div>
                <div>
                    <span class="block text-sm text-gray-500 font-medium">Responsável</span>
                    <span class="text-gray-800 font-semibold">{{ $licenca->responsavel?->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm text-gray-500 font-medium">Empresa</span>
                    <span class="text-gray-800 font-semibold">{{ $licenca->empresa?->razao_social ?? 'N/A' }}</span>
                </div>
            </div>

            @if($licenca->descricao)
                <div class="mt-6 border-t pt-4">
                    <span class="block text-sm font-medium text-gray-500">Descrição / Escopo</span>
                    <p class="text-gray-700 whitespace-pre-line mt-1">{{ $licenca->descricao }}</p>
                </div>
            @endif

            @if($licenca->condicionantes)
                <div class="mt-4 border-t pt-4">
                    <span class="block text-sm font-medium text-gray-500">Condicionantes</span>
                    <p class="text-gray-700 whitespace-pre-line mt-1">{{ $licenca->condicionantes }}</p>
                </div>
            @endif
        </div>

        {{-- Seção de Anexo PDF --}}
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 flex items-center gap-2">
                <i class="fas fa-file-pdf text-red-600"></i> Documento Anexo
            </h3>

            @if($licenca->arquivo_path)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-md border border-gray-200 mb-4">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-pdf text-red-500 text-3xl"></i>
                        <div>
                            <span class="font-semibold block text-gray-800">Arquivo da Licença (.pdf)</span>
                            <span class="text-xs text-gray-500">Documento anexado e disponível para download</span>
                        </div>
                    </div>
                    <a href="{{ route('licencas_ambientais.download', $licenca) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">
                        <i class="fas fa-download mr-1"></i> Baixar PDF
                    </a>
                </div>
            @else
                <p class="text-sm text-gray-500 mb-4">Nenhum documento PDF foi anexado a esta licença ainda.</p>
            @endif

            <form action="{{ route('licencas_ambientais.upload', $licenca) }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-4">
                @csrf
                <input type="file" name="arquivo" accept=".pdf" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm whitespace-nowrap">
                    <i class="fas fa-upload mr-1"></i> PDF
                </button>
            </form>
            @error('arquivo') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
        </div>
    </div>
</x-app-layout>