<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInventarioGeeRequest;
use App\Http\Requests\UpdateInventarioGeeRequest;
use App\Models\InventarioGee;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InventarioGeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $inventarios = InventarioGee::query()
            ->with('responsavel')
            ->when($user->empresa_id, function ($query, $empresaId) {
                $query->where('empresa_id', $empresaId);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('codigo', 'ilike', "%{$search}%")
                        ->orWhere('fonte_emissao', 'ilike', "%{$search}%");
                });
            })
            ->when($request->filled('escopo'), function ($query) use ($request) {
                $query->where('escopo', $request->input('escopo'));
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->input('status'));
            })
            ->when($request->filled('ano_referencia'), function ($query) use ($request) {
                $query->where('ano_referencia', $request->input('ano_referencia'));
            })
            ->orderByDesc('ano_referencia')
            ->orderBy('codigo')
            ->paginate(15)
            ->withQueryString();

        return view('esg.inventario_gee.index', compact('inventarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $empresa = $request->user()->empresa;

        $usuarios = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('esg.inventario_gee.create', compact('usuarios', 'empresa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventarioGeeRequest $request): RedirectResponse
    {
        $empresaId = $request->user()->empresa_id;

        if (! $empresaId) {
            return back()
                ->withInput()
                ->withErrors(['empresa_id' => 'O usuário logado não possui uma empresa associada.']);
        }

        $dados = $request->validated();
        $dados['empresa_id'] = $empresaId;

        InventarioGee::create($dados);

        return redirect()
            ->route('inventario_gee.index')
            ->with('success', 'Registro de inventário GEE criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, InventarioGee $inventarioGee): View
    {
        $inventarioGee->load('responsavel');

        return view('esg.inventario_gee.show', compact('inventarioGee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, InventarioGee $inventarioGee): View
    {
        $empresa = $request->user()->empresa;

        $usuarios = User::query()
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('esg.inventario_gee.edit', compact('inventarioGee', 'usuarios', 'empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventarioGeeRequest $request, InventarioGee $inventarioGee): RedirectResponse
    {
        $dados = $request->validated();

        if (! isset($dados['empresa_id'])) {
            $dados['empresa_id'] = $inventarioGee->empresa_id ?? $request->user()->empresa_id;
        }

        $inventarioGee->update($dados);

        return redirect()
            ->route('inventario_gee.index')
            ->with('success', 'Registro de inventário GEE atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, InventarioGee $inventarioGee): RedirectResponse
    {
        $inventarioGee->delete();

        return redirect()
            ->route('inventario_gee.index')
            ->with('success', 'Registro de inventário GEE excluído com sucesso.');
    }
}
