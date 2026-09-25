@php
    $aspecto = $aspecto ?? null;
@endphp
<div class="space-y-8">
    {{-- Informações Principais --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-leaf text-green-600 mr-1"></i>Dados do Aspecto Ambiental
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição <span class="text-red-500">*</span></label>
                <div class="mt-1">
                    <textarea id="descricao" name="descricao" rows="3"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('descricao') border-red-300 @enderror"
                              placeholder="Descreva o aspecto ambiental...">{{ old('descricao', $aspecto->descricao ?? '') }}</textarea>
                </div>
                @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo <span class="text-red-500">*</span></label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <select id="tipo" name="tipo"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('tipo') border-red-300 @enderror">
                        <option value="">Selecione o tipo</option>
                        @foreach(['Emissao ar', 'Efluente', 'Resíduo', 'Ruído', 'Uso recurso', 'Outros'] as $tipoOption)
                            <option value="{{ $tipoOption }}" {{ old('tipo', $aspecto->tipo ?? '') == $tipoOption ? 'selected' : '' }}>
                                {{ $tipoOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="processo_id" class="block text-sm font-medium text-gray-700">Processo</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-sitemap text-gray-400"></i>
                    </div>
                    <select id="processo_id" name="processo_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('processo_id') border-red-300 @enderror">
                        <option value="">Selecione um processo</option>
                        @foreach($processos as $processo)
                            <option value="{{ $processo->id }}" {{ old('processo_id', $aspecto->processo_id ?? '') == $processo->id ? 'selected' : '' }}>
                                {{ $processo->codigo }} - {{ $processo->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('processo_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="significancia" class="block text-sm font-medium text-gray-700">Significância (1 a 5)</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-weight-hanging text-gray-400"></i>
                    </div>
                    <input type="number" id="significancia" name="significancia"
                           value="{{ old('significancia', $aspecto->significancia ?? '') }}"
                           min="1" max="5"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('significancia') border-red-300 @enderror">
                </div>
                @error('significancia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-toggle-on text-gray-400"></i>
                    </div>
                    <select id="status" name="status"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('status') border-red-300 @enderror">
                        <option value="ativo" {{ old('status', $aspecto->status ?? 'ativo') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="inativo" {{ old('status', $aspecto->status ?? 'ativo') == 'inativo' ? 'selected' : '' }}>Inativo</option>
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_nome" class="block text-sm font-medium text-gray-700">Responsável</label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-user text-gray-400"></i>
                    <span class="text-gray-700">
                        {{ optional($aspecto?->responsavel)->name ?? auth()->user()->name }}
                    </span>
                </div>
                <input type="hidden" name="responsavel_id" value="{{ $aspecto?->responsavel_id ?? auth()->id() }}">
            </div>
        </div>
    </div>

    {{-- Impacto e Controles --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-exclamation-triangle text-amber-600"></i>Impacto e Controle
        </h3>

        <div class="flex flex-wrap gap-4 items-start mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="impacto_associado" class="block text-sm font-medium text-gray-700">Impacto Associado</label>
                <textarea id="impacto_associado" name="impacto_associado" rows="3"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('impacto_associado') border-red-300 @enderror"
                          placeholder="Descreva o impacto ambiental...">{{ old('impacto_associado', $aspecto->impacto_associado ?? '') }}</textarea>
                @error('impacto_associado') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="controle_existente" class="block text-sm font-medium text-gray-700">Controle Existente</label>
                <textarea id="controle_existente" name="controle_existente" rows="3"
                          class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('controle_existente') border-red-300 @enderror"
                          placeholder="Medidas de controle atuais...">{{ old('controle_existente', $aspecto->controle_existente ?? '') }}</textarea>
                @error('controle_existente') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="w-full">
            <label for="programa_gestao" class="block text-sm font-medium text-gray-700">Programa de Gestão</label>
            <textarea id="programa_gestao" name="programa_gestao" rows="2"
                      class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('programa_gestao') border-red-300 @enderror"
                      placeholder="Programas ou planos de gestão associados...">{{ old('programa_gestao', $aspecto->programa_gestao ?? '') }}</textarea>
            @error('programa_gestao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Empresa (fixa) --}}
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700">Empresa</label>
            <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                <i class="fas fa-building text-gray-400"></i>
                <span class="text-gray-700">{{ $empresa->razao_social ?? 'Empresa não definida' }}</span>
            </div>
            <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? $aspecto?->empresa_id ?? '' }}">
        </div>
    </div>
</div>