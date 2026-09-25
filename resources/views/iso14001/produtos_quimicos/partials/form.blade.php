@php $produtoQuimico = $produtoQuimico ?? null; @endphp

<div class="space-y-8">
    {{-- Identificação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-flask text-green-600"></i> Identificação
        </h3>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Nome <span class="text-red-500">*</span></label>
                <input type="text" name="nome" value="{{ old('nome', $produtoQuimico->nome ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('nome') border-red-300 @enderror">
                @error('nome')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Fabricante</label>
                <input type="text" name="fabricante" value="{{ old('fabricante', $produtoQuimico->fabricante ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(33%-0.7rem)]">
                <label class="block text-sm font-medium text-gray-700">Nº FISPQ</label>
                <input type="text" name="numero_fispq" value="{{ old('numero_fispq', $produtoQuimico->numero_fispq ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(33%-0.7rem)]">
                <label class="block text-sm font-medium text-gray-700">Nº CAS</label>
                <input type="text" name="numero_cas" value="{{ old('numero_cas', $produtoQuimico->numero_cas ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(34%-0.6rem)]">
                <label class="block text-sm font-medium text-gray-700">Estado Físico</label>
                <select name="estado_fisico"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">—</option>
                    @foreach(['Sólido','Líquido','Gasoso','Pastoso','Outros'] as $ef)
                        <option value="{{ $ef }}" {{ old('estado_fisico', $produtoQuimico->estado_fisico ?? '') == $ef ? 'selected' : '' }}>{{ $ef }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex flex-wrap gap-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Fornecedor</label>
                <select name="fornecedor_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">— Selecione —</option>
                    @foreach($fornecedores as $id => $nome)
                        <option value="{{ $id }}" {{ old('fornecedor_id', $produtoQuimico->fornecedor_id ?? '') == $id ? 'selected' : '' }}>{{ $nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Responsável</label>
                <select name="responsavel_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">— Selecione —</option>
                    @foreach($usuarios as $id => $nome)
                        <option value="{{ $id }}" {{ old('responsavel_id', $produtoQuimico->responsavel_id ?? auth()->id()) == $id ? 'selected' : '' }}>{{ $nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- FISPQ/FDS --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-exclamation-triangle text-amber-600"></i> Blocos da FISPQ / FDS
        </h3>

        @foreach([
            'composicao'             => 'Composição',
            'perigos_ghs'            => 'Perigos GHS',
            'primeiros_socorros'     => 'Primeiros Socorros',
            'combate_incendio'       => 'Combate a Incêndio',
            'medidas_derramamento'   => 'Medidas em caso de Derramamento',
            'manuseio_armazenamento' => 'Manuseio e Armazenamento',
            'epi_necessario'         => 'EPI Necessário',
            'epc_necessario'         => 'EPC Necessário',
        ] as $field => $label)
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                <textarea name="{{ $field }}" rows="2"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">{{ old($field, $produtoQuimico->$field ?? '') }}</textarea>
            </div>
        @endforeach

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Palavra de Advertência</label>
                <input type="text" name="palavra_advertencia" value="{{ old('palavra_advertencia', $produtoQuimico->palavra_advertencia ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Pictogramas</label>
                <input type="text" name="pictogramas" value="{{ old('pictogramas', $produtoQuimico->pictogramas ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
        </div>
    </div>

    {{-- Estoque --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-boxes text-blue-600"></i> Estoque
        </h3>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Localização</label>
                <input type="text" name="localizacao" value="{{ old('localizacao', $produtoQuimico->localizacao ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Quantidade</label>
                <input type="number" step="0.001" name="quantidade_estoque" value="{{ old('quantidade_estoque', $produtoQuimico->quantidade_estoque ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Unidade</label>
                <input type="text" name="unidade_medida" value="{{ old('unidade_medida', $produtoQuimico->unidade_medida ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div class="flex flex-wrap gap-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Validade</label>
                <input type="date" name="data_validade"
                       value="{{ old('data_validade', optional($produtoQuimico->data_validade ?? null)->format('Y-m-d') ?? ($produtoQuimico->data_validade ?? '')) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select name="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    @foreach(['Ativo','Inativo','Descontinuado'] as $st)
                        <option value="{{ $st }}" {{ old('status', $produtoQuimico->status ?? 'Ativo') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>