<div class="space-y-8">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-calendar-alt text-blue-500"></i> Dados da Reunião
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>

                <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                    <i class="fas fa-building text-gray-400"></i>

                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? 'Empresa não definida' }}
                    </span>
                </div>

                <input
                    type="hidden"
                    name="empresa_id"
                    value="{{ old('empresa_id', $reunioesGestao->empresa_id ?? $empresa->id ?? '') }}"
                >

                @error('empresa_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione o responsável...</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_id', $reunioesGestao->responsavel_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-1/3">
                <label for="data_reuniao" class="block text-sm font-medium text-gray-700">
                    Data da Reunião <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-day text-gray-400"></i>
                    </div>
                    <input type="date" id="data_reuniao" name="data_reuniao"
                        value="{{ old('data_reuniao', isset($reunioesGestao) ? $reunioesGestao->data_reuniao->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_reuniao') border-red-300 @enderror"
                        required>
                </div>
                @error('data_reuniao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-1/3">
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
                        @foreach(['Revisão Direção', 'Gestão Integrada', 'Outros'] as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipo', $reunioesGestao->tipo ?? '') == $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-1/3">
                <label for="proxima_reuniao" class="block text-sm font-medium text-gray-700">Próxima Reunião</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-plus text-gray-400"></i>
                    </div>
                    <input type="date" id="proxima_reuniao" name="proxima_reuniao"
                        value="{{ old('proxima_reuniao', isset($reunioesGestao) && $reunioesGestao->proxima_reuniao ? $reunioesGestao->proxima_reuniao->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('proxima_reuniao') border-red-300 @enderror">
                </div>
                @error('proxima_reuniao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Campos de texto longos --}}
        <div class="mb-4">
            <label for="pauta" class="block text-sm font-medium text-gray-700">Pauta</label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-list-ul text-gray-400"></i>
                </div>
                <textarea id="pauta" name="pauta" rows="3"
                    placeholder="Itens a serem discutidos..."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('pauta') border-red-300 @enderror">{{ old('pauta', $reunioesGestao->pauta ?? '') }}</textarea>
            </div>
            @error('pauta') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="decisoes" class="block text-sm font-medium text-gray-700">Decisões</label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-gavel text-gray-400"></i>
                </div>
                <textarea id="decisoes" name="decisoes" rows="3"
                    placeholder="Decisões tomadas durante a reunião..."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('decisoes') border-red-300 @enderror">{{ old('decisoes', $reunioesGestao->decisoes ?? '') }}</textarea>
            </div>
            @error('decisoes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="acoes_definidas" class="block text-sm font-medium text-gray-700">Ações Definidas</label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-tasks text-gray-400"></i>
                </div>
                <textarea id="acoes_definidas" name="acoes_definidas" rows="3"
                    placeholder="Ações, responsáveis e prazos definidos..."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('acoes_definidas') border-red-300 @enderror">{{ old('acoes_definidas', $reunioesGestao->acoes_definidas ?? '') }}</textarea>
            </div>
            @error('acoes_definidas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="ata" class="block text-sm font-medium text-gray-700">Ata</label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-file-alt text-gray-400"></i>
                </div>
                <textarea id="ata" name="ata" rows="4"
                    placeholder="Resumo completo da reunião..."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('ata') border-red-300 @enderror">{{ old('ata', $reunioesGestao->ata ?? '') }}</textarea>
            </div>
            @error('ata') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>