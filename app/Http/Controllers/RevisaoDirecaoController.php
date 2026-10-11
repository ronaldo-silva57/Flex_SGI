<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RelatorioRevisaoDirecaoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RevisaoDirecaoController extends Controller
{
    public function __construct(
        private RelatorioRevisaoDirecaoService $service
    ) {}

    /** Download direto pelo navegador */
    public function baixar()
    {
        $dados = $this->service->gerar();
        $pdf   = $this->buildPdf($dados);

        $nome = 'revisao-direcao-'
              . $dados['gerado_em']->format('Y-m-d_His') . '.pdf';

        return $pdf->download($nome);
    }

    /** Pré-visualização em HTML (mesmo layout, sem gerar PDF) */
    public function preview()
    {
        $dados = $this->service->gerar();
        return view('relatorios.revisao-direcao', compact('dados'));
    }

    /** Gera e salva em storage/app/relatorios/ */
    public function gerar(?Carbon $ref = null): string
    {
        $dados = $this->service->gerar($ref);
        $pdf   = $this->buildPdf($dados);

        $nome   = 'revisao-direcao-' . ($ref ?? now())->format('Y-m') . '.pdf';
        $caminho = 'relatorios/' . $nome;

        Storage::disk('local')->put($caminho, $pdf->output());

        return $caminho;
    }

    private function buildPdf(array $dados)
    {
        return Pdf::loadView('relatorios.revisao-direcao', compact('dados'))
            ->setPaper('a4', 'portrait')
            ->setOption('enable_remote', true)   // ← crítico p/ QuickChart
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('dpi', 150);
    }
}
