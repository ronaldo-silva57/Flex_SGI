<?php

namespace App\Http\Controllers;

use App\Models\ProdutoQuimico;
use App\Models\Fornecedor;
use App\Models\User;
use App\Http\Requests\StoreProdutoQuimicoRequest;
use App\Http\Requests\UpdateProdutoQuimicoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdutoQuimicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProdutoQuimico::with(['fornecedor','responsavel','empresa']);

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('nome','ilike',"%{$s}%")
                  ->orWhere('numero_cas','ilike',"%{$s}%")
                  ->orWhere('fabricante','ilike',"%{$s}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $produtos = $query->latest()->paginate(15)->withQueryString();

        return view('iso14001.produtos_quimicos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fornecedores = Fornecedor::pluck('razao_social','id');
        $usuarios = User::pluck('name','id');
        return view('iso14001.produtos_quimicos.create', compact('fornecedores','usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdutoQuimicoRequest $request)
    {
        $data = $request->validated();
        $data['empresa_id'] = $request->user()->empresa_id ?? 1;

        ProdutoQuimico::create($data);

        return redirect()->route('produtos_quimicos.index')
            ->with('success','Produto químico cadastrado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProdutoQuimico $produtoQuimico)
    {
        $produtoQuimico->load(['fornecedor','responsavel','empresa']);
        return view('iso14001.produtos_quimicos.show', compact('produtoQuimico'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProdutoQuimico $produtoQuimico)
    {
        $fornecedores = Fornecedor::pluck('razao_social','id');
        $usuarios = User::pluck('name','id');
        return view('iso14001.produtos_quimicos.edit', compact('produtoQuimico','fornecedores','usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdutoQuimicoRequest $request, ProdutoQuimico $produtoQuimico)
    {
        $produtoQuimico->update($request->validated());
        return redirect()->route('produtos_quimicos.index')->with('success','Produto Químico atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProdutoQuimico $produtoQuimico)
    {
        $produtoQuimico->delete();
        return redirect()->route('produtos_quimicos.index')->with('success','Produto Químico excluído!');
    }
    public function uploadFispq(Request $request, ProdutoQuimico $produtoQuimico)
    {
        $request->validate(['arquivo_fispq' => ['required','file','mimes:pdf','max:10240']]);

        if ($produtoQuimico->arquivo_fispq_path && Storage::disk('public')->exists($produtoQuimico->arquivo_fispq_path)) {
            Storage::disk('public')->delete($produtoQuimico->arquivo_fispq_path);
        }
        $path = $request->file('arquivo_fispq')->store('fispqs','public');
        $produtoQuimico->update(['arquivo_fispq_path' => $path]);

        return back()->with('success','FISPQ / FDS atualizada com sucesso!');
    }

    public function downloadFispq(ProdutoQuimico $produtoQuimico)
    {
        $disco = 'public';

        if (! $produtoQuimico->arquivo_fispq_path
            || ! Storage::disk($disco)->exists($produtoQuimico->arquivo_fispq_path)) {
            abort(404, 'Arquivo FISPQ não encontrado.');
        }

        $nome = 'FISPQ-' . $produtoQuimico->nome . '.pdf';

        return Storage::disk($disco)->download($produtoQuimico->arquivo_fispq_path, $nome);
    }
}
