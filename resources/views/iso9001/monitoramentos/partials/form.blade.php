<div class="space-y-8">
    {{-- Título da Seção --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-eye text-blue-500"></i> Informações do Monitoramento
        </h3>

        {{-- Linha 1: Indicador + Responsável --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Indicador --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="indicador_id" class="block text-sm font-medium text-gray-700">
                    Indicador <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-chart-line text-gray-400"></i>
                    </div>
                    <select id="indicador_id" name="indicador_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('indicador_id') border-red-300 @enderror"
                        required>
                        <option value="">Selecione o indicador...</option>
                        @foreach($indicadores as $indicador)
                            <option value="{{ $indicador->id }}" {{ old('indicador_id', $monitoramento->indicador_id ?? '') == $indicador->id ? 'selected' : '' }}>
                                {{ $indicador->codigo }} - {{ $indicador->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('indicador_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Responsável --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione o responsável...</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_id', $monitoramento->responsavel_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Período de Referência + Status --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Período de Referência --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="periodo_referencia" class="block text-sm font-medium text-gray-700">
                    Período de Referência <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="text" id="periodo_referencia" name="periodo_referencia"
                        placeholder="Ex: Jan/2026, 1º Trimestre..."
                        value="{{ old('periodo_referencia', $monitoramento->periodo_referencia ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('periodo_referencia') border-red-300 @enderror"
                        required>
                </div>
                @error('periodo_referencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Status --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tasks text-gray-400"></i>
                    </div>
                    <select id="status" name="status"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror"
                        required>
                        @foreach(['No prazo', 'Atrasado', 'Concluído'] as $statusOption)
                            <option value="{{ $statusOption }}" {{ old('status', $monitoramento->status ?? 'No prazo') == $statusOption ? 'selected' : '' }}>
                                {{ $statusOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Valor Meta + Valor Realizado --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Valor Meta --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="valor_meta" class="block text-sm font-medium text-gray-700">Valor Meta</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-bullseye text-gray-400"></i>
                    </div>
                    <input type="number" step="0.01" id="valor_meta" name="valor_meta"
                        value="{{ old('valor_meta', $monitoramento->valor_meta ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('valor_meta') border-red-300 @enderror">
                </div>
                @error('valor_meta') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Valor Realizado --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="valor_realizado" class="block text-sm font-medium text-gray-700">Valor Realizado</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-check-double text-gray-400"></i>
                    </div>
                    <input type="number" step="0.01" id="valor_realizado" name="valor_realizado"
                        value="{{ old('valor_realizado', $monitoramento->valor_realizado ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('valor_realizado') border-red-300 @enderror">
                </div>
                @error('valor_realizado') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 4: Análise + Ação Necessária --}}
        <div class="flex flex-wrap gap-4 items-start mb-4">
            {{-- Análise --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="analise" class="block text-sm font-medium text-gray-700">Análise</label>
                <div class="relative mt-1">
                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                        <i class="fas fa-search-minus text-gray-400"></i>
                    </div>
                    <textarea id="analise" name="analise" rows="3"
                        placeholder="Análise descritiva dos resultados obtidos..."
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('analise') border-red-300 @enderror">{{ old('analise', $monitoramento->analise ?? '') }}</textarea>
                </div>
                @error('analise') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Ação Necessária --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="acao_necessaria" class="block text-sm font-medium text-gray-700">Ação Necessária</label>
                <div class="relative mt-1">
                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                        <i class="fas fa-clipboard-list text-gray-400"></i>
                    </div>
                    <textarea id="acao_necessaria" name="acao_necessaria" rows="3"
                        placeholder="Planos de ação ou correções a serem tomadas..."
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('acao_necessaria') border-red-300 @enderror">{{ old('acao_necessaria', $monitoramento->acao_necessaria ?? '') }}</textarea>
                </div>
                @error('acao_necessaria') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>