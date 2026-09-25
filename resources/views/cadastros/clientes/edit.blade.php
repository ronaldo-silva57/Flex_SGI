<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-user-edit text-indigo-600"></i>
                Editar Cliente: <span class="text-indigo-900 font-bold">{{ $cliente->nome }}</span>
            </h2>
            <a href="{{ route('clientes.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition shadow-sm border border-gray-300 text-sm">
                <i class="fas fa-times mr-2"></i>Cancelar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <form method="POST" action="{{ route('clientes.update', $cliente->id) }}">
                @csrf
                @method('PUT')
                
                @include('cadastros.clientes.partials.form')

                <div class="flex justify-end gap-3 border-t border-gray-200 mt-6 pt-6">
                    <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium shadow-sm transition text-sm">
                        <i class="fas fa-sync-alt mr-2"></i> Atualizar Informações
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
