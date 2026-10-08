<?php

namespace App\Http\Controllers;

use App\Models\SoaControle;
use App\Models\User;
use App\Models\Empresa;
use App\Models\ControleSeguranca;
use App\Http\Requests\StoreSoaControle;
use App\Http\Requests\UpdateSoaControle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SoaControleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = SoaControle::with(['empresa', 'responsavel', 'controleSeguranca']);

        // Filtro de busca textual (PostgreSQL ilike)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('codigo_anexo_a', 'ilike', "%{$search}%")
                  ->orWhere('dominio', 'ilike', "%{$search}%")
                  ->orWhere('titulo', 'ilike', "%{$search}%")
                  ->orWhere('descricao', 'ilike', "%{$search}%");
            });
        }

        // Filtro por Aplicabilidade (Sim/Não)
        if ($request->has('aplicavel') && $request->input('aplicavel') !== '') {
            $query->where('aplicavel', filter_var($request->input('aplicavel'), FILTER_VALIDATE_BOOLEAN));
        }

        // Filtro por Status de Implementação
        if ($request->filled('status_implementacao')) {
            $query->where('status_implementacao', $request->input('status_implementacao'));
        }

        // Filtro por Domínio
        if ($request->filled('dominio')) {
            $query->where('dominio', $request->input('dominio'));
        }

        $controles = $query->orderBy('codigo_anexo_a', 'asc')->paginate(15);

        // Lista de domínios para o Select do filtro
        $dominios = SoaControle::distinct()->pluck('dominio')->filter();

        $statuses = ['Não iniciado', 'Em implementacao', 'Implementado', 'Não aplicável'];

        return view('iso27001.soa_controles.index', compact('controles', 'dominios', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $empresas = Empresa::pluck('razao_social', 'id');
        $usuarios = User::pluck('name', 'id');
        $controlesSeguranca = ControleSeguranca::pluck('titulo', 'id'); // ← CORRIGIDO

        $statuses = ['Não iniciado', 'Em implementacao', 'Implementado', 'Não aplicável'];

        return view('iso27001.soa_controles.create', compact('empresas', 'usuarios', 'controlesSeguranca', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSoaControle $request): RedirectResponse
    {
        $data = $request->validated();

        // Atribui empresa_id padrão do contexto/usuário se não informado
        if (!isset($data['empresa_id'])) {
            $data['empresa_id'] = $request->user()->empresa_id ?? 1;
        }

        SoaControle::create($data);

        return redirect()->route('soa_controles.index')
            ->with('success', 'Controle SoA cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SoaControle $soaControle): View
    {
        $soaControle->load(['empresa', 'responsavel', 'controleSeguranca']);

        return view('iso27001.soa_controles.show', compact('soaControle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SoaControle $soaControle): View
    {
        $empresas = Empresa::pluck('razao_social', 'id');
        $usuarios = User::pluck('name', 'id');
        $controlesSeguranca = ControleSeguranca::pluck('titulo', 'id'); // ← CORRIGIDO

        $statuses = ['Não iniciado', 'Em implementacao', 'Implementado', 'Não aplicável'];

        return view('iso27001.soa_controles.edit', compact('soaControle', 'empresas', 'usuarios', 'controlesSeguranca', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSoaControle $request, SoaControle $soaControle): RedirectResponse
    {
        $soaControle->update($request->validated());

        return redirect()->route('soa_controles.index')
            ->with('success', 'Controle SoA atualizado com sucesso!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SoaControle $soaControle): RedirectResponse
    {
        $soaControle->delete();

        return redirect()->route('soa_controles.index')
            ->with('success', 'Controle SoA excluído com sucesso!');
    }

    /**
     * Submit a document or file providing evidence of the control's implementation.
     */
    
    public function uploadEvidencia(Request $request, SoaControle $soaControle): RedirectResponse
    {
        $request->validate([
            'evidencia_file' => ['required', 'file', 'mimes:pdf,doc,docx,png,jpg,zip', 'max:10240'],
        ]);

        if ($soaControle->evidencia_path && Storage::disk('public')->exists($soaControle->evidencia_path)) {
            Storage::disk('public')->delete($soaControle->evidencia_path);
        }

        $path = $request->file('evidencia_file')->store('soa_evidencias', 'public');
        $soaControle->update(['evidencia_path' => $path]);

        return back()->with('success', 'Evidência enviada com sucesso!');
    }

    /**
     * Download the attached evidence file. 
     */
    public function downloadEvidencia(SoaControle $soaControle): BinaryFileResponse|RedirectResponse
    {
        if (!$soaControle->evidencia_path || !Storage::disk('public')->exists($soaControle->evidencia_path)) {
            return back()->with('error', 'Evidência não encontrada.');
        }

        return Storage::disk('public')->download($soaControle->evidencia_path);
    }
}
