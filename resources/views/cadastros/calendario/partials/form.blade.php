<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Título --}}
        <div>
            <label for="titulo" class="block text-sm font-medium text-gray-700">
                Título do Evento <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-heading text-gray-400"></i>
                </div>
                <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $evento->titulo ?? '') }}"
                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('titulo') border-red-300 @enderror" required placeholder="Ex: Auditoria Interna ISO 9001">
            </div>
            @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Categoria --}}
        <div>
            <label for="categoria" class="block text-sm font-medium text-gray-700">
                Categoria <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-folder text-gray-400"></i>
                </div>
                <select id="categoria" name="categoria"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('categoria') border-red-300 @enderror" required>
                    <option value="">Selecione uma Categoria</option>
                    @foreach(['Auditoria', 'Prazo SGI', 'Reunião', 'Treinamento', 'Manutenção', 'Outros'] as $cat)
                        <option value="{{ $cat }}" {{ old('categoria', $evento->categoria ?? 'Prazo SGI') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('categoria') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Empresa (Hidden + Display) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Empresa</label>
            <div class="mt-1 flex items-center gap-2 p-2.5 border border-gray-200 rounded-md bg-gray-50">
                <i class="fas fa-building text-gray-400"></i>
                <span class="text-gray-700 text-sm">
                    {{ $empresa->razao_social ?? $evento->empresa?->razao_social ?? 'Empresa não definida' }}
                </span>
            </div>
            <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? ($evento->empresa_id ?? '') }}">
        </div>

        {{-- Responsável --}}
        <div>
            <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                <select id="responsavel_id" name="responsavel_id"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('responsavel_id') border-red-300 @enderror">
                    <option value="">Selecione um responsável</option>
                    @foreach($responsaveis as $resp)
                        <option value="{{ $resp->id }}" {{ old('responsavel_id', $evento->responsavel_id ?? '') == $resp->id ? 'selected' : '' }}>
                            {{ $resp->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Status --}}
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">
                Status <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-info-circle text-gray-400"></i>
                </div>
                <select id="status" name="status"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('status') border-red-300 @enderror" required>
                    @foreach(['Agendado', 'Realizado', 'Cancelado', 'Adiado'] as $st)
                        <option value="{{ $st }}" {{ old('status', $evento->status ?? 'Agendado') == $st ? 'selected' : '' }}>
                            {{ $st }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Data Início --}}
        <div>
            <label for="data_inicio" class="block text-sm font-medium text-gray-700">
                Data e Hora de Início <span class="text-red-500">*</span>
            </label>
            <div class="mt-1">
                <input type="datetime-local" id="data_inicio" name="data_inicio"
                    value="{{ old('data_inicio', isset($evento->data_inicio) ? $evento->data_inicio->format('Y-m-d\TH:i') : '') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('data_inicio') border-red-300 @enderror" required>
            </div>
            @error('data_inicio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Data Fim --}}
        <div>
            <label for="data_fim" class="block text-sm font-medium text-gray-700">Data e Hora de Término</label>
            <div class="mt-1">
                <input type="datetime-local" id="data_fim" name="data_fim"
                    value="{{ old('data_fim', isset($evento->data_fim) ? $evento->data_fim->format('Y-m-d\TH:i') : '') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('data_fim') border-red-300 @enderror">
            </div>
            @error('data_fim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Descrição --}}
    <div>
        <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição / Detalhes</label>
        <div class="mt-1">
            <textarea id="descricao" name="descricao" rows="3"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('descricao') border-red-300 @enderror"
                placeholder="Detalhes adicionais sobre o evento...">{{ old('descricao', $evento->descricao ?? '') }}</textarea>
        </div>
        @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>