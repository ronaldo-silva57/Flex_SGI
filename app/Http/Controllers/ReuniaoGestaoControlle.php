<?php

namespace App\Http\Controllers;

use App\Models\ReuniaoGestao;
use App\Models\Empresa;
use App\Models\User;
use App\Http\Requests\StoreReuniaoGestaoRequest;
use App\Http\Requests\UpdateReuniaoGestaoRequest;
use Illuminate\Http\Request;

class ReuniaoGestaoControlle extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ReuniaoGestao::with(['empresa', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tipo', 'ilike', "%{$search}%")
                    ->orWhere('pauta', 'ilike', "%{$search}%")
                    ->orWhere('decisoes', 'ilike', "%{$search}%")
                    ->orWhereHas('empresa', fn($e) => $e->where('nome_fantasia', 'ilike', "%{$search}%")
                        ->orWhere('razao_social', 'ilike', "%{$search}%"))
                    ->orWhereHas('responsavel', fn($u) => $u->where('name', 'ilike', "%{$search}%"));
            });
        }

        $reunioes = $query->latest('data_reuniao')->paginate(15)->withQueryString();

        return view('iso9001.reunioes_gestao.index', compact('reunioes'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::where('ativo', true)->first();
        $usuarios = User::orderBy('name')->get();

        return view('iso9001.reunioes_gestao.create', compact('empresa', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReuniaoGestaoRequest $request)
    {
        ReuniaoGestao::create($request->validated());

        return redirect()
            ->route('reunioes_gestao.index')
            ->with('success', 'Reunião de gestão cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ReuniaoGestao $reunioesGestao)
    {
        $reunioesGestao->load(['empresa', 'responsavel']);

        return view('iso9001.reunioes_gestao.show', compact('reunioesGestao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReuniaoGestao $reunioesGestao)
    {
        $empresa = $reunioesGestao->empresa ?? Empresa::where('ativo', true)->first();
        $usuarios = User::orderBy('name')->get();

        return view('iso9001.reunioes_gestao.edit', compact('reunioesGestao', 'empresa', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReuniaoGestaoRequest $request, ReuniaoGestao $reunioesGestao)
    {
        $reunioesGestao->update($request->validated());

        return redirect()
            ->route('reunioes_gestao.index')
            ->with('success', 'Reunião de gestão atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReuniaoGestao $reunioesGestao)
    {
        $reunioesGestao->delete();

        return redirect()
            ->route('reunioes_gestao.index')
            ->with('success', 'Reunião de gestão removida com sucesso!');
    }
}
