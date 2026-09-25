<div class="space-y-8">
    {{-- Seção 1: Vínculo --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-link text-indigo-600"></i>Vínculo do Treinamento
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Treinamento --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="treinamento_id" class="block text-sm font-medium text-gray-700">
                    Treinamento <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-graduation-cap text-gray-400"></i>
                    </div>
                    <select id="treinamento_id" name="treinamento_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('treinamento_id') border-red-300 @enderror">
                        <option value="">Selecione um Treinamento</option>
                        @foreach($treinamentos as $t)
                            <option value="{{ $t->id }}"
                                {{ old('treinamento_id', $participacao->treinamento_id ?? '') == $t->id ? 'selected' : '' }}>
                                {{ $t->titulo }} ({{ $t->tipo }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('treinamento_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Usuário --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="usuario_id" class="block text-sm font-medium text-gray-700">
                    Usuário <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="usuario_id" name="usuario_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('usuario_id') border-red-300 @enderror">
                        <option value="">Selecione um Usuário</option>
                        @foreach($usuarios as $u)
                            <option value="{{ $u->id }}"
                                {{ old('usuario_id', $participacao->usuario_id ?? '') == $u->id ? 'selected' : '' }}>
                                {{ $u->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('usuario_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    {{-- Seção 2: Execução --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-sliders text-indigo-600"></i>Execução e Avaliação
        </h3>

        <div class="flex flex-wrap gap-4 items-end mb-4">
            {{-- Data Conclusão --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="data_conclusao" class="block text-sm font-medium text-gray-700">Data de Conclusão</label>
                <input type="date" id="data_conclusao" name="data_conclusao"
                    value="{{ old('data_conclusao', isset($participacao->data_conclusao) ? $participacao->data_conclusao->format('Y-m-d') : '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('data_conclusao') border-red-300 @enderror">
                @error('data_conclusao') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Validade --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="validade_ate" class="block text-sm font-medium text-gray-700">Válido até</label>
                <input type="date" id="validade_ate" name="validade_ate"
                    value="{{ old('validade_ate', isset($participacao->validade_ate) ? $participacao->validade_ate->format('Y-m-d') : '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('validade_ate') border-red-300 @enderror">
                <p class="text-xs text-gray-500 mt-1">Deixe vazio para calcular automaticamente.</p>
                @error('validade_ate') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Nota --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="nota" class="block text-sm font-medium text-gray-700">Nota (0 a 10)</label>
                <input type="number" step="0.01" min="0" max="10" id="nota" name="nota"
                    value="{{ old('nota', $participacao->nota ?? '') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('nota') border-red-300 @enderror"
                    placeholder="Ex: 9.5">
                @error('nota') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Status --}}
            <div class="w-full md:w-[calc(25%-0.75rem)]">
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" name="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-300 @enderror">
                    @foreach(['Pendente', 'Em andamento', 'Concluído', 'Vencido'] as $statusOpt)
                        <option value="{{ $statusOpt }}"
                            {{ old('status', $participacao->status ?? 'Pendente') == $statusOpt ? 'selected' : '' }}>
                            {{ $statusOpt }}
                        </option>
                    @endforeach
                </select>
                @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Certificado --}}
        <div class="w-full mb-4">
            <label for="certificado" class="block text-sm font-medium text-gray-700">Certificado (PDF/JPG/PNG)</label>
            <input type="file" id="certificado" name="certificado" accept=".pdf,.jpg,.jpeg,.png"
                class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md cursor-pointer file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('certificado') border-red-300 @enderror">

            @if(!empty($participacao->certificado_path))
                <p class="mt-2 text-sm text-gray-600">
                    <i class="fas fa-paperclip mr-1"></i>
                    Atual:
                    <a href="{{ Storage::disk('public')->url($participacao->certificado_path) }}"
                       target="_blank" class="text-indigo-600 hover:underline">visualizar certificado</a>
                </p>
            @endif
            @error('certificado') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>