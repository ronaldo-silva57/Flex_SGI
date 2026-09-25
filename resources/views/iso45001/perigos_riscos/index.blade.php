<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-amber-600"></i>
                Perigos e Riscos
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('iso45001.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-100">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
                </a>
                <a href="{{ route('perigos_riscos.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Novo Perigo/Risco
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Filtro --}}
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('perigos_riscos.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Buscar por perigo ou risco..." 
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    <i class="fas fa-search mr-2"></i> Buscar
                </button>
                @if(request('search'))
                    <a href="{{ route('perigos_riscos.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i> Limpar
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabela --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Perigo / Risco
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-project-diagram mr-1"></i>Processo
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-thermometer-half mr-1"></i>Nível de Risco
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-toggle-on mr-1"></i>Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-tools mr-1"></i>Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($perigos as $perigo)
                            <tr class="hover:bg-gray-50 transition-colors">
                                {{-- Descrição Perigo/Risco --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">
                                        {{ Str::limit($perigo->descricao_perigo, 50) }}
                                    </div>
                                    @if($perigo->risco_associado)
                                        <div class="text-xs text-gray-500 mt-1">
                                            <span class="font-medium">Risco:</span> {{ Str::limit($perigo->risco_associado, 40) }}
                                        </div>
                                    @endif
                                </td>

                                {{-- Processo --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $perigo->processo->nome ?? 'N/A' }}
                                </td>

                                {{-- Nível de Risco --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @php
                                        $nivel = $perigo->nivel_risco;
                                        $badgeClass = 'bg-gray-100 text-gray-800';
                                        
                                        if ($nivel) {
                                            if ($nivel <= 5) {
                                                $badgeClass = 'bg-green-100 text-green-800'; // Baixo
                                            } elseif ($nivel <= 12) {
                                                $badgeClass = 'bg-yellow-100 text-yellow-800'; // Médio
                                            } elseif ($nivel <= 19) {
                                                $badgeClass = 'bg-orange-100 text-orange-800'; // Alto
                                            } else {
                                                $badgeClass = 'bg-red-100 text-red-800'; // Crítico (20-25)
                                            }
                                        }
                                    @endphp
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                        {{ $nivel ? "Nível $nivel" : 'Não avaliado' }}
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @php
                                        $statusClasses = [
                                            'Ativo' => 'bg-red-50 text-red-700 border-red-200',
                                            'Em tratamento' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'Eliminado' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        ];
                                        $statusClass = $statusClasses[$perigo->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-md text-xs font-medium border {{ $statusClass }}">
                                        {{ $perigo->status }}
                                    </span>
                                </td>

                                {{-- Ações --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('perigos_riscos.show', $perigo) }}"
                                           class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-900 transition"
                                           title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                            <span class="hidden sm:inline">Visualizar</span>
                                        </a>
                                        <a href="{{ route('perigos_riscos.edit', $perigo) }}"
                                           class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-900 transition"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                            <span class="hidden sm:inline">Editar</span>
                                        </a>
                                        <form action="{{ route('perigos_riscos.destroy', $perigo) }}"
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este Perigo / Risco?');">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 text-red-600 hover:text-red-900 transition"
                                                    title="Excluir">
                                                <i class="fas fa-trash-alt"></i>
                                                <span class="hidden sm:inline">Excluir</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl block mb-3 text-gray-300"></i>
                                    Nenhum perigo ou risco cadastrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($perigos->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $perigos->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>