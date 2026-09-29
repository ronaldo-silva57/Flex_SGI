<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use App\Models\Empresa;
use App\Models\Departamento;
use App\Models\User;
use App\Http\Requests\StoreProcessoRequest;
use App\Http\Requests\UpdateProcessoRequest;
use Illuminate\Http\Request;

class ProcessoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Processo::with([
            'empresa', 
            'departamento', 
            'responsavel'
        ]);

        // Filtro por (Nome ou Código do processo).
        if ($request->filled('search')){
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nome', 'ilike', "%{$search}%")
                   ->orWhere('codigo', 'ilike', "%{$search}%");
            });
        }

        // Filtro por departamento.
        if ($request->filled('departamento_id')){
            $query->where(
                'departamento_id', 
                $request->departamento_id);
        }

        $processos = $query
            ->orderby('nome')
            ->paginate(15)
            ->withQueryString();

        return view('iso9001.processos.index', compact('processos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos = Departamento::orderBy('nome')->get();
         (null) ?? Empresa::first();
        $processo = new Processo();
        return view('iso9001.processos.create', compact('processo', 'departamentos', 'empresa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProcessoRequest $request)
    {
        $data = $request->validated();
        $data['responsavel_id'] = $data['responsavel_id'] ?? auth()->id();
        Processo::create($data);

        return redirect()->route('processos.index')
                        ->with('success', 'Processo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Processo $processo)
    {

        return view('iso9001.processos.show', compact('processo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Processo $processo)
    {
        $processo->load(['empresa', 'departamento', 'responsavel']);
        $departamentos = Departamento::orderBy('nome')->get();
        $empresa = $processo->empresa
            ?? Empresa::find(auth()->user()->empresa_id ?? null)
            ?? Empresa::first();

        return view('iso9001.processos.edit', compact('processo', 'empresa', 'departamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProcessoRequest $request, Processo $processo)
    {
        // Pega somente os dados validados pelo FormRequest
        $data = $request->validated();
        $processo->update($data);

        return redirect()->route('processos.index')
                        ->with('success', 'Processo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Processo $processo)
    {
        $processo->delete();

        return redirect()->route('processos.index')
                        ->with('success', 'Processo removido com sucesso!');
    }
}
