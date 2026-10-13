<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-user-tie text-blue-500"></i> Detalhes do Cargo: {{ $cargo->nome }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('cargos.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('cargos.edit', $cargo) }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $cargo->codigo ?? 'N/A' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Departamento</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $cargo->departamento?->nome ?? 'Geral' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $cargo->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $cargo->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $cargo->empresa?->razao_social ?? 'N/A' }}</span>
                </div>
            </div>

            @if($cargo->descricao || $cargo->requisitos)
                <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($cargo->descricao)
                        <div>
                            <span class="block text-sm font-medium text-gray-500 mb-1">Descrição / Atribuições</span>
                            <p class="text-gray-700 whitespace-pre-line">{{ $cargo->descricao }}</p>
                        </div>
                    @endif

                    @if($cargo->requisitos)
                        <div>
                            <span class="block text-sm font-medium text-gray-500 mb-1">Requisitos</span>
                            <p class="text-gray-700 whitespace-pre-line">{{ $cargo->requisitos }}</p>
                        </div>
                    @endif
                </div>
            @endif

            {{-- Exibição de Competências Vinculadas (Opcional se houver relação) --}}
            @if($cargo->competencias && $cargo->competencias->count() > 0)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h3 class="text-md font-medium text-gray-800 mb-3"><i class="fas fa-certificate text-indigo-500 mr-1"></i>Competências Exigidas</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($cargo->competencias as $comp)
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                {{ $comp->nome }} (Nível: {{ $comp->pivot->nivel_exigido ?? 'Padrão' }})
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ $cargo->created_at?->format('d/m/Y H:i') }}
                </div>

                <div class="flex gap-3">
                    <form action="{{ route('cargos.destroy', $cargo) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este cargo?')">
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