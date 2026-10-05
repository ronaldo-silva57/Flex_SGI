<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\NormaController;
use App\Http\Controllers\ClausulaController;
use App\Http\Controllers\ProcessoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\IndicadorController;
use App\Http\Controllers\MonitoramentoController;
use App\Http\Controllers\RiscoOportunidadeController;
use App\Http\Controllers\NaoConformidadeController;
use App\Http\Controllers\AcaoCorretivaController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\AuditoriaItemController;
use App\Http\Controllers\ReuniaoGestaoControlle;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\TreinamentoController;
use App\Http\Controllers\TreinamentoUsuarioController;
use App\Http\Controllers\RegistroLegalController;
use App\Http\Controllers\AspectoAmbientalController;
use App\Http\Controllers\PerigoRiscoController;
use App\Http\Controllers\IncidenteAcidenteController;
use App\Http\Controllers\EpiController;
use App\Http\Controllers\EpiUsuarioController;
use App\Http\Controllers\AtivoInformacaoController;
use App\Http\Controllers\ControleSegurancaController;
use App\Http\Controllers\IncidenteSegurancaController;
use App\Http\Controllers\EsgIndicadorController;
use App\Http\Controllers\EsgMonitoramentoController;
use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\MaterialidadeController;
use App\Http\Controllers\VinculoNormativoController;
use App\Http\Controllers\HistoricoAlteracaoController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\AnaliseCausaController;
use App\Http\Controllers\LicencaAmbientalController;
use App\Http\Controllers\ObjetivoAmbientalController;
use App\Http\Controllers\ProdutoQuimicoController;
use App\Http\Controllers\NaoConformidadeAmbientalController;
use App\Http\Controllers\IndicadorAmbientalController;

use App\Http\Controllers\PlanoAcaoController;
use App\Http\Controllers\ExameMedicoController;
use App\Http\Controllers\MudancaGestaoController;
use App\Http\Controllers\AvaliacaoFornecedorController;
use App\Http\Controllers\AnaliseRiscoTiController;
use App\Http\Controllers\CipaReuniaoController;

use App\Http\Controllers\AnaliseCausaRespostaController;
use App\Http\Controllers\AnaliseIshikawaController;
use App\Http\Controllers\IshikawaCausaController;
use App\Http\Controllers\RelatorioNaoConformidadeController;
use App\Http\Controllers\GestaoResiduoController;

use App\Http\Controllers\PesquisaSatisfacaoController;
use App\Http\Controllers\PesquisaSatisfacaoRespostaController;
use App\Http\Controllers\EquipamentoMedicaoController;
use App\Http\Controllers\CalibracaoController;

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware('guest')->group(function () {
    Route::get('register', fn() => redirect()->route('login'))->name('register');
});

// Setup inicial
Route::get('/setup', [SetupController::class, 'create'])->name('setup.create');
Route::post('/setup', [SetupController::class, 'store'])->name('setup.store');

