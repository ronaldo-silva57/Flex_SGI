<div class="space-y-8">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-clipboard-check text-blue-500"></i> Dados do Item
        </h3>

        {{-- Linha 1: Auditoria + Cláusula --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="auditoria_id" class="block text-sm font-medium text-gray-700">
                    Auditoria <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-clipboard-list text-gray-400"></i>
                    </div>
                    <select id="auditoria_id" name="auditoria_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('auditoria_id') border-red-300 @enderror"
                        required>
                        <option value="">Selecione a auditoria...</option>
                        @foreach($auditorias as $auditoria)
                            <option value="{{ $auditoria->id }}" {{ old('auditoria_id', $auditoriaItem->auditoria_id ?? '') == $auditoria->id ? 'selected' : '' }}>
                                Auditoria #{{ $auditoria->id }} - {{ $auditoria->norma->nome ?? $auditoria->norma->codigo ?? 'Sem Norma' }} ({{ $auditoria->tipo }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('auditoria_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

<div class="w-full md:w-[calc(50%-0.5rem)]">
    <label for="clausula_id" class="block text-sm font-medium text-gray-700">Cláusula</label>
    <div class="relative mt-1">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-paragraph text-gray-400"></i>
        </div>
        <select id="clausula_id" name="clausula_id"
            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('clausula_id') border-red-300 @enderror">
            <option value="">Selecione a cláusula...</option>
            @foreach($clausulas as $clausula)
                <option value="{{ $clausula->id }}" {{ old('clausula_id', $auditoriaItem->clausula_id ?? '') == $clausula->id ? 'selected' : '' }}>
                    {{ $clausula->codigo }} - {{ $clausula->titulo }}
                </option>
            @endforeach
        </select>
    </div>
    @error('clausula_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
</div>
        </div>

        {{-- Linha 2: Processo + Auditor --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="processo_id" class="block text-sm font-medium text-gray-700">Processo</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-cogs text-gray-400"></i>
                    </div>
                    <select id="processo_id" name="processo_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('processo_id') border-red-300 @enderror">
                        <option value="">Selecione o processo...</option>
                        @foreach($processos as $processo)
                            <option value="{{ $processo->id }}" {{ old('processo_id', $auditoriaItem->processo_id ?? '') == $processo->id ? 'selected' : '' }}>
                                {{ $processo->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('processo_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="auditor_id" class="block text-sm font-medium text-gray-700">Auditor</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="auditor_id" name="auditor_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('auditor_id') border-red-300 @enderror">
                        <option value="">Selecione o auditor...</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('auditor_id', $auditoriaItem->auditor_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('auditor_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Descrição da Verificação (textarea) --}}
        <div class="mb-4">
            <label for="descricao_verificacao" class="block text-sm font-medium text-gray-700">
                Descrição da Verificação <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-pen text-gray-400"></i>
                </div>
                <textarea id="descricao_verificacao" name="descricao_verificacao" rows="3"
                    placeholder="Descreva o que foi verificado, critérios, amostragem, etc."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descricao_verificacao') border-red-300 @enderror"
                    required>{{ old('descricao_verificacao', $auditoriaItem->descricao_verificacao ?? '') }}</textarea>
            </div>
            @error('descricao_verificacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Linha 4: Evidência Coletada (textarea) --}}
        <div class="mb-4">
            <label for="evidencia_coletada" class="block text-sm font-medium text-gray-700">Evidência Coletada</label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-file-alt text-gray-400"></i>
                </div>
                <textarea id="evidencia_coletada" name="evidencia_coletada" rows="3"
                    placeholder="Documentos, registros, fotos, depoimentos, etc."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('evidencia_coletada') border-red-300 @enderror">{{ old('evidencia_coletada', $auditoriaItem->evidencia_coletada ?? '') }}</textarea>
            </div>
            @error('evidencia_coletada') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Linha 5: Conformidade + Observações --}}
        <div class="flex flex-wrap gap-4 items-start mb-4">
            <div class="w-full md:w-1/3">
                <label for="conformidade" class="block text-sm font-medium text-gray-700">Conformidade</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-check-double text-gray-400"></i>
                    </div>
                    <select id="conformidade" name="conformidade"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('conformidade') border-red-300 @enderror">
                        <option value="">Selecione...</option>
                        @foreach(['conforme', 'nao_conforme', 'oportunidade_melhoria', 'nao_aplicavel'] as $opcao)
                            <option value="{{ $opcao }}" {{ old('conformidade', $auditoriaItem->conformidade ?? '') == $opcao ? 'selected' : '' }}>
                                {{ str_replace('_', ' ', ucfirst($opcao)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('conformidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-2/3">
                <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label>
                <div class="relative mt-1">
                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                        <i class="fas fa-comment text-gray-400"></i>
                    </div>
                    <textarea id="observacoes" name="observacoes" rows="3"
                        placeholder="Informações adicionais, recomendações, etc."
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('observacoes') border-red-300 @enderror">{{ old('observacoes', $auditoriaItem->observacoes ?? '') }}</textarea>
                </div>
                @error('observacoes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>