<?php

namespace App\Http\Controllers;

use App\Models\IncidenteAcidente;
use App\Models\Empresa;
use App\Models\User;
use App\Http\Requests\StoreIncidenteAcidenteRequest;
use App\Http\Requests\UpdateIncidenteAcidenteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidenteAcidenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::first();

        $query = IncidenteAcidente::where('empresa_id', $empresa->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('descricao', 'ilike', "%{$search}%")
                  ->orWhere('local', 'ilike', "%{$search}%");
            });
        }

        $incidentes = $query->with(['usuario', 'responsavel'])
                            ->orderBy('data_ocorrencia', 'desc')
                            ->paginate(15);
            
            $usuarios = User::all();

        return view('iso45001.incidentes_acidentes.index', compact('incidentes', 'usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        $usuarios = User::all(); 
        return view('iso45001.incidentes_acidentes.create', compact('empresa', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIncidenteAcidenteRequest $request)
    {
        $validated = $request->validated();
        if (empty($validated['responsavel_id'])) {
            $validated['responsavel_id'] = Auth::id();
        }
        IncidenteAcidente::create($validated);

        return redirect()->route('incidentes_acidentes.index')->with('success', 'Incidente/Acidente registrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncidenteAcidente $incidentesAcidente)
    {
        return view('iso45001.incidentes_acidentes.show', compact('incidentesAcidente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncidenteAcidente $incidentesAcidente)
    {
        $empresa = Empresa::find($incidentesAcidente->empresa_id);
        $usuarios = User::all();
        return view('iso45001.incidentes_acidentes.edit', compact('incidentesAcidente', 'empresa', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncidenteAcidenteRequest $request, IncidenteAcidente $incidentesAcidente)
    {
        $validated = $request->validated();
        $incidentesAcidente->update($validated);

        return redirect()->route('incidentes_acidentes.index')->with('success', 'Incidente/Acidente atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncidenteAcidente $incidentesAcidente)
    {
        $incidentesAcidente->delete();
        return redirect()->route('incidentes_acidentes.index')->with('success', 'Incidente/Acidente excluído com sucesso.');
    }
}
