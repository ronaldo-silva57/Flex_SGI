<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-triangle-exclamation text-red-500"></i>
                Detalhes do Incidente / Acidente
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('incidentes_acidentes.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('incidentes_acidentes.edit', $incidentesAcidente) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">

            {{-- Seção 1: Identificação e Data --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    @php
                        $tipoClasses = [
                            'Quase acidente' => 'bg-yellow-100 text-yellow-800',
                            'Incidente'      => 'bg-blue-100 text-blue-800',
                            'Acidente leve'  => 'bg-orange-100 text-orange-800',
                            'Acidente grave' => 'bg-red-100 text-red-800',
                            'Fatal'          => 'bg-gray-900 text-white',
                        ];
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $tipoClasses[$incidentesAcidente->tipo] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $incidentesAcidente->tipo }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusClasses = [
                            'Aberto'          => 'bg-yellow-100 text-yellow-800',
                            'Em investigação' => 'bg-blue-100 text-blue-800',
                            'Concluído'       => 'bg-green-100 text-green-800',
                        ];
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClasses[$incidentesAcidente->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $incidentesAcidente->status }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Data da Ocorrência</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $incidentesAcidente->data_ocorrencia ? \Carbon\Carbon::parse($incidentesAcidente->data_ocorrencia)->format('d/m/Y H:i') : 'N/A' }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Local</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $incidentesAcidente->local ?? 'Não informado' }}</span>
                </div>
            </div>

            {{-- Seção 2: Envolvidos (Usuário e Responsável) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 pt-6 border-t border-gray-200">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Pessoa envolvida (Vítima)</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $incidentesAcidente->usuario?->name ?? 'Não informado' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável pelo registro</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $incidentesAcidente->responsavel?->name ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- Seção 3: Descrição e Causas --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Descrição do ocorrido</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $incidentesAcidente->descricao }}</p>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Causas</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $incidentesAcidente->causas ?? 'Não informadas.' }}</p>
                </div>
            </div>

            {{-- Seção 4: Lesão e Dias Perdidos --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Lesão / Ferimento</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $incidentesAcidente->lesao ?? 'Não informada.' }}</p>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Dias perdidos</span>
                    <p class="text-2xl font-bold text-gray-800">{{ $incidentesAcidente->dias_perdidos ?? 0 }}</p>
                </div>
            </div>

            {{-- Seção 5: Tratamento e Investigação --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">
                        <i class="fas fa-notes-medical text-indigo-500 mr-1"></i> Tratamento
                    </span>
                    <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                        {{ $incidentesAcidente->tratamento ?? 'Nenhum tratamento registrado.' }}
                    </div>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">
                        <i class="fas fa-magnifying-glass text-indigo-500 mr-1"></i> Investigação
                    </span>
                    <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                        {{ $incidentesAcidente->investigacao ?? 'Nenhuma investigação registrada.' }}
                    </div>
                </div>
            </div>

            {{-- Seção 6: Ação Corretiva --}}
            <div class="mt-6 pt-6 border-t border-gray-200">
                <span class="block text-sm font-medium text-gray-500 mb-1">
                    <i class="fas fa-check-circle text-green-500 mr-1"></i> Ação Corretiva
                </span>
                <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                    {{ $incidentesAcidente->acao_corretiva ?? 'Nenhuma ação corretiva definida.' }}
                </div>
            </div>

            {{-- Rodapé com data de criação e botão excluir --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Registrado em: {{ $incidentesAcidente->created_at?->format('d/m/Y H:i') }}
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('incidentes_acidentes.destroy', $incidentesAcidente) }}" method="POST"
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