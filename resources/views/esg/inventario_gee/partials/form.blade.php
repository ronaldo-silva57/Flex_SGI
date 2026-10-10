<div class="space-y-8">
    {{-- Seção 1: Identificação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-id-card text-purple-600"></i>Identificação
        </h3>

        <div class="flex flex-wrap gap-4 mb-4">
            {{-- Empresa (fixa) --}}
            <div class="w-full md:w-[calc(40%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">{{ $empresa->razao_social ?? 'Empresa não definida' }}</span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? '' }}">
            </div>

            {{-- Responsável --}}
            <div class="w-full md:w-[calc(30%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Nenhum</option>
                        @foreach($usuarios as $u)
                            <option value="{{ $u->id }}" {{ old('responsavel_id', $inventarioGee->responsavel_id ?? '') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Ano referência --}}
            <div class="w-full md:w-[calc(30%-0.5rem)]">
                <label for="ano_referencia" class="block text-sm font-medium text-gray-700">
                    Ano de Referência <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar text-gray-400"></i>
                    </div>
                    <input type="number" id="ano_referencia" name="ano_referencia"
                           min="1900" max="2100"
                           value="{{ old('ano_referencia', $inventarioGee->ano_referencia ?? date('Y')) }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('ano_referencia') border-red-300 @enderror">
                </div>
                @error('ano_referencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Código --}}
        <div class="w-full">
            <label for="codigo" class="block text-sm font-medium text-gray-700">
                Código <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-hashtag text-gray-400"></i>
                </div>
                <input type="text" id="codigo" name="codigo" maxlength="50"
                       value="{{ old('codigo', $inventarioGee->codigo ?? '') }}"
                       placeholder="Ex: GEE-2025-001"
                       class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('codigo') border-red-300 @enderror">
            </div>
            @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 2: Classificação (GHG Protocol) --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-layer-group text-purple-600"></i>Classificação (GHG Protocol)
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(33.333%-0.66rem)]">
                <label for="escopo" class="block text-sm font-medium text-gray-700">
                    Escopo <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-sitemap text-gray-400"></i>
                    </div>
                    <select id="escopo" name="escopo"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('escopo') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        <option value="1" {{ old('escopo', $inventarioGee->escopo ?? '') == '1' ? 'selected' : '' }}>Escopo 1 — Emissões Diretas</option>
                        <option value="2" {{ old('escopo', $inventarioGee->escopo ?? '') == '2' ? 'selected' : '' }}>Escopo 2 — Energia Adquirida</option>
                        <option value="3" {{ old('escopo', $inventarioGee->escopo ?? '') == '3' ? 'selected' : '' }}>Escopo 3 — Outras Indiretas</option>
                    </select>
                </div>
                @error('escopo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(33.333%-0.66rem)]">
                <label for="categoria" class="block text-sm font-medium text-gray-700">Categoria</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <input type="text" id="categoria" name="categoria" maxlength="150"
                           value="{{ old('categoria', $inventarioGee->categoria ?? '') }}"
                           placeholder="Ex: Combustão móvel"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('categoria') border-red-300 @enderror">
                </div>
                @error('categoria') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(33.333%-0.66rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flag text-gray-400"></i>
                    </div>
                    <select id="status" name="status"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('status') border-red-300 @enderror">
                        @foreach(['Rascunho', 'Em revisão', 'Verificado', 'Publicado'] as $st)
                            <option value="{{ $st }}" {{ old('status', $inventarioGee->status ?? 'Rascunho') == $st ? 'selected' : '' }}>
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Fonte de emissão --}}
        <div class="w-full">
            <label for="fonte_emissao" class="block text-sm font-medium text-gray-700">
                Fonte de Emissão <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-industry text-gray-400"></i>
                </div>
                <input type="text" id="fonte_emissao" name="fonte_emissao" maxlength="255"
                       value="{{ old('fonte_emissao', $inventarioGee->fonte_emissao ?? '') }}"
                       placeholder="Ex: Frota de veículos leves"
                       class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('fonte_emissao') border-red-300 @enderror">
            </div>
            @error('fonte_emissao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 3: Quantificação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-calculator text-purple-600"></i>Quantificação
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="quantidade" class="block text-sm font-medium text-gray-700">Quantidade</label>
                <input type="number" step="0.001" min="0" id="quantidade" name="quantidade"
                       value="{{ old('quantidade', $inventarioGee->quantidade ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('quantidade') border-red-300 @enderror">
                @error('quantidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="unidade" class="block text-sm font-medium text-gray-700">Unidade</label>
                <input type="text" id="unidade" name="unidade" maxlength="30"
                       value="{{ old('unidade', $inventarioGee->unidade ?? '') }}"
                       placeholder="Ex: L, kg, kWh"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('unidade') border-red-300 @enderror">
                @error('unidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="fator_emissao" class="block text-sm font-medium text-gray-700">Fator de Emissão</label>
                <input type="number" step="0.000001" min="0" id="fator_emissao" name="fator_emissao"
                       value="{{ old('fator_emissao', $inventarioGee->fator_emissao ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('fator_emissao') border-red-300 @enderror">
                @error('fator_emissao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="emissao_tco2e" class="block text-sm font-medium text-gray-700">
                    Emissão (tCO₂e) <span class="text-red-500">*</span>
                </label>
                <input type="number" step="0.000001" min="0" id="emissao_tco2e" name="emissao_tco2e"
                       value="{{ old('emissao_tco2e', $inventarioGee->emissao_tco2e ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 font-semibold @error('emissao_tco2e') border-red-300 @enderror">
                @error('emissao_tco2e') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Cálculo automático sugerido --}}
        <div class="w-full">
            <label class="block text-sm font-medium text-gray-700">Cálculo sugerido (quantidade × fator)</label>
            <div class="mt-1 p-2 border border-gray-200 rounded-md bg-gray-50 flex items-center gap-2">
                <i class="fas fa-equals text-purple-500"></i>
                <span id="calc_display" class="font-semibold text-lg">--</span>
                <span class="text-sm text-gray-500 ml-2">tCO₂e</span>
                <button type="button" id="usar_calculo"
                        class="ml-auto inline-flex items-center px-3 py-1 bg-purple-50 text-purple-700 rounded-md hover:bg-purple-100 text-xs">
                    <i class="fas fa-arrow-down mr-1"></i>Usar este valor
                </button>
            </div>
        </div>
    </div>

    {{-- Seção 4: Documentação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-file-alt text-purple-600"></i>Documentação e Rastreabilidade
        </h3>

        <div class="w-full mb-4">
            <label for="referencia_fator" class="block text-sm font-medium text-gray-700">Referência do Fator</label>
            <input type="text" id="referencia_fator" name="referencia_fator" maxlength="255"
                   value="{{ old('referencia_fator', $inventarioGee->referencia_fator ?? '') }}"
                   placeholder="Ex: IPCC 2006, MCTI 2023, GHG Protocol BR"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('referencia_fator') border-red-300 @enderror">
            @error('referencia_fator') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="w-full mb-4">
            <label for="metodologia" class="block text-sm font-medium text-gray-700">Metodologia</label>
            <textarea id="metodologia" name="metodologia" rows="3"
                      placeholder="Descreva a metodologia de cálculo utilizada..."
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('metodologia') border-red-300 @enderror">{{ old('metodologia', $inventarioGee->metodologia ?? '') }}</textarea>
            @error('metodologia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="w-full">
            <label for="evidencia" class="block text-sm font-medium text-gray-700">Evidência</label>
            <textarea id="evidencia" name="evidencia" rows="3"
                      placeholder="Descreva as evidências (notas fiscais, medições, laudos, etc.)..."
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('evidencia') border-red-300 @enderror">{{ old('evidencia', $inventarioGee->evidencia ?? '') }}</textarea>
            @error('evidencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const qtd = document.getElementById('quantidade');
            const fator = document.getElementById('fator_emissao');
            const calcDisplay = document.getElementById('calc_display');
            const btnUsar = document.getElementById('usar_calculo');
            const emissao = document.getElementById('emissao_tco2e');

            function atualizarCalculo() {
                const q = parseFloat(qtd.value) || 0;
                const f = parseFloat(fator.value) || 0;

                if (q > 0 && f > 0) {
                    const total = q * f;
                    calcDisplay.textContent = total.toLocaleString('pt-BR', {
                        minimumFractionDigits: 3,
                        maximumFractionDigits: 6
                    });
                    calcDisplay.dataset.valor = total;
                } else {
                    calcDisplay.textContent = '--';
                    calcDisplay.dataset.valor = '';
                }
            }

            qtd.addEventListener('input', atualizarCalculo);
            fator.addEventListener('input', atualizarCalculo);
            atualizarCalculo();

            btnUsar.addEventListener('click', function () {
                const valor = calcDisplay.dataset.valor;
                if (valor) {
                    emissao.value = parseFloat(valor).toFixed(6);
                }
            });
        });
    </script>
</div>