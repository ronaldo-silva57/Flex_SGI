<?php

namespace App\Http\Controllers;

use App\Models\EsgIndicador;
use App\Models\Empresa;
use App\Models\User;
use App\Http\Requests\StoreEsgIndicadorRequest;
use App\Http\Requests\UpdateEsgIndicadorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EsgIndicadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::first(); 

        $query = EsgIndicador::where('empresa_id', $empresa->id);

        // Busca por código ou nome
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'ilike', "%{$search}%")
                  ->orWhere('nome', 'ilike', "%{$search}%");
            });
        }

        // Filtro opcional por dimensão
        if ($request->filled('dimensao')) {
            $query->where('dimensao', $request->dimensao);
        }

        $indicadores = $query->with(['responsavel'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('esg.esg_indicadores.index', compact('indicadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        $responsaveis = User::orderBy('name')->get();
        
        $dimensoes = ['Ambiental', 'Social', 'Governança'];
        $frequencias = ['Mensal', 'Trimestral', 'Semestral', 'Anual'];

        return view('esg.esg_indicadores.create', compact('empresa', 'responsaveis', 'dimensoes', 'frequencias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEsgIndicadorRequest $request)
    {
        $validated = $request->validated();

        if (empty($validated['responsavel_id'])) {
            $validated['responsavel_id'] = Auth::id();
        }

        // Garantir o booleano de ativo caso não venha no request
        $validated['ativo'] = $request->has('ativo');

        EsgIndicador::create($validated);

        return redirect()->route('esg_indicadores.index')
            ->with('success', 'Indicador ESG criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EsgIndicador $esgIndicador)
    {
        $esgIndicador->load(['empresa', 'responsavel']);

        return view('esg.esg_indicadores.show', compact('esgIndicador'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EsgIndicador $esgIndicador)
    {
        $empresa = Empresa::find($esgIndicador->empresa_id);
        $responsaveis = User::orderBy('name')->get();

        $dimensoes = ['Ambiental', 'Social', 'Governança'];
        $frequencias = ['Mensal', 'Trimestral', 'Semestral', 'Anual'];

        return view('esg.esg_indicadores.edit', compact(
            'esgIndicador',
            'empresa',
            'responsaveis',
            'dimensoes',
            'frequencias'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEsgIndicadorRequest $request, EsgIndicador $esgIndicador)
    {
        $validated = $request->validated();

        $validated['ativo'] = $request->has('ativo');

        $esgIndicador->update($validated);

        return redirect()->route('esg_indicadores.index')
            ->with('success', 'Indicador ESG atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EsgIndicador $esgIndicador)
    {
        $esgIndicador->delete();

        return redirect()->route('esg_indicadores.index')
            ->with('success', 'Indicador ESG excluído com sucesso.');
    }
}