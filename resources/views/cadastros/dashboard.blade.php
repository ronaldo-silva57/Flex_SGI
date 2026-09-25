<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastro Geral') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7x1 ms-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">Cadastro Geral</h3>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <!--<div class="grid grid-cols-4 gap-4">-->
                    @php
                        $cadastrosModulos = [
                            ['nome' => 'Empresa', 'icone' => 'fa-building', 'cor' => 'bg-slate-700', 'rota' => route('empresas.index')],
                            ['nome' => 'Departamentos', 'icone' => 'fa-sitemap', 'cor' => 'bg-slate-600', 'rota' => route('departamentos.index')],
                            ['nome' => 'Fornecedores', 'icone' => 'fa-truck-field', 'cor' => 'bg-amber-700', 'rota' => route('fornecedores.index')],
                            ['nome' => 'Clientes', 'icone' => 'fa-tasks', 'cor' => 'bg-violet-500', 'rota' => route('clientes.index')],
                            ['nome' => 'Documentos', 'icone' => 'fa-folder-open', 'cor' => 'bg-blue-600', 'rota' => route('documentos.index')],
                            ['nome' => 'Treinamentos', 'icone' => 'fa-chalkboard-user', 'cor' => 'bg-indigo-600', 'rota' => route('treinamentos.index')],
                            ['nome' => 'Treinamentos Usuários', 'icone' => 'fa-chalkboard-user', 'cor' => 'bg-indigo-500', 'rota' => route('treinamentos_usuarios.index')],
                            ['nome' => 'Histórico', 'icone' => 'fa-user-graduate', 'cor' => 'bg-orange-600', 'rota' => route('historico_alteracoes.index')],
                            ['nome' => 'Não Conformidades', 'icone' => 'fa-triangle-exclamation', 'cor' => 'bg-rose-700', 'rota' => route('nao_conformidades.index')],
                            ['nome' => 'Riscos e Oportunidades', 'icone' => 'fa-scale-balanced', 'cor' => 'bg-amber-600', 'rota' => route('riscos_oportunidades.index')],
                            ['nome' => 'Auditorias', 'icone' => 'fa-clipboard-check', 'cor' => 'bg-violet-600', 'rota' => route('auditorias.index')],
                            ['nome' => 'Auditorias Itens', 'icone' => 'fa-tasks', 'cor' => 'bg-violet-500', 'rota' => route('auditorias_itens.index')],
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