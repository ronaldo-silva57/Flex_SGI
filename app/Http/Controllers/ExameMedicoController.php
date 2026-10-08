<?php

namespace App\Http\Controllers;

use App\Models\ExameMedico;
use App\Models\Empresa;
use App\Models\User;
use App\Http\Requests\StoreExameMedicoRequest;
use App\Http\Requests\UpdateExameMedicoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ExameMedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = ExameMedico::with(['empresa', 'usuario', 'medicoExaminador']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('usuario', function ($u) use ($search) {
                    $u->where('name', 'ilike', "%{$search}%");
                })->orWhere('crm_medico', 'ilike', "%{$search}%")
                  ->orWhere('medico_nome', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('resultado')) {
            $query->where('resultado', $request->resultado);
        }

        $exames = $query->latest('data_realizacao')->paginate(15)->withQueryString();

        return view('iso45001.exames_medicos.index', compact('exames'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $empresa = Empresa::first();
        $usuarios = User::orderBy('name')->get();

        return view('iso45001.exames_medicos.create', compact('empresa', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExameMedicoRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('arquivo_aso')) {
            $data['arquivo_aso_path'] = $request->file('arquivo_aso')->store('asos', 'public');
        }

        ExameMedico::create($data);

        return redirect()->route('exames_medicos.index')
            ->with('success', 'Exame médico registrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExameMedico $exameMedico): View
    {
        $exameMedico->load(['empresa', 'usuario', 'medicoExaminador']);
        return view('iso45001.exames_medicos.show', compact('exameMedico'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExameMedico $exames_medico): View
    {
        $empresa = Empresa::first();
        $usuarios = User::orderBy('name')->get();

        return view('iso45001.exames_medicos.edit', compact('exames_medico', 'empresa', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExameMedicoRequest $request, ExameMedico $exameMedico): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('arquivo_aso')) {
            if ($exameMedico->arquivo_aso_path) {
                Storage::disk('public')->delete($exameMedico->arquivo_aso_path);
            }
            $data['arquivo_aso_path'] = $request->file('arquivo_aso')->store('asos', 'public');
        }

        $exameMedico->update($data);

        return redirect()->route('exames_medicos.index')
            ->with('success', 'Exame médico atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExameMedico $exameMedico): RedirectResponse
    {
        if ($exameMedico->arquivo_aso_path) {
            Storage::disk('public')->delete($exameMedico->arquivo_aso_path);
        }

        $exameMedico->delete();

        return redirect()->route('exames_medicos.index')
            ->with('success', 'Exame médico excluído com sucesso!');
    }
}
