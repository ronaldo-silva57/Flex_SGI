<?php

namespace App\Http\Controllers;

use App\Models\Norma;
use App\Http\Requests\StoreNormaRequest;
use App\Http\Requests\UpdateNormaRequest;
use Illuminate\Http\Request;

class NormaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Norma::query();

        // Filtro por Código ou Nome
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'ilike', "%{$search}%")
                ->orWhere('nome', 'ilike', "%{$search}%");
            });
        }

        // Filtro por status (ativo)
        if ($request->filled('ativo')) {
            $query->where('ativo', $request->boolean('ativo'));
        }

        $normas = $query->orderBy('codigo')->paginate(15);

        return view('iso9001.normas.index', compact('normas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('iso9001.normas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNormaRequest $request)
    {
        $data = $request->validated();
        $data['ativo'] = $request->boolean('ativo');

        Norma::create($data);

        return redirect()->route('normas.index')
                        ->with('success', 'Norma cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Norma $norma)
    {
        return view('iso9001.normas.show', compact('norma'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Norma $norma)
    {
        return view('iso9001.normas.edit', compact('norma'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNormaRequest $request, Norma $norma)
    {
        $data = $request->validated();
        $data['ativo'] = $request->boolean('ativo');

        $norma->update($data);

        return redirect()->route('normas.index')
                        ->with('success', 'Norma atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Norma $norma)
    {
        $norma->delete();

        return redirect()->route('normas.index')
                        ->with('success', 'Norma removida com sucesso!');
    }
}
