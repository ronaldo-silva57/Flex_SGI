@php
    $ncPreSelecionada = $ncPreSelecionada ?? null;
@endphp

@if($ncPreSelecionada)
    {{-- Contexto bloqueado, mostra a NC vinculada --}}
    <div class="mb-4 flex items-center gap-3 p-3 bg-orange-50 border border-orange-200 rounded-md">
        <i class="fas fa-link text-orange-500"></i>
        <div class="text-sm text-orange-900">
            Vinculada à NC
            <strong class="font-mono">{{ $ncPreSelecionada->codigo }}</strong>
            — {{ Str::limit($ncPreSelecionada->titulo, 60) }}
        </div>
    </div>
    <input type="hidden" name="nao_conformidade_id" value="{{ $ncPreSelecionada->id }}">
@else
    {{-- Select normal --}}
    <div class="w-full mb-4">
        <label for="nao_conformidade_id" class="block text-sm font-medium text-gray-700">
            Não Conformidade <span class="text-red-500">*</span>
        </label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-exclamation-triangle text-gray-400"></i>
            </div>
            <select id="nao_conformidade_id" name="nao_conformidade_id"
                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500"
                required>
                <option value="">Selecione a não conformidade...</option>
                @foreach($naoConformidades as $nc)
                    <option value="{{ $nc->id }}"
                        {{ old('nao_conformidade_id', $acaoCorretiva->nao_conformidade_id ?? '') == $nc->id ? 'selected' : '' }}>
                        {{ $nc->codigo }} — {{ Str::limit($nc->titulo, 60) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
@endif

@if($ncPreSelecionada)
    {{-- contexto já definido, não deixa o usuário errar --}}
    <div class="flex items-center gap-3 p-3 bg-orange-50 border border-orange-200 rounded-md">
        <i class="fas fa-link text-orange-500"></i>
        <span class="text-sm text-orange-900">
            Ação vinculada à NC <strong>{{ $ncPreSelecionada->codigo }}</strong> — {{ $ncPreSelecionada->titulo }}
        </span>
    </div>
    <input type="hidden" name="nao_conformidade_id" value="{{ $ncPreSelecionada->id }}">
@else
    {{-- fallback: select com busca (ver item 4) --}}
@endif