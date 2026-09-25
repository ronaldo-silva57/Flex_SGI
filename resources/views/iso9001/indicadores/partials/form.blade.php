<div class="space-y-8">
    {{-- Título --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-chart-line text-blue-500"></i> Informações do Indicador
        </h3>

        {{-- Linha 1: Código + Nome --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Código <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-barcode text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo"
                        value="{{ old('codigo', $indicador->codigo ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('codigo') border-red-300 @enderror"
                        required>
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="nome" class="block text-sm font-medium text-gray-700">
                    Nome <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-signature text-gray-400"></i>
                    </div>
                    <input type="text" id="nome" name="nome"
                        value="{{ old('nome', $indicador->nome ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nome') border-red-300 @enderror"
                        required>
                </div>
                @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Descrição + Fórmula --}}
        <div class="flex flex-wrap gap-4 items-start mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                <div class="relative mt-1">
                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                        <i class="fas fa-align-left text-gray-400"></i>
                    </div>
                    <textarea id="descricao" name="descricao" rows="2"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descricao') border-red-300 @enderror">{{ old('descricao', $indicador->descricao ?? '') }}</textarea>
                </div>
                @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="formula" class="block text-sm font-medium text-gray-700">Fórmula</label>
                <div class="relative mt-1">
                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                        <i class="fas fa-calculator text-gray-400"></i>
                    </div>
                    <textarea id="formula" name="formula" rows="2"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('formula') border-red-300 @enderror">{{ old('formula', $indicador->formula ?? '') }}</textarea>
                </div>
                @error('formula') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Meta + Unidade de Medida --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="meta" class="block text-sm font-medium text-gray-700">Meta</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-bullseye text-gray-400"></i>
                    </div>
                    <input type="number" step="0.01" id="meta" name="meta"
                        value="{{ old('meta', $indicador->meta ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('meta') border-red-300 @enderror">
                </div>
                @error('meta') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="unidade_medida" class="block text-sm font-medium text-gray-700">Unidade de Medida</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-ruler text-gray-400"></i>
                    </div>
                    <input type="text" id="unidade_medida" name="unidade_medida"
                        value="{{ old('unidade_medida', $indicador->unidade_medida ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('unidade_medida') border-red-300 @enderror">
                </div>
                @error('unidade_medida') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 4: Frequência + Tipo de Meta --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="frequencia" class="block text-sm font-medium text-gray-700">Frequência</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-clock text-gray-400"></i>
                    </div>
                    <select id="frequencia" name="frequencia"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('frequencia') border-red-300 @enderror">
                        <option value="">Selecione...</option>
                        @foreach(['Diária', 'Semanal', 'Mensal', 'Trimestral', 'Semestral', 'Anual'] as $freq)
                            <option value="{{ $freq }}" {{ old('frequencia', $indicador->frequencia ?? '') == $freq ? 'selected' : '' }}>
                                {{ $freq }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('frequencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tipo_meta" class="block text-sm font-medium text-gray-700">Tipo de Meta</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-arrow-right text-gray-400"></i>
                    </div>
                    <select id="tipo_meta" name="tipo_meta"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tipo_meta') border-red-300 @enderror">
                        <option value="">Selecione...</option>
                        @foreach(['Maior que', 'Menor que', 'Igual a', 'Entre'] as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipo_meta', $indicador->tipo_meta ?? '') == $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo_meta') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 5: Empresa + Processo (relacionamentos) --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Empresa --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? ($indicadores->empresa->razao_social ?? 'Empresa não definida') }}
                    </span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="processo_id" class="block text-sm font-medium text-gray-700">Processo</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flowchart text-gray-400"></i>
                    </div>
                    <select id="processo_id" name="processo_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('processo_id') border-red-300 @enderror">
                        <option value="">Selecione o processo</option>
                        @foreach($processos as $processo)
                            <option value="{{ $processo->id }}" {{ old('processo_id', $indicador->processo_id ?? '') == $processo->id ? 'selected' : '' }}>
                                {{ $processo->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('processo_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 6: Norma + Responsável --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="norma_id" class="block text-sm font-medium text-gray-700">Norma</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-file-alt text-gray-400"></i>
                    </div>
                    <select id="norma_id" name="norma_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('norma_id') border-red-300 @enderror">
                        <option value="">Selecione a norma</option>
                        @foreach($normas as $norma)
                            <option value="{{ $norma->id }}" {{ old('norma_id', $indicador->norma_id ?? '') == $norma->id ? 'selected' : '' }}>
                                {{ $norma->codigo }} - {{ $norma->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('norma_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione o responsável</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_id', $indicador->responsavel_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 7: Ativo (toggle) --}}
        <div class="w-full md:w-[calc(50%-0.5rem)]">
            <label for="ativo" class="block text-sm font-medium text-gray-700">
                Ativo <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-2">
                <input type="hidden" name="ativo" value="0">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="ativo" name="ativo" value="1"
                        {{ old('ativo', $indicador->ativo ?? true) ? 'checked' : '' }}
                        class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-green-500 relative transition">
                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-5"></div>
                    </div>
                </label>
            </div>
            @error('ativo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>