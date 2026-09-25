<div class="space-y-8">
    {{-- Seção 1: Identificação e Relacionamentos --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-ribbon text-amber-600 mr-1"></i>Identificação
        </h3>

        {{-- Linha 1: Empresa + Processo --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Empresa --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? ($riscos_oportunidade->empresa->razao_social ?? 'Empresa não definida') }}
                    </span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
            </div>
            {{-- Processo --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="processo_id" class="block text-sm font-medium text-gray-700">
                    Processo <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-diagram-project text-gray-400"></i>
                    </div>
                    <select id="processo_id" name="processo_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('processo_id') border-red-300 @enderror">
                        <option value="">Selecione um Processo</option>
                        @foreach($processos as $processo)
                            <option value="{{ $processo->id }}" {{ old('processo_id', $riscos_oportunidade->processo_id ?? '') == $processo->id ? 'selected' : '' }}>
                                {{ $processo->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('processo_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Responsável (fixo) + Tipo --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Responsável --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Responsável <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-user text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ optional($riscos_oportunidade->responsavel ?? null)->name ?? auth()->user()->name }}
                    </span>
                </div>
                <input type="hidden" name="responsavel_id" value="{{ old('responsavel_id', $riscos_oportunidade->responsavel_id ?? auth()->id()) }}">
            </div>

            {{-- Tipo --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">
                    Tipo <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <select id="tipo" name="tipo"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('tipo') border-red-300 @enderror">
                        <option value="">Selecione o Tipo</option>
                        @foreach(['Risco', 'Oportunidade'] as $tipoOption)
                            <option value="{{ $tipoOption }}" {{ old('tipo', $riscos_oportunidade->tipo ?? '') == $tipoOption ? 'selected' : '' }}>
                                {{ $tipoOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Descrição (ocupa linha inteira) --}}
        <div class="w-full mb-4">
            <label for="descricao" class="block text-sm font-medium text-gray-700">
                Descrição <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <textarea id="descricao" name="descricao" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('descricao') border-red-300 @enderror"
                    placeholder="Descreva o risco ou oportunidade...">{{ old('descricao', $riscos_oportunidade->descricao ?? '') }}</textarea>
            </div>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 2: Causa e Consequência (Análise) --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-search text-amber-600"></i>Análise de Causa e Consequência
        </h3>

        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="causa" class="block text-sm font-medium text-gray-700">
                    Causa
                </label>
                <div class="relative mt-1">
                    <textarea id="causa" name="causa" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('causa') border-red-300 @enderror"
                        placeholder="O que pode causar o risco? (opcional)">{{ old('causa', $riscos_oportunidade->causa ?? '') }}</textarea>
                </div>
                @error('causa') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="consequencia" class="block text-sm font-medium text-gray-700">
                    Consequência
                </label>
                <div class="relative mt-1">
                    <textarea id="consequencia" name="consequencia" rows="3"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('consequencia') border-red-300 @enderror"
                        placeholder="Quais os impactos caso ocorra? (opcional)">{{ old('consequencia', $riscos_oportunidade->consequencia ?? '') }}</textarea>
                </div>
                @error('consequencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 3: Avaliação de Risco (Probabilidade, Impacto, Nível) --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-calculator text-amber-600"></i>Avaliação de Risco
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Probabilidade --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="probabilidade" class="block text-sm font-medium text-gray-700">
                    Probabilidade (1 a 5)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-dice text-gray-400"></i>
                    </div>
                    <select id="probabilidade" name="probabilidade"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('probabilidade') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('probabilidade', $riscos_oportunidade->probabilidade ?? '') == $i ? 'selected' : '' }}>
                                {{ $i }} - {{ ['Muito Baixa', 'Baixa', 'Média', 'Alta', 'Muito Alta'][$i-1] }}
                            </option>
                        @endfor
                    </select>
                </div>
                @error('probabilidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Impacto --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="impacto" class="block text-sm font-medium text-gray-700">
                    Impacto (1 a 5)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-bullseye text-gray-400"></i>
                    </div>
                    <select id="impacto" name="impacto"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('impacto') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('impacto', $riscos_oportunidade->impacto ?? '') == $i ? 'selected' : '' }}>
                                {{ $i }} - {{ ['Insignificante', 'Leve', 'Moderado', 'Grave', 'Catastrófico'][$i-1] }}
                            </option>
                        @endfor
                    </select>
                </div>
                @error('impacto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Nível de Risco (calculado, somente leitura) --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Nível de Risco (Prob. × Impacto)
                </label>
                <div class="mt-1 p-2 border border-gray-200 rounded-md bg-gray-50 flex items-center gap-2">
                    <i class="fas fa-chart-simple text-amber-500"></i>
                    <span id="nivel_risco_display" class="font-semibold text-lg">
                        {{ isset($riscos_oportunidade) && $riscos_oportunidade->nivel_risco ? $riscos_oportunidade->nivel_risco : '--' }}
                    </span>
                    <span class="text-sm text-gray-500 ml-2">(calculado automaticamente)</span>
                </div>
                {{-- Campo oculto apenas para referência (não é enviado) --}}
            </div>
        </div>
    </div>

    {{-- Seção 4: Tratamento e Plano de Ação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-bullhorn text-amber-600"></i>Tratamento e Plano de Ação
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tratamento" class="block text-sm font-medium text-gray-700">
                    Estratégia de Tratamento
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-people-arrows text-gray-400"></i>
                    </div>
                    <select id="tratamento" name="tratamento"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('tratamento') border-red-300 @enderror">
                        <option value="">Selecione uma estratégia</option>
                        @foreach(['Eliminar', 'Mitigar', 'Transferir', 'Aceitar'] as $tratamentoOption)
                            <option value="{{ $tratamentoOption }}" {{ old('tratamento', $riscos_oportunidade->tratamento ?? '') == $tratamentoOption ? 'selected' : '' }}>
                                {{ $tratamentoOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tratamento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="prazo" class="block text-sm font-medium text-gray-700">
                    Prazo para Implementação
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" id="prazo" name="prazo"
                        value="{{ old('prazo', isset($riscos_oportunidade) && $riscos_oportunidade->prazo ? $riscos_oportunidade->prazo->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('prazo') border-red-300 @enderror">
                </div>
                @error('prazo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="w-full mb-4">
            <label for="plano_acao" class="block text-sm font-medium text-gray-700">
                Plano de Ação
            </label>
            <div class="relative mt-1">
                <textarea id="plano_acao" name="plano_acao" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('plano_acao') border-red-300 @enderror"
                    placeholder="Descreva as ações para tratar o risco ou oportunidade...">{{ old('plano_acao', $riscos_oportunidade->plano_acao ?? '') }}</textarea>
            </div>
            @error('plano_acao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 5: Status e Evidência --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-check-circle text-amber-600"></i>Status e Evidência
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flag text-gray-400"></i>
                    </div>
                    <select id="status" name="status"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('status') border-red-300 @enderror">
                        @foreach(['Aberto', 'Em andamento', 'Concluído', 'Cancelado'] as $statusOption)
                            <option value="{{ $statusOption }}" {{ old('status', $riscos_oportunidade->status ?? 'Aberto') == $statusOption ? 'selected' : '' }}>
                                {{ $statusOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="evidencia" class="block text-sm font-medium text-gray-700">
                    Evidência
                </label>
                <div class="relative mt-1">
                    <textarea id="evidencia" name="evidencia" rows="2"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('evidencia') border-red-300 @enderror"
                        placeholder="Link, anexo ou descrição da evidência (opcional)">{{ old('evidencia', $riscos_oportunidade->evidencia ?? '') }}</textarea>
                </div>
                @error('evidencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- JavaScript para calcular nível de risco dinamicamente --}}

    <script>
    document.addEventListener('DOMContentLoaded', function() {

        const probabilidade = document.getElementById('probabilidade');
        const impacto = document.getElementById('impacto');
        const nivelDisplay = document.getElementById('nivel_risco_display');

        function calcularNivel() {

            const p = parseInt(probabilidade.value) || 0;
            const i = parseInt(impacto.value) || 0;

            if (p > 0 && i > 0) {
                const nivel = p * i;
                nivelDisplay.textContent = nivel;
            } else {
                nivelDisplay.textContent = '--';
            }
        }

        probabilidade.addEventListener('change', calcularNivel);
        impacto.addEventListener('change', calcularNivel);

        // Calcula também ao abrir a página
        calcularNivel();
    });
    </script>

</div>