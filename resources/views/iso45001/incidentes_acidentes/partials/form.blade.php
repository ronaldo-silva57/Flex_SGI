<div class="space-y-8">
    {{-- Seção 1: Identificação e Data --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-ribbon text-red-600 mr-1"></i>Dados do Incidente
        </h3>

        {{-- Linha 1: Empresa (fixa) + Data Ocorrência --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? ($incidentesAcidente->empresa->razao_social ?? 'Empresa não definida') }}
                    </span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? '' }}">
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_ocorrencia" class="block text-sm font-medium text-gray-700">
                    Data da Ocorrência <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="datetime-local" id="data_ocorrencia" name="data_ocorrencia"
                        value="{{ old('data_ocorrencia', isset($incidentesAcidente) && $incidentesAcidente->data_ocorrencia ? $incidentesAcidente->data_ocorrencia->format('Y-m-d\TH:i') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('data_ocorrencia') border-red-300 @enderror">
                </div>
                @error('data_ocorrencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Tipo + Local --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">
                    Tipo <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <select id="tipo" name="tipo"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('tipo') border-red-300 @enderror">
                        <option value="">Selecione o tipo</option>
                        @foreach(['Quase acidente', 'Incidente', 'Acidente leve', 'Acidente grave', 'Fatal'] as $tipoOption)
                            <option value="{{ $tipoOption }}" {{ old('tipo', $incidentesAcidente->tipo ?? '') == $tipoOption ? 'selected' : '' }}>
                                {{ $tipoOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="local" class="block text-sm font-medium text-gray-700">
                    Local
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-map-pin text-gray-400"></i>
                    </div>
                    <input type="text" id="local" name="local"
                        value="{{ old('local', $incidentesAcidente->local ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('local') border-red-300 @enderror"
                        placeholder="Ex: Setor de produção, almoxarifado...">
                </div>
                @error('local') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Usuário (vítima) e Responsável --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="usuario_id" class="block text-sm font-medium text-gray-700">
                    Pessoa envolvida (Vítima)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="usuario_id" name="usuario_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('usuario_id') border-red-300 @enderror">
                        <option value="">Selecione um usuário</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('usuario_id', $incidentesAcidente->usuario_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('usuario_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">
                    Responsável pelo registro
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-check text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione o responsável</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_id', $incidentesAcidente->responsavel_id ?? auth()->id()) == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Descrição (obrigatória) --}}
        <div class="w-full mb-4">
            <label for="descricao" class="block text-sm font-medium text-gray-700">
                Descrição do ocorrido <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <textarea id="descricao" name="descricao" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('descricao') border-red-300 @enderror"
                    placeholder="Descreva detalhadamente o evento...">{{ old('descricao', $incidentesAcidente->descricao ?? '') }}</textarea>
            </div>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 2: Causas e Lesão --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-search text-red-600"></i>Causas e Lesão
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="causas" class="block text-sm font-medium text-gray-700">
                    Causas
                </label>
                <div class="relative mt-1">
                    <textarea id="causas" name="causas" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('causas') border-red-300 @enderror"
                        placeholder="Fatores que contribuíram para o evento (opcional)">{{ old('causas', $incidentesAcidente->causas ?? '') }}</textarea>
                </div>
                @error('causas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="lesao" class="block text-sm font-medium text-gray-700">
                    Lesão / Ferimento
                </label>
                <div class="relative mt-1">
                    <textarea id="lesao" name="lesao" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('lesao') border-red-300 @enderror"
                        placeholder="Descreva as lesões ou ferimentos (opcional)">{{ old('lesao', $incidentesAcidente->lesao ?? '') }}</textarea>
                </div>
                @error('lesao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="w-full md:w-1/2">
            <label for="dias_perdidos" class="block text-sm font-medium text-gray-700">
                Dias perdidos
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-clock text-gray-400"></i>
                </div>
                <input type="number" id="dias_perdidos" name="dias_perdidos"
                    value="{{ old('dias_perdidos', $incidentesAcidente->dias_perdidos ?? 0) }}"
                    min="0"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('dias_perdidos') border-red-300 @enderror"
                    placeholder="0">
            </div>
            @error('dias_perdidos') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 3: Tratamento e Investigação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-notes-medical text-red-600"></i>Tratamento e Investigação
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tratamento" class="block text-sm font-medium text-gray-700">
                    Tratamento aplicado
                </label>
                <div class="relative mt-1">
                    <textarea id="tratamento" name="tratamento" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('tratamento') border-red-300 @enderror"
                        placeholder="Medidas médicas ou assistenciais (opcional)">{{ old('tratamento', $incidentesAcidente->tratamento ?? '') }}</textarea>
                </div>
                @error('tratamento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="investigacao" class="block text-sm font-medium text-gray-700">
                    Investigação
                </label>
                <div class="relative mt-1">
                    <textarea id="investigacao" name="investigacao" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('investigacao') border-red-300 @enderror"
                        placeholder="Análise da causa raiz, entrevistas, etc. (opcional)">{{ old('investigacao', $incidentesAcidente->investigacao ?? '') }}</textarea>
                </div>
                @error('investigacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 4: Ação Corretiva e Status --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-check-circle text-red-600"></i>Ação Corretiva e Status
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="acao_corretiva" class="block text-sm font-medium text-gray-700">
                    Ação Corretiva
                </label>
                <div class="relative mt-1">
                    <textarea id="acao_corretiva" name="acao_corretiva" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('acao_corretiva') border-red-300 @enderror"
                        placeholder="Ações para prevenir recorrência (opcional)">{{ old('acao_corretiva', $incidentesAcidente->acao_corretiva ?? '') }}</textarea>
                </div>
                @error('acao_corretiva') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
                            <option value="{{ $statusOption }}" {{ old('status', $incidentesAcidente->status ?? 'Aberto') == $statusOption ? 'selected' : '' }}>
                                {{ $statusOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>