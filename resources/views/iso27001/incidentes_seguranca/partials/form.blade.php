<div class="space-y-8">
    {{-- Seção 1: Identificação e Data --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-shield-alt text-red-600 mr-1"></i>Dados do Incidente de Segurança
        </h3>

        {{-- Linha 1: Empresa + Data Ocorrência --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? ($incidentesSeguranca->empresa->razao_social ?? 'Empresa não definida') }}
                    </span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? $incidentesSeguranca->empresa_id }}">
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_ocorrencia" class="block text-sm font-medium text-gray-700">
                    Data e Hora da Ocorrência <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="datetime-local" id="data_ocorrencia" name="data_ocorrencia"
                        value="{{ old('data_ocorrencia', isset($incidentesSeguranca) && $incidentesSeguranca->data_ocorrencia ? \Carbon\Carbon::parse($incidentesSeguranca->data_ocorrencia)->format('Y-m-d\TH:i') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('data_ocorrencia') border-red-300 @enderror">
                </div>
                @error('data_ocorrencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Tipo + Ativo de Informação --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">
                    Tipo de Incidente <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <select id="tipo" name="tipo"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('tipo') border-red-300 @enderror">
                        <option value="">Selecione o tipo</option>
                        @foreach(['Acesso não autorizado', 'Malware', 'Vazamento Dados', 'Indisponibilidade', 'Phishing', 'Outros'] as $tipoOption)
                            <option value="{{ $tipoOption }}" {{ old('tipo', $incidentesSeguranca->tipo ?? '') == $tipoOption ? 'selected' : '' }}>
                                {{ $tipoOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="ativo_id" class="block text-sm font-medium text-gray-700">
                    Ativo de Informação Afetado
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-server text-gray-400"></i>
                    </div>
                    <select id="ativo_id" name="ativo_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('ativo_id') border-red-300 @enderror">
                        <option value="">Nenhum / Não aplicável</option>
                        @foreach($ativos as $ativo)
                            <option value="{{ $ativo->id }}" {{ old('ativo_id', $incidentesSeguranca->ativo_id ?? '') == $ativo->id ? 'selected' : '' }}>
                                {{ $ativo->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('ativo_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Responsável + Status --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">
                    Responsável pelo Registro / Análise
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-shield text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione o responsável</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_id', $incidentesSeguranca->responsavel_id ?? auth()->id()) == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('status') border-red-300 @enderror">
                        @foreach(['Aberto', 'Em investigação', 'Concluído'] as $statusOption)
                            <option value="{{ $statusOption }}" {{ old('status', $incidentesSeguranca->status ?? 'Aberto') == $statusOption ? 'selected' : '' }}>
                                {{ $statusOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Descrição --}}
        <div class="w-full mb-4">
            <label for="descricao" class="block text-sm font-medium text-gray-700">
                Descrição do Incidente <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <textarea id="descricao" name="descricao" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('descricao') border-red-300 @enderror"
                    placeholder="Descreva detalhadamente o evento de segurança...">{{ old('descricao', $incidentesSeguranca->descricao ?? '') }}</textarea>
            </div>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 2: Análise, Impacto e Ações --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-search-plus text-red-600"></i>Análise e Resposta ao Incidente
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="impacto" class="block text-sm font-medium text-gray-700">
                    Impacto Observado / Estimado
                </label>
                <div class="relative mt-1">
                    <textarea id="impacto" name="impacto" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('impacto') border-red-300 @enderror"
                        placeholder="Impacto em dados, sistemas, operações ou reputação (opcional)...">{{ old('impacto', $incidentesSeguranca->impacto ?? '') }}</textarea>
                </div>
                @error('impacto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="acao_imediata" class="block text-sm font-medium text-gray-700">
                    Ação Imediata (Contenção)
                </label>
                <div class="relative mt-1">
                    <textarea id="acao_imediata" name="acao_imediata" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('acao_imediata') border-red-300 @enderror"
                        placeholder="Medidas tomadas para conter o incidente (opcional)...">{{ old('acao_imediata', $incidentesSeguranca->acao_imediata ?? '') }}</textarea>
                </div>
                @error('acao_imediata') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="w-full mb-4">
            <label for="investigacao" class="block text-sm font-medium text-gray-700">
                Investigação e Causa Raiz
            </label>
            <div class="relative mt-1">
                <textarea id="investigacao" name="investigacao" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('investigacao') border-red-300 @enderror"
                    placeholder="Resultados da perícia, logs analisados e causa raiz identificada (opcional)...">{{ old('investigacao', $incidentesSeguranca->investigacao ?? '') }}</textarea>
            </div>
            @error('investigacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>