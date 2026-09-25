<div class="space-y-8">
    {{-- Seção 1: Identificação e Relacionamentos --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-gears text-cyan-600 mr-1 mb-4"></i>Informações do Processo
        </h3>

        {{-- Linha 1: Código + Nome --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Código <span text-red-500>*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center point-events-none">
                        <i class="fas fa-barcode text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $processo->codigo ?? '') }}" 
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('codigo') border-red-300 @enderror"
                        required>
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="nome" class="block text-sm font-medium text-gray-700">
                    Processo <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-diagram-project text-gray-400"></i>
                    </div>
                    <input type="text" id="nome" name="nome" value="{{ old('nome', $processo->nome ?? '') }}"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('nome') border-red-300 @enderror" required>
                </div>
                @error ('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Empresa + Departamento --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa 
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? 'Empresa não definida' }}
                    </span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? $processo->empresa_id }}">
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-sitemap text-gray-400"></i>
                    </div>
                    <select id="departamento_id" name="departamento_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('departamento_id') border-red-300 @enderror">
                        <option value="">Selecione um Departamento</option>
                        @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id }}" {{ old('departamento_id', $processo->departamento_id ?? '') == $departamento->id ? 'selected' : '' }}>
                                {{ $departamento->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('departamento_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Responsável + Tipo --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">

                <div class="form-group mb-3">
                    <label for="responsavel_nome" class="form-label">Responsável</label>
                    
                    {{-- Exibe o nome do usuário logado (ou o responsável já salvo se for edição) --}}
               <input type="text" 
                        id="responsavel_nome" 
                        class="form-control" 
                        value="{{ optional($processo->responsavel)->name ?? auth()->user()->name }}" 
                        disabled readonly>

                    {{-- Envia o ID do responsável no formulário --}}
                    <input type="hidden" 
                        name="responsavel_id" 
                        value="{{ $processo->responsavel_id ?? auth()->id() }}">
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Processo</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-layer-group text-gray-400"></i>
                    </div>
                    <select id="tipo" name="tipo"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('tipo') border-red-300 @enderror">
                        <option value="">Selecione a Classificação</option>
                        @foreach(['Estratégico', 'Principal', 'Apoio'] as $tipoOption)
                            <option value="{{ $tipoOption }}" {{ old('tipo', $processo->tipo ?? '') == $tipoOption ? 'selected' : '' }}>
                                {{ $tipoOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 4: Descrição + Objetivo --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                <div class="relative mt-1">
                    <textarea id="descricao" name="descricao" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('descricao') border-red-300 @enderror"
                        placeholder="Resumo das atividades do processo...">{{ old('descricao', $processo->descricao ?? '') }}</textarea>
                </div>
                @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="objetivo" class="block text-sm font-medium text-gray-700">Objetivo</label>
                <div class="relative mt-1">
                    <textarea id="objetivo" name="objetivo" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('objetivo') border-red-300 @enderror"
                        placeholder="Meta ou finalidade principal do processo...">{{ old('objetivo', $processo->objetivo ?? '') }}</textarea>
                </div>
                @error('objetivo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 2: Entradas, Saídas e Indicadores (Mapeamento SIPOC) --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-right-left text-cyan-600"></i>Fluxo & Desempenho
        </h3>

        {{-- Entradas + Saídas --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="entradas" class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-right-to-bracket text-gray-400 mr-1"></i>Entradas (Inputs)
                </label>
                <div class="relative mt-1">
                    <textarea id="entradas" name="entradas" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('entradas') border-red-300 @enderror"
                        placeholder="Insumos, dados, documentos de entrada...">{{ old('entradas', $processo->entradas ?? '') }}</textarea>
                </div>
                @error('entradas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="saidas" class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-right-from-bracket text-gray-400 mr-1"></i>Saídas (Outputs)
                </label>
                <div class="relative mt-1">
                    <textarea id="saidas" name="saidas" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('saidas') border-red-300 @enderror"
                        placeholder="Produtos, serviços ou entregáveis...">{{ old('saidas', $processo->saidas ?? '') }}</textarea>
                </div>
                @error('saidas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Indicadores --}}
        <div class="w-full">
            <label for="indicadores_chave" class="block text-sm font-medium text-gray-700">
                <i class="fas fa-chart-line text-gray-400 mr-1"></i>Indicadores Chave (KPIs)
            </label>
            <div class="relative mt-1">
                <textarea id="indicadores_chave" name="indicadores_chave" rows="2"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('indicadores_chave') border-red-300 @enderror"
                    placeholder="KPIs do processo (ex: Taxa de Refugo, Lead Time)...">{{ old('indicadores_chave', $processo->indicadores_chave ?? '') }}</textarea>
            </div>
            @error('indicadores_chave') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 3: Status --}}
    <div>
        <div class="w-full md:w-[calc(50%-0.5rem)]">
            <label for="ativo" class="block text-sm font-medium text-gray-700">
                Ativo <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-2">
                <input type="hidden" name="ativo" value="0">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="ativo" name="ativo" value="1"
                        {{ old('ativo', $processo->ativo ?? true) ? 'checked' : '' }}
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
