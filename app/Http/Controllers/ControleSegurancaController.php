<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreControlesSegurancaRequest;
use App\Http\Requests\UpdateControlesSegurancaRequest;
use App\Models\AtivoInformacao;
use App\Models\ControleSeguranca;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControleSegurancaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $empresa = Empresa::first();

        $query = ControleSeguranca::where('empresa_id', $empresa->id)
            ->with(['ativo', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'ILIKE', "%{$search}%")
                    ->orWhere('codigo_anexo_a', 'ILIKE', "%{$search}%")
                    ->orWhere('descricao', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->has('implementado') && $request->implementado !== '') {
            $query->where(
                'implementado',
                $request->implementado === '1'
            );
        }

        $controles = $query
            ->orderBy('codigo_anexo_a')
            ->orderBy('titulo')
            ->paginate(15)
            ->withQueryString();

        return view(
            'iso27001.controles_seguranca.index',
            compact('controles')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresa = Empresa::first();

        $ativos = AtivoInformacao::where('empresa_id', $empresa->id)
            ->orderBy('nome')
            ->get();

        $usuarios = User::orderBy('name')->get();

        return view(
            'iso27001.controles_seguranca.create',
            compact('empresa', 'ativos', 'usuarios')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreControlesSegurancaRequest $request)
    {
        $empresa = Empresa::first();

        $validated = $request->validated();

        $validated['empresa_id'] = $empresa->id;

        if (empty($validated['responsavel_id'])) {
            $validated['responsavel_id'] = Auth::id();
        }

        ControleSeguranca::create($validated);

        return redirect()
            ->route('controles_seguranca.index')
            ->with('success', 'Controle de segurança criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ControleSeguranca $controlesSeguranca)
    {
        $controlesSeguranca->load([
            'empresa',
            'ativo',
            'responsavel'
        ]);

        return view(
            'iso27001.controles_seguranca.show',
            compact('controlesSeguranca')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ControleSeguranca $controlesSeguranca)
    {
        $empresa = Empresa::find($controlesSeguranca->empresa_id);

        $ativos = AtivoInformacao::where('empresa_id', $empresa->id)
            ->orderBy('nome')
            ->get();

        $usuarios = User::orderBy('name')->get();

        return view(
            'iso27001.controles_seguranca.edit',
            compact(
                'controlesSeguranca',
                'empresa',
                'ativos',
                'usuarios'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateControlesSegurancaRequest $request,
        ControleSeguranca $controlesSeguranca
    ) {
        $validated = $request->validated();

        // Não permite alterar a empresa do registro pelo formulário.
        $validated['empresa_id'] = $controlesSeguranca->empresa_id;

        $controlesSeguranca->update($validated);

        return redirect()
            ->route('controles_seguranca.index')
            ->with('success', 'Controle de segurança atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ControleSeguranca $controlesSeguranca)
    {
        $controlesSeguranca->delete();

        return redirect()
            ->route('controles_seguranca.index')
            ->with('success', 'Controle de segurança excluído com sucesso.');
    }
}