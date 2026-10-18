<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use App\Models\EsgGovernancaMembro;
use App\Http\Requests\StoreEsgGovernancaMembro;
use App\Http\Requests\UpdateEsgGovernancaMembro;
use Illuminate\Http\Request;

class EsgGovernancaMembroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EsgGovernancaMembro::with(['empresa', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'ilike', "%{$search}%")
                  ->orWhere('orgao', 'ilike', "%{$search}%")
                  ->orWhere('cargo', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('inicio_mandato')) {
            $query->where('inicio_mandato', $request->inicio_mandato);
        }

        $esgGovernanca = $query 
            ->orderBy('inicio_mandato', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('esg.esg_governanca.index', compact('esgGovernanca'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        $responsaveis = User::orderBy('name')->get();

        $esgGovernancaMembro = new EsgGovernancaMembro();
        
        return view('esg.esg_governanca.create', compact('empresa', 'responsaveis', 'esgGovernancaMembro'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEsgGovernancaMembro $request)
    {
        $data = $request->validated();

        EsgGovernancaMembro::create($data);

        return redirect()
            ->route('esg_governanca.index')
            ->with('success', 'Governança ESG criada com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(EsgGovernancaMembro $esgGovernancaMembro)
    {
        return view('esg.esg_governanca.show', compact('esgGovernancaMembro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EsgGovernancaMembro $esgGovernancaMembro)
    {
        $empresa = Empresa::find($esgGovernancaMembro->empresa_id) ?? Empresa::first();
        $responsaveis = User::orderBy('name')->get();

        return view('esg.esg_governanca.edit', compact('esgGovernancaMembro', 'empresa', 'responsaveis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEsgGovernancaMembro $request, EsgGovernancaMembro $esgGovernancaMembro)
    {
        $data = $request->validated();

        $esgGovernancaMembro->update($data);

        return redirect()
            ->route('esg_governanca.index')
            ->with('success', 'Governança ESG atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EsgGovernancaMembro $esgGovernancaMembro)
    {
        $esgGovernancaMembro->delete();

        return redirect()
            ->route('esg_governanca.index')
            ->with('success', 'Governança ESG excluído com sucesso');
    }
}
