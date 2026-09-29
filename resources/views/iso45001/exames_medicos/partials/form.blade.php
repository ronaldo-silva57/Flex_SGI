<div class="space-y-8">
    {{-- Título da Seção --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-notes-medical text-blue-500"></i> Informações do ASO / Exame Médico
        </h3>

        {{-- Linha 1: Empresa + Colaborador --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Empresa --}}
        <div class="w-full md:w-[calc(50%-0.5rem)]">
            <label class="block text-sm font-medium text-gray-700">
                Empresa
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-building text-gray-400"></i>
                </div>
                <input type="text"
                    value="{{ $empresa->razao_social ?? (auth()->user()->empresa->razao_social ?? 'Empresa') }}"
                    class="pl-10 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-700 cursor-not-allowed shadow-sm focus:ring-0 focus:border-gray-300"
                    readonly
                    disabled>
            </div>
            {{-- Campo hidden para enviar o ID da empresa na requisição POST/PUT --}}
            <input type="hidden" name="empresa_id" value="{{ old('empresa_id', $exameMedico->empresa_id ?? $empresa->id) }}">
            @error('empresa_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
            {{-- Colaborador --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="usuario_id" class="block text-sm font-medium text-gray-700">
                    Colaborador <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="usuario_id" name="usuario_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('usuario_id') border-red-300 @enderror"
                        required>
                        <option value="">Selecione o colaborador...</option>
                        @foreach($usuarios ?? [] as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('usuario_id', $exameMedico->usuario_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('usuario_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Tipo ASO + Resultado + Status --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Tipo de ASO --}}
            <div class="w-full md:w-[calc(33.33%-0.66rem)]">
                <label for="tipo_aso" class="block text-sm font-medium text-gray-700">
                    Tipo do ASO <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-file-medical text-gray-400"></i>
                    </div>
                    <select id="tipo_aso" name="tipo_aso"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tipo_aso') border-red-300 @enderror"
                        required>
                        @foreach(['Admissional', 'Periódico', 'Retorno ao Trabalho', 'Mudança de Risco', 'Demissional'] as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipo_aso', $exameMedico->tipo_aso ?? '') == $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo_aso') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Resultado --}}
            <div class="w-full md:w-[calc(33.33%-0.66rem)]">
                <label for="resultado" class="block text-sm font-medium text-gray-700">
                    Resultado <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-heartbeat text-gray-400"></i>
                    </div>
                    <select id="resultado" name="resultado"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('resultado') border-red-300 @enderror"
                        required>
                        @foreach(['Apto', 'Apto com Restrição', 'Inapto'] as $res)
                            <option value="{{ $res }}" {{ old('resultado', $exameMedico->resultado ?? 'Apto') == $res ? 'selected' : '' }}>
                                {{ $res }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('resultado') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Status --}}
            <div class="w-full md:w-[calc(33.33%-0.66rem)]">
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
                        @foreach(['Vigente', 'Vencido', 'Substituído'] as $st)
                            <option value="{{ $st }}" {{ old('status', $exameMedico->status ?? 'Vigente') == $st ? 'selected' : '' }}>
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Data Realização + Data Vencimento --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_realizacao" class="block text-sm font-medium text-gray-700">
                    Data de Realização <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" id="data_realizacao" name="data_realizacao"
                        value="{{ old('data_realizacao', isset($exameMedico->data_realizacao) ? \Carbon\Carbon::parse($exameMedico->data_realizacao)->format('Y-m-d') : date('Y-m-d')) }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_realizacao') border-red-300 @enderror"
                        required>
                </div>
                @error('data_realizacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_vencimento" class="block text-sm font-medium text-gray-700">Data de Vencimento</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>
                    <input type="date" id="data_vencimento" name="data_vencimento"
                        value="{{ old('data_vencimento', isset($exameMedico->data_vencimento) ? \Carbon\Carbon::parse($exameMedico->data_vencimento)->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_vencimento') border-red-300 @enderror">
                </div>
                @error('data_vencimento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 4: Médico Examinador, Nome do Médico e CRM --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <label for="medico_examinador_id" class="block text-sm font-medium text-gray-700">Médico no Sistema</label>
                <select id="medico_examinador_id" name="medico_examinador_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Nenhum / Externo</option>
                    @foreach($usuarios ?? [] as $medico)
                        <option value="{{ $medico->id }}" {{ old('medico_examinador_id', $exameMedico->medico_examinador_id ?? '') == $medico->id ? 'selected' : '' }}>
                            {{ $medico->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="medico_nome" class="block text-sm font-medium text-gray-700">Nome do Médico (Externo)</label>
                <input type="text" id="medico_nome" name="medico_nome"
                    placeholder="Ex: Dr. João da Silva"
                    value="{{ old('medico_nome', $exameMedico->medico_nome ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="crm_medico" class="block text-sm font-medium text-gray-700">CRM do Médico</label>
                <input type="text" id="crm_medico" name="crm_medico"
                    placeholder="Ex: 123456/SP"
                    value="{{ old('crm_medico', $exameMedico->crm_medico ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        {{-- Restrições --}}
        <div class="mb-4">
            <label for="restricoes" class="block text-sm font-medium text-gray-700">Restrições Observadas</label>
            <textarea id="restricoes" name="restricoes" rows="3"
                placeholder="Descreva aqui caso existam restrições do colaborador..."
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
            >{{ old('restricoes', $exameMedico->restricoes ?? '') }}</textarea>
            @error('restricoes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Upload de Arquivo ASO --}}
        <div class="mb-4">
            <label for="arquivo_aso" class="block text-sm font-medium text-gray-700">Anexo do ASO (PDF / Imagem)</label>
            <input type="file" id="arquivo_aso" name="arquivo_aso" accept=".pdf,.jpg,.jpeg,.png"
                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @if(isset($exameMedico) && $exameMedico->arquivo_aso_path)
                <p class="mt-2 text-xs text-gray-500 flex items-center gap-1">
                    <i class="fas fa-paperclip"></i> Arquivo atual: 
                    <a href="{{ Storage::url($exameMedico->arquivo_aso_path) }}" target="_blank" class="text-blue-600 underline">Visualizar ASO</a>
                </p>
            @endif
            @error('arquivo_aso') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>