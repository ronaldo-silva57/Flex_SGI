<?php

namespace App\Http\Controllers;

use App\Models\IndicadorAmbiental;
use App\Models\User;
use App\Http\Requests\StoreIndicadorAmbientalRequest;
use App\Http\Requests\UpdateIndicadorAmbientalRequest;
use Illuminate\Http\Request;

class IndicadorAmbientalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = IndicadorAmbiental::with(['empresa','responsavel']);

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('codigo','ilike',"%{$s}%")
                  ->orWhere('nome','ilike',"%{$s}%")
                  ->orWhere('descricao','ilike',"%{$s}%");
            });
        }
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->input('categoria'));
        }

        $indicadores = $query->latest()->paginate(10)->withQueryString();

        return view('iso14001.indicadores_ambientais.index', compact('indicadores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::pluck('name','id');
        return view('iso14001.indicadores_ambientais.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIndicadorAmbientalRequest $request)
    {
        $data = $request->validated();
        $data['empresa_id'] = $request->user()->empresa_id ?? 1;
        $data['ativo'] = $request->boolean('ativo', true);

        IndicadorAmbiental::create($data);

        return redirect()->route('indicadores_ambientais.index')
            ->with('success','Indicador ambiental cadastrado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(IndicadorAmbiental $indicadorAmbiental)
    {
        $indicadorAmbiental->load(['empresa','responsavel']);
        return view('iso14001.indicadores_ambientais.show', ['indicador' => $indicadorAmbiental]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IndicadorAmbiental $indicadorAmbiental)
    {
        $usuarios = User::pluck('name','id');
        return view('iso14001.indicadores_ambientais.edit', ['indicador' => $indicadorAmbiental, 'usuarios' => $usuarios]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIndicadorAmbientalRequest $request, IndicadorAmbiental $indicadorAmbiental)
    {
        $data = $request->validated();
        $data['ativo'] = $request->boolean('ativo', false);
        $indicadorAmbiental->update($data);

        return redirect()->route('indicadores_ambientais.index')
            ->with('success','Indicador ambiental atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IndicadorAmbiental $indicadorAmbiental)
    {
        $indicadorAmbiental->delete();
        return redirect()->route('indicadores_ambientais.index')
            ->with('success','Indicador ambiental excluído!');
    }
}
