<div class="space-y-8">
    {{-- Título --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-file-alt text-blue-500"></i>Informações da Norma
        </h3>

        {{-- Linha 1: Código + Nome --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Código <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-barcode text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo"
                        value="{{ old('codigo', $norma->codigo ?? '')}}"
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
                        value="{{ old('nome', $norma->nome ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nome') border-red-300 @enderror">
                </div>
                @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Versão + Descrição --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="versao" class="block text-sm font-medium text-gray-700">
                    Versão <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-code-branch text-gray-400"></i>
                    </div>
                    <input type="text" id="versao" name="versao"
                        value="{{ old('versao', $norma->versao ?? '')}}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('versao') border-red-300 @enderror"
                        required>
                </div>
                @error('versao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-start pointer-events-none">
                        <i class="fas fa-align-left text-gray-400 mt-2"></i>
                    </div>
                    <textarea id="descricao" name="descricao"
                        class="pl-10 block w-full  resize rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descricao') border-red-300 @enderror">{{ old('descricao', $norma->descricao ?? '') }}</textarea>
                </div>
                @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

        </div>

        {{-- Linha 3: Ativo --}}
        <div class="w-full md:w-[calc(50%-0.5rem)]">
            <label for="ativo" class="block text-sm font-medium text-gray-700">
                Ativo <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-2">
                <input type="hidden" name="ativo" value="0">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="ativo" name="ativo" value="1"
                        {{ old('ativo', $norma->ativo ?? false) ? 'checked' : '' }}
                        class="sr-only peer">

                    <div class="w-11 h-6 bg-gray-200 rounded-full transition
                                peer-checked:bg-green-500
                                after:content-[''] after:absolute after:top-1 after:left-1
                                after:bg-white after:rounded-full after:h-4 after:w-4
                                after:transition-all peer-checked:after:translate-x-5">
                    </div>
                </label>
            </div>
            @error('ativo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>
