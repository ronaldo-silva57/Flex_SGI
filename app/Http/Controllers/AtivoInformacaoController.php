<?php

namespace App\Http\Controllers;

use App\Models\AtivoInformacao;
use App\Models\Empresa;
use App\Models\User;
use App\Http\Requests\StoreAtivosInformacaoRequest;
use App\Http\Requests\UpdateAtivosInformacaoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtivoInformacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::first();
        $query = AtivoInformacao::where('empresa_id', $empresa->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'LIKE', "%{$search}%")
                  ->orWhere('descricao', 'LIKE', "%{$search}%")
                  ->orWhere('localizacao', 'LIKE', "%{$search}%");
            });
        }

        $ativos = $query->with(['responsavel', 'proprietario'])->orderBy('nome')->paginate(15);

        return view('iso27001.ativos_informacao.index', compact('ativos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        $usuarios = User::all(); // ou filtrar por empresa
        return view('iso27001.ativos_informacao.create', compact('empresa', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAtivosInformacaoRequest $request)
    {
        $validated = $request->validated();
        if (empty($validated['responsavel_id'])) {
            $validated['responsavel_id'] = Auth::id();
        }
        AtivoInformacao::create($validated);

        return redirect()->route('ativos_informacao.index')->with('success', 'Ativo de informação criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AtivoInformacao $ativosInformacao)
    {
        $ativosInformacao->load(['responsavel', 'proprietario', 'controles', 'incidentes']);
        return view('iso27001.ativos_informacao.show', compact('ativosInformacao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AtivoInformacao $ativosInformacao)
    {
        $empresa = Empresa::find($ativosInformacao->empresa_id);
        $usuarios = User::all();
        return view('iso27001.ativos_informacao.edit', compact('ativosInformacao', 'empresa', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAtivosInformacaoRequest $request, AtivoInformacao $ativosInformacao)
    {
        $validated = $request->validated();
        $ativosInformacao->update($validated);

        return redirect()->route('ativos_informacao.index')->with('success', 'Ativo atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AtivoInformacao $ativosInformacao)
    {
        $ativosInformacao->delete();
        return redirect()->route('ativos_informacao.index')->with('success', 'Ativo excluído com sucesso.');
    }
}
