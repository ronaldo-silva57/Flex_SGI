<?php

namespace App\Http\Controllers;

use App\Models\HistoricoAlteracao;
use Illuminate\Http\Request;

class HistoricoAlteracaoController extends Controller
{
    /**
     * Listagem dos registros de auditoria.
     */
    public function index(Request $request)
    {
        $query = HistoricoAlteracao::with('usuario');

        // Filtro por tabela
        if ($request->filled('tabela')) {
            $query->where('tabela', 'ilike', '%' . $request->tabela . '%');
        }

        // Filtro por ação
        if ($request->filled('acao')) {
            $query->where('acao', $request->acao);
        }

        // Filtro por usuário
        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        // Filtro por data (intervalo)
        if ($request->filled('data_inicio')) {
            $query->whereDate('created_at', '>=', $request->data_inicio);
        }
        if ($request->filled('data_fim')) {
            $query->whereDate('created_at', '<=', $request->data_fim);
        }

        // Busca livre (tabela ou registro_id)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tabela', 'ilike', "%{$search}%")
                  ->orWhere('registro_id', 'like', "%{$search}%");
            });
        }

        $historicos = $query
            ->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        // Lista de tabelas distintas para o filtro
        $tabelasDisponiveis = HistoricoAlteracao::query()
            ->select('tabela')
            ->distinct()
            ->orderBy('tabela')
            ->pluck('tabela');

        return view('cadastros.historico_alteracoes.index', compact(
            'historicos',
            'tabelasDisponiveis'
        ));
    }

    /**
     * Exibe um registro específico (comparação antes/depois).
     */
    public function show(HistoricoAlteracao $historico_alteracao)
    {
        $historico_alteracao->load('usuario');

        return view('cadastros.historico_alteracoes.show', compact('historico_alteracao'));
    }
}