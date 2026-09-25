<x-app-layout>

    <x-slot name="header">

        <div class="flex justify-between items-center">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">

                <i class="fas fa-shield-halved text-indigo-600"></i>

                Detalhes do Controle de Segurança

            </h2>


            <div class="flex gap-3">

                <a
                    href="{{ route('controles_seguranca.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition shadow-sm border border-blue-200"
                >

                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar

                </a>


                <a
                    href="{{ route('controles_seguranca.edit', $controlesSeguranca) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition"
                >

                    <i class="fas fa-edit mr-2"></i>
                    Editar

                </a>

            </div>

        </div>

    </x-slot>


    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white p-6 rounded-lg shadow-sm">


            {{-- Identificação --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                <div>

                    <span class="block text-sm font-medium text-gray-500">
                        Código / Anexo A
                    </span>

                    <span class="mt-1 block text-lg font-mono font-semibold text-indigo-700">
                        {{ $controlesSeguranca->codigo_anexo_a ?? 'Não informado' }}
                    </span>

                </div>


                <div class="lg:col-span-2">

                    <span class="block text-sm font-medium text-gray-500">
                        Controle
                    </span>

                    <span class="mt-1 block text-lg font-semibold text-gray-800">
                        {{ $controlesSeguranca->titulo }}
                    </span>

                </div>


                <div>

                    <span class="block text-sm font-medium text-gray-500">
                        Situação
                    </span>

                    @if($controlesSeguranca->implementado)

                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">

                            <i class="fas fa-check-circle mr-2"></i>
                            Implementado

                        </span>

                    @else

                        <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800">

                            <i class="fas fa-times-circle mr-2"></i>
                            Não implementado

                        </span>

                    @endif

                </div>

            </div>


            {{-- Ativo / Responsável / Data --}}
            <div class="mt-6 pt-6 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>

                    <span class="block text-sm font-medium text-gray-500">
                        Ativo de Informação
                    </span>

                    <span class="mt-1 block text-gray-800">

                        @if($controlesSeguranca->ativo)

                            <i class="fas fa-server text-gray-400 mr-2"></i>
                            {{ $controlesSeguranca->ativo->nome }}

                        @else

                            Não vinculado

                        @endif

                    </span>

                </div>


                <div>

                    <span class="block text-sm font-medium text-gray-500">
                        Responsável
                    </span>

                    <span class="mt-1 block text-gray-800">

                        <i class="fas fa-user text-gray-400 mr-2"></i>

                        {{ $controlesSeguranca->responsavel?->name ?? 'Não informado' }}

                    </span>

                </div>


                <div>

                    <span class="block text-sm font-medium text-gray-500">
                        Data da Implementação
                    </span>

                    <span class="mt-1 block text-gray-800">

                        <i class="fas fa-calendar-check text-gray-400 mr-2"></i>

                        {{ $controlesSeguranca->data_implementacao?->format('d/m/Y') ?? 'Não informada' }}

                    </span>

                </div>

            </div>


            {{-- Descrição --}}
            <div class="mt-6 pt-6 border-t border-gray-200">

                <span class="block text-sm font-medium text-gray-500 mb-2">

                    <i class="fas fa-align-left text-indigo-500 mr-1"></i>

                    Descrição

                </span>

                <div class="p-4 bg-gray-50 rounded-md border border-gray-100 text-gray-700 whitespace-pre-line">

                    {{ $controlesSeguranca->descricao ?? 'Nenhuma descrição registrada.' }}

                </div>

            </div>


            {{-- Evidência --}}
            <div class="mt-6 pt-6 border-t border-gray-200">

                <span class="block text-sm font-medium text-gray-500 mb-2">

                    <i class="fas fa-file-shield text-indigo-500 mr-1"></i>

                    Evidência da Implementação

                </span>

                <div class="p-4 bg-gray-50 rounded-md border border-gray-100 text-gray-700 whitespace-pre-line">

                    {{ $controlesSeguranca->evidencia ?? 'Nenhuma evidência registrada.' }}

                </div>

            </div>


            {{-- Informações de registro --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-between items-center">

                <div class="text-xs text-gray-400">

                    Registrado em:
                    {{ $controlesSeguranca->created_at?->format('d/m/Y H:i') }}

                    @if($controlesSeguranca->updated_at &&
                        $controlesSeguranca->updated_at->ne($controlesSeguranca->created_at))

                        <br>

                        Atualizado em:
                        {{ $controlesSeguranca->updated_at->format('d/m/Y H:i') }}

                    @endif

                </div>


                <form
                    action="{{ route('controles_seguranca.destroy', $controlesSeguranca) }}"
                    method="POST"
                    onsubmit="return confirm('Tem certeza que deseja excluir este controle?')"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
                    >

                        <i class="fas fa-trash mr-2"></i>
                        Excluir

                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>