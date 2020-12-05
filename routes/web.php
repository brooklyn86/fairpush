<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('teste-valida-numero', 'AppController@testeValidaNumero');
Route::get('busca-valida-numero', 'AppController@buscaValidaNumero');

Route::get('redirect-api', 'AppController@viewRedirectApi');

Route::get('webhook-valida-numero', 'AppController@webhookValidaNumero');
Route::post('webhook-valida-numero', 'AppController@webhookValidaNumero');


Route::prefix('app')->group(function(){
    Route::get('login', 'AppController@viewLogin')->name('app.login');
    Route::post('login', 'AppController@postLogin')->name('app.postlogin');
    Route::post('login-temp', 'AppController@postLoginTemp')->name('app.postlogin2');

    Route::get('cron/verifica-resultados-telefone', 'AppController@verificaResultadosTelefone');
    Route::get('dispara-ligacao', 'AppController@disparaLigacaoJive');

    Route::get('dashboard', 'AppController@viewDashboard')->name('app.dashboard');

    /*Funções Agenda */
    Route::post('agenda/cadastrar-novo-processo', 'AppController@agendaCadastrarNovoProcesso');
    Route::get('agenda/recupera-processos/{status_id}', 'AppController@recuperaProcessosByStatus');

    Route::get('agenda/recupera-documentos/{idprocesso}', 'AppController@recuperaDocumentosByProcessoId');
    Route::get('agenda/recupera-telefones/{idprocesso}', 'AppController@recuperaTelefonesByProcessoId');
    Route::get('agenda/recupera-emails/{idprocesso}', 'AppController@recuperaEmailsByProcessoId');
    Route::get('agenda/recupera-comentarios/{idprocesso}', 'AppController@recuperaComentariosByProcessoId');
    Route::get('agenda/recupera-dados-processo/{idprocesso}', 'AppController@recuperaProcessoById');
    Route::get('agenda/recupera-dados-e-comentarios/{idprocesso}', 'AppController@recuperaDadoseComentariosByProcessoId');

    Route::post('agenda/enviar-chat', 'AppController@postEnviarChat');
    Route::get('agenda/capturaCpf/contatos', 'AppController@postAtualizaCPF');
    Route::post('agenda/salvar-telefone', 'AppController@postSalvarTelefone');
    Route::get('agenda/salvar-telefone', 'AppController@postSalvarTelefone');
    Route::post('agenda/salvar-email', 'AppController@postSalvarEmail');
    Route::get('agenda/excluir-telefone/{id}', 'AppController@excluirTelefone');
    Route::get('agenda/excluir-email/{id}', 'AppController@excluirEmail');
    Route::post('agenda/atualizar-calculos', 'AppController@postAtualizarCalculos');
    Route::post('agenda/enviar-documento', 'AppController@postEnviarDocumento');
    Route::get('agenda/excluir-documento/{id}', 'AppController@excluirDocumento');
    Route::get('agenda/download-arquivo/{id}', 'AppController@downloadArquivo');
    Route::post('agenda/atualizar-dados-processo', 'AppController@atualizarDadosProcesso');
    Route::get('agenda/mudar-box-agenda', 'AppController@mudarBoxAgenda');
    Route::get('agenda/excluir-processo/{id}', 'AppController@excluirProcesso');


    Route::post('agenda/adicionar-lembrete', 'AppController@addLembreteProcesso');
    Route::get('agenda/recupera-lembretes', 'AppController@recuperaLembretes');
    Route::get('agenda/excluir-item/{id}', 'AppController@excluirLembreteItem');

    /* Rotas Ajax pra gerar contratos */
    Route::post('ajax/cadastrar-cedente', 'AppController@postCadastrarCedente');
    Route::get('ajax/excluir-cedente/{id}', 'AppController@excluirCedente');
    Route::get('gerar-pdf-contrato', 'AppController@gerarPdfContrato');

    Route::get('meus-dados', 'AppController@viewMeusDados');
    Route::post('meus-dados', 'AppController@postMeusDados');
    Route::get('logout', 'AppController@logout');

    //Tipos de Agenda
    Route::get('agendas/trasferir-processos', 'AppController@viewTransferirProcessos')->name('app.agendas.transferirProcessos');
    Route::get('agendas/recuperar-subtipo-ajax/{id}', 'AppController@recuperaSubTipoAjax')->name('app.agendas.recuperarSubtipoAjax');

    Route::get('sms/get-sms/{id}', 'AppController@getSms')->name('app.sms.getsms');
    Route::get('sms/recupera-telefones-agenda/{idprocesso}', 'AppController@recuperaTelefonesAgenda');
    Route::post('sms/dispara-sms', 'AppController@disparaSms');


});
Route::middleware(['checkAdmin'])->prefix('app')->group(function(){
    Route::get('seleciona-tipo-agenda', 'AppController@selecionaTipoAgenda');

    //Setores
    Route::get('setores/index', 'AppController@viewSetoresIndex')->name('app.setores.index');
    Route::get('setores/editar/{id}', 'AppController@viewEditarSetor')->name('app.setores.editar');
    Route::post('setores/editar/{id}', 'AppController@postEditarSetor')->name('app.setores.posteditar');
    Route::get('setores/cadastrar', 'AppController@viewCadastrarSetor')->name('app.setores.cadastrar');
    Route::post('setores/cadastrar', 'AppController@postCadastrarSetor')->name('app.setores.postcadastrar');
    Route::get('setores/excluir/{id}', 'AppController@excluirSetor')->name('app.setores.excluir');

    //Usuários
    Route::get('usuarios/index', 'AppController@viewUsuarios')->name('app.usuarios.index');
    Route::get('usuarios/cadastrar', 'AppController@viewCadastrarUsuario')->name('app.usuarios.viewCadastrar');
    Route::post('usuarios/cadastrar', 'AppController@postCadastrarUsuario')->name('app.usuarios.postCadastrar');
    Route::get('usuarios/editar/{id}', 'AppController@viewEditarUsuario')->name('app.usuarios.viewEditar');
    Route::post('usuarios/editar/{id}', 'AppController@postEditarUsuario')->name('app.usuarios.postEditar');

    //Tipos de Agenda
    Route::get('agendas/index', 'AppController@viewAgendasIndex')->name('app.agendas.index');
    Route::get('agendas/cadastrar', 'AppController@viewCadastrarAgenda')->name('app.agendas.viewcadastrar');
    Route::post('agendas/cadastrar', 'AppController@postCadastrarAgenda')->name('app.agendas.postcadastrar');
    Route::get('agendas/editar/{id}', 'AppController@viewEditarAgenda')->name('app.agendas.vieweditar');
    Route::post('agendas/editar/{id}', 'AppController@postEditarAgenda')->name('app.agendas.posteditar');
    Route::get('app/agendas/excluir/{id}', 'AppController@excluirAgenda')->name('app.agendas.excluir');

    Route::get('sms/index', 'AppController@viewSmsIndex')->name('app.sms.index');
    Route::get('sms/cadastrar', 'AppController@viewCadastrarSms')->name('app.sms.viewcadastrar');
    Route::post('sms/cadastrar', 'AppController@postCadastrarSms')->name('app.sms.postcadastrar');
    Route::get('sms/editar/{id}', 'AppController@viewEditarSms')->name('app.sms.vieweditar');
    Route::post('sms/editar/{id}', 'AppController@postEditarSms')->name('app.sms.posteditar');
    Route::get('sms/excluir/{id}', 'AppController@excluirSms')->name('app.sms.excluir');

    # Rotas para o novo robo
    Route::get('robo/extrair-cadernos', 'NovoRoboController@viewExtrairCadernos');
    Route::post('robo/extrair-cadernos', 'NovoRoboController@postExtrairCadernos');
    Route::get('robo/iniciar-leitura/{id}', 'NovoRoboController@iniciarLeituraCaderno');
    Route::get('robo/iniciar-crawler/{id}', 'NovoRoboController@iniciaCrawler');
    Route::get('robo/excluir-processo/{id}', 'NovoRoboController@excluirProcesso');
    Route::get('robo/get-processos', 'NovoRoboController@getProcessosForPython');
    Route::get('robo/processo/update/{id}/{code}/{url}', 'NovoRoboController@updateProcess')->name('get.process');
    Route::get('robo/visualizar-processos/{id}', 'NovoRoboController@viewCrawlerCaderno');
    Route::get('robo/enviar-agenda/{id}', 'NovoRoboController@viewEnviarAgenda');

    Route::post('robo/envia-agenda', 'NovoRoboController@postEnviarAgenda');
    Route::post('robo/salvar-alteracoes', 'NovoRoboController@postSalvarAlteracoes');

    Route::get('robo/previa-agenda/{id}', 'NovoRoboController@viewPreviaAgenda');
    Route::post('robo/previa-agenda/{id}', 'NovoRoboController@postPreviaAgenda');
});
