<div class="space-y-8">
    {{-- Seção 1: Identificação do Projeto --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-hand-holding-heart text-indigo-600 mr-1"></i>Dados do Projeto Social
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Empresa --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">{{ $empresa->razao_social ?? 'Empresa não definida' }}</span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? '' }}">
                @error('empresa_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Responsável --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione um responsável</option>
                        @foreach($responsaveis as $user)
                            <option value="{{ $user->id }}"
                                {{ old('responsavel_id', $esgProjetoSocial->responsavel_id ?? auth()->id()) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Nome do Projeto --}}
        <div class="w-full mb-4">
            <label for="nome_projeto" class="block text-sm font-medium text-gray-700">
                Nome do Projeto <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lightbulb text-gray-400"></i>
                </div>
                <input type="text" id="nome_projeto" name="nome_projeto"
                       value="{{ old('nome_projeto', $esgProjetoSocial->nome_projeto ?? '') }}"
                       placeholder="Ex: Educação Digital para Jovens"
                       class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('nome_projeto') border-red-300 @enderror">
            </div>
            @error('nome_projeto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Localidade --}}
        <div class="w-full mb-4">
            <label for="localidade" class="block text-sm font-medium text-gray-700">Localidade</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-map-marker-alt text-gray-400"></i>
                </div>
                <input type="text" id="localidade" name="localidade" maxlength="150"
                       value="{{ old('localidade', $esgProjetoSocial->localidade ?? '') }}"
                       placeholder="Ex: São Paulo - SP"
                       class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('localidade') border-red-300 @enderror">
            </div>
            @error('localidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 2: Período e Recursos --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-calendar-alt text-indigo-600"></i>Período e Recursos
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Data de Início --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data de Início</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-plus text-gray-400"></i>
                    </div>
                    <input type="date" id="data_inicio" name="data_inicio"
                           value="{{ old('data_inicio', isset($esgProjetoSocial) && $esgProjetoSocial->data_inicio ? $esgProjetoSocial->data_inicio->format('Y-m-d') : '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('data_inicio') border-red-300 @enderror">
                </div>
                @error('data_inicio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Data de Fim --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="data_fim" class="block text-sm font-medium text-gray-700">Data de Fim</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>
                    <input type="date" id="data_fim" name="data_fim"
                           value="{{ old('data_fim', isset($esgProjetoSocial) && $esgProjetoSocial->data_fim ? $esgProjetoSocial->data_fim->format('Y-m-d') : '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('data_fim') border-red-300 @enderror">
                </div>
                @error('data_fim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Orçamento Investido --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="orcamento_investido" class="block text-sm font-medium text-gray-700">Orçamento Investido (R$)</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-dollar-sign text-gray-400"></i>
                    </div>
                    <input type="number" step="0.01" min="0" id="orcamento_investido" name="orcamento_investido"
                           value="{{ old('orcamento_investido', $esgProjetoSocial->orcamento_investido ?? '0.00') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('orcamento_investido') border-red-300 @enderror">
                </div>
                @error('orcamento_investido') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Beneficiários Diretos --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="beneficiarios_diretos" class="block text-sm font-medium text-gray-700">Beneficiários Diretos</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-users text-gray-400"></i>
                    </div>
                    <input type="number" min="0" id="beneficiarios_diretos" name="beneficiarios_diretos"
                           value="{{ old('beneficiarios_diretos', $esgProjetoSocial->beneficiarios_diretos ?? 0) }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('beneficiarios_diretos') border-red-300 @enderror">
                </div>
                @error('beneficiarios_diretos') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Status --}}
        <div class="w-full md:w-1/2 mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">
                Status <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-flag text-gray-400"></i>
                </div>
                <select id="status" name="status"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-300 @enderror">
                    @foreach(['Planejado','Em Andamento','Concluído','Cancelado'] as $st)
                        <option value="{{ $st }}"
                            {{ old('status', $esgProjetoSocial->status ?? 'Planejado') == $st ? 'selected' : '' }}>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 3: Descrição --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-align-left text-indigo-600"></i>Descrição
        </h3>

        <div class="w-full">
            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição do Projeto</label>
            <textarea id="descricao" name="descricao" rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('descricao') border-red-300 @enderror"
                      placeholder="Objetivos, público-alvo, resultados esperados...">{{ old('descricao', $esgProjetoSocial->descricao ?? '') }}</textarea>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>