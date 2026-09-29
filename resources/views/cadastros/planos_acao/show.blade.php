<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-tasks text-blue-500"></i>Detalhes: {{ $planosAcao->titulo }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('planos_acao.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('planos_acao.edit', $planosAcao) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Código</span>
                    <span class="mt-1 text-lg font-semibold text-gray-900">{{ $planosAcao->codigo ?? '-' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold text-gray-900">{{ optional($planosAcao->responsavel)->name ?? 'Não definido' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Início</span>
                    <span class="mt-1 text-lg font-semibold text-gray-900">
                        {{ $planosAcao->prazo_inicio ? \Carbon\Carbon::parse($planosAcao->prazo_inicio)->format('d/m/Y') : '-' }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Término / Prazo</span>
                    <span class="mt-1 text-lg font-semibold text-gray-900">
                        {{ $planosAcao->prazo_fim ? \Carbon\Carbon::parse($planosAcao->prazo_fim)->format('d/m/Y') : '-' }}
                    </span>
                </div>

                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">
                        O que será feito
                    </span>

                    <p class="mt-1 text-base text-gray-800 whitespace-pre-line">
                        {{ $planosAcao->o_que ?? 'Não informado.' }}
                    </p>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">
                        Por que será feito
                    </span>

                    <p class="mt-1 text-base text-gray-800 whitespace-pre-line">
                        {{ $planosAcao->por_que ?? 'Não informado.' }}
                    </p>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">
                        Onde será executado
                    </span>

                    <p class="mt-1 text-base text-gray-800 whitespace-pre-line">
                        {{ $planosAcao->onde ?? 'Não informado.' }}
                    </p>
                </div>

                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">
                        Como será feito
                    </span>

                    <p class="mt-1 text-base text-gray-800 whitespace-pre-line">
                        {{ $planosAcao->como ?? 'Não informado.' }}
                    </p>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">
                        Custo estimado
                    </span>

                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        R$ {{ number_format($planosAcao->quanto_custa ?? 0, 2, ',', '.') }}
                    </p>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">
                        Progresso
                    </span>

                    <p class="mt-1 text-lg font-semibold text-gray-900">
                        {{ $planosAcao->progresso ?? 0 }}%
                    </p>
                </div>


                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusStyle = [
                            'Pendente'     => 'bg-yellow-100 text-yellow-800',
                            'Em andamento' => 'bg-blue-100 text-blue-800',
                            'Concluído'    => 'bg-green-100 text-green-800',
                            'Atrasado'     => 'bg-red-100 text-red-800',
                            'Cancelado'    => 'bg-gray-100 text-gray-800',
                        ][$planosAcao->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp

                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusStyle }}">
                        {{ $planosAcao->status }}
                    </span>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('planos_acao.destroy', $planosAcao) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir este plano de ação?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition shadow-sm">
                        <i class="fas fa-trash mr-2"></i> Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>