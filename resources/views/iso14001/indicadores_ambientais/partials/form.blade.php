@php $indicador = $indicador ?? null; @endphp

<div class="space-y-8">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-bar text-green-600"></i> Dados do Indicador
        </h3>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(25%-0.6rem)]">
                <label class="block text-sm font-medium text-gray-700">Código <span class="text-red-500">*</span></label>
                <input type="text" name="codigo" value="{{ old('codigo', $indicador->codigo ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('codigo') border-red-300 @enderror">
                @error('codigo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="w-full md:w-[calc(75%-0.4rem)]">
                <label class="block text-sm font-medium text-gray-700">Nome <span class="text-red-500">*</span></label>
                <input type="text" name="nome" value="{{ old('nome', $indicador->nome ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('nome') border-red-300 @enderror">
                @error('nome')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Descrição</label>
            <textarea name="descricao" rows="2"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('descricao', $indicador->descricao ?? '') }}</textarea>
        </div>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Categoria <span class="text-red-500">*</span></label>
                <select name="categoria"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    @foreach(['Emissões Atmosféricas','Recursos Hídricos','Energia','Resíduos','Biodiversidade','Uso do Solo','Ruído','Outros'] as $cat)
                        <option value="{{ $cat }}" {{ old('categoria', $indicador->categoria ?? '') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Responsável</label>
                <select name="responsavel_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">— Selecione —</option>
                    @foreach($usuarios as $id => $nome)
                        <option value="{{ $id }}" {{ old('responsavel_id', $indicador->responsavel_id ?? auth()->id()) == $id ? 'selected' : '' }}>{{ $nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-calculator text-blue-600"></i> Meta e Frequência
        </h3>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Fórmula</label>
                <input type="text" name="formula" value="{{ old('formula', $indicador->formula ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Meta</label>
                <input type="number" step="0.01" name="meta" value="{{ old('meta', $indicador->meta ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Unidade</label>
                <input type="text" name="unidade_medida" value="{{ old('unidade_medida', $indicador->unidade_medida ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div class="flex flex-wrap gap-4">
            <div class="w-full md:w-[calc(33%-0.7rem)]">
                <label class="block text-sm font-medium text-gray-700">Frequência</label>
                <select name="frequencia"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">—</option>
                    @foreach(['Mensal','Trimestral','Semestral','Anual'] as $f)
                        <option value="{{ $f }}" {{ old('frequencia', $indicador->frequencia ?? '') == $f ? 'selected' : '' }}>{{ $f }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-[calc(33%-0.7rem)]">
                <label class="block text-sm font-medium text-gray-700">Tipo de Meta</label>
                <select name="tipo_meta"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">—</option>
                    @foreach(['Maior que','Menor que','Igual a','Entre'] as $t)
                        <option value="{{ $t }}" {{ old('tipo_meta', $indicador->tipo_meta ?? '') == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-[calc(34%-0.6rem)] flex items-end">
                <label class="inline-flex items-center gap-2">
                    <input type="hidden" name="ativo" value="0">
                    <input type="checkbox" name="ativo" value="1"
                           {{ old('ativo', $indicador->ativo ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                    <span class="text-sm font-medium text-gray-700">Indicador ativo</span>
                </label>
            </div>
        </div>
    </div>
</div>