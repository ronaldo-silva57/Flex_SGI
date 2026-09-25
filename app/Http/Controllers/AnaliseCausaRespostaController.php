<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnaliseCausaRespostaRequest;
use App\Http\Requests\UpdateAnaliseCausaRespostaRequest;
use App\Models\AnaliseCausa;
use App\Models\AnaliseCausaResposta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnaliseCausaRespostaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = AnaliseCausaResposta::with('analiseCausa');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('pergunta', 'ilike', "%{$search}%")
                  ->orWhere('resposta', 'ilike', "%{$search}%")
                  ->orWhere('evidencia', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('analise_causa_id')) {
            $query->where('analise_causa_id', $request->input('analise_causa_id'));
        }

        $respostas = $query->orderBy('analise_causa_id')
            ->orderBy('ordem')
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.analises_causa_respostas.index', compact('respostas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $analises = AnaliseCausa::orderBy('id')->get();

        return view('cadastros.analises_causa_respostas.create', [
            'analises'        => $analises,
            'analiseCausaId'  => $request->input('analise_causa_id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnaliseCausaRespostaRequest $request): RedirectResponse
    {
        AnaliseCausaResposta::create($request->validated());

        return redirect()->route('analises_causa_respostas.index')
            ->with('success', 'Resposta cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnaliseCausaResposta $analiseCausaResposta): View
    {
        $analiseCausaResposta->load('analiseCausa');

        return view('cadastros.analises_causa_respostas.show', compact('analiseCausaResposta'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnaliseCausaResposta $analiseCausaResposta): View
    {
        $analises = AnaliseCausa::orderBy('id')->get();

        return view('cadastros.analises_causa_respostas.edit', compact('analiseCausaResposta', 'analises'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateAnaliseCausaRespostaRequest $request,
        AnaliseCausaResposta $analiseCausaResposta
    ): RedirectResponse {
        $analiseCausaResposta->update($request->validated());

        return redirect()->route('analises_causa_respostas.index')
            ->with('success', 'Resposta atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnaliseCausaResposta $analiseCausaResposta): RedirectResponse
    {
        $analiseCausaResposta->delete();

        return redirect()->route('analises_causa_respostas.index')
            ->with('success', 'Resposta removida com sucesso.');
    }
}
