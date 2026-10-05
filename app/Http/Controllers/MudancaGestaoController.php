<?php

namespace App\Http\Controllers;

use App\Models\MudancaGestao;
use App\Models\Empresa;
use App\Models\Processo;
use App\Models\User;
use App\Http\Requests\StoreMudancaGestaoRequest;
use App\Http\Requests\UpdateMudancaGestaoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MudancaGestaoController extends Controller
{
    public function index(): View
    {
        $mudancas = MudancaGestao::with(['empresa', 'solicitante', 'responsavelAprovacao', 'processo'])
            ->latest()
            ->paginate(15);

        return view('cadastros.mudancas_gestao.index', compact('mudancas'));
    }

    public function create(): View
    {
        return view('cadastros.mudancas_gestao.create', $this->dadosFormulario());
    }

    public function store(StoreMudancaGestaoRequest $request): RedirectResponse
    {
        MudancaGestao::create($request->validated());

        return redirect()->route('mudancas_gestao.index')
            ->with('success', 'Solicitação de Mudança criada com sucesso!');
    }

    public function show(MudancaGestao $mudancaGestao): View
    {
        $mudancaGestao->load([
            'empresa', 'solicitante', 'responsavelAprovacao', 'processo',
        ]);

        return view('cadastros.mudancas_gestao.show', compact('mudancaGestao'));
    }

    public function edit(MudancaGestao $mudancaGestao): View
    {
        return view('cadastros.mudancas_gestao.edit', array_merge(
            ['mudancaGestao' => $mudancaGestao],
            $this->dadosFormulario()
        ));
    }

    public function update(UpdateMudancaGestaoRequest $request, MudancaGestao $mudancaGestao): RedirectResponse
    {
        $mudancaGestao->update($request->validated());

        return redirect()->route('mudancas_gestao.index')
            ->with('success', 'Gestão de Mudança atualizada com sucesso!');
    }

    public function destroy(MudancaGestao $mudancaGestao): RedirectResponse
    {
        $mudancaGestao->delete();

        return redirect()->route('mudancas_gestao.index')
            ->with('success', 'Gestão de Mudança excluída!');
    }

    /**
     * Dados comuns às telas de create/edit.
     */
    private function dadosFormulario(): array
    {
        return [
            'empresaAtual'  => Empresa::first(),      // única empresa
            'solicitantes'  => User::orderBy('name')->get(),
            'aprovadores'   => User::orderBy('name')->get(),
            'processos'     => Processo::orderBy('nome')->get(), // ajuste o campo se não for 'nome'
        ];
    }
}