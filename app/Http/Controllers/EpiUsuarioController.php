<?php

namespace App\Http\Controllers;

use App\Models\EpiUsuario;
use App\Models\Epi;
use App\Models\User;
use App\Models\Empresa;
use App\Http\Requests\StoreEpiUsuarioRequest;
use App\Http\Requests\UpdateEpiUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EpiUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::first(); 

        $query = EpiUsuario::whereHas('epi', function ($q) use ($empresa) {
            $q->where('empresa_id', $empresa->id);
        });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('epi', function ($q) use ($search) {
                $q->where('nome', 'LIKE', "%{$search}%");
            })->orWhereHas('usuario', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        $entregas = $query->with(['epi', 'usuario', 'responsavelEntrega'])->orderBy('created_at', 'desc')->paginate(15);

        return view('iso45001.epis_usuarios.index', compact('entregas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        $epis = Epi::where('empresa_id', $empresa->id)->orderBy('nome')->get();
        $usuarios = User::all();
        return view('iso45001.epis_usuarios.create', compact('empresa', 'epis', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEpiUsuarioRequest $request)
    {
        $validated = $request->validated();
        if (empty($validated['responsavel_entrega_id'])) {
            $validated['responsavel_entrega_id'] = Auth::id();
        }
        EpiUsuario::create($validated);

        // Atualizar estoque do EPI (opcional)
        $epi = Epi::find($validated['epi_id']);
        $epi->increment('estoque_atual', $validated['quantidade'] ?? 1);

        return redirect()->route('epis_usuarios.index')->with('success', 'Entrega de EPI registrada com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EpiUsuario $episUsuario)
    {
        return view('iso45001.epis_usuarios.show', compact('episUsuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EpiUsuario $episUsuario)
    {
        $empresa = Empresa::find($episUsuario->epi->empresa_id);
        $epis = Epi::where('empresa_id', $empresa->id)->orderBy('nome')->get();
        $usuarios = User::all();
        return view('iso45001.epis_usuarios.edit', compact('episUsuario', 'empresa', 'epis', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEpiUsuarioRequest $request, EpiUsuario $episUsuario)
    {
        $validated = $request->validated();

        // Ajustar estoque se quantidade mudou (exemplo simples)
        $oldQtde = $episUsuario->quantidade;
        $episUsuario->update($validated);
        $newQtde = $validated['quantidade'] ?? $oldQtde;
        $diff = $newQtde - $oldQtde;
        if ($diff != 0) {
            $epi = Epi::find($episUsuario->epi_id);
            $epi->increment('estoque_atual', $diff);
        }

        return redirect()->route('epis_usuarios.index')->with('success', 'Entrega de EPI atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EpiUsuario $episUsuario)
    {
        // Devolver ao estoque
        $epi = Epi::find($episUsuario->epi_id);
        $epi->decrement('estoque_atual', $episUsuario->quantidade);

        $episUsuario->delete();
        return redirect()->route('epis_usuarios.index')->with('success', 'Registro de entrega excluído.');
    }
}
