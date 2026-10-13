<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Número do Contrato --}}
        <div>
            <label for="numero_contrato" class="block text-sm font-medium text-gray-700">
                Número do Contrato <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-barcode text-gray-400"></i>
                </div>
                <input type="text" id="numero_contrato" name="numero_contrato" value="{{ old('numero_contrato', $contrato->numero_contrato ?? '') }}"
                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('numero_contrato') border-red-300 @enderror" required placeholder="Ex: CTR-2026/001">
            </div>
            @error('numero_contrato') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Título --}}
        <div class="md:col-span-2">
            <label for="titulo" class="block text-sm font-medium text-gray-700">
                Título do Contrato <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-file-alt text-gray-400"></i>
                </div>
                <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $contrato->titulo ?? '') }}"
                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('titulo') border-red-300 @enderror" required placeholder="Ex: Prestação de Serviços de Consultoria SGI">
            </div>
            @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        {{-- Empresa (Hidden + Display) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Empresa</label>
            <div class="mt-1 flex items-center gap-2 p-2.5 border border-gray-200 rounded-md bg-gray-50">
                <i class="fas fa-building text-gray-400"></i>
                <span class="text-gray-700 text-sm truncate">
                    {{ $empresa->razao_social ?? $contrato->empresa?->razao_social ?? 'Empresa não definida' }}
                </span>
            </div>
            <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? ($contrato->empresa_id ?? '') }}">
        </div>

        {{-- Tipo --}}
        <div>
            <label for="tipo" class="block text-sm font-medium text-gray-700">
                Tipo <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <select id="tipo" name="tipo"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('tipo') border-red-300 @enderror" required>
                    @foreach(['Cliente', 'Fornecedor', 'Parceria', 'Prestação de Serviço'] as $tp)
                        <option value="{{ $tp }}" {{ old('tipo', $contrato->tipo ?? 'Cliente') == $tp ? 'selected' : '' }}>
                            {{ $tp }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">
                Status <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <select id="status" name="status"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('status') border-red-300 @enderror" required>
                    @foreach(['Minuta', 'Vingente', 'Suspenso', 'Encerrado', 'Recindido'] as $st)
                        <option value="{{ $st }}" {{ old('status', $contrato->status ?? 'Vingente') == $st ? 'selected' : '' }}>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Valor Total --}}
        <div>
            <label for="valor_total" class="block text-sm font-medium text-gray-700">Valor Total (R$)</label>
            <div class="mt-1">
                <input type="number" step="0.000001" id="valor_total" name="valor_total"
                    value="{{ old('valor_total', $contrato->valor_total ?? '') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('valor_total') border-red-300 @enderror" placeholder="0.00">
            </div>
            @error('valor_total') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        {{-- Data Início --}}
        <div>
            <label for="data_inicio" class="block text-sm font-medium text-gray-700">
                Data de Início <span class="text-red-500">*</span>
            </label>
            <div class="mt-1">
                <input type="date" id="data_inicio" name="data_inicio"
                    value="{{ old('data_inicio', optional($contrato->data_inicio ?? null)->format('Y-m-d')) }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('data_inicio') border-red-300 @enderror" required>
            </div>
            @error('data_inicio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Data Fim --}}
        <div>
            <label for="data_fim" class="block text-sm font-medium text-gray-700">
                Data de Término <span class="text-red-500">*</span>
            </label>
            <div class="mt-1">
                <input type="date" id="data_fim" name="data_fim"
                    value="{{ old('data_fim', optional($contrato->data_fim ?? null)->format('Y-m-d')) }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('data_fim') border-red-300 @enderror" required>
            </div>
            @error('data_fim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Alerta Vencimento (Dias) --}}
        <div>
            <label for="alerta_vencimento_dias" class="block text-sm font-medium text-gray-700">Alerta Vencimento (Dias)</label>
            <div class="mt-1">
                <input type="number" id="alerta_vencimento_dias" name="alerta_vencimento_dias"
                    value="{{ old('alerta_vencimento_dias', $contrato->alerta_vencimento_dias ?? 30) }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('alerta_vencimento_dias') border-red-300 @enderror">
            </div>
            @error('alerta_vencimento_dias') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Responsável --}}
        <div>
            <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
            <div class="mt-1">
                <select id="responsavel_id" name="responsavel_id"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('responsavel_id') border-red-300 @enderror">
                    <option value="">Selecione...</option>
                    @foreach($responsaveis ?? [] as $resp)
                        <option value="{{ $resp->id }}" {{ old('responsavel_id', $contrato->responsavel_id ?? '') == $resp->id ? 'selected' : '' }}>
                            {{ $resp->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Objeto --}}
    <div>
        <label for="objeto" class="block text-sm font-medium text-gray-700">Objeto do Contrato</label>
        <div class="mt-1">
            <textarea id="objeto" name="objeto" rows="3"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('objeto') border-red-300 @enderror"
                placeholder="Descreva o escopo e objeto...">{{ old('objeto', $contrato->objeto ?? '') }}</textarea>
        </div>
        @error('objeto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Observações --}}
    <div>
        <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label>
        <div class="mt-1">
            <textarea id="observacoes" name="observacoes" rows="2"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('observacoes') border-red-300 @enderror"
                placeholder="Notas adicionais...">{{ old('observacoes', $contrato->observacoes ?? '') }}</textarea>
        </div>
        @error('observacoes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>