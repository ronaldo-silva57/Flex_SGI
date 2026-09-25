<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-eye text-blue-500"></i>Detalhes da Reunião de Gestão
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('reunioes_gestao.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('reunioes_gestao.edit', $reunioesGestao) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Empresa</span>
                    <span class="mt-1 text-lg font-semibold">
                        {{ $reunioesGestao->empresa->nome_fantasia ?? $reunioesGestao->empresa->razao_social ?? 'N/A' }}
                    </span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Responsável</span>
                    <span class="mt-1 text-lg font-semibold">{{ $reunioesGestao->responsavel->name ?? 'Não definido' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data da Reunião</span>
                    <span class="mt-1 text-lg font-semibold">{{ $reunioesGestao->data_reuniao->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 text-lg font-semibold">
                        <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $reunioesGestao->tipo }}
                        </span>
                    </span>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Pauta</span>
                    <p class="mt-1 text-gray-800">{{ $reunioesGestao->pauta ?? 'Não informada' }}</p>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Decisões</span>
                    <p class="mt-1 text-gray-800">{{ $reunioesGestao->decisoes ?? 'Não informadas' }}</p>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Ações Definidas</span>
                    <p class="mt-1 text-gray-800">{{ $reunioesGestao->acoes_definidas ?? 'Não informadas' }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Próxima Reunião</span>
                    <span class="mt-1 text-lg font-semibold">
                        {{ $reunioesGestao->proxima_reuniao ? $reunioesGestao->proxima_reuniao->format('d/m/Y') : 'Não definida' }}
                    </span>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Ata</span>
                    <p class="mt-1 text-gray-800">{{ $reunioesGestao->ata ?? 'Não disponível' }}</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('reunioes_gestao.destroy', $reunioesGestao) }}" method="POST"
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
</x-app-layout>