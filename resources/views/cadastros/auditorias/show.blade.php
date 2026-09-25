<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-eye text-blue-500"></i>Detalhes da Auditoria
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('auditorias.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('auditorias.edit', $auditoria) }}"
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
                    <span class="mt-1 text-lg font-semibold">{{ $auditoria->empresa->nome ?? 'N/A' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Norma</span>
                    <span class="mt-1 text-lg font-semibold">{{ $auditoria->norma->codigo ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipo</span>
                    <span class="mt-1 text-lg font-semibold">{{ $auditoria->tipo }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Auditor Líder</span>
                    <span class="mt-1 text-lg font-semibold">{{ $auditoria->auditorLider->name ?? 'Não definido' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Início</span>
                    <span class="mt-1 text-lg font-semibold">{{ $auditoria->data_inicio ? $auditoria->data_inicio->format('d/m/Y') : '---' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Data de Fim</span>
                    <span class="mt-1 text-lg font-semibold">{{ $auditoria->data_fim ? $auditoria->data_fim->format('d/m/Y') : '---' }}</span>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Escopo</span>
                    <p class="mt-1 text-gray-800">{{ $auditoria->escopo ?? 'Não informado' }}</p>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Objetivo</span>
                    <p class="mt-1 text-gray-800">{{ $auditoria->objetivo ?? 'Não informado' }}</p>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Status</span>
                    @php
                        $statusClasses = [
                            'Planejada'      => 'bg-blue-100 text-blue-800',
                            'Em andamento'   => 'bg-yellow-100 text-yellow-800',
                            'Concluída'      => 'bg-green-100 text-green-800',
                            'Cancelada'      => 'bg-gray-100 text-gray-800',
                        ][$auditoria->status] ?? 'bg-gray-100 text-gray-800';
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusClasses }}">
                        {{ $auditoria->status }}
                    </span>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Relatório</span>
                    <p class="mt-1 text-gray-800">{{ $auditoria->relatorio ?? 'Não informado' }}</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <form action="{{ route('auditorias.destroy', $auditoria) }}" method="POST"
                      onsubmit="return confirm('Tem certeza que deseja excluir esta auditoria?')">
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