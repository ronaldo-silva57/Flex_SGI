<?php

namespace App\Http\Controllers;

use App\Models\Monitoramento;
use App\Models\Indicador;
use App\Models\User;
use App\Http\Requests\StoreMonitoramentoRequest;
use App\Http\Requests\UpdateMonitoramentoRequest;
use Illuminate\Http\Request;

class MonitoramentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Monitoramento::with([
            'indicador',
            'responsavel',
        ]);

        // Filtro por período, Status, indicador ou Nome
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('periodo_referencia', 'ilike', "%{$search}%")
                    ->orWhere('status', 'ilike', "%{$search}%")
                    ->orWhereHas('indicador', function ($indicador) use ($search) {
                        $indicador->where('codigo', 'ilike', "%{$search}%")
                            ->orWhere('nome', 'ilike', "%{$search}%");
                    });
            });
        }

        $monitoramentos = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'iso9001.monitoramentos.index',
            compact('monitoramentos')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $indicadores = Indicador::where('ativo', true)
            ->orderBy('codigo')
            ->get();

        $usuarios = User::orderBy('name')->get();

        return view(
            'iso9001.monitoramentos.create',
            compact('indicadores', 'usuarios')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMonitoramentoRequest $request)
    {
        $data = $request->validated();

        Monitoramento::create($data);

        return redirect()
            ->route('monitoramentos.index')
            ->with('success', 'Monitoramento cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Monitoramento $monitoramento)
    {
        $monitoramento->load([
            'indicador',
            'responsavel',
        ]);

        return view(
            'iso9001.monitoramentos.show',
            compact('monitoramento')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Monitoramento $monitoramento)
    {
        $indicadores = Indicador::where('ativo', true)
            ->orderBy('codigo')
            ->get();

        $usuarios = User::orderBy('name')->get();

        return view(
            'iso9001.monitoramentos.edit',
            compact(
                'monitoramento',
                'indicadores',
                'usuarios'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateMonitoramentoRequest $request,
        Monitoramento $monitoramento
    ) {
        $data = $request->validated();

        $monitoramento->update($data);

        return redirect()
            ->route('monitoramentos.index')
            ->with('success', 'Monitoramento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Monitoramento $monitoramento)
    {
        $monitoramento->delete();

        return redirect()
            ->route('monitoramentos.index')
            ->with('success', 'Monitoramento removido com sucesso!');
    }
}