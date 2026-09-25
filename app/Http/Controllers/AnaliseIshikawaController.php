<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnaliseIshikawaRequest;
use App\Http\Requests\UpdateAnaliseIshikawaRequest;
use App\Models\AnaliseCausa;
use App\Models\AnaliseIshikawa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnaliseIshikawaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = AnaliseIshikawa::with(['analiseCausa', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('efeito_analisado', 'ilike', "%{$search}%")
                  ->orWhere('conclusao', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('analise_causa_id')) {
            $query->where('analise_causa_id', $request->input('analise_causa_id'));
        }

        $ishikawas = $query->latest()
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.analises_ishikawa.index', compact('ishikawas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $analises  = AnaliseCausa::orderBy('id')->get();
        $usuarios  = User::orderBy('name')->get();

        return view('cadastros.analises_ishikawa.create', [
            'analises'        => $analises,
            'usuarios'        => $usuarios,
            'analiseCausaId'  => $request->input('analise_causa_id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnaliseIshikawaRequest $request): RedirectResponse
    {
        AnaliseIshikawa::create($request->validated());

        return redirect()->route('analises_ishikawa.index')
            ->with('success', 'Análise Ishikawa criada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AnaliseIshikawa $analiseIshikawa): View
    {
        $analiseIshikawa->load(['analiseCausa', 'responsavel', 'causas']);

        return view('cadastros.analises_ishikawa.show', compact('analiseIshikawa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnaliseIshikawa $analiseIshikawa): View
    {
        $analises = AnaliseCausa::orderBy('id')->get();
        $usuarios = User::orderBy('name')->get();

        return view('cadastros.analises_ishikawa.edit', compact('analiseIshikawa', 'analises', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateAnaliseIshikawaRequest $request,
        AnaliseIshikawa $analiseIshikawa
    ): RedirectResponse {
        $analiseIshikawa->update($request->validated());

        return redirect()->route('analises_ishikawa.index')
            ->with('success', 'Análise Ishikawa atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnaliseIshikawa $analiseIshikawa): RedirectResponse
    {
        $analiseIshikawa->delete();

        return redirect()->route('analises_ishikawa.index')
            ->with('success', 'Análise Ishikawa removida com sucesso.');
    }
}
