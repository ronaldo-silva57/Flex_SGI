<div class="space-y-8">

    {{-- =========================================================
         SEÇÃO 1 - IDENTIFICAÇÃO
         ========================================================= --}}
    <div>

        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-shield-halved text-indigo-600"></i>
            Identificação do Controle
        </h3>


        {{-- Empresa + Código --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">

            {{-- Empresa --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">

                <label class="block text-sm font-medium text-gray-700">
                    Empresa
                </label>

                <div class="mt-1 flex items-center gap-2 p-2.5 border border-gray-200 rounded-md bg-gray-50">

                    <i class="fas fa-building text-gray-400"></i>

                    <span class="text-gray-700">
                        {{ $empresa->razao_social ?? 'Empresa não definida' }}
                    </span>

                </div>

                <input
                    type="hidden"
                    name="empresa_id"
                    value="{{ $empresa->id ?? '' }}"
                >

            </div>


            {{-- Código Anexo A --}}
            <div class="w-full md:w-[calc(50%-0.5rem)]">

                <label for="codigo_anexo_a"
                       class="block text-sm font-medium text-gray-700">

                    Código / Referência do Anexo A

                </label>

                <div class="relative mt-1">

                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-gray-400"></i>
                    </div>

                    <input
                        type="text"
                        id="codigo_anexo_a"
                        name="codigo_anexo_a"
                        value="{{ old('codigo_anexo_a', $controlesSeguranca->codigo_anexo_a ?? '') }}"
                        maxlength="20"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('codigo_anexo_a') border-red-300 @enderror"
                        placeholder="Ex.: A.5.1"
                    >

                </div>

                @error('codigo_anexo_a')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

        </div>


        {{-- Título --}}
        <div class="mb-4">

            <label for="titulo"
                   class="block text-sm font-medium text-gray-700">

                Título do Controle
                <span class="text-red-500">*</span>

            </label>

            <div class="relative mt-1">

                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-heading text-gray-400"></i>
                </div>

                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    value="{{ old('titulo', $controlesSeguranca->titulo ?? '') }}"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('titulo') border-red-300 @enderror"
                    placeholder="Nome do controle de segurança..."
                >

            </div>

            @error('titulo')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Ativo --}}
        <div>

            <label for="ativo_id"
                   class="block text-sm font-medium text-gray-700">

                Ativo de Informação

            </label>

            <div class="relative mt-1">

                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-server text-gray-400"></i>
                </div>

                <select
                    id="ativo_id"
                    name="ativo_id"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('ativo_id') border-red-300 @enderror"
                >

                    <option value="">
                        Selecione um ativo
                    </option>

                    @foreach($ativos as $ativo)

                        <option
                            value="{{ $ativo->id }}"
                            {{ old('ativo_id', $controlesSeguranca->ativo_id ?? '') == $ativo->id ? 'selected' : '' }}
                        >
                            {{ $ativo->nome }}
                        </option>

                    @endforeach

                </select>

            </div>

            @error('ativo_id')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>

    </div>


    {{-- =========================================================
         SEÇÃO 2 - DESCRIÇÃO
         ========================================================= --}}
    <div>

        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">

            <i class="fas fa-align-left text-indigo-600"></i>

            Descrição do Controle

        </h3>


        <label for="descricao"
               class="block text-sm font-medium text-gray-700">

            Descrição

        </label>

        <textarea
            id="descricao"
            name="descricao"
            rows="5"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('descricao') border-red-300 @enderror"
            placeholder="Descreva o objetivo, aplicação e funcionamento do controle..."
        >{{ old('descricao', $controlesSeguranca->descricao ?? '') }}</textarea>

        @error('descricao')
            <p class="mt-1 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror

    </div>


    {{-- =========================================================
         SEÇÃO 3 - IMPLEMENTAÇÃO
         ========================================================= --}}
    <div>

        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">

            <i class="fas fa-circle-check text-green-600"></i>

            Implementação

        </h3>


        <div class="flex flex-wrap gap-4 items-end">


            {{-- Implementado --}}
            <div class="w-full md:w-1/3">

                <label for="implementado"
                       class="block text-sm font-medium text-gray-700">

                    Situação

                </label>

                <div class="relative mt-1">

                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-toggle-on text-gray-400"></i>
                    </div>

                    <select
                        id="implementado"
                        name="implementado"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    >

                        <option value="0"
                            {{ old('implementado', $controlesSeguranca->implementado ?? false) == false ? 'selected' : '' }}>
                            Não implementado
                        </option>

                        <option value="1"
                            {{ old('implementado', $controlesSeguranca->implementado ?? false) == true ? 'selected' : '' }}>
                            Implementado
                        </option>

                    </select>

                </div>

            </div>


            {{-- Data implementação --}}
            <div class="w-full md:w-1/3">

                <label for="data_implementacao"
                       class="block text-sm font-medium text-gray-700">

                    Data da Implementação

                </label>

                <div class="relative mt-1">

                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-check text-gray-400"></i>
                    </div>

                    <input
                        type="date"
                        id="data_implementacao"
                        name="data_implementacao"
                        value="{{ old('data_implementacao', isset($controlesSeguranca->data_implementacao) ? $controlesSeguranca->data_implementacao->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('data_implementacao') border-red-300 @enderror"
                    >

                </div>

                @error('data_implementacao')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- Responsável --}}
            <div class="w-full md:w-[calc(33.333%-0.5rem)]">

                <label for="responsavel_id"
                       class="block text-sm font-medium text-gray-700">

                    Responsável

                </label>

                <div class="relative mt-1">

                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-check text-gray-400"></i>
                    </div>

                    <select
                        id="responsavel_id"
                        name="responsavel_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    >

                        <option value="">
                            Selecione o responsável
                        </option>

                        @foreach($usuarios as $usuario)

                            <option
                                value="{{ $usuario->id }}"
                                {{ old('responsavel_id', $controlesSeguranca->responsavel_id ?? auth()->id()) == $usuario->id ? 'selected' : '' }}
                            >
                                {{ $usuario->name }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         SEÇÃO 4 - EVIDÊNCIA
         ========================================================= --}}
    <div>

        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">

            <i class="fas fa-file-shield text-indigo-600"></i>

            Evidência da Implementação

        </h3>


        <label for="evidencia"
               class="block text-sm font-medium text-gray-700">

            Evidência

        </label>

        <textarea
            id="evidencia"
            name="evidencia"
            rows="5"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('evidencia') border-red-300 @enderror"
            placeholder="Informe documentos, procedimentos, registros, sistemas ou outras evidências que comprovem a implementação..."
        >{{ old('evidencia', $controlesSeguranca->evidencia ?? '') }}</textarea>

        @error('evidencia')
            <p class="mt-1 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror

    </div>

</div>