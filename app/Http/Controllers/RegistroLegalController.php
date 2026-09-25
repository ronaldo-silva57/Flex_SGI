<?php

namespace App\Http\Controllers;

use App\Models\RegistroLegal;
use App\Models\Empresa;
use App\Models\Norma;
use App\Http\Requests\StoreRegistroLegalRequest;
use App\Http\Requests\UpdateRegistroLegalRequest;   
use Illuminate\Http\Request;

class RegistroLegalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::first();

        $query = RegistroLegal::where([
            ['empresa_id', '=', $empresa->id],
        ]);

        if($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero', 'ilike', "%{$search}%")
                  ->orWhere('descricao', 'ilike', "%{$search}%")
                  ->orWhere('orgao', 'ilike', "%{$search}%");
            });
        }     

        $registros = $query->orderBy('empresa_id', 'desc')->paginate(15);

        return view('iso14001.registros_legais.index', compact('registros'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();

        $normas = Norma::orderBy('codigo')->get();

        return view('iso14001.registros_legais.create', compact('normas', 'empresa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegistroLegalRequest $request)
    {
        $validated = $request->validated();
        RegistroLegal::create($validated);

        return redirect()->route('registros_legais.index')
                         ->with('success', 'Registro legal criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RegistroLegal $registro)
    {
        return view('iso14001.registros_legais.show', compact('registro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegistroLegal $registro)
    {
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $normas  = Norma::orderBy('codigo')->get();

        return view('iso14001.registros_legais.edit', compact('registro', 'normas', 'empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRegistroLegalRequest $request, RegistroLegal $registro)
    {
        $registro->update($request->validated());

        return redirect()->route('registros_legais.index')
                        ->with('success', 'Registro legal atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegistroLegal $registro)
    {
        $registro->delete();

        return redirect()->route('registros_legais.index')
                        ->with('success', 'Registro legal excluído com sucesso.');
    }
}
