<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Título --}}
        <div class="md:col-span-2">
            <label for="titulo" class="block text-sm font-medium text-gray-700">
                Título <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-heading text-gray-400"></i>
                </div>
                <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $comunicacao->titulo ?? '') }}"
                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('titulo') border-red-300 @enderror" required placeholder="Ex: Nova Diretriz de Qualidade SGI">
            </div>
            @error('titulo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Tipo --}}
        <div>
            <label for="tipo" class="block text-sm font-medium text-gray-700">
                Tipo <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <select id="tipo" name="tipo"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('tipo') border-red-300 @enderror" required>
                    @foreach(['Aviso', 'Circular', 'Política SGI', 'Comunicado Oficial'] as $tp)
                        <option value="{{ $tp }}" {{ old('tipo', $comunicacao->tipo ?? 'Aviso') == $tp ? 'selected' : '' }}>
                            {{ $tp }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('tipo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Empresa (Hidden + Display) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Empresa</label>
            <div class="mt-1 flex items-center gap-2 p-2.5 border border-gray-200 rounded-md bg-gray-50">
                <i class="fas fa-building text-gray-400"></i>
                <span class="text-gray-700 text-sm truncate">
                    {{ $empresa->razao_social ?? $comunicacao->empresa?->razao_social ?? 'Empresa não definida' }}
                </span>
            </div>
            <input type="hidden" name="empresa_id" value="{{ $empresa->id ?? ($comunicacao->empresa_id ?? '') }}">
        </div>

        {{-- Publicado Em --}}
        <div>
            <label for="publicado_em" class="block text-sm font-medium text-gray-700">Data/Hora de Publicação</label>
            <div class="mt-1">
                <input type="datetime-local" id="publicado_em" name="publicado_em"
                    value="{{ old('publicado_em', isset($comunicacao->publicado_em) ? $comunicacao->publicado_em->format('Y-m-d\TH:i') : '') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('publicado_em') border-red-300 @enderror">
            </div>
            @error('publicado_em') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Expirado Em --}}
        <div>
            <label for="expirado_em" class="block text-sm font-medium text-gray-700">Data/Hora de Expiração</label>
            <div class="mt-1">
                <input type="datetime-local" id="expirado_em" name="expirado_em"
                    value="{{ old('expirado_em', isset($comunicacao->expirado_em) ? $comunicacao->expirado_em->format('Y-m-d\TH:i') : '') }}"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('expirado_em') border-red-300 @enderror">
            </div>
            @error('expirado_em') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Conteúdo --}}
    <div>
        <label for="conteundo" class="block text-sm font-medium text-gray-700">
            Conteúdo <span class="text-red-500">*</span>
        </label>
        <div class="mt-1">
            <textarea id="conteundo" name="conteundo" rows="5"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500 @error('conteundo') border-red-300 @enderror"
                required placeholder="Escreva o texto da comunicação interna...">{{ old('conteundo', $comunicacao->conteundo ?? '') }}</textarea>
        </div>
        @error('conteundo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-200">
        {{-- Exige Ciência --}}
        <div>
            <label for="exige_ciencia" class="block text-sm font-medium text-gray-700">Exige Confirmação de Ciência</label>
            <div class="relative mt-2">
                <input type="hidden" name="exige_ciencia" value="0">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="exige_ciencia" name="exige_ciencia" value="1"
                        {{ old('exige_ciencia', $comunicacao->exige_ciencia ?? false) ? 'checked' : '' }}
                        class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-indigo-500 relative transition">
                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-5"></div>
                    </div>
                </label>
            </div>
            @error('exige_ciencia') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        {{-- Status Ativo --}}
        <div>
            <label for="ativo" class="block text-sm font-medium text-gray-700">Ativo</label>
            <div class="relative mt-2">
                <input type="hidden" name="ativo" value="0">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" id="ativo" name="ativo" value="1"
                        {{ old('ativo', $comunicacao->ativo ?? true) ? 'checked' : '' }}
                        class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-green-500 relative transition">
                        <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition peer-checked:translate-x-5"></div>
                    </div>
                </label>
            </div>
            @error('ativo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>