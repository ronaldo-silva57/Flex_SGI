<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClausulaRequest;
use App\Http\Requests\UpdateClausulaRequest;
use App\Models\Clausula;
use Illuminate\Http\Request;
use App\Models\Norma; 

class ClausulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Clausula::with('norma')
            ->select('clausulas.*') 
            ->join('normas', 'clausulas.norma_id', '=', 'normas.id')
            ->orderBy('normas.nome', 'asc'); 

        // Filtro por Código, Título ou Descrição
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('clausulas.codigo', 'ilike', "%{$search}%")
                ->orWhere('clausulas.titulo', 'ilike', "%{$search}%")
                ->orWhere('clausulas.descricao', 'ilike', "%{$search}%")
                ->orWhere('normas.codigo', 'ilike', "%{$search}%")
                ->orWhere('normas.nome', 'ilike', "%{$search}%");
            });
        }

        $clausulas = $query->paginate(10);

        return view('iso9001.clausulas.index', compact('clausulas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $normas = Norma::orderBy('codigo')->get();
        $clausulasPai = Clausula::orderBy('codigo')->get();

        return view('iso9001.clausulas.create', compact('normas', 'clausulasPai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClausulaRequest $request)
    {
        $clausula = Clausula::create($request->validated()); 

        return redirect()
            ->route('clausulas.index', $clausula) 
            ->with('success', 'Cláusula criada com sucesso!');
    }

   /**
     * Display the specified resource.
     */
    public function show(Clausula $clausula)
    {
        return view('iso9001.clausulas.show', compact('clausula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clausula $clausula)
    {
        $normas = Norma::orderBy('codigo')->get(); 
        $clausulasPai = Clausula::where('norma_id', $clausula->norma_id)
            ->where('id', '!=', $clausula->id)
            ->orderBy('codigo')
            ->get();

        return view('iso9001.clausulas.edit', compact('clausula', 'normas', 'clausulasPai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClausulaRequest $request, Clausula $clausula)
    {
        $clausula->update($request->validated());

        return redirect()
            ->route('clausulas.index')
            ->with('success', 'Cláusula atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Clausula $clausula)
    {
        $clausula->delete();

        return redirect()
            ->route('clausulas.index')
            ->with('success', 'Cláusula removida com sucesso!');
    }
}
