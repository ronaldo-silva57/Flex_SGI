<?php

namespace App\Http\Controllers;

use App\Models\LicencaAmbiental;
use App\Models\User;
use App\Models\Empresa;
use App\Http\Requests\StoreLicencaAmbientalRequest;
use App\Http\Requests\UpdateLicencaAmbientalRequest;
use App\Http\Requests\UploadLicencaAmbientalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LicencaAmbientalController extends Controller
{
    public function index(Request $request)
    {
        $query = LicencaAmbiental::with(['empresa', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('numero', 'like', "%{$search}%")
                  ->orWhere('orgao_emissor', 'like', "%{$search}%")
                  ->orWhere('descricao', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        $licencas = $query->orderBy('data_validade', 'asc')->paginate(15);

        return view('iso14001.licencas_ambientais.index', compact('licencas'));
    }

    public function create()
    {
        $empresas = Empresa::pluck('razao_social', 'id');
        $usuarios = User::pluck('name', 'id');
        $tipos = LicencaAmbiental::TIPOS;
        $statuses = [
            LicencaAmbiental::STATUS_VIGENTE,
            LicencaAmbiental::STATUS_VENCIDA,
            LicencaAmbiental::STATUS_EM_RENOVACAO,
            LicencaAmbiental::STATUS_SUSPENSA,
            LicencaAmbiental::STATUS_CANCELADA,
        ];

        return view('iso14001.licencas_ambientais.create', compact('empresas', 'usuarios', 'tipos', 'statuses'));
    }

    public function store(StoreLicencaAmbientalRequest $request)
    {
        $data = $request->validated();
        
        // Atribui empresa_id default se não enviado (ou via sessão do tenant/contexto)
        if (!isset($data['empresa_id'])) {
            $data['empresa_id'] = $request->user()->empresa_id ?? 1;
        }

        LicencaAmbiental::create($data);

        return redirect()->route('licencas_ambientais.index')
            ->with('success', 'Licença ambiental cadastrada com sucesso!');
    }

    public function show(LicencaAmbiental $licenca)
    {
        $licenca->load(['empresa', 'responsavel', 'naoConformidades']);

        return view('iso14001.licencas_ambientais.show', [
            'licenca' => $licenca
        ]);
    }

    public function edit(LicencaAmbiental $licenca)
    {
        $empresas = Empresa::pluck('razao_social', 'id');
        $usuarios = User::pluck('name', 'id');
        $tipos    = LicencaAmbiental::TIPOS;
        $statuses = [
            LicencaAmbiental::STATUS_VIGENTE,
            LicencaAmbiental::STATUS_VENCIDA,
            LicencaAmbiental::STATUS_EM_RENOVACAO,
            LicencaAmbiental::STATUS_SUSPENSA,
            LicencaAmbiental::STATUS_CANCELADA,
        ];

        return view('iso14001.licencas_ambientais.edit', compact('licenca', 'empresas', 'usuarios', 'tipos', 'statuses'));
    }

    public function update(UpdateLicencaAmbientalRequest $request, LicencaAmbiental $licenca)
    {
        $licenca->update($request->validated());

        return redirect()->route('licencas_ambientais.index')
            ->with('success', 'Licença ambiental atualizada com sucesso!');
    }

    public function destroy(LicencaAmbiental $licenca)
    {
        $licenca->delete();

        return redirect()->route('licencas_ambientais.index')
            ->with('success', 'Licença ambiental excluída com sucesso!');
    }

    public function uploadArquivo(UploadLicencaAmbientalRequest $request, LicencaAmbiental $licenca)
    {
        if ($licenca->arquivo_path && Storage::disk('public')->exists($licenca->arquivo_path)) {
            Storage::disk('public')->delete($licenca->arquivo_path);
        }

        $path = $request->file('arquivo')->store('licencas_ambientais', 'public');
        $licenca->update(['arquivo_path' => $path]);

        return back()->with('success', 'Documento da licença enviado com sucesso!');
    }

    public function downloadArquivo(LicencaAmbiental $licenca)
    {
        if (!$licenca->arquivo_path || !Storage::disk('public')->exists($licenca->arquivo_path)) {
            return back()->with('error', 'Arquivo não encontrado.');
        }

        return Storage::disk('public')->download($licenca->arquivo_path);
    }
}