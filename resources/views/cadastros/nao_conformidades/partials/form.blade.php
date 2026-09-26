@php
    $ncPreSelecionada = $ncPreSelecionada ?? null;
@endphp

@if($ncPreSelecionada)
    {{-- Contexto bloqueado, mostra a NC vinculada --}}
    <div class="mb-4 flex items-center gap-3 p-3 bg-orange-50 border border-orange-200 rounded-md">
        <i class="fas fa-link text-orange-500"></i>
        <div class="text-sm text-orange-900">
            Vinculada à NC
            <strong class="font-mono">{{ $ncPreSelecionada->codigo }}</strong>
            — {{ Str::limit($ncPreSelecionada->titulo, 60) }}
        </div>
    </div>
    <input type="hidden" name="nao_conformidade_id" value="{{ $ncPreSelecionada->id }}">
@else
    {{-- Select normal --}}
{{-- Select de Não Conformidade --}}
<div class="w-full mb-4">
    <label for="nao_conformidade_id" class="block text-sm font-medium text-gray-700">
        Não Conformidade <span class="text-red-500">*</span>
    </label>
    <div class="relative mt-1">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="fas fa-exclamation-triangle text-gray-400"></i>
        </div>
        <select id="nao_conformidade_id" name="nao_conformidade_id"
            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500"
            required>
            <option value="">Selecione a não conformidade...</option>

            {{-- Caso esteja criando e tenha lista de NCs --}}
            @if(isset($naoConformidades) && $naoConformidades->count())
                @foreach($naoConformidades as $nc)
                    <option value="{{ $nc->id }}"
                        {{ old('nao_conformidade_id', $acaoCorretiva->nao_conformidade_id ?? '') == $nc->id ? 'selected' : '' }}>
                        {{ $nc->codigo }} — {{ Str::limit($nc->titulo, 60) }}
                    </option>
                @endforeach
            @endif

            {{-- Caso esteja editando e tenha apenas uma NC vinculada --}}
            @if(isset($naoConformidade))
                <option value="{{ $naoConformidade->id }}"
                    {{ old('nao_conformidade_id', $acaoCorretiva->nao_conformidade_id ?? '') == $naoConformidade->id ? 'selected' : '' }}>
                    {{ $naoConformidade->codigo }} — {{ Str::limit($naoConformidade->titulo, 60) }}
                </option>
            @endif
        </select>
    </div>
</div>

@endif


@php
    $nc = $naoConformidade ?? null;
@endphp

