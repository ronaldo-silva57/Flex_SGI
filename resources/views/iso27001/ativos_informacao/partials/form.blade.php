<div class="space-y-8">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-database text-purple-600 mr-1"></i>Dados do Ativo
        </h3>

        {{-- Empresa (fixa) --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">
                Empresa <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                <i class="fas fa-building text-gray-400"></i>
                <span class="text-gray-700">
                    {{ $empresa->razao_social ?? ($ativosInformacao->empresa->razao_social ?? 'Empresa não definida') }}
                </span>
            </div>
            <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? '' }}">
        </div>

        {{-- Nome + Tipo --}}
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
                        value="{{ old('nome', $ativosInformacao->nome ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('nome') border-red-300 @enderror"
                        placeholder="Ex: Servidor de Arquivos">
                </div>
                @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">
                    Tipo <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <select id="tipo" name="tipo"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('tipo') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @foreach(['Hardware', 'Software', 'Dados', 'Servico', 'Pessoas', 'Instalações', 'Intangível'] as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipo', $ativosInformacao->tipo ?? '') == $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Descrição --}}
        <div class="w-full mb-4">
            <label for="descricao" class="block text-sm font-medium text-gray-700">
                Descrição
            </label>
            <div class="relative mt-1">
                <textarea id="descricao" name="descricao" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('descricao') border-red-300 @enderror"
                    placeholder="Descrição detalhada do ativo">{{ old('descricao', $ativosInformacao->descricao ?? '') }}</textarea>
            </div>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Localização + Classificação --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="localizacao" class="block text-sm font-medium text-gray-700">
                    Localização
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                    </div>
                    <input type="text" id="localizacao" name="localizacao"
                        value="{{ old('localizacao', $ativosInformacao->localizacao ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('localizacao') border-red-300 @enderror"
                        placeholder="Ex: Sala 101, Data Center">
                </div>
                @error('localizacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="classificacao" class="block text-sm font-medium text-gray-700">
                    Classificação
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <select id="classificacao" name="classificacao"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('classificacao') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @foreach(['Público', 'Interno', 'Confidencial', 'Restrito'] as $class)
                            <option value="{{ $class }}" {{ old('classificacao', $ativosInformacao->classificacao ?? '') == $class ? 'selected' : '' }}>
                                {{ $class }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('classificacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Responsável + Proprietário --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">
                    Responsável
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-check text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_id', $ativosInformacao->responsavel_id ?? auth()->id()) == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="proprietario_id" class="block text-sm font-medium text-gray-700">
                    Proprietário
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-tie text-gray-400"></i>
                    </div>
                    <select id="proprietario_id" name="proprietario_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('proprietario_id') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('proprietario_id', $ativosInformacao->proprietario_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('proprietario_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Valor + Status --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="valor" class="block text-sm font-medium text-gray-700">
                    Valor (R$)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-dollar-sign text-gray-400"></i>
                    </div>
                    <input type="number" step="0.01" id="valor" name="valor"
                        value="{{ old('valor', $ativosInformacao->valor ?? '') }}"
                        min="0"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('valor') border-red-300 @enderror"
                        placeholder="0.00">
                </div>
                @error('valor') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flag text-gray-400"></i>
                    </div>
                    <select id="status" name="status"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('status') border-red-300 @enderror">
                        @foreach(['Ativo', 'Inativo', 'Descartado'] as $status)
                            <option value="{{ $status }}" {{ old('status', $ativosInformacao->status ?? 'Ativo') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>