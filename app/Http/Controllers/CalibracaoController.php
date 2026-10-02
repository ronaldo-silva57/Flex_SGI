<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCalibracaoRequest;
use App\Http\Requests\StoreCalibracaoRequest;
use App\Models\Calibracao;
use App\Models\EquipamentoMedicao;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CalibracaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $calibracoes = Calibracao::query()
            ->with(['equipamento', 'responsavel'])
            ->when($request->filled('equipamento_id'),
                fn ($q) => $q->where('equipamento_id', $request->integer('equipamento_id')))
            ->when($request->filled('resultado'),
                fn ($q) => $q->where('resultado', $request->string('resultado')))
            ->when($request->filled('busca'), function ($q) use ($request) {
                $b = '%' . $request->string('busca') . '%';
                $q->where(function ($q) use ($b) {
                    $q->where('laboratorio', 'ilike', $b)
                      ->orWhere('certificado_numero', 'ilike', $b);
                });
            })
            ->orderByDesc('data_calibracao')
            ->paginate(15)
            ->withQueryString();

        $equipamentos = EquipamentoMedicao::orderBy('nome')
            ->get(['id', 'codigo', 'nome']);

        return view('iso9001.equipamentos_medicao.calibracoes.index',compact('calibracoes', 'equipamentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('iso9001.equipamentos_medicao.calibracoes.create', [
            'equipamentos'  => EquipamentoMedicao::daEmpresa()->orderBy('nome')->get(['id', 'codigo', 'nome']),
            'responsaveis'  => $this->responsaveis(),
        ]);
    }

    private function responsaveis()
    {
        return User::orderBy('name')->get(['id', 'name']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCalibracaoRequest $request): RedirectResponse
    {
        $dados = $request->validated();
        $dados['responsavel_id'] ??= auth()->id();

        if ($request->hasFile('certificado')) {
            $dados['certificado_path'] = $request->file('certificado')
                ->store('certificados-calibracao', 'public');
        }
        unset($dados['certificado']);

        $calibracao = Calibracao::create($dados);

        return redirect()
            ->route('calibracoes.show', $calibracao)
            ->with('success', 'Calibração registrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Calibracao $calibracao): View
    {
        $calibracao->load(['equipamento', 'responsavel']);

        return view('iso9001.equipamentos_medicao.calibracoes.show', compact('calibracao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Calibracao $calibracao): View
    {
        $responsaveis = User::orderBy('name')->get(['id', 'name']);

        return view('iso9001.equipamentos_medicao.calibracoes.edit',
            compact('calibracao', 'responsaveis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCalibracaoRequest $request, Calibracao $calibracao): RedirectResponse
    {
        $dados = $request->validated();

        if ($request->hasFile('certificado')) {
            if ($calibracao->certificado_path) {
                Storage::disk('public')->delete($calibracao->certificado_path);
            }
            $dados['certificado_path'] = $request->file('certificado')
                ->store('certificados-calibracao', 'public');
        }
        unset($dados['certificado']);

        $calibracao->update($dados);

        return redirect()
            ->route('calibracoes.show', $calibracao)
            ->with('success', 'Calibração atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Calibracao $calibracao): RedirectResponse
    {
        if ($calibracao->certificado_path) {
            Storage::disk('public')->delete($calibracao->certificado_path);
        }

        $calibracao->delete();

        return redirect()
            ->route('calibracoes.index')
            ->with('success', 'Calibração excluída com sucesso.');
    }

    private function ensureBelongsTo(EquipamentoMedicao $equipamento, Calibracao $calibracao): void
    {
        abort_unless($calibracao->equipamento_id === $equipamento->id, 404);
    }
}
