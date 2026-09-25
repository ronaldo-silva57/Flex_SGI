@php $objetivo = $objetivo ?? null; @endphp

<div class="space-y-8">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-bullseye text-green-600"></i> Dados do Objetivo
        </h3>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(33%-0.7rem)]">
                <label class="block text-sm font-medium text-gray-700">Código <span class="text-red-500">*</span></label>
                <input type="text" name="codigo" value="{{ old('codigo', $objetivo->codigo ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('codigo') border-red-300 @enderror">
                @error('codigo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="w-full md:w-[calc(67%-0.3rem)]">
                <label class="block text-sm font-medium text-gray-700">Título <span class="text-red-500">*</span></label>
                <input type="text" name="titulo" value="{{ old('titulo', $objetivo->titulo ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('titulo') border-red-300 @enderror">
                @error('titulo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Descrição</label>
            <textarea name="descricao" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('descricao') border-red-300 @enderror">{{ old('descricao', $objetivo->descricao ?? '') }}</textarea>
            @error('descricao')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Aspecto Ambiental relacionado</label>
                <select name="aspecto_ambiental_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">— Nenhum —</option>
                    @foreach($aspectos as $id => $desc)
                        <option value="{{ $id }}" {{ old('aspecto_ambiental_id', $objetivo->aspecto_ambiental_id ?? '') == $id ? 'selected' : '' }}>
                            {{ Str::limit($desc, 80) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Responsável</label>
                <select name="responsavel_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">— Selecione —</option>
                    @foreach($usuarios as $id => $nome)
                        <option value="{{ $id }}" {{ old('responsavel_id', $objetivo->responsavel_id ?? auth()->id()) == $id ? 'selected' : '' }}>
                            {{ $nome }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-line text-blue-600"></i> Indicador e Meta
        </h3>

        <div class="flex flex-wrap gap-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Indicador</label>
                <input type="text" name="indicador" value="{{ old('indicador', $objetivo->indicador ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Meta</label>
                <input type="number" step="0.01" name="meta" value="{{ old('meta', $objetivo->meta ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Unidade</label>
                <input type="text" name="unidade_medida" value="{{ old('unidade_medida', $objetivo->unidade_medida ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-calendar text-amber-600"></i> Prazos, Progresso e Status
        </h3>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Início</label>
                <input type="date" name="data_inicio" value="{{ old('data_inicio', optional($objetivo->data_inicio ?? null)->format('Y-m-d') ?? ($objetivo->data_inicio ?? '')) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Prazo</label>
                <input type="date" name="prazo" value="{{ old('prazo', optional($objetivo->prazo ?? null)->format('Y-m-d') ?? ($objetivo->prazo ?? '')) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Conclusão</label>
                <input type="date" name="data_conclusao" value="{{ old('data_conclusao', optional($objetivo->data_conclusao ?? null)->format('Y-m-d') ?? ($objetivo->data_conclusao ?? '')) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Progresso (%)</label>
                <input type="number" min="0" max="100" name="progresso"
                       value="{{ old('progresso', $objetivo->progresso ?? 0) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div class="flex flex-wrap gap-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select name="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    @foreach(['Planejado','Em andamento','Concluído','Cancelado','Atrasado'] as $st)
                        <option value="{{ $st }}" {{ old('status', $objetivo->status ?? 'Planejado') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Evidência</label>
                <input type="text" name="evidencia" value="{{ old('evidencia', $objetivo->evidencia ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div class="flex flex-wrap gap-4 mt-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Recursos Necessários</label>
                <textarea name="recursos_necessarios" rows="2"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('recursos_necessarios', $objetivo->recursos_necessarios ?? '') }}</textarea>
            </div>
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Responsáveis pela Execução</label>
                <textarea name="responsaveis_execucao" rows="2"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('responsaveis_execucao', $objetivo->responsaveis_execucao ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>