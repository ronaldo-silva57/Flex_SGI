<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <i class="fas fa-shield-halved text-indigo-600 mr-2"></i>
                Novo Controle de Segurança
            </h2>
            <a
                href="{{ route('controles_seguranca.index') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition shadow-sm border border-blue-200"
            >
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <form
                action="{{ route('controles_seguranca.store') }}"
                method="POST"
            >
                @csrf
                @include('iso27001.controles_seguranca.partials.form')

                <div class="mt-8 flex justify-end gap-3 border-t pt-6">
                    <a
                        href="{{ route('controles_seguranca.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                    >
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    <button
                        type="submit"
                        class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Salvar Controle
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>