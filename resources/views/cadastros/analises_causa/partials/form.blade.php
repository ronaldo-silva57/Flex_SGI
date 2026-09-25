@php $a = $analiseCausa ?? null; @endphp

<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Não Conformidade --}}
        <div>
            <label for="nao_conformidade_id" class="block text-sm font-medium text-gray-700">Não Conformidade <span class="text-red-500">*</span></label>
            <select id="nao_conformidade_id" name="nao_conformidade_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="">Selecione...</option>
                @foreach($naoConformidades as $nc)
                    <option value="{{ $nc->id }}" {{ old('nao_conformidade_id', $a->nao_conformidade_id ?? '') == $nc->id ? 'selected' : '' }}>
                        {{ $nc->codigo }} - {{ $nc->titulo }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Métodos (ex: 5 Porquês, Ishikawa) --}}
        <div>
            <label for="metodo" class="block text-sm font-medium text-gray-700">Método <span class="text-red-500">*</span></label>
            <select id="metodo" name="metodo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                <option value="5 Porquês" {{ old('metodo', $a->metodo ?? '') == '5 Porquês' ? 'selected' : '' }}>5 Porquês</option>
                <option value="Ishikawa" {{ old('metodo', $a->metodo ?? '') == 'Ishikawa' ? 'selected' : '' }}>Diagrama de Ishikawa (6M)</option>
                <option value="Misto" {{ old('metodo', $a->metodo ?? '') == 'Misto' ? 'selected' : '' }}>Análise Combinada</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Responsável --}}
        <div>
            <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
            <select id="responsavel_id" name="responsavel_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Selecione...</option>
                @foreach($usuarios as $u)
                    <option value="{{ $u->id }}" {{ old('responsavel_id', $a->responsavel_id ?? '') == $u->id ? 'selected' : '' }}>
                        {{ $u->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @foreach(['Em andamento', 'Concluído', 'Cancelado'] as $st)
                    <option value="{{ $st }}" {{ old('status', $a->status ?? 'Em andamento') == $st ? 'selected' : '' }}>
                        {{ $st }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Objetivo e Conclusão --}}
    <div>
        <label for="objetivo" class="block text-sm font-medium text-gray-700">Objetivo</label>
        <textarea id="objetivo" name="objetivo" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('objetivo', $a->objetivo ?? '') }}</textarea>
    </div>

    <div>
        <label for="conclusao" class="block text-sm font-medium text-gray-700">Conclusão</label>
        <textarea id="conclusao" name="conclusao" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('conclusao', $a->conclusao ?? '') }}</textarea>
    </div>

    {{-- Datas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data de Início</label>
            <input type="date" id="data_inicio" name="data_inicio" value="{{ old('data_inicio', isset($a->data_inicio) ? $a->data_inicio->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="data_conclusao" class="block text-sm font-medium text-gray-700">Data de Conclusão</label>
            <input type="date" id="data_conclusao" name="data_conclusao" value="{{ old('data_conclusao', isset($a->data_conclusao) ? $a->data_conclusao->format('Y-m-d') : '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
        </div>
    </div>
</div>