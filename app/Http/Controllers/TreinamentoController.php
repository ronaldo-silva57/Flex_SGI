<?php

namespace App\Http\Controllers;

use App\Models\Treinamento;
use App\Models\Empresa;
use App\Models\User;
use App\Http\Requests\StoreTreinamentoRequest;
use App\Http\Requests\UpdateTreinamentoRequest;
use Illuminate\Http\Request;

class TreinamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Treinamento::with(['responsavel', 'empresa']);

        if($search = $request->input('search')) {
            $query->where('titulo', 'like', "%{$search}%")
                    ->orWhere('tipo', 'like', "%{$search}%");               
        }

        $treinamentos = $query->latest()->paginate(15);

        return view('cadastros.treinamentos.index', compact('treinamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $usuarios = User::orderBy('name')->get();

        return view('cadastros.treinamentos.create', compact('empresa', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTreinamentoRequest $request)
    {
        Treinamento::create($request->validated());

        return redirect()->route('treinamentos.index')->with('success', 'Treinamento criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Treinamento $treinamento)
    {
        $treinamento->load(['responsavel', 'empresa', 'usuarios']);
        
        return view('cadastros.treinamentos.show', compact('treinamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Treinamento $treinamento)
    {
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $usuarios = User::orderBy('name')->get();
        
        return view('cadastros.treinamentos.edit', compact('treinamento', 'empresa', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreinamentoRequest $request, Treinamento $treinamento)
    {
        $treinamento->update($request->validated());

        return redirect()->route('treinamentos.index')
            ->with('success', 'Treinamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Treinamento $treinamento)
    {
        $treinamento->delete();

        return redirect()->route('treinamentos.index')
            ->with('success', 'Treinamento excluído com sucesso!');
    }
}
