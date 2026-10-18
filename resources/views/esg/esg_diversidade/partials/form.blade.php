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
                                {{ old('responsavel_id', $esgDiversidade->responsavel_id ?? auth()->id()) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Ano de Referência --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="ano_referencia" class="block text-sm font-medium text-gray-700">
                    Ano de Referência <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="number" id="ano_referencia" name="ano_referencia"
                           value="{{ old('ano_referencia', $esgDiversidade->ano_referencia ?? date('Y')) }}"
                           min="2000" max="2100"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('ano_referencia') border-red-300 @enderror">
                </div>
                @error('ano_referencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Quantidade de Colaboradores --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="quantidade_colaboradores" class="block text-sm font-medium text-gray-700">
                    Quantidade de Colaboradores <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-users text-gray-400"></i>
                    </div>
                    <input type="number" id="quantidade_colaboradores" name="quantidade_colaboradores"
                           value="{{ old('quantidade_colaboradores', $esgDiversidade->quantidade_colaboradores ?? 0) }}"
                           min="0"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('quantidade_colaboradores') border-red-300 @enderror">
                </div>
                @error('quantidade_colaboradores') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 2: Diversidade --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-people-group text-indigo-600"></i>Categorias de Diversidade
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Categoria / Cargo --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="categoria_cargo" class="block text-sm font-medium text-gray-700">
                    Categoria / Cargo <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-briefcase text-gray-400"></i>
                    </div>
                    <input type="text" id="categoria_cargo" name="categoria_cargo"
                           value="{{ old('categoria_cargo', $esgDiversidade->categoria_cargo ?? '') }}"
                           placeholder="Ex: Diretoria, Gerência, Operacional"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('categoria_cargo') border-red-300 @enderror">
                </div>
                @error('categoria_cargo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Gênero --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="genero" class="block text-sm font-medium text-gray-700">Gênero</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-venus-mars text-gray-400"></i>
                    </div>
                    <select id="genero" name="genero"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('genero') border-red-300 @enderror">
                        <option value="">Não informado</option>
                        @foreach(['Feminino', 'Masculino', 'Outro', 'Não informado'] as $g)
                            <option value="{{ $g }}" {{ old('genero', $esgDiversidade->genero ?? '') == $g ? 'selected' : '' }}>{{ $g }}</option>
                        @endforeach
                    </select>
                </div>
                @error('genero') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Raça / Etnia --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="raca_etnia" class="block text-sm font-medium text-gray-700">Raça / Etnia</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-users-rectangle text-gray-400"></i>
                    </div>
                    <select id="raca_etnia" name="raca_etnia"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('raca_etnia') border-red-300 @enderror">
                        <option value="">Não informado</option>
                        @foreach(['Branco', 'Negro', 'Pardo', 'Indígena', 'Amarelo', 'Outro', 'Não informado'] as $r)
                            <option value="{{ $r }}" {{ old('raca_etnia', $esgDiversidade->raca_etnia ?? '') == $r ? 'selected' : '' }}>{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                @error('raca_etnia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Cargo de Liderança --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cargo de Liderança</label>
                <input type="hidden" name="cargo_lideranca" value="0">
                <label class="inline-flex items-center mt-2 cursor-pointer">
                    <input type="checkbox" id="cargo_lideranca" name="cargo_lideranca" value="1"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                           {{ old('cargo_lideranca', $esgDiversidade->cargo_lideranca ?? false) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-700">Sim, é cargo de liderança</span>
                </label>
                @error('cargo_lideranca') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>