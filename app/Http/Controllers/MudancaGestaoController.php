<?php

namespace App\Http\Controllers;

use App\Models\MudancaGestao;
use App\Http\Requests\StoreMudancaGestaoRequest;
use App\Http\Requests\UpdateMudancaGestaoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MudancaGestaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $mudancas = MudancaGestao::with(['empresa', 'solicitante', 'processo'])
            ->latest()
            ->paginate(15);

        return view('mudancas_gestao.index', compact('mudancas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('mudancas_gestao.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMudancaGestaoRequest $request): RedirectResponse
    {
        MudancaGestao::create($request->validated());

        return redirect()->route('v.index')
            ->with('success', 'Solicitação de Mudança criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MudancaGestao $mudancasGestao): View
    {
        return view('mudancas_gestao.edit', compact('mudancasGestao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMudancaGestaoRequest $request, MudancaGestao $mudancasGestao): RedirectResponse
    {
        $mudancasGestao->update($request->validated());

        return redirect()->route('mudancas_gestao.index')
            ->with('success', 'Gestão de Mudança atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
