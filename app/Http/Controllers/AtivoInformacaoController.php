<?php

namespace App\Http\Controllers;

use App\Models\AnaliseRiscoTI;
use App\Models\AtivoInformacao;
use App\Models\Empresa;
use App\Models\User;
use App\Http\Requests\StoreAnaliseRiscoTIRequest;
use App\Http\Requests\UpdateAnaliseRiscoTIRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AtivoInformacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $empresaId = $request->user()->empresa_id;

        $query = AnaliseRiscoTI::query()
            ->with(['ativo', 'responsavel'])
            ->where('empresa_id', $empresaId);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('ameaca', 'ilike', "%{$search}%")
                    ->orWhere('vulnerabilidade', 'ilike', "%{$search}%")
                    ->orWhereHas('ativo', function ($ativoQuery) use ($search) {
                        $ativoQuery->where('nome', 'ilike', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $analises = $query
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view(
            'iso27001.analises_risco_ti.index',
            compact('analises')
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $empresa = Empresa::find($request->user()->empresa_id);

        $ativos = AtivoInformacao::query()
            ->where('empresa_id', $request->user()->empresa_id)
            ->where('status', 'Ativo')
            ->orderBy('nome')
            ->get();

        $usuarios = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view(
            'iso27001.analises_risco_ti.create',
            compact('empresa', 'ativos', 'usuarios')
        );
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreAnaliseRiscoTIRequest $request
    ): RedirectResponse {

        $dados = $request->validated();

        if (empty($dados['responsavel_id'])) {
            $dados['responsavel_id'] = Auth::id();
        }

        $dados['empresa_id'] = $request->user()->empresa_id;

        AnaliseRiscoTI::create($dados);

        return redirect()
            ->route('analises_risco_ti.index')
            ->with(
                'success',
                'Análise de risco de TI criada com sucesso.'
            );
    }
    /**
     * Display the specified resource.
     */
    public function show(
        AnaliseRiscoTI $analisesRiscoTi
    ): View {

        $analisesRiscoTi->load([
            'empresa',
            'ativo',
            'responsavel',
        ]);

        return view(
            'iso27001.analises_risco_ti.show',
            compact('analisesRiscoTi')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        AnaliseRiscoTI $analisesRiscoTi
    ): View {

        $empresa = Empresa::find($analisesRiscoTi->empresa_id);

        $ativos = AtivoInformacao::query()
            ->where('empresa_id', $analisesRiscoTi->empresa_id)
            ->orderBy('nome')
            ->get();

        $usuarios = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view(
            'iso27001.analises_risco_ti.edit',
            compact(
                'analisesRiscoTi',
                'empresa',
                'ativos',
                'usuarios'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateAnaliseRiscoTIRequest $request,
        AnaliseRiscoTI $analisesRiscoTi
    ): RedirectResponse {

        $dados = $request->validated();

        // Mantém a empresa original.
        $dados['empresa_id'] = $analisesRiscoTi->empresa_id;

        $analisesRiscoTi->update($dados);

        return redirect()
            ->route('analises_risco_ti.index')
            ->with(
                'success',
                'Análise de risco de TI atualizada com sucesso.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        AnaliseRiscoTI $analisesRiscoTi
    ): RedirectResponse {

        $analisesRiscoTi->delete();

        return redirect()
            ->route('analises_risco_ti.index')
            ->with(
                'success',
                'Análise de risco de TI excluída com sucesso.'
            );
    }
}
