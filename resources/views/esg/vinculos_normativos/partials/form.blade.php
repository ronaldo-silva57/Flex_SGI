<div class="space-y-8">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-link text-blue-600 mr-1"></i>Vínculo
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="norma_id" class="block text-sm font-medium text-gray-700">Norma <span class="text-red-500">*</span></label>
                <select id="norma_id" name="norma_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Selecione</option>
                    @foreach($normas as $norma)
                        <option value="{{ $norma->id }}" {{ old('norma_id', $vinculos_normativo->norma_id ?? '') == $norma->id ? 'selected' : '' }}>
                            {{ $norma->nome }}
                        </option>
                    @endforeach
                </select>
                @error('norma_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="clausula_id" class="block text-sm font-medium text-gray-700">Cláusula <span class="text-red-500">*</span></label>
                <select id="clausula_id" name="clausula_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Selecione</option>
                    @foreach($clausulas as $clausula)
                        <option value="{{ $clausula->id }}" {{ old('clausula_id', $vinculos_normativo->clausula_id ?? '') == $clausula->id ? 'selected' : '' }}>
                            {{ $clausula->descricao }}
                        </option>
                    @endforeach
                </select>
                @error('clausula_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="processo_id" class="block text-sm font-medium text-gray-700">Processo <span class="text-red-500">*</span></label>
            <select id="processo_id" name="processo_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Selecione</option>
                @foreach($processos as $processo)
                    <option value="{{ $processo->id }}" {{ old('processo_id', $vinculos_normativo->processo_id ?? '') == $processo->id ? 'selected' : '' }}>
                        {{ $processo->nome }}
                    </option>
                @endforeach
            </select>
            @error('processo_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="documento_id" class="block text-sm font-medium text-gray-700">Documento (opcional)</label>
                <select id="documento_id" name="documento_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Nenhum</option>
                    @foreach($documentos as $doc)
                        <option value="{{ $doc->id }}" {{ old('documento_id', $vinculos_normativo->documento_id ?? '') == $doc->id ? 'selected' : '' }}>
                            {{ $doc->nome }}
                        </option>
                    @endforeach
                </select>
                @error('documento_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="indicador_id" class="block text-sm font-medium text-gray-700">Indicador (opcional)</label>
                <select id="indicador_id" name="indicador_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Nenhum</option>
                    @foreach($indicadores as $ind)
                        <option value="{{ $ind->id }}" {{ old('indicador_id', $vinculos_normativo->indicador_id ?? '') == $ind->id ? 'selected' : '' }}>
                            {{ $ind->nome }}
                        </option>
                    @endforeach
                </select>
                @error('indicador_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label for="risco_id" class="block text-sm font-medium text-gray-700">Risco/Oportunidade (opcional)</label>
                <select id="risco_id" name="risco_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Nenhum</option>
                    @foreach($riscos as $risco)
                        <option value="{{ $risco->id }}" {{ old('risco_id', $vinculos_normativo->risco_id ?? '') == $risco->id ? 'selected' : '' }}>
                            {{ $risco->descricao }}
                        </option>
                    @endforeach
                </select>
                @error('risco_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="requisito_legal_id" class="block text-sm font-medium text-gray-700">Requisito Legal (opcional)</label>
                <select id="requisito_legal_id" name="requisito_legal_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Nenhum</option>
                    @foreach($requisitos as $req)
                        <option value="{{ $req->id }}" {{ old('requisito_legal_id', $vinculos_normativo->requisito_legal_id ?? '') == $req->id ? 'selected' : '' }}>
                            {{ $req->descricao }}
                        </option>
                    @endforeach
                </select>
                @error('requisito_legal_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="esg_indicador_id" class="block text-sm font-medium text-gray-700">Indicador ESG (opcional)</label>
                <select id="esg_indicador_id" name="esg_indicador_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Nenhum</option>
                    @foreach($esgIndicadores as $esg)
                        <option value="{{ $esg->id }}" {{ old('esg_indicador_id', $vinculos_normativo->esg_indicador_id ?? '') == $esg->id ? 'selected' : '' }}>
                            {{ $esg->codigo }} - {{ $esg->nome }}
                        </option>
                    @endforeach
                </select>
                @error('esg_indicador_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="observacao" class="block text-sm font-medium text-gray-700">Observação</label>
            <textarea id="observacao" name="observacao" rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                placeholder="Observações adicionais...">{{ old('observacao', $vinculos_normativo->observacao ?? '') }}</textarea>
            @error('observacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>