<div class="space-y-8">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-clipboard-list text-blue-500"></i> Dados da Auditoria
        </h3>

        {{-- Linha 1: Empresa + Norma --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Empresa --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>

                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>

                    <span class="text-gray-700">
                        {{ $empresas->razao_social ?? 'Empresa não definida' }}
                    </span>
                </div>

                <input
                    type="hidden"
                    name="empresa_id"
                    value="{{ old('empresa_id', $auditoria->empresa_id ?? $empresas->id) }}"
                >

                @error('empresa_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="norma_id" class="block text-sm font-medium text-gray-700">Norma</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-file-alt text-gray-400"></i>
                    </div>
                    <select id="norma_id" name="norma_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('norma_id') border-red-300 @enderror">
                        <option value="">Selecione a norma...</option>
                        @foreach($normas as $norma)
                            <option value="{{ $norma->id }}" {{ old('norma_id', $auditoria->norma_id ?? '') == $norma->id ? 'selected' : '' }}>
                                {{ $norma->codigo }} - {{ $norma->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('norma_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Tipo + Auditor Líder --}}
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
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tipo') border-red-300 @enderror"
                        required>
                        <option value="">Selecione o tipo...</option>
                        @foreach(['Interna', 'Externa', 'Terceira parte'] as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipo', $auditoria->tipo ?? '') == $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="auditor_lider_id" class="block text-sm font-medium text-gray-700">Auditor Líder</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="auditor_lider_id" name="auditor_lider_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('auditor_lider_id') border-red-300 @enderror">
                        <option value="">Selecione o auditor...</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('auditor_lider_id', $auditoria->auditor_lider_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('auditor_lider_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Escopo + Objetivo --}}
        <div class="flex flex-wrap gap-4 items-start mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="escopo" class="block text-sm font-medium text-gray-700">Escopo</label>
                <div class="relative mt-1">
                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                        <i class="fas fa-bullseye text-gray-400"></i>
                    </div>
                    <textarea id="escopo" name="escopo" rows="2"
                        placeholder="Processos, áreas, setores abrangidos..."
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('escopo') border-red-300 @enderror">{{ old('escopo', $auditoria->escopo ?? '') }}</textarea>
                </div>
                @error('escopo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="objetivo" class="block text-sm font-medium text-gray-700">Objetivo</label>
                <div class="relative mt-1">
                    <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                        <i class="fas fa-flag text-gray-400"></i>
                    </div>
                    <textarea id="objetivo" name="objetivo" rows="2"
                        placeholder="O que se espera alcançar com a auditoria..."
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('objetivo') border-red-300 @enderror">{{ old('objetivo', $auditoria->objetivo ?? '') }}</textarea>
                </div>
                @error('objetivo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 4: Datas + Status --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-1/3">
                <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data de Início</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-plus text-gray-400"></i>
                    </div>
                    <input type="date" id="data_inicio" name="data_inicio"
                        value="{{ old('data_inicio', isset($auditoria) ? $auditoria->data_inicio?->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_inicio') border-red-300 @enderror">
                </div>
                @error('data_inicio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-1/3">
                <label for="data_fim" class="block text-sm font-medium text-gray-700">Data de Fim</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>
                    <input type="date" id="data_fim" name="data_fim"
                        value="{{ old('data_fim', isset($auditoria) ? $auditoria->data_fim?->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_fim') border-red-300 @enderror">
                </div>
                @error('data_fim') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

{{-- Status --}}
<div class="w-full md:w-1/3">
    <label for="status" class="block text-sm font-medium text-gray-700">
        Status <span class="text-red-500">*</span>
    </label>

                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-toggle-on text-gray-400"></i>
                    </div>

                    <select
                        id="status"
                        name="status"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror"
                        required
                    >
                        @foreach(['Planejada', 'Em andamento', 'Concluída', 'Cancelada'] as $status)
                            <option
                                value="{{ $status }}"
                                {{ old('status', $auditoria->status ?? 'Planejada') === $status ? 'selected' : '' }}
                            >
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Linha 5: Relatório --}}
        <div>
            <label for="relatorio" class="block text-sm font-medium text-gray-700">Relatório</label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-file-pdf text-gray-400"></i>
                </div>
                <textarea id="relatorio" name="relatorio" rows="3"
                    placeholder="Conclusões, não conformidades encontradas, recomendações..."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('relatorio') border-red-300 @enderror">{{ old('relatorio', $auditoria->relatorio ?? '') }}</textarea>
            </div>
            @error('relatorio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>