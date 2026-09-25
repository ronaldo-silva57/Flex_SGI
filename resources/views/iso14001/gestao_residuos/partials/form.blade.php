@php $residuo = $residuo ?? null; @endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Código <span class="text-red-500">*</span></label>
            <input type="text" name="codigo" value="{{ old('codigo', $residuo?->codigo) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('codigo') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700">Descrição do Resíduo <span class="text-red-500">*</span></label>
            <input type="text" name="descricao" value="{{ old('descricao', $residuo?->descricao) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('descricao') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Tipo de Resíduo <span class="text-red-500">*</span></label>
            <select name="tipo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Selecione...</option>
                @foreach(\App\Models\GestaoResiduo::TIPOS as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipo', $residuo?->tipo) == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Classe (NBR 10.004)</label>
            <select name="classe" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Selecione...</option>
                @foreach(\App\Models\GestaoResiduo::CLASSES as $classe)
                    <option value="{{ $classe }}" {{ old('classe', $residuo?->classe) == $classe ? 'selected' : '' }}>{{ $classe }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
            <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="Ativo" {{ old('status', $residuo?->status ?? 'Ativo') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="Inativo" {{ old('status', $residuo?->status) == 'Inativo' ? 'selected' : '' }}>Inativo</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Qtd. Gerada / Mês</label>
            <input type="number" step="0.001" name="quantidade_gerada" value="{{ old('quantidade_gerada', $residuo?->quantidade_gerada) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Unidade de Medida</label>
            <input type="text" name="unidade_medida" placeholder="Ex: kg, t, m³" value="{{ old('unidade_medida', $residuo?->unidade_medida) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Frequência de Geração</label>
            <select name="frequencia_geracao" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Selecione...</option>
                @foreach(\App\Models\GestaoResiduo::FREQUENCIAS as $freq)
                    <option value="{{ $freq }}" {{ old('frequencia_geracao', $residuo?->frequencia_geracao) == $freq ? 'selected' : '' }}>{{ $freq }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Processo Gerador</label>
            <select name="processo_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Nenhum</option>
                @foreach($processos as $id => $nome)
                    <option value="{{ $id }}" {{ old('processo_id', $residuo?->processo_id) == $id ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Responsável Interno</label>
            <select name="responsavel_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Nenhum</option>
                @foreach($usuarios as $id => $nome)
                    <option value="{{ $id }}" {{ old('responsavel_id', $residuo?->responsavel_id) == $id ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Destino Final</label>
            <select name="destino_final" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Selecione...</option>
                @foreach(\App\Models\GestaoResiduo::DESTINOS as $dest)
                    <option value="{{ $dest }}" {{ old('destino_final', $residuo?->destino_final) == $dest ? 'selected' : '' }}>{{ $dest }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Empresa Transportadora</label>
            <input type="text" name="transportador" value="{{ old('transportador', $residuo?->transportador) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Empresa Destinadora</label>
            <input type="text" name="destinador" value="{{ old('destinador', $residuo?->destinador) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">Forma de Armazenamento</label>
            <textarea name="forma_armazenamento" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('forma_armazenamento', $residuo?->forma_armazenamento) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Observações</label>
            <textarea name="observacoes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('observacoes', $residuo?->observacoes) }}</textarea>
        </div>
    </div>
</div>