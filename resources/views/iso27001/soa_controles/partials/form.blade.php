<div class="space-y-8">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-clipboard-check text-purple-600 mr-1"></i>Dados do Controle SoA
        </h3>

        {{-- Empresa (fixa) --}}
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">
                Empresa <span class="text-red-500">*</span>
            </label>
            <div class="mt-1 flex items-center gap-2 p-2 border border-gray-200 rounded-md bg-gray-50">
                <i class="fas fa-building text-gray-400"></i>
                <span class="text-gray-700">
                    {{ $empresa->razao_social
                        ?? ($soaControle->empresa->razao_social
                        ?? auth()->user()->empresa->razao_social
                        ?? 'Empresa não definida') }}
                </span>
            </div>
            <input type="hidden" name="empresa_id"
                   value="{{ old('empresa_id', $empresa->id ?? ($soaControle->empresa_id ?? auth()->user()->empresa_id ?? '')) }}">
        </div>

        {{-- Código Anexo A + Domínio --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(35%-0.5rem)]">
                <label for="codigo_anexo_a" class="block text-sm font-medium text-gray-700">
                    Código Anexo A <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-gray-400"></i>
                    </div>
                    <input type="text" id="codigo_anexo_a" name="codigo_anexo_a"
                        value="{{ old('codigo_anexo_a', $soaControle->codigo_anexo_a ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('codigo_anexo_a') border-red-300 @enderror"
                        placeholder="Ex: A.5.1">
                </div>
                @error('codigo_anexo_a') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(65%-0.5rem)]">
                <label for="dominio" class="block text-sm font-medium text-gray-700">
                    Domínio <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-sitemap text-gray-400"></i>
                    </div>
                    <input type="text" id="dominio" name="dominio"
                        value="{{ old('dominio', $soaControle->dominio ?? '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('dominio') border-red-300 @enderror"
                        placeholder="Ex: Políticas de Segurança da Informação">
                </div>
                @error('dominio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Título --}}
        <div class="w-full mb-4">
            <label for="titulo" class="block text-sm font-medium text-gray-700">
                Título <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-heading text-gray-400"></i>
                </div>
                <input type="text" id="titulo" name="titulo"
                    value="{{ old('titulo', $soaControle->titulo ?? '') }}"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('titulo') border-red-300 @enderror"
                    placeholder="Ex: Política de Segurança da Informação">
            </div>
            @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Descrição --}}
        <div class="w-full mb-4">
            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
            <textarea id="descricao" name="descricao" rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('descricao') border-red-300 @enderror"
                placeholder="Descrição do controle conforme Anexo A">{{ old('descricao', $soaControle->descricao ?? '') }}</textarea>
            @error('descricao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Aplicável + Status de Implementação --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="aplicavel" class="block text-sm font-medium text-gray-700">
                    Aplicável <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-check-circle text-gray-400"></i>
                    </div>
                    <select id="aplicavel" name="aplicavel"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('aplicavel') border-red-300 @enderror">
                        <option value="1" {{ old('aplicavel', $soaControle->aplicavel ?? 1) == 1 ? 'selected' : '' }}>Sim</option>
                        <option value="0" {{ old('aplicavel', $soaControle->aplicavel ?? 1) == 0 ? 'selected' : '' }}>Não</option>
                    </select>
                </div>
                @error('aplicavel') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="status_implementacao" class="block text-sm font-medium text-gray-700">
                    Status de Implementação <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-flag text-gray-400"></i>
                    </div>
                    <select id="status_implementacao" name="status_implementacao"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('status_implementacao') border-red-300 @enderror">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}"
                                {{ old('status_implementacao', $soaControle->status_implementacao ?? 'Não iniciado') == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('status_implementacao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Justificativa Inclusão / Exclusão --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="justificativa_inclusao" class="block text-sm font-medium text-gray-700">
                    Justificativa de Inclusão
                </label>
                <textarea id="justificativa_inclusao" name="justificativa_inclusao" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('justificativa_inclusao') border-red-300 @enderror"
                    placeholder="Motivo pelo qual o controle é aplicável">{{ old('justificativa_inclusao', $soaControle->justificativa_inclusao ?? '') }}</textarea>
                @error('justificativa_inclusao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="justificativa_exclusao" class="block text-sm font-medium text-gray-700">
                    Justificativa de Exclusão
                </label>
                <textarea id="justificativa_exclusao" name="justificativa_exclusao" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('justificativa_exclusao') border-red-300 @enderror"
                    placeholder="Motivo pelo qual o controle NÃO é aplicável">{{ old('justificativa_exclusao', $soaControle->justificativa_exclusao ?? '') }}</textarea>
                @error('justificativa_exclusao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Responsável + Controle Segurança --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-check text-gray-400"></i>
                    </div>
                    <select id="responsavel_id" name="responsavel_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('responsavel_id') border-red-300 @enderror">
                        <option value="">Selecione</option>
                        @foreach($usuarios as $id => $nome)
                            <option value="{{ $id }}"
                                {{ old('responsavel_id', $soaControle->responsavel_id ?? auth()->id()) == $id ? 'selected' : '' }}>
                                {{ $nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="controle_id" class="block text-sm font-medium text-gray-700">
                    Controle de Segurança Vinculado
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-shield-alt text-gray-400"></i>
                    </div>
                    <select id="controle_id" name="controle_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('controle_id') border-red-300 @enderror">
                        <option value="">Nenhum</option>
                        @foreach($controlesSeguranca as $id => $nome)
                            <option value="{{ $id }}"
                                {{ old('controle_id', $soaControle->controle_id ?? '') == $id ? 'selected' : '' }}>
                                {{ $nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('controle_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Evidência (texto) --}}
        <div class="w-full mb-4">
            <label for="evidencia" class="block text-sm font-medium text-gray-700">Evidência (descrição)</label>
            <textarea id="evidencia" name="evidencia" rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 @error('evidencia') border-red-300 @enderror"
                placeholder="Descreva as evidências de implementação do controle">{{ old('evidencia', $soaControle->evidencia ?? '') }}</textarea>
            @error('evidencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>