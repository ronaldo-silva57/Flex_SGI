<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use App\Models\EsgProjetoSocial;
use App\Http\Requests\StoreEsgProjetosSociais;
use App\Http\Requests\UpdateEsgProjetosSociais;
use Illuminate\Http\Request;

class EsgProjetosSociaisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EsgProjetoSocial::with(['empresa', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome_projeto', 'ilike', "%{$search}%")
                  ->orWhere('localidade', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $esgProjetosSociais = $query
            ->orderBy('data_inicio', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('esg.esg_projetos.index', compact('esgProjetosSociais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        $responsaveis = User::orderBy('name')->get();

        return view('esg.esg_projetos.create', compact('empresa', 'responsaveis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEsgProjetosSociais $request)
    {
        $data = $request->validated();

        EsgProjetoSocial::create($data);

        return redirect()
            ->route('esg_projetos.index')
            ->with('success', 'Projeto Social ESG criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(EsgProjetoSocial $esgProjetoSocial)
    {
        return view('esg.esg_projetos.show', compact('esgProjetoSocial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EsgProjetoSocial $esgProjetoSocial)
    {
        $empresa = Empresa::find($esgProjetoSocial->empresa_id) ?? Empresa::first();
        $responsaveis = User::orderBy('name')->get();

        return view('esg.esg_projetos.edit', compact('esgProjetoSocial', 'empresa', 'responsaveis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEsgProjetosSociais $request, EsgProjetoSocial $esgProjetoSocial)
    {
        $data = $request->validated();

        $esgProjetoSocial->update($data);

        return redirect()
            ->route('esg_projetos.index')
            ->with('success', 'Projeto Social ESG atualizado com sucesso'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EsgProjetoSocial $esgProjetoSocial)
    {
        $esgProjetoSocial->delete();

        return redirect()
            ->route('esg_projetos.index')
            ->with('success', 'Projeto Social ESG excluído com sucesso');
    }
}
