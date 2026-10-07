<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <i class="fas fa-edit text-indigo-500 mr-2"></i>Editar Resposta de Pesquisa
            </h2>
            <a href="{{ route('pesquisas_satisfacao_respostas.index') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition border border-blue-200">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <form action="{{ route('pesquisas_satisfacao_respostas.update', $resposta) }}" method="POST">
                @csrf
                @method('PUT')
                @include('iso9001.pesquisas_satisfacao_respostas.partials.form')

                <div class="mt-8 flex justify-end gap-3 border-t pt-6">
                    <a href="{{ route('pesquisas_satisfacao_respostas.index') }}" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-50">
                        Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                        <i class="fas fa-sync-alt mr-2"></i>Atualizar Resposta
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>