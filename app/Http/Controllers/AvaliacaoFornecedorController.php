<?php

namespace App\Http\Controllers;

use App\Models\AvaliacaoFornecedor;
use App\Models\Empresa;
use App\Models\Fornecedor;
use App\Models\User;
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

        return view('cadastros.avaliacoes_fornecedores.index', compact('avaliacoes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('cadastros.avaliacoes_fornecedores.create', [
            'empresa'      => Empresa::orderBy('razao_social')->first(),
            'fornecedores' => Fornecedor::orderBy('razao_social')->get(),
            'avaliadores'  => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAvaliacaoFornecedorRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['nota_final'] = $this->calcularNotaFinal($data);

        AvaliacaoFornecedor::create($data);

        return redirect()->route('avaliacoes_fornecedores.index')
            ->with('success', 'Avaliação de fornecedor registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AvaliacaoFornecedor $avaliacaoFornecedor): View
    {
        $avaliacaoFornecedor->load(['empresa', 'fornecedor', 'avaliador']);

        return view('cadastros.avaliacoes_fornecedores.show', compact('avaliacaoFornecedor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AvaliacaoFornecedor $avaliacaoFornecedor): View
    {
        return view('cadastros.avaliacoes_fornecedores.edit', [
            'avaliacaoFornecedor' => $avaliacaoFornecedor,
            'empresas'            => Empresa::orderBy('razao_social')->get(),
            'fornecedores'        => Fornecedor::orderBy('razao_social')->get(),
            'avaliadores'         => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAvaliacaoFornecedorRequest $request, AvaliacaoFornecedor $avaliacaoFornecedor): RedirectResponse
    {
        $data = $request->validated();
        $data['nota_final'] = $this->calcularNotaFinal($data, $avaliacaoFornecedor);

        $avaliacaoFornecedor->update($data);

        return redirect()->route('avaliacoes_fornecedores.index')
            ->with('success', 'Avaliação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AvaliacaoFornecedor $avaliacaoFornecedor): RedirectResponse
    {
        $avaliacaoFornecedor->delete();

        return redirect()->route('avaliacoes_fornecedores.index')
            ->with('success', 'Avaliação excluída!');
    }

    /**
     * Calcula a média das notas preenchidas caso nota_final não venha no request.
     */
    private function calcularNotaFinal(array $data, ?AvaliacaoFornecedor $atual = null): ?float
    {
        if (!empty($data['nota_final'])) {
            return $data['nota_final'];
        }

        $notas = array_filter([
            $data['nota_qualidade']     ?? $atual?->nota_qualidade,
            $data['nota_prazo']         ?? $atual?->nota_prazo,
            $data['nota_atendimento']   ?? $atual?->nota_atendimento,
            $data['nota_esg_ambiental'] ?? $atual?->nota_esg_ambiental,
        ], fn ($n) => !is_null($n) && $n !== '');

        return count($notas) > 0 ? round(array_sum($notas) / count($notas), 2) : null;
    }
}
