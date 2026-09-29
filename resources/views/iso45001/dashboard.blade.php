<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ISO 45001') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7x1 ms-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">ISO 45001</h3>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!--<div class="grid grid-cols-4 gap-4">-->
                        @php
                            $cadastrosModulos = [
                                ['nome' => 'Perigos e Riscos', 'icone' => 'fa-biohazard', 'cor' => 'bg-amber-700', 'rota' => route('perigos_riscos.index')],
                                ['nome' => 'Incidentes/Acidentes', 'icone' => 'fa-triangle-exclamation', 'cor' => 'bg-red-600', 'rota' => route('incidentes_acidentes.index')],
                                ['nome' => 'EPIs', 'icone' => 'fa-hard-hat', 'cor' => 'bg-yellow-600', 'rota' => route('epis.index')],
                                ['nome' => 'EPIs - Usuários', 'icone' => 'fa-user-gear', 'cor' => 'bg-yellow-700', 'rota' => route('epis_usuarios.index')],       
                                
                                
                                ['nome' => 'Exames Médicos (ASO)', 'icone' => 'fa-user-md', 'cor' => 'bg-red-700', 'rota' => route('exames_medicos.index')],
                                ['nome' => 'CIPA e Reuniões', 'icone' => 'fa-users-between-lines', 'cor' => 'bg-amber-600', 'rota' => route('cipa_reunioes.index')],
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