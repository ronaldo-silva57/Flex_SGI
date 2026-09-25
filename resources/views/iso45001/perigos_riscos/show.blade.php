<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-bolt text-amber-500"></i>Detalhes do Perigo/Risco
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('perigos_riscos.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('perigos_riscos.edit', $perigosRisco) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i> Editar
                </a>
            </div>
        </div>
    </x-slot>

    {{-- Status, Processo e Responsável --}}
    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusClasses = [
                            'Ativo' => 'bg-green-100 text-green-800',
                            'Em tratamento' => 'bg-yellow-100 text-yellow-800',
                            'Eliminado' => 'bg-gray-100 text-gray-800',
                        ]
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClasses[$perigosRisco->status] ?? 'bg-gray-100 text-gray-800' }} ">
                        {{ $perigosRisco->status }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Processos Vinculados</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $perigosRisco->processo?->nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">{{ $perigosRisco->responsavel?->name ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- Matriz de Avaliação (Probabilidade, Severidade, Nível e Necessita Ação --}}
            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Avaliação e Matriz de Risco</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
                    <div class="p-3 bg-white rounded border border-gray-100 shadow-sm">
                        <span class="block text-xs text-gray-500 uppercase">Probabilidade (1 a 5)</span>
                        <span class="text-2xl font-bold text-gray-800">{{ $perigosRisco->probabilidade ?? '-' }}</span>
                    </div>

                    <div class="p-3 bg-white rounded border border-gray-100 shadow-sm">
                        <span class="block text-xs text-gray-500 uppercase">Severidade (1 a 5)</span>
                        <span class="text-2xl font-bold text-gray-800">{{ $perigosRisco->severidade ?? '-' }}</span>
                    </div>

                    <div class="p-3 bg-white rounded border-gray-100 shadow-sm">
                        <span class="block text-xs text-gray-500 uppercase">Nível de Risco</span>
                        @php
                            $nivel = $perigosRisco->nivel_risco;
                            $corNivel = 'text-gray-800';
                            if ($nivel >= 15) $corNivel = 'text-red-600';
                            elseif ($nivel >= 8) $corNivel = 'text-amber-600';
                            elseif ($nivel) $corNivel = 'text-green-600';
                        @endphp
                        <span class="text-2xl font-bold {{ $corNivel }}">{{ $nivel ?? '-' }}</span>
                    </div>

                    <div class="p-3 bg-white rounded border border-gray-100 shadow-sm">
                        <span class="block text-xs text-gray-500 uppercase">Necessita Ação</span>
                        <span class="text-lg font-semibold block mt-1 px-2 py-1 rounded
                            {{ $perigosRisco->necessita_acao ? 'bg-red-600 text-white' : 'bg-green-600 text-white' }}">
                            {{ $perigosRisco->necessita_acao ? 'Sim' : 'Não' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Descrições: Perigo, Risco Associado e Exposição --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Descrição do Perigo</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $perigosRisco->descricao_perigo }}</p>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Risco Associado</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $perigosRisco->risco_associado ?? 'Não informado.' }}</p>
                </div>   
                
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">Exposição</span>
                    <p class="text-gray-700 whitespace-pre-line">{{ $perigosRisco->exposicao ?? 'Não informada.' }}</p>
                </div>
            </div>

            {{-- Medida de controle --}}
            <div class="mt-6 pt-6 border-t border-gray-200">
                <span class="block text-sm font-medium text-gray-500 mb-1">
                    <i class="fas fa-shield-alt text-indigo-500 mr-1"></i> Medida de Controle
                </span>
                <div class="p-3 bg-gray-50 rounded-md border border-gray-100 text-gray-700 text-sm whitespace-pre-line">
                    {{ $perigosRisco->medida_controle ?? 'Nenhuma medida de controle registrada.' }}
                </div>
            </div>

            {{-- Ações Inferiores --}}
            <div class="mt-8 pt-6 border-t bordr-gray-200 flex justify-between items-center">
                <div class="text-xs text-gray-400">
                    Cadastrado em: {{ $perigosRisco->created_at?->format('d/m/Y H:i') }}
                </div> 
                <div class="flex gap-3">
                    <form action="{{ route('perigos_riscos.destroy', $perigosRisco) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este registro?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i>Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>