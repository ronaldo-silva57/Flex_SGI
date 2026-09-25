<div class="space-y-8">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-file-alt text-blue-500"></i> Dados do Documento
        </h3>

        {{-- Linha 1: Empresa + Código --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
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
                    value="{{ old('empresa_id', $documento->empresa_id ?? $empresas->id ?? '') }}"
                >

                @error('empresa_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Código <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $documento->codigo ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('codigo') border-red-300 @enderror"
                        required maxlength="50">
                </div>
                @error('codigo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 2: Título + Tipo --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="titulo" class="block text-sm font-medium text-gray-700">
                    Título <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-file-signature text-gray-400"></i>
                    </div>
                    <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $documento->titulo ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('titulo') border-red-300 @enderror"
                        required maxlength="255">
                </div>
                @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

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
                        @foreach(['Política', 'Procedimento', 'Instrução', 'Registro', 'Formulário', 'Manual', 'Outro'] as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipo', $documento->tipo ?? '') == $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 3: Processo + Norma --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="processo_id" class="block text-sm font-medium text-gray-700">Processo</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-cogs text-gray-400"></i>
                    </div>
                    <select id="processo_id" name="processo_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('processo_id') border-red-300 @enderror">
                        <option value="">Selecione o processo...</option>
                        @foreach($processos as $processo)
                            <option value="{{ $processo->id }}" {{ old('processo_id', $documento->processo_id ?? '') == $processo->id ? 'selected' : '' }}>
                                {{ $processo->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('processo_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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
                            <option value="{{ $norma->id }}" {{ old('norma_id', $documento->norma_id ?? '') == $norma->id ? 'selected' : '' }}>
                                {{ $norma->codigo }} - {{ $norma->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('norma_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 4: Responsável + Versão + Status --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-1/3">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione o responsável...</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_id', $documento->responsavel_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-1/3">
                <label for="versao" class="block text-sm font-medium text-gray-700">
                    Versão <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-code-branch text-gray-400"></i>
                    </div>
                    <input type="text" id="versao" name="versao" value="{{ old('versao', $documento->versao ?? '1.0') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('versao') border-red-300 @enderror"
                        required maxlength="10">
                </div>
                @error('versao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-1/3">
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
                        @foreach(['Rascunho', 'Em revisão', 'Aprovado', 'Obsoleto'] as $status)
                            <option value="{{ $status }}" {{ old('status', $documento->status ?? 'Rascunho') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha 5: Datas de aprovação e revisão --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-1/2">
                <label for="data_aprovacao" class="block text-sm font-medium text-gray-700">Data de Aprovação</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>
                    <input type="date" id="data_aprovacao" name="data_aprovacao"
                        value="{{ old('data_aprovacao', isset($documento) && $documento->data_aprovacao ? $documento->data_aprovacao->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_aprovacao') border-red-300 @enderror">
                </div>
                @error('data_aprovacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-1/2">
                <label for="data_revisao" class="block text-sm font-medium text-gray-700">Data de Revisão</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="date" id="data_revisao" name="data_revisao"
                        value="{{ old('data_revisao', isset($documento) && $documento->data_revisao ? $documento->data_revisao->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('data_revisao') border-red-300 @enderror">
                </div>
                @error('data_revisao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Conteúdo --}}
        <div class="mb-4">
            <label for="conteudo" class="block text-sm font-medium text-gray-700">Conteúdo</label>
            <div class="relative mt-1">
                <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                    <i class="fas fa-align-left text-gray-400"></i>
                </div>
                <textarea id="conteudo" name="conteudo" rows="4"
                    placeholder="Descrição detalhada do documento..."
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('conteudo') border-red-300 @enderror">{{ old('conteudo', $documento->conteudo ?? '') }}</textarea>
            </div>
            @error('conteudo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Arquivo (upload) --}}
        <div class="mb-4">
            <label for="arquivo_path" class="block text-sm font-medium text-gray-700">Arquivo (PDF, DOC, etc.)</label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-file-upload text-gray-400"></i>
                </div>
                <input type="file" id="arquivo_path" name="arquivo_path"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('arquivo_path') border-red-300 @enderror">
            </div>
            @if(isset($documento) && $documento->arquivo_path)
                <p class="mt-1 text-sm text-gray-500">
                    <i class="fas fa-file mr-1"></i> Arquivo atual: 
                    <a href="{{ asset('storage/' . $documento->arquivo_path) }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ basename($documento->arquivo_path) }}
                    </a>
                </p>
            @endif
            @error('arquivo_path') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>