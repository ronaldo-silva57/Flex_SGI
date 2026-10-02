<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-clipboard-check text-blue-600"></i>
                Nova Calibração
            </h2>
            <a href="{{ route('calibracoes.index') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition">
                <i class="fas fa-arrow-left mr-2"></i>Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 text-red-700 rounded-md">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('calibracoes.store') }}" method="POST"
              enctype="multipart/form-data"
              class="bg-white p-6 rounded-lg shadow-sm space-y-5">
            @csrf

            {{-- Equipamento (substitui o antigo $equipamento do binding) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Equipamento *</label>
                <select name="equipamento_id" required
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">— Selecione —</option>
                    @foreach($equipamentos as $eq)
                        <option value="{{ $eq->id }}" @selected(old('equipamento_id') == $eq->id)>
                            {{ $eq->codigo }} — {{ $eq->nome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data da calibração *</label>
                    <input type="date" name="data_calibracao" required
                           value="{{ old('data_calibracao', now()->format('Y-m-d')) }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Data de validade *</label>
                    <input type="date" name="data_validade" required
                           value="{{ old('data_validade') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Laboratório</label>
                    <input type="text" name="laboratorio" value="{{ old('laboratorio') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nº do certificado</label>
                    <input type="text" name="certificado_numero" value="{{ old('certificado_numero') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Resultado *</label>
                <select name="resultado" required
                        class="block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">— Selecione —</option>
                    @foreach(['Aprovado','Aprovado com restrição','Reprovado'] as $r)
                        <option value="{{ $r }}" @selected(old('resultado') === $r)>{{ $r }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Responsável</label>
                <select name="responsavel_id" class="block w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">— Padrão: usuário logado —</option>
                    @foreach($responsaveis as $u)
                        <option value="{{ $u->id }}" @selected(old('responsavel_id') == $u->id)>{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Certificado (PDF)</label>
                <input type="file" name="certificado" accept="application/pdf"
                       class="block w-full text-sm text-gray-700">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Observações</label>
                <textarea name="observacoes" rows="3"
                          class="block w-full rounded-md border-gray-300 shadow-sm">{{ old('observacoes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('calibracoes.index') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                    <i class="fas fa-save mr-2"></i>Salvar
                </button>
            </div>
        </form>
    </div>
</x-app-layout>