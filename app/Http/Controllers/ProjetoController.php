<?php

namespace App\Http\Controllers;

use App\Models\Projeto;
use App\Models\Empresa;
use App\Models\User;
use App\Http\Requests\StoreProjetoRequest;
use App\Http\Requests\UpdateProjetoRequest;
use Illuminate\Http\Request;

class ProjetoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Projeto::with(['empresa', 'responsavel', 'tarefas']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'ilike', "%{$search}%")
                   ->orWhere('codigo', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $projetos = $query
            ->orderBy('nome')
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.projetos.index', compact('projetos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $responsaveis = User::orderBy('name')->get();
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $projeto = new Projeto();

        return view('cadastros.projetos.create', compact('projeto', 'responsaveis', 'empresa'));
    }   

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjetoRequest $request)
    {
        $data = $request->validated();
        Projeto::create($data);

        return redirect()->route('projetos.index')
                        ->with('success', 'Projeto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Projeto $projeto)
    {
        $projeto->load(['empresa', 'responsavel', 'tarefas.responsavel']);
        return view('cadastros.projetos.show', compact('projeto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projeto $projeto)
    {
        $projeto->load(['empresa', 'responsavel']);
        $responsaveis = User::orderBy('name')->get();
        $empresa = $projeto->empresa
            ?? Empresa::find(auth()->user()->empresa_id ?? null)
            ?? Empresa::first();

        return view('cadastros.projetos.edit', compact('projeto', 'empresa', 'responsaveis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjetoRequest $request, Projeto $projeto)
    {
        $data = $request->validated();
        $projeto->update($data);

        return redirect()->route('projetos.index')
                        ->with('success', 'Projeto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projeto $projeto)
    {
        $projeto->delete();

        return redirect()->route('projetos.index')
                        ->with('success', 'Projeto removido com sucesso!');
    }

    // Método opcional para visão Kanban do projeto
    public function kanban(Projeto $projeto)
    {
        $projeto->load(['tarefas.responsavel']);
        return view('cadastros.projetos.kanban', compact('projeto'));
    }
}
