<?php

namespace App\Http\Controllers;

use App\Models\ComunicacaoInterna;
use App\Models\Empresa;
use App\Http\Requests\StoreComunicacaoInternaRequest;
use App\Http\Requests\UpdateComunicacaoInternaRequest;
use Illuminate\Http\Request;

class ComunicacaoInternaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ComunicacaoInterna::with(['empresa', 'autor', 'leituras']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('titulo', 'ilike', "%{$search}%");
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $comunicacoes = $query
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.comunicacoes.index', compact('comunicacoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $comunicacao = new ComunicacaoInterna();

        return view('cadastros.comunicacoes.create', compact('comunicacao', 'empresa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreComunicacaoInternaRequest $request)
    {
        $data = $request->validated();
        ComunicacaoInterna::create($data);

        return redirect()->route('comunicacoes.index')
                        ->with('success', 'Comunicação criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ComunicacaoInterna $comunicacaoInterna)
    {
        $comunicacaoInterna->load(['empresa', 'autor', 'leituras']);

        $comunicacao = $comunicacaoInterna;

        return view('cadastros.comunicacoes.show', compact('comunicacao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComunicacaoInterna $comunicacaoInterna)
    {
        $comunicacaoInterna->load(['empresa', 'autor']);

        $comunicacao = $comunicacaoInterna;

        $empresa = $comunicacao->empresa
            ?? Empresa::find(auth()->user()->empresa_id ?? null)
            ?? Empresa::first();

        return view('cadastros.comunicacoes.edit', compact('comunicacao', 'empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateComunicacaoInternaRequest $request, ComunicacaoInterna $comunicacaoInterna)
    {
        $data = $request->validated();
        $comunicacaoInterna->update($data);

        return redirect()->route('comunicacoes.index')
                        ->with('success', 'Comunicação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComunicacaoInterna $comunicacaoInterna)
    {
        $comunicacaoInterna->delete();

        return redirect()->route('comunicacoes.index')
                        ->with('success', 'Comunicação removida com sucesso!');
    }

    // Método para o usuário dar ciência/leitura
    public function registrarLeitura(Request $request, ComunicacaoInterna $comunicacao)
    {
        $comunicacao->leituras()->syncWithoutDetaching([
            auth()->id() => ['lido_em' => now()]
        ]);

        return back()->with('success', 'Ciência registrada com sucesso!');
    }
}
