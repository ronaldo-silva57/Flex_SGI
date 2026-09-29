<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-edit text-indigo-600"></i>
                Editar Plano de Ação
            </h2>

            <a
                href="{{ route('planos_acao.index') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200"
            >
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('planos_acao.update', $planosAcao) }}"
                method="POST"
            >
                @csrf
                @method('PUT')

                @include('cadastros.planos_acao.partials.form', [
                    'planoAcao' => $planosAcao,
                    'usuarios' => $usuarios,
                ])

                <div class="mt-8 flex justify-end gap-3 border-t pt-6">
                    <a
                        href="{{ route('planos_acao.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
                    >
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                    >
                        <i class="fas fa-save mr-2"></i>
                        Atualizar Plano
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
