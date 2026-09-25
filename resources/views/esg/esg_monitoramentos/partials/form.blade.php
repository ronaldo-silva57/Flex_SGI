<div class="space-y-8">
    {{-- Seção 1: Indicador e Responsável --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-ribbon text-indigo-600 mr-1"></i>Dados do Monitoramento
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Indicador --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="esg_indicador_id" class="block text-sm font-medium text-gray-700">
                    Indicador ESG <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-chart-pie text-gray-400"></i>
                    </div>
                    <select id="esg_indicador_id" name="esg_indicador_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('esg_indicador_id') border-red-300 @enderror">
                        <option value="">Selecione um indicador</option>
                        @foreach($indicadores as $indicador)
                            <option value="{{ $indicador->id }}" {{ old('esg_indicador_id', $esgMonitoramento->esg_indicador_id ?? '') == $indicador->id ? 'selected' : '' }}>
                                {{ $indicador->codigo }} - {{ $indicador->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('esg_indicador_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Responsável --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">
                    Responsável
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione um responsável</option>
                        @foreach($responsaveis as $user)
                            <option value="{{ $user->id }}" {{ old('responsavel_id', $esgMonitoramento->responsavel_id ?? auth()->id()) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Período de referência --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="periodo_referencia" class="block text-sm font-medium text-gray-700">
                    Período de Referência <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" id="periodo_referencia" name="periodo_referencia"
                           value="{{ old('periodo_referencia', isset($esgMonitoramento) && $esgMonitoramento->periodo_referencia ? $esgMonitoramento->periodo_referencia->format('Y-m-d') : '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('periodo_referencia') border-red-300 @enderror">
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
                        <i class="fas fa-flag text-gray-400"></i>
                    </div>
                    <select id="status" name="status"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-300 @enderror">
                        <option value="">Selecione o status</option>
                        @foreach($statusList as $st)
                            <option value="{{ $st }}" {{ old('status', $esgMonitoramento->status ?? 'No prazo') == $st ? 'selected' : '' }}>
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 2: Valores e Análise --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-calculator text-indigo-600"></i>Valores e Análise
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="valor_realizado" class="block text-sm font-medium text-gray-700">
                    Valor Realizado
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-check-circle text-gray-400"></i>
                    </div>
                    <input type="number" step="0.01" id="valor_realizado" name="valor_realizado"
                           value="{{ old('valor_realizado', $esgMonitoramento->valor_realizado ?? '') }}"
                           placeholder="Ex: 85.5"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('valor_realizado') border-red-300 @enderror">
                </div>
                @error('valor_realizado') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="valor_meta" class="block text-sm font-medium text-gray-700">
                    Meta (pode ser preenchida ou herdada do indicador)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-bullseye text-gray-400"></i>
                    </div>
                    <input type="number" step="0.01" id="valor_meta" name="valor_meta"
                           value="{{ old('valor_meta', $esgMonitoramento->valor_meta ?? '') }}"
                           placeholder="Valor da meta (opcional)"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('valor_meta') border-red-300 @enderror">
                </div>
                @error('valor_meta') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="w-full mb-4">
            <label for="analise" class="block text-sm font-medium text-gray-700">
                Análise / Comentários
            </label>
            <div class="relative mt-1">
                <textarea id="analise" name="analise" rows="3"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('analise') border-red-300 @enderror"
                          placeholder="Análise do resultado, observações...">{{ old('analise', $esgMonitoramento->analise ?? '') }}</textarea>
            </div>
            @error('analise') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>