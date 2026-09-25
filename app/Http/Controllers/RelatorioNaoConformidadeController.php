<?php

namespace App\Http\Controllers;

use App\Models\NaoConformidade;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class RelatorioNaoConformidadeController extends Controller
{
    /**
     * Gera o PDF completo da NC com análises de causa e ações corretivas.
     */
    public function pdf(NaoConformidade $naoConformidade): Response
    {
        // $this->authorize('view', $naoConformidade);

        $naoConformidade->load([
            'empresa',
            'cliente',
            'norma',
            'clausula',
            'processo',
            'responsavelApuracao',
            'responsavelTratamento',

            'analisesCausa' => fn ($q) => $q
                ->with([
                    'responsavel',
                    'respostas' => fn ($r) => $r->orderBy('ordem'),
                    'ishikawa.responsavel',
                    'ishikawa.causas' => fn ($c) => $c->orderBy('categoria')->orderBy('id'),
                    'ishikawa.causas.responsavelValidacao',
                ])
                ->orderBy('created_at'),

            'acoesCorretivas' => fn ($q) => $q
                ->with('responsavel')
                ->orderByRaw("
                    CASE etapa
                        WHEN 'Contenção'   THEN 1
                        WHEN 'Causa raiz'  THEN 2
                        WHEN 'Correção'    THEN 3
                        WHEN 'Verificação' THEN 4
                        WHEN 'Conclusão'   THEN 5
                        ELSE 6
                    END
                ")
                ->orderBy('prazo'),
        ]);

        // Timeline (reaproveita a lógica que já existe no NaoConformidadeController)
        $timeline = app(NaoConformidadeController::class)
            ->montarTimelinePublica($naoConformidade);

        // Data/hora de emissão + quem emitiu
        $emitidoEm = now();
        $emitidoPor = auth()->user();

        $pdf = Pdf::loadView('pdf.nao_conformidade', compact(
            'naoConformidade',
            'timeline',
            'emitidoEm',
            'emitidoPor'
        ));

        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'isRemoteEnabled'      => true,
            'isHtml5ParserEnabled' => true,
            'defaultFont'          => 'DejaVu Sans',
            'dpi'                  => 130,
            'chroot'               => base_path(),
        ]);

        $nomeArquivo = "NC-{$naoConformidade->codigo}-relatorio.pdf";

        return $pdf->download($nomeArquivo);

        // Use ->stream($nomeArquivo) para abrir no navegador em vez de baixar.
    }
}