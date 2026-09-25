<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Relatório NC {{ $naoConformidade->codigo }}</title>
    <style>
        /* ========================================================= */
        /* Reset e base                                               */
        /* ========================================================= */
        @page {
            margin: 110px 40px 80px 40px;
        }
        @page :first {
            margin: 140px 40px 80px 40px;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #1f2937;
            line-height: 1.45;
            margin: 0;
        }

        h1, h2, h3, h4 { margin: 0; font-weight: bold; }

        /* ========================================================= */
        /* Header fixo em todas as páginas                            */
        /* ========================================================= */
        .pdf-header {
            position: fixed;
            top: -90px;
            left: 0; right: 0;
            height: 80px;
            border-bottom: 2px solid #b91c1c;
            padding-bottom: 8px;
        }
        .pdf-header table { width: 100%; }
        .pdf-header td { vertical-align: middle; }
        .pdf-header .logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
        .pdf-header .empresa { font-size: 14px; font-weight: bold; color: #111827; }
        .pdf-header .subtitulo { font-size: 9px; color: #6b7280; }
        .pdf-header .doc-tipo {
            text-align: right;
            font-size: 9px;
            color: #6b7280;
        }
        .pdf-header .doc-tipo strong {
            display: block;
            font-size: 12px;
            color: #b91c1c;
            letter-spacing: 0.5px;
        }

        /* ========================================================= */
        /* Footer fixo em todas as páginas                            */
        /* ========================================================= */
        .pdf-footer {
            position: fixed;
            bottom: -55px;
            left: 0; right: 0;
            height: 45px;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
            font-size: 8px;
            color: #6b7280;
        }
        .pdf-footer .page:after {
            content: "Página " counter(page) " de " counter(pages);
        }
        .pdf-footer table { width: 100%; }

        /* ========================================================= */
        /* Capa / título                                              */
        /* ========================================================= */
        .doc-titulo {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 3px double #b91c1c;
        }
        .doc-titulo h1 {
            font-size: 18px;
            color: #7f1d1d;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .doc-titulo .codigo {
            font-family: 'DejaVu Sans Mono', monospace;
            font-size: 12px;
            color: #374151;
            background: #f3f4f6;
            display: inline-block;
            padding: 3px 10px;
            border-radius: 3px;
            margin-top: 6px;
        }
        .doc-titulo .titulo-nc {
            font-size: 13px;
            color: #111827;
            margin-top: 8px;
            font-weight: bold;
        }

        /* ========================================================= */
        /* Seções                                                     */
        /* ========================================================= */
        .secao {
            margin-bottom: 16px;
            page-break-inside: avoid;
        }
        .secao-titulo {
            background: #7f1d1d;
            color: #fff;
            font-size: 10px;
            font-weight: bold;
            padding: 5px 10px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }
        .secao-corpo {
            padding: 0 4px;
        }

        /* ========================================================= */
        /* Grid de definições                                         */
        /* ========================================================= */
        .grid {
            width: 100%;
            border-collapse: collapse;
        }
        .grid td {
            padding: 4px 8px;
            vertical-align: top;
            border-bottom: 1px solid #f3f4f6;
        }
        .grid .label {
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            width: 110px;
        }
        .grid .valor {
            font-size: 10px;
            color: #111827;
        }
        .grid-2col td:nth-child(1) { width: 15%; }
        .grid-2col td:nth-child(2) { width: 35%; }
        .grid-2col td:nth-child(3) { width: 15%; }
        .grid-2col td:nth-child(4) { width: 35%; }

        /* ========================================================= */
        /* Badges                                                     */
        /* ========================================================= */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .badge-aberta      { background: #fee2e2; color: #991b1b; }
        .badge-analise     { background: #fef3c7; color: #92400e; }
        .badge-acao        { background: #dbeafe; color: #1e40af; }
        .badge-verificacao { background: #e9d5ff; color: #6b21a8; }
        .badge-fechada     { background: #d1fae5; color: #065f46; }

        .badge-baixa   { background: #dbeafe; color: #1e40af; }
        .badge-media   { background: #fef3c7; color: #92400e; }
        .badge-alta    { background: #fed7aa; color: #9a3412; }
        .badge-critica { background: #fecaca; color: #991b1b; }

        /* ========================================================= */
        /* Blocos de texto longo                                      */
        /* ========================================================= */
        .texto-bloco {
            background: #f9fafb;
            border-left: 3px solid #b91c1c;
            padding: 8px 12px;
            font-size: 10px;
            color: #374151;
            white-space: pre-line;
            margin: 4px 0;
        }

        /* ========================================================= */
        /* Tabelas de dados                                           */
        /* ========================================================= */
        table.dados {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-top: 4px;
        }
        table.dados th {
            background: #f3f4f6;
            color: #374151;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 5px 6px;
            text-align: left;
            border: 1px solid #e5e7eb;
        }
        table.dados td {
            padding: 5px 6px;
            border: 1px solid #e5e7eb;
            vertical-align: top;
            color: #374151;
        }
        table.dados tr:nth-child(even) td {
            background: #fafafa;
        }
        .col-center { text-align: center; }
        .col-right  { text-align: right; }
        .col-raiz {
            background: #fef2f2 !important;
            font-weight: bold;
            color: #991b1b;
        }

        /* ========================================================= */
        /* Quebra de páginas                                          */
        /* ========================================================= */
        .quebra-pagina {
            page-break-before: always;
        }
        .evitar-quebra {
            page-break-inside: avoid;
        }

        /* ========================================================= */
        /* Timeline                                                   */
        /* ========================================================= */
        .timeline { margin: 0; padding: 0; list-style: none; }
        .timeline li {
            padding: 6px 0 6px 20px;
            border-left: 2px solid #e5e7eb;
            position: relative;
            margin-left: 6px;
        }
        .timeline li:before {
            content: "";
            position: absolute;
            left: -7px;
            top: 9px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #b91c1c;
            border: 2px solid #fff;
        }
        .timeline .tl-data {
            font-size: 8px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .timeline .tl-titulo {
            font-size: 10px;
            font-weight: bold;
            color: #111827;
        }
        .timeline .tl-desc {
            font-size: 9px;
            color: #4b5563;
            margin-top: 2px;
        }

        /* ========================================================= */
        /* Assinaturas                                                */
        /* ========================================================= */
        .assinaturas {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .assinaturas td {
            width: 50%;
            padding: 0 20px;
            text-align: center;
            vertical-align: bottom;
        }
        .assinatura-linha {
            border-top: 1px solid #374151;
            padding-top: 4px;
            margin-top: 40px;
        }
        .assinatura-nome {
            font-size: 10px;
            font-weight: bold;
            color: #111827;
        }
        .assinatura-cargo {
            font-size: 8px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        /* ========================================================= */
        /* Info box (assinaturas no rodapé do doc)                    */
        /* ========================================================= */
        .info-emissao {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 3px;
            padding: 6px 10px;
            font-size: 8px;
            color: #6b7280;
            margin-top: 20px;
        }
    </style>
</head>
<body>

{{-- ================================================================== --}}
{{-- HEADER FIXO (todas as páginas)                                     --}}
{{-- ================================================================== --}}
<div class="pdf-header">
    <table>
        <tr>
            <td style="width: 80px;">
                @if($naoConformidade->empresa?->logo)
                    <img src="{{ public_path('storage/' . $naoConformidade->empresa->logo) }}"
                         class="logo" alt="Logo">
                @else
                    <div style="width:70px;height:70px;border:1px dashed #d1d5db;border-radius:4px;
                                display:flex;align-items:center;justify-content:center;
                                font-size:8px;color:#9ca3af;text-align:center;">
                        SEM<br>LOGO
                    </div>
                @endif
            </td>
            <td style="padding-left: 12px;">
                <div class="empresa">
                    {{ $naoConformidade->empresa->razao_social ?? 'Empresa' }}
                </div>
                <div class="subtitulo">
                    @if($naoConformidade->empresa?->cnpj)
                        CNPJ: {{ $naoConformidade->empresa->cnpj }}
                    @endif
                    @if($naoConformidade->empresa?->endereco)
                        · {{ $naoConformidade->empresa->endereco }}
                    @endif
                </div>
                <div class="subtitulo">
                    Sistema de Gestão da Qualidade
                </div>
            </td>
            <td class="doc-tipo">
                <strong>RELATÓRIO DE NÃO CONFORMIDADE</strong>
                <span>{{ $naoConformidade->codigo }}</span>
            </td>
        </tr>
    </table>
</div>

{{-- ================================================================== --}}
{{-- FOOTER FIXO (todas as páginas)                                     --}}
{{-- ================================================================== --}}
<div class="pdf-footer">
    <table>
        <tr>
            <td>
                Documento gerado eletronicamente em
                {{ $emitidoEm->format('d/m/Y \à\s H:i') }}
                @if($emitidoPor)
                    por {{ $emitidoPor->name }}
                @endif
            </td>
            <td style="text-align:right;" class="page"></td>
        </tr>
    </table>
</div>

{{-- ================================================================== --}}
{{-- CONTEÚDO                                                           --}}
{{-- ================================================================== --}}

<div class="doc-titulo">
    <h1>Relatório de Não Conformidade</h1>
    <div class="codigo">{{ $naoConformidade->codigo }}</div>
    <div class="titulo-nc">{{ $naoConformidade->titulo }}</div>
</div>

{{-- ================================================================== --}}
{{-- 1. IDENTIFICAÇÃO                                                    --}}
{{-- ================================================================== --}}
<div class="secao">
    <div class="secao-titulo">1. Identificação</div>
    <div class="secao-corpo">
        <table class="grid grid-2col">
            <tr>
                <td class="label">Tipo</td>
                <td class="valor">{{ $naoConformidade->tipo ?? 'Não Conformidade' }}</td>
                <td class="label">Origem</td>
                <td class="valor">{{ $naoConformidade->origem }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td class="valor">
                    @php
                        $statusCls = [
                            'Aberta'      => 'badge-aberta',
                            'Em analise'  => 'badge-analise',
                            'Em ação'     => 'badge-acao',
                            'Verificação' => 'badge-verificacao',
                            'Fechada'     => 'badge-fechada',
                        ][$naoConformidade->status] ?? 'badge-aberta';
                    @endphp
                    <span class="badge {{ $statusCls }}">{{ $naoConformidade->status }}</span>
                    @if($naoConformidade->recorrente)
                        <span class="badge badge-alta" style="margin-left:4px;">RECORRENTE</span>
                    @endif
                </td>
                <td class="label">Local</td>
                <td class="valor">{{ $naoConformidade->local_ocorrencia ?? '—' }}</td>
            </tr>
            <tr>
                <td class="label">Empresa</td>
                <td class="valor">{{ $naoConformidade->empresa->razao_social ?? '—' }}</td>
                <td class="label">Cliente</td>
                <td class="valor">
                    {{ $naoConformidade->cliente->razao_social
                        ?? ($naoConformidade->cliente->nome ?? '—') }}
                </td>
            </tr>
            <tr>
                <td class="label">Norma</td>
                <td class="valor">{{ $naoConformidade->norma->codigo ?? '—' }}</td>
                <td class="label">Cláusula</td>
                <td class="valor">
                    {{ $naoConformidade->clausula->descricao
                        ?? $naoConformidade->clausula->nome
                        ?? '—' }}
                </td>
            </tr>
            <tr>
                <td class="label">Processo</td>
                <td class="valor">{{ $naoConformidade->processo->nome ?? '—' }}</td>
                <td class="label">Gravidade</td>
                <td class="valor">
                    @php
                        $grav = $naoConformidade->gravidade ?? 'N/A';
                        $gravCls = [
                            'Baixa'   => 'badge-baixa',
                            'Media'   => 'badge-media',
                            'Alta'    => 'badge-alta',
                            'Crítica' => 'badge-critica',
                        ][$grav] ?? 'badge-baixa';
                    @endphp
                    <span class="badge {{ $gravCls }}">{{ $grav }}</span>
                    @if($naoConformidade->probabilidade)
                        · Probabilidade: <strong>{{ $naoConformidade->probabilidade }}</strong>
                    @endif
                    @if($naoConformidade->prioridade)
                        · Prioridade: <strong>{{ $naoConformidade->prioridade }}</strong>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- ================================================================== --}}
{{-- 2. RESPONSÁVEIS                                                     --}}
{{-- ================================================================== --}}
<div class="secao">
    <div class="secao-titulo">2. Responsáveis</div>
    <div class="secao-corpo">
        <table class="grid grid-2col">
            <tr>
                <td class="label">Apuração</td>
                <td class="valor">
                    {{ $naoConformidade->responsavelApuracao->name ?? 'Não atribuído' }}
                </td>
                <td class="label">Tratamento</td>
                <td class="valor">
                    {{ $naoConformidade->responsavelTratamento->name ?? 'Não atribuído' }}
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- ================================================================== --}}
{{-- 3. DESCRIÇÃO DA OCORRÊNCIA                                          --}}
{{-- ================================================================== --}}
<div class="secao">
    <div class="secao-titulo">3. Descrição da Ocorrência</div>
    <div class="secao-corpo">
        <div style="font-size:8px;color:#6b7280;text-transform:uppercase;margin-bottom:2px;">
            Descrição
        </div>
        <div class="texto-bloco">{{ $naoConformidade->descricao }}</div>

        @if($naoConformidade->requisito_nao_atendido)
            <div style="font-size:8px;color:#6b7280;text-transform:uppercase;margin:8px 0 2px;">
                Requisito não atendido
            </div>
            <div class="texto-bloco">{{ $naoConformidade->requisito_nao_atendido }}</div>
        @endif

        @if($naoConformidade->evidencia_inicial)
            <div style="font-size:8px;color:#6b7280;text-transform:uppercase;margin:8px 0 2px;">
                Evidência inicial
            </div>
            <div class="texto-bloco">{{ $naoConformidade->evidencia_inicial }}</div>
        @endif
    </div>
</div>

{{-- ================================================================== --}}
{{-- 4. DATAS-CHAVE                                                      --}}
{{-- ================================================================== --}}
<div class="secao">
    <div class="secao-titulo">4. Prazos e Datas</div>
    <div class="secao-corpo">
        <table class="dados">
            <thead>
                <tr>
                    <th class="col-center">Identificação</th>
                    <th class="col-center">Abertura</th>
                    <th class="col-center">Prazo Tratamento</th>
                    <th class="col-center">Análise</th>
                    <th class="col-center">Verificação</th>
                    <th class="col-center">Encerramento</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-center">{{ $naoConformidade->data_identificacao?->format('d/m/Y') ?? '—' }}</td>
                    <td class="col-center">{{ $naoConformidade->data_abertura?->format('d/m/Y') ?? '—' }}</td>
                    <td class="col-center">{{ $naoConformidade->prazo_tratamento?->format('d/m/Y') ?? '—' }}</td>
                    <td class="col-center">{{ $naoConformidade->data_analise?->format('d/m/Y') ?? '—' }}</td>
                    <td class="col-center">{{ $naoConformidade->data_verificacao?->format('d/m/Y') ?? '—' }}</td>
                    <td class="col-center">{{ $naoConformidade->data_encerramento?->format('d/m/Y') ?? '—' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- ================================================================== --}}
{{-- 5. ANÁLISES DE CAUSA                                                --}}
{{-- ================================================================== --}}
@if($naoConformidade->analisesCausa->isNotEmpty())
    <div class="quebra-pagina"></div>

    <div class="secao">
        <div class="secao-titulo">
            5. Análise de Causa ({{ $naoConformidade->analisesCausa->count() }})
        </div>

        @foreach($naoConformidade->analisesCausa as $idx => $analise)
            <div class="secao-corpo evitar-quebra" style="margin-bottom:14px;">
                <table class="grid grid-2col" style="margin-bottom:6px;">
                    <tr>
                        <td class="label">Método</td>
                        <td class="valor"><strong>{{ $analise->metodo }}</strong></td>
                        <td class="label">Responsável</td>
                        <td class="valor">{{ $analise->responsavel->name ?? '—' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Status</td>
                        <td class="valor">{{ $analise->status }}</td>
                        <td class="label">Período</td>
                        <td class="valor">
                            {{ $analise->data_inicio?->format('d/m/Y') ?? '—' }}
                            @if($analise->data_conclusao)
                                → {{ $analise->data_conclusao->format('d/m/Y') }}
                            @endif
                        </td>
                    </tr>
                </table>

                @if($analise->objetivo)
                    <div style="font-size:8px;color:#6b7280;text-transform:uppercase;margin:4px 0 2px;">
                        Objetivo
                    </div>
                    <div class="texto-bloco">{{ $analise->objetivo }}</div>
                @endif

                {{-- 5 Porquês --}}
                @if($analise->respostas->isNotEmpty())
                    <div style="font-size:9px;font-weight:bold;color:#7f1d1d;margin:10px 0 4px;">
                        ▸ Técnica dos 5 Porquês
                    </div>
                    <table class="dados">
                        <thead>
                            <tr>
                                <th class="col-center" style="width:30px;">#</th>
                                <th style="width:30%;">Pergunta</th>
                                <th>Resposta</th>
                                <th style="width:20%;">Evidência</th>
                                <th class="col-center" style="width:50px;">Raiz</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($analise->respostas as $i => $r)
                                <tr>
                                    <td class="col-center">{{ $i + 1 }}</td>
                                    <td>{{ $r->pergunta }}</td>
                                    <td class="{{ $r->eh_causa_raiz ? 'col-raiz' : '' }}">{{ $r->resposta }}</td>
                                    <td>{{ $r->evidencia ?? '—' }}</td>
                                    <td class="col-center">
                                        @if($r->eh_causa_raiz)
                                            <span class="badge badge-critica">SIM</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                {{-- Ishikawa --}}
                @if($analise->ishikawa)
                    <div style="font-size:9px;font-weight:bold;color:#3730a3;margin:10px 0 4px;">
                        ▸ Diagrama de Ishikawa
                    </div>
                    <table class="grid grid-2col" style="margin-bottom:4px;">
                        <tr>
                            <td class="label">Efeito</td>
                            <td class="valor">{{ $analise->ishikawa->efeito_analisado }}</td>
                            <td class="label">Responsável</td>
                            <td class="valor">{{ $analise->ishikawa->responsavel->name ?? '—' }}</td>
                        </tr>
                    </table>

                    @if($analise->ishikawa->causas->isNotEmpty())
                        @php
                            $porCategoria = $analise->ishikawa->causas->groupBy('categoria');
                        @endphp
                        <table class="dados">
                            <thead>
                                <tr>
                                    <th style="width:20%;">Categoria</th>
                                    <th>Descrição da causa</th>
                                    <th style="width:18%;">Evidência</th>
                                    <th class="col-center" style="width:55px;">Confirm.</th>
                                    <th class="col-center" style="width:45px;">Raiz</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($porCategoria as $categoria => $causas)
                                    @foreach($causas as $i => $c)
                                        <tr>
                                            @if($i === 0)
                                                <td rowspan="{{ $causas->count() }}" style="font-weight:bold;color:#374151;">
                                                    {{ $categoria }}
                                                </td>
                                            @endif
                                            <td class="{{ $c->causa_raiz ? 'col-raiz' : '' }}">{{ $c->descricao }}</td>
                                            <td>{{ $c->evidencia ?? '—' }}</td>
                                            <td class="col-center">{{ $c->confirmada ? 'Sim' : 'Não' }}</td>
                                            <td class="col-center">
                                                @if($c->causa_raiz)
                                                    <span class="badge badge-critica">SIM</span>
                                                @else
                                                    —
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if($analise->ishikawa->conclusao)
                        <div style="font-size:8px;color:#6b7280;text-transform:uppercase;margin:6px 0 2px;">
                            Conclusão do diagrama
                        </div>
                        <div class="texto-bloco">{{ $analise->ishikawa->conclusao }}</div>
                    @endif
                @endif

                @if($analise->conclusao)
                    <div style="font-size:8px;color:#6b7280;text-transform:uppercase;margin:8px 0 2px;">
                        Conclusão da análise
                    </div>
                    <div class="texto-bloco" style="border-left-color:#16a34a;">
                        {{ $analise->conclusao }}
                    </div>
                @endif
            </div>

            @unless($loop->last)
                <div style="border-top:1px dashed #e5e7eb;margin:10px 0;"></div>
            @endunless
        @endforeach
    </div>
@endif

{{-- ================================================================== --}}
{{-- 6. AÇÕES CORRETIVAS                                                 --}}
{{-- ================================================================== --}}
@if($naoConformidade->acoesCorretivas->isNotEmpty())
    <div class="quebra-pagina"></div>

    <div class="secao">
        <div class="secao-titulo">
            6. Ações Corretivas ({{ $naoConformidade->acoesCorretivas->count() }})
        </div>
        <div class="secao-corpo">
            <table class="dados">
                <thead>
                    <tr>
                        <th style="width:70px;">Etapa</th>
                        <th>Descrição</th>
                        <th style="width:15%;">Responsável</th>
                        <th class="col-center" style="width:60px;">Prazo</th>
                        <th class="col-center" style="width:65px;">Execução</th>
                        <th class="col-center" style="width:65px;">Status</th>
                        <th class="col-center" style="width:50px;">Eficaz</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($naoConformidade->acoesCorretivas as $acao)
                        <tr>
                            <td><strong>{{ $acao->etapa }}</strong></td>
                            <td>
                                {{ $acao->descricao }}
                                @if($acao->evidencia)
                                    <div style="font-size:8px;color:#6b7280;margin-top:3px;">
                                        <strong>Evidência:</strong> {{ $acao->evidencia }}
                                    </div>
                                @endif
                            </td>
                            <td>{{ $acao->responsavel->name ?? '—' }}</td>
                            <td class="col-center">
                                {{ $acao->prazo?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="col-center">
                                {{ $acao->data_execucao?->format('d/m/Y') ?? '—' }}
                            </td>
                            <td class="col-center">{{ $acao->status }}</td>
                            <td class="col-center">
                                @if($acao->eficaz === true)
                                    <span style="color:#16a34a;font-weight:bold;">Sim</span>
                                @elseif($acao->eficaz === false)
                                    <span style="color:#dc2626;font-weight:bold;">Não</span>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

{{-- ================================================================== --}}
{{-- 7. ENCERRAMENTO                                                     --}}
{{-- ================================================================== --}}
@if($naoConformidade->justificativa_encerramento)
    <div class="secao">
        <div class="secao-titulo">7. Justificativa de Encerramento</div>
        <div class="secao-corpo">
            <div class="texto-bloco" style="border-left-color:#16a34a;">
                {{ $naoConformidade->justificativa_encerramento }}
            </div>
        </div>
    </div>
@endif

{{-- ================================================================== --}}
{{-- 8. HISTÓRICO / TIMELINE                                             --}}
{{-- ================================================================== --}}
@if($timeline->isNotEmpty())
    <div class="quebra-pagina"></div>

    <div class="secao">
        <div class="secao-titulo">8. Histórico de Eventos</div>
        <div class="secao-corpo">
            <ul class="timeline">
                @foreach($timeline as $evento)
                    <li>
                        <div class="tl-data">
                            {{ optional($evento['data'])->format('d/m/Y') ?? '—' }}
                        </div>
                        <div class="tl-titulo">{{ $evento['titulo'] }}</div>
                        @if(!empty($evento['desc']))
                            <div class="tl-desc">{{ $evento['desc'] }}</div>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

{{-- ================================================================== --}}
{{-- 9. ASSINATURAS                                                      --}}
{{-- ================================================================== --}}
<div class="secao evitar-quebra" style="margin-top:24px;">
    <div class="secao-titulo">9. Aprovações</div>
    <div class="secao-corpo">
        <table class="assinaturas">
            <tr>
                <td>
                    <div class="assinatura-linha"></div>
                    <div class="assinatura-nome">
                        {{ $naoConformidade->responsavelTratamento->name ?? '________________________' }}
                    </div>
                    <div class="assinatura-cargo">Responsável pelo Tratamento</div>
                </td>
                <td>
                    <div class="assinatura-linha"></div>
                    <div class="assinatura-nome">
                        {{ $naoConformidade->responsavelApuracao->name ?? '________________________' }}
                    </div>
                    <div class="assinatura-cargo">Responsável pela Apuração</div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="info-emissao">
                        <strong>Documento emitido eletronicamente</strong> em
                        {{ $emitidoEm->format('d/m/Y \à\s H:i') }}
                        @if($emitidoPor)
                            por <strong>{{ $emitidoPor->name }}</strong>
                            @if($emitidoPor->email)
                                ({{ $emitidoPor->email }})
                            @endif
                        @endif
                        — {{ config('app.name') }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>