<?php

namespace App\Http\Controllers;

use App\Models\AnaliseRiscoTi;
use App\Http\Requests\StoreAnaliseRiscoTiRequest;
use App\Http\Requests\UpdateAnaliseRiscoTiRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AnaliseRiscoTiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $riscos = AnaliseRiscoTi::with(['empresa', 'ativo', 'responsavel'])
            ->latest()
            ->paginate(15);

        return view('iso27001.analises_risco_ti.index', compact('riscos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $empresas = \App\Models\Empresa::pluck('razao_social', 'id');
        $ativos = \App\Models\AtivoInformacao::pluck('nome', 'id');
        $usuarios = \App\Models\User::pluck('name', 'id');

        return view('iso27001.analises_risco_ti.create', compact('empresas', 'ativos', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnaliseRiscoTiRequest $request): RedirectResponse
    {
        AnaliseRiscoTi::create($request->validated());

        return redirect()->route('analises_risco_ti.index')
            ->with('success', 'Risco de Segurança da Informação mapeado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnaliseRiscoTi $analisesRiscoTi): View
    {
        $analisesRiscoTi->load(['empresa', 'ativo', 'responsavel']);
        return view('iso27001.analises_risco_ti.show', compact('analisesRiscoTi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnaliseRiscoTi $analisesRiscoTi): View
    {
        $empresas = \App\Models\Empresa::pluck('razao_social', 'id');
        $ativos = \App\Models\AtivoInformacao::pluck('nome', 'id');
        $usuarios = \App\Models\User::pluck('name', 'id');

        return view('iso27001.analises_risco_ti.edit', compact('analisesRiscoTi', 'empresas', 'ativos', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnaliseRiscoTiRequest $request, AnaliseRiscoTi $analisesRiscoTi): RedirectResponse
    {
        $analisesRiscoTi->update($request->validated());

        return redirect()->route('analises_risco_ti.index')
            ->with('success', 'Análise de Risco de TI atualizada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnaliseRiscoTi $analisesRiscoTi): RedirectResponse
    {
        $analisesRiscoTi->delete();

        return redirect()->route('analises_risco_ti.index')
            ->with('success', 'Registro removido!');
    }
}
