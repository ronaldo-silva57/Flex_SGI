<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-shield-alt text-indigo-600"></i> Análise de Riscos de TI
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('iso27001.dashboard') }}" class="px-4 py-2 bg-blue-50 text-blue-700 border border-blue-200 rounded-md hover:bg-blue-100 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('analises_risco_ti.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Novo Risco
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
            <form method="GET" action="{{ route('analises_risco_ti.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Buscar por ameaça ou vulnerabilidade..."
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos os Status</option>
                        @foreach(['Identificado', 'Em tratamento', 'Monitorado', 'Encerrado'] as $st)
                            <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition">
                    <i class="fas fa-search mr-2"></i> Filtrar
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('analises_risco_ti.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i> Limpar
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabela --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ativo / Ameaça</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vulnerabilidade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pilares (CID)</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Risco Inerente</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Risco Residual</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($riscos as $risco)
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900 block">{{ $risco->ativo?->nome ?? 'Ativo Não Definido' }}</span>
                                <span class="text-sm text-gray-600">{{ Str::limit($risco->ameaca, 40) }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ Str::limit($risco->vulnerabilidade, 35) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-1">
                                    <span class="px-1.5 py-0.5 text-xs font-bold rounded {{ $risco->afeta_confidencialidade ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-400 line-through' }}">C</span>
                                    <span class="px-1.5 py-0.5 text-xs font-bold rounded {{ $risco->afeta_integridade ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-400 line-through' }}">I</span>
                                    <span class="px-1.5 py-0.5 text-xs font-bold rounded {{ $risco->afeta_disponibilidade ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-400 line-through' }}">D</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $score = $risco->nivel_risco_inerente ?? ($risco->probabilidade * $risco->impacto);
                                    $color = $score >= 15 ? 'bg-red-100 text-red-800' : ($score >= 8 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                                @endphp
                                <span class="px-2.5 py-1 text-xs rounded-full font-bold {{ $color }}">
                                    {{ $score }} (P{{ $risco->probabilidade }} x I{{ $risco->impacto }})
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($risco->nivel_risco_residual)
                                    @php
                                        $resScore = $risco->nivel_risco_residual;
                                        $resColor = $resScore >= 15 ? 'bg-red-100 text-red-800' : ($resScore >= 8 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800');
                                    @endphp
                                    <span class="px-2.5 py-1 text-xs rounded-full font-bold {{ $resColor }}">
                                        {{ $resScore }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs rounded-full font-bold 
                                    {{ $risco->status == 'Encerrado' ? 'bg-gray-100 text-gray-800' : 
                                       ($risco->status == 'Em tratamento' ? 'bg-blue-100 text-blue-800' : 
                                       ($risco->status == 'Monitorado' ? 'bg-purple-100 text-purple-800' : 'bg-amber-100 text-amber-800')) }}">
                                    {{ $risco->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('analises_risco_ti.show', $risco) }}" class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-700 rounded hover:bg-blue-100" title="Visualizar">
                                        <i class="fas fa-eye"></i>Visualizar
                                    </a>
                                    <a href="{{ route('analises_risco_ti.edit', $risco) }}" class="inline-flex items-center px-2 py-1 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100" title="Editar">
                                        <i class="fas fa-edit"></i>Editar
                                    </a>
                                    <form action="{{ route('analises_risco_ti.destroy', $risco) }}" method="POST" onsubmit="return confirm('Deseja realmente remover esta análise de risco?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-2 py-1 bg-red-50 text-red-700 rounded hover:bg-red-100" title="Excluir">
                                            <i class="fas fa-trash"></i>Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">Nenhuma análise de risco cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $riscos->links() }}
        </div>
    </div>
</x-app-layout>