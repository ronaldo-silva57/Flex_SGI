<?php

namespace App\Http\Controllers;

use App\Models\Competencia;
use App\Models\Empresa;
use App\Http\Requests\StoreCompetenciaRequest;
use App\Http\Requests\UpdateCompetenciaRequest;
use Illuminate\Http\Request;

class CompetenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Competencia::with(['empresa']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'ilike', "%{$search}%")
                   ->orWhere('codigo', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $competencias = $query
            ->orderBy('nome')
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.competencias.index', compact('competencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $competencia = new Competencia();

        return view('cadastros.competencias.create', compact('competencia', 'empresa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompetenciaRequest $request)
    {
        $data = $request->validated();
        Competencia::create($data);

        return redirect()->route('competencias.index')
                        ->with('success', 'Competência criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Competencia $competencia)
    {
        $competencia->load(['empresa', 'cargos', 'usuarios']);
        return view('cadastros.competencias.show', compact('competencia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Competencia $competencia)
    {
        $competencia->load(['empresa']);
        $empresa = $competencia->empresa
            ?? Empresa::find(auth()->user()->empresa_id ?? null)
            ?? Empresa::first();

        return view('cadastros.competencias.edit', compact('competencia', 'empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompetenciaRequest $request, Competencia $competencia)
    {
        $data = $request->validated();
        $competencia->update($data);

        return redirect()->route('competencias.index')
                        ->with('success', 'Competência atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy(Competencia $competencia)
    {
        $competencia->delete();

        return redirect()->route('competencias.index')
                        ->with('success', 'Competência removida com sucesso!');
    }
}
