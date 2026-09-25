<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap justify-between items-center gap-3">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                <i class="fas fa-magnifying-glass-chart text-purple-700"></i>
                Análise de Causa
                @if($analiseCausa->naoConformidade)
                    <span class="text-sm font-mono bg-gray-100 text-gray-700 px-2 py-0.5 rounded">
                        {{ $analiseCausa->naoConformidade->codigo }}
                    </span>
                @endif
            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('analises_causa.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 border border-blue-200 transition shadow-sm">
                    <i class="fas fa-arrow-left mr-2"></i>Voltar
                </a>
                <a href="{{ route('analises_causa.edit', $analiseCausa) }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm">
                    <i class="fas fa-pen mr-2"></i>Editar dados
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6"
         x-data="{ tab: '{{ request('tab', 'resumo') }}' }">

        <x-breadcrumb :items="[
            ['label' => 'Cadastros', 'url' => route('cadastros.dashboard')],
            ['label' => 'Análises de Causa', 'url' => route('analises_causa.index')],
            ['label' => '#' . $analiseCausa->id],
        ]" />

        @if(session('success'))
            <div class="p-4 bg-green-50 border-l-4 border-green-400 text-green-700 rounded-md flex items-center shadow-sm">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- CABEÇALHO                                                          --}}
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">

            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div class="min-w-0">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2 flex-wrap">
                            <i class="fas fa-diagram-project text-purple-600"></i>
                            {{ $analiseCausa->metodo }}
                            <x-badge-status :status="$analiseCausa->status" />
                        </h3>

                        @if($analiseCausa->naoConformidade)
                            <a href="{{ route('nao_conformidades.show', $analiseCausa->naoConformidade) }}"
                               class="text-sm text-gray-600 hover:text-red-600 transition mt-2 inline-flex items-center gap-2">
                                <i class="fas fa-link text-gray-400"></i>
                                <span class="font-mono">{{ $analiseCausa->naoConformidade->codigo }}</span>
                                <span class="text-gray-400">·</span>
                                <span>{{ Str::limit($analiseCausa->naoConformidade->titulo, 70) }}</span>
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        @endif
                    </div>
                    <div class="text-right text-sm text-gray-500">
                        <div>Responsável</div>
                        <div class="font-semibold text-gray-800">
                            {{ $analiseCausa->responsavel->name ?? 'Não atribuído' }}
                        </div>
                    </div>
                </div>

                {{-- Métricas --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-5">
                    <div class="p-3 rounded-md bg-purple-50 border border-purple-100">
                        <div class="text-xs uppercase text-purple-600 font-medium">5 Porquês</div>
                        <div class="text-lg font-bold text-purple-800">{{ $totais['respostas'] }}</div>
                        <div class="text-xs text-purple-600">
                            {{ $totais['causas_raiz_5p'] }} marcada(s) como raiz
                        </div>
                    </div>
                    <div class="p-3 rounded-md bg-indigo-50 border border-indigo-100">
                        <div class="text-xs uppercase text-indigo-600 font-medium">Ishikawa</div>
                        <div class="text-lg font-bold text-indigo-800">{{ $totais['causas_ishikawa'] }}</div>
                        <div class="text-xs text-indigo-600">
                            {{ $totais['raiz_ishikawa'] }} causa(s) raiz
                        </div>
                    </div>
                    <div class="p-3 rounded-md bg-gray-50 border border-gray-100">
                        <div class="text-xs uppercase text-gray-500 font-medium">Início</div>
                        <div class="text-sm font-semibold text-gray-800 mt-1">
                            {{ $analiseCausa->data_inicio?->format('d/m/Y') ?? '—' }}
                        </div>
                    </div>
                    <div class="p-3 rounded-md bg-gray-50 border border-gray-100">
                        <div class="text-xs uppercase text-gray-500 font-medium">Conclusão</div>
                        <div class="text-sm font-semibold text-gray-800 mt-1">
                            {{ $analiseCausa->data_conclusao?->format('d/m/Y') ?? '—' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ABAS --}}

            <nav class="flex flex-wrap border-b border-gray-200 bg-gray-50/50" role="tablist">
                @php
                    $tabs = [
                        'resumo'   => ['Resumo',     'fa-circle-info',              null],
                        'porques'  => ['5 Porquês',  'fa-list-ol',                  $totais['respostas']],
                        'ishikawa' => ['Ishikawa',   'fa-fish-fins',                $totais['causas_ishikawa']],
                    ];
                @endphp
                @foreach($tabs as $key => [$label, $icon, $count])
                    <button type="button" role="tab" @click="tab = '{{ $key }}'"
                            :class="tab === '{{ $key }}'
                                ? 'border-purple-600 text-purple-700 bg-white'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-white/60'"
                            class="px-4 py-3 text-sm font-medium border-b-2 transition inline-flex items-center gap-2">
                        <i class="fas {{ $icon }} text-xs"></i>
                        {{ $label }}
                        @if(!is_null($count) && $count > 0)
                            <span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full font-semibold">
                                {{ $count }}
                            </span>
                        @endif
                    </button>
                @endforeach
            </nav>

            {{-- ABA 1: RESUMO --}}
            <div x-show="tab === 'resumo'" x-transition.opacity class="p-6">
                <form action="{{ route('analises_causa.update', $analiseCausa) }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Método <span class="text-red-500">*</span></label>
                            <input type="text" name="metodo" value="{{ old('metodo', $analiseCausa->metodo) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500"
                                   required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Responsável</label>
                            <select name="responsavel_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                <option value="">— Selecione —</option>
                                @foreach($usuarios as $u)
                                    <option value="{{ $u->id }}"
                                        @selected(old('responsavel_id', $analiseCausa->responsavel_id) == $u->id)>
                                        {{ $u->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                @foreach(['Em andamento', 'Concluída', 'Cancelada'] as $s)
                                    <option value="{{ $s }}"
                                        @selected(old('status', $analiseCausa->status) === $s)>{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">NC vinculada</label>
                            <select name="nao_conformidade_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                                @foreach(\App\Models\NaoConformidade::orderBy('codigo')->limit(200)->get() as $nc)
                                    <option value="{{ $nc->id }}"
                                        @selected(old('nao_conformidade_id', $analiseCausa->nao_conformidade_id) == $nc->id)>
                                        {{ $nc->codigo }} — {{ Str::limit($nc->titulo, 60) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data de início</label>
                            <input type="date" name="data_inicio"
                                   value="{{ old('data_inicio', $analiseCausa->data_inicio?->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data de conclusão</label>
                            <input type="date" name="data_conclusao"
                                   value="{{ old('data_conclusao', $analiseCausa->data_conclusao?->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Objetivo</label>
                        <textarea name="objetivo" rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500"
                                  placeholder="O que se pretende descobrir com esta análise?">{{ old('objetivo', $analiseCausa->objetivo) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Conclusão</label>
                        <textarea name="conclusao" rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500"
                                  placeholder="Causa raiz identificada e justificativa...">{{ old('conclusao', $analiseCausa->conclusao) }}</textarea>
                    </div>

                    <div class="flex justify-end pt-4 border-t">
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 shadow-sm">
                            <i class="fas fa-save mr-2"></i>Salvar alterações
                        </button>
                    </div>
                </form>
            </div>

            {{-- ABA 2: 5 PORQUÊS (inline editing) --}}
            <div x-show="tab === 'porques'" x-transition.opacity class="p-6"
                 x-data="cincoPorques(@js($analiseCausa->respostas->map(fn($r) => [
                    'id'            => $r->id,
                    'pergunta'      => $r->pergunta,
                    'resposta'      => $r->resposta,
                    'evidencia'     => $r->evidencia,
                    'eh_causa_raiz' => (bool) $r->eh_causa_raiz,
                 ])->values()))">

                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h4 class="text-base font-semibold text-gray-800 flex items-center gap-2">
                            <i class="fas fa-list-ol text-purple-500"></i> Técnica dos 5 Porquês
                        </h4>
                        <p class="text-sm text-gray-500 mt-1">
                            Pergunte "Por quê?" sucessivamente até chegar à causa raiz. Marque a linha que identificou a raiz.
                        </p>
                    </div>
                    <button type="button" @click="adicionar()"
                            class="inline-flex items-center px-3 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition shadow-sm text-sm">
                        <i class="fas fa-plus mr-2"></i>Adicionar porquê
                    </button>
                </div>

                <form action="{{ route('analises_causa.sync.respostas', $analiseCausa) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="overflow-x-auto border border-gray-200 rounded-lg">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-12 px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pergunta</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Resposta</th>
                                    <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Evidência</th>
                                    <th class="w-24 px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Causa raiz?</th>
                                    <th class="w-12 px-3 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                <template x-for="(r, i) in respostas" :key="r.uid">
                                    <tr class="hover:bg-purple-50/40 transition">
                                        <td class="px-3 py-2 align-top text-center">
                                            <span class="inline-flex w-7 h-7 items-center justify-center rounded-full bg-purple-100 text-purple-700 font-semibold text-sm"
                                                  x-text="i + 1"></span>
                                            <input type="hidden" :name="`respostas[${i}][id]`" :value="r.id ?? ''">
                                        </td>
                                        <td class="px-3 py-2 align-top">
                                            <input type="text" :name="`respostas[${i}][pergunta]`"
                                                   x-model="r.pergunta"
                                                   class="w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 text-sm"
                                                   placeholder="Por que ... ?" required>
                                        </td>
                                        <td class="px-3 py-2 align-top">
                                            <textarea :name="`respostas[${i}][resposta]`" x-model="r.resposta" rows="2"
                                                      class="w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 text-sm"
                                                      placeholder="Resposta..." required></textarea>
                                        </td>
                                        <td class="px-3 py-2 align-top">
                                            <textarea :name="`respostas[${i}][evidencia]`" x-model="r.evidencia" rows="2"
                                                      class="w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500 text-sm"
                                                      placeholder="Link, doc, registro..."></textarea>
                                        </td>
                                        <td class="px-3 py-2 align-top text-center">
                                            <input type="hidden" :name="`respostas[${i}][eh_causa_raiz]`" :value="r.eh_causa_raiz ? 1 : 0">
                                            <input type="checkbox" x-model="r.eh_causa_raiz"
                                                   class="rounded border-gray-300 text-purple-600 focus:ring-purple-500 h-5 w-5">
                                        </td>
                                        <td class="px-3 py-2 align-top text-center">
                                            <button type="button" @click="remover(i)"
                                                    class="p-2 text-red-500 hover:bg-red-50 rounded-md transition"
                                                    title="Remover linha">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </template>

                                <tr x-show="respostas.length === 0">
                                    <td colspan="6" class="text-center py-12 text-gray-400">
                                        <i class="fas fa-list-ol text-4xl block mb-2"></i>
                                        Nenhum porquê cadastrado.
                                        <button type="button" @click="adicionar()"
                                                class="text-purple-600 hover:underline ml-1 font-medium">
                                            Adicionar o primeiro
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-wrap justify-between items-center mt-5 pt-4 border-t gap-3">
                        <div class="text-xs text-gray-500">
                            <span x-text="respostas.length"></span>
                            porquê(s) ·
                            <span class="text-purple-700 font-semibold"
                                  x-text="respostas.filter(r => r.eh_causa_raiz).length"></span>
                            marcado(s) como causa raiz
                        </div>
                        <div class="flex gap-2">
                            <button type="button" @click="adicionar()"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition text-sm">
                                <i class="fas fa-plus mr-2"></i>Linha
                            </button>
                            <button type="submit"
                                    class="inline-flex items-center px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 shadow-sm">
                                <i class="fas fa-save mr-2"></i>Salvar 5 Porquês
                            </button>
                        </div>
                    </div>
                </form>
            </div>


            {{-- ABA 3: ISHIKAWA --}}

            <div x-show="tab === 'ishikawa'" x-transition.opacity class="p-6"
                 x-data="ishikawa(
                    @js($analiseCausa->ishikawa?->causas->map(fn($c) => [
                        'id'                        => $c->id,
                        'categoria'                 => $c->categoria,
                        'descricao'                 => $c->descricao,
                        'evidencia'                 => $c->evidencia,
                        'confirmada'                => (bool) $c->confirmada,
                        'causa_raiz'                => (bool) $c->causa_raiz,
                        'responsavel_validacao_id'  => $c->responsavel_validacao_id,
                    ])->values() ?? []),
                    @js($categoriasIshikawa)
                 )">

                <form action="{{ route('analises_causa.sync.ishikawa', $analiseCausa) }}" method="POST" class="space-y-6">
                    @csrf @method('PUT')

                    {{-- Cabeçalho do Ishikawa --}}
                    <div class="p-4 rounded-lg border border-indigo-100 bg-indigo-50/40">
                        <h4 class="text-base font-semibold text-indigo-900 flex items-center gap-2 mb-3">
                            <i class="fas fa-fish-fins text-indigo-600"></i> Diagrama de Ishikawa (Espinha de Peixe)
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Efeito analisado <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="efeito_analisado" required
                                       value="{{ old('efeito_analisado', $analiseCausa->ishikawa?->efeito_analisado ?? $analiseCausa->naoConformidade->titulo ?? '') }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="Problema que está sendo analisado">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Responsável pelo diagrama</label>
                                <select name="responsavel_ishikawa_id"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">— Selecione —</option>
                                    @foreach($usuarios as $u)
                                        <option value="{{ $u->id }}"
                                            @selected(old('responsavel_ishikawa_id', $analiseCausa->ishikawa?->responsavel_id) == $u->id)>
                                            {{ $u->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Data de início</label>
                                    <input type="date" name="ishikawa_data_inicio"
                                           value="{{ old('ishikawa_data_inicio', $analiseCausa->ishikawa?->data_inicio?->format('Y-m-d')) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Data de conclusão</label>
                                    <input type="date" name="ishikawa_data_conclusao"
                                           value="{{ old('ishikawa_data_conclusao', $analiseCausa->ishikawa?->data_conclusao?->format('Y-m-d')) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Conclusão do diagrama</label>
                                <textarea name="ishikawa_conclusao" rows="3"
                                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Causa raiz identificada a partir do diagrama...">{{ old('ishikawa_conclusao', $analiseCausa->ishikawa?->conclusao) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Lista de causas --}}
                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                            <h5 class="text-sm font-semibold text-gray-700 uppercase tracking-wide flex items-center gap-2">
                                <i class="fas fa-list-ul text-indigo-500"></i> Causas identificadas
                            </h5>
                            <button type="button" @click="adicionar()"
                                    class="inline-flex items-center px-3 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition shadow-sm text-sm">
                                <i class="fas fa-plus mr-2"></i>Adicionar causa
                            </button>
                        </div>

                        {{-- Agrupamento visual por categoria --}}
                        <div class="space-y-4">
                            <template x-for="cat in categorias" :key="cat">
                                <div x-show="causasPorCategoria(cat).length > 0"
                                     class="border border-gray-200 rounded-lg overflow-hidden">
                                    <div class="px-4 py-2 bg-gray-50 border-b border-gray-200 flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full"
                                              :class="corCategoria(cat)"></span>
                                        <span class="text-sm font-semibold text-gray-700" x-text="cat"></span>
                                        <span class="text-xs bg-gray-200 text-gray-600 px-2 py-0.5 rounded-full"
                                              x-text="causasPorCategoria(cat).length"></span>
                                    </div>
                                    <div class="divide-y divide-gray-100">
                                        <template x-for="c in causasPorCategoria(cat)" :key="c.uid">
                                            <div class="p-4 hover:bg-gray-50/50 transition">
                                                <input type="hidden" :name="`causas[${indexGlobal(c)}][id]`" :value="c.id ?? ''">
                                                <input type="hidden" :name="`causas[${indexGlobal(c)}][categoria]`" :value="c.categoria">
                                                <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                                                    <div class="md:col-span-6">
                                                        <textarea :name="`causas[${indexGlobal(c)}][descricao]`"
                                                                  x-model="c.descricao" rows="2"
                                                                  class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                                  placeholder="Descrição da causa..." required></textarea>
                                                    </div>
                                                    <div class="md:col-span-3">
                                                        <textarea :name="`causas[${indexGlobal(c)}][evidencia]`"
                                                                  x-model="c.evidencia" rows="2"
                                                                  class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                                                                  placeholder="Evidência"></textarea>
                                                    </div>
                                                    <div class="md:col-span-3 space-y-2">
                                                        <select :name="`causas[${indexGlobal(c)}][responsavel_validacao_id]`"
                                                                x-model="c.responsavel_validacao_id"
                                                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                                            <option value="">Validador...</option>
                                                            @foreach($usuarios as $u)
                                                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="flex flex-wrap gap-3 text-xs">
                                                            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                                                <input type="hidden" :name="`causas[${indexGlobal(c)}][confirmada]`" :value="c.confirmada ? 1 : 0">
                                                                <input type="checkbox" x-model="c.confirmada"
                                                                       class="rounded border-gray-300 text-green-600 focus:ring-green-500 h-4 w-4">
                                                                <span class="text-gray-700">Confirmada</span>
                                                            </label>
                                                            <label class="inline-flex items-center gap-1.5 cursor-pointer">
                                                                <input type="hidden" :name="`causas[${indexGlobal(c)}][causa_raiz]`" :value="c.causa_raiz ? 1 : 0">
                                                                <input type="checkbox" x-model="c.causa_raiz"
                                                                       class="rounded border-gray-300 text-red-600 focus:ring-red-500 h-4 w-4">
                                                                <span class="text-gray-700 font-medium">Causa raiz</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex justify-end mt-2">
                                                    <button type="button" @click="remover(c.uid)"
                                                            class="text-xs text-red-600 hover:text-red-800 inline-flex items-center gap-1">
                                                        <i class="fas fa-trash-alt"></i> Remover
                                                    </button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            {{-- Estado vazio --}}
                            <div x-show="causas.length === 0"
                                 class="text-center py-12 border-2 border-dashed border-gray-200 rounded-lg">
                                <i class="fas fa-fish-fins text-4xl text-gray-300"></i>
                                <p class="mt-3 text-gray-600 font-medium">Nenhuma causa adicionada ainda.</p>
                                <p class="text-sm text-gray-500 mt-1">
                                    Adicione causas para cada categoria (Método, Máquina, Material, etc.).
                                </p>
                                <button type="button" @click="adicionar()"
                                        class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 shadow-sm">
                                    <i class="fas fa-plus mr-2"></i>Adicionar primeira causa
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap justify-between items-center pt-4 border-t gap-3">
                        <div class="text-xs text-gray-500">
                            <span x-text="causas.length"></span> causa(s) ·
                            <span class="text-red-600 font-semibold"
                                  x-text="causas.filter(c => c.causa_raiz).length"></span>
                            marcada(s) como raiz
                        </div>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 shadow-sm">
                            <i class="fas fa-save mr-2"></i>Salvar Ishikawa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ALPINE COMPONENTS --}}
    @push('scripts')
    <script>
        function cincoPorques(iniciais) {
            let uid = 0;
            const normaliza = (arr) => arr.map(r => ({ ...r, uid: ++uid }));

            return {
                respostas: normaliza(iniciais || []),
                adicionar() {
                    const n = this.respostas.length;
                    this.respostas.push({
                        uid: ++uid,
                        id: null,
                        pergunta: `${n + 1}º Por quê?`,
                        resposta: '',
                        evidencia: '',
                        eh_causa_raiz: false,
                    });
                },
                remover(i) {
                    if (confirm('Remover esta linha?')) {
                        this.respostas.splice(i, 1);
                    }
                },
            };
        }

        function ishikawa(iniciais, categorias) {
            let uid = 0;
            const normaliza = (arr) => arr.map(c => ({ ...c, uid: ++uid }));

            return {
                causas: normaliza(iniciais || []),
                categorias: categorias,

                adicionar() {
                    this.causas.push({
                        uid: ++uid,
                        id: null,
                        categoria: this.categorias[0],
                        descricao: '',
                        evidencia: '',
                        confirmada: false,
                        causa_raiz: false,
                        responsavel_validacao_id: '',
                    });
                },
                remover(uid) {
                    if (confirm('Remover esta causa?')) {
                        this.causas = this.causas.filter(c => c.uid !== uid);
                    }
                },
                causasPorCategoria(cat) {
                    return this.causas.filter(c => c.categoria === cat);
                },
                // Retorna o índice real no array global (para os name="" dos inputs)
                indexGlobal(c) {
                    return this.causas.findIndex(x => x.uid === c.uid);
                },
                corCategoria(cat) {
                    const cores = {
                        'Método':         'bg-blue-500',
                        'Mão de obra':    'bg-green-500',
                        'Máquina':        'bg-purple-500',
                        'Material':       'bg-orange-500',
                        'Medição':        'bg-yellow-500',
                        'Meio ambiente':  'bg-teal-500',
                        'Gestão':         'bg-indigo-500',
                        'Informação':     'bg-pink-500',
                    };
                    return cores[cat] || 'bg-gray-400';
                },
            };
        }
    </script>
    @endpush
</x-app-layout>