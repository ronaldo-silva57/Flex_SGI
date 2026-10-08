@php $risco = $analisesRiscoTi ?? $risco ?? null; @endphp

<div class="space-y-6">
    {{-- Ativo e Responsável --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Empresa <span class="text-red-500">*</span></label>
            <select name="empresa_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Selecione...</option>
                @foreach($empresas as $id => $nome)
                    <option value="{{ $id }}" {{ old('empresa_id', $risco?->empresa_id) == $id ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>
            @error('empresa_id') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Ativo de Informação <span class="text-red-500">*</span></label>
            <select name="ativo_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Selecione...</option>
                @foreach($ativos as $id => $nome)
                    <option value="{{ $id }}" {{ old('ativo_id', $risco?->ativo_id) == $id ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>
            @error('ativo_id') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Responsável</label>
            <select name="responsavel_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Nenhum</option>
                @foreach($usuarios as $id => $nome)
                    <option value="{{ $id }}" {{ old('responsavel_id', $risco?->responsavel_id) == $id ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Ameaça e Vulnerabilidade --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Ameaça <span class="text-red-500">*</span></label>
            <input type="text" name="ameaca" value="{{ old('ameaca', $risco?->ameaca) }}" required placeholder="Ex: Ataque de Ransomware, Falha de Hardware" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('ameaca') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Vulnerabilidade <span class="text-red-500">*</span></label>
            <input type="text" name="vulnerabilidade" value="{{ old('vulnerabilidade', $risco?->vulnerabilidade) }}" required placeholder="Ex: Sistemas sem patch de segurança, Ausência de MFA" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('vulnerabilidade') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- Pilares Afetados --}}
    <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
        <label class="block text-sm font-medium text-gray-700 mb-2">Pilares da Segurança da Informação Afetados</label>
        <div class="flex flex-wrap gap-6">
            <label class="inline-flex items-center">
                <input type="hidden" name="afeta_confidencialidade" value="0">
                <input type="checkbox" name="afeta_confidencialidade" value="1" {{ old('afeta_confidencialidade', $risco?->afeta_confidencialidade ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-700 font-semibold">Confidencialidade</span>
            </label>
            <label class="inline-flex items-center">
                <input type="hidden" name="afeta_integridade" value="0">
                <input type="checkbox" name="afeta_integridade" value="1" {{ old('afeta_integridade', $risco?->afeta_integridade ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-700 font-semibold">Integridade</span>
            </label>
            <label class="inline-flex items-center">
                <input type="hidden" name="afeta_disponibilidade" value="0">
                <input type="checkbox" name="afeta_disponibilidade" value="1" {{ old('afeta_disponibilidade', $risco?->afeta_disponibilidade ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-700 font-semibold">Disponibilidade</span>
            </label>
        </div>
    </div>

    {{-- Avaliação Inerente --}}
    <div class="border border-indigo-100 bg-indigo-50/30 p-4 rounded-md">
        <h3 class="text-sm font-semibold text-indigo-900 mb-3 flex items-center gap-1">
            <i class="fas fa-exclamation-triangle"></i> Avaliação do Risco Inerente
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Probabilidade (1 a 5) <span class="text-red-500">*</span></label>
                <select name="probabilidade" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Selecione...</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('probabilidade', $risco?->probabilidade) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Impacto (1 a 5) <span class="text-red-500">*</span></label>
                <select name="impacto" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Selecione...</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('impacto', $risco?->impacto) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach(['Identificado', 'Em tratamento', 'Monitorado', 'Encerrado'] as $st)
                        <option value="{{ $st }}" {{ old('status', $risco?->status ?? 'Identificado') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Tratameno e Controles --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Controles Existentes</label>
            <textarea name="controles_existentes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Controles técnicos ou administrativos já aplicados...">{{ old('controles_existentes', $risco?->controles_existentes) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Opção de Tratamento</label>
            <select name="opcao_tratamento" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mb-2">
                @foreach(['Mitigar', 'Transferir', 'Evitar', 'Aceitar'] as $opt)
                    <option value="{{ $opt }}" {{ old('opcao_tratamento', $risco?->opcao_tratamento ?? 'Mitigar') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Plano de Tratamento</label>
        <textarea name="plano_tratamento" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ações detalhadas para mitigar ou tratar o risco...">{{ old('plano_tratamento', $risco?->plano_tratamento) }}</textarea>
    </div>

    {{-- Avaliação Residual --}}
    <div class="border border-green-100 bg-green-50/30 p-4 rounded-md">
        <h3 class="text-sm font-semibold text-green-900 mb-3 flex items-center gap-1">
            <i class="fas fa-check-shield"></i> Avaliação do Risco Residual (Pós-Tratamento)
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Probabilidade Residual</label>
                <select name="probabilidade_residual" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Nenhum / Não avaliado</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('probabilidade_residual', $risco?->probabilidade_residual) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Impacto Residual</label>
                <select name="impacto_residual" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Nenhum / Não avaliado</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('impacto_residual', $risco?->impacto_residual) == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
</div>