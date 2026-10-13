<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Código --}}
        <div>
            <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-barcode text-gray-400"></i>
                </div>
                <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $cargo->codigo ?? '') }}" 
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('codigo') border-red-300 @enderror"
                    placeholder="Ex: CARG-001">
            </div>
            @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Nome do Cargo --}}
        <div>
            <label for="nome" class="block text-sm font-medium text-gray-700">
                Nome do Cargo <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user-tie text-gray-400"></i>
                </div>
                <input type="text" id="nome" name="nome" value="{{ old('nome', $cargo->nome ?? '') }}"
                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('nome') border-red-300 @enderror" required>
            </div>
            @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Empresa (Hidden + Display) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Empresa</label>
            <div class="mt-1 flex items-center gap-2 p-2.5 border border-gray-200 rounded-md bg-gray-50">
                <i class="fas fa-building text-gray-400"></i>
                <span class="text-gray-700 text-sm">
                    {{ $empresa->razao_social ?? 'Empresa não definida' }}
                </span>
            </div>
            <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? $cargo->empresa_id }}">
        </div>

        {{-- Departamento --}}
        <div>
            <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-sitemap text-gray-400"></i>
                </div>
                <select id="departamento_id" name="departamento_id"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('departamento_id') border-red-300 @enderror">
                    <option value="">Selecione um Departamento</option>
                    @foreach($departamentos as $departamento)
                        <option value="{{ $departamento->id }}" {{ old('departamento_id', $cargo->departamento_id ?? '') == $departamento->id ? 'selected' : '' }}>
                            {{ $departamento->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('departamento_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Descrição --}}
        <div>
            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição / Atribuições</label>
            <div class="mt-1">
                <textarea id="descricao" name="descricao" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('descricao') border-red-300 @enderror"
                    placeholder="Resumo das responsabilidades do cargo...">{{ old('descricao', $cargo->descricao ?? '') }}</textarea>
            </div>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Requisitos --}}
        <div>
            <label for="requisitos" class="block text-sm font-medium text-gray-700">Requisitos e Qualificações</label>
            <div class="mt-1">
                <textarea id="requisitos" name="requisitos" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('requisitos') border-red-300 @enderror"
                    placeholder="Escolaridade, experiência ou formações exigidas...">{{ old('requisitos', $cargo->requisitos ?? '') }}</textarea>
            </div>
            @error('requisitos') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Status Ativo --}}
    <div>
        <label for="ativo" class="block text-sm font-medium text-gray-700">Ativo</label>
        <div class="relative mt-2">
            <input type="hidden" name="ativo" value="0">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" id="ativo" name="ativo" value="1"
                    {{ old('ativo', $cargo->ativo ?? true) ? 'checked' : '' }}
                    class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-green-500 relative transition">
                    <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-5"></div>
                </div>
            </label>
        </div>
        @error('ativo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>