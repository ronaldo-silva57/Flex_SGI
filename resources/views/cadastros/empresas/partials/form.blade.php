<div class="space-y-8">
    {{-- Seção 1: Dados Principais --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-building text-blue-500"></i> Dados Principais
        </h3>

        {{-- Linha 1: Código + Razão Social --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $empresa->codigo ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('codigo') border-red-300 @enderror"
                           maxlength="50">
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="razao_social" class="block text-sm font-medium text-gray-700">Razão Social <span class="text-red-500">*</span></label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-signature text-gray-400"></i>
                    </div>
                    <input type="text" id="razao_social" name="razao_social" value="{{ old('razao_social', $empresa->razao_social ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('razao_social') border-red-300 @enderror"
                           required>
                </div>
                @error('razao_social') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Nome Fantasia + CNPJ --}}
        <div class="flex flex-wrap gap-4 items-end mt-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="nome_fantasia" class="block text-sm font-medium text-gray-700">Nome Fantasia</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-store text-gray-400"></i>
                    </div>
                    <input type="text" id="nome_fantasia" name="nome_fantasia" value="{{ old('nome_fantasia', $empresa->nome_fantasia ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nome_fantasia') border-red-300 @enderror">
                </div>
                @error('nome_fantasia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ <span class="text-red-500">*</span></label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-id-card text-gray-400"></i>
                    </div>
                    <input type="text" id="cnpj" name="cnpj" value="{{ old('cnpj', $empresa->cnpj ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('cnpj') border-red-300 @enderror"
                           required>
                </div>
                @error('cnpj') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Inscrição Estadual (sozinha) --}}
        <div class="flex flex-wrap gap-4 items-end mt-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="ie" class="block text-sm font-medium text-gray-700">Inscrição Estadual</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-registered text-gray-400"></i>
                    </div>
                    <input type="text" id="ie" name="ie" value="{{ old('ie', $empresa->ie ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('ie') border-red-300 @enderror">
                </div>
                @error('ie') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 2: Endereço --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-map-pin text-blue-500"></i> Endereço
        </h3>

        {{-- Linha 4: Endereço + Cidade --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="endereco" class="block text-sm font-medium text-gray-700">Endereço</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                    </div>
                    <input type="text" id="endereco" name="endereco" value="{{ old('endereco', $empresa->endereco ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('endereco') border-red-300 @enderror">
                </div>
                @error('endereco') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-city text-gray-400"></i>
                    </div>
                    <input type="text" id="cidade" name="cidade" value="{{ old('cidade', $empresa->cidade ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('cidade') border-red-300 @enderror">
                </div>
                @error('cidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 5: Estado + CEP --}}
        <div class="flex flex-wrap gap-4 items-end mt-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flag text-gray-400"></i>
                    </div>
                    <input type="text" id="estado" name="estado" value="{{ old('estado', $empresa->estado ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('estado') border-red-300 @enderror"
                           maxlength="2">
                </div>
                @error('estado') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="cep" class="block text-sm font-medium text-gray-700">CEP</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-mailbox text-gray-400"></i>
                    </div>
                    <input type="text" id="cep" name="cep" value="{{ old('cep', $empresa->cep ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('cep') border-red-300 @enderror"
                           maxlength="10">
                </div>
                @error('cep') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 3: Contato e Status --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-phone-alt text-blue-500"></i> Contato e Status
        </h3>

        {{-- Linha 6: Telefone + Email --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="telefone" class="block text-sm font-medium text-gray-700">Telefone</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-gray-400"></i>
                    </div>
                    <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $empresa->telefone ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('telefone') border-red-300 @enderror"
                           maxlength="20">
                </div>
                @error('telefone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email', $empresa->email ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 @enderror">
                </div>
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 7: Ativo (checkbox estilizado) --}}
        <div class="flex flex-wrap gap-4 items-center mt-4">
            <div class="flex items-center">
                <input type="checkbox" id="ativo" name="ativo" value="1"
                       {{ old('ativo', $empresa->ativo ?? true) ? 'checked' : '' }}
                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="ativo" class="ml-2 block text-sm text-gray-900">
                    <i class="fas fa-toggle-on text-gray-400 mr-1"></i> Ativo
                </label>
            </div>
            @error('ativo') <p class="ml-2 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>