<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ISO 14001') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7x1 ms-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">ISO 14001</h3>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!--<div class="grid grid-cols-4 gap-4">-->
                        @php
                            $cadastrosModulos = [

                                ['nome' => 'Aspectos Ambientais', 'icone' => 'fa-leaf', 'cor' => 'bg-green-600', 'rota' => route('aspectos_ambientais.index')],
                                ['nome' => 'Registros Legais', 'icone' => 'fa-gavel', 'cor' => 'bg-stone-700', 'rota' => route('registros_legais.index')],
                                ['nome' => 'Licenças Ambientais', 'icone' => 'fa-scroll', 'cor' => 'bg-teal-600', 'rota' => route('licencas_ambientais.index')],
                                ['nome' => 'Gestão de Residuos', 'icone' => 'fa-recycle', 'cor' => 'bg-green-600', 'rota' => route('gestao_residuos.index')],
                                ['nome' => 'Objetivos Ambientais', 'icone' => 'fa-bullseye', 'cor' => 'bg-blue-600', 'rota' => route('objetivos_ambientais.index')],
                                ['nome' => 'Produtos Químicos', 'icone' => 'fa-bullseye', 'cor' => 'bg-blue-600', 'rota' => route('produtos_quimicos.index')],
                                ['nome' => 'Indicadores Ambientais', 'icone' => 'fa-bullseye', 'cor' => 'bg-blue-600', 'rota' => route('indicadores_ambientais.index')],
                                ['nome' => 'Não Conformidades Ambientais', 'icone' => 'fa-bullseye', 'cor' => 'bg-blue-600', 'rota' => route('nao_conformidades_ambientais.index')],
                            ];
                        @endphp

                            @foreach ($cadastrosModulos  as $modulo)
                                <a href="{{ $modulo['rota'] }}" class-block>
                                    <div class="rounded-xl shadow-md hover:shadow-lg transition duration-200 p-4 text-white {{ $modulo['cor'] }} text-center flex flex-col items-center justify-center h-28">
                                        <i class="fas {{ $modulo['icone'] }} text-3xl mb-2"></i>
                                        <span class="text-xs font-medium uppercase tracking-wide">{{ $modulo['nome'] }}</span>
                                    </div>
                                </a>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>