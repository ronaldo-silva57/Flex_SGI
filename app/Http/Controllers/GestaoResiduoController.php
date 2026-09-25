<?php

namespace App\Http\Controllers;

use App\Models\GestaoResiduo;
use App\Models\Processo;
use App\Models\User;
use App\Http\Requests\UpdateGestaoResiduoRequest;
use App\Http\Requests\StoreGestaoResiduoRequest;
use Illuminate\Http\Request;

class GestaoResiduoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        $query = GestaoResiduo::with(['processo', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%")
                  ->orWhere('fonte_geradora', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        $residuos = $query->latest()->paginate(10);

        return view('iso14001.gestao_residuos.index', compact('residuos'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $processos = Processo::pluck('nome', 'id');
        $usuarios = User::pluck('name', 'id');

        return view('iso14001.gestao_residuos.create', compact('processos', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGestaoResiduoRequest $request)
    {
        $data = $request->validated();
        $data['empresa_id'] = $request->user()->empresa_id ?? 1;

        GestaoResiduo::create($data);

        return redirect()->route('gestao_residuos.index')->with('success', 'Resíduo cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(GestaoResiduo $gestaoResiduo)
    {
        $gestaoResiduo->load(['processo', 'responsavel', 'empresa']);
        return view('iso14001.gestao_residuos.show', ['residuo' => $gestaoResiduo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GestaoResiduo $gestaoResiduo)
    {
        $processos = Processo::pluck('nome', 'id');
        $usuarios = User::pluck('name', 'id');

        return view('iso14001.gestao_residuos.edit', [
            'residuo' => $gestaoResiduo,
            'processos' => $processos,
            'usuarios' => $usuarios
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGestaoResiduoRequest $request, GestaoResiduo $gestaoResiduo)
    {
        $gestaoResiduo->update($request->validated());

        return redirect()->route('gestao_residuos.index')->with('success', 'Resíduo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GestaoResiduo $gestaoResiduo)
    {
        $gestaoResiduo->delete();
        return redirect()->route('gestao_residuos.index')->with('success', 'Resíduo excluído com sucesso!');
    }
}
