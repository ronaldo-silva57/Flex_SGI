<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-exclamation-triangle text-red-600"></i> Não Conformidades Ambientais
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('iso14001.dashboard') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('nao_conformidades_ambientais.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>Nova NC
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-green-500 mr-3"></i><span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('nao_conformidades_ambientais.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Buscar por código, título ou descrição..."
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Status</option>
                        @foreach(['Aberta','Em análise','Em ação','Verificação','Fechada'] as $st)
                            <option value="{{ $st }}" {{ request('status')==$st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="gravidade" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Gravidade</option>
                        @foreach(['Baixa','Média','Alta','Crítica'] as $g)
                            <option value="{{ $g }}" {{ request('gravidade')==$g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <select name="origem" class="rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Origem</option>
                        @foreach(['Auditoria','Fiscalização','Monitoramento','Reclamação','Incidente','Outros'] as $o)
                            <option value="{{ $o }}" {{ request('origem')==$o ? 'selected' : '' }}>{{ $o }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                    <i class="fas fa-search mr-2"></i>Buscar
                </button>
                @if(request()->hasAny(['search','status','gravidade','origem']))
                    <a href="{{ route('nao_conformidades_ambientais.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-times mr-2"></i>Limpar
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Origem</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gravidade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prazo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($naoConformidades as $nc)
                            @php
                                $gravClasses = [
                                    'Baixa'   => 'bg-green-100 text-green-800',
                                    'Média'   => 'bg-yellow-100 text-yellow-800',
                                    'Alta'    => 'bg-orange-100 text-orange-800',
                                    'Crítica' => 'bg-red-100 text-red-800',
                                ];
                                $statusClasses = [
                                    'Aberta'      => 'bg-red-100 text-red-800',
                                    'Em análise'  => 'bg-amber-100 text-amber-800',
                                    'Em ação'     => 'bg-blue-100 text-blue-800',
                                    'Verificação' => 'bg-indigo-100 text-indigo-800',
                                    'Fechada'     => 'bg-green-100 text-green-800',
                                ];
                            @endphp
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $nc->codigo }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    {{ Str::limit($nc->titulo, 50) }}
                                    @if($nc->recorrente)
                                        <span class="ml-2 px-1.5 py-0.5 rounded text-[10px] font-semibold bg-purple-100 text-purple-700">RECORRENTE</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $nc->origem }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($nc->gravidade)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $gravClasses[$nc->gravidade] ?? 'bg-gray-100 text-gray-700' }}">{{ $nc->gravidade }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $nc->prazo_tratamento ? \Carbon\Carbon::parse($nc->prazo_tratamento)->format('d/m/Y') : '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses[$nc->status] ?? 'bg-gray-100 text-gray-700' }}">{{ $nc->status }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="flex justify-end items-center gap-3">
                                        <a href="{{ route('nao_conformidades_ambientais.show', $nc) }}"                                            class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-900 transition"
                                           title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                            <span class="hidden sm:inline">Visualizar</span>
                                        </a>
                                        <a href="{{ route('nao_conformidades_ambientais.edit', $nc) }}"                                            class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-900 transition"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                            <span class="hidden sm:inline">Editar</span>
                                        </a>
                                        <form action="{{ route('nao_conformidades_ambientais.destroy', $nc) }}" method="POST"
                                              onsubmit="return confirm('Excluir esta não conformidade?');" class="inline">
                                            @csrf @method('DELETE')
                                            <button class="text-red-600 hover:text-red-900"><i                                     class="inline-flex items-center gap-1 text-red-600 hover:text-red-900 transition"
                                                    title="Excluir">
                                                <i class="fas fa-trash-alt"></i>
                                                <span class="hidden sm:inline">Excluir</span>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Nenhuma não conformidade cadastrada.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $naoConformidades->links() }}</div>
    </div>
</x-app-layout>