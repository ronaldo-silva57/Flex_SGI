<?php

namespace App\Http\Controllers;

use App\Models\PerigoRisco;
use App\Models\Empresa;
use App\Models\Processo;
use App\Http\Requests\StorePerigoRiscoRequest;
use App\Http\Requests\UpdatePerigoRiscoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerigoRiscoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::first();

        $query = PerigoRisco::where('empresa_id', $empresa->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('descricao_perigo', 'LIKE', "%{$search}%")
                  ->orWhere('risco_associado', 'LIKE', "%{$search}%");
            });
        }

        $perigos = $query->with(['processo', 'responsavel'])->orderBy('created_at', 'desc')->paginate(15);

        return view('iso45001.perigos_riscos.index', compact('perigos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        $processos = Processo::where('empresa_id', $empresa->id)->orderBy('nome')->get();
        return view('iso45001.perigos_riscos.create', compact('empresa', 'processos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerigoRiscoRequest $request)
    {
        $validated = $request->validated();
        if (empty($validated['responsavel_id'])) {
            $validated['responsavel_id'] = Auth::id();
        }
        // Calcula nível de risco
        if (!empty($validated['probabilidade']) && !empty($validated['severidade'])) {
            $validated['nivel_risco'] = $validated['probabilidade'] * $validated['severidade'];
        }
        PerigoRisco::create($validated);

        return redirect()->route('perigos_riscos.index')->with('success', 'Perigo/Risco criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PerigoRisco $perigosRisco)
    {
        return view('iso45001.perigos_riscos.show', compact('perigosRisco'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerigoRisco $perigosRisco)
    {
        $empresa = Empresa::find($perigosRisco->empresa_id);
        $processos = Processo::where('empresa_id', $empresa->id)->orderBy('nome')->get();
        return view('iso45001.perigos_riscos.edit', compact('perigosRisco', 'empresa', 'processos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePerigoRiscoRequest $request, PerigoRisco $perigosRisco)
    {
        $validated = $request->validated();
        if (!empty($validated['probabilidade']) && !empty($validated['severidade'])) {
            $validated['nivel_risco'] = $validated['probabilidade'] * $validated['severidade'];
        }
        $perigosRisco->update($validated);

        return redirect()->route('perigos_riscos.index')->with('success', 'Perigo/Risco atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerigoRisco $perigosRisco)
    {
        $perigosRisco->delete();
        return redirect()->route('perigos_riscos.index')->with('success', 'Perigo/Risco excluído com sucesso.');
    }
}
