<div class="space-y-8">
    {{-- Seção 1: Tema e Indicador --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-ribbon text-purple-600 mr-1"></i>Dados do Tema
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Empresa (fixa) --}}
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

            {{-- Indicador ESG (opcional) --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="esg_indicador_id" class="block text-sm font-medium text-gray-700">
                    Indicador ESG (opcional)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-chart-pie text-gray-400"></i>
                    </div>
                    <select id="esg_indicador_id" name="esg_indicador_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('esg_indicador_id') border-red-300 @enderror">
                        <option value="">Nenhum</option>
                        @foreach($indicadores as $ind)
                            <option value="{{ $ind->id }}" {{ old('esg_indicador_id', $materialidade->esg_indicador_id ?? '') == $ind->id ? 'selected' : '' }}>
                                {{ $ind->codigo }} - {{ $ind->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('esg_indicador_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Tema --}}
        <div class="w-full mb-4">
            <label for="tema" class="block text-sm font-medium text-gray-700">
                Tema <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-tag text-gray-400"></i>
                </div>
                <input type="text" id="tema" name="tema"
                       value="{{ old('tema', $materialidade->tema ?? '') }}"
                       placeholder="Ex: Mudanças Climáticas"
                       class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('tema') border-red-300 @enderror">
            </div>
            @error('tema') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 2: Importâncias e Classificação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-calculator text-purple-600"></i>Avaliação de Materialidade
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="importancia_stakeholders" class="block text-sm font-medium text-gray-700">
                    Importância para Stakeholders (1 a 5) <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-users text-gray-400"></i>
                    </div>
                    <select id="importancia_stakeholders" name="importancia_stakeholders"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('importancia_stakeholders') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('importancia_stakeholders', $materialidade->importancia_stakeholders ?? '') == $i ? 'selected' : '' }}>
                                {{ $i }} - {{ ['Muito Baixa', 'Baixa', 'Média', 'Alta', 'Muito Alta'][$i-1] }}
                            </option>
                        @endfor
                    </select>
                </div>
                @error('importancia_stakeholders') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="importancia_negocio" class="block text-sm font-medium text-gray-700">
                    Importância para o Negócio (1 a 5) <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-building text-gray-400"></i>
                    </div>
                    <select id="importancia_negocio" name="importancia_negocio"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('importancia_negocio') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}" {{ old('importancia_negocio', $materialidade->importancia_negocio ?? '') == $i ? 'selected' : '' }}>
                                {{ $i }} - {{ ['Muito Baixa', 'Baixa', 'Média', 'Alta', 'Muito Alta'][$i-1] }}
                            </option>
                        @endfor
                    </select>
                </div>
                @error('importancia_negocio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Classificação (calculada automaticamente com JavaScript) --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="classificacao" class="block text-sm font-medium text-gray-700">
                    Classificação (automática com base no Score)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-chart-simple text-gray-400"></i>
                    </div>
                    <select id="classificacao" name="classificacao"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('classificacao') border-red-300 @enderror">
                        <option value="">Selecione manualmente (ou automático)</option>
                        @foreach($classificacoes as $cat)
                            <option value="{{ $cat }}" {{ old('classificacao', $materialidade->classificacao ?? '') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('classificacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Score (Stakeholders + Negócio)
                </label>
                <div class="mt-1 p-2 border border-gray-200 rounded-md bg-gray-50 flex items-center gap-2">
                    <i class="fas fa-calculator text-purple-500"></i>
                    <span id="score_display" class="font-semibold text-lg">
                        {{ isset($materialidade) && $materialidade->score ? $materialidade->score : '--' }}
                    </span>
                    <span class="text-sm text-gray-500 ml-2">(calculado automaticamente)</span>
                </div>
            </div>
        </div>
    </div>

    {{-- JavaScript para calcular score e classificação automática --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stakeholders = document.getElementById('importancia_stakeholders');
            const negocio = document.getElementById('importancia_negocio');
            const scoreDisplay = document.getElementById('score_display');
            const classificacao = document.getElementById('classificacao');

            function atualizarScoreEClassificacao() {
                const s = parseInt(stakeholders.value) || 0;
                const n = parseInt(negocio.value) || 0;
                const total = s + n;

                if (s > 0 && n > 0) {
                    scoreDisplay.textContent = total;

                    // Sugere classificação automaticamente
                    let sugestao = '';
                    if (total >= 8) sugestao = 'Crítica';
                    else if (total >= 6) sugestao = 'Alta';
                    else if (total >= 4) sugestao = 'Média';
                    else if (total >= 2) sugestao = 'Baixa';

                    // Se o campo classificação estiver vazio, preenche a sugestão
                    if (classificacao.value === '') {
                        // Procura a opção com o valor sugerido e seleciona
                        for (let option of classificacao.options) {
                            if (option.value === sugestao) {
                                option.selected = true;
                                break;
                            }
                        }
                    }
                } else {
                    scoreDisplay.textContent = '--';
                }
            }

            stakeholders.addEventListener('change', atualizarScoreEClassificacao);
            negocio.addEventListener('change', atualizarScoreEClassificacao);

            // Executa ao carregar a página
            atualizarScoreEClassificacao();
        });
    </script>
</div>