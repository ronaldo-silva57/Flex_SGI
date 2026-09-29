<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanoAcaoRequest;
use App\Http\Requests\UpdatePlanoAcaoRequest;
use App\Http\Requests\StorePlanoAcaoRequest as RequestsStorePlanoAcaoRequest;
use App\Models\PlanoAcao;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanoAcaoController extends Controller
{
    /**
     * Lista os planos de ação.
     */
    public function index(Request $request): View
    {
        $planos = PlanoAcao::query()
            ->with('responsavel')
            ->where('empresa_id', $request->user()->empresa_id)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('titulo', 'like', "%{$search}%")
                        ->orWhere('codigo', 'like', "%{$search}%");
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
    public function create(Request $request): View
    {
        $usuarios = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('cadastros.planos_acao.create', compact('usuarios'));
    }

    /**
     * Salva um novo plano de ação.
     */
    public function store(StorePlanoAcaoRequest $request): RedirectResponse 
    {
        $dados = $request->validated();
        $dados['empresa_id'] = $request->user()->empresa_id;

        PlanoAcao::create($dados);

        return redirect()
            ->route('planos_acao.index')
            ->with('success', 'Plano de ação criado com sucesso.');
    }

    /**
     * Exibe um plano de ação.
     */
    public function show(Request $request, PlanoAcao $planosAcao): View {
        $this->validarEmpresa($request, $planosAcao);

        $planosAcao->load('responsavel');

        return view('cadastros.planos_acao.show', compact('planosAcao'));
    }


    /**
     * Exibe o formulário de edição.
     */
    public function edit(Request $request, PlanoAcao $planosAcao
    ): View {
        $this->validarEmpresa($request, $planosAcao);

        $usuarios = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('cadastros.planos_acao.edit', compact('planosAcao', 'usuarios')
        );
    }

    /**
     * Atualiza um plano de ação.
     */
    public function update(UpdatePlanoAcaoRequest $request, PlanoAcao $planoAcao): RedirectResponse {
        $this->validarEmpresa($request, $planoAcao);

        $planoAcao->update($request->validated());

        return redirect()
            ->route('planos_acao.index')
            ->with('success', 'Plano de ação atualizado com sucesso.');
    }

    /**
     * Exclui logicamente um plano de ação.
     */
    public function destroy(Request $request, PlanoAcao $planoAcao): RedirectResponse {
        $this->validarEmpresa($request, $planoAcao);

        $planoAcao->delete();

        return redirect()
            ->route('planos_acao.index')
            ->with('success', 'Plano de ação excluído com sucesso.');
    }

    /**
     * Impede acesso a registros de outra empresa.
     */
    private function validarEmpresa(
        Request $request,
        PlanoAcao $planoAcao
    ): void {
        abort_unless(
            (int) $planoAcao->empresa_id === (int) $request->user()->empresa_id,
            404
        );
    }
}
