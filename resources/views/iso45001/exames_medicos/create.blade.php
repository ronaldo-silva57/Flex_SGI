<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-plus-circle text-blue-600"></i>Novo Exame Médico (ASO)
            </h2>
            <a href="{{ route('exames_medicos.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition shadow-sm border border-gray-300">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <form action="{{ route('exames_medicos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('iso45001.exames_medicos.partials.form')

                <div class="mt-6 flex justify-end gap-3 border-t border-gray-100 pt-4">
                    <a href="{{ route('exames_medicos.index') }}"
                       class="px-4 py-2 bg-white border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm flex items-center gap-2">
                        <i class="fas fa-save"></i> Salvar Exame
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>