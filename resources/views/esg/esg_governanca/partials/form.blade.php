<div class="space-y-8">
    {{-- Seção 1: Dados Gerais --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-building text-indigo-600 mr-1"></i>Dados Gerais
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">

            {{-- Empresa (fixa) --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>
                    <span class="text-gray-700">{{ $empresa->razao_social ?? 'Empresa não definida' }}</span>
                </div>
                <input type="hidden" name="empresa_id" value="{{ $empresa->id }}">
            </div>

            {{-- Responsável --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">
                    Responsável
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione um responsável</option>
                        @foreach($responsaveis as $user)
                            <option value="{{ $user->id }}"
                                {{ old('responsavel_id', $esgGovernancaMembro->responsavel_id ?? auth()->id()) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 2: Informações do Membro --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-user-tie text-indigo-600"></i>Informações do Membro
        </h3>

        {{-- Nome --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full">
                <label for="nome" class="block text-sm font-medium text-gray-700">
                    Nome <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-id-card text-gray-400"></i>
                    </div>
                    <input type="text" id="nome" name="nome"
                           value="{{ old('nome', $esgGovernancaMembro->nome ?? '') }}"
                           placeholder="Nome completo do membro"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('nome') border-red-300 @enderror">
                </div>
                @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Órgão --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="orgao" class="block text-sm font-medium text-gray-700">
                    Órgão <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-sitemap text-gray-400"></i>
                    </div>
                    <select id="orgao" name="orgao"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('orgao') border-red-300 @enderror">
                        <option value="">Selecione o órgão</option>
                        @foreach(['Conselho de Administração', 'Diretoria Executiva', 'Comitê de Auditoria', 'Comitê ESG', 'Outro'] as $orgao)
                            <option value="{{ $orgao }}" {{ old('orgao', $esgGovernancaMembro->orgao ?? '') == $orgao ? 'selected' : '' }}>
                                {{ $orgao }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('orgao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Cargo --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="cargo" class="block text-sm font-medium text-gray-700">
                    Cargo <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-briefcase text-gray-400"></i>
                    </div>
                    <input type="text" id="cargo" name="cargo" maxlength="100"
                           value="{{ old('cargo', $esgGovernancaMembro->cargo ?? '') }}"
                           placeholder="Ex: Conselheiro Independente, Presidente"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('cargo') border-red-300 @enderror">
                </div>
                @error('cargo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Independente --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Membro Independente</label>
                <input type="hidden" name="independente" value="0">
                <label class="inline-flex items-center mt-2 cursor-pointer">
                    <input type="checkbox" id="independente" name="independente" value="1"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                           {{ old('independente', $esgGovernancaMembro->independente ?? false) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Sim, é membro independente</span>
                </label>
                @error('independente') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Ativo --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Situação</label>
                <input type="hidden" name="ativo" value="0">
                <label class="inline-flex items-center mt-2 cursor-pointer">
                    <input type="checkbox" id="ativo" name="ativo" value="1"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                           {{ old('ativo', $esgGovernancaMembro->ativo ?? true) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Ativo</span>
                </label>
                @error('ativo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 3: Mandato --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-calendar-check text-indigo-600"></i>Mandato
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Início do Mandato --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="inicio_mandato" class="block text-sm font-medium text-gray-700">
                    Início do Mandato
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" id="inicio_mandato" name="inicio_mandato"
                           value="{{ old('inicio_mandato', isset($esgGovernancaMembro->inicio_mandato) ? $esgGovernancaMembro->inicio_mandato->format('Y-m-d') : '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('inicio_mandato') border-red-300 @enderror">
                </div>
                @error('inicio_mandato') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Fim do Mandato --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="fim_mandato" class="block text-sm font-medium text-gray-700">
                    Fim do Mandato
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-times text-gray-400"></i>
                    </div>
                    <input type="date" id="fim_mandato" name="fim_mandato"
                           value="{{ old('fim_mandato', isset($esgGovernancaMembro->fim_mandato) ? $esgGovernancaMembro->fim_mandato->format('Y-m-d') : '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('fim_mandato') border-red-300 @enderror">
                </div>
                @error('fim_mandato') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>