<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ISO 9001') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7x1 ms-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">ISO 9001</h3>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!--<div class="grid grid-cols-4 gap-4">-->
                        @php
                            $cadastrosModulos = [
                                ['nome' => 'Normas', 'icone' => 'fa-book', 'cor' => 'bg-blue-700', 'rota' => route('normas.index')],
                                ['nome' => 'Cláusulas', 'icone' => 'fa-list-ol', 'cor' => 'bg-blue-500', 'rota' => route('clausulas.index')],
                                ['nome' => 'Processos', 'icone' => 'fa-gears', 'cor' => 'bg-cyan-600', 'rota' => route('processos.index')],
                                ['nome' => 'Indicadores', 'icone' => 'fa-chart-line', 'cor' => 'bg-emerald-600', 'rota' => route('indicadores.index')],
                                ['nome' => 'Monitoramentos', 'icone' => 'fa-chart-pie', 'cor' => 'bg-teal-600', 'rota' => route('monitoramentos.index')],
                                ['nome' => 'Reuniões Geral', 'icone' => 'fa-users', 'cor' => 'bg-sky-600', 'rota' => route('reunioes_gestao.index')],
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