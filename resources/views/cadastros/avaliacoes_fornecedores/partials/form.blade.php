@php
    $avaliacao = $avaliacaoFornecedor ?? null;
@endphp

<div class="space-y-8">
    {{--  Bloco 1: Vínculos --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap2">
            <i class="fas fa-link text-blue-500"></i>Vínculos
        </h3>
        <div>
            {{-- Empresa --}}
            <div class="flex flex-wrap gap-4 items-end">
                <label for="empresa_id" class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                
                <!-- ADICIONE ESTA LINHA ABAIXO PARA ENVIAR O ID DA EMPRESA -->
                <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? '' }}">

                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? 'Empresa não definida' }}
                    </span>
                </div>
                {{-- Fornecedor --}}
                <div class="w-full md:w-[calc(50%-0.5rem)]">
                    <label for="fornecedor_id" class="block text-sm font-medium text-gray-700">
                        Fornecedor <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex-items-center pointer-events none">
                            <i class="fas fa-truck text-gray-400"></i>
                        </div>
                        <select name="fornecedor_id" id="fornecedor_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('fornecedor_id') border-red-300 @enderror" required>
                            <option value="">Selecione</option>
                            @foreach ($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->id}}"
                                    {{ (int) old('fornecedor_id', $avaliacao->fornecedor_id ?? '') === $fornecedor->id ? 'selected' : ''}}>
                                    {{ $fornecedor->razao_social }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('fornecedor_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mt-4">
            {{-- Avaliador --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="avaliador_id" class="block text-sm font-medium text-gray-700">Avaliador</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-check text-gray-400"></i>
                    </div>
                    <select name="avaliador_id" id="avaliador_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('avaliador_id') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @foreach($avaliadores as $user)
                            <option value="{{ $user->id }}"
                                {{ (int) old('avaliador_id', $avaliacao->avaliador_id ?? '') === $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('avaliador_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Período --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="periodo_referencia" class="block text-sm font-medium text-gray-700">
                    Período de Referência <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="text" id="periodo_referencia" name="periodo_referencia"
                        placeholder="Ex.: 2026-Q3 ou 2026-09" maxlength="20"
                        value="{{ old('periodo_referencia', $avaliacao->periodo_referencia ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('periodo_referencia') border-red-300 @enderror"
                        required>
                </div>
                @error('periodo_referencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Bloco 2: Notas --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-star text-yellow-500"></i> Notas (0 a 100)
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach([
                'nota_qualidade'     => ['Qualidade',   'fa-award'],
                'nota_prazo'         => ['Prazo',       'fa-clock'],
                'nota_atendimento'   => ['Atendimento', 'fa-headset'],
                'nota_esg_ambiental' => ['ESG Ambiental','fa-leaf'],
            ] as $campo => [$label, $icone])
                <div>
                    <label for="{{ $campo }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas {{ $icone }} text-gray-400"></i>
                        </div>
                        <input type="number" step="0.01" min="0" max="100"
                            id="{{ $campo }}" name="{{ $campo }}"
                            value="{{ old($campo, $avaliacao->{$campo} ?? '') }}"
                            class="js-nota pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error($campo) border-red-300 @enderror">
                    </div>
                    @error($campo) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            {{-- Nota Final --}}
            <div>
                <label for="nota_final" class="block text-sm font-medium text-gray-700">
                    Nota Final
                    <span class="text-xs text-gray-500">(auto se vazio)</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calculator text-gray-400"></i>
                    </div>
                    <input type="number" step="0.01" min="0" max="100"
                        id="nota_final" name="nota_final"
                        value="{{ old('nota_final', $avaliacao->nota_final ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nota_final') border-red-300 @enderror">
                </div>
                @error('nota_final') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Status --}}
            <div class="md:col-span-2">
                <label for="status_qualificacao" class="block text-sm font-medium text-gray-700">
                    Status de Qualificação <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-clipboard-check text-gray-400"></i>
                    </div>
                    @php
                        $statusOptions = ['Aprovado', 'Aprovado com Restrição', 'Reprovado', 'Em observação'];
                        $statusAtual = old('status_qualificacao', $avaliacao->status_qualificacao ?? 'Aprovado');
                    @endphp
                    <select name="status_qualificacao" id="status_qualificacao"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status_qualificacao') border-red-300 @enderror"
                        required>
                        @foreach($statusOptions as $opt)
                            <option value="{{ $opt }}" {{ $statusAtual === $opt ? 'selected' : '' }}>
                                {{ $opt }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status_qualificacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Bloco 3: Observações --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-comment-dots text-blue-500"></i> Observações e Plano de Ação
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label>
                <textarea id="observacoes" name="observacoes" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('observacoes') border-red-300 @enderror">{{ old('observacoes', $avaliacao->observacoes ?? '') }}</textarea>
                @error('observacoes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="plano_acao_exigido" class="block text-sm font-medium text-gray-700">Plano de Ação Exigido</label>
                <textarea id="plano_acao_exigido" name="plano_acao_exigido" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('plano_acao_exigido') border-red-300 @enderror">{{ old('plano_acao_exigido', $avaliacao->plano_acao_exigido ?? '') }}</textarea>
                @error('plano_acao_exigido') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-preenche nota_final enquanto o usuário não digitar manualmente nela
    (function () {
        const notas = document.querySelectorAll('.js-nota');
        const campoFinal = document.getElementById('nota_final');
        if (!campoFinal) return;

        let finalTouched = campoFinal.value.trim() !== '';
        campoFinal.addEventListener('input', () => { finalTouched = campoFinal.value.trim() !== ''; });

        function recalc() {
            if (finalTouched) return;
            const valores = Array.from(notas)
                .map(i => parseFloat(i.value))
                .filter(n => !isNaN(n));
            if (!valores.length) { campoFinal.value = ''; return; }
            const media = valores.reduce((a, b) => a + b, 0) / valores.length;
            campoFinal.value = media.toFixed(2);
        }

        notas.forEach(i => i.addEventListener('input', recalc));
    })();
</script>
@endpush