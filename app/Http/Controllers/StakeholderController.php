<?php

namespace App\Http\Controllers;

use App\Models\Stakeholder;
use App\Models\Empresa;
use App\Http\Requests\StoreStakeholderRequest;
use App\Http\Requests\UpdateStakeholderRequest;
use Illuminate\Http\Request;

class StakeholderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Stakeholder::with(['empresa']);

        // Filtro por nome ou tipo
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'ilike', "%{$search}%")
                  ->orWhere('tipo', 'ilike', "%{$search}%");
            });
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        // Filtro por prioridade
        if ($request->filled('prioridade')) {
            $query->where('prioridade', $request->prioridade);
        }

        // Filtro por ativo
        if ($request->filled('ativo')) {
            $query->where('ativo', $request->ativo == '1');
        }

        $stakeholders = $query
            ->orderBy('prioridade', 'desc')
            ->orderBy('nome')
            ->paginate(15)
            ->withQueryString();

        return view('esg.stakeholders.index', compact('stakeholders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $tipos = ['Cliente', 'Colaborador', 'Fornecedor', 'Comunidade', 'Investidor', 'Governo', 'Outros'];

        return view('esg.stakeholders.create', compact('empresa', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStakeholderRequest $request)
    {
        $data = $request->validated();

        // Se empresa_id não veio, usa do usuário
        if (empty($data['empresa_id'])) {
            $data['empresa_id'] = auth()->user()->empresa_id ?? Empresa::first()->id;
        }

        // Ativo vem como boolean
        $data['ativo'] = $request->has('ativo');

        Stakeholder::create($data);

        return redirect()
            ->route('stakeholders.index')
            ->with('success', 'Stakeholder criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Stakeholder $stakeholder)
    {
        $stakeholder->load(['empresa']);

        return view('esg.stakeholders.show', compact('stakeholder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stakeholder $stakeholder)
    {
        $empresa = Empresa::find($stakeholder->empresa_id) ?? Empresa::first();
        $tipos = ['Cliente', 'Colaborador', 'Fornecedor', 'Comunidade', 'Investidor', 'Governo', 'Outros'];

        return view('esg.stakeholders.edit', compact('stakeholder', 'empresa', 'tipos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStakeholderRequest $request, Stakeholder $stakeholder)
    {
        $data = $request->validated();

        $data['ativo'] = $request->has('ativo');

        $stakeholder->update($data);

        return redirect()
            ->route('stakeholders.index')
            ->with('success', 'Stakeholder atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stakeholder $stakeholder)
    {
        $stakeholder->delete();

        return redirect()
            ->route('stakeholders.index')
            ->with('success', 'Stakeholder removido com sucesso.');
    }
}
