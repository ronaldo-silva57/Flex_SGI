<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center">
                <i class="fas fa-edit text-indigo-500 mr-1"></i>Editar Governança ESG
            </h2>
            <a href="{{ route('esg_governanca.index') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <form action="{{ route('esg_governanca.update', $esgGovernancaMembro) }}" method="POST">
                @csrf
                @method('PUT')
                @include('esg.esg_governanca.partials.form', ['esgGovernancaMembro' => $esgGovernancaMembro])

                <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('esg_governanca.index') }}"
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