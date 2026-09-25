<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRiscoOportunidadeRequest;
use App\Http\Requests\UpdateRiscoOportunidadeRequest;
use App\Models\Processo;
use App\Models\RiscoOportunidade;
use App\Models\Empresa;
use Illuminate\Http\Request;

class RiscoOportunidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RiscoOportunidade::with([
            'empresa',
            'processo',
            'responsavel',
        ]);

        // Filtrp por tipo
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('tipo', 'ilike', "%{$search}%");
            });
        }

        $riscos = $query
            ->orderBy('status')
            ->paginate(15)
            ->withQueryString();

        return view(
            'cadastros.riscos_oportunidades.index',
            compact('riscos')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $processos = Processo::orderBy('nome')->get();

       $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? empresa::first();
        //@dd(auth()->user());

        return view(
            'cadastros.riscos_oportunidades.create',
            compact('processos', 'empresa')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRiscoOportunidadeRequest $request)
    {
        $data = $request->validated();

        $data['empresa_id'] = $data['empresa_id']
            ?? auth()->user()->empresa_id;

        $data['responsavel_id'] = $data['responsavel_id']
            ?? auth()->id();

        RiscoOportunidade::create($data);

        return redirect()
            ->route('riscos_oportunidades.index')
            ->with(
                'success',
                'Risco ou Oportunidade criado com sucesso'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(RiscoOportunidade $riscos_oportunidade)
    {
        $riscos_oportunidade->load([
            'empresa',
            'processo',
            'responsavel',
        ]);

        return view(
            'cadastros.riscos_oportunidades.show',
            compact('riscos_oportunidade')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RiscoOportunidade $riscos_oportunidade)
    {
        $processos = Processo::orderBy('nome')->get();

        $riscos_oportunidade->load('empresa', 'responsavel');

        $empresa = $riscos_oportunidade->empresa
            ?? Empresa::find(auth()->user()->empresa_id ?? null) 
            ?? Empresa::first();

        return view(
            'cadastros.riscos_oportunidades.edit',
            compact('riscos_oportunidade', 'processos', 'empresa')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateRiscoOportunidadeRequest $request,
        RiscoOportunidade $riscos_oportunidade
    ) {
        $data = $request->validated();

        $riscos_oportunidade->update($data);

        return redirect()
            ->route('riscos_oportunidades.index')
            ->with(
                'success',
                'Risco ou Oportunidade atualizado com sucesso!'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RiscoOportunidade $riscos_oportunidade)
    {
        $riscos_oportunidade->delete();

        return redirect()
            ->route('riscos_oportunidades.index')
            ->with(
                'success',
                'Risco ou Oportunidade removido com sucesso!'
            );
    }
}