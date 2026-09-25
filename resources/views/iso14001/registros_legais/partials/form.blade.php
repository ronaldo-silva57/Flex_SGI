<div class="space-y-8">
    {{-- Informações Principais --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-gavel text-blue-600 mr-1"></i>Dados do Registro Legal
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="numero" class="block text-sm font-medium text-gray-700">Número</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-gray-400"></i>
                    </div>
                    <input type="text" id="numero" name="numero" value="{{ old('numero', $registro->numero ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('numero') border-red-300 @enderror">
                </div>
                @error('numero') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="orgao" class="block text-sm font-medium text-gray-700">Órgão</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-building text-gray-400"></i>
                    </div>
                    <input type="text" id="orgao" name="orgao" value="{{ old('orgao', $registro->orgao ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('orgao') border-red-300 @enderror">
                </div>
                @error('orgao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo <span class="text-red-500">*</span></label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <select id="tipo" name="tipo"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tipo') border-red-300 @enderror">
                        <option value="">Selecione o tipo</option>
                        @foreach(['Lei', 'Decreto', 'Normativa', 'Convênio', 'Resolução'] as $tipoOption)
                            <option value="{{ $tipoOption }}" {{ old('tipo', $registro->tipo ?? '') == $tipoOption ? 'selected' : '' }}>
                                {{ $tipoOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-toggle-on text-gray-400"></i>
                    </div>
                    <select id="status" name="status"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror">
                        @foreach(['Vigente', 'Revogado', 'Em revisão'] as $statusOption)
                            <option value="{{ $statusOption }}" {{ old('status', $registro->status ?? 'Vigente') == $statusOption ? 'selected' : '' }}>
                                {{ $statusOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_publicacao" class="block text-sm font-medium text-gray-700">Data de Publicação</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-day text-gray-400"></i>
                    </div>
                    <input type="date" id="data_publicacao" name="data_publicacao"
                           value="{{ old('data_publicacao', isset($registro) ? $registro->data_publicacao?->format('Y-m-d') : '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_publicacao') border-red-300 @enderror">
                </div>
                @error('data_publicacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_vigencia" class="block text-sm font-medium text-gray-700">Data de Vigência</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>
                    <input type="date" id="data_vigencia" name="data_vigencia"
                           value="{{ old('data_vigencia', isset($registro) ? $registro->data_vigencia?->format('Y-m-d') : '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_vigencia') border-red-300 @enderror">
                </div>
                @error('data_vigencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Descrição e Norma Associada --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-file-contract text-blue-600"></i>Detalhamento
        </h3>

        <div class="flex flex-wrap gap-4 items-start mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição <span class="text-red-500">*</span></label>
                <div class="mt-1">
                    <textarea id="descricao" name="descricao" rows="4"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descricao') border-red-300 @enderror"
                              placeholder="Descreva o conteúdo do registro legal...">{{ old('descricao', $registro->descricao ?? '') }}</textarea>
                </div>
                @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="norma_id" class="block text-sm font-medium text-gray-700">Norma Associada</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-book text-gray-400"></i>
                    </div>
                    <select id="norma_id" name="norma_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('norma_id') border-red-300 @enderror">
                        <option value="">Selecione uma norma</option>
                        @foreach($normas as $norma)
                            <option value="{{ $norma->id }}" {{ old('norma_id', $registro->norma_id ?? '') == $norma->id ? 'selected' : '' }}>
                                {{ $norma->codigo }} - {{ $norma->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('norma_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Empresa (fixa) --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Empresa --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? ($treinamentos->empresa->razao_social ?? 'Empresa não definida') }}
                    </span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? $treinamentos->empresa_id }}">
            </div>

        {{-- Arquivo (path) --}}
        <div class="mt-4">
            <label for="arquivo_path" class="block text-sm font-medium text-gray-700">Caminho do Arquivo (URL)</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-link text-gray-400"></i>
                </div>
                <input type="text" id="arquivo_path" name="arquivo_path"
                       value="{{ old('arquivo_path', $registro->arquivo_path ?? '') }}"
                       placeholder="Ex: /documentos/lei123.pdf"
                       class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('arquivo_path') border-red-300 @enderror">
            </div>
            @error('arquivo_path') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>