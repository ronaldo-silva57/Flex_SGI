<?php

namespace App\Http\Controllers;

use App\Models\Epi;
use App\Models\Empresa;
use App\Http\Requests\StoreEpiRequest;
use App\Http\Requests\UpdateEpiRequest;
use Illuminate\Http\Request;

class EpiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::first();

        $query = Epi::where('empresa_id', $empresa->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'LIKE', "%{$search}%")
                  ->orWhere('categoria', 'LIKE', "%{$search}%");
            });
        }

        $epis = $query->orderBy('nome')->paginate(15);

        return view('iso45001.epis.index', compact('epis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        return view('iso45001.epis.create', compact('empresa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEpiRequest $request)
    {
        $validated = $request->validated();
        Epi::create($validated);

        return redirect()->route('epis.index')->with('success', 'EPI criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Epi $epi)
    {
        $epi->load('usuarios.usuario');
        return view('iso45001.epis.show', compact('epi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Epi $epi)
    {
        $empresa = Empresa::find($epi->empresa_id);
        return view('iso45001.epis.edit', compact('epi', 'empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEpiRequest $request, Epi $epi)
    {
        $validated = $request->validated();
        $epi->update($validated);

        return redirect()->route('epis.index')->with('success', 'EPI atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Epi $epi)
    {
        $epi->delete();
        return redirect()->route('epis.index')->with('success', 'EPI excluído com sucesso.');
    }
}
