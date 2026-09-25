<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnaliseCausaRequest;
use App\Http\Requests\UpdateAnaliseCausaRequest;
use App\Models\AnaliseCausa;
use App\Models\NaoConformidade;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnaliseCausaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = AnaliseCausa::with(['naoConformidade', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('metodo', 'ilike', "%{$search}%")
                  ->orWhere('status', 'ilike', "%{$search}%")
                  ->orWhere('objetivo', 'ilike', "%{$search}%");
            });
        }

        $analises = $query->latest()
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.analises_causa.index', compact('analises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $ncPreSelecionada = $request->filled('nao_conformidade_id')
            ? NaoConformidade::find($request->input('nao_conformidade_id'))
            : null;

        $naoConformidades = $ncPreSelecionada
            ? collect()
            : NaoConformidade::orderByDesc('created_at')
                ->limit(100)
                ->get(['id', 'codigo', 'titulo']);

        $usuarios = User::orderBy('name')->get();

        return view('cadastros.analises_causa.create',
            compact('naoConformidades', 'usuarios', 'ncPreSelecionada'));
    }

   /** Store a newly created resource in storage.
     */
    public function store(StoreAnaliseCausaRequest $request): RedirectResponse
    {
        $analise = AnaliseCausa::create($request->validated());

        return redirect()
            ->route('analises_causa.show', $analise)
            ->with('success', 'Análise de Causa criada. Agora preencha os 5 Porquês ou o Ishikawa.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnaliseCausa $analiseCausa): View
    {
        $analiseCausa->load([
            'naoConformidade.empresa',
            'naoConformidade.cliente',
            'naoConformidade.norma',
            'responsavel',
            'respostas' => fn ($q) => $q->orderBy('ordem'),
            'ishikawa.responsavel',
            'ishikawa.causas' => fn ($q) => $q->orderBy('categoria')->orderBy('id'),
            'ishikawa.causas.responsavelValidacao',
        ]);

        $usuarios = User::orderBy('name')->get();

        // Estatísticas rápidas
        $totais = [
            'respostas'      => $analiseCausa->respostas->count(),
            'causas_raiz_5p' => $analiseCausa->respostas->where('eh_causa_raiz', true)->count(),
            'causas_ishikawa'=> $analiseCausa->ishikawa?->causas->count() ?? 0,
            'raiz_ishikawa'  => $analiseCausa->ishikawa?->causas->where('causa_raiz', true)->count() ?? 0,
        ];

        // Categorias padrão para o select do Ishikawa
        $categoriasIshikawa = [
            'Método', 'Mão de obra', 'Máquina', 'Material',
            'Medição', 'Meio ambiente', 'Gestão', 'Informação',
        ];

        return view('cadastros.analises_causa.show', compact(
            'analiseCausa', 'usuarios', 'totais', 'categoriasIshikawa'
        ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnaliseCausa $analiseCausa): View
    {
        $naoConformidades = NaoConformidade::orderBy('codigo')->get();
        $usuarios = User::orderBy('name')->get();

        return view('cadastros.analises_causa.edit',
            compact('analiseCausa', 'naoConformidades', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnaliseCausaRequest $request, AnaliseCausa $analiseCausa): RedirectResponse
    {
        $analiseCausa->update($request->validated());

        return redirect()
            ->route('analises_causa.show', ['analiseCausa' => $analiseCausa, 'tab' => 'resumo'])
            ->with('success', 'Análise atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnaliseCausa $analiseCausa): RedirectResponse
    {
        $analiseCausa->delete();

        return redirect()
            ->route('analises_causa.index')
            ->with('success', 'Análise de Causa removida com sucesso.');
    }


    // =====================================================================
    // INLINE EDITING
    // =====================================================================

    /**
     * Sincroniza a lista completa de respostas (5 Porquês).
     * Recebe o array completo — atualiza, cria e remove o que não veio.
     */
    public function syncRespostas(Request $request, AnaliseCausa $analiseCausa): RedirectResponse
    {
        $data = $request->validate([
            'respostas'                    => 'array',
            'respostas.*.id'               => 'nullable|integer|exists:analise_causa_respostas,id',
            'respostas.*.pergunta'         => 'required|string|max:255',
            'respostas.*.resposta'         => 'required|string',
            'respostas.*.evidencia'        => 'nullable|string',
            'respostas.*.eh_causa_raiz'    => 'boolean',
        ]);

        DB::transaction(function () use ($analiseCausa, $data) {
            $idsEnviados = collect($data['respostas'] ?? [])
                ->pluck('id')
                ->filter()
                ->all();

            // Remove os que não vieram no payload
            $analiseCausa->respostas()
                ->whereNotIn('id', $idsEnviados)
                ->delete();

            // Offset temporário para evitar conflito do unique(analise_causa_id, ordem)
            $analiseCausa->respostas()->update([
                'ordem' => DB::raw('ordem + 10000'),
            ]);

            foreach ($data['respostas'] ?? [] as $i => $r) {
                $payload = [
                    'ordem'         => $i + 1,
                    'pergunta'      => $r['pergunta'],
                    'resposta'      => $r['resposta'],
                    'evidencia'     => $r['evidencia'] ?? null,
                    'eh_causa_raiz' => !empty($r['eh_causa_raiz']),
                ];

                if (!empty($r['id'])) {
                    $analiseCausa->respostas()
                        ->where('id', $r['id'])
                        ->update($payload);
                } else {
                    $analiseCausa->respostas()->create($payload);
                }
            }
        });

        return redirect()
            ->route('analises_causa.show', [
                'analiseCausa' => $analiseCausa,
                'tab'          => 'porques',
            ])
            ->with('success', '5 Porquês salvos com sucesso.');
    }

    /**
     * Sincroniza Ishikawa (cabeçalho + causas).
     * Cria o Ishikawa na primeira gravação (upsert).
     */
    public function syncIshikawa(Request $request, AnaliseCausa $analiseCausa): RedirectResponse
    {
        $data = $request->validate([
            'efeito_analisado'         => 'required|string|max:255',
            'ishikawa_conclusao'       => 'nullable|string',
            'responsavel_ishikawa_id'  => 'nullable|integer|exists:users,id',
            'ishikawa_data_inicio'     => 'nullable|date',
            'ishikawa_data_conclusao'  => 'nullable|date',

            'causas'                          => 'array',
            'causas.*.id'                     => 'nullable|integer|exists:ishikawa_causas,id',
            'causas.*.categoria'              => 'required|string|max:40',
            'causas.*.descricao'              => 'required|string',
            'causas.*.evidencia'              => 'nullable|string',
            'causas.*.confirmada'             => 'boolean',
            'causas.*.causa_raiz'             => 'boolean',
            'causas.*.responsavel_validacao_id' => 'nullable|integer|exists:users,id',
        ]);

        DB::transaction(function () use ($analiseCausa, $data) {
            // Cabeçalho do Ishikawa (cria na primeira vez)
            $ishikawa = $analiseCausa->ishikawa()->updateOrCreate(
                ['analise_causa_id' => $analiseCausa->id],
                [
                    'efeito_analisado' => $data['efeito_analisado'],
                    'conclusao'        => $data['ishikawa_conclusao'] ?? null,
                    'responsavel_id'   => $data['responsavel_ishikawa_id'] ?? auth()->id(),
                    'data_inicio'      => $data['ishikawa_data_inicio'] ?? null,
                    'data_conclusao'   => $data['ishikawa_data_conclusao'] ?? null,
                ]
            );

            $idsEnviados = collect($data['causas'] ?? [])
                ->pluck('id')
                ->filter()
                ->all();

            $ishikawa->causas()->whereNotIn('id', $idsEnviados)->delete();

            foreach ($data['causas'] ?? [] as $c) {
                $payload = [
                    'categoria'                => $c['categoria'],
                    'descricao'                => $c['descricao'],
                    'evidencia'                => $c['evidencia'] ?? null,
                    'confirmada'               => !empty($c['confirmada']),
                    'causa_raiz'               => !empty($c['causa_raiz']),
                    'responsavel_validacao_id' => $c['responsavel_validacao_id'] ?? auth()->id(),
                ];

                if (!empty($c['id'])) {
                    $ishikawa->causas()->where('id', $c['id'])->update($payload);
                } else {
                    $ishikawa->causas()->create($payload);
                }
            }
        });

        return redirect()
            ->route('analises_causa.show', [
                'analiseCausa' => $analiseCausa,
                'tab'          => 'ishikawa',
            ])
            ->with('success', 'Diagrama de Ishikawa salvo com sucesso.');
    }
}

