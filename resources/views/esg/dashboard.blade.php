<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ESG') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7x1 ms-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">ESG</h3>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!--<div class="grid grid-cols-4 gap-4">-->
                        @php
                            $cadastrosModulos = [
                                ['nome' => 'Indicadores ESG', 'icone' => 'fa-earth-americas', 'cor' => 'bg-emerald-700', 'rota' => route('esg_indicadores.index')],
                                ['nome' => 'Monitoramento ESG', 'icone' => 'fa-eye', 'cor' => 'bg-teal-700', 'rota' => route('esg_monitoramentos.index')],
                                ['nome' => 'Stakeholders', 'icone' => 'fa-handshake', 'cor' => 'bg-indigo-700', 'rota' => route('stakeholders.index')],
                                ['nome' => 'Materialidade', 'icone' => 'fa-layer-group', 'cor' => 'bg-purple-700', 'rota' => route('materialidade.index')],
                                ['nome' => 'Vínculos Normativos', 'icone' => 'fa-link', 'cor' => 'bg-slate-800', 'rota' => route('vinculos_normativos.index')],  
                                ['nome' => 'Inventario GEE', 'icone' => 'fa-link', 'cor' => 'bg-slate-800', 'rota' => route('inventario_gee.index')],  
                                
                                
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