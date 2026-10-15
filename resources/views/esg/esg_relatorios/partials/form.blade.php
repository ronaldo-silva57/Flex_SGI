<div class="space-y-8">
    {{-- Seção 1: Identificação do Relatório --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-file-alt text-indigo-600 mr-1"></i>Dados do Relatório
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
                <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
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
                                {{ old('responsavel_id', $esgRelatorio->responsavel_id ?? auth()->id()) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
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
                           value="{{ old('titulo', $esgRelatorio->titulo ?? '') }}"
                           placeholder="Ex: Relatório Anual de Sustentabilidade 2025"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('titulo') border-red-300 @enderror">
                </div>
                @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Framework --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="framework" class="block text-sm font-medium text-gray-700">
                    Framework <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-layer-group text-gray-400"></i>
                    </div>
                    <select id="framework" name="framework"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('framework') border-red-300 @enderror">
                        <option value="">Selecione o framework</option>
                        @foreach(['GRI','SASB','TCFD','Global Compact','Outro'] as $fw)
                            <option value="{{ $fw }}"
                                {{ old('framework', $esgRelatorio->framework ?? '') == $fw ? 'selected' : '' }}>
                                {{ $fw }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('framework') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Ano de referência --}}
            <div class="w-full md:w-[calc(33%-0.66rem)]">
                <label for="ano_referencia" class="block text-sm font-medium text-gray-700">
                    Ano de Referência <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar text-gray-400"></i>
                    </div>
                    <input type="number" id="ano_referencia" name="ano_referencia"
                           min="2000" max="{{ date('Y') + 1 }}"
                           value="{{ old('ano_referencia', $esgRelatorio->ano_referencia ?? date('Y')) }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('ano_referencia') border-red-300 @enderror">
                </div>
                @error('ano_referencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Status --}}
            <div class="w-full md:w-[calc(33%-0.66rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flag text-gray-400"></i>
                    </div>
                    <select id="status" name="status"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-300 @enderror">
                        @foreach(['Rascunho','Em Revisão','Auditado','Publicado'] as $st)
                            <option value="{{ $st }}"
                                {{ old('status', $esgRelatorio->status ?? 'Rascunho') == $st ? 'selected' : '' }}>
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Data de publicação --}}
            <div class="w-full md:w-[calc(33%-0.66rem)]">
                <label for="data_publicacao" class="block text-sm font-medium text-gray-700">Data de Publicação</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>
                    <input type="date" id="data_publicacao" name="data_publicacao"
                           value="{{ old('data_publicacao', isset($esgRelatorio) && $esgRelatorio->data_publicacao ? $esgRelatorio->data_publicacao->format('Y-m-d') : '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('data_publicacao') border-red-300 @enderror">
                </div>
                @error('data_publicacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 2: Arquivo e Observações --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-paperclip text-indigo-600"></i>Arquivo e Observações
        </h3>

        <div class="w-full mb-4">
            <label for="arquivo_path" class="block text-sm font-medium text-gray-700">Caminho / URL do Arquivo</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-link text-gray-400"></i>
                </div>
                <input type="text" id="arquivo_path" name="arquivo_path"
                       value="{{ old('arquivo_path', $esgRelatorio->arquivo_path ?? '') }}"
                       placeholder="Ex: relatorios/2025/sustentabilidade.pdf"
                       class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('arquivo_path') border-red-300 @enderror">
            </div>
            @error('arquivo_path') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="w-full">
            <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label>
            <textarea id="observacoes" name="observacoes" rows="4"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('observacoes') border-red-300 @enderror"
                      placeholder="Observações, escopo, versão...">{{ old('observacoes', $esgRelatorio->observacoes ?? '') }}</textarea>
            @error('observacoes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>