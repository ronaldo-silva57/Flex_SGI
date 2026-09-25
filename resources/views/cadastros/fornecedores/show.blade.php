<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-truck text-blue-500"></i> Detalhes: {{ $fornecedor->razao_social }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('fornecedores.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('fornecedores.edit', $fornecedor) }}" 
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
                    <span class="mt-1 text-lg font-semibold">{{ $fornecedor->empresa->razao_social ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Razão Social</span>
                    <span class="mt-1 text-lg font-semibold">{{ $fornecedor->razao_social }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Nome Fantasia</span>
                    <span class="mt-1 text-lg font-semibold">{{ $fornecedor->nome_fantasia ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">CNPJ</span>
                    <span class="mt-1 text-lg font-semibold">{{ $fornecedor->cnpj ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Nome do Contato</span>
                    <span class="mt-1 text-lg font-semibold">{{ $fornecedor->contato_nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">E-mail do Contato</span>
                    <span class="mt-1">
                        @if($fornecedor->contato_email)
                            <a href="mailto:{{ $fornecedor->contato_email }}" class="text-blue-600 hover:underline">
                                {{ $fornecedor->contato_email }}
                            </a>
                        @else
                            <span class="text-gray-500">N/A</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Telefone do Contato</span>
                    <span class="mt-1">
                        @if($fornecedor->contato_telefone)
                            <a href="tel:{{ $fornecedor->contato_telefone }}" class="text-blue-600 hover:underline">
                                {{ $fornecedor->contato_telefone }}
                            </a>
                        @else
                            <span class="text-gray-500">N/A</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Categoria</span>
                    <span class="mt-1 text-lg font-semibold">{{ $fornecedor->categoria ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Avaliação de Risco</span>
                    <span class="mt-1 text-lg font-semibold">
                        @if($fornecedor->avaliacao_risco)
                            {{ $fornecedor->avaliacao_risco }} / 5
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $fornecedor->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $fornecedor->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>
            </div>

            @if($fornecedor->endereco)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500">Endereço</span>
                    <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $fornecedor->endereco }}</p>
                </div>
            @endif

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('fornecedores.destroy', $fornecedor) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este fornecedor?')">
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