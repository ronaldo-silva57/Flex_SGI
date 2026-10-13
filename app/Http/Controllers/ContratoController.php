<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\Fornecedor;
use App\Models\User;
use App\Http\Requests\StoreContratoRequest;
use App\Http\Requests\UpdateContratoRequest;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contrato::with(['empresa', 'cliente', 'fornecedor', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'ilike', "%{$search}%")
                   ->orWhere('numero_contrato', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $contratos = $query
            ->orderBy('data_inicio', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.contratos.index', compact('contratos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $fornecedores = Fornecedor::orderBy('razao_social')->get();
        $responsaveis = User::orderBy('name')->get();
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $contrato = new Contrato();

        return view('cadastros.contratos.create', compact('contrato', 'clientes', 'fornecedores', 'responsaveis', 'empresa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContratoRequest $request)
    {
        $data = $request->validated();
        Contrato::create($data);

        return redirect()->route('contratos.index')
                        ->with('success', 'Contrato cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contrato $contrato)
    {
        $contrato->load(['empresa', 'cliente', 'fornecedor', 'responsavel']);
        return view('cadastros.contratos.show', compact('contrato'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contrato $contrato)
    {
        $contrato->load(['empresa', 'cliente', 'fornecedor', 'responsavel']);
        $clientes = Cliente::orderBy('nome')->get();
        $fornecedores = Fornecedor::orderBy('razao_social')->get();
        $responsaveis = User::orderBy('name')->get();
        $empresa = $contrato->empresa
            ?? Empresa::find(auth()->user()->empresa_id ?? null)
            ?? Empresa::first();

        return view('cadastros.contratos.edit', compact('contrato', 'empresa', 'clientes', 'fornecedores', 'responsaveis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContratoRequest $request, Contrato $contrato)
    {
        $data = $request->validated();
        $contrato->update($data);

        return redirect()->route('contratos.index')
                        ->with('success', 'Contrato atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contrato $contrato)
    {
        $contrato->delete();

        return redirect()->route('contratos.index')
                        ->with('success', 'Contrato removido com sucesso!');
    }
}
