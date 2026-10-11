<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Relatório de Revisão pela Direção — {{ $dados['periodo'] }}</title>
    <style>
        @page { margin: 40px 30px 70px 30px; }
        body  { font-family: DejaVu Sans, sans-serif; font-size: 10px; color: #1f2937; }

        /* Cabeçalho / rodapé */
        header { position: fixed; top: -20px; left: 0; right: 0; height: 30px;
                 border-bottom: 2px solid #1e40af; padding-bottom: 6px; }
        footer { position: fixed; bottom: -30px; left: 0; right: 0; height: 20px;
                 border-top: 1px solid #cbd5e1; font-size: 8px; color: #64748b;
                 padding-top: 4px; text-align: center; }

        h1 { font-size: 20px; color: #1e40af; margin: 0 0 4px 0; }
        h2 { font-size: 14px; color: #1e40af; border-bottom: 1px solid #e5e7eb;
             padding-bottom: 4px; margin: 20px 0 10px 0; }
        h3 { font-size: 11px; color: #374151; margin: 12px 0 6px 0; }

        .capa { text-align: center; padding: 80px 20px 0 20px; }
        .capa .titulo { font-size: 28px; font-weight: bold; color: #1e40af; }
        .capa .periodo { font-size: 18px; margin: 12px 0 40px 0; color: #4b5563; }
        .capa .meta { font-size: 10px; color: #6b7280; margin-top: 80px; line-height: 1.8; }

        /* KPIs em formato de tabela (DomPDF não suporta grid) */
        table.kpi { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table.kpi td { width: 25%; border: 1px solid #e5e7eb; padding: 8px;
                       vertical-align: top; }
        table.kpi .label { font-size: 9px; color: #374151; text-transform: uppercase; font-weight: 600; }
        table.kpi .valor { font-size: 16px; font-weight: bold; color: #111827; }

        /* Alertas */
        table.alertas { width: 100%; border-collapse: collapse; margin-top: 6px; }
        table.alertas th { background: #f3f4f6; text-align: left; padding: 5px 8px;
                            font-size: 9px; color: #374151; border: 1px solid #e5e7eb; }
        table.alertas td { padding: 5px 8px; border: 1px solid #e5e7eb; font-size: 9px; }
        .badge-red   { background: #fee2e2; color: #991b1b; padding: 2px 6px;
                       border-radius: 8px; font-weight: bold; }
        .badge-amber { background: #fef3c7; color: #92400e; padding: 2px 6px;
                       border-radius: 8px; font-weight: bold; }
        .badge-green { background: #d1fae5; color: #065f46; padding: 2px 6px;
                       border-radius: 8px; font-weight: bold; }

        /* Gráficos lado a lado */
        table.graficos { width: 100%; border-collapse: collapse; }
        table.graficos td { vertical-align: top; padding: 6px; }

        /* Destaque de dias sem acidente */
        .hero-45001 { background: #fff7ed; border-left: 4px solid #f97316;
                      padding: 12px; margin: 8px 0; }
        .hero-45001 .numero { font-size: 32px; font-weight: bold; color: #ea580c; }

        /* Quebra de página por ISO */
        .page-break { page-break-before: always; }

        /* Área para anotações manuais */
        .anotacoes { border: 1px dashed #cbd5e1; padding: 10px; min-height: 60px;
                     background: #f9fafb; font-size: 9px; color: #6b7280; }

        /* Barra de conformidade */
        .barra { background: #e5e7eb; height: 12px; border-radius: 6px; }
        .barra > div { height: 12px; border-radius: 6px; background: #10b981; }
    </style>
</head>
<body>

<header>
    <table style="width:100%">
        <tr>
            <td style="text-align:left; font-size:10px; color:#1e40af; font-weight:bold;">
                {{ $dados['empresa'] }} — Relatório de Revisão pela Direção
            </td>
            <td style="text-align:right; font-size:9px; color:#64748b;">
                {{ $dados['periodo'] }}
            </td>
        </tr>
    </table>
</header>

<footer>
    Gerado em {{ $dados['gerado_em']->format('d/m/Y H:i') }}
    · Sistema de Gestão Integrado · Página {PAGE_NUM} de {PAGE_COUNT}
</footer>

{{-- =================== CAPA =================== --}}
<div class="capa">
    <div class="titulo">Relatório de Revisão pela Direção</div>
    <div class="periodo">{{ $dados['periodo'] }}</div>

    <div style="text-align:left; padding: 0 60px;">
        <p style="font-size: 11px; line-height: 1.6; color: #374151;">
            Este relatório consolida os indicadores dos sistemas de gestão
            <strong>ISO 9001</strong>, <strong>ISO 14001</strong>,
            <strong>ISO 45001</strong>, <strong>ISO 27001</strong>,
            conforme requisito <strong>Cláusula 9.3</strong> das respectivas normas
            (Análise Crítica pela Direção).
        </p>
    </div>

    <div class="meta">
        <strong>{{ $dados['empresa'] }}</strong><br>
        Emitido em {{ $dados['gerado_em']->format('d/m/Y \à\s H:i') }}<br>
        Documento de uso interno
    </div>
</div>

<div class="page-break"></div>

{{-- =================== RESUMO EXECUTIVO (SIG) =================== --}}
<h2>1. Resumo Executivo — SIG</h2>

<table class="kpi">
    @foreach(array_chunk($dados['sig']['kpis'], 3, true) as $linha)
        <tr>
            @foreach($linha as $label => $valor)
                <td>
                    <div class="label">{{ $label }}</div>
                    <div class="valor">{{ $valor }}</div>
                </td>
            @endforeach
            @for($i = count($linha); $i < 3; $i++)<td></td>@endfor
        </tr>
    @endforeach
</table>

<table class="graficos">
    <tr>
        <td width="50%">
            <h3>Planos de ação por origem</h3>
            <img src="{{ \App\Support\QuickChart::doughnut($dados['sig']['grafico_planos_origem'], 380, 220) }}">
        </td>
        <td width="50%">
            <h3>Planos de ação por status</h3>
            <img src="{{ \App\Support\QuickChart::bar($dados['sig']['grafico_planos_status'], 380, 220, '#10b981') }}">
        </td>
    </tr>
</table>

@if($dados['sig']['ultima_revisao'])
    <p style="margin-top: 12px; font-size: 10px; color: #4b5563;">
        <strong>Última Revisão pela Direção:</strong>
        {{ \Carbon\Carbon::parse($dados['sig']['ultima_revisao']->data_reuniao)->format('d/m/Y') }}
        @if($dados['sig']['ultima_revisao']->proxima_reuniao)
            · <strong>Próxima:</strong>
            {{ \Carbon\Carbon::parse($dados['sig']['ultima_revisao']->proxima_reuniao)->format('d/m/Y') }}
        @endif
    </p>
@endif

{{-- =================== ISO 9001 =================== --}}
<div class="page-break"></div>
<h2>2. {{ $dados['iso9001']['titulo'] }}</h2>

<p style="font-size: 10px; color: #4b5563;">
    <strong>Conformidade geral:</strong> {{ $dados['iso9001']['conformidade_pct'] }}%
</p>
<div class="barra">
    <div style="width: {{ $dados['iso9001']['conformidade_pct'] }}%"></div>
</div>

<h3 style="margin-top: 14px;">Indicadores do período</h3>
<table class="kpi">
    @foreach(array_chunk($dados['iso9001']['kpis'], 3, true) as $linha)
        <tr>
            @foreach($linha as $label => $valor)
                <td><div class="label">{{ $label }}</div>
                    <div class="valor">{{ $valor }}</div></td>
            @endforeach
            @for($i = count($linha); $i < 3; $i++)<td></td>@endfor
        </tr>
    @endforeach
</table>

<table class="graficos">
    <tr>
        <td width="50%">
            <h3>NCs por origem (6 meses)</h3>
            <img src="{{ \App\Support\QuickChart::doughnut($dados['iso9001']['grafico_nc_origem'], 380, 220) }}">
        </td>
        <td width="50%">
            <h3>NCs por status</h3>
            <img src="{{ \App\Support\QuickChart::bar($dados['iso9001']['grafico_nc_status'], 380, 220, '#3b82f6') }}">
        </td>
    </tr>
</table>

<h3 style="margin-top: 14px;">Alertas abertos</h3>
<table class="alertas">
    <tr><th>Indicador</th><th>Valor</th><th>Status</th></tr>
    @foreach($dados['iso9001']['alertas'] as $nome => $v)
        <tr>
            <td>{{ $nome }}</td>
            <td>{{ $v }}</td>
            <td>
                @if($v == 0)<span class="badge-green">OK</span>
                @elseif($v <= 3)<span class="badge-amber">Atenção</span>
                @else<span class="badge-red">Crítico</span>
                @endif
            </td>
        </tr>
    @endforeach
</table>

<h3 style="margin-top: 14px;">Anotações da Direção</h3>
<div class="anotacoes">&nbsp;</div>

{{-- =================== ISO 14001 =================== --}}
<div class="page-break"></div>
<h2>3. {{ $dados['iso14001']['titulo'] }}</h2>

<p style="font-size: 10px; color: #4b5563;">
    <strong>Conformidade geral:</strong> {{ $dados['iso14001']['conformidade_pct'] }}%
</p>
<div class="barra">
    <div style="width: {{ $dados['iso14001']['conformidade_pct'] }}%"></div>
</div>

<h3 style="margin-top: 14px;">Indicadores do período</h3>
<table class="kpi">
    @foreach(array_chunk($dados['iso14001']['kpis'], 3, true) as $linha)
        <tr>
            @foreach($linha as $label => $valor)
                <td><div class="label">{{ $label }}</div>
                    <div class="valor">{{ $valor }}</div></td>
            @endforeach
            @for($i = count($linha); $i < 3; $i++)<td></td>@endfor
        </tr>
    @endforeach
</table>

<table class="graficos">
    <tr>
        <td width="50%">
            <h3>NCs ambientais por origem</h3>
            <img src="{{ \App\Support\QuickChart::doughnut($dados['iso14001']['grafico_nc_origem'], 380, 220) }}">
        </td>
        <td width="50%">
            <h3>NCs ambientais por status</h3>
            <img src="{{ \App\Support\QuickChart::bar($dados['iso14001']['grafico_nc_status'], 380, 220, '#10b981') }}">
        </td>
    </tr>
</table>

<h3 style="margin-top: 14px;">Alertas abertos</h3>
<table class="alertas">
    <tr><th>Indicador</th><th>Valor</th><th>Status</th></tr>
    @foreach($dados['iso14001']['alertas'] as $nome => $v)
        <tr>
            <td>{{ $nome }}</td>
            <td>{{ $v }}</td>
            <td>
                @if($v == 0)<span class="badge-green">OK</span>
                @elseif($v <= 3)<span class="badge-amber">Atenção</span>
                @else<span class="badge-red">Crítico</span>
                @endif
            </td>
        </tr>
    @endforeach
</table>

<h3 style="margin-top: 14px;">Anotações da Direção</h3>
<div class="anotacoes">&nbsp;</div>

{{-- =================== ISO 45001 =================== --}}
<div class="page-break"></div>
<h2>4. {{ $dados['iso45001']['titulo'] }}</h2>

@if($dados['iso45001']['destaque'] !== null)
    <div class="hero-45001">
        <table style="width:100%">
            <tr>
                <td>
                    <div style="font-size: 9px; text-transform: uppercase; color: #9a3412;">
                        Dias sem acidente com afastamento
                    </div>
                    <div class="numero">{{ $dados['iso45001']['destaque'] }}</div>
                </td>
                <td style="text-align:right; font-size:9px; color:#9a3412;">
                    Indicador cultural — divulgar em murais
                </td>
            </tr>
        </table>
    </div>
@endif

<h3>Indicadores do período</h3>
<table class="kpi">
    @foreach(array_chunk($dados['iso45001']['kpis'], 3, true) as $linha)
        <tr>
            @foreach($linha as $label => $valor)
                <td><div class="label">{{ $label }}</div>
                    <div class="valor">{{ $valor }}</div></td>
            @endforeach
            @for($i = count($linha); $i < 3; $i++)<td></td>@endfor
        </tr>
    @endforeach
</table>

<table class="graficos">
    <tr>
        <td width="50%">
            <h3>Incidentes por tipo (6 meses)</h3>
            <img src="{{ \App\Support\QuickChart::doughnut($dados['iso45001']['grafico_inc_tipo'], 380, 220) }}">
        </td>
        <td width="50%">
            <h3>Perigos por nível de risco</h3>
            <img src="{{ \App\Support\QuickChart::bar($dados['iso45001']['grafico_perigos_nivel'], 380, 220, '#f97316') }}">
        </td>
    </tr>
</table>

<h3 style="margin-top: 14px;">Alertas abertos</h3>
<table class="alertas">
    <tr><th>Indicador</th><th>Valor</th><th>Status</th></tr>
    @foreach($dados['iso45001']['alertas'] as $nome => $v)
        <tr>
            <td>{{ $nome }}</td>
            <td>{{ $v }}</td>
            <td>
                @if($v == 0)<span class="badge-green">OK</span>
                @elseif($v <= 3)<span class="badge-amber">Atenção</span>
                @else<span class="badge-red">Crítico</span>
                @endif
            </td>
        </tr>
    @endforeach
</table>

<h3 style="margin-top: 14px;">Anotações da Direção</h3>
<div class="anotacoes">&nbsp;</div>

{{-- =================== ISO 27001 =================== --}}
<div class="page-break"></div>
<h2>5. {{ $dados['iso27001']['titulo'] }}</h2>

<p style="font-size: 10px; color: #4b5563;">
    <strong>SoA implementado:</strong> {{ $dados['iso27001']['conformidade_pct'] }}%
</p>
<div class="barra">
    <div style="width: {{ $dados['iso27001']['conformidade_pct'] }}%"></div>
</div>

<h3 style="margin-top: 14px;">Indicadores do período</h3>
<table class="kpi">
    @foreach(array_chunk($dados['iso27001']['kpis'], 3, true) as $linha)
        <tr>
            @foreach($linha as $label => $valor)
                <td><div class="label">{{ $label }}</div>
                    <div class="valor">{{ $valor }}</div></td>
            @endforeach
            @for($i = count($linha); $i < 3; $i++)<td></td>@endfor
        </tr>
    @endforeach
</table>

<table class="graficos">
    <tr>
        <td width="50%">
            <h3>Incidentes por tipo (6 meses)</h3>
            <img src="{{ \App\Support\QuickChart::doughnut($dados['iso27001']['grafico_inc_tipo'], 380, 220) }}">
        </td>
        <td width="50%">
            <h3>Implementação do SoA</h3>
            <img src="{{ \App\Support\QuickChart::doughnut($dados['iso27001']['grafico_soa'], 380, 220) }}">
        </td>
    </tr>
</table>

<h3 style="margin-top: 14px;">Alertas abertos</h3>
<table class="alertas">
    <tr><th>Indicador</th><th>Valor</th><th>Status</th></tr>
    @foreach($dados['iso27001']['alertas'] as $nome => $v)
        <tr>
            <td>{{ $nome }}</td>
            <td>{{ $v }}</td>
            <td>
                @if($v == 0)<span class="badge-green">OK</span>
                @elseif($v <= 3)<span class="badge-amber">Atenção</span>
                @else<span class="badge-red">Crítico</span>
                @endif
            </td>
        </tr>
    @endforeach
</table>

<h3 style="margin-top: 14px;">Anotações da Direção</h3>
<div class="anotacoes">&nbsp;</div>

{{-- =================== CONCLUSÕES =================== --}}
<div class="page-break"></div>
<h2>6. Conclusões e Deliberações da Direção</h2>

<p style="font-size: 10px; color: #4b5563;">
    Espaço destinado ao registro das decisões tomadas durante a reunião de
    Análise Crítica pela Direção, conforme Cláusula 9.3.3.
</p>

<h3>6.1 Oportunidades de melhoria identificadas</h3>
<div class="anotacoes" style="min-height: 120px;">&nbsp;</div>

<h3>6.2 Necessidades de mudanças no SGI</h3>
<div class="anotacoes" style="min-height: 120px;">&nbsp;</div>

<h3>6.3 Recursos necessários</h3>
<div class="anotacoes" style="min-height: 100px;">&nbsp;</div>

<table style="width:100%; margin-top: 40px;">
    <tr>
        <td width="50%" style="text-align:center; padding-top: 40px;
                               border-top: 1px solid #374151;">
            <div style="font-size: 9px; color: #6b7280;">Alta Direção</div>
        </td>
        <td width="50%" style="text-align:center; padding-top: 40px;
                               border-top: 1px solid #374151;">
            <div style="font-size: 9px; color: #6b7280;">Representante da Direção (SGI)</div>
        </td>
    </tr>
</table>

</body>
</html>