Route::middleware(['auth', 'verified'])->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard Principal
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Painel Geral (gráficos, KPIs, alertas)
    Route::get('/dashboard/painel-geral', [DashboardController::class, 'index'])->name('painel.geral');

    // Recursos
    Route::patch('fornecedores/{id}/restore', [FornecedorController::class, 'restore'])->name('fornecedores.restore');
    Route::resource('empresas', EmpresaController::class);
    Route::resource('departamentos', DepartamentoController::class);
    Route::resource('fornecedores', FornecedorController::class)->parameters(['fornecedores' => 'fornecedor']);
    Route::resource('clientes', ClienteController::class)->parameters(['clientes' => 'cliente']);

    Route::resource('normas', NormaController::class);
    Route::resource('clausulas', ClausulaController::class);
    Route::resource('processos', ProcessoController::class);
    Route::resource('riscos_oportunidades', RiscoOportunidadeController::class);
    Route::resource('monitoramentos', MonitoramentoController::class);
    Route::get('acoes_corretivas/geral', [AcaoCorretivaController::class, 'indexGeral'])
        ->name('acoes_corretivas.geral');

    Route::resource('analises_causa', AnaliseCausaController::class)
        ->parameters(['analises_causa' => 'analiseCausa']);

    // Endpoints de sincronização (inline editing)
    Route::prefix('analises_causa/{analiseCausa}')
        ->name('analises_causa.')
        ->group(function () {
            Route::put('cinco-porques', [AnaliseCausaController::class, 'syncRespostas'])
                ->name('sync.respostas');

            Route::put('ishikawa', [AnaliseCausaController::class, 'syncIshikawa'])
                ->name('sync.ishikawa');
        });

    // Não Conformidades
    Route::get(
        'nao_conformidades/{naoConformidade}/relatorio.pdf',
        [RelatorioNaoConformidadeController::class, 'pdf']
    )->name('nao_conformidades.relatorio.pdf');

    Route::resource(
        'nao_conformidades',
        NaoConformidadeController::class
    )->parameters([
        'nao_conformidades' => 'naoConformidade',
    ]);

    // Ações Corretivas
    Route::resource(
        'acoes_corretivas',
        AcaoCorretivaController::class
    )->parameters([
        'acoes_corretivas' => 'acaoCorretiva',
    ]);

    Route::resource('auditorias_itens', AuditoriaItemController::class)->parameters(['auditorias_itens' => 'auditoriaItem']);
    Route::resource('auditorias', AuditoriaController::class);
    Route::resource('indicadores', IndicadorController::class)->parameters(['indicadores' => 'indicador']);
    Route::resource('reunioes_gestao', ReuniaoGestaoControlle::class)->parameters(['reunioes_gestao' => 'reunioesGestao']);
    Route::resource('documentos', DocumentoController::class);
    Route::resource('treinamentos', TreinamentoController::class);
    Route::resource('treinamentos_usuarios', TreinamentoUsuarioController::class)->parameters(['treinamentos_usuarios' => 'treinamentosUsuario']);
    Route::resource('registros_legais', RegistroLegalController::class)->parameters(['registros_legais' => 'registro']);
    Route::resource('aspectos_ambientais', AspectoAmbientalController::class)->parameters(['aspectos_ambientais' => 'aspecto']);
    Route::resource('perigos_riscos', PerigoRiscoController::class);
    Route::resource('incidentes_acidentes', IncidenteAcidenteController::class);
    Route::resource('epis', EpiController::class);
    Route::resource('epis_usuarios', EpiUsuarioController::class);
    Route::resource('ativos_informacao', AtivoInformacaoController::class);
    Route::resource('controles_seguranca', ControleSegurancaController::class);
    Route::resource('incidentes_seguranca', IncidenteSegurancaController::class);
    Route::resource('esg_indicadores', EsgIndicadorController::class)->parameters(['esg_indicadores' => 'esg_indicador']);
    Route::resource('esg_monitoramentos', EsgMonitoramentoController::class)->parameters(['esg_monitoramentos' => 'esg_monitoramento']);
    Route::resource('stakeholders', StakeholderController::class);
    Route::resource('materialidade', MaterialidadeController::class);
    Route::resource('vinculos_normativos', VinculoNormativoController::class);
    Route::resource('planos_acao', PlanoAcaoController::class);

    Route::resource('licencas_ambientais', LicencaAmbientalController::class)
        ->parameters(['licencas_ambientais' => 'licenca']);
    Route::post('licencas_ambientais/{licencaAmbiental}/upload', [LicencaAmbientalController::class, 'uploadArquivo'])->name('licencas_ambientais.upload');
    Route::get('licencas_ambientais/{licencaAmbiental}/download', [LicencaAmbientalController::class, 'downloadArquivo'])->name('licencas_ambientais.download');
    
    Route::resource('gestao_residuos', GestaoResiduoController::class);
    Route::resource('objetivos_ambientais', ObjetivoAmbientalController::class);


    Route::prefix('produtos_quimicos')->name('produtos_quimicos.')->group(function () {
        Route::get('{produtoQuimico}/fispq/download', [ProdutoQuimicoController::class, 'downloadFispq'])
            ->name('fispq.download');

        // Rota que faltava para o upload:
        Route::post('{produtoQuimico}/fispq/upload', [ProdutoQuimicoController::class, 'uploadFispq'])
            ->name('fispq.upload');
    });

    Route::resource('produtos_quimicos', ProdutoQuimicoController::class)
    ->parameters(['produtos_quimicos' => 'produtoQuimico']);

    Route::resource('nao_conformidades_ambientais', NaoConformidadeAmbientalController::class);
    Route::resource('indicadores_ambientais', IndicadorAmbientalController::class)
        ->parameters(['indicadores_ambientais' => 'indicadorAmbiental']);

    Route::resource('exames_medicos', ExameMedicoController::class);
    Route::resource('mudancas_gestao', MudancaGestaoController::class)
        ->parameters(['mudancas_gestao' => 'mudancaGestao']);
    Route::resource('avaliacoes_fornecedores', AvaliacaoFornecedorController::class)
        ->parameters(['avaliacoes_fornecedores' => 'avaliacaoFornecedor']);


    Route::resource('analises_risco_ti', AnaliseRiscoTiController::class);
    Route::resource('cipa_reunioes', CipaReuniaoController::class);
        
    //Pesquisas
    Route::resource('pesquisas_satisfacao', PesquisaSatisfacaoController::class)
        ->parameters(['pesquisas_satisfacao' => 'pesquisaSatisfacao',]);
    Route::post('pesquisas_satisfacao/{pesquisaSatisfacao}/respostas',
        [PesquisaSatisfacaoController::class, 'storeResposta']
    )->name('pesquisas_satisfacao.respostas.store');
    
    //Rota de exportação para CSV
    Route::get('respostas_pesquisa/export', [PesquisaSatisfacaoRespostaController::class, 'export'])
        ->name('respostas_pesquisa.export');

    Route::resource('pesquisas_satisfacao_respostas', PesquisaSatisfacaoRespostaController::class)
        ->except(['show']);

    // Equipamentos de Medição
    Route::resource('equipamentos_medicao', EquipamentoMedicaoController::class);

    Route::resource('calibracoes', CalibracaoController::class)
        ->parameters(['calibracoes' => 'calibracao']);;

    // Histórico de Alterações (somente leitura)
    Route::resource('historico_alteracoes', HistoricoAlteracaoController::class)
        ->parameters(['historico_alteracoes' => 'historico_alteracao'])
        ->only(['index', 'show']);

    // Dashboards específicos
    Route::prefix('dashboard')->group(function () {
        Route::view('/cadastros', 'cadastros.dashboard')->name('cadastros.dashboard');
        Route::view('/iso9001', 'iso9001.dashboard')->name('iso9001.dashboard');
        Route::view('/iso14001', 'iso14001.dashboard')->name('iso14001.dashboard');
        Route::view('/iso45001', 'iso45001.dashboard')->name('iso45001.dashboard');
        Route::view('/iso27001', 'iso27001.dashboard')->name('iso27001.dashboard');
        Route::view('/esg', 'esg.dashboard')->name('esg.dashboard');
        Route::view('/administracao', 'administracao.dashboard')->name('administracao.dashboard');
    });

    // Rotas de roles (somente admin)
    Route::prefix('cadastro')->middleware('role:admin')->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/roles/{id}', [RoleController::class, 'update'])->name('roles.update');
    });

});

require __DIR__.'/auth.php';