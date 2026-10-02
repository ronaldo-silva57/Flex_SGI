<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-clipboard-check text-blue-500"></i>
                Detalhes da Calibração
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('calibracoes.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('calibracoes.edit', $calibracao) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $dias = now()->diffInDays($calibracao->data_validade, false);
    @endphp

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>{{ session('success') }}
            </div>
        @endif

        {{-- Cards de topo --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-500">Data da calibração</span>
                    <i class="fas fa-calendar-check text-blue-500"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900">
                    {{ $calibracao->data_calibracao->format('d/m/Y') }}
                </span>
            </div>

            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-500">Validade</span>
                    <i class="fas fa-calendar-alt text-indigo-500"></i>
                </div>
                <span class="text-2xl font-bold text-gray-900">
                    {{ $calibracao->data_validade->format('d/m/Y') }}
                </span>
                @if($dias < 0)
                    <span class="mt-2 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <i class="fas fa-exclamation-triangle mr-1"></i>{{ abs($dias) }} dias em atraso
                    </span>
                @elseif($dias <= 30)
                    <span class="mt-2 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        <i class="fas fa-clock mr-1"></i>{{ $dias }} dias restantes
                    </span>
                @else
                    <span class="mt-2 inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-check mr-1"></i>Em dia
                    </span>
                @endif
            </div>

            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-500">Resultado</span>
                    <i class="fas fa-clipboard-list text-indigo-500"></i>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                    @if($calibracao->resultado === 'Aprovado') bg-green-100 text-green-800
                    @elseif($calibracao->resultado === 'Aprovado com restrição') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ $calibracao->resultado }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Coluna principal --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-500"></i>Informações
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach([
                            'Laboratório'     => $calibracao->laboratorio ?? '—',
                            'Nº certificado'  => $calibracao->certificado_numero ?? '—',
                            'Responsável'     => $calibracao->responsavel?->name ?? '—',
                            'Registrado em'   => $calibracao->created_at?->format('d/m/Y H:i') ?? '—',
                            'Atualizado em'   => $calibracao->updated_at?->format('d/m/Y H:i') ?? '—',
                        ] as $label => $value)
                            <div>
                                <span class="block text-sm font-medium text-gray-500">{{ $label }}</span>
                                <span class="mt-1 text-base text-gray-900">{{ $value }}</span>
                            </div>
                        @endforeach

                        <div class="md:col-span-2">
                            <span class="block text-sm font-medium text-gray-500">Observações</span>
                            <p class="mt-1 text-base text-gray-900 whitespace-pre-line">
                                {{ $calibracao->observacoes ?: '—' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-between items-center gap-3 mt-6 pt-4 border-t border-gray-100">
                        <div>
                            @if($calibracao->certificado_path)
                                <a href="{{ Storage::disk('public')->url($calibracao->certificado_path) }}"
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition">
                                    <i class="fas fa-paperclip mr-2"></i>Ver certificado
                                </a>
                            @endif
                        </div>
                        <form action="{{ route('calibracoes.destroy', $calibracao) }}" method="POST"
                              onsubmit="return confirm('Tem certeza que deseja excluir esta calibração?');">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md text-red-700 hover:bg-red-50 transition">
                                <i class="fas fa-trash-alt mr-2"></i>Excluir
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Coluna lateral --}}
            <div>
                <div class="bg-white p-6 rounded-lg shadow-sm sticky top-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-ruler-combined text-blue-500"></i>Equipamento
                    </h3>

                    @if($calibracao->equipamento)
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="block text-xs uppercase text-gray-500 font-semibold">Código</span>
                                <span class="font-mono text-gray-900">{{ $calibracao->equipamento->codigo }}</span>
                            </div>
                            <div>
                                <span class="block text-xs uppercase text-gray-500 font-semibold">Nome</span>
                                <span class="text-gray-900">{{ $calibracao->equipamento->nome }}</span>
                            </div>
                            @if(trim($calibracao->equipamento->marca . ' ' . $calibracao->equipamento->modelo))
                                <div>
                                    <span class="block text-xs uppercase text-gray-500 font-semibold">Marca / Modelo</span>
                                    <span class="text-gray-900">
                                        {{ trim($calibracao->equipamento->marca . ' ' . $calibracao->equipamento->modelo) }}
                                    </span>
                                </div>
                            @endif
                            @if($calibracao->equipamento->localizacao)
                                <div>
                                    <span class="block text-xs uppercase text-gray-500 font-semibold">Localização</span>
                                    <span class="text-gray-900">{{ $calibracao->equipamento->localizacao }}</span>
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('equipamentos_medicao.show', $calibracao->equipamento) }}"
                           class="mt-4 inline-flex w-full justify-center items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                            <i class="fas fa-external-link-alt mr-2"></i>Ver equipamento
                        </a>
                    @else
                        <p class="text-sm text-gray-500">Equipamento não encontrado.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>