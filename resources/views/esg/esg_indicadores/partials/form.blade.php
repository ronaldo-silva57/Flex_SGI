<div class="space-y-8">
    {{-- Seção 1: Dados Gerais --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-ribbon text-emerald-600 mr-1"></i>Dados Gerais
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Empresa (fixa) --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">{{ $empresa->razao_social ?? 'Empresa não definida' }}</span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
            </div>

            {{-- Responsável --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">
                    Responsável
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione um responsável</option>
                        @foreach($responsaveis as $user)
                            <option value="{{ $user->id }}" {{ old('responsavel_id', $esgIndicador->responsavel_id ?? auth()->id()) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Dimensão --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="dimensao" class="block text-sm font-medium text-gray-700">
                    Dimensão <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-layer-group text-gray-400"></i>
                    </div>
                    <select id="dimensao" name="dimensao"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('dimensao') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @foreach($dimensoes as $dim)
                            <option value="{{ $dim }}" {{ old('dimensao', $esgIndicador->dimensao ?? '') == $dim ? 'selected' : '' }}>
                                {{ $dim }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('dimensao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Código --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Código <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo"
                           value="{{ old('codigo', $esgIndicador->codigo ?? '') }}"
                           placeholder="Ex: ESG-001"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('codigo') border-red-300 @enderror">
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Nome --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="nome" class="block text-sm font-medium text-gray-700">
                    Nome <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-font text-gray-400"></i>
                    </div>
                    <input type="text" id="nome" name="nome"
                           value="{{ old('nome', $esgIndicador->nome ?? '') }}"
                           placeholder="Nome do indicador"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('nome') border-red-300 @enderror">
                </div>
                @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Descrição --}}
        <div class="w-full mb-4">
            <label for="descricao" class="block text-sm font-medium text-gray-700">
                Descrição
            </label>
            <div class="relative mt-1">
                <textarea id="descricao" name="descricao" rows="3"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('descricao') border-red-300 @enderror"
                          placeholder="Descreva o indicador...">{{ old('descricao', $esgIndicador->descricao ?? '') }}</textarea>
            </div>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 2: Metas e Frequência --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-bullseye text-emerald-600"></i>Metas e Frequência
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="meta" class="block text-sm font-medium text-gray-700">
                    Meta
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flag-checkered text-gray-400"></i>
                    </div>
                    <input type="number" step="0.01" id="meta" name="meta"
                           value="{{ old('meta', $esgIndicador->meta ?? '') }}"
                           placeholder="Valor da meta"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('meta') border-red-300 @enderror">
                </div>
                @error('meta') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="unidade_medida" class="block text-sm font-medium text-gray-700">
                    Unidade de Medida
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-ruler text-gray-400"></i>
                    </div>
                    <input type="text" id="unidade_medida" name="unidade_medida"
                           value="{{ old('unidade_medida', $esgIndicador->unidade_medida ?? '') }}"
                           placeholder="Ex: %, tCO₂, R$"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('unidade_medida') border-red-300 @enderror">
                </div>
                @error('unidade_medida') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="frequencia" class="block text-sm font-medium text-gray-700">
                    Frequência de Medição <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-clock text-gray-400"></i>
                    </div>
                    <select id="frequencia" name="frequencia"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('frequencia') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @foreach($frequencias as $freq)
                            <option value="{{ $freq }}" {{ old('frequencia', $esgIndicador->frequencia ?? '') == $freq ? 'selected' : '' }}>
                                {{ $freq }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('frequencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="referencia_gri" class="block text-sm font-medium text-gray-700">
                    Referência GRI
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-book text-gray-400"></i>
                    </div>
                    <input type="text" id="referencia_gri" name="referencia_gri"
                           value="{{ old('referencia_gri', $esgIndicador->referencia_gri ?? '') }}"
                           placeholder="Ex: GRI 302-1"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 @error('referencia_gri') border-red-300 @enderror">
                </div>
                @error('referencia_gri') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 3: Status --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-toggle-on text-emerald-600"></i>Status
        </h3>

        <div class="flex items-center gap-4">
            <label for="ativo" class="inline-flex items-center">
                <input type="checkbox" id="ativo" name="ativo" value="1"
                       {{ old('ativo', $esgIndicador->ativo ?? true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500">
                <span class="ml-2 text-sm text-gray-700">Ativo</span>
            </label>
        </div>
        @error('ativo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>