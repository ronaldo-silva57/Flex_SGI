<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePesquisaSatisfacaoRequest;
use App\Http\Requests\StorePesquisaRespostaRequest;
use App\Http\Requests\UpdatePesquisaSatisfacaoRequest;
use App\Models\Cliente;
use App\Models\PesquisaSatisfacao;
use App\Models\User;
use Illuminate\Http\Request;

class PesquisaSatisfacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pesquisas = PesquisaSatisfacao::query()
            ->with(['cliente:id,nome', 'responsavel:id,name'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->tipo,   fn ($q) => $q->where('tipo', $request->tipo))
            ->when($request->busca,  fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('titulo', 'ilike', "%{$request->busca}%")
                ->orWhere('codigo', 'ilike', "%{$request->busca}%");
            }))
            ->orderByDesc('data_inicio')
            ->paginate(15)
            ->withQueryString();

        return view('iso9001.pesquisas_satisfacao.index', compact('pesquisas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('iso9001.pesquisas_satisfacao.create', [
            'clientes'    => Cliente::where('empresa_id', auth()->user()->empresa_id)
                                    ->orderBy('nome')->get(['id', 'nome']),
            'responsaveis' => User::where('empresa_id', auth()->user()->empresa_id)
                                    ->where('ativo', true)->orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePesquisaSatisfacaoRequest $request)
    {
        $data = $request->validated();
        $data['empresa_id'] = auth()->user()->empresa_id;

        $pesquisa = PesquisaSatisfacao::create($data);

        return redirect()
            ->route('pesquisas_satisfacao.show', $pesquisa)
            ->with('success', 'Pesquisa criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PesquisaSatisfacao $pesquisaSatisfacao)
    {
        $user = auth()->user();

        // 1. Garantia de isolamento de tenant (impede acesso a dados de outras empresas)
        if ($user->empresa_id && $pesquisaSatisfacao->empresa_id !== $user->empresa_id) {
            abort(403, 'Acesso não autorizado a este registro.');
        }

        // 2. Eager loading dos dados principais
        $pesquisaSatisfacao->load([
            'cliente:id,nome',
            'responsavel:id,name',
        ]);

        // 3. Carrega as respostas ordenadas e com paginação própria se necessário na view
        $respostas = $pesquisaSatisfacao->respostas()
            ->with(['cliente:id,nome', 'respondente:id,name'])
            ->latest('respondido_em')
            ->paginate(10);

        return view('iso9001.pesquisas_satisfacao.show', compact('pesquisaSatisfacao', 'respostas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PesquisaSatisfacao $pesquisaSatisfacao)
    {
        return view('iso9001.pesquisas_satisfacao.edit', [
            'pesquisa'    => $pesquisaSatisfacao,
            'clientes'    => Cliente::where('empresa_id', auth()->user()->empresa_id)
                                    ->orderBy('nome')->get(['id', 'nome']),
            'responsaveis' => User::where('empresa_id', auth()->user()->empresa_id)
                                    ->where('ativo', true)->orderBy('name')->get(['id', 'name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePesquisaSatisfacaoRequest $request, PesquisaSatisfacao $pesquisaSatisfacao)
    {
        $pesquisaSatisfacao->update($request->validated());

        return redirect()
            ->route('pesquisas_satisfacao.show', $pesquisaSatisfacao)
            ->with('success', 'Pesquisa atualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PesquisaSatisfacao $pesquisaSatisfacao)
    {
        $pesquisaSatisfacao->delete();

        return redirect()
            ->route('pesquisas_satisfacao.index')
            ->with('success', 'Pesquisa removida.');
    }

    public function storeResposta(StorePesquisaRespostaRequest $request, PesquisaSatisfacao $pesquisaSatisfacao)
    {
        //$this->authorizeEmpresa($pesquisaSatisfacao);

        $pesquisaSatisfacao->respostas()->create($request->validated());

        return back()->with('success', 'Resposta registrada.');
    }
}
