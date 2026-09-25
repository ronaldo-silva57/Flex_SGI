<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Models\Empresa;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $empresas = Empresa::paginate(10);
        return view('cadastros.empresas.index' , compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('cadastros.empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmpresaRequest $request): RedirectResponse
    {
        Empresa::create($request->validated());

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa): View
    {
        //$empresa->load('departamentos');
        return view('cadastros.empresas.show', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa): View
    {
        return view('cadastros.empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmpresaRequest $request, Empresa $empresa): RedirectResponse
    {
        $empresa->update($request->validated());

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa): RedirectResponse
    {
        $empresa->delete();
        return redirect()->route('empresas.index')
            ->with('Success', 'Empresa excluída com sucesso!');
    }
}
