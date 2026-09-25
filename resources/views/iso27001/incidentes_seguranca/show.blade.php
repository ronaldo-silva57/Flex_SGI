<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-shield-alt text-red-600"></i>
                Detalhes do Incidente #{{ $incidentesSeguranca->id }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('incidentes_seguranca.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('incidentes_seguranca.edit', $incidentesSeguranca) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    <i class="fas fa-edit mr-2"></i>Editar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Data da Ocorrência</label>
                    <p class="mt-1 text-sm font-medium text-gray-900">
                        {{ $incidentesSeguranca->data_ocorrencia ? \Carbon\Carbon::parse($incidentesSeguranca->data_ocorrencia)->format('d/m/Y H:i') : '-' }}
                    </p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Tipo</label>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $incidentesSeguranca->tipo }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Status</label>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $incidentesSeguranca->status }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Ativo Afetado</label>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $incidentesSeguranca->ativo?->nome ?? 'Não associado' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase">Responsável</label>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $incidentesSeguranca->responsavel?->name ?? 'Não definido' }}</p>
                </div>
            </div>

            <div class="mt-6 border-t pt-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Descrição</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded-md">{{ $incidentesSeguranca->descricao }}</p>
            </div>

            @if($incidentesSeguranca->impacto)
            <div class="mt-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Impacto</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded-md">{{ $incidentesSeguranca->impacto }}</p>
            </div>
            @endif

            @if($incidentesSeguranca->acao_imediata)
            <div class="mt-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Ação Imediata</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded-md">{{ $incidentesSeguranca->acao_imediata }}</p>
            </div>
            @endif

            @if($incidentesSeguranca->investigacao)
            <div class="mt-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Investigação</label>
                <p class="text-gray-800 bg-gray-50 p-3 rounded-md">{{ $incidentesSeguranca->investigacao }}</p>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>