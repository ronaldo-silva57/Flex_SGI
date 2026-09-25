<?php

namespace App\Http\Controllers;

use App\Models\AcaoCorretiva;
use App\Models\NaoConformidade;
use App\Models\User;
use App\Http\Requests\StoreAcaoCorretivaRequest;
use App\Http\Requests\UpdateAcaoCorretivaRequest;
use Illuminate\Http\Request;

class AcaoCorretivaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = AcaoCorretiva::with([
            'naoConformidade',
            'responsavel',
        ]);

        // Filtro por descrição, etapa, status ou não conformidade relacionada
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('descricao', 'ilike', "%{$search}%")
                    ->orWhere('etapa', 'ilike', "%{$search}%")
                    ->orWhere('status', 'ilike', "%{$search}%")
                    ->orWhereHas('naoConformidade', function ($nc) use ($search) {
                        $nc->where('titulo', 'ilike', "%{$search}%")
                            ->orWhere('codigo', 'ilike', "%{$search}%");
                    });
            });
        }

        $acoesCorretivas = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'iso9001.acoes_corretivas.index',
            compact('acoesCorretivas')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $naoConformidades = NaoConformidade::orderBy('created_at', 'desc')->get();
        $usuarios = User::orderBy('name')->get();

        return view(
            'iso9001.acoes_corretivas.create',
            compact('naoConformidades', 'usuarios')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcaoCorretivaRequest $request)
    {
        $data = $request->validated();

        AcaoCorretiva::create($data);

        return redirect()
            ->route('acoes_corretivas.index')
            ->with('success', 'Ação Corretiva cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AcaoCorretiva $acaoCorretiva)
    {
        $acaoCorretiva->load([
            'naoConformidade',
            'responsavel',
        ]);

        return view(
            'iso9001.acoes_corretivas.show',
            compact('acaoCorretiva')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcaoCorretiva $acaoCorretiva)
    {
        $naoConformidades = NaoConformidade::orderBy('created_at', 'desc')->get();
        $usuarios = User::orderBy('name')->get();

        return view(
            'iso9001.acoes_corretivas.edit',
            compact(
                'acaoCorretiva',
                'naoConformidades',
                'usuarios'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateAcaoCorretivaRequest $request,
        AcaoCorretiva $acaoCorretiva
    ) {
        $data = $request->validated();

        $acaoCorretiva->update($data);

        return redirect()
            ->route('acoes_corretivas.index')
            ->with('success', 'Ação Corretiva atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcaoCorretiva $acaoCorretiva)
    {
        $acaoCorretiva->delete();

        return redirect()
            ->route('acoes_corretivas.index')
            ->with('success', 'Ação Corretiva removida com sucesso!');
    }
}