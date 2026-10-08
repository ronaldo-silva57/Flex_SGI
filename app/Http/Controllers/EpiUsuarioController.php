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
use Illuminate\Support\Carbon;

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
            $query->where(function ($q) use ($search) {
                $q->whereHas('epi', fn($e) => $e->where('nome', 'ilike', "%{$search}%"))
                  ->orWhereHas('usuario', fn($u) => $u->where('name', 'ilike', "%{$search}%"));
            });
        }

        $entregas = $query->with(['epi', 'usuario', 'responsavelEntrega'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('iso45001.epis_usuarios.index', compact('entregas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();
        // Carrega epis com o atributo validade_meses para usar via JavaScript no Blade
        $epis = Epi::where('empresa_id', $empresa->id)->where('ativo', true)->orderBy('nome')->get();
        $usuarios = User::orderBy('name')->get();
        return view('iso45001.epis_usuarios.create', compact('empresa', 'epis', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEpiUsuarioRequest $request)
    {
        $validated = $request->validated();

        // 1. Define data de entrega como HOJE caso vazia
        if (empty($validated['data_entrega'])) {
            $validated['data_entrega'] = now()->format('Y-m-d');
        }

        // 2. Define o responsável pela entrega
        if (empty($validated['responsavel_entrega_id'])) {
            $validated['responsavel_entrega_id'] = Auth::id();
        }

        // 3. Busca o EPI e calcula a Data de Vencimento caso não informada
        $epi = Epi::findOrFail($validated['epi_id']);

        if (empty($validated['data_vencimento']) && $epi->validade_meses) {
            $dataEntrega = Carbon::parse($validated['data_entrega']);
            $validated['data_vencimento'] = $dataEntrega->addMonths($epi->validade_meses)->format('Y-m-d');
        }

        // 4. Salva o registro no banco
        EpiUsuario::create($validated);

        // 5. Baixa no estoque do EPI
        $quantidade = $validated['quantidade'] ?? 1;
        $epi->decrement('estoque_atual', $quantidade);

        return redirect()->route('epis_usuarios.index')
            ->with('success', 'Entrega de EPI registrada com sucesso.');
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
        $usuarios = User::orderBy('name')->get();
        return view('iso45001.epis_usuarios.edit', compact('episUsuario', 'empresa', 'epis', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEpiUsuarioRequest $request, EpiUsuario $episUsuario)
    {
        $validated = $request->validated();

        $oldQtde = $episUsuario->quantidade;
        $episUsuario->update($validated);

        $newQtde = $validated['quantidade'] ?? $oldQtde;
        $diff = $newQtde - $oldQtde;

        if ($diff != 0) {
            $epi = Epi::find($episUsuario->epi_id);
            // Se aumentou a quantidade entregue, diminui do estoque
            $epi->decrement('estoque_atual', $diff);
        }

        return redirect()->route('epis_usuarios.index')
            ->with('success', 'Entrega de EPI atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EpiUsuario $episUsuario)
    {
        // Devolve a quantidade ao estoque ao excluir a entrega
        $epi = Epi::find($episUsuario->epi_id);
        if ($epi) {
            $epi->increment('estoque_atual', $episUsuario->quantidade);
        }

        $episUsuario->delete();
        return redirect()->route('epis_usuarios.index')
            ->with('success', 'Registro de entrega excluído.');
    }
}
