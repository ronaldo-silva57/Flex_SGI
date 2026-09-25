<div class="space-y-8">
    {{-- Seção 1: Identificação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-ribbon text-indigo-600 mr-1"></i>Identificação do Treinamento
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Empresa --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? ($treinamento->empresa->razao_social ?? 'Empresa não definida') }}
                    </span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? $treinamento->empresa_id }}">
            </div>

            {{-- Responsável --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">
                    Responsável / Instrutor
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione um Responsável</option>
                        @foreach($usuarios as $user)
                            <option value="{{ $user->id }}" {{ old('responsavel_id', $treinamento->responsavel_id ?? '') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Título --}}
        <div class="w-full mb-4">
            <label for="titulo" class="block text-sm font-medium text-gray-700">
                Título do Treinamento <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $treinamento->titulo ?? '') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('titulo') border-red-300 @enderror"
                    placeholder="Ex: Treinamento Inteiro de Integração ISO 9001">
            </div>
            @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Descrição --}}
        <div class="w-full mb-4">
            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
            <div class="relative mt-1">
                <textarea id="descricao" name="descricao" rows="2"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('descricao') border-red-300 @enderror"
                    placeholder="Visão geral e objetivos do treinamento...">{{ old('descricao', $treinamento->descricao ?? '') }}</textarea>
            </div>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 2: Configurações do Treinamento --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-sliders text-indigo-600"></i>Configurações e Parâmetros
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Tipo --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">
                    Tipo <span class="text-red-500">*</span>
                </label>
                <select id="tipo" name="tipo"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('tipo') border-red-300 @enderror">
                    @foreach(['Obrigatório', 'Recomendado', 'Capacitação'] as $tipoOpt)
                        <option value="{{ $tipoOpt }}" {{ old('tipo', $treinamento->tipo ?? '') == $tipoOpt ? 'selected' : '' }}>
                            {{ $tipoOpt }}
                        </option>
                    @endforeach
                </select>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Carga Horária --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="carga_horaria" class="block text-sm font-medium text-gray-700">Carga Horária (Horas)</label>
                <input type="number" id="carga_horaria" name="carga_horaria" value="{{ old('carga_horaria', $treinamento->carga_horaria ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('carga_horaria') border-red-300 @enderror"
                    placeholder="Ex: 8">
                @error('carga_horaria') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Validade em Meses --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="validade_meses" class="block text-sm font-medium text-gray-700">Validade (Meses)</label>
                <input type="number" id="validade_meses" name="validade_meses" value="{{ old('validade_meses', $treinamento->validade_meses ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('validade_meses') border-red-300 @enderror"
                    placeholder="Ex: 12">
                @error('validade_meses') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Status --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" name="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-300 @enderror">
                    <option value="Ativo" {{ old('status', $treinamento->status ?? 'Ativo') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="Inativo" {{ old('status', $treinamento->status ?? '') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                </select>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Conteúdo Programático --}}
        <div class="w-full mb-4">
            <label for="conteudo" class="block text-sm font-medium text-gray-700">Conteúdo Programático</label>
            <div class="relative mt-1">
                <textarea id="conteudo" name="conteudo" rows="4"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('conteudo') border-red-300 @enderror"
                    placeholder="Detalhamento do conteúdo, módulos ou ementa do treinamento...">{{ old('conteudo', $treinamento->conteudo ?? '') }}</textarea>
            </div>
            @error('conteudo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>