<h1>Em construção</h1><x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-notes-medical text-blue-600"></i>Exames Médicos (ASO)
            </h2> 
            <div class="flex space-x-4">
                <a href="{{ route('iso45001.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a> 
                <a href="{{ route('exames_medicos.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Novo Exame / ASO
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

        {{-- Filtros --}}
        <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
            <form method="GET" action="{{ route('exames_medicos.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="search" class="sr-only">Buscar</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                               placeholder="Colaborador, CRM ou Médico..."
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div class="w-44">
                    <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos os Status</option>
                        @foreach(['Vigente', 'Vencido', 'Substituído'] as $st)
                            <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-44">
                    <select name="resultado" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Resultados</option>
                        @foreach(['Apto', 'Apto com Restrição', 'Inapto'] as $res)
                            <option value="{{ $res }}" {{ request('resultado') == $res ? 'selected' : '' }}>{{ $res }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                    <i class="fas fa-search mr-2"></i> Buscar
                </button>
                @if(request('search') || request('status') || request('resultado'))
                    <a href="{{ route('exames_medicos.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition">
                        <i class="fas fa-times mr-2"></i> Limpar
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabela --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-user mr-1"></i>Colaborador / Empresa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-file-alt mr-1"></i>Tipo ASO
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-calendar-alt mr-1"></i>Realização / Vencimento
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-heartbeat mr-1"></i>Resultado
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-toggle-on mr-1"></i>Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wide">
                                <i class="fas fa-tools mr-1"></i>Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($exames as $exame)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-indigo-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <div class="flex flex-col">
                                        <span>{{ $exame->usuario->name ?? 'N/A' }}</span>
                                        <span class="text-xs text-gray-500 font-normal">{{ $exame->empresa->razao_social ?? 'Empresa N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $exame->tipo_aso }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex flex-col">
                                        <span>Realizado: {{ \Carbon\Carbon::parse($exame->data_realizacao)->format('d/m/Y') }}</span>
                                        <span class="text-xs text-gray-500">Vence: {{ $exame->data_vencimento ? \Carbon\Carbon::parse($exame->data_vencimento)->format('d/m/Y') : 'N/I' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @php
                                        $resClasses = [
                                            'Apto'              => 'text-green-700 bg-green-50 border-green-200',
                                            'Apto com Restrição'=> 'text-amber-700 bg-amber-50 border-amber-200',
                                            'Inapto'            => 'text-red-700 bg-red-50 border-red-200',
                                        ][$exame->resultado] ?? 'text-gray-700 bg-gray-50';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $resClasses }}">
                                        {{ $exame->resultado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'Vigente'    => 'bg-green-100 text-green-800 border-green-200',
                                            'Vencido'    => 'bg-red-100 text-red-800 border-red-200',
                                            'Substituído'=> 'bg-gray-100 text-gray-800 border-gray-200',
                                        ][$exame->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $statusClasses }}">
                                        {{ $exame->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="inline-flex gap-1">
                                        <a href="{{ route('exames_medicos.show', $exame) }}"
                                        class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-700 rounded hover:bg-blue-100"
                                        title="Visualizar">
                                        <i class="fas fa-eye mr-1"></i> Visualizar
                                        </a>

                                        <a href="{{ route('exames_medicos.edit', $exame) }}"
                                        class="inline-flex items-center px-3 py-2 bg-indigo-50 text-indigo-700 rounded hover:bg-indigo-100"
                                        title="Editar">
                                        <i class="fas fa-edit mr-1"></i> Editar
                                        </a>

                                        <form action="{{ route('exames_medicos.destroy', $exame) }}" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja excluir este exame médico?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-2 bg-red-50 text-red-700 rounded hover:bg-red-100"
                                                title="Excluir">
                                                <i class="fas fa-trash mr-1"></i> Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Nenhum exame médico encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($exames->hasPages())
                <div class="p-4 border-t border-gray-200">
                    {{ $exames->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>