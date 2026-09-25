<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-hand-holding-heart text-green-600"></i>
                Detalhes da Entrega de EPI
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('epis_usuarios.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('epis_usuarios.edit', $episUsuario) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Informações principais --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">EPI</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $episUsuario->epi->nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Usuário</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $episUsuario->usuario->name ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Quantidade</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $episUsuario->quantidade }}</span>
                </div>
            </div>

            {{-- Datas e Status --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Entrega</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $episUsuario->data_entrega ? \Carbon\Carbon::parse($episUsuario->data_entrega)->format('d/m/Y') : 'Não definida' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Vencimento</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $episUsuario->data_vencimento ? \Carbon\Carbon::parse($episUsuario->data_vencimento)->format('d/m/Y') : 'Não definida' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusColors = [
                            'Ativo' => 'bg-green-100 text-green-800',
                            'Vencido' => 'bg-red-100 text-red-800',
                            'Devolvido' => 'bg-gray-100 text-gray-800',
                        ];
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$episUsuario->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $episUsuario->status }}
                    </span>
                </div>
            </div>

            {{-- Responsável pela Entrega --}}
            <div class="mt-6 pt-6 border-t border-gray-200">
                <span class="block text-sm font-medium text-gray-500">Responsável pela Entrega</span>
                <span class="mt-1 text-lg font-semibold text-gray-800">{{ $episUsuario->responsavelEntrega->name ?? 'N/A' }}</span>
            </div>

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Registrado em: {{ $episUsuario->created_at?->format('d/m/Y H:i') }}
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('epis_usuarios.destroy', $episUsuario) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir esta entrega?')">
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