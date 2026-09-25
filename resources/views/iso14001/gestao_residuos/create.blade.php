<x-app-layout>
    <x-slot name='header'>
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-recycle text-green-600"></i>
                Novo Resíduo
            </h2>
            <a href="{{ route('gestao_residuos.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <form action="{{  route('gestao_residuos.store') }}" method="POST">
                @csrf
                @include('iso14001.gestao_residuos.partials.form')
                <div class="mt-8 flex justify-end gap-3 border-t pt-6">
                    <a href="{{ route('gestao_residuos.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                        <i class="fas fa-times mr-2"></i>Cancelar
                    </a>
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 shadow-sm">
                        <i class="fas fa-save mr-2"></i>Salvar Resíduo
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
