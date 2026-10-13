<?php

namespace App\Http\Controllers;

use App\Models\CalendarioEvento;
use App\Models\Empresa;
use App\Models\User;
use App\Http\Requests\StoreCalendarioEventoRequest;
use App\Http\Requests\UpdateCalendarioEventoRequest;
use Illuminate\Http\Request;

class CalendarioEventoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CalendarioEvento::with(['empresa', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('titulo', 'ilike', "%{$search}%");
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        $eventos = $query
            ->orderBy('data_inicio')
            ->paginate(15)
            ->withQueryString();

        return view('cadastros.calendario.index', compact('eventos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $responsaveis = User::orderBy('name')->get();
        $empresa = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $evento = new CalendarioEvento();

        return view('cadastros.calendario.create', compact('evento', 'responsaveis', 'empresa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCalendarioEventoRequest $request)
    {
        $data = $request->validated();
        CalendarioEvento::create($data);

        return redirect()->route('calendario.index')
                        ->with('success', 'Evento cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CalendarioEvento $calendarioEvento)
    {
        $calendarioEvento->load(['empresa', 'responsavel']);
        return view('cadastros.calendario.show', ['evento' => $calendarioEvento]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CalendarioEvento $calendarioEvento)
    {
        $calendarioEvento->load(['empresa', 'responsavel']);
        $responsaveis = User::orderBy('name')->get();
        $empresa = $calendario->empresa
            ?? Empresa::find(auth()->user()->empresa_id ?? null)
            ?? Empresa::first();

        return view('cadastros.calendario.edit', ['evento' => $calendarioEvento, 'empresa' => $empresa, 'responsaveis' => $responsaveis]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCalendarioEventoRequest $request, CalendarioEvento $calendario)
    {
        $data = $request->validated();
        $calendario->update($data);

        return redirect()->route('calendario.index')
                        ->with('success', 'Evento atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CalendarioEvento $calendario)
    {
        $calendario->delete();

        return redirect()->route('calendario.index')
                        ->with('success', 'Evento removido com sucesso!');
    }
}
