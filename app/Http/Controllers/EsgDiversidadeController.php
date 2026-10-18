<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use App\Models\EsgDiversidade;
use App\Http\Requests\StoreEsgDiversidade;
use App\Http\Requests\UpdateEsgDiversidade;
use Illuminate\Http\Request;

class EsgDiversidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        $query = EsgDiversidade::with(['empresa', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('categoria_cargo', 'ilike', "%{$search}%")
                  ->orWhere('genero', 'ilike', "%{$search}%")
                  ->orWhere('raca_etnia', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('ano_referencia')) {
            $query->where('ano_referencia', $request->ano_referencia);
        }
        
        $esgDiversidade = $query
            ->orderBy('ano_referencia', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('esg.esg_diversidade.index', compact('esgDiversidade'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        $responsaveis = User::orderBy('name')->get();

        return view('esg.esg_diversidade.create', compact('empresa', 'responsaveis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEsgDiversidade $request)
    {
        $data = $request->validated();

        EsgDiversidade::create($data);

        return redirect()
            ->route('esg_diversidade.index')
            ->with('success', 'Diversidade ESG criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(EsgDiversidade $esgDiversidade)
    {
        return view('esg.esg_diversidade.show', compact('esgDiversidade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EsgDiversidade $esgDiversidade)
    {
        $empresa = Empresa::find($esgDiversidade->empresa_id) ?? Empresa::first();
        $responsaveis = User::orderBy('name')->get();

        return view('esg.esg_diversidade.edit', compact('esgDiversidade', 'empresa', 'responsaveis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEsgDiversidade $request, EsgDiversidade $esgDiversidade)
    {
        $data = $request->validated();

        $esgDiversidade->update($data);

        return redirect()
            ->route('esg_diversidade.index')
            ->with('success', 'Diversidade ESG atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EsgDiversidade $esgDiversidade)
    {
        $esgDiversidade->delete();

        return redirect()
            ->route('esg_diversidade.index')
            ->with('success', 'Diversidade ESG excluído com sucesso');
    }
}
