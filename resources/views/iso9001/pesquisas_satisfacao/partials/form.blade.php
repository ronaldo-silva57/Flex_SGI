@csrf
<div class="space-y-8">
    {{-- Título da seção --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-clipboard-list text-blue-500"></i>Informações da Pesquisa
        </h3>

        {{-- Linha 1: Código + Título --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Código <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-barcode text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo"
                           value="{{ old('codigo', $pesquisa->codigo ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('codigo') border-red-300 @enderror"
                           required>
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="titulo" class="block text-sm font-medium text-gray-700">
                    Título <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-heading text-gray-400"></i>
                    </div>
                    <input type="text" id="titulo" name="titulo"
                           value="{{ old('titulo', $pesquisa->titulo ?? '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('titulo') border-red-300 @enderror"
                           required>
                </div>
                @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Tipo + Canal --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="tipo" class="block text-sm font-medium text-gray-700">
                    Tipo <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tags text-gray-400"></i>
                    </div>
                    <select id="tipo" name="tipo" required
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tipo') border-red-300 @enderror">
                        @foreach(['NPS','CSAT','Personalizada'] as $t)
                            <option value="{{ $t }}" @selected(old('tipo', $pesquisa->tipo ?? 'CSAT') === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="canal" class="block text-sm font-medium text-gray-700">Canal</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-bullhorn text-gray-400"></i>
                    </div>
                    <select id="canal" name="canal"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('canal') border-red-300 @enderror">
                        <option value="">—</option>
                        @foreach(['Email','Telefone','Presencial','Online'] as $c)
                            <option value="{{ $c }}" @selected(old('canal', $pesquisa->canal ?? '') === $c)>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                @error('canal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Cliente + Responsável --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-tie text-gray-400"></i>
                    </div>
                    <select id="cliente_id" name="cliente_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('cliente_id') border-red-300 @enderror">
                        <option value="">—</option>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}" @selected(old('cliente_id', $pesquisa->cliente_id ?? '') == $c->id)>{{ $c->nome }}</option>
                        @endforeach
                    </select>
                </div>
                @error('cliente_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-cog text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">—</option>
                        @foreach($responsaveis as $r)
                            <option value="{{ $r->id }}" @selected(old('responsavel_id', $pesquisa->responsavel_id ?? '') == $r->id)>{{ $r->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 4: Data início + Data fim --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_inicio" class="block text-sm font-medium text-gray-700">
                    Data de início <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-day text-gray-400"></i>
                    </div>
                    <input type="date" id="data_inicio" name="data_inicio" required
                           value="{{ old('data_inicio', isset($pesquisa) ? $pesquisa->data_inicio?->format('Y-m-d') : '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_inicio') border-red-300 @enderror">
                </div>
                @error('data_inicio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_fim" class="block text-sm font-medium text-gray-700">Data de encerramento</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>
                    <input type="date" id="data_fim" name="data_fim"
                           value="{{ old('data_fim', isset($pesquisa) ? $pesquisa->data_fim?->format('Y-m-d') : '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_fim') border-red-300 @enderror">
                </div>
                @error('data_fim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 5: Status --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-toggle-on text-gray-400"></i>
                    </div>
                    <select id="status" name="status" required
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror">
                        @foreach(['Planejada','Em andamento','Concluída','Cancelada'] as $s)
                            <option value="{{ $s }}" @selected(old('status', $pesquisa->status ?? 'Planejada') === $s)>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 6: Descrição --}}
        <div class="flex flex-wrap gap-4">
            <div class="w-full">
                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-start pointer-events-none">
                        <i class="fas fa-align-left text-gray-400 mt-2"></i>
                    </div>
                    <textarea id="descricao" name="descricao" rows="3"
                              class="pl-10 block w-full resize rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('descricao') border-red-300 @enderror">{{ old('descricao', $pesquisa->descricao ?? '') }}</textarea>
                </div>
                @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>