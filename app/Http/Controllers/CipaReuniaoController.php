<?php

namespace App\Http\Controllers;

use App\Models\CipaReuniao;
use App\Http\Requests\StoreCipaReuniaoRequest;
use App\Http\Requests\UpdateCipaReuniaoRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CipaReuniaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $reunioes = CipaReuniao::with(['empresa', 'presidente', 'secretario'])
            ->latest('data_reuniao')
            ->paginate(15);

        return view('iso45001.cipa_reunioes.index', compact('reunioes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('iso45001.cipa_reunioes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCipaReuniaoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('ata_arquivo')) {
            $data['ata_arquivo_path'] = $request->file('ata_arquivo')->store('cipa_atas', 'public');
        }

        CipaReuniao::create($data);

        return redirect()->route('cipa_reunioes.index')
            ->with('success', 'Reunião/Atividade da CIPA registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CipaReuniao $cipaReuniao): View
    {
        return view('iso45001.cipa_reunioes.edit', compact('cipaReuniao'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCipaReuniaoRequest $request, CipaReuniao $cipaReuniao): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('ata_arquivo')) {
            if ($cipaReuniao->ata_arquivo_path) {
                Storage::disk('public')->delete($cipaReuniao->ata_arquivo_path);
            }
            $data['ata_arquivo_path'] = $request->file('ata_arquivo')->store('cipa_atas', 'public');
        }

        $cipaReuniao->update($data);

        return redirect()->route('cipa_reunioes.index')
            ->with('success', 'Ata/Registro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CipaReuniao $cipaReuniao): RedirectResponse
    {
        if ($cipaReuniao->ata_arquivo_path) {
            Storage::disk('public')->delete($cipaReuniao->ata_arquivo_path);
        }

        $cipaReuniao->delete();

        return redirect()->route('cipa_reunioes.index')
            ->with('success', 'Registro excluído!');
    }
}
