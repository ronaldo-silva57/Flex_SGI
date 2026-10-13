<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\Departamento;
use App\Http\Requests\StoreCargoRequest;
use App\Http\Requests\UpdateCargoRequest;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cargo::with(['empresa', 'departamento', 'competencias']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'ilike', "%{$search}%")
                   ->orWhere('codigo', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('departamento_id')) {
            $query->where('departamento_id', $request->departamento_id);
        }

        $cargos = $query
            ->orderBy('nome')
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.cargos.index', compact('cargos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos = Departamento::orderBy('nome')->get();
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $cargo = new Cargo();

        return view('cadastros.cargos.create', compact('cargo', 'departamentos', 'empresa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCargoRequest $request)
    {
        $data = $request->validated();
        Cargo::create($data);

        return redirect()->route('cargos.index')
                        ->with('success', 'Cargo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cargo $cargo)
    {
        $cargo->load(['empresa', 'departamento', 'competencias']);
        return view('cadastros.cargos.show', compact('cargo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cargo $cargo)
    {
        $cargo->load(['empresa', 'departamento', 'competencias']);
        $departamentos = Departamento::orderBy('nome')->get();
        $empresa = $cargo->empresa
            ?? Empresa::find(auth()->user()->empresa_id ?? null)
            ?? Empresa::first();

        return view('cadastros.cargos.edit', compact('cargo', 'empresa', 'departamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCargoRequest $request, Cargo $cargo)
    {
        $data = $request->validated();
        $cargo->update($data);

        return redirect()->route('cargos.index')
                        ->with('success', 'Cargo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cargo $cargo)
    {
        $cargo->delete();

        return redirect()->route('cargos.index')
                        ->with('success', 'Cargo removido com sucesso!');
    }
}
