<div class="space-y-8">
    {{-- Seção 1: Dados da Entrega --}}
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-hand-holding-heart text-green-600 mr-1"></i>Registro de Entrega
        </h3>

        {{-- Linha: EPI + Usuário --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="epi_id" class="block text-sm font-medium text-gray-700">
                    EPI <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hard-hat text-gray-400"></i>
                    </div>
                    <select id="epi_id" name="epi_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('epi_id') border-red-300 @enderror">
                        <option value="">Selecione um EPI</option>
                        @foreach($epis as $epi)
                            <option value="{{ $epi->id }}" {{ old('epi_id', $episUsuario->epi_id ?? '') == $epi->id ? 'selected' : '' }}>
                                {{ $epi->nome }} (Estoque: {{ $epi->estoque_atual }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('epi_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="usuario_id" class="block text-sm font-medium text-gray-700">
                    Usuário <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <select id="usuario_id" name="usuario_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('usuario_id') border-red-300 @enderror">
                        <option value="">Selecione um usuário</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('usuario_id', $episUsuario->usuario_id ?? '') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('usuario_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha: Quantidade + Data Entrega --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="quantidade" class="block text-sm font-medium text-gray-700">
                    Quantidade <span class="text-red-500">*</span>
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-hashtag text-gray-400"></i>
                    </div>
                    <input type="number" id="quantidade" name="quantidade"
                        value="{{ old('quantidade', $episUsuario->quantidade ?? 1) }}"
                        min="1"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('quantidade') border-red-300 @enderror"
                        placeholder="1">
                </div>
                @error('quantidade') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_entrega" class="block text-sm font-medium text-gray-700">
                    Data de Entrega
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-day text-gray-400"></i>
                    </div>
                    <input type="date" id="data_entrega" name="data_entrega"
                        value="{{ old('data_entrega', isset($episUsuario) && $episUsuario->data_entrega ? $episUsuario->data_entrega->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('data_entrega') border-red-300 @enderror">
                </div>
                @error('data_entrega') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Linha: Data Vencimento + Responsável Entrega --}}
        <div class="flex flex-wrap gap-4 items-end mb-4">
            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="data_vencimento" class="block text-sm font-medium text-gray-700">
                    Data de Vencimento
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-calendar-times text-gray-400"></i>
                    </div>
                    <input type="date" id="data_vencimento" name="data_vencimento"
                        value="{{ old('data_vencimento', isset($episUsuario) && $episUsuario->data_vencimento ? $episUsuario->data_vencimento->format('Y-m-d') : '') }}"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('data_vencimento') border-red-300 @enderror">
                </div>
                @error('data_vencimento') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="w-full md:w-[calc(50%-0.5rem)]">
                <label for="responsavel_entrega_id" class="block text-sm font-medium text-gray-700">
                    Responsável pela Entrega
                </label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user-check text-gray-400"></i>
                    </div>
                    <select id="responsavel_entrega_id" name="responsavel_entrega_id"
                        class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('responsavel_entrega_id') border-red-300 @enderror">
                        <option value="">Selecione o responsável</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_entrega_id', $episUsuario->responsavel_entrega_id ?? auth()->id()) == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('responsavel_entrega_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Status --}}
        <div class="w-full md:w-1/2">
            <label for="status" class="block text-sm font-medium text-gray-700">
                Status <span class="text-red-500">*</span>
            </label>
            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-flag text-gray-400"></i>
                </div>
                <select id="status" name="status"
                    class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-green-500 focus:border-green-500 @error('status') border-red-300 @enderror">
                    @foreach(['Ativo', 'Vencido', 'Devolvido'] as $statusOption)
                        <option value="{{ $statusOption }}" {{ old('status', $episUsuario->status ?? 'Ativo') == $statusOption ? 'selected' : '' }}>
                            {{ $statusOption }}
                        </option>
                    @endforeach
                </select>
            </div>
            @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const epiSelect = document.getElementById('epi_id');
    const dataEntregaInput = document.getElementById('data_entrega');
    const dataVencimentoInput = document.getElementById('data_vencimento');

    // Mapeamento seguro usando a classe Js::from do Laravel
    const epis = {{ \Illuminate\Support\Js::from($epis) }};
    const episValidade = {};

    if (Array.isArray(epis)) {
        epis.forEach(function (epi) {
            episValidade[epi.id] = epi.validade_meses;
        });
    }

    function calcularVencimento() {
        const epiId = epiSelect.value;
        const validadeMeses = episValidade[epiId];
        const dataEntregaVal = dataEntregaInput.value;

        if (epiId && validadeMeses && dataEntregaVal) {
            const data = new Date(dataEntregaVal + 'T00:00:00');
            data.setMonth(data.getMonth() + parseInt(validadeMeses));

            const ano = data.getFullYear();
            const mes = String(data.getMonth() + 1).padStart(2, '0');
            const dia = String(data.getDate()).padStart(2, '0');

            dataVencimentoInput.value = `${ano}-${mes}-${dia}`;
        }
    }

    if (epiSelect && dataEntregaInput && dataVencimentoInput) {
        epiSelect.addEventListener('change', calcularVencimento);
        dataEntregaInput.addEventListener('change', calcularVencimento);
    }
});
</script>