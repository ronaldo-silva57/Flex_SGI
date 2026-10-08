<?php

namespace App\Http\Controllers;

use App\Models\AspectoAmbiental;
use App\Models\Empresa;
use App\Models\Processo;
use App\Models\User;
use App\Http\Requests\StoreAspectoAmbientalRequest;
use App\Http\Requests\UpdateAspectoAmbientalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AspectoAmbientalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::first(); // Ajuste

        $query = AspectoAmbiental::where('empresa_id', $empresa->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('descricao', 'ilike', "%{$search}%")
                  ->orWhere('tipo', 'ilike', "%{$search}%");
            });
        }

         $aspectos = $query->with(['processo', 'responsavel'])->orderBy('created_at', 'desc')->paginate(15);

        return view('iso14001.aspectos_ambientais.index', compact('aspectos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $processos = Processo::where('empresa_id', $empresa->id)->orderBy('nome')->get();

        return view('iso14001.aspectos_ambientais.create', compact('empresa', 'processos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAspectoAmbientalRequest $request)
    {
        $validated = $request->validated();
        if (empty($validated['responsavel_id'])) {
            $validated['responsavel_id'] = Auth::id();
        }

        AspectoAmbiental::create($validated);

        return redirect()->route('aspectos_ambientais.index')
                         ->with('success', 'Aspecto ambiental criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AspectoAmbiental $aspecto)
    {
        return view('iso14001.aspectos_ambientais.show', compact('aspecto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AspectoAmbiental $aspecto)
    {
        $empresa   = Empresa::find($aspecto->empresa_id);
        $processos = Processo::where('empresa_id', $empresa->id)->orderBy('nome')->get();

        return view('iso14001.aspectos_ambientais.edit', compact('aspecto', 'empresa', 'processos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAspectoAmbientalRequest $request, AspectoAmbiental $aspecto)
    {
        $aspecto->update($request->validated());

        return redirect()->route('aspectos_ambientais.index')
                        ->with('success', 'Aspecto ambiental atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AspectoAmbiental $aspecto)
    {
        $aspecto->delete();

        return redirect()->route('aspectos_ambientais.index')
                        ->with('success', 'Aspecto ambiental excluído com sucesso.');
    }
}
