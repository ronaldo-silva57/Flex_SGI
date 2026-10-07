<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-users text-red-500"></i>
                Detalhes da Reunião da CIPA
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('cipa_reunioes.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('cipa_reunioes.edit', $cipaReuniao) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">

            {{-- Seção 1: Identificação --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    @php
                        $tipoClasses = [
                            'Ordinária'         => 'bg-blue-100 text-blue-800',
                            'Extraordinária'    => 'bg-purple-100 text-purple-800',
                            'Inspeção de Campo' => 'bg-amber-100 text-amber-800',
                            'DDSGeral'          => 'bg-emerald-100 text-emerald-800',
                        ];
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $tipoClasses[$cipaReuniao->tipo] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $cipaReuniao->tipo }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusClasses = [
                            'Agendada'  => 'bg-yellow-100 text-yellow-800',
                            'Realizada' => 'bg-green-100 text-green-800',
                            'Cancelada' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClasses[$cipaReuniao->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $cipaReuniao->status }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Data da Reunião</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $cipaReuniao->data_reuniao ? \Carbon\Carbon::parse($cipaReuniao->data_reuniao)->format('d/m/Y') : 'N/A' }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Gestão</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $cipaReuniao->gestao_ano }}</span>
                </div>
            </div>

            {{-- Seção 2: Empresa + Envolvidos --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 pt-6 border-t border-gray-200">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $cipaReuniao->empresa?->nome_fantasia ?? $cipaReuniao->empresa?->razao_social ?? 'N/A' }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Presidente</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $cipaReuniao->presidente?->name ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Secretário(a)</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $cipaReuniao->secretario?->name ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- Seção 3: Pauta --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500 mb-1">Pauta Principal</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $cipaReuniao->pauta_principal }}</p>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Pauta Detalhada</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $cipaReuniao->pauta_detalhada ?? 'Não informada.' }}</p>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Deliberações</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $cipaReuniao->deliberacoes ?? 'Não informadas.' }}</p>
                </div>
            </div>

            {{-- Seção 4: Ata --}}
            @if($cipaReuniao->ata_arquivo_path)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <span class="block text-sm font-medium text-gray-500 mb-1">
                        <i class="fas fa-file-pdf text-red-500 mr-1"></i> Ata da Reunião
                    </span>
                    <a href="{{ Storage::disk('public')->url($cipaReuniao->ata_arquivo_path) }}"
                       target="_blank"
                       class="inline-flex items-center px-4 py-2 bg-red-50 text-red-700 rounded-md hover:bg-red-100 transition border border-red-200">
                        <i class="fas fa-download mr-2"></i> Baixar / Visualizar Ata
                    </a>
                </div>
            @endif

            {{-- Rodapé --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Registrado em: {{ $cipaReuniao->created_at?->format('d/m/Y H:i') }}
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('cipa_reunioes.destroy', $cipaReuniao) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir esta reunião?')">
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