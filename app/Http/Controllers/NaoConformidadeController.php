<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNaoConformidadeRequest;
use App\Http\Requests\UpdateNaoConformidadeRequest;
use App\Models\Clausula;
use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\NaoConformidade;
use App\Models\Norma;
use App\Models\Processo;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class NaoConformidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $empresaId = auth()->user()->empresa_id ?? null;

        $base = NaoConformidade::query()
            ->when($empresaId, fn ($q) => $q->where('empresa_id', $empresaId));

        $contadores = (clone $base)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $vencidas = (clone $base)
            ->whereNotNull('prazo_tratamento')
            ->whereDate('prazo_tratamento', '<', Carbon::today())
            ->where('status', '<>', 'Fechada')
            ->count();

        $fechadasMes = (clone $base)
            ->where('status', 'Fechada')
            ->whereBetween('data_encerramento', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth(),
            ])
            ->count();

        $query = (clone $base)->with([
            'empresa',
            'cliente',
            'norma',
            'clausula',
            'processo',
            'responsavelApuracao',
            'responsavelTratamento',
        ]);

        // Aba de status
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Filtros secundários
        $query
            ->when($request->input('gravidade'), fn ($q, $g) => $q->where('gravidade', $g))
            ->when($request->input('origem'),    fn ($q, $o) => $q->where('origem', $o))
            ->when($request->input('apenas_vencidas'), fn ($q) => $q
                ->whereNotNull('prazo_tratamento')
                ->whereDate('prazo_tratamento', '<', Carbon::today())
                ->where('status', '<>', 'Fechada')
            )
            ->when($request->filled('search'), function ($q) use ($request) {
                $s = $request->input('search');
                $q->where(function ($w) use ($s) {
                    $w->where('codigo', 'ilike', "%{$s}%")
                      ->orWhere('titulo', 'ilike', "%{$s}%")
                      ->orWhere('descricao', 'ilike', "%{$s}%")
                      ->orWhere('origem', 'ilike', "%{$s}%")
                      ->orWhere('local_ocorrencia', 'ilike', "%{$s}%");
                });
            });

        // Ordenação: vencidas primeiro, depois mais recentes
        $query
            ->orderByRaw("
                CASE
                    WHEN prazo_tratamento IS NOT NULL
                     AND prazo_tratamento < CURRENT_DATE
                     AND status <> 'Fechada'
                    THEN 0 ELSE 1
                END
            ")
            ->latest();

        $naoConformidades = $query
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.nao_conformidades.index', compact(
            'naoConformidades',
            'contadores',
            'vencidas',
            'fechadasMes'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
public function create(): View
{
    $empresaId = auth()->user()->empresa_id ?? null;

    $empresa = $empresaId 
        ? Empresa::find($empresaId) 
        : Empresa::first();

    $clientes = Cliente::when($empresaId, fn ($q, $id) => $q->where('empresa_id', $id))
        ->orderBy('razao_social')
        ->get();

    $normas = Norma::orderBy('nome')->get();
    $clausulas = Clausula::orderBy('titulo')->get();
    $processos = Processo::orderBy('nome')->get();

    $usuarios = User::when($empresaId, fn ($q, $id) => $q->where('empresa_id', $id))
        ->orderBy('name')
        ->get();

    return view('cadastros.nao_conformidades.create', compact(
        'empresa',
        'clientes',
        'normas',
        'clausulas',
        'processos',
        'usuarios'
    ));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNaoConformidadeRequest $request): RedirectResponse
    {
        // $this->authorize('create', NaoConformidade::class);

        NaoConformidade::create($request->validated());

        return redirect()
            ->route('nao_conformidades.index')
            ->with('success', 'Não conformidade cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(NaoConformidade $naoConformidade): View
    {
        // $this->authorize('view', $naoConformidade);

        $naoConformidade->load([
            'empresa',
            'cliente',
            'norma',
            'clausula',
            'processo',
            'responsavelApuracao',
            'responsavelTratamento',

            // Hub central: carrega tudo que orbita a NC
            'analisesCausa' => fn ($q) => $q->with(['responsavel', 'ishikawa'])->latest(),
            'acoesCorretivas' => fn ($q) => $q
                ->with('responsavel')
                ->orderByRaw("
                    CASE status
                        WHEN 'Pendente'     THEN 0
                        WHEN 'Em andamento' THEN 1
                        WHEN 'Reprovada'    THEN 2
                        WHEN 'Concluída'    THEN 3
                        ELSE 4
                    END
                ")
                ->orderByRaw('prazo IS NULL, prazo ASC'),
        ]);

        // Contadores para as abas
        $totais = [
            'analises_causa'   => $naoConformidade->analisesCausa->count(),
            'acoes_corretivas' => $naoConformidade->acoesCorretivas->count(),
            'acoes_pendentes'  => $naoConformidade->acoesCorretivas
                ->whereIn('status', ['Pendente', 'Em andamento'])
                ->count(),
            'acoes_atrasadas'  => $naoConformidade->acoesCorretivas
                ->filter(fn ($a) => $a->prazo
                    && $a->prazo->isPast()
                    && !in_array($a->status, ['Concluída', 'Reprovada']))
                ->count(),
        ];

        // Timeline unificada (eventos da NC + filhos)
        $timeline = $this->montarTimeline($naoConformidade);

        return view(
            'cadastros.nao_conformidades.show',
            compact('naoConformidade', 'totais', 'timeline')
        );
    }

    /**
     * Monta uma timeline unificada ordenada por data (desc).
     */
    private function montarTimeline(NaoConformidade $nc): \Illuminate\Support\Collection
    {
        $eventos = collect();

        // Abertura
        if ($nc->data_abertura) {
            $eventos->push([
                'data'  => $nc->data_abertura,
                'tipo'  => 'abertura',
                'icone' => 'fa-flag',
                'cor'   => 'red',
                'titulo'=> 'Não conformidade aberta',
                'desc'  => $nc->titulo,
                'url'   => null,
            ]);
        }

    // Análises de causa
    foreach ($nc->analisesCausa as $a) {
        $eventos->push([
            'data'  => $a->data_inicio ?? $a->created_at,
            'tipo'  => 'analise',
            'icone' => 'fa-magnifying-glass-chart',
            'cor'   => 'purple',
            'titulo'=> "Análise de causa ({$a->metodo}) criada",
            'desc'  => $a->objetivo,
            'url' => route('analises_causa.show', $a),
        ]);

        if ($a->data_conclusao) {
            $eventos->push([
                'data'  => $a->data_conclusao,
                'tipo'  => 'analise_concluida',
                'icone' => 'fa-check',
                'cor'   => 'green',
                'titulo'=> "Análise de causa concluída",
                'desc'  => $a->conclusao,
                'url' => route('analises_causa.show', $a),
            ]);
        }
    }

    // Ações corretivas
    foreach ($nc->acoesCorretivas as $a) {
        $eventos->push([
            'data'  => $a->created_at,
            'tipo'  => 'acao',
            'icone' => 'fa-screwdriver-wrench',
            'cor'   => 'orange',
            'titulo'=> "Ação corretiva [{$a->etapa}] criada",
            'desc'  => $a->descricao,
            'url' => route('acoes_corretivas.show', $a),
        ]);

        if ($a->data_execucao) {
            $eventos->push([
                'data'  => $a->data_execucao,
                'tipo'  => 'acao_executada',
                'icone' => 'fa-circle-check',
                'cor'   => $a->eficaz ? 'green' : 'yellow',
                'titulo'=> "Ação corretiva executada",
                'desc'  => $a->eficaz ? 'Avaliada como eficaz' : 'Executada (eficácia não confirmada)',
                'url' => route('acoes_corretivas.show', $a),
            ]);
        }
    }

    // Encerramento
    if ($nc->data_encerramento) {
        $eventos->push([
            'data'  => $nc->data_encerramento,
            'tipo'  => 'encerramento',
            'icone' => 'fa-flag-checkered',
            'cor'   => 'green',
            'titulo'=> 'Não conformidade encerrada',
            'desc'  => $nc->justificativa_encerramento,
            'url'   => null,
        ]);
    }

    return $eventos
        ->sortByDesc(fn ($e) => $e['data'] instanceof \Carbon\Carbon
            ? $e['data']->timestamp
            : strtotime($e['data']))
        ->values();
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NaoConformidade $naoConformidade): View
    {
        // $this->authorize('update', $naoConformidade);

        // No form o campo empresa é readonly (usa $empresa no singular)
        $empresa = $naoConformidade->empresa
            ?? Empresa::find(auth()->user()->empresa_id ?? null);

        $clientes = Cliente::when(
                auth()->user()->empresa_id ?? null,
                fn ($q, $empresaId) => $q->where('empresa_id', $empresaId)
            )
            ->orderBy('razao_social')
            ->get();

        $normas = Norma::orderBy('nome')->get();

        $clausulas = Clausula::orderBy('titulo')->get();

        $processos = Processo::orderBy('nome')->get();

        $usuarios = User::when(
                auth()->user()->empresa_id ?? null,
                fn ($q, $empresaId) => $q->where('empresa_id', $empresaId)
            )
            ->orderBy('name')
            ->get();

        return view(
            'cadastros.nao_conformidades.edit',
            compact(
                'naoConformidade',
                'empresa',
                'clientes',
                'normas',
                'clausulas',
                'processos',
                'usuarios'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateNaoConformidadeRequest $request,
        NaoConformidade $naoConformidade
    ): RedirectResponse {
        // $this->authorize('update', $naoConformidade);

        $naoConformidade->update($request->validated());

        return redirect()
            ->route('nao_conformidades.index')
            ->with('success', 'Não conformidade atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NaoConformidade $naoConformidade): RedirectResponse
    {
        // $this->authorize('delete', $naoConformidade);

        $naoConformidade->delete();

        return redirect()
            ->route('nao_conformidades.index')
            ->with('success', 'Não conformidade removida com sucesso.');
    }

    public function montarTimelinePublica(NaoConformidade $nc): \Illuminate\Support\Collection
    {
        return $this->montarTimeline($nc);
    }
}