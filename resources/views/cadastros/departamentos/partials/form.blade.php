<div class="space-y-8">
    {{-- Seção 1: Informações do Departamento --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-sitemap text-blue-500"></i> Informações do Departamento
        </h3>

        {{-- Linha 1: Código + Nome --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $departamento->codigo ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('codigo') border-red-300 @enderror"
                           maxlength="50">
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="nome" class="block text-sm font-medium text-gray-700">Departamento <span class="text-red-500">*</span></label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <input type="text" id="nome" name="nome" value="{{ old('nome', $departamento->nome ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nome') border-red-300 @enderror"
                           required>
                </div>
                @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Descrição --}}
        <div class="mt-4">
            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 pt-3 pointer-events-none">
                    <i class="fas fa-align-left text-gray-400"></i>
                </div>
                <textarea id="descricao" name="descricao" rows="3"
                          class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descricao') border-red-300 @enderror">{{ old('descricao', $departamento->descricao ?? '') }}</textarea>
            </div>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Linha 3: Ativo (checkbox) --}}
        <div class="flex flex-wrap gap-4 items-center mt-4">
            <div class="flex items-center">
                <input type="checkbox" id="ativo" name="ativo" value="1"
                       {{ old('ativo', $departamento->ativo ?? true) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="ativo" class="ml-2 block text-sm text-gray-900">
                    <i class="fas fa-toggle-on text-gray-400 mr-1"></i> Ativo
                </label>
            </div>
            @error('ativo') <p class="ml-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 2: Vinculações (Empresa e Responsável) --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-link text-blue-500"></i> Vinculações
        </h3>

        <div class="flex flex-wrap gap-4 items-end">
            
            {{-- Empresa --}}
            
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Empresa <span class="text-red-500">*</span></label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-blue-500"></i>
                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? 'Empresa não definida' }}
                    </span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
            </div>
            
            {{-- Responsável --}}
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Responsável <span class="text-red-500">*</span></label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-user text-green-500"></i>
                    <span class="text-gray-700">
                        {{ $usuarioLogado->name ?? 'Usuário não definido' }}
                    </span>
                </div>
                <input type="hidden" name="responsavel_id" value="{{ $usuarioLogado->id }}">
            </div>
        </div>
    </div>
</div>