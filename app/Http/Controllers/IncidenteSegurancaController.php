<?php

namespace App\Http\Controllers;

use App\Models\IncidenteSeguranca;
use App\Models\AtivoInformacao;
use App\Models\Empresa;
use App\Models\User;
use App\Http\Requests\StoreIncidentesSegurancaRequest;
use App\Http\Requests\UpdateIncidentesSegurancaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncidenteSegurancaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::first();
        $query = IncidenteSeguranca::where('empresa_id', $empresa->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('descricao', 'LIKE', "%{$search}%")
                  ->orWhere('tipo', 'LIKE', "%{$search}%");
            });
        }

        $incidentes = $query->with(['ativo', 'responsavel'])->orderBy('data_ocorrencia', 'desc')->paginate(15);

        return view('iso27001.incidentes_seguranca.index', compact('incidentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        $ativos = AtivoInformacao::where('empresa_id', $empresa->id)->orderBy('nome')->get();
        $usuarios = User::all();
        return view('iso27001.incidentes_seguranca.create', compact('empresa', 'ativos', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIncidentesSegurancaRequest $request)
    {
        $validated = $request->validated();
        if (empty($validated['responsavel_id'])) {
            $validated['responsavel_id'] = Auth::id();
        }
        IncidenteSeguranca::create($validated);

        return redirect()->route('incidentes_seguranca.index')->with('success', 'Incidente de segurança registrado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncidenteSeguranca $incidentesSeguranca)
    {
        $incidentesSeguranca->load(['ativo', 'responsavel']);
        return view('iso27001.incidentes_seguranca.show', compact('incidentesSeguranca'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncidenteSeguranca $incidentesSeguranca)
    {
        $empresa = Empresa::find($incidentesSeguranca->empresa_id);
        $ativos = AtivoInformacao::where('empresa_id', $empresa->id)->orderBy('nome')->get();
        $usuarios = User::all();
        return view('iso27001.incidentes_seguranca.edit', compact('incidentesSeguranca', 'empresa', 'ativos', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIncidentesSegurancaRequest $request, IncidenteSeguranca $incidentesSeguranca)
    {
        $validated = $request->validated();
        $incidentesSeguranca->update($validated);

        return redirect()->route('incidentes_seguranca.index')->with('success', 'Incidente atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncidenteSeguranca $incidentesSeguranca)
    {
        $incidentesSeguranca->delete();
        return redirect()->route('incidentes_seguranca.index')->with('success', 'Incidente excluído com sucesso.');
    }
}
