<?php

namespace App\Http\Controllers;

use App\Models\ObjetivoAmbiental;
use App\Models\AspectoAmbiental;
use App\Models\User;
use App\Http\Requests\StoreObjetivoAmbiental;
use App\Http\Requests\UpdateObjetivoAmbiental;
use Illuminate\Http\Request;

class ObjetivoAmbientalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ObjetivoAmbiental::with(['aspectoAmbiental','responsavel','empresa']);

        if ($request->filled('search')) {
            $s = $request->input('search');
            $query->where(function ($q) use ($s) {
                $q->where('titulo','ilike',"%{$s}%")
                  ->orWhere('codigo','ilike',"%{$s}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $objetivos = $query->orderBy('prazo','asc')->paginate(15)->withQueryString();

        return view('iso14001.objetivos_ambientais.index', compact('objetivos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aspectos = AspectoAmbiental::pluck('descricao','id');
        $usuarios = User::pluck('name','id');
        $empresa  = auth()->user()->empresa ?? null;

        return view('iso14001.objetivos_ambientais.create', compact('aspectos','usuarios','empresa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreObjetivoAmbiental $request)
    {
        $data = $request->validated();
        $data['empresa_id'] = $request->user()->empresa_id ?? 1;

        ObjetivoAmbiental::create($data);

        return redirect()->route('objetivos_ambientais.index')
            ->with('success','Objetivo Ambiental cadastrado!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ObjetivoAmbiental $objetivoAmbiental)
    {
        $objetivoAmbiental->load(['aspectoAmbiental','responsavel','empresa']);
        return view('iso14001.objetivos_ambientais.show', compact('objetivoAmbiental'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ObjetivoAmbiental $objetivoAmbiental)
    {
        $aspectos = AspectoAmbiental::pluck('descricao','id');
        $usuarios = User::pluck('name','id');
        $empresa  = auth()->user()->empresa ?? null;

        return view('iso14001.objetivos_ambientais.edit', [
            'objetivo' => $objetivoAmbiental,
            'aspectos' => $aspectos,
            'usuarios' => $usuarios,
            'empresa'  => $empresa,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateObjetivoAmbiental $request, ObjetivoAmbiental $objetivoAmbiental)
    {
        $objetivoAmbiental->update($request->validated());

        return redirect()->route('objetivos_ambientais.index')
            ->with('success','Objetivo Ambiental atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ObjetivoAmbiental $objetivoAmbiental)
    {
        $objetivoAmbiental->delete();
        return redirect()->route('objetivos_ambientais.index')->with('success','Objetivo excluído!');
    }
}
