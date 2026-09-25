<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIshikawaCausaRequest;
use App\Http\Requests\UpdateIshikawaCausaRequest;
use App\Models\AnaliseIshikawa;
use App\Models\IshikawaCausa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IshikawaCausaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = IshikawaCausa::with(['analiseIshikawa', 'responsavelValidacao']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('categoria', 'ilike', "%{$search}%")
                  ->orWhere('descricao', 'ilike', "%{$search}%")
                  ->orWhere('evidencia', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('analise_ishikawa_id')) {
            $query->where('analise_ishikawa_id', $request->input('analise_ishikawa_id'));
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->input('categoria'));
        }

        $causas = $query->latest()
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.ishikawa_causas.index', compact('causas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $ishikawas = AnaliseIshikawa::orderBy('id')->get();
        $usuarios  = User::orderBy('name')->get();

        return view('cadastros.ishikawa_causas.create', [
            'ishikawas'           => $ishikawas,
            'usuarios'            => $usuarios,
            'analiseIshikawaId'   => $request->input('analise_ishikawa_id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIshikawaCausaRequest $request): RedirectResponse
    {
        IshikawaCausa::create($request->validated());

        return redirect()->route('ishikawa_causas.index')
            ->with('success', 'Causa Ishikawa cadastrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(IshikawaCausa $ishikawaCausa): View
    {
        $ishikawaCausa->load(['analiseIshikawa', 'responsavelValidacao']);

        return view('cadastros.ishikawa_causas.show', compact('ishikawaCausa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IshikawaCausa $ishikawaCausa): View
    {
        $ishikawas = AnaliseIshikawa::orderBy('id')->get();
        $usuarios  = User::orderBy('name')->get();

        return view('cadastros.ishikawa_causas.edit', compact('ishikawaCausa', 'ishikawas', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateIshikawaCausaRequest $request,
        IshikawaCausa $ishikawaCausa
    ): RedirectResponse {
        $ishikawaCausa->update($request->validated());

        return redirect()->route('ishikawa_causas.index')
            ->with('success', 'Causa Ishikawa atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IshikawaCausa $ishikawaCausa): RedirectResponse
    {
        $ishikawaCausa->delete();

        return redirect()->route('ishikawa_causas.index')
            ->with('success', 'Causa Ishikawa removida com sucesso.');
    }
}
