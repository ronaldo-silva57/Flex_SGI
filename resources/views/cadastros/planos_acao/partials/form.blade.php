<div class="space-y-8">
    {{-- Título da Seção --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-tasks text-blue-500"></i> Informações do Plano de Ação
        </h3>

        {{-- Linha 1: Título + Código --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Título --}}
            <div class="w-full md:w-[calc(70%-0.5rem)]">
                <label for="titulo" class="block text-sm font-medium text-gray-700">
                    Título <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-heading text-gray-400"></i>
                    </div>
                    <input type="text" id="titulo" name="titulo"
                        placeholder="Ex: Adequação da temperatura na linha 2"
                        value="{{ old('titulo', $planoAcao->titulo ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('titulo') border-red-300 @enderror"
                        required>
                </div>
                @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Código --}}
            <div class="w-full md:w-[calc(30%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo"
                        placeholder="Ex: PA-2026-001"
                        value="{{ old('codigo', $planoAcao->codigo ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('codigo') border-red-300 @enderror">
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Responsável + Status --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
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
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('responsavel_id') border-red-300 @enderror"
                        required>
                        <option value="">Selecione o responsável...</option>
                        @foreach($usuarios ?? [] as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_id', $planoAcao->responsavel_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Status --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-toggle-on text-gray-400"></i>
                    </div>
                    <select id="status" name="status"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror"
                        required>
                        @foreach(['Pendente', 'Em andamento', 'Em verificação', 'Concluído', 'Cancelado'] as $statusOption)
                            <option value="{{ $statusOption }}" {{ old('status', $planoAcao->status ?? 'Pendente') == $statusOption ? 'selected' : '' }}>
                                {{ $statusOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Prazo Início + Prazo Fim --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Prazo Início --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="prazo_inicio" class="block text-sm font-medium text-gray-700">Data de Início</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" id="prazo_inicio" name="prazo_inicio"
                        value="{{ old('prazo_inicio', isset($planoAcao->prazo_inicio) ? \Carbon\Carbon::parse($planoAcao->prazo_inicio)->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('prazo_inicio') border-red-300 @enderror">
                </div>
                @error('prazo_inicio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Prazo Fim --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="prazo_fim" class="block text-sm font-medium text-gray-700">Data de Término / Prazo</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>
                    <input type="date" id="prazo_fim" name="prazo_fim"
                        value="{{ old('prazo_fim', isset($planoAcao->prazo_fim) ? \Carbon\Carbon::parse($planoAcao->prazo_fim)->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('prazo_fim') border-red-300 @enderror">
                </div>
                @error('prazo_fim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 4: Descrição --}}
        <div class="mb-4">
            <label for="o_que" class="block text-sm font-medium text-gray-700">
                O que será feito? <span class="text-red-500">*</span>
            </label>

            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-align-left text-gray-400"></i>
                </div>

                <textarea id="o_que" name="o_que" rows="4"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('o_que') border-red-300 @enderror"
                    required
                >{{ old('o_que', $planoAcao->o_que ?? '') }}</textarea>
            </div>

            @error('o_que')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="por_que" class="block text-sm font-medium text-gray-700">
                    Por que será feito?
                </label>

                <textarea
                    id="por_que"
                    name="por_que"
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                >{{ old('por_que', $planoAcao->por_que ?? '') }}</textarea>

                @error('por_que')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="onde" class="block text-sm font-medium text-gray-700">
                    Onde será executado?
                </label>

                <textarea
                    id="onde"
                    name="onde"
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                >{{ old('onde', $planoAcao->onde ?? '') }}</textarea>

                @error('onde')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="como" class="block text-sm font-medium text-gray-700">
                    Como será feito?
                </label>

                <textarea
                    id="como"
                    name="como"
                    rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                >{{ old('como', $planoAcao->como ?? '') }}</textarea>

                @error('como')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quanto_custa" class="block text-sm font-medium text-gray-700">
                    Quanto custa?
                </label>

                <input
                    type="number"
                    step="0.01"
                    min="0"
                    id="quanto_custa"
                    name="quanto_custa"
                    value="{{ old('quanto_custa', $planoAcao->quanto_custa ?? '0.00') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                >

                @error('quanto_custa')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <label for="data_conclusao" class="block text-sm font-medium text-gray-700">
                    Data de conclusão
                </label>

                <input
                    type="date"
                    id="data_conclusao"
                    name="data_conclusao"
                    value="{{ old('data_conclusao', optional($planoAcao->data_conclusao ?? null)->format('Y-m-d')) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                >

                @error('data_conclusao')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="progresso" class="block text-sm font-medium text-gray-700">
                    Progresso (%)
                </label>

                <input
                    type="number"
                    min="0"
                    max="100"
                    id="progresso"
                    name="progresso"
                    value="{{ old('progresso', $planoAcao->progresso ?? 0) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                >

                @error('progresso')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <label for="observacoes" class="block text-sm font-medium text-gray-700">
                Observações
            </label>

            <textarea
                id="observacoes"
                name="observacoes"
                rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >{{ old('observacoes', $planoAcao->observacoes ?? '') }}</textarea>

            @error('observacoes')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>