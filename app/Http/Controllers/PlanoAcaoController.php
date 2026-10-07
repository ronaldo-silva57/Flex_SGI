<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanoAcaoRequest;
use App\Http\Requests\UpdatePlanoAcaoRequest;
use App\Models\PlanoAcao;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanoAcaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $planos = PlanoAcao::query()
            ->with('responsavel')
            ->when($user->empresa_id, function ($query, $empresaId) {
                $query->where('empresa_id', $empresaId);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('titulo', 'ilike', "%{$search}%")
                        ->orWhere('codigo', 'ilike', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->orderBy('prazo_fim')
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.planos_acao.index', compact('planos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $usuarios = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('cadastros.planos_acao.create', compact('usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlanoAcaoRequest $request): RedirectResponse 
    {
        $empresaId = $request->user()->empresa_id;

        if (! $empresaId) {
            return back()
                ->withInput()
                ->withErrors(['empresa_id' => 'O usuário logado não possui uma empresa associada.']);
        }

        $dados = $request->validated();
        $dados['empresa_id'] = $empresaId;

        PlanoAcao::create($dados);

        return redirect()
            ->route('planos_acao.index')
            ->with('success', 'Plano de ação criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, PlanoAcao $planoAcao): View {

        $planoAcao->load('responsavel');

        return view('cadastros.planos_acao.show', compact('planoAcao'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, PlanoAcao $planosAcao): View 
    {
        $usuarios = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        // Passamos a variável $planoAcao para a view mantendo a convenção do seu Blade
        $planoAcao = $planosAcao;

        return view('cadastros.planos_acao.edit', compact('planoAcao', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanoAcaoRequest $request, PlanoAcao $planosAcao): RedirectResponse 
    {
        $dados = $request->validated();

        if (! isset($dados['empresa_id'])) {
            $dados['empresa_id'] = $planosAcao->empresa_id ?? $request->user()->empresa_id;
        }

        $planosAcao->update($dados);

        return redirect()
            ->route('planos_acao.index')
            ->with('success', 'Plano de ação atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, PlanoAcao $planoAcao): RedirectResponse {
        $planoAcao->delete();

        return redirect()
            ->route('planos_acao.index')
            ->with('success', 'Plano de ação excluído com sucesso.');
    }

    /**
     * Impede acesso a registros de outra empresa.
     */

}
