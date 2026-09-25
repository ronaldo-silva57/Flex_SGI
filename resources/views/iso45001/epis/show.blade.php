<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-hard-hat text-blue-600"></i>
                Detalhes do EPI: {{ $epi->nome }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('epis.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('epis.edit', $epi) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Dados do EPI --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Nome</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $epi->nome }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Categoria</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $epi->categoria ?? 'Não definida' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">CA</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $epi->ca ?? 'Não informado' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Validade (meses)</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $epi->validade_meses ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- Descrição --}}
            <div class="mt-6 pt-6 border-t border-gray-200">
                <span class="block text-sm font-medium text-gray-500 mb-1">Descrição</span>
                <p class="text-gray-700 whitespace-pre-line">{{ $epi->descricao ?? 'Nenhuma descrição fornecida.' }}</p>
            </div>

            {{-- Estoque --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Estoque Atual</span>
                    <span class="text-2xl font-bold text-gray-800">{{ $epi->estoque_atual }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Estoque Mínimo</span>
                    <span class="text-2xl font-bold text-gray-800">{{ $epi->estoque_minimo ?? 'Não definido' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @if($epi->ativo)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-1"></i> Ativo
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                            <i class="fas fa-times-circle mr-1"></i> Inativo
                        </span>
                    @endif
                </div>
            </div>

            {{-- Entregas vinculadas --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-users text-blue-600"></i> Entregas para Usuários
                </h3>

                @if($epi->usuarios->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuário</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantidade</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Data Entrega</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vencimento</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Responsável</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($epi->usuarios as $entrega)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $entrega->usuario->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $entrega->quantidade }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $entrega->data_entrega ? \Carbon\Carbon::parse($entrega->data_entrega)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $entrega->data_vencimento ? \Carbon\Carbon::parse($entrega->data_vencimento)->format('d/m/Y') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusColors = [
                                                    'Ativo' => 'bg-green-100 text-green-800',
                                                    'Vencido' => 'bg-red-100 text-red-800',
                                                    'Devolvido' => 'bg-gray-100 text-gray-800',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$entrega->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $entrega->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $entrega->responsavelEntrega->name ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">Nenhuma entrega registrada para este EPI.</p>
                @endif
            </div>

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ $epi->created_at?->format('d/m/Y H:i') }}
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('epis.destroy', $epi) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este EPI?')">
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