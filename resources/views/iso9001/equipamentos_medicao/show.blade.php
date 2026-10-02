<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2"><i class="fas fa-ruler-combined text-blue-500"></i>Detalhes: {{ $equipamento->nome }}</h2>
            <div class="flex space-x-4">
                <a href="{{ route('equipamentos_medicao.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition shadow-sm border border-blue-200"><i class="fas fa-arrow-left mr-2"></i>Voltar</a>
                <a href="{{ route('equipamentos_medicao.edit', $equipamento) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm"><i class="fas fa-edit mr-2"></i>Editar</a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        @if(session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm"><i class="fas fa-check-circle text-green-500 mr-3"></i>{{ session('success') }}</div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200"><div class="flex items-center justify-between mb-2"><span class="text-sm font-medium text-gray-500">Código</span><i class="fas fa-barcode text-blue-500"></i></div><span class="text-2xl font-bold font-mono text-gray-900">{{ $equipamento->codigo }}</span></div>
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200"><div class="flex items-center justify-between mb-2"><span class="text-sm font-medium text-gray-500">Status</span><i class="fas fa-toggle-on text-green-500"></i></div><span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold @if($equipamento->status === 'Ativo') bg-green-100 text-green-800 @elseif($equipamento->status === 'Em manutenção') bg-yellow-100 text-yellow-800 @elseif($equipamento->status === 'Inativo') bg-gray-100 text-gray-800 @else bg-red-100 text-red-800 @endif">{{ $equipamento->status }}</span></div>
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-200"><div class="flex items-center justify-between mb-2"><span class="text-sm font-medium text-gray-500">Próxima calibração</span><i class="fas fa-calendar-alt text-indigo-500"></i></div><span class="text-2xl font-bold text-gray-900">{{ $equipamento->proxima_calibracao?->format('d/m/Y') ?? '—' }}</span></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2"><i class="fas fa-info-circle text-blue-500"></i>Informações</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach([
                            'Marca/Modelo' => trim($equipamento->marca.' '.$equipamento->modelo) ?: '—',
                            'Nº de série' => $equipamento->numero_serie ?? '—',
                            'Faixa de medição' => $equipamento->faixa_medicao ?? '—',
                            'Resolução' => $equipamento->resolucao ?? '—',
                            'Localização' => $equipamento->localizacao ?? '—',
                            'Responsável' => $equipamento->responsavel?->name ?? '—',
                            'Periodicidade' => $equipamento->periodicidade_calibracao_meses ? $equipamento->periodicidade_calibracao_meses.' meses' : '—',
                            'Última calibração' => $equipamento->ultima_calibracao?->format('d/m/Y') ?? '—',
                        ] as $label => $value)
                            <div><span class="block text-sm font-medium text-gray-500">{{ $label }}</span><span class="mt-1 text-base text-gray-900">{{ $value }}</span></div>
                        @endforeach
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                        <form action="{{ route('equipamentos_medicao.destroy', $equipamento) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este equipamento?');">@csrf @method('DELETE')<button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 rounded-md text-red-700 hover:bg-red-50 transition"><i class="fas fa-trash-alt mr-2"></i>Excluir</button></form>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200"><h3 class="text-lg font-medium text-gray-900 flex items-center gap-2"><i class="fas fa-history text-blue-500"></i>Histórico de Calibrações</h3></div>
                    <div class="overflow-x-auto"><table class="min-w-full"><thead class="bg-gray-100"><tr>
                        @foreach(['Data','Validade','Laboratório','Certificado','Resultado','Responsável'] as $heading)<th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wide">{{ $heading }}</th>@endforeach
                    </tr></thead><tbody class="divide-y divide-gray-200">
                        @forelse($equipamento->calibracoes as $c)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-indigo-50 transition"><td class="px-4 py-3 text-sm">{{ $c->data_calibracao->format('d/m/Y') }}</td><td class="px-4 py-3 text-sm">{{ $c->data_validade->format('d/m/Y') }}</td><td class="px-4 py-3 text-sm">{{ $c->laboratorio ?? '—' }}</td><td class="px-4 py-3 text-sm font-mono">{{ $c->certificado_numero ?? '—' }}</td><td class="px-4 py-3 text-sm"><span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium @if($c->resultado === 'Aprovado') bg-green-100 text-green-800 @elseif($c->resultado === 'Aprovado com restrição') bg-yellow-100 text-yellow-800 @else bg-red-100 text-red-800 @endif">{{ $c->resultado }}</span></td><td class="px-4 py-3 text-sm text-gray-600">{{ $c->responsavel?->name ?? '—' }}</td></tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-10 text-center text-gray-500"><i class="fas fa-inbox text-3xl mb-2 block text-gray-300"></i>Sem calibrações registradas.</td></tr>
                        @endforelse
                    </tbody></table></div>
                </div>
            </div>

            <div>
                <div class="bg-white p-6 rounded-lg shadow-sm sticky top-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2"><i class="fas fa-plus-circle text-indigo-500"></i>Nova calibração</h3>
                    <form method="POST" action="{{ route('calibracoes.store', $equipamento) }}" class="space-y-4">
                        @csrf
                        <div><label for="data_calibracao" class="block text-sm font-medium text-gray-700">Data da calibração <span class="text-red-500">*</span></label><input type="date" id="data_calibracao" name="data_calibracao" required value="{{ old('data_calibracao', now()->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></div>
                        <div><label for="data_validade" class="block text-sm font-medium text-gray-700">Validade <span class="text-red-500">*</span></label><input type="date" id="data_validade" name="data_validade" required value="{{ old('data_validade') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></div>
                        <div><label for="laboratorio" class="block text-sm font-medium text-gray-700">Laboratório</label><input type="text" id="laboratorio" name="laboratorio" value="{{ old('laboratorio') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></div>
                        <div><label for="certificado_numero" class="block text-sm font-medium text-gray-700">Nº certificado</label><input type="text" id="certificado_numero" name="certificado_numero" value="{{ old('certificado_numero') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></div>
                        <div><label for="resultado" class="block text-sm font-medium text-gray-700">Resultado <span class="text-red-500">*</span></label><select id="resultado" name="resultado" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"><option>Aprovado</option><option>Aprovado com restrição</option><option>Reprovado</option></select></div>
                        <div><label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label><textarea id="observacoes" name="observacoes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('observacoes') }}</textarea></div>
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition shadow-sm"><i class="fas fa-save mr-2"></i>Salvar calibração</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
