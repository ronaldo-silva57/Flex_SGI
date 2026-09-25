<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-database text-purple-600"></i>
                Detalhes do Ativo: {{ $ativosInformacao->nome }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('ativos_informacao.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('ativos_informacao.edit', $ativosInformacao) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Nome</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $ativosInformacao->nome }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $ativosInformacao->tipo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Classificação</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $ativosInformacao->classificacao ?? 'Não definida' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusColors = [
                            'Ativo' => 'bg-green-100 text-green-800',
                            'Inativo' => 'bg-gray-100 text-gray-800',
                            'Descartado' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$ativosInformacao->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $ativosInformacao->status }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Localização</span>
                    <p class="text-gray-700">{{ $ativosInformacao->localizacao ?? 'Não informada' }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Valor</span>
                    <p class="text-gray-700">R$ {{ number_format($ativosInformacao->valor ?? 0, 2, ',', '.') }}</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <span class="block text-sm font-medium text-gray-500">Descrição</span>
                <p class="text-gray-700 whitespace-pre-line">{{ $ativosInformacao->descricao ?? 'Nenhuma descrição fornecida.' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-200">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <p class="text-gray-700">{{ $ativosInformacao->responsavel->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Proprietário</span>
                    <p class="text-gray-700">{{ $ativosInformacao->proprietario->name ?? 'N/A' }}</p>
                </div>
            </div>

            {{-- Controles e Incidentes relacionados --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Controles de Segurança Associados</h3>
                @if($ativosInformacao->controles->count() > 0)
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($ativosInformacao->controles as $controle)
                            <li>
                                <a href="{{ route('controles_seguranca.show', $controle) }}" class="text-blue-600 hover:underline">
                                    {{ $controle->titulo }}
                                </a>
                                <span class="text-sm text-gray-500">({{ $controle->implementado ? 'Implementado' : 'Não implementado' }})</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Nenhum controle associado.</p>
                @endif
            </div>

            <div class="mt-6 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Incidentes de Segurança</h3>
                @if($ativosInformacao->incidentes->count() > 0)
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($ativosInformacao->incidentes as $incidente)
                            <li>
                                <a href="{{ route('incidentes_seguranca.show', $incidente) }}" class="text-blue-600 hover:underline">
                                    {{ $incidente->tipo }} - {{ $incidente->data_ocorrencia->format('d/m/Y') }}
                                </a>
                                <span class="text-sm text-gray-500">({{ $incidente->status }})</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Nenhum incidente registrado.</p>
                @endif
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ $ativosInformacao->created_at?->format('d/m/Y H:i') }}
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('ativos_informacao.destroy', $ativosInformacao) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este ativo?')">
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