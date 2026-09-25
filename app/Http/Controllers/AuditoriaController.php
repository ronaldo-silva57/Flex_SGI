<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuditoriaRequest;
use App\Http\Requests\UpdateAuditoriaRequest;
use App\Models\Auditoria;
use App\Models\Empresa;
use App\Models\Norma;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $auditorias = Auditoria::with(['empresa', 'norma', 'auditorLider'])
            ->latest()
            ->paginate(15);

        return view('cadastros.auditorias.index', compact('auditorias'));
    }

   /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $empresas = Empresa::first();
        $normas = Norma::all();
        $usuarios = User::all();

        return view('cadastros.auditorias.create', compact('empresas', 'normas', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuditoriaRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $dados['status'] = 'Planejada';

        Auditoria::create($dados);

        return redirect()
            ->route('auditorias.index')
            ->with('success', 'Auditoria cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Auditoria $auditoria): View
    {
        $auditoria->load(['empresa', 'norma', 'auditorLider']);

        return view('cadastros.auditorias.show', compact('auditoria'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Auditoria $auditoria): View
    {
        $empresas = Empresa::first();
        $normas = Norma::all();
        $usuarios = User::all();

        return view('cadastros.auditorias.edit', compact('auditoria', 'empresas', 'normas', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuditoriaRequest $request,Auditoria $auditoria): RedirectResponse 
    {
        $auditoria->update($request->validated());

        return redirect()
            ->route('auditorias.index')
            ->with('success', 'Auditoria atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auditoria $auditoria): RedirectResponse
    {
        $auditoria->delete();

        return redirect()
            ->route('auditorias.index')
            ->with('success', 'Auditoria removida com sucesso.');
    }
}