<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCipaReuniaoRequest;
use App\Http\Requests\UpdateCipaReuniaoRequest;
use App\Models\CipaReuniao;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CipaReuniaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        $query = CipaReuniao::with(['empresa', 'presidente', 'secretario'])
            ->orderBy('data_reuniao', 'desc');

        // Filtro global por termo de busca
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('pauta_principal', 'ilike', "%{$search}%")
                  ->orWhere('pauta_detalhada', 'ilike', "%{$search}%")
                  ->orWhere('deliberacoes', 'ilike', "%{$search}%")
                  ->orWhere('gestao_ano', 'ilike', "%{$search}%")
                  ->orWhereHas('empresa', function ($qEmp) use ($search) {
                      $qEmp->where('nome_fantasia', 'ilike', "%{$search}%")
                           ->orWhere('razao_social', 'ilike', "%{$search}%");
                  });
            });
        }

        // Filtros específicos (opcionais)
        if ($request->filled('empresa_id')) {
            $query->where('empresa_id', $request->empresa_id);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reunioes = $query
            ->paginate(15)
            ->withQueryString();
        $empresas = Empresa::orderBy('nome_fantasia')->get();

        return view('iso45001.cipa_reunioes.index', compact('reunioes', 'empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
        $empresas = Empresa::orderBy('nome_fantasia')->get();
        $usuarios = User::orderBy('name')->get();

        return view('iso45001.cipa_reunioes.create', compact('empresas', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCipaReuniaoRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('ata_arquivo')) {
            $data['ata_arquivo_path'] = $request->file('ata_arquivo')->store('atas_cipa', 'public');
        }

        CipaReuniao::create($data);

        return redirect()
            ->route('cipa_reunioes.index')
            ->with('success', 'Reunião da CIPA agendada/registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CipaReuniao $cipaReuniao)
    {
        $cipaReuniao->load(['empresa', 'presidente', 'secretario']);

        return view('iso45001.cipa_reunioes.show', compact('cipaReuniao'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CipaReuniao $cipaReuniao)
    {
        $empresas = Empresa::orderBy('nome_fantasia')->get();
        $usuarios = User::orderBy('name')->get();

        return view('iso45001.cipa_reunioes.edit', compact('cipaReuniao', 'empresas', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCipaReuniaoRequest $request, CipaReuniao $cipaReuniao)
    {
        $data = $request->validated();

        if ($request->hasFile('ata_arquivo')) {
            if ($cipaReuniao->ata_arquivo_path && Storage::disk('public')->exists($cipaReuniao->ata_arquivo_path)) {
                Storage::disk('public')->delete($cipaReuniao->ata_arquivo_path);
            }
            $data['ata_arquivo_path'] = $request->file('ata_arquivo')->store('atas_cipa', 'public');
        }

        $cipaReuniao->update($data);

        return redirect()
            ->route('cipa_reunioes.index')
            ->with('success', 'Reunião da CIPA atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CipaReuniao $cipaReuniao)
    {
        $cipaReuniao->delete();

        return redirect()
            ->route('cipa_reunioes.index')
            ->with('success', 'Reunião da CIPA removida com sucesso!');
    }
}
