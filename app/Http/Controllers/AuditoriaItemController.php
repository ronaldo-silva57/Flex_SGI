<?php

namespace App\Http\Controllers;

use App\Models\AuditoriaItem;
use App\Models\Auditoria;
use App\Models\Clausula;
use App\Models\Processo;
use App\Models\User;
use App\Http\Requests\StoreAuditoriaItemRequest;
use App\Http\Requests\UpdateAuditoriaItemRequest;
use Illuminate\Http\Request;

class AuditoriaItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AuditoriaItem::with([
            'auditoria.empresa',
            'clausula',
            'processo',
            'auditor',
        ]);

        // Filtro por Evidência, Conformidade, Auditoria ou Processo
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('descricao_verificacao', 'ilike', "%{$search}%")
                    ->orWhere('evidencia_coletada', 'ilike', "%{$search}%")
                    ->orWhere('conformidade', 'ilike', "%{$search}%")
                    ->orWhereHas('auditoria', fn ($a) => $a->where('titulo', 'ilike', "%{$search}%"))
                    ->orWhereHas('processo', fn ($p) => $p->where('nome', 'ilike', "%{$search}%"));
            });
        }

        $auditoriaItens = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.auditorias_itens.index', compact('auditoriaItens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auditorias = Auditoria::with('norma')->orderBy('created_at', 'desc')->get();
        $clausulas  = Clausula::orderBy('codigo')->get();
        $processos  = Processo::orderBy('nome')->get();
        $usuarios   = User::orderBy('name')->get();

        return view(
            'cadastros.auditorias_itens.create',
            compact('auditorias', 'clausulas', 'processos', 'usuarios')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuditoriaItemRequest $request)
    {
        AuditoriaItem::create($request->validated());

        return redirect()
            ->route('auditorias_itens.index')
            ->with('success', 'Item de auditoria cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AuditoriaItem $auditoriaItem)
    {
        $auditoriaItem->load([
            'auditoria.empresa', 
            'clausula', 
            'processo', 
            'auditor'
        ]);

        return view('cadastros.auditorias_itens.show', compact('auditoriaItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AuditoriaItem $auditoriaItem)
    {
        $auditorias = Auditoria::with('norma')->orderBy('created_at', 'desc')->get();
        $clausulas  = Clausula::orderBy('codigo')->get();
        $processos  = Processo::orderBy('nome')->get();
        $usuarios   = User::orderBy('name')->get();

        return view(
            'cadastros.auditorias_itens.edit',
            compact('auditoriaItem', 'auditorias', 'clausulas', 'processos', 'usuarios')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuditoriaItemRequest $request, AuditoriaItem $auditoriaItem)
    {
        $auditoriaItem->update($request->validated());

        return redirect()
            ->route('auditorias_itens.index')
            ->with('success', 'Item de auditoria atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuditoriaItem $auditoriaItem)
    {
        $auditoriaItem->delete();

        return redirect()
            ->route('auditorias_itens.index')
            ->with('success', 'Item de auditoria removido com sucesso!');
    }
}