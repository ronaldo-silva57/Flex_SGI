<div class="space-y-8">

    {{-- Seção 1: Identificação --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-ribbon text-red-600 mr-1"></i>Dados da Reunião
        </h3>

        {{-- Empresa + Gestão --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="empresa_id" class="block text-sm font-medium text-gray-700">
                    Empresa <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-building text-gray-400"></i>
                    </div>
                    <select id="empresa_id" name="empresa_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('empresa_id') border-red-300 @enderror">
                        <option value="">Selecione a empresa</option>
                        @foreach($empresas as $emp)
                            <option value="{{ $emp->id }}"
                                {{ old('empresa_id', $cipaReuniao->empresa_id ?? ($empresa->id ?? '')) == $emp->id ? 'selected' : '' }}>
                                {{ $emp->nome_fantasia ?? $emp->razao_social }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('empresa_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="gestao_ano" class="block text-sm font-medium text-gray-700">
                    Gestão (ano) <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar text-gray-400"></i>
                    </div>
                    <input type="text" id="gestao_ano" name="gestao_ano"
                        value="{{ old('gestao_ano', $cipaReuniao->gestao_ano ?? '') }}"
                        placeholder="Ex: 2026/2027"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('gestao_ano') border-red-300 @enderror">
                </div>
                @error('gestao_ano') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Tipo + Data --}}
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
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('tipo') border-red-300 @enderror">
                        <option value="">Selecione o tipo</option>
                        @foreach(['Ordinária', 'Extraordinária', 'Inspeção de Campo', 'DDSGeral'] as $tipoOption)
                            <option value="{{ $tipoOption }}"
                                {{ old('tipo', $cipaReuniao->tipo ?? '') == $tipoOption ? 'selected' : '' }}>
                                {{ $tipoOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_reuniao" class="block text-sm font-medium text-gray-700">
                    Data da Reunião <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" id="data_reuniao" name="data_reuniao"
                        value="{{ old('data_reuniao', isset($cipaReuniao) && $cipaReuniao->data_reuniao ? $cipaReuniao->data_reuniao->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('data_reuniao') border-red-300 @enderror">
                </div>
                @error('data_reuniao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Presidente + Secretário --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="presidente_id" class="block text-sm font-medium text-gray-700">
                    Presidente
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-tie text-gray-400"></i>
                    </div>
                    <select id="presidente_id" name="presidente_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('presidente_id') border-red-300 @enderror">
                        <option value="">Selecione o presidente</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}"
                                {{ old('presidente_id', $cipaReuniao->presidente_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('presidente_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="secretario_id" class="block text-sm font-medium text-gray-700">
                    Secretário(a)
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-check text-gray-400"></i>
                    </div>
                    <select id="secretario_id" name="secretario_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('secretario_id') border-red-300 @enderror">
                        <option value="">Selecione o secretário</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}"
                                {{ old('secretario_id', $cipaReuniao->secretario_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('secretario_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 2: Pauta --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-list-check text-red-600"></i>Pauta e Deliberações
        </h3>

        <div class="w-full mb-4">
            <label for="pauta_principal" class="block text-sm font-medium text-gray-700">
                Pauta Principal <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <input type="text" id="pauta_principal" name="pauta_principal"
                    value="{{ old('pauta_principal', $cipaReuniao->pauta_principal ?? '') }}"
                    placeholder="Resumo da pauta principal da reunião"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('pauta_principal') border-red-300 @enderror">
            </div>
            @error('pauta_principal') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex flex-wrap gap-4 items-start mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="pauta_detalhada" class="block text-sm font-medium text-gray-700">
                    Pauta Detalhada
                </label>
                <textarea id="pauta_detalhada" name="pauta_detalhada" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('pauta_detalhada') border-red-300 @enderror"
                    placeholder="Detalhamento dos tópicos discutidos (opcional)">{{ old('pauta_detalhada', $cipaReuniao->pauta_detalhada ?? '') }}</textarea>
                @error('pauta_detalhada') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="deliberacoes" class="block text-sm font-medium text-gray-700">
                    Deliberações
                </label>
                <textarea id="deliberacoes" name="deliberacoes" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('deliberacoes') border-red-300 @enderror"
                    placeholder="Decisões e encaminhamentos (opcional)">{{ old('deliberacoes', $cipaReuniao->deliberacoes ?? '') }}</textarea>
                @error('deliberacoes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 3: Ata e Status --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-file-lines text-red-600"></i>Ata e Status
        </h3>

        <div class="flex flex-wrap gap-4 items-end">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="ata_arquivo" class="block text-sm font-medium text-gray-700">
                    Arquivo da Ata (PDF)
                </label>
                <div class="mt-1">
                    <input type="file" id="ata_arquivo" name="ata_arquivo" accept="application/pdf"
                        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 @error('ata_arquivo') border-red-300 @enderror">
                </div>
                @if(!empty($cipaReuniao->ata_arquivo_path))
                    <p class="mt-2 text-xs text-gray-500">
                        <i class="fas fa-paperclip mr-1"></i>
                        Arquivo atual:
                        <a href="{{ Storage::disk('public')->url($cipaReuniao->ata_arquivo_path) }}"
                           target="_blank" class="text-blue-600 hover:underline">
                            Visualizar ata
                        </a>
                    </p>
                @endif
                @error('ata_arquivo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flag text-gray-400"></i>
                    </div>
                    <select id="status" name="status"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 @error('status') border-red-300 @enderror">
                        @foreach(['Agendada', 'Realizada', 'Cancelada'] as $statusOption)
                            <option value="{{ $statusOption }}"
                                {{ old('status', $cipaReuniao->status ?? 'Agendada') == $statusOption ? 'selected' : '' }}>
                                {{ $statusOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>