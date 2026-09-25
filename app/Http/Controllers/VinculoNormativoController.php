<?php

namespace App\Http\Controllers;

use App\Models\VinculoNormativo;
use App\Models\Norma;
use App\Models\Clausula;
use App\Models\Processo;
use App\Models\Documento;
use App\Models\Indicador;
use App\Models\RiscoOportunidade;
use App\Models\RegistroLegal;
use App\Models\EsgIndicador;
use App\Http\Requests\StoreVinculoNormativoRequest;
use App\Http\Requests\UpdateVinculoNormativoRequest;
use Illuminate\Http\Request;

class VinculoNormativoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VinculoNormativo::with([
            'norma', 'clausula', 'processo', 'documento',
            'indicador', 'risco', 'requisitoLegal', 'esgIndicador'
        ]);

        // Filtro por busca em norma ou cláusula
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('norma', function ($q) use ($search) {
                $q->where('nome', 'ilike', "%{$search}%");
            })->orWhereHas('clausula', function ($q) use ($search) {
                $q->where('descricao', 'ilike', "%{$search}%");
            });
        }

        $vinculos = $query
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('esg.vinculos_normativos.index', compact('vinculos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $normas = Norma::orderBy('nome')->get();
        $clausulas = Clausula::orderBy('descricao')->get();
        $processos = Processo::orderBy('nome')->get();
        $documentos = Documento::orderBy('titulo')->get();
        $indicadores = Indicador::orderBy('nome')->get();
        $riscos = RiscoOportunidade::orderBy('descricao')->get();
        $requisitos = RegistroLegal::orderBy('descricao')->get();
        $esgIndicadores = EsgIndicador::where('ativo', true)->orderBy('nome')->get();

        return view('esg.vinculos_normativos.create', compact(
            'normas', 'clausulas', 'processos', 'documentos',
            'indicadores', 'riscos', 'requisitos', 'esgIndicadores'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVinculoNormativoRequest $request)
    {
        $data = $request->validated();
        VinculoNormativo::create($data);

        return redirect()
            ->route('vinculos_normativos.index')
            ->with('success', 'Vínculo normativo criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VinculoNormativo $vinculos_normativo)
    {
        $vinculos_normativo->load([
            'norma', 'clausula', 'processo', 'documento',
            'indicador', 'risco', 'requisitoLegal', 'esgIndicador'
        ]);

        return view('esg.vinculos_normativos.show', compact('vinculos_normativo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VinculoNormativo $vinculos_normativo)
    {
        $normas = Norma::orderBy('nome')->get();
        $clausulas = Clausula::orderBy('descricao')->get();
        $processos = Processo::orderBy('nome')->get();
        $documentos = Documento::orderBy('titulo')->get();
        $indicadores = Indicador::orderBy('nome')->get();
        $riscos = RiscoOportunidade::orderBy('descricao')->get();
        $requisitos = RegistroLegal::orderBy('descricao')->get();
        $esgIndicadores = EsgIndicador::where('ativo', true)->orderBy('nome')->get();

        return view('esg.vinculos_normativos.edit', compact(
            'vinculos_normativo',
            'normas', 'clausulas', 'processos', 'documentos',
            'indicadores', 'riscos', 'requisitos', 'esgIndicadores'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVinculoNormativoRequest $request, VinculoNormativo $vinculos_normativo)
    {
        $data = $request->validated();
        $vinculos_normativo->update($data);

        return redirect()
            ->route('vinculos_normativos.index')
            ->with('success', 'Vínculo normativo atualizado com sucesso.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VinculoNormativo $vinculos_normativo)
    {
        $vinculos_normativo->delete();

        return redirect()
            ->route('vinculos_normativos.index')
            ->with('success', 'Vínculo normativo removido com sucesso.');
    }
}
