<?php

namespace App\Http\Controllers;

use App\Models\NaoConformidadeAmbiental;
use App\Models\LicencaAmbiental;
use App\Models\AspectoAmbiental;
use App\Models\Processo;
use App\Models\User;
use App\Http\Requests\StoreNaoConformidadeAmbientalRequest;
use App\Http\Requests\UpdateNaoConformidadeAmbientalRequest;
use Illuminate\Http\Request;

class NaoConformidadeAmbientalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = NaoConformidadeAmbiental::with([
            'empresa','licencaAmbiental','aspectoAmbiental','processo',
            'responsavelApuracao','responsavelTratamento'
        ]);

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('codigo','ilike',"%{$s}%")
                  ->orWhere('titulo','ilike',"%{$s}%")
                  ->orWhere('descricao','ilike',"%{$s}%");
            });
        }
        if ($request->filled('status'))   { $query->where('status',   $request->input('status')); }
        if ($request->filled('gravidade')){ $query->where('gravidade',$request->input('gravidade')); }
        if ($request->filled('origem'))   { $query->where('origem',   $request->input('origem')); }

        $naoConformidades = $query->latest()->paginate(10)->withQueryString();

        return view('iso14001.nao_conformidades_ambientais.index', compact('naoConformidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $licencas  = LicencaAmbiental::pluck('titulo','id');
        $aspectos  = AspectoAmbiental::pluck('descricao','id');
        $processos = Processo::pluck('nome','id');
        $usuarios  = User::pluck('name','id');

        return view('iso14001.nao_conformidades_ambientais.create',
            compact('licencas','aspectos','processos','usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNaoConformidadeAmbientalRequest $request)
    {
        $data = $request->validated();
        $data['empresa_id'] = $request->user()->empresa_id ?? 1;
        $data['recorrente'] = $request->boolean('recorrente');

        NaoConformidadeAmbiental::create($data);

        return redirect()->route('nao_conformidades_ambientais.index')
            ->with('success','Não conformidade ambiental cadastrada!');
    }
    /**
     * Display the specified resource.
     */
    public function show(NaoConformidadeAmbiental $naoConformidadeAmbiental)
    {
        $naoConformidadeAmbiental->load([
            'empresa','licencaAmbiental','aspectoAmbiental','processo',
            'responsavelApuracao','responsavelTratamento'
        ]);
        return view('iso14001.nao_conformidades_ambientais.show', compact('naoConformidadeAmbiental'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NaoConformidadeAmbiental $naoConformidadeAmbiental)
    {
        $licencas  = LicencaAmbiental::pluck('titulo','id');
        $aspectos  = AspectoAmbiental::pluck('descricao','id');
        $processos = Processo::pluck('nome','id');
        $usuarios  = User::pluck('name','id');

        return view('iso14001.nao_conformidades_ambientais.edit', [
            'naoConformidade' => $naoConformidadeAmbiental,
            'licencas'        => $licencas,
            'aspectos'        => $aspectos,
            'processos'       => $processos,
            'usuarios'        => $usuarios,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNaoConformidadeAmbientalRequest $request, NaoConformidadeAmbiental $naoConformidadeAmbiental)
    {
        $data = $request->validated();
        $data['recorrente'] = $request->boolean('recorrente');
        $naoConformidadeAmbiental->update($data);

        return redirect()->route('nao_conformidades_ambientais.index')
            ->with('success','Não conformidade ambiental atualizada!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NaoConformidadeAmbiental $naoConformidadeAmbiental)
    {
        $naoConformidadeAmbiental->delete();
        return redirect()->route('nao_conformidades_ambientais.index')
            ->with('success','Não conformidade ambiental excluída!');
    }
}
