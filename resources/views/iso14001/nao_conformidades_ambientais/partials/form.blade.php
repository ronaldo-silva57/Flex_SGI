@php $nc = $naoConformidade ?? null; @endphp

<div class="space-y-8">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-exclamation-triangle text-red-600"></i> Identificação
        </h3>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(25%-0.6rem)]">
                <label class="block text-sm font-medium text-gray-700">Código <span class="text-red-500">*</span></label>
                <input type="text" name="codigo" value="{{ old('codigo', $nc->codigo ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('codigo') border-red-300 @enderror">
                @error('codigo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="w-full md:w-[calc(75%-0.4rem)]">
                <label class="block text-sm font-medium text-gray-700">Título <span class="text-red-500">*</span></label>
                <input type="text" name="titulo" value="{{ old('titulo', $nc->titulo ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('titulo') border-red-300 @enderror">
                @error('titulo')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(33%-0.7rem)]">
                <label class="block text-sm font-medium text-gray-700">Origem <span class="text-red-500">*</span></label>
                <select name="origem"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    @foreach(['Auditoria','Fiscalização','Monitoramento','Reclamação','Incidente','Outros'] as $o)
                        <option value="{{ $o }}" {{ old('origem', $nc->origem ?? '') == $o ? 'selected' : '' }}>{{ $o }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-[calc(33%-0.7rem)]">
                <label class="block text-sm font-medium text-gray-700">Gravidade</label>
                <select name="gravidade"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">—</option>
                    @foreach(['Baixa','Média','Alta','Crítica'] as $g)
                        <option value="{{ $g }}" {{ old('gravidade', $nc->gravidade ?? '') == $g ? 'selected' : '' }}>{{ $g }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-[calc(34%-0.6rem)]">
                <label class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select name="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    @foreach(['Aberta','Em análise','Em ação','Verificação','Fechada'] as $st)
                        <option value="{{ $st }}" {{ old('status', $nc->status ?? 'Aberta') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Local da Ocorrência</label>
                <input type="text" name="local_ocorrencia" value="{{ old('local_ocorrencia', $nc->local_ocorrencia ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Probabilidade</label>
                <input type="text" name="probabilidade" value="{{ old('probabilidade', $nc->probabilidade ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Prioridade</label>
                <input type="text" name="prioridade" value="{{ old('prioridade', $nc->prioridade ?? '') }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Descrição <span class="text-red-500">*</span></label>
            <textarea name="descricao" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('descricao') border-red-300 @enderror">{{ old('descricao', $nc->descricao ?? '') }}</textarea>
            @error('descricao')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Requisito não Atendido</label>
                <textarea name="requisito_nao_atendido" rows="2"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('requisito_nao_atendido', $nc->requisito_nao_atendido ?? '') }}</textarea>
            </div>
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Evidência Inicial</label>
                <textarea name="evidencia_inicial" rows="2"
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('evidencia_inicial', $nc->evidencia_inicial ?? '') }}</textarea>
            </div>
        </div>

        <label class="inline-flex items-center gap-2">
            <input type="hidden" name="recorrente" value="0">
            <input type="checkbox" name="recorrente" value="1"
                   {{ old('recorrente', $nc->recorrente ?? false) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
            <span class="text-sm font-medium text-gray-700">Ocorrência recorrente</span>
        </label>
    </div>

    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-link text-blue-600"></i> Vínculos
        </h3>

        <div class="flex flex-wrap gap-4 mb-4">
            <div class="w-full md:w-[calc(33%-0.7rem)]">
                <label class="block text-sm font-medium text-gray-700">Licença Ambiental</label>
                <select name="licenca_ambiental_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">— Nenhuma —</option>
                    @foreach($licencas as $id => $titulo)
                        <option value="{{ $id }}" {{ old('licenca_ambiental_id', $nc->licenca_ambiental_id ?? '') == $id ? 'selected' : '' }}>{{ $titulo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-[calc(33%-0.7rem)]">
                <label class="block text-sm font-medium text-gray-700">Aspecto Ambiental</label>
                <select name="aspecto_ambiental_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">— Nenhum —</option>
                    @foreach($aspectos as $id => $desc)
                        <option value="{{ $id }}" {{ old('aspecto_ambiental_id', $nc->aspecto_ambiental_id ?? '') == $id ? 'selected' : '' }}>{{ Str::limit($desc, 60) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-[calc(34%-0.6rem)]">
                <label class="block text-sm font-medium text-gray-700">Processo</label>
                <select name="processo_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">— Nenhum —</option>
                    @foreach($processos as $id => $nome)
                        <option value="{{ $id }}" {{ old('processo_id', $nc->processo_id ?? '') == $id ? 'selected' : '' }}>{{ $nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex flex-wrap gap-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Responsável pela Apuração</label>
                <select name="responsavel_apuracao_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">— Selecione —</option>
                    @foreach($usuarios as $id => $nome)
                        <option value="{{ $id }}" {{ old('responsavel_apuracao_id', $nc->responsavel_apuracao_id ?? '') == $id ? 'selected' : '' }}>{{ $nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Responsável pelo Tratamento</label>
                <select name="responsavel_tratamento_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">— Selecione —</option>
                    @foreach($usuarios as $id => $nome)
                        <option value="{{ $id }}" {{ old('responsavel_tratamento_id', $nc->responsavel_tratamento_id ?? '') == $id ? 'selected' : '' }}>{{ $nome }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-calendar text-amber-600"></i> Datas e Tratamento
        </h3>

        <div class="flex flex-wrap gap-4 mb-4">
            @foreach([
                'data_identificacao' => 'Identificação',
                'data_abertura'      => 'Abertura',
                'prazo_tratamento'   => 'Prazo Tratamento',
                'data_analise'       => 'Análise',
                'data_verificacao'   => 'Verificação',
                'data_encerramento'  => 'Encerramento',
            ] as $field => $label)
                <div class="w-full md:w-[calc(33%-0.7rem)]">
                    <label class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                    <input type="date" name="{{ $field }}"
                           value="{{ old($field, optional($nc->$field ?? null)->format('Y-m-d') ?? ($nc->$field ?? '')) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">
                </div>
            @endforeach
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Ação Corretiva</label>
            <textarea name="acao_corretiva" rows="3"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('acao_corretiva', $nc->acao_corretiva ?? '') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Justificativa de Encerramento</label>
            <textarea name="justificativa_encerramento" rows="2"
                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('justificativa_encerramento', $nc->justificativa_encerramento ?? '') }}</textarea>
        </div>
    </div>
</div>