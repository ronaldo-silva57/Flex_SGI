<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartamentoRequest;
use App\Http\Requests\UpdateDepartamentoRequest;
use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    //Filtro por Código, Nome, Empresa, Razão, Fantasia
    $search = $request->input('search');

    $departamentos = Departamento::with('empresa')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('departamentos.codigo', 'ilike', "%{$search}%")
                  ->orWhere('departamentos.nome', 'ilike', "%{$search}%")
                  ->orWhereHas('empresa', function ($empresa) use ($search) {
                      $empresa->where('razao_social', 'ilike', "%{$search}%")
                              ->orWhere('nome_fantasia', 'ilike', "%{$search}%");
                  });
            });
        })
        ->orderBy('codigo')
        ->paginate(10)
        ->withQueryString();

    return view('cadastros.departamentos.index', compact('departamentos'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
            $empresa       = Empresa::where('ativo', true)->first();
            $usuarioLogado = auth()->user();
            $departamento  = new Departamento(); 

            return view('cadastros.departamentos.create', compact('departamento', 'empresa', 'usuarioLogado'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartamentoRequest $request): RedirectResponse
    {
        Departamento::create($request->validated());

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento criado com sucesso');
    }

    /**
     * Display the specified resource.
     */
    public function show(Departamento $departamento): View
    {
        $departamento->load('empresa');
        return view('cadastros.departamentos.show', compact('departamento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departamento $departamento): View
    {
        $departamento->load('empresa');
        $empresa       = $departamento->empresa;         
        $usuarioLogado = auth()->user();                 
        //dd($empresa);

        return view('cadastros.departamentos.edit', compact('departamento', 'empresa', 'usuarioLogado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartamentoRequest $request, Departamento $departamento): RedirectResponse
    {
        $departamento->update($request->validated());

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departamento $departamento): RedirectResponse
    {
        $departamento->delete();

        return redirect()->route('departamentos.index')
            ->with('success', 'Departamento excluído com sucesso!');
    }
}
