<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Empresa;
use App\Models\Processo;
use App\Models\Norma;
use App\Models\User;
use App\Models\Departamento;
use App\Models\DocumentoAnexo;
use App\Models\DocumentoRevisao;
use App\Models\DocumentoLeitura;
use App\Http\Requests\StoreDocumentoRequest;
use App\Http\Requests\UpdateDocumentoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        $query = Documento::with(['empresa', 'processo', 'norma', 'responsavel']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('codigo', 'ilike', "%{$search}%")
                    ->orWhere('titulo', 'ilike', "%{$search}%")
                    ->orWhere('tipo', 'ilike', "%{$search}%")
                    ->orWhere('status', 'ilike', "%{$search}%")
                    ->orWhereHas('empresa', fn($e) => $e->where('nome_fantasia', 'ilike', "%{$search}%")
                        ->orWhere('razao_social', 'ilike', "%{$search}%"))
                    ->orWhereHas('processo', fn($p) => $p->where('nome', 'ilike', "%{$search}%"))
                    ->orWhereHas('norma', fn($n) => $n->where('codigo', 'ilike', "%{$search}%")
                        ->orWhere('nome', 'ilike', "%{$search}%"));
            });
        }

        $documentos = $query->latest()->paginate(15)->withQueryString();

        return view('cadastros.documentos.index', compact('documentos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empresas = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $processos = Processo::where('ativo', true)->orderBy('nome')->get();
        $normas = Norma::where('ativo', true)->orderBy('codigo')->get();
        $usuarios = User::orderBy('name')->get();
        $departamentos = Departamento::orderBy('nome')->get();

        return view('cadastros.documentos.create', compact('empresas', 'processos', 'normas', 'usuarios', 'departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentoRequest $request)
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();

            if ($request->hasFile('arquivo_path')) {
                $data['arquivo_path'] = $request->file('arquivo_path')->store('documentos', 'public');
            }

            $documento = Documento::create($data);

            // Regista automaticamente a versão inicial no histórico de revisões
            DocumentoRevisao::create([
                'documento_id' => $documento->id,
                'versao' => $documento->versao ?? '1.0',
                'alteracoes_realizadas' => 'Emissão inicial do documento.',
                'responsavel_id' => $documento->responsavel_id ?? auth()->id(),
                'arquivo_path' => $documento->arquivo_path,
                'data_revisao' => now(),
            ]);
        });

        return redirect()->route('documentos.index')->with('success', 'Documento cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Documento $documento)
    {
        $documento->load(['empresa', 'processo', 'norma', 'responsavel', 'revisoes.responsavel', 'aprovacoes.aprovador', 'anexos', 'leituras.usuario', 'distribuicoes.departamento']);
        
        $departamentos = Departamento::orderBy('nome')->get();
        $usuarios = User::orderBy('name')->get();

        return view('cadastros.documentos.show', compact('documento', 'departamentos', 'usuarios'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documento $documento)
    {
        $empresas = Empresa::find(auth()->user()->empresa_id ?? null) ?? Empresa::first();
        $processos = Processo::where('ativo', true)->orderBy('nome')->get();
        $normas = Norma::where('ativo', true)->orderBy('codigo')->get();
        $usuarios = User::orderBy('name')->get();

        return view('cadastros.documentos.edit', compact('documento', 'empresas', 'processos', 'normas', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDocumentoRequest $request, Documento $documento)
    {
        $data = $request->validated();

        if ($request->hasFile('arquivo_path')) {
            if ($documento->arquivo_path && Storage::disk('public')->exists($documento->arquivo_path)) {
                Storage::disk('public')->delete($documento->arquivo_path);
            }
            $data['arquivo_path'] = $request->file('arquivo_path')->store('documentos', 'public');
        } else {
            unset($data['arquivo_path']);
        }

        $documento->update($data);

        return redirect()->route('documentos.index')->with('success', 'Documento atualizado com sucesso!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documento $documento)
    {
        if ($documento->arquivo_path && Storage::disk('public')->exists($documento->arquivo_path)) {
            Storage::disk('public')->delete($documento->arquivo_path);
        }
        
        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento removido com sucesso!');
    }

// Métodos adicionais para o novo fluxo SGI
    public function storeAnexo(Request $request, Documento $documento)
    {
        $request->validate([
            'nome_arquivo' => 'required|string|max:255',
            'arquivo' => 'required|file|max:10240', // max 10MB
        ]);

        $path = $request->file('arquivo')->store('documentos/anexos', 'public');

        DocumentoAnexo::create([
            'documento_id' => $documento->id,
            'nome_arquivo' => $request->nome_arquivo,
            'arquivo_path' => $path,
            'usuario_id' => auth()->id(),
        ]);

        return back()->with('success', 'Anexo adicionado com sucesso!');
    }

    public function destroyAnexo(DocumentoAnexo $anexo)
    {
        if (Storage::disk('public')->exists($anexo->arquivo_path)) {
            Storage::disk('public')->delete($anexo->arquivo_path);
        }
        $anexo->delete();

        return back()->with('success', 'Anexo removido com sucesso!');
    }

    public function registrarLeitura(Request $request, Documento $documento)
    {
        DocumentoLeitura::updateOrCreate(
            [
                'documento_id' => $documento->id,
                'usuario_id' => auth()->id(),
            ],
            [
                'data_leitura' => now(),
                'ip_address' => $request->ip(),
            ]
        );

        return back()->with('success', 'Leitura do documento confirmada e registada com sucesso!');
    }
}
