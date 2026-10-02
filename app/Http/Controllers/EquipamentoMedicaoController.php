<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalibracaoRequest;
use App\Http\Requests\StoreEquipamentoMedicaoRequest;
use App\Http\Requests\UpdateEquipamentoMedicaoRequest;
use App\Models\Calibracao;
use App\Models\EquipamentoMedicao;
use App\Models\User;
use Illuminate\Http\Request;

class EquipamentoMedicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $equipamentos = EquipamentoMedicao::query()
            ->daEmpresa()
            ->with('responsavel:id,name')
            ->when($request->busca, fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('nome', 'ilike', "%{$request->busca}%")
                  ->orWhere('codigo', 'ilike', "%{$request->busca}%")
                  ->orWhere('numero_serie', 'ilike', "%{$request->busca}%");
            }))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->filtro === 'vencidos', fn ($q) => $q->whereDate('proxima_calibracao', '<', now()))
            ->when($request->filtro === '30d', fn ($q) => $q->whereBetween('proxima_calibracao', [now(), now()->addDays(30)]))
            ->orderByRaw('proxima_calibracao IS NULL, proxima_calibracao ASC')
            ->paginate(15)->withQueryString();

        return view('iso9001.equipamentos_medicao.index', compact('equipamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('iso9001.equipamentos_medicao.create', [
            'responsaveis' => $this->responsaveis(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipamentoMedicaoRequest $request)
    {
        $data = $request->validated();
        $data['empresa_id'] = auth()->user()->empresa_id;

        EquipamentoMedicao::create($data);

        return redirect()->route('equipamentos_medicao.index')
            ->with('success', 'Equipamento cadastrado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipamentoMedicao $equipamentosMedicao)
    {
        //$this->authorizeEmpresa($equipamentosMedicao);
        $equipamentosMedicao->load(['responsavel', 'calibracoes.responsavel']);

        return view('iso9001.equipamentos_medicao.show', ['equipamento' => $equipamentosMedicao]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipamentoMedicao $equipamentosMedicao)
    {
        //$this->authorizeEmpresa($equipamentosMedicao);

        return view('iso9001.equipamentos_medicao.edit', [
            'equipamento'  => $equipamentosMedicao,
            'responsaveis' => $this->responsaveis(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipamentoMedicaoRequest $request, EquipamentoMedicao $equipamentosMedicao)
    {
        //$this->authorizeEmpresa($equipamentosMedicao);
        $equipamentosMedicao->update($request->validated());

        return redirect()->route('equipamentos_medicao.show', $equipamentosMedicao)
            ->with('success', 'Equipamento atualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipamentoMedicao $equipamentosMedicao)
    {
        //$this->authorizeEmpresa($equipamentosMedicao);
        $equipamentosMedicao->delete();

        return redirect()->route('equipamentos_medicao.index')
            ->with('success', 'Equipamento removido.');
    }

    public function storeCalibracao(StoreCalibracaoRequest $request, EquipamentoMedicao $equipamentosMedicao)
    {
        //$this->authorizeEmpresa($equipamentosMedicao);

        $equipamentosMedicao->calibracoes()->create($request->validated());

        return back()->with('success', 'Calibração registrada.');
    }

    private function responsaveis()
    {
        return User::where('empresa_id', auth()->user()->empresa_id)
            ->where('ativo', true)->orderBy('name')->get(['id', 'name']);
    }
}
