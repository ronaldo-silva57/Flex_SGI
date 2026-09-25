<?php

namespace App\Http\Controllers;

use App\Models\Indicador;
use App\Http\Requests\StoreIndicadorRequest;
use App\Http\Requests\UpdateIndicadorRequest;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Processo;
use App\Models\Norma;
use App\Models\User;

class IndicadorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Indicador::query();

        // Filtro por código ou nome
        if($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search){
                $q->where('codigo', 'ilike', "%{$search}%")
                  ->orWhere('nome', 'ilike', "%{$search}%");
            });
        }

        $indicadores = $query->orderBy('codigo')->paginate(15);

        return view('iso9001.indicadores.index', compact('indicadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $processos = Processo::orderBy('nome')->get();
        $normas = Norma::orderBy('nome')->get();
        $usuarios = User::orderBy('name')->get();
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();

        return view('iso9001.indicadores.create', compact('empresa', 'processos', 'normas', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIndicadorRequest $request)
    {
        $data = $request->validated();
        $data['ativo'] = $request->boolean('ativo');

        Indicador::create($data);

        return redirect()->route('indicadores.index')
                        ->with('success', 'Indicador cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Indicador $indicador)
    {
        return view('iso9001.indicadores.show', compact('indicador'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Indicador $indicador)
    {
        $processos = Processo::orderBy('nome')->get();
        $normas = Norma::orderBy('nome')->get();
        $usuarios = User::orderBy('name')->get();

        $empresa = $indicador->empresa
            ?? Empresa::find(auth()->user()->empresa_id ?? null)
            ?? Empresa::first();

        return view('iso9001.indicadores.edit', compact('indicador', 'empresa', 'processos', 'normas', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIndicadorRequest $request, Indicador $indicador)
    {
        $data = $request->validated();
        $data['ativo'] = $request->boolean('ativo');

        $indicador->update($data);

        return redirect()->route('indicadores.index')
                        ->with('success', 'Indicador atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Indicador $indicador)
    {
        $indicador->delete();

        return redirect()->route('indicadores.index')
                        ->with('success', 'Indicador removido com sucesso!');
    }
}
