<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-user-tie text-indigo-500"></i> Detalhes do Membro de Governança ESG
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('esg_governanca.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('esg_governanca.edit', $esgGovernancaMembro) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            {{-- Cabeçalho --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $esgGovernancaMembro->empresa->nome ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Órgão</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $esgGovernancaMembro->orgao }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $esgGovernancaMembro->responsavel?->name ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @if($esgGovernancaMembro->ativo)
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                            <i class="fas fa-circle mr-1 text-green-500"></i> Ativo
                        </span>
                    @else
                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                            <i class="fas fa-circle mr-1 text-gray-500"></i> Inativo
                        </span>
                    @endif
                </div>
            </div>

            {{-- Nome + Cargo --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Nome</span>
                    <p class="text-lg font-semibold text-gray-800">{{ $esgGovernancaMembro->nome }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Cargo</span>
                    <p class="text-lg font-semibold text-gray-800">{{ $esgGovernancaMembro->cargo }}</p>
                </div>
            </div>

            {{-- Independência + Mandato --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Independente</span>
                    @if($esgGovernancaMembro->independente)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                            <i class="fas fa-check-circle mr-1"></i> Sim
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-800">
                            <i class="fas fa-times-circle mr-1"></i> Não
                        </span>
                    @endif
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Início do Mandato</span>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $esgGovernancaMembro->inicio_mandato?->format('d/m/Y') ?? 'Não informado' }}
                    </p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Fim do Mandato</span>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $esgGovernancaMembro->fim_mandato?->format('d/m/Y') ?? 'Não informado' }}
                    </p>
                </div>
            </div>

            {{-- Ações --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Criado em: {{ $esgGovernancaMembro->created_at?->format('d/m/Y H:i') }}
                    @if($esgGovernancaMembro->updated_at && $esgGovernancaMembro->updated_at != $esgGovernancaMembro->created_at)
                        <br>Última atualização: {{ $esgGovernancaMembro->updated_at->format('d/m/Y H:i') }}
                    @endif
                </div>
                <div>
                    <form action="{{ route('esg_governanca.destroy', $esgGovernancaMembro) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este membro?')">
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