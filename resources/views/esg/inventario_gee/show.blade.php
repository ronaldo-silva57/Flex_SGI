<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-smog text-purple-500"></i> Detalhes do Registro de Inventário GEE
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('inventario_gee.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('inventario_gee.edit', $inventarioGee) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Cabeçalho --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $inventarioGee->codigo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Ano de Referência</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $inventarioGee->ano_referencia }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $inventarioGee->responsavel?->name ?? 'Não atribuído' }}
                    </span>
                </div>
            </div>

            {{-- Classificação --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Escopo (GHG Protocol)</span>
                    @php
                        $coresEscopo = ['1' => 'red', '2' => 'orange', '3' => 'blue'];
                        $corEsc = $coresEscopo[$inventarioGee->escopo] ?? 'gray';
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $corEsc }}-100 text-{{ $corEsc }}-800">
                        Escopo {{ $inventarioGee->escopo }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Categoria</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $inventarioGee->categoria ?: '—' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $coresStatus = [
                            'Rascunho'   => 'gray',
                            'Em revisão' => 'yellow',
                            'Verificado' => 'blue',
                            'Publicado'  => 'green',
                        ];
                        $corSt = $coresStatus[$inventarioGee->status] ?? 'gray';
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $corSt }}-100 text-{{ $corSt }}-800">
                        {{ $inventarioGee->status }}
                    </span>
                </div>
            </div>

            {{-- Fonte --}}
            <div class="mt-6 pt-6 border-t border-gray-200">
                <span class="block text-sm font-medium text-gray-500">Fonte de Emissão</span>
                <span class="mt-1 text-lg font-semibold text-gray-800">{{ $inventarioGee->fonte_emissao }}</span>
            </div>

            {{-- Quantificação --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Quantidade</span>
                    <span class="text-2xl font-bold text-gray-800">
                        {{ $inventarioGee->quantidade !== null
                            ? number_format((float) $inventarioGee->quantidade, 3, ',', '.')
                            : '—' }}
                    </span>
                    @if($inventarioGee->unidade)
                        <span class="text-sm text-gray-500 ml-1">{{ $inventarioGee->unidade }}</span>
                    @endif
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Fator de Emissão</span>
                    <span class="text-2xl font-bold text-gray-800">
                        {{ $inventarioGee->fator_emissao !== null
                            ? number_format((float) $inventarioGee->fator_emissao, 6, ',', '.')
                            : '—' }}
                    </span>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Emissão Total</span>
                    <span class="text-2xl font-bold text-purple-700">
                        {{ number_format((float) $inventarioGee->emissao_tco2e, 6, ',', '.') }}
                        <span class="text-base font-medium text-gray-500">tCO₂e</span>
                    </span>
                </div>
            </div>

            {{-- Documentação --}}
            @if($inventarioGee->metodologia || $inventarioGee->referencia_fator || $inventarioGee->evidencia)
                <div class="mt-6 pt-6 border-t border-gray-200 space-y-4">
                    @if($inventarioGee->referencia_fator)
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Referência do Fator</span>
                            <span class="mt-1 block text-gray-800">{{ $inventarioGee->referencia_fator }}</span>
                        </div>
                    @endif
                    @if($inventarioGee->metodologia)
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Metodologia</span>
                            <p class="mt-1 text-gray-800 whitespace-pre-line">{{ $inventarioGee->metodologia }}</p>
                        </div>
                    @endif
                    @if($inventarioGee->evidencia)
                        <div>
                            <span class="block text-sm font-medium text-gray-500">Evidência</span>
                            <p class="mt-1 text-gray-800 whitespace-pre-line">{{ $inventarioGee->evidencia }}</p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Rodapé --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Criado em: {{ $inventarioGee->created_at?->format('d/m/Y H:i') }}
                    @if($inventarioGee->updated_at && $inventarioGee->updated_at != $inventarioGee->created_at)
                        <br>Última atualização: {{ $inventarioGee->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
                <div>
                    <form action="{{ route('inventario_gee.destroy', $inventarioGee) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este registro?')">
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