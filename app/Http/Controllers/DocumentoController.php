<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Empresa;
use App\Models\Processo;
use App\Models\Norma;
use App\Models\User;
use App\Http\Requests\StoreDocumentoRequest;
use App\Http\Requests\UpdateDocumentoRequest;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Documento::with(['empresa', 'processo', 'norma', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'ilike', "%{$search}%")
                    ->orWhere('titulo', 'ilike', "%{$search}%")
                    ->orWhere('tipo', 'ilike', "%{$search}%")
                    ->orWhere('status', 'ilike', "%{$search}%")
                    ->orWhereHas('empresa', fn($e) => $e->where('nome_fantasia', 'ilike', "%{$search}%")
                        ->orWhere('razao_social', 'ilike', "%{$search}%"))
                    ->orWhereHas('processo', fn($p) => $p->where('nome', 'ilike', "%{$search}%"))
                    ->orWhereHas('norma', fn($n) => $n->where('codigo', 'ilike', "%{$search}%")
                        ->orWhere('nome', 'ilike', "%{$search}%"));
            });
        }

        $documentos = $query->latest()->paginate(15)->withQueryString();

        return view('cadastros.documentos.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresas = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $processos = Processo::where('ativo', true)->orderBy('nome')->get();
        $normas = Norma::where('ativo', true)->orderBy('codigo')->get();
        $usuarios = User::orderBy('name')->get();

        return view('cadastros.documentos.create', compact('empresas', 'processos', 'normas', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentoRequest $request)
    {
        Documento::create($request->validated());

        return redirect()
            ->route('documentos.index')
            ->with('success', 'Documento cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Documento $documento)
    {
        $documento->load(['empresa', 'processo', 'norma', 'responsavel']);

        return view('cadastros.documentos.show', compact('documento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documento $documento)
    {
        $empresas = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $processos = Processo::where('ativo', true)->orderBy('nome')->get();
        $normas = Norma::where('ativo', true)->orderBy('codigo')->get();
        $usuarios = User::orderBy('name')->get();

        return view('cadastros.documentos.edit', compact('documento', 'empresas', 'processos', 'normas', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentoRequest $request, Documento $documento)
    {
        $documento->update($request->validated());

        return redirect()
            ->route('documentos.index')
            ->with('success', 'Documento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documento $documento)
    {
        $documento->delete();

        return redirect()
            ->route('documentos.index')
            ->with('success', 'Documento removido com sucesso!');
    }
}
