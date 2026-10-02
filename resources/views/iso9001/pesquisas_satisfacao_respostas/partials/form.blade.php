@csrf
<div class="space-y-6">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-reply text-indigo-500"></i>Dados da Resposta
        </h3>

        {{-- Linha 1: Pesquisa + Cliente --}}
        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="pesquisa_id" class="block text-sm font-medium text-gray-700">
                    Pesquisa <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-clipboard-list text-gray-400"></i>
                    </div>
                    <select id="pesquisa_id" name="pesquisa_id" required
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('pesquisa_id') border-red-300 @enderror">
                        <option value="">Selecione a pesquisa...</option>
                        @foreach($pesquisas as $p)
                            <option value="{{ $p->id }}" @selected(old('pesquisa_id', $resposta->pesquisa_id ?? $selectedPesquisaId ?? '') == $p->id)>
                                [{{ $p->codigo }}] {{ $p->titulo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('pesquisa_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="cliente_id" class="block text-sm font-medium text-gray-700">Cliente</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-tie text-gray-400"></i>
                    </div>
                    <select id="cliente_id" name="cliente_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('cliente_id') border-red-300 @enderror">
                        <option value="">— Não especificado —</option>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}" @selected(old('cliente_id', $resposta->cliente_id ?? '') == $c->id)>{{ $c->nome }}</option>
                        @endforeach
                    </select>
                </div>
                @error('cliente_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Respondente + Nota + Data --}}
        <div class="flex flex-wrap gap-4 items-end mt-4">
            <div class="w-full md:w-[calc(33.33%-0.66rem)]">
                <label for="respondente_id" class="block text-sm font-medium text-gray-700">Respondente (Usuário)</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="respondente_id" name="respondente_id"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('respondente_id') border-red-300 @enderror">
                        <option value="">— Anônimo / Externo —</option>
                        @foreach($respondentes as $u)
                            <option value="{{ $u->id }}" @selected(old('respondente_id', $resposta->respondente_id ?? '') == $u->id)>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
                @error('respondente_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(33.33%-0.66rem)]">
                <label for="nota" class="block text-sm font-medium text-gray-700">
                    Nota (0–10) <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-star text-amber-400"></i>
                    </div>
                    <input type="number" step="0.01" min="0" max="10" id="nota" name="nota" required
                           value="{{ old('nota', $resposta->nota ?? '') }}"
                           placeholder="Ex: 9.5"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('nota') border-red-300 @enderror">
                </div>
                @error('nota') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(33.33%-0.66rem)]">
                <label for="respondido_em" class="block text-sm font-medium text-gray-700">Data do preenchimento</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="datetime-local" id="respondido_em" name="respondido_em"
                           value="{{ old('respondido_em', isset($resposta) ? $resposta->respondido_em?->format('Y-m-d\TH:i') : '') }}"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('respondido_em') border-red-300 @enderror">
                </div>
                @error('respondido_em') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Comentário / Respostas Detalhadas --}}
        <div class="flex flex-wrap gap-4 mt-4">
            <div class="w-full">
                <label for="comentario" class="block text-sm font-medium text-gray-700">Comentário / Observações</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-start pointer-events-none">
                        <i class="fas fa-comment-alt text-gray-400 mt-2.5"></i>
                    </div>
                    <textarea id="comentario" name="comentario" rows="3"
                              placeholder="Digite observações sobre o feedback recebido..."
                              class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('comentario') border-red-300 @enderror">{{ old('comentario', $resposta->respostas_detalhadas['comentario'] ?? '') }}</textarea>
                </div>
                @error('comentario') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>