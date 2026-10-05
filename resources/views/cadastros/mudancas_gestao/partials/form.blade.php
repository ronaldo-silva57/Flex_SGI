@php
    $mudanca = $mudancaGestao ?? null;
    $tipos = ['Processo','Equipamento','Layout','Documento','Pessoas/Estrutura','Sistema/IT','Outros'];
    $statusOpts = ['Proposta','Em analise','Aprovada','Rejeitada','Em implementação','Concluída','Cancelada'];
@endphp

<div class="space-y-8">

    {{-- Empresa (readonly) --}}
    <input type="hidden" name="empresa_id" value="{{ old('empresa_id', $mudanca->empresa_id ?? $empresaAtual->id ?? '') }}">
    <div>
        <label class="block text-sm font-medium text-gray-700">Empresa</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-building text-gray-400"></i>
            </div>
            <input type="text"
                   value="{{ $empresaAtual->razao_social ?? 'Empresa não cadastrada' }}"
                   class="pl-10 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-600 shadow-sm cursor-not-allowed"
                   readonly>
        </div>
    </div>

    {{-- Identificação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-exchange-alt text-blue-500"></i> Identificação da Mudança
        </h3>

        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(30%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Código <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-barcode text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo" maxlength="50"
                           value="{{ old('codigo', $mudanca->codigo ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('codigo') border-red-300 @enderror"
                           required>
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(70%-0.5rem)]">
                <label for="titulo" class="block text-sm font-medium text-gray-700">
                    Título <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-heading text-gray-400"></i>
                    </div>
                    <input type="text" id="titulo" name="titulo"
                           value="{{ old('titulo', $mudanca->titulo ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('titulo') border-red-300 @enderror"
                           required>
                </div>
                @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mt-4">
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">
                    Tipo <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tags text-gray-400"></i>
                    </div>
                    <select name="tipo" id="tipo"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tipo') border-red-300 @enderror"
                        required>
                        <option value="">Selecione</option>
                        @foreach($tipos as $t)
                            <option value="{{ $t }}" {{ old('tipo', $mudanca->tipo ?? '') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="processo_id" class="block text-sm font-medium text-gray-700">Processo Relacionado</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-project-diagram text-gray-400"></i>
                    </div>
                    <select name="processo_id" id="processo_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('processo_id') border-red-300 @enderror">
                        <option value="">Nenhum</option>
                        @foreach($processos as $proc)
                            <option value="{{ $proc->id }}"
                                {{ (int) old('processo_id', $mudanca->processo_id ?? '') === $proc->id ? 'selected' : '' }}>
                                {{ $proc->nome ?? $proc->codigo ?? ('#'.$proc->id) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('processo_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(33.333%-0.5rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-clipboard-check text-gray-400"></i>
                    </div>
                    @php $statusAtual = old('status', $mudanca->status ?? 'Proposta'); @endphp
                    <select name="status" id="status"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror"
                        required>
                        @foreach($statusOpts as $s)
                            <option value="{{ $s }}" {{ $statusAtual === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Descrição / Justificativa --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-file-alt text-blue-500"></i> Descrição e Justificativa
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="descricao_mudanca" class="block text-sm font-medium text-gray-700">
                    Descrição da Mudança <span class="text-red-500">*</span>
                </label>
                <textarea id="descricao_mudanca" name="descricao_mudanca" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descricao_mudanca') border-red-300 @enderror"
                    required>{{ old('descricao_mudanca', $mudanca->descricao_mudanca ?? '') }}</textarea>
                @error('descricao_mudanca') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="justificativa" class="block text-sm font-medium text-gray-700">
                    Justificativa <span class="text-red-500">*</span>
                </label>
                <textarea id="justificativa" name="justificativa" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('justificativa') border-red-300 @enderror"
                    required>{{ old('justificativa', $mudanca->justificativa ?? '') }}</textarea>
                @error('justificativa') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Avaliação de Impacto SGI --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-shield-alt text-blue-500"></i> Avaliação de Impacto do SGI
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach([
                'impacto_qualidade'           => ['Qualidade',              'fa-award'],
                'impacto_ambiental'           => ['Meio Ambiente',          'fa-leaf'],
                'impacto_sso'                 => ['SSO (Saúde e Segurança)','fa-hard-hat'],
                'impacto_seguranca_informacao'=> ['Segurança da Informação','fa-lock'],
            ] as $campo => [$label, $icone])
                <div>
                    <label for="{{ $campo }}" class="block text-sm font-medium text-gray-700 flex items-center gap-2">
                        <i class="fas {{ $icone }} text-gray-400"></i>{{ $label }}
                    </label>
                    <textarea id="{{ $campo }}" name="{{ $campo }}" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error($campo) border-red-300 @enderror">{{ old($campo, $mudanca->{$campo} ?? '') }}</textarea>
                    @error($campo) <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            @endforeach
        </div>
    </div>

    {{-- Datas --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-calendar-alt text-blue-500"></i> Prazos
        </h3>

        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_prevista" class="block text-sm font-medium text-gray-700">
                    Data Prevista <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-day text-gray-400"></i>
                    </div>
                    <input type="date" id="data_prevista" name="data_prevista"
                        value="{{ old('data_prevista', isset($mudanca->data_prevista) ? \Illuminate\Support\Carbon::parse($mudanca->data_prevista)->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_prevista') border-red-300 @enderror"
                        required>
                </div>
                @error('data_prevista') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_implementacao" class="block text-sm font-medium text-gray-700">Data de Implementação</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>
                    <input type="date" id="data_implementacao" name="data_implementacao"
                        value="{{ old('data_implementacao', isset($mudanca->data_implementacao) ? \Illuminate\Support\Carbon::parse($mudanca->data_implementacao)->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_implementacao') border-red-300 @enderror">
                </div>
                @error('data_implementacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Aprovação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-user-shield text-blue-500"></i> Fluxo de Aprovação
        </h3>

        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="solicitante_id" class="block text-sm font-medium text-gray-700">Solicitante</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select name="solicitante_id" id="solicitante_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('solicitante_id') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @foreach($solicitantes as $u)
                            <option value="{{ $u->id }}"
                                {{ (int) old('solicitante_id', $mudanca->solicitante_id ?? '') === $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('solicitante_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_aprovacao_id" class="block text-sm font-medium text-gray-700">Responsável pela Aprovação</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-check text-gray-400"></i>
                    </div>
                    <select name="responsavel_aprovacao_id" id="responsavel_aprovacao_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('responsavel_aprovacao_id') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @foreach($aprovadores as $u)
                            <option value="{{ $u->id }}"
                                {{ (int) old('responsavel_aprovacao_id', $mudanca->responsavel_aprovacao_id ?? '') === $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_aprovacao_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-4">
            <label for="parecer_aprovacao" class="block text-sm font-medium text-gray-700">Parecer da Aprovação</label>
            <textarea id="parecer_aprovacao" name="parecer_aprovacao" rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('parecer_aprovacao') border-red-300 @enderror">{{ old('parecer_aprovacao', $mudanca->parecer_aprovacao ?? '') }}</textarea>
            @error('parecer_aprovacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>