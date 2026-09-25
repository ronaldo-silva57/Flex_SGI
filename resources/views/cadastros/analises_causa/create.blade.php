<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nova Análise de Causa
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <form method="POST" action="{{ route('analises_causa.store') }}">
                @csrf
                @if($ncPreSelecionada)
                    <div class="mb-4 p-3 bg-orange-50 border border-orange-200 rounded-md">
                        <strong>Vinculada à NC:</strong>
                        {{ $ncPreSelecionada->codigo }} — {{ $ncPreSelecionada->titulo }}
                    </div>
                    <input type="hidden" name="nao_conformidade_id" value="{{ $ncPreSelecionada->id }}">
                @else
                    {{-- Select para escolher a NC --}}
                    <div class="mb-4">
                        <label for="nao_conformidade_id" class="block text-sm font-medium text-gray-700">
                            Não Conformidade <span class="text-red-500">*</span>
                        </label>
                        <select id="nao_conformidade_id" name="nao_conformidade_id"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500"
                                required>
                            <option value="">Selecione...</option>
                            @foreach($naoConformidades as $nc)
                                <option value="{{ $nc->id }}" {{ old('nao_conformidade_id') == $nc->id ? 'selected' : '' }}>
                                    {{ $nc->codigo }} — {{ Str::limit($nc->titulo, 60) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                {{-- Responsável --}}
                <div class="mb-4">
                    <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                    <select id="responsavel_id" name="responsavel_id"
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500">
                        <option value="">Selecione...</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('responsavel_id') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Método --}}
                <div class="mb-4">
                    <label for="metodo" class="block text-sm font-medium text-gray-700">Método</label>
                    <input type="text" id="metodo" name="metodo"
                           value="{{ old('metodo') }}"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>

                {{-- Objetivo --}}
                <div class="mb-4">
                    <label for="objetivo" class="block text-sm font-medium text-gray-700">Objetivo</label>
                    <textarea id="objetivo" name="objetivo" rows="3"
                              class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500">{{ old('objetivo') }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
