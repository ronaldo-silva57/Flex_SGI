<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-l mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- Título --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Módulos</h3>
                    </div>

                    {{-- Grid de módulos --}}
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @php
                        $modulos = [
                            ['nome' => 'Painel Geral', 'icone' => 'fa-tachometer-alt', 'cor' => ' bg-neutral-900', 'rota' => route('painel.geral')],
                            ['nome' => 'Geral & Estrutura', 'icone' => 'fa-layer-group', 'cor' => 'bg-blue-600', 'rota' => route('cadastros.dashboard')],
                            ['nome' => 'ISO 9001', 'icone' => 'fa-check-circle', 'cor' => 'bg-green-600' , 'rota'=> route('iso9001.dashboard')],
                            ['nome' => 'ISO 14001', 'icone' => 'fa-leaf', 'cor' => 'bg-teal-600', 'rota' => route('iso14001.dashboard')],
                            ['nome' => 'ISO 45001', 'icone' => 'fa-hard-hat', 'cor' => 'bg-red-600', 'rota' => route('iso45001.dashboard')],
                            ['nome' => 'ISO 27001', 'icone' => 'fa-shield-alt', 'cor' => 'bg-indigo-600', 'rota' => route('iso27001.dashboard')],
                            ['nome' => 'ESG', 'icone' => 'fa-globe-americas', 'cor' => 'bg-purple-600', 'rota' => route('esg.dashboard')],
                            ['nome' => 'Controle de Acesso', 'icone' => 'fa-user-shield', 'cor' => 'bg-purple-600', 'rota' => route('administracao.dashboard')],
                        ];
                    @endphp

                        @foreach ($modulos as $modulo)
                            <a href="{{ $modulo['rota'] }}" class="block">
                                <div class="rounded-xl shadow-md hover:shadow-lg transition duration-200 p-4 text-white {{$modulo['cor'] }} text-center flex flex-col items-center justify-center h-28">
                                    <i class="fas {{ $modulo['icone'] }} text-3xl b-2"></i>
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