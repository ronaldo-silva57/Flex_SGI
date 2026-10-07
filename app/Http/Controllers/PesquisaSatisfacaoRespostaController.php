<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePesquisaRespostaRequest;
use App\Http\Requests\UpdatePesquisaRespostaRequest;
use App\Models\Cliente;
use App\Models\PesquisaSatisfacao;
use App\Models\PesquisaSatisfacaoResposta;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PesquisaSatisfacaoRespostaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $respostas = PesquisaSatisfacaoResposta::query()
            ->with(['pesquisa:id,codigo,titulo', 'cliente:id,nome', 'respondente:id,name'])
            ->when($request->pesquisa_id, fn ($q) => $q->where('pesquisa_id', $request->pesquisa_id))
            ->when($request->classificacao, fn ($q) => $q->where('classificacao', $request->classificacao))
            ->when($request->busca, function ($q) use ($request) {
                $q->whereHas('pesquisa', function ($qp) use ($request) {
                    $qp->where('titulo', 'ilike', "%{$request->busca}%")
                    ->orWhere('codigo', 'ilike', "%{$request->busca}%");
                });
            })
            ->latest('respondido_em')
            ->paginate(15)
            ->withQueryString();

        // Traz todas as pesquisas para o select de filtro da view
        $pesquisas = PesquisaSatisfacao::query()
            ->orderBy('titulo')
            ->get(['id', 'codigo', 'titulo']);

        return view('iso9001.pesquisas_satisfacao_respostas.index', compact('respostas', 'pesquisas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $empresaId = auth()->user()->empresa_id;

        return view('iso9001.pesquisas_satisfacao_respostas.create', [
            'pesquisas' => PesquisaSatisfacao::where('empresa_id', $empresaId)
                ->whereIn('status', ['Em andamento', 'Planejada'])
                ->orderBy('titulo')->get(['id', 'codigo', 'titulo']),
            'clientes' => Cliente::where('empresa_id', $empresaId)
                ->orderBy('nome')->get(['id', 'nome']),
            'respondentes' => User::where('empresa_id', $empresaId)
                ->where('ativo', true)->orderBy('name')->get(['id', 'name']),
            'selectedPesquisaId' => $request->query('pesquisa_satisfacao_id'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePesquisaRespostaRequest $request)
    {
        $data = $request->validated();
        if (empty($data['respondido_em'])) {
            $data['respondido_em'] = now();
        }

        PesquisaSatisfacaoResposta::create($data);

        return redirect()
            ->route('pesquisas_satisfacao.show', $data['pesquisa_id'])
            ->with('success', 'Resposta registrada com sucesso.');
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
    public function edit(PesquisaSatisfacaoResposta $pesquisasSatisfacaoResposta)
    {
        $user = auth()->user();

        // Eager loading para otimizar os relacionamentos
        $pesquisasSatisfacaoResposta->load(['pesquisa', 'cliente', 'respondente']);

        // Busca de listas respeitando o perfil (admin/multitenant)
        $pesquisas = PesquisaSatisfacao::query()
            ->when($user->empresa_id, fn ($q) => $q->where('empresa_id', $user->empresa_id))
            ->orderBy('titulo')
            ->get(['id', 'codigo', 'titulo']);

        $clientes = Cliente::query()
            ->when($user->empresa_id, fn ($q) => $q->where('empresa_id', $user->empresa_id))
            ->orderBy('nome')
            ->get(['id', 'nome']);

        $respondentes = User::query()
            ->when($user->empresa_id, fn ($q) => $q->where('empresa_id', $user->empresa_id))
            ->where('ativo', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('iso9001.pesquisas_satisfacao_respostas.edit', [
            'resposta'     => $pesquisasSatisfacaoResposta,
            'pesquisas'    => $pesquisas,
            'clientes'     => $clientes,
            'respondentes' => $respondentes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePesquisaRespostaRequest $request, PesquisaSatisfacaoResposta $respostas_pesquisa)
    {
        $respostas_pesquisa->update($request->validated());

        return redirect()
            ->route('pesquisas_satisfacao.show', $respostas_pesquisa->pesquisa_id)
            ->with('success', 'Resposta atualizada com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PesquisaSatisfacaoResposta $respostas_pesquisa)
    {
        $pesquisaId = $respostas_pesquisa->pesquisa_id;
        $respostas_pesquisa->delete();

        return redirect()
            ->route('pesquisas_satisfacao.show', $pesquisaId)
            ->with('success', 'Resposta removida com sucesso.');
    }

public function export(Request $request): StreamedResponse
    {
        $filename = 'respostas_pesquisa_' . date('Y-m-d_H-i') . '.csv';

        $query = PesquisaSatisfacaoResposta::query()
            ->whereHas('pesquisa', fn ($q) => $q->where('empresa_id', auth()->user()->empresa_id))
            ->with(['pesquisa:id,codigo,titulo', 'cliente:id,nome', 'respondente:id,name'])
            ->when($request->pesquisa_satisfacao_id, fn ($q) => $q->where('pesquisa_id', $request->pesquisa_satisfacao_id));

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputs($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

            fputcsv($handle, ['ID', 'Código Pesquisa', 'Título Pesquisa', 'Cliente', 'Respondente', 'Nota', 'Classificação', 'Comentário', 'Data Resposta'], ';');

            $query->chunk(200, function ($respostas) use ($handle) {
                foreach ($respostas as $r) {
                    $comentario = $r->respostas_detalhadas['comentario'] ?? '';
                    fputcsv($handle, [
                        $r->id,
                        $r->pesquisa?->codigo,
                        $r->pesquisa?->titulo,
                        $r->cliente?->nome ?? '—',
                        $r->respondente?->name ?? '—',
                        number_format($r->nota, 2, ',', '.'),
                        $r->classificacao,
                        $comentario,
                        $r->respondido_em?->format('d/m/Y H:i'),
                    ], ';');
                }
            });

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
