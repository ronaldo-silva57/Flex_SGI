@php
    /** @var \App\Models\Calibracao $calibracao */
    $equipamentoForm = $equipamento ?? $calibracao->equipamento;
    $ehEdicao = $calibracao->exists;
@endphp

<div class="space-y-8">
    {{-- Contexto: equipamento --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 flex items-center gap-3">
        <i class="fas fa-ruler-combined text-blue-600 text-xl"></i>
        <div>
            <p class="text-xs uppercase tracking-wide text-blue-700 font-semibold">Equipamento</p>
            <p class="text-gray-900 font-medium">
                {{ $equipamentoForm->codigo }} — {{ $equipamentoForm->nome }}
            </p>
            @if(trim($equipamentoForm->marca . ' ' . $equipamentoForm->modelo))
                <p class="text-xs text-gray-500">{{ trim($equipamentoForm->marca . ' ' . $equipamentoForm->modelo) }}</p>
            @endif
        </div>
    </div>

    {{-- Dados da calibração --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-clipboard-check text-blue-500"></i>
            Dados da Calibração
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Data calibração --}}
            <div>
                <label for="data_calibracao" class="block text-sm font-medium text-gray-700">
                    Data da calibração <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>
                    <input type="date" id="data_calibracao" name="data_calibracao" required
                           value="{{ old('data_calibracao', $calibracao->data_calibracao?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_calibracao') border-red-300 @enderror">
                </div>
                @error('data_calibracao')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Data validade --}}
            <div>
                <label for="data_validade" class="block text-sm font-medium text-gray-700">
                    Validade <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" id="data_validade" name="data_validade" required
                           value="{{ old('data_validade', $calibracao->data_validade?->format('Y-m-d')) }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_validade') border-red-300 @enderror">
                </div>
                @error('data_validade')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                @if($equipamentoForm->periodicidade_calibracao_meses)
                    <p class="mt-1 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Sugerido: <span id="sugestaoValidade">—</span>
                        ({{ $equipamentoForm->periodicidade_calibracao_meses }} meses)
                    </p>
                @endif
            </div>

            {{-- Laboratório --}}
            <div>
                <label for="laboratorio" class="block text-sm font-medium text-gray-700">Laboratório</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flask text-gray-400"></i>
                    </div>
                    <input type="text" id="laboratorio" name="laboratorio"
                           value="{{ old('laboratorio', $calibracao->laboratorio) }}"
                           placeholder="Nome do laboratório"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('laboratorio') border-red-300 @enderror">
                </div>
                @error('laboratorio')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Nº certificado --}}
            <div>
                <label for="certificado_numero" class="block text-sm font-medium text-gray-700">Nº do certificado</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-certificate text-gray-400"></i>
                    </div>
                    <input type="text" id="certificado_numero" name="certificado_numero"
                           value="{{ old('certificado_numero', $calibracao->certificado_numero) }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('certificado_numero') border-red-300 @enderror">
                </div>
                @error('certificado_numero')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Resultado --}}
            <div>
                <label for="resultado" class="block text-sm font-medium text-gray-700">
                    Resultado <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-clipboard-list text-gray-400"></i>
                    </div>
                    <select id="resultado" name="resultado" required
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('resultado') border-red-300 @enderror">
                        @foreach(['Aprovado','Aprovado com restrição','Reprovado'] as $r)
                            <option value="{{ $r }}" @selected(old('resultado', $calibracao->resultado ?? 'Aprovado') === $r)>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                @error('resultado')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Responsável --}}
            <div>
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">— padrão (usuário atual) —</option>
                        @foreach($responsaveis as $r)
                            <option value="{{ $r->id }}" @selected(old('responsavel_id', $calibracao->responsavel_id) == $r->id)>
                                {{ $r->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Certificado (arquivo) --}}
            <div class="md:col-span-2">
                <label for="certificado" class="block text-sm font-medium text-gray-700">Certificado (PDF/imagem)</label>
                <div class="mt-1 flex items-center gap-3">
                    <input type="file" id="certificado" name="certificado"
                           accept=".pdf,.jpg,.jpeg,.png"
                           class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('certificado') border-red-300 @enderror">
                </div>
                @error('certificado')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror

                @if($ehEdicao && $calibracao->certificado_path)
                    <div class="mt-2 flex items-center gap-2 text-sm text-gray-600">
                        <i class="fas fa-paperclip text-gray-400"></i>
                        <a href="{{ Storage::disk('public')->url($calibracao->certificado_path) }}"
                           target="_blank" class="text-indigo-600 hover:underline">
                            Arquivo atual
                        </a>
                        <span class="text-xs text-gray-500">(enviar novo substitui o atual)</span>
                    </div>
                @endif
            </div>

            {{-- Observações --}}
            <div class="md:col-span-2">
                <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label>
                <textarea id="observacoes" name="observacoes" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('observacoes') border-red-300 @enderror">{{ old('observacoes', $calibracao->observacoes) }}</textarea>
                @error('observacoes')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>
</div>

@if($equipamentoForm->periodicidade_calibracao_meses)
    @push('scripts')
        <script>
            (function () {
                const meses   = {{ (int) $equipamentoForm->periodicidade_calibracao_meses }};
                const inputD  = document.getElementById('data_calibracao');
                const inputV  = document.getElementById('data_validade');
                const sugest  = document.getElementById('sugestaoValidade');

                function atualizar() {
                    if (!inputD.value) return;
                    const d = new Date(inputD.value + 'T00:00:00');
                    d.setMonth(d.getMonth() + meses);
                    const iso = d.toISOString().slice(0, 10);
                    if (sugest) sugest.textContent = d.toLocaleDateString('pt-BR');
                    if (!inputV.value) inputV.value = iso;
                }
                inputD.addEventListener('change', atualizar);
                atualizar();
            })();
        </script>
    @endpush
@endif