<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\User;
use App\Models\EsgRelatorio;
use App\Http\Requests\StoreEsgRelatorioRequest;
use App\Http\Requests\UpdateEsgRelatorioRequest;
use Illuminate\Http\Request;

class EsgRelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EsgRelatorio::with(['empresa', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->search;
            // Busca direta nas colunas da tabela de relatórios
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'ilike', "%{$search}%")
                  ->orWhere('ano_referencia', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('ano_referencia')) {
            $query->where('ano_referencia', $request->ano_referencia);
        }

        $esgrelatorios = $query
            ->orderBy('data_publicacao', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('esg.esg_relatorios.index', compact('esgrelatorios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        $responsaveis = User::orderBy('name')->get();
        
        return view('esg.esg_relatorios.create', compact('empresa', 'responsaveis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEsgRelatorioRequest $request)
    {
        $data = $request->validated();

        EsgRelatorio::create($data);

        return redirect()
            ->route('esg_relatorios.index')
            ->with('success', 'Relatório ESG criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(EsgRelatorio $esgRelatorio)
    {
        return view('esg.esg_relatorios.show', compact('esgRelatorio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EsgRelatorio $esgRelatorio)
    {
        $empresa = Empresa::find($esgRelatorio->empresa_id) ?? Empresa::first();
        $responsaveis = User::orderBy('name')->get();

        return view('esg.esg_relatorios.edit', compact('esgRelatorio', 'empresa', 'responsaveis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEsgRelatorioRequest $request, EsgRelatorio $esgRelatorio)
    {
        $data = $request->validated();

        $esgRelatorio->update($data);

        return redirect()
            ->route('esg_relatorios.index')
            ->with('success', 'Relatório ESG atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EsgRelatorio $esgRelatorio)
    {
        $esgRelatorio->delete();

        return redirect()
            ->route('esg_relatorios.index')
            ->with('success', 'Relatório ESG excluído com sucesso.');
    }
}