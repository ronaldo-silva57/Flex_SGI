<?php

namespace App\Http\Controllers;

use App\Models\AvaliacaoFornecedor;
use App\Http\Requests\StoreAvaliacaoFornecedorRequest;
use App\Http\Requests\UpdateAvaliacaoFornecedorRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AvaliacaoFornecedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(): View
    {
        $avaliacoes = AvaliacaoFornecedor::with(['empresa', 'fornecedor', 'avaliador'])
            ->latest()
            ->paginate(15);

        return view('avaliacoes_fornecedores.index', compact('avaliacoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('avaliacoes_fornecedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAvaliacaoFornecedorRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Cálculo da média ponderada automática se nota_final não for digitada manualmente
        if (empty($data['nota_final'])) {
            $notas = array_filter([
                $data['nota_qualidade'] ?? null,
                $data['nota_prazo'] ?? null,
                $data['nota_atendimento'] ?? null,
                $data['nota_esg_ambiental'] ?? null,
            ], fn($n) => !is_null($n));

            $data['nota_final'] = count($notas) > 0 ? array_sum($notas) / count($notas) : 0;
        }

        AvaliacaoFornecedor::create($data);

        return redirect()->route('avaliacoes_fornecedores.index')
            ->with('success', 'Avaliação de fornecedor concluída com sucesso!');
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
    public function edit(AvaliacaoFornecedor $avaliacoesFornecedor): View
    {
        return view('avaliacoes_fornecedores.edit', compact('avaliacoesFornecedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAvaliacaoFornecedorRequest $request, AvaliacaoFornecedor $avaliacoesFornecedor): RedirectResponse
    {
        $avaliacoesFornecedor->update($request->validated());

        return redirect()->route('avaliacoes_fornecedores.index')
            ->with('success', 'Avaliação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvaliacaoFornecedor $avaliacoesFornecedor): RedirectResponse
    {
        $avaliacoesFornecedor->delete();

        return redirect()->route('avaliacoes_fornecedores.index')
            ->with('success', 'Avaliação excluída!');
    }
}
