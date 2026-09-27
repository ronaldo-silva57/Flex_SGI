@php
    $acao = $acaoCorretiva ?? null;
    $ncPreSelecionada = $ncPreSelecionada ?? null;
@endphp

<div class="space-y-6">

    {{-- Vínculo com a Não Conformidade --}}
    @if($ncPreSelecionada)
        <div class="rounded-md border border-orange-200 bg-orange-50 p-3 flex items-center gap-2">
            <i class="fas fa-link text-orange-500"></i>
            <span>
                Vinculada à NC:
                <strong>{{ $ncPreSelecionada->codigo }}</strong>
                — {{ $ncPreSelecionada->titulo }}
            </span>
        </div>

        <input type="hidden" name="nao_conformidade_id" value="{{ $ncPreSelecionada->id }}">
    @else
        <div>
            <label for="nao_conformidade_id" class="block text-sm font-medium text-gray-700">
                Não Conformidade <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-exclamation-triangle text-gray-400"></i>
                </div>
                <select id="nao_conformidade_id" name="nao_conformidade_id" required
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('nao_conformidade_id') border-red-300 @enderror">
                    <option value="">Selecione a não conformidade...</option>
                    @foreach($naoConformidades ?? [] as $nc)
                        <option value="{{ $nc->id }}"
                            @selected(old('nao_conformidade_id', $acao->nao_conformidade_id ?? null) == $nc->id)>
                            {{ $nc->codigo }} — {{ $nc->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('nao_conformidade_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    @endif

    {{-- Etapa + Responsável --}}
    <div class="flex flex-wrap gap-4 items-end">
        <div class="w-full md:w-[calc(50%-0.5rem)]">
            <label for="etapa" class="block text-sm font-medium text-gray-700">
                Etapa <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-layer-group text-gray-400"></i>
                </div>
                <select id="etapa" name="etapa" required
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('etapa') border-red-300 @enderror">
                    <option value="">Selecione a etapa...</option>
                    @foreach(['Contenção', 'Causa raiz', 'Correção', 'Verificação', 'Conclusão'] as $etapa)
                        <option value="{{ $etapa }}" @selected(old('etapa', $acao->etapa ?? '') == $etapa)>
                            {{ $etapa }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('etapa') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="w-full md:w-[calc(50%-0.5rem)]">
            <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                <select id="responsavel_id" name="responsavel_id"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('responsavel_id') border-red-300 @enderror">
                    <option value="">Selecione o responsável...</option>
                    @foreach($usuarios ?? [] as $usuario)
                        <option value="{{ $usuario->id }}"
                            @selected(old('responsavel_id', $acao->responsavel_id ?? '') == $usuario->id)>
                            {{ $usuario->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Descrição --}}
    <div>
        <label for="descricao" class="block text-sm font-medium text-gray-700">
            Descrição da Ação <span class="text-red-500">*</span>
        </label>
        <div class="relative mt-1">
            <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                <i class="fas fa-align-left text-gray-400"></i>
            </div>
            <textarea id="descricao" name="descricao" rows="4" required
                placeholder="Descreva a ação corretiva a ser executada..."
                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('descricao') border-red-300 @enderror">{{ old('descricao', $acao->descricao ?? '') }}</textarea>
        </div>
        @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Prazo + Data de execução --}}
    <div class="flex flex-wrap gap-4 items-end">
        <div class="w-full md:w-[calc(50%-0.5rem)]">
            <label for="prazo" class="block text-sm font-medium text-gray-700">Prazo</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-hourglass-half text-gray-400"></i>
                </div>
                <input type="date" id="prazo" name="prazo"
                    value="{{ old('prazo', isset($acao->prazo) ? $acao->prazo->format('Y-m-d') : '') }}"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('prazo') border-red-300 @enderror">
            </div>
            @error('prazo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="w-full md:w-[calc(50%-0.5rem)]">
            <label for="data_execucao" class="block text-sm font-medium text-gray-700">Data de Execução</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-calendar-check text-gray-400"></i>
                </div>
                <input type="date" id="data_execucao" name="data_execucao"
                    value="{{ old('data_execucao', isset($acao->data_execucao) ? $acao->data_execucao->format('Y-m-d') : '') }}"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('data_execucao') border-red-300 @enderror">
            </div>
            @error('data_execucao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Status + Eficaz --}}
    <div class="flex flex-wrap gap-4 items-end">
        <div class="w-full md:w-[calc(50%-0.5rem)]">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-toggle-on text-gray-400"></i>
                </div>
                <select id="status" name="status"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('status') border-red-300 @enderror">
                    <option value="">Selecione...</option>
                    @foreach(['Pendente', 'Em andamento', 'Concluída', 'Reprovada'] as $st)
                        <option value="{{ $st }}" @selected(old('status', $acao->status ?? 'Pendente') == $st)>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="w-full md:w-[calc(50%-0.5rem)]">
            <label class="block text-sm font-medium text-gray-700">Eficaz?</label>
            <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md h-[42px]">
                <input type="hidden" name="eficaz" value="0">
                <input type="checkbox" id="eficaz" name="eficaz" value="1"
                    {{ old('eficaz', $acao->eficaz ?? false) ? 'checked' : '' }}
                    class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                <label for="eficaz" class="text-sm text-gray-700">Sim, ação eficaz</label>
            </div>
            @error('eficaz') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Evidência --}}
    <div>
        <label for="evidencia" class="block text-sm font-medium text-gray-700">Evidência</label>
        <div class="relative mt-1">
            <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                <i class="fas fa-paperclip text-gray-400"></i>
            </div>
            <textarea id="evidencia" name="evidencia" rows="2"
                placeholder="Links, anexos, documentos comprobatórios..."
                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500 @error('evidencia') border-red-300 @enderror">{{ old('evidencia', $acao->evidencia ?? '') }}</textarea>
        </div>
        @error('evidencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>