<div class="space-y-8">

    {{-- SEÇÃO 1: Identificação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2 border-b pb-2">
            <i class="fas fa-id-card text-red-500"></i> Identificação
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Código --}}
            <div class="w-full md:w-[calc(35%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Código <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo" maxlength="40"
                        value="{{ old('codigo', $nc->codigo ?? '') }}"
                        placeholder="NC-2026-0001"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('codigo') border-red-300 @enderror"
                        required>
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Título --}}
            <div class="w-full md:w-[calc(65%-0.5rem)]">
                <label for="titulo" class="block text-sm font-medium text-gray-700">
                    Título <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-heading text-gray-400"></i>
                    </div>
                    <input type="text" id="titulo" name="titulo" maxlength="255"
                        value="{{ old('titulo', $nc->titulo ?? '') }}"
                        placeholder="Resumo curto da não conformidade"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('titulo') border-red-300 @enderror"
                        required>
                </div>
                @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end">
            {{-- Tipo --}}
            <div class="w-full md:w-[calc(35%-0.5rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tags text-gray-400"></i>
                    </div>
                    <input type="text" id="tipo" name="tipo" maxlength="40"
                        value="{{ old('tipo', $nc->tipo ?? 'Não Conformidade') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('tipo') border-red-300 @enderror">
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Local da ocorrência --}}
            <div class="w-full md:w-[calc(65%-0.5rem)]">
                <label for="local_ocorrencia" class="block text-sm font-medium text-gray-700">Local da Ocorrência</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                    </div>
                    <input type="text" id="local_ocorrencia" name="local_ocorrencia" maxlength="255"
                        value="{{ old('local_ocorrencia', $nc->local_ocorrencia ?? '') }}"
                        placeholder="Setor, filial, unidade..."
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('local_ocorrencia') border-red-300 @enderror">
                </div>
                @error('local_ocorrencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- SEÇÃO 2: Classificação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2 border-b pb-2">
            <i class="fas fa-sitemap text-red-500"></i> Classificação
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Empresa (obrigatório, exibido somente leitura) --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Empresa <span class="text-red-500">*</span></label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? 'Empresa não definida' }}
                    </span>
                </div>
                <input type="hidden" name="empresa_id"
                    value="{{ $empresa->id ?? ($nc->empresa_id ?? '') }}">
            </div>

            {{-- Cliente --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-tie text-gray-400"></i>
                    </div>
                    <select id="cliente_id" name="cliente_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('cliente_id') border-red-300 @enderror">
                        <option value="">Selecione o cliente...</option>
                        @foreach(($clientes ?? []) as $cliente)
                            <option value="{{ $cliente->id }}" {{ old('cliente_id', $nc->cliente_id ?? '') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->razao_social ?? $cliente->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('cliente_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Norma --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="norma_id" class="block text-sm font-medium text-gray-700">Norma</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-file-alt text-gray-400"></i>
                    </div>
                    <select id="norma_id" name="norma_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('norma_id') border-red-300 @enderror">
                        <option value="">Selecione a norma...</option>
                        @foreach(($normas ?? []) as $norma)
                            <option value="{{ $norma->id }}" {{ old('norma_id', $nc->norma_id ?? '') == $norma->id ? 'selected' : '' }}>
                                {{ $norma->codigo }} - {{ $norma->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('norma_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Cláusula --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="clausula_id" class="block text-sm font-medium text-gray-700">Cláusula</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-list-ul text-gray-400"></i>
                    </div>
                    <select id="clausula_id" name="clausula_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('clausula_id') border-red-300 @enderror">
                        <option value="">Selecione a cláusula...</option>
                        @foreach(($clausulas ?? []) as $clausula)
                            <option value="{{ $clausula->id }}" {{ old('clausula_id', $nc->clausula_id ?? '') == $clausula->id ? 'selected' : '' }}>
                                {{ $clausula->codigo }} - {{ $clausula->descricao }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('clausula_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end">
            {{-- Processo --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="processo_id" class="block text-sm font-medium text-gray-700">Processo</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-cogs text-gray-400"></i>
                    </div>
                    <select id="processo_id" name="processo_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('processo_id') border-red-300 @enderror">
                        <option value="">Selecione o processo...</option>
                        @foreach(($processos ?? []) as $processo)
                            <option value="{{ $processo->id }}" {{ old('processo_id', $nc->processo_id ?? '') == $processo->id ? 'selected' : '' }}>
                                {{ $processo->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('processo_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Origem --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="origem" class="block text-sm font-medium text-gray-700">
                    Origem <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <select id="origem" name="origem"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('origem') border-red-300 @enderror"
                        required>
                        <option value="">Selecione a origem...</option>
                        @foreach(['Auditoria', 'Monitoramento', 'Reclamacao', 'Incidente', 'Outros'] as $origem)
                            <option value="{{ $origem }}" {{ old('origem', $nc->origem ?? '') == $origem ? 'selected' : '' }}>
                                {{ $origem }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('origem') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- SEÇÃO 3: Responsáveis --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2 border-b pb-2">
            <i class="fas fa-user-friends text-red-500"></i> Responsáveis
        </h3>

        <div class="flex flex-wrap gap-4 items-end">
            {{-- Responsável pela apuração --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_apuracao_id" class="block text-sm font-medium text-gray-700">Responsável pela Apuração</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-search text-gray-400"></i>
                    </div>
                    <select id="responsavel_apuracao_id" name="responsavel_apuracao_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('responsavel_apuracao_id') border-red-300 @enderror">
                        <option value="">Selecione o responsável...</option>
                        @foreach(($usuarios ?? []) as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_apuracao_id', $nc->responsavel_apuracao_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_apuracao_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Responsável pelo tratamento --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_tratamento_id" class="block text-sm font-medium text-gray-700">
                    Responsável pelo Tratamento <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-cog text-gray-400"></i>
                    </div>
                    <select id="responsavel_tratamento_id" name="responsavel_tratamento_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('responsavel_tratamento_id') border-red-300 @enderror"
                        required>
                        <option value="">Selecione o responsável...</option>
                        @foreach(($usuarios ?? []) as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_tratamento_id', $nc->responsavel_tratamento_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_tratamento_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- SEÇÃO 4: Descrição da ocorrência --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2 border-b pb-2">
            <i class="fas fa-clipboard-list text-red-500"></i> Descrição da Ocorrência
        </h3>

        {{-- Descrição --}}
        <div class="mb-4">
            <label for="descricao" class="block text-sm font-medium text-gray-700">
                Descrição <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-align-left text-gray-400"></i>
                </div>
                <textarea id="descricao" name="descricao" rows="3"
                    placeholder="Descreva a não conformidade encontrada..."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('descricao') border-red-300 @enderror"
                    required>{{ old('descricao', $nc->descricao ?? '') }}</textarea>
            </div>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Requisito não atendido --}}
        <div class="mb-4">
            <label for="requisito_nao_atendido" class="block text-sm font-medium text-gray-700">Requisito Não Atendido</label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-gavel text-gray-400"></i>
                </div>
                <textarea id="requisito_nao_atendido" name="requisito_nao_atendido" rows="2"
                    placeholder="Requisito legal, normativo ou contratual não atendido..."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('requisito_nao_atendido') border-red-300 @enderror">{{ old('requisito_nao_atendido', $nc->requisito_nao_atendido ?? '') }}</textarea>
            </div>
            @error('requisito_nao_atendido') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Evidência inicial --}}
        <div>
            <label for="evidencia_inicial" class="block text-sm font-medium text-gray-700">Evidência Inicial</label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-paperclip text-gray-400"></i>
                </div>
                <textarea id="evidencia_inicial" name="evidencia_inicial" rows="2"
                    placeholder="Links, anexos, documentos comprobatórios..."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('evidencia_inicial') border-red-300 @enderror">{{ old('evidencia_inicial', $nc->evidencia_inicial ?? '') }}</textarea>
            </div>
            @error('evidencia_inicial') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- SEÇÃO 5: Avaliação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2 border-b pb-2">
            <i class="fas fa-chart-line text-red-500"></i> Avaliação
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Gravidade --}}
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label for="gravidade" class="block text-sm font-medium text-gray-700">Gravidade</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-exclamation-circle text-gray-400"></i>
                    </div>
                    <select id="gravidade" name="gravidade"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('gravidade') border-red-300 @enderror">
                        <option value="">Selecione...</option>
                        @foreach(['Baixa', 'Media', 'Alta', 'Crítica'] as $gravidade)
                            <option value="{{ $gravidade }}" {{ old('gravidade', $nc->gravidade ?? '') == $gravidade ? 'selected' : '' }}>
                                {{ $gravidade }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('gravidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Probabilidade --}}
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label for="probabilidade" class="block text-sm font-medium text-gray-700">Probabilidade</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-percentage text-gray-400"></i>
                    </div>
                    <select id="probabilidade" name="probabilidade"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('probabilidade') border-red-300 @enderror">
                        <option value="">Selecione...</option>
                        @foreach(['Baixa', 'Media', 'Alta'] as $prob)
                            <option value="{{ $prob }}" {{ old('probabilidade', $nc->probabilidade ?? '') == $prob ? 'selected' : '' }}>
                                {{ $prob }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('probabilidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Prioridade --}}
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label for="prioridade" class="block text-sm font-medium text-gray-700">Prioridade</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flag text-gray-400"></i>
                    </div>
                    <select id="prioridade" name="prioridade"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('prioridade') border-red-300 @enderror">
                        <option value="">Selecione...</option>
                        @foreach(['Baixa', 'Media', 'Alta', 'Urgente'] as $prio)
                            <option value="{{ $prio }}" {{ old('prioridade', $nc->prioridade ?? '') == $prio ? 'selected' : '' }}>
                                {{ $prio }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('prioridade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Recorrente --}}
            <div class="w-full md:w-[calc(25%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">Recorrente?</label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md h-[42px]">
                    <input type="hidden" name="recorrente" value="0">
                    <input type="checkbox" id="recorrente" name="recorrente" value="1"
                        {{ old('recorrente', $nc->recorrente ?? false) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                    <label for="recorrente" class="text-sm text-gray-700">Sim, é recorrente</label>
                </div>
                @error('recorrente') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Status --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-toggle-on text-gray-400"></i>
                    </div>
                    <select id="status" name="status"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('status') border-red-300 @enderror"
                        required>
                        @foreach(['Aberta', 'Em analise', 'Em ação', 'Verificação', 'Fechada'] as $status)
                            <option value="{{ $status }}" {{ old('status', $nc->status ?? 'Aberta') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- SEÇÃO 6: Datas --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2 border-b pb-2">
            <i class="fas fa-calendar-alt text-red-500"></i> Datas
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Data identificação --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="data_identificacao" class="block text-sm font-medium text-gray-700">Data de Identificação</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="date" id="data_identificacao" name="data_identificacao"
                        value="{{ old('data_identificacao', isset($nc->data_identificacao) ? $nc->data_identificacao->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('data_identificacao') border-red-300 @enderror">
                </div>
                @error('data_identificacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Data abertura --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="data_abertura" class="block text-sm font-medium text-gray-700">
                    Data de Abertura <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-plus text-gray-400"></i>
                    </div>
                    <input type="date" id="data_abertura" name="data_abertura"
                        value="{{ old('data_abertura', isset($nc->data_abertura) ? $nc->data_abertura->format('Y-m-d') : date('Y-m-d')) }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('data_abertura') border-red-300 @enderror"
                        required>
                </div>
                @error('data_abertura') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Prazo tratamento --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="prazo_tratamento" class="block text-sm font-medium text-gray-700">Prazo para Tratamento</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hourglass-half text-gray-400"></i>
                    </div>
                    <input type="date" id="prazo_tratamento" name="prazo_tratamento"
                        value="{{ old('prazo_tratamento', isset($nc->prazo_tratamento) ? $nc->prazo_tratamento->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('prazo_tratamento') border-red-300 @enderror">
                </div>
                @error('prazo_tratamento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end">
            {{-- Data análise --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="data_analise" class="block text-sm font-medium text-gray-700">Data da Análise</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-clipboard-check text-gray-400"></i>
                    </div>
                    <input type="date" id="data_analise" name="data_analise"
                        value="{{ old('data_analise', isset($nc->data_analise) ? $nc->data_analise->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('data_analise') border-red-300 @enderror">
                </div>
                @error('data_analise') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Data verificação --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="data_verificacao" class="block text-sm font-medium text-gray-700">Data da Verificação</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-check-double text-gray-400"></i>
                    </div>
                    <input type="date" id="data_verificacao" name="data_verificacao"
                        value="{{ old('data_verificacao', isset($nc->data_verificacao) ? $nc->data_verificacao->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('data_verificacao') border-red-300 @enderror">
                </div>
                @error('data_verificacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Data encerramento --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="data_encerramento" class="block text-sm font-medium text-gray-700">Data de Encerramento</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>
                    <input type="date" id="data_encerramento" name="data_encerramento"
                        value="{{ old('data_encerramento', isset($nc->data_encerramento) ? $nc->data_encerramento->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('data_encerramento') border-red-300 @enderror">
                </div>
                @error('data_encerramento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- SEÇÃO 7: Encerramento --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2 border-b pb-2">
            <i class="fas fa-flag-checkered text-red-500"></i> Encerramento
        </h3>

        <div>
            <label for="justificativa_encerramento" class="block text-sm font-medium text-gray-700">Justificativa de Encerramento</label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-comment-dots text-gray-400"></i>
                </div>
                <textarea id="justificativa_encerramento" name="justificativa_encerramento" rows="3"
                    placeholder="Justificativa para o encerramento da não conformidade..."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('justificativa_encerramento') border-red-300 @enderror">{{ old('justificativa_encerramento', $nc->justificativa_encerramento ?? '') }}</textarea>
            </div>
            @error('justificativa_encerramento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>