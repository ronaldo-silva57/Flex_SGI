<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-user-tie text-blue-500"></i> Detalhes: {{ $cliente->nome }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('clientes.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('clientes.edit', $cliente) }}"
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
                    <span class="mt-1 text-lg font-semibold">{{ $cliente->empresa->razao_social ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Nome</span>
                    <span class="mt-1 text-lg font-semibold">{{ $cliente->nome }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Razão Social</span>
                    <span class="mt-1 text-lg font-semibold">{{ $cliente->razao_social ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo de Documento</span>
                    <span class="mt-1 text-lg font-semibold uppercase">{{ $cliente->tipo_documento ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Documento</span>
                    <span class="mt-1 text-lg font-semibold">{{ $cliente->documento ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Contato Principal</span>
                    <span class="mt-1 text-lg font-semibold">{{ $cliente->contato_principal ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">E-mail</span>
                    <span class="mt-1">
                        @if($cliente->email)
                            <a href="mailto:{{ $cliente->email }}" class="text-blue-600 hover:underline">
                                {{ $cliente->email }}
                            </a>
                        @else
                            <span class="text-gray-500">N/A</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Telefone</span>
                    <span class="mt-1">
                        @if($cliente->telefone)
                            <a href="tel:{{ $cliente->telefone }}" class="text-blue-600 hover:underline">
                                {{ $cliente->telefone }}
                            </a>
                        @else
                            <span class="text-gray-500">N/A</span>
                        @endif
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Cidade / Estado</span>
                    <span class="mt-1 text-lg font-semibold">
                        {{ $cliente->cidade ?? 'N/A' }}{{ $cliente->estado ? ' / ' . strtoupper($cliente->estado) : '' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                        @if($cliente->status === 'ativo') bg-green-100 text-green-800
                        @elseif($cliente->status === 'inativo') bg-gray-200 text-gray-700
                        @else bg-red-100 text-red-800 @endif">
                        @if($cliente->status === 'ativo')
                            <i class="fas fa-check-circle mr-1"></i> Ativo
                        @elseif($cliente->status === 'inativo')
                            <i class="fas fa-minus-circle mr-1"></i> Inativo
                        @else
                            <i class="fas fa-ban mr-1"></i> Bloqueado SGI
                        @endif
                    </span>
                </div>
            </div>

            @if($cliente->endereco_completo)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500">Endereço Completo</span>
                    <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $cliente->endereco_completo }}</p>
                </div>
            @endif

            @if($cliente->observacoes_compliance)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500">Observações de Compliance</span>
                    <p class="mt-1 text-gray-700 whitespace-pre-line">{{ $cliente->observacoes_compliance }}</p>
                </div>
            @endif

            <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-100 text-sm text-gray-500">
                <div class="flex gap-6">
                    <span><i class="fas fa-calendar-plus mr-1"></i> Criado em: {{ $cliente->created_at?->format('d/m/Y H:i') }}</span>
                    <span><i class="fas fa-calendar-check mr-1"></i> Atualizado em: {{ $cliente->updated_at?->format('d/m/Y H:i') }}</span>
                </div>
                <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
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