<div class="space-y-8">
    {{-- Título --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-scroll text-blue-500"></i>Informações da Cláusula
        </h3>

        {{-- Linha 1: Norma + Código --}}
        <div class="flex flex-wrap gap-4 items-end">
            {{-- Norma (select) --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="norma_id" class="block text-sm font-medium text-gray-700">
                    Norma <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-book text-gray-400"></i>
                    </div>
                    <select id="norma_id" name="norma_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('norma_id') border-red-300 @enderror"
                        required>
                        <option value="">Selecione uma norma</option>
                        @foreach($normas as $norma)
                            <option value="{{ $norma->id }}"
                                {{ old('norma_id', $clausula->norma_id ?? '') == $norma->id ? 'selected' : '' }}>
                                {{ $norma->codigo }} - {{ $norma->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('norma_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Código --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Item <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo"
                        value="{{ old('codigo', $clausula->codigo ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('codigo') border-red-300 @enderror"
                        required>
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Título + Descrição --}}
        <div class="flex flex-wrap gap-4 items-end mt-4">
            {{-- Título --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="titulo" class="block text-sm font-medium text-gray-700">
                    Título <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-heading text-gray-400"></i>
                    </div>
                    <input type="text" id="titulo" name="titulo"
                        value="{{ old('titulo', $clausula->titulo ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('titulo') border-red-300 @enderror"
                        required>
                </div>
                @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Descrição --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-align-left text-gray-400"></i>
                </div>
                <textarea id="descricao" name="descricao" rows="4"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descricao') border-red-300 @enderror"
                    placeholder="Digite a descrição...">{{ old('descricao', $clausula->descricao ?? '') }}</textarea>
            </div>
            @error('descricao') 
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p> 
            @enderror
        </div>

        </div>

        {{-- Linha 3: Cláusula Pai + Ordem --}}
        <div class="flex flex-wrap gap-4 items-end mt-4">
            {{-- Cláusula pai --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="clausula_pai_id" class="block text-sm font-medium text-gray-700">
                    Cláusula pai
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-sitemap text-gray-400"></i>
                    </div>
                    <select id="clausula_pai_id" name="clausula_pai_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('clausula_pai_id') border-red-300 @enderror">
                        <option value="">Nenhuma (cláusula raiz)</option>
                        @foreach($clausulasPai as $pai)
                            <option value="{{ $pai->id }}"
                                {{ old('clausula_pai_id', $clausula->clausula_pai_id ?? '') == $pai->id ? 'selected' : '' }}>
                                {{ $pai->codigo }} - {{ $pai->titulo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('clausula_pai_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Ordem --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="ordem" class="block text-sm font-medium text-gray-700">
                    Ordem
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-sort-numeric-down text-gray-400"></i>
                    </div>
                    <input type="number" id="ordem" name="ordem"
                        value="{{ old('ordem', $clausula->ordem ?? 0) }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('ordem') border-red-300 @enderror">
                </div>
                @error('ordem') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 4: Ativo (switch) --}}
        <div class="w-full md:w-[calc(50%-0.5rem)] mt-4">
            <label for="ativo" class="block text-sm font-medium text-gray-700">
                Status <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-2">
                <input type="hidden" name="ativo" value="0">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="ativo" name="ativo" value="1"
                        {{ old('ativo', $clausula->ativo ?? true) ? 'checked' : '' }}
                        class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-green-500 relative transition">
                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-5"></div>
                    </div>
                    <span class="ml-3 text-sm text-gray-600 peer-checked:text-green-600">
                        {{ old('ativo', $clausula->ativo ?? true) ? 'Ativo' : 'Inativo' }}
                    </span>
                </label>
            </div>
            @error('ativo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>