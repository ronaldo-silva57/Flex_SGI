<div class="space-y-8">
    {{-- Seção 1: Dados Gerais --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-user-plus text-blue-600 mr-1"></i>Dados do Stakeholder
        </h3>

        {{-- Empresa (fixa) + Nome --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
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

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="nome" class="block text-sm font-medium text-gray-700">
                    Nome <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input type="text" id="nome" name="nome"
                           value="{{ old('nome', $stakeholder->nome ?? '') }}"
                           placeholder="Nome do stakeholder"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nome') border-red-300 @enderror">
                </div>
                @error('nome') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Tipo + Contato --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">
                    Tipo <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <select id="tipo" name="tipo"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tipo') border-red-300 @enderror">
                        <option value="">Selecione um tipo</option>
                        @foreach($tipos as $t)
                            <option value="{{ $t }}" {{ old('tipo', $stakeholder->tipo ?? '') == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="contato" class="block text-sm font-medium text-gray-700">
                    Contato
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-phone text-gray-400"></i>
                    </div>
                    <input type="text" id="contato" name="contato"
                           value="{{ old('contato', $stakeholder->contato ?? '') }}"
                           placeholder="Email, telefone, etc."
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('contato') border-red-300 @enderror">
                </div>
                @error('contato') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 2: Expectativas, Necessidades e Prioridade --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-list-ul text-blue-600"></i>Expectativas e Prioridade
        </h3>

        <div class="flex flex-wrap gap-4 items-start mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="expectativas" class="block text-sm font-medium text-gray-700">
                    Expectativas
                </label>
                <div class="relative mt-1">
                    <textarea id="expectativas" name="expectativas" rows="3"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('expectativas') border-red-300 @enderror"
                              placeholder="O que o stakeholder espera da organização?">{{ old('expectativas', $stakeholder->expectativas ?? '') }}</textarea>
                </div>
                @error('expectativas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="necessidades" class="block text-sm font-medium text-gray-700">
                    Necessidades
                </label>
                <div class="relative mt-1">
                    <textarea id="necessidades" name="necessidades" rows="3"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('necessidades') border-red-300 @enderror"
                              placeholder="Quais as necessidades do stakeholder?">{{ old('necessidades', $stakeholder->necessidades ?? '') }}</textarea>
                </div>
                @error('necessidades') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Prioridade --}}
        <div class="w-full md:w-1/3">
            <label for="prioridade" class="block text-sm font-medium text-gray-700">
                Prioridade (1 a 5)
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-star text-gray-400"></i>
                </div>
                <select id="prioridade" name="prioridade"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('prioridade') border-red-300 @enderror">
                    <option value="">Selecione</option>
                    @for ($i = 1; $i <= 5; $i++)
                        @php $labels = ['Muito Baixa', 'Baixa', 'Média', 'Alta', 'Muito Alta']; @endphp
                        <option value="{{ $i }}" {{ old('prioridade', $stakeholder->prioridade ?? '') == $i ? 'selected' : '' }}>
                            {{ $i }} - {{ $labels[$i-1] }}
                        </option>
                    @endfor
                </select>
            </div>
            @error('prioridade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Seção 3: Status --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-toggle-on text-blue-600"></i>Status
        </h3>

        <div class="flex items-center gap-4">
            <label for="ativo" class="inline-flex items-center">
                <input type="checkbox" id="ativo" name="ativo" value="1"
                       {{ old('ativo', $stakeholder->ativo ?? true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Ativo</span>
            </label>
        </div>
        @error('ativo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>