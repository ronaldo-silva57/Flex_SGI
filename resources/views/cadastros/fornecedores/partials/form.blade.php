<div class="space-y-8">
    {{-- Título --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-truck text-blue-500"></i> Informações do Fornecedor
        </h3>

        {{-- Linha 0: Código --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(15%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Código <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-barcode text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo" maxlength="50"
                           value="{{ old('codigo', $fornecedor->codigo ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('codigo') border-red-300 @enderror"
                           required>
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 1: Razão Social + Nome Fantasia --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="razao_social" class="block text-sm font-medium text-gray-700">
                    Razão Social <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-signature text-gray-400"></i>
                    </div>
                    <input type="text" id="razao_social" name="razao_social"
                           value="{{ old('razao_social', $fornecedor->razao_social ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('razao_social') border-red-300 @enderror"
                           required>
                </div>
                @error('razao_social') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="nome_fantasia" class="block text-sm font-medium text-gray-700">Nome Fantasia</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-store text-gray-400"></i>
                    </div>
                    <input type="text" id="nome_fantasia" name="nome_fantasia"
                           value="{{ old('nome_fantasia', $fornecedor->nome_fantasia ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nome_fantasia') border-red-300 @enderror">
                </div>
                @error('nome_fantasia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: CNPJ + Contato Nome --}}
        <div class="flex flex-wrap gap-4 items-end mt-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-id-card text-gray-400"></i>
                    </div>
                    <input type="text" id="cnpj" name="cnpj"
                           value="{{ old('cnpj', $fornecedor->cnpj ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('cnpj') border-red-300 @enderror">
                </div>
                @error('cnpj') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="contato_nome" class="block text-sm font-medium text-gray-700">Nome do Contato</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-circle text-gray-400"></i>
                    </div>
                    <input type="text" id="contato_nome" name="contato_nome"
                           value="{{ old('contato_nome', $fornecedor->contato_nome ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('contato_nome') border-red-300 @enderror">
                </div>
                @error('contato_nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: E-mail + Telefone --}}
        <div class="flex flex-wrap gap-4 items-end mt-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="contato_email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="contato_email" name="contato_email"
                           value="{{ old('contato_email', $fornecedor->contato_email ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('contato_email') border-red-300 @enderror">
                </div>
                @error('contato_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="contato_telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-gray-400"></i>
                    </div>
                    <input type="tel" id="contato_telefone" name="contato_telefone"
                           value="{{ old('contato_telefone', $fornecedor->contato_telefone ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('contato_telefone') border-red-300 @enderror">
                </div>
                @error('contato_telefone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 4: Categoria + Avaliação de Risco --}}
        <div class="flex flex-wrap gap-4 items-end mt-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="categoria" class="block text-sm font-medium text-gray-700">Categoria</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tags text-gray-400"></i>
                    </div>
                    <input type="text" id="categoria" name="categoria"
                           value="{{ old('categoria', $fornecedor->categoria ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('categoria') border-red-300 @enderror">
                </div>
                @error('categoria') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            @php
                $labels = [
                    1 => 'Muito Baixo',
                    2 => 'Baixo',
                    3 => 'Médio',
                    4 => 'Alto',
                    5 => 'Muito Alto',
                ]
            @endphp
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="avaliacao_risco" class="block text-sm font-medium text-gray-700">
                    Avaliação de Risco (1 a 5)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-chart-line text-gray-400"></i>
                    </div>
                    <select name="avaliacao_risco" id="avaliacao_risco"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('avaliacao_risco') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @foreach($labels as $valor => $texto)
                            <option value="{{ $valor }}"
                                {{ old('avaliacao_risco', $fornecedor->avaliacao_risco ?? '') == $valor ? 'selected' : '' }}>
                                {{ $valor }} - {{ $texto }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('avaliacao_risco')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Linha 5: Endereço (ocupando largura total) --}}
        <div class="mt-4">
            <label for="endereco" class="block text-sm font-medium text-gray-700">Endereço</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-start pt-2 pointer-events-none">
                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                </div>
                <textarea id="endereco" name="endereco" rows="3"
                          class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('endereco') border-red-300 @enderror">{{ old('endereco', $fornecedor->endereco ?? '') }}</textarea>
            </div>
            @error('endereco') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Linha 6: Ativo (checkbox) --}}
<div class="w-full md:w-[calc(50%-0.5rem)]">
    <label for="ativo" class="block text-sm font-medium text-gray-700">
        Ativo <span class="text-red-500">*</span>
    </label>
    <div class="relative mt-2">
        <input type="hidden" name="ativo" value="0">
        <label class="flex items-center cursor-pointer">
            <input type="checkbox" id="ativo" name="ativo" value="1"
                {{ old('ativo', $fornecedor->ativo ?? false) ? 'checked' : '' }}
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