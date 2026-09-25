<div class="space-y-8">
    {{-- Seção 1: Identificação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-ribbon text-amber-600 mr-1"></i>Identificação do Perigo
        </h3>

        {{-- Linha 1: Empresa + Processo --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Empresa (fixa) --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? ($perigosRisco->empresa->razao_social ?? 'Empresa não definida') }}
                    </span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? '' }}">
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
                            <option value="{{ $processo->id }}" {{ old('processo_id', $perigosRisco->processo_id ?? '') == $processo->id ? 'selected' : '' }}>
                                {{ $processo->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('processo_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Responsável (fixo) --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Responsável <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-user text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ optional($perigosRisco->responsavel ?? null)->name ?? auth()->user()->name }}
                    </span>
                </div>
                <input type="hidden" name="responsavel_id" value="{{ old('responsavel_id', $perigosRisco->responsavel_id ?? auth()->id()) }}">
            </div>
        </div>

        {{-- Descrição do Perigo (obrigatório) --}}
        <div class="w-full mb-4">
            <label for="descricao_perigo" class="block text-sm font-medium text-gray-700">
                Descrição do Perigo <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <textarea id="descricao_perigo" name="descricao_perigo" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('descricao_perigo') border-red-300 @enderror"
                    placeholder="Descreva o perigo identificado...">{{ old('descricao_perigo', $perigosRisco->descricao_perigo ?? '') }}</textarea>
            </div>
            @error('descricao_perigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Risco Associado e Exposição (linha) --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="risco_associado" class="block text-sm font-medium text-gray-700">
                    Risco Associado
                </label>
                <div class="relative mt-1">
                    <textarea id="risco_associado" name="risco_associado" rows="2"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('risco_associado') border-red-300 @enderror"
                        placeholder="Risco potencial associado ao perigo (opcional)">{{ old('risco_associado', $perigosRisco->risco_associado ?? '') }}</textarea>
                </div>
                @error('risco_associado') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="exposicao" class="block text-sm font-medium text-gray-700">
                    Exposição
                </label>
                <div class="relative mt-1">
                    <textarea id="exposicao" name="exposicao" rows="2"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('exposicao') border-red-300 @enderror"
                        placeholder="Como ocorre a exposição? (opcional)">{{ old('exposicao', $perigosRisco->exposicao ?? '') }}</textarea>
                </div>
                @error('exposicao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 2: Avaliação de Risco --}}
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
                            <option value="{{ $i }}" {{ old('probabilidade', $perigosRisco->probabilidade ?? '') == $i ? 'selected' : '' }}>
                                {{ $i }} - {{ ['Muito Baixa', 'Baixa', 'Média', 'Alta', 'Muito Alta'][$i-1] }}
                            </option>
                        @endfor
                    </select>
                </div>
                @error('probabilidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Severidade --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="severidade" class="block text-sm font-medium text-gray-700">
                    Severidade (1 a 5)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-bullseye text-gray-400"></i>
                    </div>
                    <select id="severidade" name="severidade"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('severidade') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('severidade', $perigosRisco->severidade ?? '') == $i ? 'selected' : '' }}>
                                {{ $i }} - {{ ['Insignificante', 'Leve', 'Moderado', 'Grave', 'Catastrófico'][$i-1] }}
                            </option>
                        @endfor
                    </select>
                </div>
                @error('severidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Nível de Risco (calculado) --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Nível de Risco (Prob. × Severidade)
                </label>
                <div class="mt-1 p-2 border border-gray-200 rounded-md bg-gray-50 flex items-center gap-2">
                    <i class="fas fa-chart-simple text-amber-500"></i>
                    <span id="nivel_risco_display" class="font-semibold text-lg">
                        {{ isset($perigosRisco) && $perigosRisco->nivel_risco ? $perigosRisco->nivel_risco : '--' }}
                    </span>
                    <span class="text-sm text-gray-500 ml-2">(calculado automaticamente)</span>
                </div>
                {{-- Campo oculto opcional: se quiser enviar o valor calculado, pode usar um hidden, mas o controller calcula novamente --}}
            </div>
        </div>

        {{-- Necessita Ação --}}
        <div class="w-full">
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="necessita_acao" name="necessita_acao" type="checkbox"
                        value="1"
                        class="h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500"
                        {{ old('necessita_acao', $perigosRisco->necessita_acao ?? false) ? 'checked' : '' }}>
                </div>
                <div class="ml-3 text-sm">
                    <label for="necessita_acao" class="font-medium text-gray-700">Necessita ação imediata?</label>
                    <p class="text-gray-500">Marque se este risco requer uma ação corretiva urgente.</p>
                </div>
            </div>
            @error('necessita_acao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 3: Medida de Controle --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-shield-alt text-amber-600"></i>Medida de Controle
        </h3>

        <div class="w-full">
            <label for="medida_controle" class="block text-sm font-medium text-gray-700">
                Medida de Controle
            </label>
            <div class="relative mt-1">
                <textarea id="medida_controle" name="medida_controle" rows="3"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('medida_controle') border-red-300 @enderror"
                    placeholder="Descreva as medidas de controle existentes ou propostas...">{{ old('medida_controle', $perigosRisco->medida_controle ?? '') }}</textarea>
            </div>
            @error('medida_controle') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 4: Status --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-flag text-amber-600"></i>Status
        </h3>

        <div class="w-full md:w-1/2">
            <label for="status" class="block text-sm font-medium text-gray-700">
                Status <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-circle text-gray-400"></i>
                </div>
                <select id="status" name="status"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-amber-500 focus:border-amber-500 @error('status') border-red-300 @enderror">
                    @foreach(['Ativo', 'Em tratamento', 'Eliminado'] as $statusOption)
                        <option value="{{ $statusOption }}" {{ old('status', $perigosRisco->status ?? 'Ativo') == $statusOption ? 'selected' : '' }}>
                            {{ $statusOption }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Script para cálculo dinâmico do nível de risco --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const probabilidade = document.getElementById('probabilidade');
            const severidade = document.getElementById('severidade');
            const nivelDisplay = document.getElementById('nivel_risco_display');

            function calcularNivel() {
                const p = parseInt(probabilidade.value) || 0;
                const s = parseInt(severidade.value) || 0;
                if (p > 0 && s > 0) {
                    nivelDisplay.textContent = p * s;
                } else {
                    nivelDisplay.textContent = '--';
                }
            }

            probabilidade.addEventListener('change', calcularNivel);
            severidade.addEventListener('change', calcularNivel);

            // Calcula ao carregar a página
            calcularNivel();
        });
    </script>
</div>