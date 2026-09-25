<div class="space-y-8">
    {{-- Seção 1: Identificação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-ribbon text-blue-600 mr-1"></i>Identificação do EPI
        </h3>

        {{-- Empresa (fixa) --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">
                Empresa <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                <i class="fas fa-building text-gray-400"></i>
                <span class="text-gray-700">
                    {{ $empresa->razao_social ?? ($epi->empresa->razao_social ?? 'Empresa não definida') }}
                </span>
            </div>
            <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? '' }}">
        </div>

        {{-- Linha: Nome + Categoria --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="nome" class="block text-sm font-medium text-gray-700">
                    Nome <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <input type="text" id="nome" name="nome"
                        value="{{ old('nome', $epi->nome ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nome') border-red-300 @enderror"
                        placeholder="Ex: Capacete de Segurança">
                </div>
                @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="categoria" class="block text-sm font-medium text-gray-700">
                    Categoria
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-list text-gray-400"></i>
                    </div>
                    <input type="text" id="categoria" name="categoria"
                        value="{{ old('categoria', $epi->categoria ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('categoria') border-red-300 @enderror"
                        placeholder="Ex: Cabeça, Proteção Respiratória">
                </div>
                @error('categoria') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Descrição (linha inteira) --}}
        <div class="w-full mb-4">
            <label for="descricao" class="block text-sm font-medium text-gray-700">
                Descrição
            </label>
            <div class="relative mt-1">
                <textarea id="descricao" name="descricao" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descricao') border-red-300 @enderror"
                    placeholder="Descrição detalhada do EPI (opcional)">{{ old('descricao', $epi->descricao ?? '') }}</textarea>
            </div>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Linha: CA + Validade --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="ca" class="block text-sm font-medium text-gray-700">
                    Certificado de Aprovação (CA)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-certificate text-gray-400"></i>
                    </div>
                    <input type="text" id="ca" name="ca"
                        value="{{ old('ca', $epi->ca ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('ca') border-red-300 @enderror"
                        placeholder="Número do CA">
                </div>
                @error('ca') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="validade_meses" class="block text-sm font-medium text-gray-700">
                    Validade (meses)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-clock text-gray-400"></i>
                    </div>
                    <input type="number" id="validade_meses" name="validade_meses"
                        value="{{ old('validade_meses', $epi->validade_meses ?? '') }}"
                        min="0"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('validade_meses') border-red-300 @enderror"
                        placeholder="Ex: 12">
                </div>
                @error('validade_meses') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 2: Estoque e Status --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-boxes text-blue-600"></i>Estoque e Status
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="estoque_minimo" class="block text-sm font-medium text-gray-700">
                    Estoque Mínimo
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-arrow-down text-gray-400"></i>
                    </div>
                    <input type="number" id="estoque_minimo" name="estoque_minimo"
                        value="{{ old('estoque_minimo', $epi->estoque_minimo ?? '') }}"
                        min="0"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('estoque_minimo') border-red-300 @enderror"
                        placeholder="Quantidade mínima">
                </div>
                @error('estoque_minimo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="estoque_atual" class="block text-sm font-medium text-gray-700">
                    Estoque Atual
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-box text-gray-400"></i>
                    </div>
                    <input type="number" id="estoque_atual" name="estoque_atual"
                        value="{{ old('estoque_atual', $epi->estoque_atual ?? 0) }}"
                        min="0"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('estoque_atual') border-red-300 @enderror"
                        placeholder="0">
                </div>
                @error('estoque_atual') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <div class="flex items-start mt-6">
                    <div class="flex items-center h-5">
                        <input id="ativo" name="ativo" type="checkbox"
                            value="1"
                            class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                            {{ old('ativo', $epi->ativo ?? true) ? 'checked' : '' }}>
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="ativo" class="font-medium text-gray-700">EPI ativo</label>
                        <p class="text-gray-500">Desative para impedir novas entregas.</p>
                    </div>
                </div>
                @error('ativo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>