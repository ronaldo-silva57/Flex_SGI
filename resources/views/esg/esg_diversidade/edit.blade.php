<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            <i class="fas fa-edit text-indigo-500"></i> Editar Diversidade ESG
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <form action="{{ route('esg_diversidade.update', $esgDiversidade) }}" method="POST">
                @csrf
                @method('PUT')
                @include('esg.esg_diversidade.partials.form', ['esgDiversidade' => $esgDiversidade])

                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('esg_diversidade.index') }}"
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 transition">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                        <i class="fas fa-save mr-2"></i> Atualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>