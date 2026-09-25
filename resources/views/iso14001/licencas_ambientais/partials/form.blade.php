@php
    $licenca = $licenca ?? null;
@endphp

<div class="space-y-6">
    <h3 class="text-lg font-medium text-gray-900 flex items-center gap-2 border-b pb-2">
        <i class="fas fa-file-contract text-green-600"></i> Informações Principais da Licença
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="numero" class="block text-sm font-medium text-gray-700">Número da Licença <span class="text-red-500">*</span></label>
            <input type="text" name="numero" id="numero" value="{{ old('numero', $licenca?->numero) }}" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('numero') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Licença <span class="text-red-500">*</span></label>
            <select name="tipo" id="tipo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Selecione...</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipo', $licenca?->tipo) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                @endforeach
            </select>
            @error('tipo') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="orgao_emissor" class="block text-sm font-medium text-gray-700">Órgão Emissor <span class="text-red-500">*</span></label>
            <input type="text" name="orgao_emissor" id="orgao_emissor" value="{{ old('orgao_emissor', $licenca?->orgao_emissor) }}" required placeholder="Ex.: CETESB, IBAMA"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('orgao_emissor') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="data_emissao" class="block text-sm font-medium text-gray-700">Data de Emissão <span class="text-red-500">*</span></label>
            <input type="date" name="data_emissao" id="data_emissao" value="{{ old('data_emissao', $licenca?->data_emissao?->format('Y-m-d')) }}" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('data_emissao') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="data_validade" class="block text-sm font-medium text-gray-700">Data de Validade <span class="text-red-500">*</span></label>
            <input type="date" name="data_validade" id="data_validade" value="{{ old('data_validade', $licenca?->data_validade?->format('Y-m-d')) }}" required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('data_validade') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="data_renovacao" class="block text-sm font-medium text-gray-700">Data Limite p/ Renovação</label>
            <input type="date" name="data_renovacao" id="data_renovacao" value="{{ old('data_renovacao', $licenca?->data_renovacao?->format('Y-m-d')) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('data_renovacao') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
            <select name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @foreach($statuses as $st)
                    <option value="{{ $st }}" {{ old('status', $licenca?->status ?? 'Vigente') == $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
            </select>
            @error('status') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável Interno</label>
            <select name="responsavel_id" id="responsavel_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Selecione...</option>
                @foreach($usuarios as $id => $nome)
                    <option value="{{ $id }}" {{ old('responsavel_id', $licenca?->responsavel_id) == $id ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>
            @error('responsavel_id') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
    </div>

    <div>
        <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição / Escopo da Licença</label>
        <textarea name="descricao" id="descricao" rows="3"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('descricao', $licenca?->descricao) }}</textarea>
    </div>

    <div>
        <label for="condicionantes" class="block text-sm font-medium text-gray-700">Condicionantes Ambientais</label>
        <textarea name="condicionantes" id="condicionantes" rows="4" placeholder="Exigências e obrigações técnicas estipuladas no documento..."
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('condicionantes', $licenca?->condicionantes) }}</textarea>
    </div>

    <div>
        <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações Gerais</label>
        <textarea name="observacoes" id="observacoes" rows="2"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('observacoes', $licenca?->observacoes) }}</textarea>
    </div>
</div>