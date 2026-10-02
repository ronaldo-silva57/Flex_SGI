@csrf
<div class="space-y-8">
    <div>
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-ruler-combined text-blue-500"></i>Informações do Equipamento
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @php
                $campos = [
                    ['codigo', 'Código', 'barcode', 'text', true],
                    ['nome', 'Nome', 'tag', 'text', true],
                    ['marca', 'Marca', 'copyright', 'text', false],
                    ['modelo', 'Modelo', 'cubes', 'text', false],
                    ['numero_serie', 'Nº de série', 'hashtag', 'text', false],
                    ['localizacao', 'Localização', 'map-marker-alt', 'text', false],
                    ['faixa_medicao', 'Faixa de medição', 'arrows-alt-h', 'text', false],
                    ['resolucao', 'Resolução', 'search-plus', 'text', false],
                ];
            @endphp
            @foreach($campos as [$name, $label, $icon, $type, $required])
                <div>
                    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
                        {{ $label }} @if($required)<span class="text-red-500">*</span>@endif
                    </label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-{{ $icon }} text-gray-400"></i></div>
                        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $equipamento->{$name} ?? '') }}" @if($required) required @endif
                               class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 @error($name) border-red-300 @enderror">
                    </div>
                    @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            @endforeach
        </div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center gap-2"><i class="fas fa-calendar-check text-blue-500"></i>Calibração e controle</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="periodicidade_calibracao_meses" class="block text-sm font-medium text-gray-700">Periodicidade (meses)</label>
                <div class="relative mt-1"><div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-sync-alt text-gray-400"></i></div>
                    <input type="number" min="1" max="120" id="periodicidade_calibracao_meses" name="periodicidade_calibracao_meses" value="{{ old('periodicidade_calibracao_meses', $equipamento->periodicidade_calibracao_meses ?? '') }}" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                @error('periodicidade_calibracao_meses')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="responsavel_id" class="block text-sm font-medium text-gray-700">Responsável</label>
                <div class="relative mt-1"><div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-user text-gray-400"></i></div>
                    <select id="responsavel_id" name="responsavel_id" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">—</option>
                        @foreach($responsaveis as $r)<option value="{{ $r->id }}" @selected(old('responsavel_id', $equipamento->responsavel_id ?? '') == $r->id)>{{ $r->name }}</option>@endforeach
                    </select>
                </div>
                @error('responsavel_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            @foreach(['ultima_calibracao' => 'Última calibração', 'proxima_calibracao' => 'Próxima calibração'] as $name => $label)
                <div>
                    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                    <div class="relative mt-1"><div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-calendar-alt text-gray-400"></i></div>
                        <input type="date" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, isset($equipamento) ? $equipamento->{$name}?->format('Y-m-d') : '') }}" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @error($name)<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            @endforeach
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <div class="relative mt-1"><div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><i class="fas fa-toggle-on text-gray-400"></i></div>
                    <select id="status" name="status" required class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        @foreach(['Ativo','Em manutenção','Inativo','Descartado'] as $s)<option value="{{ $s }}" @selected(old('status', $equipamento->status ?? 'Ativo') === $s)>{{ $s }}</option>@endforeach
                    </select>
                </div>
                @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>
</div>
