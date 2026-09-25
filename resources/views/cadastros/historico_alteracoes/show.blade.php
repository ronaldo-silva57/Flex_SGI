<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-history text-slate-600"></i>
                Detalhes da Alteração
            </h2>
            <a href="{{ route('historico_alteracoes.index') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 rounded-lg shadow-sm">

            {{-- Cabeçalho: Tabela / Registro / Ação / Data --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tabela</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $historico_alteracao->tabela }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Registro</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        #{{ $historico_alteracao->registro_id }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Ação</span>
                    @php
                        $acaoCor = match($historico_alteracao->acao) {
                            'insert' => 'green',
                            'update' => 'blue',
                            'delete' => 'red',
                            default  => 'gray',
                        };
                        $acaoIcone = match($historico_alteracao->acao) {
                            'insert' => 'fa-plus-circle',
                            'update' => 'fa-pen',
                            'delete' => 'fa-trash',
                            default  => 'fa-circle',
                        };
                    @endphp
                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-{{ $acaoCor }}-100 text-{{ $acaoCor }}-800">
                        <i class="fas {{ $acaoIcone }} mr-1"></i>
                        {{ $historico_alteracao->acao_label }}
                    </span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Data / Hora</span>
                    <span class="mt-1 text-lg font-semibold text-gray-800">
                        {{ $historico_alteracao->created_at?->format('d/m/Y H:i:s') ?? '-' }}
                    </span>
                </div>
            </div>

            {{-- Usuário / IP --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b border-gray-200">
                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">
                        <i class="fas fa-user mr-1"></i> Usuário
                    </span>
                    <p class="text-gray-800 font-semibold">
                        {{ $historico_alteracao->usuario?->name ?? 'Sistema' }}
                    </p>
                    @if($historico_alteracao->usuario?->email)
                        <p class="text-xs text-gray-500">{{ $historico_alteracao->usuario->email }}</p>
                    @endif
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500 mb-1">
                        <i class="fas fa-network-wired mr-1"></i> Endereço IP
                    </span>
                    <p class="text-gray-800 font-mono">
                        {{ $historico_alteracao->ip_address ?? 'Não registrado' }}
                    </p>
                </div>
            </div>

            {{-- Diff: Antes x Depois --}}
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Dados anteriores --}}
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fas fa-arrow-left text-red-500"></i>
                        Dados Anteriores
                    </h3>
                    <div class="bg-red-50 border border-red-100 rounded-lg p-4 overflow-x-auto">
                        @if(!empty($historico_alteracao->dados_anteriores))
                            <pre class="text-xs text-gray-800 whitespace-pre-wrap break-all">{{ json_encode($historico_alteracao->dados_anteriores, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        @else
                            <p class="text-sm text-gray-500 italic">Nenhum dado anterior (inserção).</p>
                        @endif
                    </div>
                </div>

                {{-- Dados novos --}}
                <div>
                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2 flex items-center gap-2">
                        <i class="fas fa-arrow-right text-green-500"></i>
                        Dados Novos
                    </h3>
                    <div class="bg-green-50 border border-green-100 rounded-lg p-4 overflow-x-auto">
                        @if(!empty($historico_alteracao->dados_novos))
                            <pre class="text-xs text-gray-800 whitespace-pre-wrap break-all">{{ json_encode($historico_alteracao->dados_novos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        @else
                            <p class="text-sm text-gray-500 italic">Nenhum dado novo (exclusão).</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Rodapé --}}
            <div class="mt-8 pt-6 border-t border-gray-200 text-xs text-gray-400">
                ID do registro de auditoria: <span class="font-mono">#{{ $historico_alteracao->id }}</span>
            </div>
        </div>
    </div>
</x-app-layout>