<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-flask text-green-500"></i> {{ $produtoQuimico->nome }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('produtos_quimicos.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('produtos_quimicos.edit', $produtoQuimico) }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-50 border-l-4 border-red-400 text-red-700 rounded-md">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div><span class="block text-sm text-gray-500">Nome</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $produtoQuimico->nome }}</span></div>
                <div><span class="block text-sm text-gray-500">Fabricante</span>
                    <span class="mt-1 text-gray-800">{{ $produtoQuimico->fabricante ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Estado Físico</span>
                    <span class="mt-1 text-gray-800">{{ $produtoQuimico->estado_fisico ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Nº FISPQ</span>
                    <span class="mt-1 text-gray-800">{{ $produtoQuimico->numero_fispq ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Nº CAS</span>
                    <span class="mt-1 text-gray-800">{{ $produtoQuimico->numero_cas ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Status</span>
                    <span class="mt-1 inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">{{ $produtoQuimico->status }}</span></div>
                <div><span class="block text-sm text-gray-500">Fornecedor</span>
                    <span class="mt-1 text-gray-800">{{ $produtoQuimico->fornecedor?->razao_social ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Responsável</span>
                    <span class="mt-1 text-gray-800">{{ $produtoQuimico->responsavel?->name ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Localização</span>
                    <span class="mt-1 text-gray-800">{{ $produtoQuimico->localizacao ?? '—' }}</span></div>
                <div><span class="block text-sm text-gray-500">Estoque</span>
                    <span class="mt-1 text-gray-800">{{ $produtoQuimico->quantidade_estoque ?? '—' }} {{ $produtoQuimico->unidade_medida }}</span></div>
                <div><span class="block text-sm text-gray-500">Validade</span>
                    <span class="mt-1 text-gray-800">{{ optional($produtoQuimico->data_validade)->format('d/m/Y') ?? '—' }}</span></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-file-pdf text-red-600"></i> FISPQ / FDS
            </h3>

            @if($produtoQuimico->arquivo_fispq_path)
                <a href="{{ route('produtos_quimicos.fispq.download', $produtoQuimico) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    <i class="fas fa-download mr-2"></i>Baixar arquivo atual
                </a>
            @else
                <p class="text-gray-500 text-sm mb-3">Nenhum arquivo enviado.</p>
            @endif

            <form action="{{ route('produtos_quimicos.fispq.upload', $produtoQuimico) }}"
                  method="POST" enctype="multipart/form-data" class="mt-4 flex flex-wrap items-end gap-3">
                @csrf
                <div class="flex-1 min-w-[240px]">
                    <label class="block text-sm font-medium text-gray-700">Substituir / enviar PDF</label>
                    <input type="file" name="arquivo_fispq" accept="application/pdf"
                           class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md p-2">
                    @error('arquivo_fispq')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <button class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i class="fas fa-upload mr-2"></i>Enviar
                </button>
            </form>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-shield-alt text-amber-600"></i> Informações de Segurança
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach([
                    'composicao','perigos_ghs','palavra_advertencia','pictogramas',
                    'primeiros_socorros','combate_incendio','medidas_derramamento',
                    'manuseio_armazenamento','epi_necessario','epc_necessario'
                ] as $f)
                    @if($produtoQuimico->$f)
                        <div>
                            <span class="block text-sm font-medium text-gray-500 mb-1">{{ Str::headline($f) }}</span>
                            <p class="text-gray-700 whitespace-pre-line">{{ $produtoQuimico->$f }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm flex justify-between items-center">
            <div class="text-xs text-gray-400">Criado em: {{ $produtoQuimico->created_at?->format('d/m/Y H:i') }}</div>
            <form action="{{ route('produtos_quimicos.destroy', $produtoQuimico) }}" method="POST"
                  onsubmit="return confirm('Excluir este produto?')">
                @csrf @method('DELETE')
                <button class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    <i class="fas fa-trash mr-2"></i>Excluir
                </button>
            </form>
        </div>
    </div>
</x-app-layout>