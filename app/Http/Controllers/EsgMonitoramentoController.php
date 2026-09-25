<?php

namespace App\Http\Controllers;

use App\Models\EsgIndicador;
use App\Models\EsgMonitoramento;
use App\Models\Empresa;
use App\Models\User;
use App\Http\Requests\StoreEsgMonitoramentoRequest;
use App\Http\Requests\UpdateEsgMonitoramentoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EsgMonitoramentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EsgMonitoramento::with(['indicador', 'responsavel']);

        // Filtro por indicador (pesquisa no nome/código)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('indicador', function ($q) use ($search) {
                $q->where('nome', 'ilike', "%{$search}%")
                  ->orWhere('codigo', 'ilike', "%{$search}%");
            });
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $monitoramentos = $query
            ->orderBy('periodo_referencia', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('esg.esg_monitoramentos.index', compact('monitoramentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first(); // ou usar a lógica de multi-tenant
        $indicadores = EsgIndicador::where('empresa_id', $empresa->id)
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();
        $responsaveis = User::orderBy('name')->get();
        $statusList = ['No prazo', 'Atrasado', 'Concluído'];

        return view('esg.esg_monitoramentos.create', compact(
            'empresa',
            'indicadores',
            'responsaveis',
            'statusList'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEsgMonitoramentoRequest $request)
    {
        $data = $request->validated();

        if (empty($data['responsavel_id'])) {
            $data['responsavel_id'] = Auth::id();
        }

        EsgMonitoramento::create($data);

        return redirect()
            ->route('esg_monitoramentos.index')
            ->with('success', 'Monitoramento ESG criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EsgMonitoramento $esgMonitoramento)
    {
        $esgMonitoramento->load(['indicador', 'responsavel', 'indicador.empresa']);

        return view('esg.esg_monitoramentos.show', compact('esgMonitoramento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EsgMonitoramento $esgMonitoramento)
    {
        $empresa = Empresa::find($esgMonitoramento->indicador->empresa_id ?? null) ?? Empresa::first();
        $indicadores = EsgIndicador::where('empresa_id', $empresa->id)
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();
        $responsaveis = User::orderBy('name')->get();
        $statusList = ['No prazo', 'Atrasado', 'Concluído'];

        return view('esg.esg_monitoramentos.edit', compact(
            'esgMonitoramento',
            'empresa',
            'indicadores',
            'responsaveis',
            'statusList'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEsgMonitoramentoRequest $request, EsgMonitoramento $esgMonitoramento)
    {
        $data = $request->validated();

        $esgMonitoramento->update($data);

        return redirect()
            ->route('esg_monitoramentos.index')
            ->with('success', 'Monitoramento ESG atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EsgMonitoramento $esgMonitoramento)
    {
        $esgMonitoramento->delete();

        return redirect()
            ->route('esg_monitoramentos.index')
            ->with('success', 'Monitoramento ESG excluído com sucesso.');
    }
}
