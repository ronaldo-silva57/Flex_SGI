<?php

namespace App\Http\Controllers;

use App\Models\Materialidade;
use App\Models\Empresa;
use App\Models\EsgIndicador;
use App\Http\Requests\StoreMaterialidadeRequest;
use App\Http\Requests\UpdateMaterialidadeRequest;
use Illuminate\Http\Request;
class MaterialidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Materialidade::with(['empresa', 'esgIndicador']);

        // Filtro por tema
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('tema', 'ilike', "%{$search}%");
        }

        // Filtro por classificação
        if ($request->filled('classificacao')) {
            $query->where('classificacao', $request->classificacao);
        }

        $materialidades = $query
            ->orderBy('score', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('esg.materialidade.index', compact('materialidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $indicadores = EsgIndicador::where('empresa_id', $empresa->id)
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();

        $classificacoes = ['Baixa', 'Média', 'Alta', 'Crítica'];

        return view('esg.materialidade.create', compact('empresa', 'indicadores', 'classificacoes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaterialidadeRequest $request)
    {
        $data = $request->validated();

        // O score é calculado automaticamente pelo banco (storedAs)
        Materialidade::create($data);

        return redirect()
            ->route('materialidade.index')
            ->with('success', 'Materialidade criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Materialidade $materialidade)
    {
        $materialidade->load(['empresa', 'esgIndicador']);

        return view('esg.materialidade.show', compact('materialidade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materialidade $materialidade)
    {
        $empresa = Empresa::find($materialidade->empresa_id ?? null) ?? Empresa::first();
        $indicadores = EsgIndicador::where('empresa_id', $empresa->id)
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();

        $classificacoes = ['Baixa', 'Média', 'Alta', 'Crítica'];

        return view('esg.materialidade.edit', compact(
            'materialidade',
            'empresa',
            'indicadores',
            'classificacoes'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaterialidadeRequest $request, Materialidade $materialidade)
    {
        $data = $request->validated();

        $materialidade->update($data);

        return redirect()
            ->route('materialidade.index')
            ->with('success', 'Materialidade atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materialidade $materialidade)
    {
        $materialidade->delete();

        return redirect()
            ->route('materialidade.index')
            ->with('success', 'Materialidade removida com sucesso.');
    }
}
