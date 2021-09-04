<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="">
	<meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FairConsultoria</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/select2.min.css">
	<link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

    <link rel="stylesheet" href="/assets/css/style.css">

    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700&display=swap" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->

    <style type="text/css">
        .kanban-list > .kanban-wrap{
            padding: 0px;
        }

        .task-priority{
            font-size: 13px !important;
        }

        .kanban-footer{
            margin-top: 0px !important;
        }

        .botaoAcoes{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin-top: 10px;
        }

        .botaoAcoes i{
            font-size: 20px;
        }

        @media (min-width: 576px){
            .modal-dialog {
                max-width: 750px !important;
                margin: 1.75rem auto;
            }
        }

        .page-wrapper{
            margin-left: 0px !important;
        }

        .header {
            background: #3f4245 !important;
        }

        .user-menu.nav > li > a > i{
            font-size: 26px !important;
        }

        .kanban-list{
            margin-right: 0px;
            min-width: unset;
            width: 12.5%;
        }
        .kanban-list > .kanban-header > .status-title{
            font-weight: 600;
            font-size: 16px;
            font-family: 'Source Sans Pro', sans-serif;
        }

        .kanban-list > .kanban-header > .status-subtitle{
            font-family: 'Source Sans Pro', sans-serif;
            color: #FFF;
            font-weight: 300;
            font-size: 14px;
        }
        .kanban-list > .kanban-header{
            flex-direction: column;
            align-items: flex-start;
            padding: 5px 10px;
        }

        .kanban-list > .kanban-header > p{
            margin-bottom: 0px;
            margin-top: 0px;
        }

        .kanban-list > .kanban-wrap{
            padding-top: 10px;
        }

        .kanban-box .task-board-header{
            flex-direction: column;
            padding: 5px 10px 5px 10px;
        }
        .task-board-header .status-title{
            font-family: 'Source Sans Pro', sans-serif;
            /*color: rgb(38, 41, 44);*/
            font-size: 15px;
            font-weight: 600;
            line-height: 90%;
        }
        .task-board-header .status-subtitle{
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 13px;
            font-weight: normal;
            margin-top: 5px;
            /*color: rgb(116, 118, 120);*/
        }
        .kanban-list > .kanban-header > .status-title{
            color: #2e2e2e !important;
        }
        .kanban-list > .kanban-header > .status-subtitle{
            color: #2e2e2e !important;
        }

        .karban-branco > .kanban-header{
            border-bottom: 1px solid #2e2e2e;
            border-top: 1px solid #2e2e2e;
            background-color: #ededed;
            border-right: 1px solid #2e2e2e;
        }
        a {
            color: #343a40;
        }
        .autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; position:fixed !important; z-index: 100000 !important;}
        .autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
        .autocomplete-selected { background: #F0F0F0; }
        .autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
        .autocomplete-group { padding: 2px 5px; }
        .autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
        .ui-autocomplete{
            z-index: -1 !important;
            position:absolute;
        }
        .swal2-container{
            z-index: 9999999999 !important;
        }
            </style>
</head>
<body>
    @include('app.include')
	<!-- Main Wrapper -->
    <div class="main-wrapper">

		@yield('header')

		<!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid" id="containerBody" hidden>

				<!-- Page Header -->
				<!-- <div class="page-header">
					<div class="row">
						<div class="col-sm-12">
							<h3 class="page-title">Agenda</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="/app/dashboard">Dashboard</a></li>
								<li class="breadcrumb-item active">Agenda</li>
							</ul>
						</div>
					</div>
				</div> -->
				<!-- /Page Header -->

				<!-- Content Starts -->
                <div class="row board-view-header" style="margin-bottom: 10px !important; position:fixed !important; top:60px; z-index: 10;  background:#fff !important; width:100%; padding:10px">
                <!-- <div class="row board-view-header" style="margin-bottom: 10px !important;!important; top:60px; z-index: 10;  background:#fff !important; width:100%; padding:10px"> -->

					<div class="col-12 text-left" style=" position:relative !important;">
                        <div style="display: flex; flex-direction: row; justify-content: flex-start;">
                            <a href="#" style="cursor:'point';background-color: #FFFFFF; border: 1px solid #000; color: #000 !important " class="btn btn-warning btn-sm text-white float-left" data-toggle="modal" data-target="#modalNovoProcesso">
                                <i class="fa fa-plus"></i> Criar novo processo
                            </a>

                            <a style="background-color: #FFFFFF; border: 1px solid #000; color: #000 !important" href="#" class="btn btn-dark btn-sm text-white float-left ml-4" id="abre_filtros_agenda" data-toggle="modal" data-target="#modalFiltroTipoAgenda">
                                <i class="la la-filter"></i> Alterar tipo de agenda
                            </a>

                            <a style="background-color: #FFFFFF; border: 1px solid #000; color: #000 !important" href="#" class="btn btn-dark btn-sm text-white float-left ml-4" id="toggleFiltrosTexto">
                                <i class="la la-filter"></i> Filtrar por dados do processo
                            </a>

                            <a style="background-color: #FFFFFF; border: 1px solid #000; color: #000 !important" href="#" class="btn btn-dark btn-sm text-white float-left ml-4" id="toggleEnvioLote">
                                <i class="la la-filter"></i> Envio processos em lote
                            </a>
                            <label for="filtroAbandono"  style="background-color: #FFFFFF; border: 1px solid #000; color: #000 !important" href="#" class="btn btn-light btn-sm text-white float-left ml-4" id="labelfiltroAbandono">
                                <i class="la la-filter"> </i>Filtro de Abandono
                                <input id="filtroAbandono" names="filtroAbandono" hidden type="checkbox" autocomplete="off"></input>
                            </label>
                            <a style="background-color: #FFFFFF; border: 1px solid #000; color: #000 !important" href="#" class="btn btn-dark btn-sm text-white float-left ml-4" id="agendaAtual">
                                <i class="la la-filter"> </i><span id="textoAgendaAtual">Todos</span>
                            </a>
                        </div>


                    </div>
                </div>
                <!-- <div class="row filter-row" id="rowFiltros" style="top:98px; z-index: 10; margin-top: 20px; display: none; background-color:#fff !important;width:100%"> -->
                <div class="row filter-row" id="rowFiltros" style="position:fixed !important; top:90px; z-index: 10; margin-top: 20px; display: none; background-color:#fff !important;width:100%">
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input class="form-control floating" type="text" name="filtroNome">
                        <label class="focus-label">Nome</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input class="form-control floating" type="text" name="filtroNumeroProcesso">
                        <label class="focus-label">Número do Processo</label>
                    </div>
                </div>
                @can('isAdmin')
                <div class="col-sm-6 col-md-2">
                    <div class="form-group form-focus focused">
                        <select name="filtroIdFuncionario" id="filtroIdFuncionario" class="form-control floating">
                            <option value=""></option>
                            <?php
                                $sqlUsers = DB::table('users')->get();

                                if(count($sqlUsers) > 0){
                                    foreach($sqlUsers as $dados){
                                        echo '<option value="'.$dados->id.'" data-backgroundColor="'.$dados->backgroundColor.'" data-textColor="'.$dados->textColor.'">'.$dados->name.'</option>';
                                    }
                                }
                            ?>
                        </select>

                        <label class="focus-label">Funcionário</label>
                    </div>
                </div>
                    @endcan
                <div class="col-sm-2 col-md-1">
                    <div class="form-group form-focus focused">
                        <select name="filtroTypeValorPrecatorio" id="filtroTypeValorPrecatorio" class="form-control floating">
                            <option value=""></option>
                            <option value="0">Acima</option>
                            <option value="1">Até</option>
                        </select>
                        <label class="focus-label">Acima</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus focused">
                        <select name="filtroValorPrecatorio" id="filtroValorPrecatorio" class="form-control floating">
                            <option value=""></option>
                            <option value="50000.00">R$ 50.000,00</option>
                            <option value="100000.00">R$ 100.000,00</option>
                            <option value="200000.00"> R$ 200.000,00</option>
                            <option value="300000.00"> R$ 300.000,00</option>
                            <option value="400000.00"> R$ 400.000,00</option>
                            <option value="500000.00"> R$ 500.000,00</option>
                            <option value="750000.00"> R$ 700.000,00</option>
                            <option value="1000000.00"> R$ 1.000.000,00</option>
                            <option value="1250000.00"> R$ 1.250.000,00</option>
                            <option value="1500000.00"> R$ 1.500.000,00</option>
                            <option value="1750000.00"> R$ 1.750.000,00</option>
                            <option value="2000000.00"> R$ 2.000.000,00</option>
                        </select>
                        <label class="focus-label">Selecione o valor do precatório</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input class="form-control floating" type="text" name="filtroDataProcesso" id="filtroDataProcesso">
                        <label class="focus-label">Ordem Cronológica</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input class="form-control floating" type="text" name="filtroDataTelefone" id="filtroDataTelefone">
                        <label class="focus-label">Telefone</label>
                        <div class="autocomplete-suggestions" hidden id="telefoneSuggestions">
                            <div class="autocomplete-suggestion" hidden id="telefoneSuggestionsLoad">Pesquisando...</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input class="form-control floating" type="text" name="filtroDataCPF" id="filtroDataCPF">
                        <label class="focus-label">CPF</label>
                        <div class="autocomplete-suggestions" hidden id="telefoneSuggestions">
                            <div class="autocomplete-suggestion" hidden id="telefoneSuggestionsLoad">Pesquisando...</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input class="form-control floating" type="text" name="filtroDataBaseProcesso" id="filtroDataBaseProcesso">
                        <label class="focus-label">Data Base</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group form-focus">
                        <input class="form-control floating" type="text" name="filtroIDProcesso" id="filtroIDProcesso">
                        <label class="focus-label">ID</label>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <a href="#" class="btn btn btn-dark btn-block" id="btnFiltrar"><i class="la la-search"></i> Procurar </a>
                </div>
                </div>

                <div class="row filter-row" id="rowEnvioLote" style="position:fixed !important; top:98px; z-index: 10; margin-top: 20px; display: none; background-color:#fff !important;width:100%"">
                <!-- <div class="row filter-row" id="rowEnvioLote" style="top:98px; z-index: 10; margin-top: 20px; display: none; background-color:#fff !important;width:100%""> -->



                </div>
							<div class="kanban-cont" id="kabanhidden" style="margin-top:40px;" hidden>
								<div class="kanban-list karban-branco">
									<div class="kanban-header" style="border-left: 1px solid #2e2e2e;">
										<p class="status-title">Novo</p>
                                        <p class="status-subtitle ss0">(12) R$ 350.000,00</p>
									</div>
									<div class="kanban-wrap" id="box0">

									</div>

								</div>
								<div class="kanban-list karban-branco">
									<div class="kanban-header">
										<p class="status-title">Tentando Contato</p>
										<p class="status-subtitle ss1">12 processos</p>
									</div>
									<div class="kanban-wrap" id="box1">

									</div>
								</div>
								<div class="kanban-list karban-branco">
									<div class="kanban-header">
                                        <p class="status-title">Sem Interesse</p>
										<p class="status-subtitle ss2">12 processos</p>
									</div>
									<div class="kanban-wrap ks-empty" id="box2">
									</div>

								</div>
								<div class="kanban-list karban-branco">
									<div class="kanban-header">
                                        <p class="status-title">Proposta Enviada</p>
										<p class="status-subtitle ss3">12 processos</p>
									</div>
									<div class="kanban-wrap" id="box3">

									</div>

								</div>

								<div class="kanban-list karban-branco">
									<div class="kanban-header">
                                        <p class="status-title">Cliente Avaliando</p>
										<p class="status-subtitle ss5">12 processos</p>
									</div>
									<div class="kanban-wrap" id="box5">

									</div>

								</div>
                                <div class="kanban-list karban-branco">
									<div class="kanban-header">
                                        <p class="status-title">Parecer</p>
										<p class="status-subtitle ss6">12 processos</p>
									</div>
									<div class="kanban-wrap" id="box6">

									</div>
								</div>
								<div class="kanban-list karban-branco">
									<div class="kanban-header">
                                        <p class="status-title">Cessão Agendada</p>
										<p class="status-subtitle ss7">12 processos</p>
									</div>
									<div class="kanban-wrap ks-empty" id="box7">
									</div>

								</div>

								<div class="kanban-list karban-branco">
									<div class="kanban-header">
                                        <p class="status-title">Pagamento</p>
										<p class="status-subtitle ss8">12 processos</p>
									</div>
									<div class="kanban-wrap" id="box8">

									</div>

								</div>

							</div>
                            <div class="d-flex justify-content-center" >
                                    <div class="spinner-border" role="status"  id="loadingPagination" hidden>
                                        <span class="sr-only">Loading...</span>
                                    </div>
                            </div>

				<!-- /Content End -->
            </div>
        </div>

        <div id="mySidepanel" class="sidepanel message-view chat-profile-view chat-sidebar">
            <a href="#" class="closebtn" id="closeSidepanel"><i class="la la-times"></i></a>

            <div class="chat-window video-window">
				<div class="fixed-header">
					<ul class="nav nav-tabs nav-tabs-bottom">
						<li class="nav-item"><a class="nav-link active" href="#tab1" data-toggle="tab">SMS</a></li>
						<li class="nav-item"><a class="nav-link" href="#tab2" data-toggle="tab">Ligação</a></li>
					</ul>
				</div>
				<div class="tab-content chat-contents">
					<div class="content-full tab-pane show active" id="tab1">
                        <div style="padding-left: 16px; padding-right: 16px; padding-top: 32px; padding-bottom: 32px;">
                            <?php
                                $sqlSms = DB::table('mensagem_sms')->where('status', 1)->orderBy('titulo', 'asc')->get();
                                $arraySms = [];

                                if(count($sqlSms) > 0){ foreach($sqlSms as $dadosSms){ $arraySms[$dadosSms->id] = $dadosSms->titulo; } }
                            ?>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Mensagem a ser enviada</label>
                                    {{ Form::select('sms_idMensagem',$arraySms, null, ['class' => 'form-control','id' => 'sms_idMensagem', 'placeholder' => 'Selecione uma mensagem para enviar']) }}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label>Preview</label>
                                    {{ Form::textarea('sms_previewMensagem', null, ['class' => 'form-control', 'id' => 'previewMensagem']) }}
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="isFlashSms" name="isFlashSms" value="1">&nbsp; Enviar SMS Flash?</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 mt-3" id="sms_listaTelefones">

                            </div>

                            <input type="hidden" name="sms_idprocesso">

                            <div class="mb-3 mt-3"><button type="button" id="enviarSms" class="btn btn btn-dark">Enviar SMS</button></div>
                        </div>
                    </div>
                    <div class="content-full tab-pane" id="tab2">
                        <p>Ligações</p>
                    </div>
                </div>
        </div>
        <div id="mySidepanelFilter" class="sidepanel message-view chat-profile-view chat-sidebar">
            <a href="#" class="closebtn" id="toggleEnvioLoteClose"><i class="la la-times"></i></a>
            <div class="chat-window video-window">
				<div class="fixed-header">
					<ul class="nav nav-tabs nav-tabs-bottom">
						<li class="nav-item"><a class="nav-link active" data-toggle="tab">Envio de Processo em Lote</a></li>
					</ul>
				</div>
                <div style="margin-top:10px">
                <div class="col-sm-12">
                        <div class="form-group">
                            <input class="form-control" type="text" placeholder="Nome do Processo" name="reqteName"  id="reqteName">
                            <!-- <label class="focus-label">Nome do Processo</label> -->
                            <div class="autocomplete-suggestions" hidden id="reqteSuggestions">
                                <div class="autocomplete-suggestion" hidden id="reqteSuggestionsLoad">Pesquisando...</div>
                            </div>
                        </div>
                    </div>

                    <div class="fixed-header">
					<ul class="nav nav-tabs nav-tabs-bottom">
						<li class="nav-item"><a class="nav-link active" data-toggle="tab">Enviar para...</a></li>
					</ul>
				</div>
                <div style="margin-top:10px">
                    <div class="col-sm-12">
                        <div class="form-group ">
                            <input class="form-control floating" type="text" placeholder="Nome do Funcionario" name="nomeFuncionario" id="nomeFuncionario">
                            <!-- <label class="focus-label"></label> -->
                            <div class="autocomplete-suggestions" hidden id="nomeFuncionarioSuggestions">
                                <div class="autocomplete-suggestion" hidden id="nomeFuncionarioSuggestionsLoad">Pesquisando...</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 ">
                        <div class="form-group">
                            <select name="filtroTipoProcessoLote" id="filtroTipoProcessoLote" class="form-control">
                                <option value="">Selecione a Agenda</option>
                                <?php
                                    foreach($arrayTiposAgenda as $key => $value){
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                                <select name="filtroSubtipoProcessoLote" id="filtroSubtipoProcessoLote" class="form-control">
                                    <option value="">Selecione a subtipo</option>
                                </select>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                        <select name="situacaoLote" id="situacaoLote" class="form-control custom-select">
                            <option value="">Selecione a Situação</option>
                            <option value="1">Novo</option>
                            <option value="2">Tentando Contato</option>
                            <option value="3">Sem interesse</option>
                            <option value="4">Proposta Enviada</option>
                            <option value="6">Cliente Avaliando</option>
                            <option value="7">Cessão Agendada</option>
                            <option value="8">Pagamento Realizado</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 ">
                    <a href="#" class="btn btn-dark" id="btnEnviarLote"><i class="la la-send"></i> Enviar</a>
                </div>
                <div class="col-sm-12" style="margin:10px; max-height:400px; min-height:400px">
                    <table class="table table-resposive">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="loteTable" style="overflow:scroll;  max-height:350px">
                        </tbody>
                    </table>
                </div>

            </div>
        <style type="text/css">
            #divExcluirProcesso{
                position: absolute;
                bottom: 0;
                width: 100%;
                border: 3px dashed #ef5350;
                color: #ef5350;
                height: 100px;
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
                align-self: center;
                font-size: 20px;
                transition: opacity .25s ease-in-out;
                -moz-transition: opacity .25s ease-in-out;
                -webkit-transition: opacity .25s ease-in-out;
            }
            .background{

            }
            .sidepanel {
                height: 100%;
                width: 0;
                position: fixed;
                z-index: 99999;
                top: 0;
                right: 0;
                background-color: #FFFFFF;
                padding-top: 60px;
                transition: 0.5s;
                overflow:scroll;
            }
            .message-view{
                z-index: 100000 !important;

            }
            .sidepanel .closebtn {
                position: absolute;
                top: 10px;
                right: 25px;
                font-size: 36px;
                margin-left: 50px;
            }
            .nav-tabs.nav-tabs-solid > li > a.active, .nav-tabs.nav-tabs-solid > li > a.active:hover, .nav-tabs.nav-tabs-solid > li > a.active:focus {
                background-color:#343a40;
                border-color:#343a40;
            }
        </style>


            <div class="kanban-wrap" id="divExcluirProcesso">
                <i class="la la-trash"></i> Excluir
            </div>



        <div class="notification-popup hide">
            <p>
                <span class="task"></span>
                <span class="notification-text"></span>
			</p>
		</div>

    </div>
	<!-- /Main Wrapper -->
<style type="text/css">
@media (min-width: 768px) and (max-width: 991.98px) {
    .modal-fair{
        width: 90% !important; max-width: 90% !important;
    }
}
@media (min-width: 992px) and (max-width: 1199.98px) {
    .modal-fair{
        width: 75% !important; max-width: 75% !important;
    }
}

@media (min-width: 1200px) {
    .modal-fair{
        width: 70% !important; max-width: 70% !important;
    }
}
</style>
<!-- Modal Editar Processo -->
<div id="modalEditarProcesso" class="modal custom-modal fade" role="dialog" style="z-index: -1">
    <div class="modal-dialog modal-fair" >
        <div class="modal-content" style="width:85%">
            <div class="modal-header">
                <h4 class="modal-title">Visualizar Processo</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">

                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
                    <li class="nav-item"><a class="nav-link active" href="#tabDadosProcesso" data-toggle="tab">Dados do Processo</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabCalculadora" data-toggle="tab">Calculadora</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabAgendamentoContato" data-toggle="tab">Agendar Contato</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabDocumentos" data-toggle="tab">Documentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabContratos" data-toggle="tab">Gerar Contratos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabCedentes" data-toggle="tab">Cedentes</a></li>
					<li class="nav-item"><a class="nav-link" href="#tabCarta" data-toggle="tab">Carta</a></li>
					<li class="nav-item"><a class="nav-link" href="#tabTrocarAgenda" data-toggle="tab">Trocar de Agenda</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="tabDadosProcesso">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="card flex-fill">
									<div class="card-header">
										<h5 class="card-title mb-0">Dados do Processo</h5>
									</div>
									<div class="card-body">
                                        <input type="hidden" name="mepIdProcesso" id="mepIdProcesso">
                                        <div class="row">
                                            <div class="col-sm-12">
                        						<div class="form-group">
                        							<label>Cabeça de Ação</label>
                        							<input class="form-control" type="text" name="mepCabecaAcao" id="mepCabecaAcao">
                        						</div>
                        					</div>
                                        </div>

										<div class="row">
                                            <div class="col-sm-12">
											     <div class="form-group">
                        							<label>Nome do Cliente</label>
                        							<input class="form-control" type="text" name="mepRequerente" id="mepRequerente">
                        						</div>
                        					</div>
                                        </div>
										<div class="row">
										       <div class="col-sm-12">
                        						<div class="form-group">
                        							<label>Número do Processo</label>
                        							<input class="form-control" type="text" name="mepNumeroProcesso" id="mepNumeroProcesso">
                                                    <a href="" id="mepexternallink" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i></a>
                        						</div>
                        					</div>
										</div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                @if(auth()->user()->role_id != 1)
                                                    <div class="form-group">
                                                        <label>Entidade Devedora</label>
                                                        <input class="form-control" type="text" name="mepEntDevedora" id="mepEntDevedora" disabled>
                                                    </div>
                                                @else 
                                                    <div class="form-group">
                                                        <label>Entidade Devedora</label>
                                                        <input class="form-control" type="text" name="mepEntDevedora" id="mepEntDevedora">
                                                    </div>
                                                @endif
                        					</div>
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>CPF</label>
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" placeholder="CPF" aria-label="Username" aria-describedby="basic-addon1"  name="mepCpf" id="mepCpf">
                                                        <div class="input-group-prepend" id="atualizaScore">
                                                            <span class="input-group-text" style="background:orange; color:white;" id="score">SC:</span>
                                                        </div>
                                                    </div>
                                                    <span class="input-group-addon" id="atualizaCPF" >Atualizar Dados</span>
                                                    <div class="spinner-border spinner-border-sm hidden" id="loadingCPF" role="status" hidden>
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                        							<!-- <input class="form-control" type="text" name="mepCpf" id="mepCpf"> -->
                                                   
                        						</div>
                        					</div>

                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Ordem Cronológica</label>
                        							<input class="form-control" type="text" name="mepOrdemCronologica" id="mepOrdemCronologica">
                        						</div>
                        					</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                        						<div class="form-group">
                        							<label>Data de Nascimento</label>
                        							<input class="form-control" type="date" name="mepDataNascimento" id="mepDataNascimento" >
                        						</div>
                        					</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>EP do Processo</label>
                        							<input class="form-control" type="text" name="mepExp" id="mepExp">
                        						</div>
                        					</div>
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Indice de Data Base</label>
                        							<div class="cal-icon">
                        								<input class="form-control datetimepicker" type="text" name="mepIndiceDataBase" id="mepIndiceDataBase">
                        							</div>
                        						</div>
                        					</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Valor Principal</label>
                        							<input class="form-control" type="text" name="mepValorPrincipal" id="mepValorPrincipal">
                        						</div>
                        					</div>
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Valor Juros</label>
                        							<input class="form-control" type="text" name="mepValorJuros" id="mepValorJuros">
                        						</div>
                        					</div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label>Colaborador Responsável</label>
                                                {{ Form::select('mepFuncionario', $arrayColaboradores, null, ['class' => 'custom-select', 'id' => 'mepFuncionario', 'readonly' => 'readonly']) }}
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label>Situação</label>
                                                {{ Form::select('mepSituacao', [
                                                    '1' => 'Novo',
                                                    '2' => 'Tentando Contato',
                                                    '3' => 'Sem interesse',
                                                    '4' => 'Proposta Enviada',
                                                    '6' => 'Cliente Avaliando',
                                                    '7' => 'Parecer',
                                                    '8' => 'Cessão Agendada',
                                                    '9' => 'Pagamento Realizado'
                                                ], null, ['class' => 'custom-select', 'id' => 'mepSituacao', 'readonly' => 'readonly']) }}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" name="btnSalvarEdicao" id="btnSalvarEdicao" class="btn btn btn-dark submit-btn" >Salvar Edição</button>
                                            </div>
                                        </div>

									</div>
								</div>
                            </div>
                            <div class="col-md-5">
                            	<div class="chat-main-row">
                            		<div class="chat-main-wrapper">
                            			<div class="col-lg-12 message-view task-view">
                            				<div class="chat-window">
                            					<div class="chat-contents">
                            						<div class="chat-content-wrap">
                            							<div class="chat-wrap-inner">
                            								<div class="chat-box">
                            									<div class="chats">
                            										<div class="chat chat-left">
                            											<div class="chat-body">
                            												<div class="chat-bubble">
                            													<div class="chat-content">
                            														<p>I'm just looking around.</p>
                            														<p>Will you tell me something about yourself? </p>
                            														<span class="chat-time">8:35 am</span>
                            													</div>
                            												</div>
                            											</div>
                            										</div>
                            									</div>
                            								</div>
                            							</div>
                            						</div>
                            					</div>
                            					<div class="chat-footer">
                            						<div class="message-bar">
                            							<div class="message-inner">
                            								<div class="message-area" style="height:200px !important;">
                            									<div class="input-group">
                            										<textarea class="form-control" placeholder="Aperte enter para enviar sua mensagem..." id="mensagemChat" style="height:150px;"></textarea>
                            										<!-- <span class="input-group-append">
                            											<button class="btn  btn-outline-dark" type="button" id="btnEnviarChat"><i class="fa fa-send"></i></button>
                            										</span> -->
                            									</div>
                            								</div>
                            							</div>
                            						</div>
                            					</div>
                            				</div>
                            			</div>
                            		</div>
                            	</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card flex-fill">
									<div class="card-header">
                                    <nav>
                                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                        <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#telefones" role="tab" aria-controls="nav-home" aria-selected="true">Telefones</a>
                                        <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#possiveisParentes" role="tab" aria-controls="possiveisParentes" aria-selected="false">Possiveis Parentes</a>
                                    </div>
                                    </nav>
										<!-- <h5 class="card-title mb-0">Telefones</h5> -->
									</div>
                                    <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="telefones" role="tabpanel" aria-labelledby="telefones-tab">
                                        <div class="card-body" >
                                            <div class="row filter-row">
                                                <div class="col-sm-10">
                                                    <input name="mepAdicionarTelefoneText" class="form-control form-control-lg">
                                                </div>
                                                <div class="col-sm-2" style="display: flex;align-items: center;">
                                                    <span style="font-size: 32px;" id="clickAddTelefone"><i class="la la-plus-circle"></i></span>
                                                </div>
                                            </div>

                                            <table class="table table-hover mb-0 mt-3">
                                                <thead>
                                                    <th>Telefone</th>
                                                    <th>Status</th>
                                                    <th>Ações</th>
                                                </thead>
                                                <tbody id="tbodyTelefones">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                        <div class="tab-pane fade" id="possiveisParentes" role="tabpanel" aria-labelledby="possiveisParentes-tab">
                                            <div class="card-body">
                                                <div class="row filter-row">
                                                    <div class="col-sm-10">
                                                        <input name="mepAdicionarTelefoneParenteText" class="form-control form-control-lg">
                                                    </div>
                                                    <div class="col-sm-2" style="display: flex;align-items: center;">
                                                        <span style="font-size: 32px;" id="clickAddTelefoneParente"><i class="la la-plus-circle"></i></span>
                                                    </div>
                                                </div>

                                                <table class="table table-hover mb-0 mt-3">
                                                    <thead>
                                                        <th>Telefone</th>
                                                        <th>Status</th>
                                                        <th>Ações</th>
                                                    </thead>
                                                    <tbody id="tbodyTelefonesParente">

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card flex-fill">
									<div class="card-header">
										<h5 class="card-title mb-0">Emails</h5>
									</div>
									<div class="card-body">
                                        <div class="row filter-row">
                                            <div class="col-sm-10">
                                                <input name="mepAdicionarEmailText" class="form-control form-control-lg">
                                            </div>
                                            <div class="col-sm-2" style="display: flex;align-items: center;">
                                                <span style="font-size: 32px;" id="clickAddEmail"><i class="la la-plus-circle"></i></span>
                                            </div>
                                        </div>

                                        <table class="table table-hover mb-0 mt-3">
                                            <thead>
                                                <th>Email</th>
                                                <th>Ações</th>
                                            </thead>
                                            <tbody id="tbodyEmails">

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabCalculadora">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card flex-fill">
									<div class="card-header">
										<h5 class="card-title mb-0">Calculos do Processo</h5>
									</div>
									<div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Indice de Data Base</label>
                        							<div class="cal-icon">
                        								<input class="form-control datetimepicker" type="text" name="mcIndiceDataBase" id="mcIndiceDataBase">
                        							</div>
                        						</div>
                        					</div>
                                            <div class="col-sm-6 text-center">
                                                <div class="stats-box mb-4">
													<p>Resultado</p>
													<h3 id="mcResultado1">385</h3>
												</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Indice de Correção Até</label>
                                                    <span id="atualizaCorrecao" style="cursor: pointer;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"/>
                                                        <path fill-rule="evenodd" d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"/>
                                                        <path fill-rule="evenodd" d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"/>
                                                    </svg>
                                                    </span>
                        							<div class="cal-icon">
                        								<input class="form-control datetimepicker" type="text" name="mcIndiceCorrecaoAte" id="mcIndiceCorrecaoAte">
                        							</div>
                        						</div>
                        					</div>
                                            <div class="col-sm-6 text-center">
                                                <div class="stats-box mb-4">
													<p>Resultado</p>
													<h3 id="mcResultado2">385</h3>
												</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                           <div class="col-sm-6">
                        						<!-- <div class="form-group">
                        							<label>Data de Emissão do Precatório</label>
                        							<div class="cal-icon"> -->
                        								<input class="form-control" type="hidden" name="mcDataEmissaoPrecatorio" id="mcDataEmissaoPrecatorio">
                        							<!-- </div>
                        						</div> -->
                                                <!-- <div class="form-group"> -->
                        							<!-- <label>Data de Vencimento</label> -->
                        							<!-- <div class="cal-icon"> -->
                        								<input class="form-control" type="hidden" name="mcDataVencimento" id="mcDataVencimento">
                        							<!-- </div> -->
                        						<!-- </div> -->
                        					</div>
                                            <div class="col-sm-6 text-center">
                                                <div class="stats-box mb-4">
													<p>Dias Fora do Periodo</p>
													<h3 id="mcResultado3"></h3>
												</div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Juros Moratórios ( em dias )</label>
                        							<input class="form-control" type="text" name="mcDias" id="mcDias" readonly>
                        						</div>
                        					</div>
                                            <div class="col-sm-6" style="display: none;">
                        						<div class="form-group">
                        							<label>Utiliza Desconto da Sumula 17 STF?</label>
                                                    <div class="checkbox">
    													<label>
    														<input type="checkbox" name="desconto17" id="desconto17" value="1"> Sim
    													</label>
    												</div>
                        						</div>
                        					</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Valor Principal</label>
                        							<input class="form-control" type="text" name="mcValorPrincipal" id="mcValorPrincipal">
                        						</div>
                        					</div>
                                            <div class="col-sm-6">
                                                <div class="card dash-widget">
                    								<div class="card-body">

                    									<div class="dash-widget-info">
                    										<h4 id="mcResultadoValorPrincipal">R$ 180.000,00</h4>
                    										<span>Resultado</span>
                    									</div>
                    								</div>
                    							</div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Valor Juros</label>
                        							<input class="form-control" type="text" name="mcValorJuros" id="mcValorJuros">
                        						</div>
                        					</div>
                                            <div class="col-sm-6">
                                                <div class="card dash-widget">
                    								<div class="card-body">

                    									<div class="dash-widget-info">
                    										<h4 id="mcResultadoValorJuros">R$ 180.000,00</h4>
                    										<span>Resultado</span>
                    									</div>
                    								</div>
                    							</div>

                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                        							<label>Juros Sobre o Principal Atualizado</label>
                        							<input class="form-control" type="text" name="mcJurosPrincipalAtualizado" id="mcJurosPrincipalAtualizado" readonly>
                        						</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                        							<label>Percentual de Assistência Médica e SPPREV</label>

                                                    {{ Form::select('mcPercentualAM', [
                                                        '0' => '0%',
                                                        '13' => '13%'
                                                    ], null, ['class' => 'custom-select', 'id' => 'mcPercentualAM']) }}
                        						</div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                        							<label>Pagamentos Parciais ou Prioridades</label>
                        							<input class="form-control" type="text" name="mcPagamentosParciais" id="mcPagamentosParciais">
                        						</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="card">
                									<div class="card-body">
                										<div class="d-flex justify-content-between mb-3">
                											<div>
                												<span class="d-block">Total Bruto</span>
                											</div>
                										</div>
                										<h3 class="mb-3" id="mcTotalBruto">R$ 800,00</h3>
                										<div class="progress mb-2" style="height: 5px;">
                											<div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                										</div>
                									</div>
                								</div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card">
                									<div class="card-body">
                										<div class="d-flex justify-content-between mb-3">
                											<div>
                												<span class="d-block">SPPREV</span>
                											</div>
                										</div>
                										<h3 class="mb-3" id="mcSpprev">R$ 800,00</h3>
                										<div class="progress mb-2" style="height: 5px;">
                											<div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                										</div>
                									</div>
                								</div>
                                            </div>
                                           <!-- <div class="col-md-3">
                                                <div class="card">
                									<div class="card-body">
                										<div class="d-flex justify-content-between mb-3">
                											<div>
                												<span class="d-block">Saldo Atualizado</span>
                											</div>
                										</div>
                										<h3 class="mb-3" id="mcSaldoAtualizado">R$ 800,00</h3>
                										<div class="progress mb-2" style="height: 5px;">
                											<div class="progress-bar bg-warning" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                										</div>
                									</div>
                								</div>
                                            </div> -->
                                            <div class="col-md-3">
                                                <div class="card">
                									<div class="card-body">
                										<div class="d-flex justify-content-between mb-3">
                											<div>
                												<span class="d-block">Honorários</span>
                											</div>
                										</div>
                										<h3 class="mb-3" id="mcHonorarios">R$ 800,00</h3>
                										<div class="progress mb-2" style="height: 5px;">
                											<div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                										</div>
                									</div>
                								</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Saldo Líquido Disponível</label>
                        							<input class="form-control" type="text" name="mcCessaoSemHonorarios" id="mcCessaoSemHonorarios">
                        						</div>
                        					</div>
                                            <div class="col-sm-6">
                                                <div class="card">
                									<div class="card-body">
                										<div class="d-flex justify-content-between mb-3">
                											<div>
                												<span class="d-block">Saldo Líquido Disponível</span>
                											</div>
                										</div>
                										<h3 class="mb-3" id="mcCessaoSemHonorariosResultado">R$ 800,00</h3>
                										<div class="progress mb-2" style="height: 5px;">
                											<div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                										</div>
                									</div>
                								</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Pagamento da Cessão</label>
                        							<input class="form-control" type="text" name="mcPagamentoCessao" id="mcPagamentoCessao">
                        						</div>
                        					</div>
                                            <div class="col-sm-6">
                                                <div class="card">
                									<div class="card-body">
                										<div class="d-flex justify-content-between mb-3">
                											<div>
                												<span class="d-block">Pagamento da Cessão</span>
                											</div>
                										</div>
                										<h3 class="mb-3" id="mcPagamentoCessaoResultado">R$ 800,00</h3>
                										<div class="progress mb-2" style="height: 5px;">
                											<div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                										</div>
                									</div>
                								</div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" name="btnAtualizarCalculos" id="btnAtualizarCalculos" class="btn btn btn-dark submit-btn">Atualizar Calculos</button>
                                                <span style="display: none;" id="loadingGif">
                                                    <img src="https://cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif">
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabAgendamentoContato">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="mac_mostra_alert"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Criar novo lembrete</h6>
                                    </div>
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputEmail1">Data de Agendamento</label>
                                                    <input type="text" id="mac_data" name="mac_data" class="form-control datetimepicker">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputEmail1">Comentário / Observação</label>
                                                    <textarea id="mac_observacao" name="mac_observacao" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" class="btn  btn-outline-dark mac_submit" id="mac_submit">Salvar Lembrete</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- <a href="#!" class="btn btn-outline-danger btn-sm"><i class="feather icon-trash-2"></i>&nbsp;Delete </a> -->
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title mb-0">Historico de Lembretes</h6>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <th>Data de Agendamento</th>
                                                <th>Comentário</th>
                                                <th>Ações</th>
                                            </thead>
                                            <tbody id="mac_tbody">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabDocumentos">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card flex-fill">
									<div class="card-header">
										<h5 class="card-title mb-0">Enviar Documento</h5>
									</div>
									<div class="card-body">
                                        <form action="#" id="formEnviarArquivo">
                                            <div class="row">
                                                <div class="col-md-6 form-group">
                                                    <label>Título do Documento</label>
                                                    <input class="form-control" type="text" name="tituloDocumento">
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label>Selecione o arquivo a ser enviado</label>
                                                    <input type="file" name="arquivo" class="form-control">
                                                </div>
                                            </div>
                                            <input type="hidden" name="mepIdProcesso2" id="mepIdProcesso2">
                                        </form>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" name="btnEnviarArquivo" id="btnEnviarArquivo" class="btn btn btn-dark submit-btn">Enviar Arquivo</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="card flex-fill">
									<div class="card-header" style="background-color: #7460ee !important;">
										<h5 class="card-title text-white mb-0">Arquivos Enviados</h5>
									</div>
									<div class="card-body" >

                                        <div class="row" id="bodyArquivosEnviados">

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="tab-pane" id="tabCarta">
					    <div class="card flex-fill">
					        <div class="card-header">
                                <h5 class="card-title mb-0">Gerar Carta Cliente</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{route('cadastrar.carta')}}">
                                    <div class="row">
                                        @csrf
                                        <input type="hidden" name="mccidProcessoCarta" class="form-control form-control2" id="mccidProcessoCarta">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn btn-dark" >Gerar Carta Cliente</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
					    </div>
					</div>
                    <div class="tab-pane" id="tabTrocarAgenda">
					    <div class="card flex-fill">
					        <div class="card-header">
                                <h5 class="card-title mb-0">Trocar Agenda do Processo</h5>
                            </div>
                            <div class="card-body">
                                <form id="formAlterarAgenda" method="post" action="{{route('alterar.agenda')}}">
                                    <div class="row">
                                        <input type="hidden" name="mccidProcessoChangeAgenda" class="form-control form-control2" id="mccidProcessoChangeAgenda">
                                        <input type="hidden"  id="mccidsubAgenda">
                                    </div>
                                    @csrf
                                    <div class="col-md-6 form-group">
                                        <label>Nova agenda</label>
                                        
                                        {{ Form::select('tipoProcessoDisable',  array_merge([0 => 'Selecione um Tipo'], $arrayTiposAgenda), null, ['class' => 'custom-select type-change-agenda-disabled disable']) }}
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Sub-tipo da Agenda</label>
                                        <select name="subTipoProcessoDisable" id="subTipoProcessoDisable" class="custom-select">
                                            <option value="">Selecione o Subtipo</option>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="spinner-border spinner-border-sm hide disabled" role="status" id="subTipoProcessoLoadDisable" hidden>
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Nova agenda</label>
                                        {{ Form::select('tipoProcesso',  array_merge([0 => 'Selecione um Tipo'], $arrayTiposAgenda), null, ['class' => 'custom-select type-change-agenda']) }}
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Sub-tipo da Agenda</label>
                                        <select name="subTipoProcesso" id="subTipoProcesso" class="custom-select">
                                            <option value="">Selecione o Subtipo</option>
                                        </select>
                                        <div class="input-group-append">
                                            <div class="spinner-border spinner-border-sm hide" role="status" id="subTipoProcessoLoad" hidden>
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="button" id="btnAlterarAgenda" class="btn btn btn-dark" >Alterar Agenda</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
					    </div>
					</div>
                    <div class="tab-pane" id="tabCedentes">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Cadastrar Cedentes</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Nome do Cedente</label>
                                        <input type="text" name="mccNomeCedente" class="form-control form-control2" id="mccNomeCedente">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>CPF</label>
                                        <input type="text" name="mccCpfCedente" class="form-control form-control2" id="mccCpfCedente">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>RG</label>
                                        <input type="text" name="mccRgCedente" class="form-control form-control2" id="mccRgCedente">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Orgão Emissor</label>
                                        <input type="text" name="mccOrgaoEmissorRgCedente" class="form-control form-control2" id="mccOrgaoEmissorRgCedente">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>Nacionalidade</label>
                                        <input type="text" name="mccNacionalidade" class="form-control form-control2" id="mccNacionalidade">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Estado Civíl</label>
                                        <input type="text" name="mccEstadoCivil" class="form-control form-control2" id="mccEstadoCivil">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Profissão</label>
                                        <input type="text" name="mccProfissao" class="form-control form-control2" id="mccProfissao">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label>CEP</label>
                                        <input type="text" name="mccCep" class="form-control form-control2" id="mccCep">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6  form-group">
                                        <label>Logradouro</label>
                                        <input type="text" name="mccLogradouro" class="form-control form-control2" id="mccLogradouro">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Número</label>
                                        <input type="text" name="mccNumero" class="form-control form-control2" id="mccNumero">
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label>Complemento</label>
                                        <input type="text" name="mccComplemento" class="form-control form-control2" id="mccComplemento">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>Bairro</label>
                                        <input type="text" name="mccBairro" class="form-control form-control2" id="mccBairro">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Estado</label>
                                        <input type="text" name="mccEstado" class="form-control form-control2" id="mccEstado">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Cidade</label>
                                        <input type="text" name="mccCidade" class="form-control form-control2" id="mccCidade">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Nome do Banco</label>
                                        <input type="text" name="mccBanco" class="form-control form-control2" id="mccBanco">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Tipo de Conta</label>
                                        <select name="mccTipoConta" class="form-control form-control2" id="mccTipoConta">
                                            <option value="poupanca">Conta Poupança</option>
                                            <option value="corrente">Conta Corrente</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Agência</label>
                                        <input type="text" name="mccAgencia" class="form-control form-control2" id="mccAgencia">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Numero da Conta</label>
                                        <input type="text" name="mccNumeroConta" class="form-control form-control2" id="mccNumeroConta">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn btn-dark" id="btnCadastrarCedenteProcesso">Cadastrar Cedente</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Cedentes cadastrados</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-condensed">
                                    <thead>
                                        <th>Nome</th>
                                        <th>CPF</th>
                                        <th>RG</th>
                                        <th>Localização</th>
                                        <th>Excluir</th>
                                    </thead>
                                    <tbody id="tbodyCedentesCadastros">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="tabContratos">
                        <div class="card flex-fill">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Gerar um novo contrato</h5>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Selecione o tipo de contrato</label>
                                            <select name="mgcTipoContrato" class="form-control form-control2">
                                                <option value=""># Selecione um tipo de contrato</option>
                                                <option value="1">Masculino</option>
                                                <option value="2">Feminino</option>
                                                <option value="3">Herdeiros</option>
                                                <option value="4">Plural</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="mgcMostraGerarNormal" style="display: none;">

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Data e Local de Assinatura</label>
                                            <input type="text" name="gcDataLocalAssinatura" class="form-control form-control2" placeholder="Digite a data e local de assinatura do contrato, que aparecerá no rodapé da página">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Data de Atualização</label>
                                            <input type="text" name="gcDataAtualizacao" class="form-control form-control2">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>Valor Efetivamente Pago no Contrato</label>
                                            <input type="text" name="gcValorEfetivoPago" class="form-control form-control2" placeholder="Digite o valor efetivamente pago nesse contrato">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Percentual de honorários</label>
                                            <input type="text" name="gcPercentualHonorarios" class="form-control form-control2" placeholder="Digite o percentual de honorários">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Digite a data de assinatura do contrato</label>
                                            <input type="text" name="gcDataAssinatura" class="form-control form-control2" placeholder="Digite a data de assinatura do contrato">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Linha nome dos advogados</label>
                                            <input type="text" name="gcNomeAdvs" class="form-control form-control2" placeholder="Digite os dados da linha nome dos advogados">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Linha endereço dos advogados</label>
                                            <input type="text" name="gcEndrecosAdvs" class="form-control form-control2" placeholder="Digite os dados da linha dos endereços dos advogados">
                                        </div>
                                    </div>

                                    <table class="table table-condensed">
                                        <thead>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>RG</th>
                                            <th>Localização</th>
                                            <th>Selecionar</th>
                                        </thead>
                                        <tbody class="tbodyCedentesCadastros2">

                                        </tbody>
                                    </table>

                                    <button type="button" name="btnGerarContratoNormal" id="btnGerarContratoNormal"
                                    class="btn btn btn-dark">Gerar Contrato Selecionado</button>
                                </div>
                                <div id="mgcMostraGerarCedentes" style="display: none;">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Data e Local de Assinatura</label>
                                            <input type="text" name="gcDataLocalAssinatura2" class="form-control form-control2" placeholder="Digite a data e local de assinatura do contrato, que aparecerá no rodapé da página">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Data de Atualização</label>
                                            <input type="text" name="gcDataAtualizacao2" class="form-control form-control2">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label>Valor Efetivamente Pago no Contrato</label>
                                            <input type="text" name="gcValorEfetivoPago2" class="form-control form-control2" placeholder="Digite o valor efetivamente pago nesse contrato">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Percentual de honorários</label>
                                            <input type="text" name="gcPercentualHonorarios2" class="form-control form-control2" placeholder="Digite o percentual de honorários">
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label>Digite a data de assinatura do contrato</label>
                                            <input type="text" name="gcDataAssinatura2" class="form-control form-control2" placeholder="Digite a data de assinatura do contrato">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Linha nome dos advogados</label>
                                            <input type="text" name="gcNomeAdvs2" class="form-control form-control2" placeholder="Digite os dados da linha nome dos advogados">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <label>Linha endereço dos advogados</label>
                                            <input type="text" name="gcEndrecosAdvs2" class="form-control form-control2" placeholder="Digite os dados da linha dos endereços dos advogados">
                                        </div>
                                    </div>

                                    <table class="table table-condensed">
                                        <thead>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>RG</th>
                                            <th>Localização</th>
                                            <th>Selecionar</th>
                                        </thead>
                                        <tbody class="tbodyCedentesCadastros2">

                                        </tbody>
                                    </table>

                                    <button type="button" name="btnGerarContratoCedentes" id="btnGerarContratoCedentes"
                                    class="btn btn-dark">Gerar Contrato com cedentes selecionados</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer" style="justify-content: flex-end;">
                @can('isAdmin')
                <button type="button" class="btn  btn-outline-danger btn-sm clickRemoverAgenda" data-id="{{}}">
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                </svg>Remover da Lista
                </button>
                @endcan
                <button type="button" id="abrirSms" class="btn  btn-outline-dark btn-sm">Guia SMS</button>
                @can('isAdmin')
                <button type="button" id="abrirSms" class="btn btn-secondary btn-sm"><span id="mepDataUltimaAbertura"></span></button>
                @endcan
            </div>
        </div>
    </div>
</div>
<!-- Fim do Editar Processo -->

<!-- Modal Filtro de Tipo de Agenda -->
<div id="modalFiltroTipoAgenda" class="modal custom-modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Selecionar o Tipo de Agenda</h4>
			</div>
			<div class="modal-body">

                <form name="formFiltroTipoProcesso">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Selecione o tipo de processo</label>
                            <select name="filtroTipoProcesso" id="filtroTipoProcesso" class="form-control">
                                <option value="">Todos os tipos</option>
                                <?php
                                    foreach($arrayTiposAgenda as $key => $value){
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Selecione um sub-tipo</label>
                            <select name="filtroSubtipoProcesso" id="filtroSubtipoProcesso" class="form-control">
                                <option value="">All</option>
                            </select>
                        </div>
                    </div>

                    <div class="submit-section">
    					<button class="btn btn-dark submit-btn" type="button" id="btnConfirmarFiltroAgenda">Filtrar</button>
    				</div>
                </form>

            </div>
        </div>
    </div>
</div>
<div style="display: flex; flex-direction: row; justify-content: flex-start;">

<input type="hidden" name="u_filtroTipoProcesso" id="u_filtroTipoProcesso" value="{{ $filtroTipoProcesso }}">
<input type="hidden" name="u_filtroSubtipoProcesso" id="u_filtroSubtipoProcesso" value="{{ $filtroSubtipoProcesso }}">

</div>
<!-- Fim do Modal -->
<!-- Modal Nova Venda -->
<div id="modalNovoProcesso" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adicionar Processo</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
						<div class="form-group">
							<label>Entidade Devedora</label>
							<input class="form-control" type="text" name="mnpEntidadeDevedora">
						</div>
					</div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
						<div class="form-group">
							<label>Cabeça de Ação</label>
							<input class="form-control" type="text" name="mnpCabecaAcao">
						</div>
					</div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
						<div class="form-group">
							<label>Nome do Cliente</label>
							<input class="form-control" type="text" name="mnpRequerente">
						</div>
					</div>
                    <div class="col-sm-6">
						<div class="form-group">
							<label>CPF</label>
							<input class="form-control" type="text" name="mnpCpf">
						</div>
					</div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
						<div class="form-group">
							<label>Número do Processo</label>
							<input class="form-control" type="text" name="mnpNumeroProcesso">
						</div>
					</div>
                    <div class="col-sm-6">
						<div class="form-group">
							<label>Ordem Cronológica</label>
							<input class="form-control" type="text" name="mnpOrdemCronologica">
						</div>
					</div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
						<div class="form-group">
							<label>EP do Processo</label>
							<input class="form-control" type="text" name="mnpExp">
						</div>
					</div>
                    <div class="col-sm-6">
						<div class="form-group">
							<label>Indice de Data Base</label>
							<div class="cal-icon">
								<input class="form-control datetimepicker" type="text" name="mnpIndiceDataBase">
							</div>
						</div>
					</div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
						<div class="form-group">
							<label>Valor Principal</label>
							<input class="form-control" type="text" name="mnpValorPrincipal">
						</div>
					</div>
                    <div class="col-sm-6">
						<div class="form-group">
							<label>Valor Juros</label>
							<input class="form-control" type="text" name="mnpValorJuros">
						</div>
					</div>
                </div>
                @can('isAdmin')
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Colaborador Responsável</label>
                        {{ Form::select('mnpColaborador', $arrayColaboradores, null, ['class' => 'custom-select']) }}

                    </div>
                </div>
                @endcan
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Tipo da Agenda</label>
                        <select name="mnpTipoProcesso" class="custom-select type-agenda tipo_agenda_select">
                            <option value="">Selecione uma agenda</option>

                            @foreach($arrayTiposAgenda as $key => $value )
                                <option value="{{$key}}">{{$value}} </option>
                            @endforeach 
                        </select>


                    </div>
                </div>
                <div class="row">
                <div class="input-group">
                    <div class="form-group col-sm-12">
                        <label>Sub-tipo da Agenda</label>
                        <select name="mnpSubTipoProcesso" id="mnpSubTipoProcesso" class="custom-select" style="width:80%">
                            <option value="">Selecione o Subtipo</option>
                        </select>
                        <div class="input-group-append">
                        <div class="spinner-border spinner-border-sm hide" role="status" id="mnpSubTipoProcessoLoad" hidden>
                            <span class="sr-only">Loading...</span>
                        </div>
                        </div>
                        </div>

                    </div>
                </div>

					<div class="submit-section">
					<button class="btn btn btn-dark submit-btn" type="button" id="mnpBtnSalvar">Salvar Processo</button>
				</div>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="modalListaNotificacoes" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog  modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Notificações de Hoje - {{ date('d/m/Y') }}</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body" style="overflow-y:scroll; height: 400px;">

                <table class="table">
                    <thead>
                        <th>Colaborador</th>
                        <th>Comentário</th>
                        <th>Numero do Processo</th>
                        <th>Nome do Cliente</th>
                    </thead>
                    <tbody id="mln_tbody" >

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

   <script src="/assets/js/jquery-3.2.1.min.js"></script>
   <script src="/assets/js/jquery-ui.min.js"></script>
   <script src="/assets/js/jquery.ui.touch-punch.min.js"></script>
   <script src="/assets/js/popper.min.js"></script>
   <script src="/assets/js/bootstrap.min.js"></script>
   <script src="/assets/js/jquery.slimscroll.min.js"></script>
   <script src="/assets/js/select2.min.js"></script>
   <script src="/assets/js/moment.min.js"></script>
   <script src="/assets/js/bootstrap-datetimepicker.min.js"></script>
   <script src="/assets/js/jquery.mask.min.js"></script>
   <script src="/assets/js/jquery-autocomplete.js"></script>
   <script src="/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
   <script src="/assets/js/app.js"></script>
   <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
   <script src="https://momentjs.com/downloads/moment.js"></script>
   <script type="text/javascript">
        $(document).ready(function(e){
            setInterval(validaNumeros, 60000);
            var arrayLote = [];
            $('#modalFiltroTipoAgenda').modal('show');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/app/agenda/recupera-lembretes',
                method: 'GET',
                success: function(res){
                    if(res.status == 'ok'){
                        var abremodal = 0;
                        $.map( res.array_response, function(val,i) {
                            $('#mln_tbody').append('<tr><td>'+val.nome+'</td><td>'+val.comentario+'</td><td>'+val.processo_de_origem+'</td><td>'+val.reqte+'</td></tr>');

                            abremodal = 1;
                        });

                        if(abremodal == 1){
                            $('#modalListaNotificacoes').modal('show');
                        }
                    }
                },error: function(){

                },complete: function(){

                }
            });
            validaNumeros();
            function validaNumeros(){
                try {
                    var time = localStorage.getItem('validaNumero');
                    var oldTime = moment(time).fromNow();
                    var timeFilter = oldTime.split(" ");
                    if(timeFilter[0] == 'a' && timeFilter[1] == 'minute' && timeFilter[1] == 'ago' || timeFilter[0] >= 1 && timeFilter[1] == 'minutes'){
                        console.log('Rodando cron validação telefone')
                        localStorage.removeItem('validaNumero')
                        $.ajax({
                            url: '/app/cron/verifica-resultados-telefone',
                            method: 'GET',
                            success: function(res){

                            },error: function(){

                            },complete: function(){

                            }
                        });
                    }
                } catch (error) {

                }

            }
            $('.clickRemoverAgenda').click(function(e){
                swal.fire({
                title: "Você tem certeza disso?",
                text: "Você realmente quer remover esse processo da agenda?",
                icon: "warning",
                buttons: true,
                showCancelButton:true,
                dangerMode: true,
                })
                .then((response) => {
                    if (response.isConfirmed) {
                        var id = $(this).attr('data-id');
                        $.ajax({
                            url: '/app/robo/remover-agenda/' + id,
                            method: 'GET',
                            success: function(res){
                                if(res.status == 'ok'){
                                    swal.fire("Tudo certo! Processo foi removido da agenda!", {
                                        icon: "success",
                                    });
                                    refiltrar();
                                }else{
                                    swal.fire(res.response);
                                    $('#modalEditarProcesso').modal('hide')
                                }
                            },error: function(err){
                                swal.fire("Ops, tivemos um problema! mas não removemos o processo da agenda!");
                                $('#modalEditarProcesso').modal('hide')
                            },complete: function(){
                                $('#modalEditarProcesso').modal('hide')
                            }
                        });

                    } else {
                        swal.fire("O processo não foi removido da agenda!");
                    }
                });

            });
            $('#atualizaCPF').click(function(e){
                var cpf = $('#mepCpf').val();
                var idProcesso = $('#mepIdProcesso').val();
                $('#loadingCPF').removeAttr('hidden')
                localStorage.setItem('validaNumero', moment().format());
                $.ajax({
                    url: 'agenda/capturaCpf/contatos?cpf='+cpf.replace(/[^\d]+/g,'')+'&idProcesso='+idProcesso,
                    method: 'GET',
                    success: function(res){
                        $('#mepDataNascimento').val(res.data_nascimento);
                        $.each(res.telefones,function(index,val){
                            $('#tbodyTelefones').append('<tr>'+
                                '<td>'+val.telefone+'</td>'+
                                '<td><span class="badge badge-primary">Em Consulta</span></td>'+
                                '<td class="text-right">'+
                                    '<div class="dropdown dropdown-action">'+
                                        '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                            '<i class="material-icons">more_vert</i>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-right">'+
                                            '<a class="dropdown-item clickExcluirTelefone" href="#" data-id="'+val.id+'"><i class="fa fa-trash-o m-r-5"></i> Excluir</a>'+
                                            '<a class="dropdown-item clickAbrirWhatsapp" href="https://api.whatsapp.com/send?phone=55'+encodeURIComponent(res.telefone)+'" target="_blank" data-id="'+val.id+'"><i class="fa fa-whatsapp m-r-5"></i> Whatsapp Web</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>');
                        });
                        $.each(res.emails,function(index,val){
                            $('#tbodyEmails').append('<tr>'+
                                '<td>'+val.email+'</td>'+
                                '<td class="text-right">'+
                                    '<div class="dropdown dropdown-action">'+
                                        '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                            '<i class="material-icons">more_vert</i>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-right">'+
                                            '<a class="dropdown-item clickExcluirEmail" href="#" data-id="'+val.id+'"><i class="fa fa-trash-o m-r-5"></i> Excluir</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>');
                        });
                        $('#loadingCPF').attr('hidden',true);
                        Swal.fire({
                        icon: 'success',
                        title: 'Atualizado',
                        text: 'A lista de telefone e e-mail foi atualizada',
                    });
                    },error: function(){
                        $('#loadingCPF').attr('hidden',true);
                        Swal.fire({
                        icon: 'error',
                        title: 'Falha ao se comunicar com api!',
                        text: 'Por favor tente novamente!',
                    });
                    },complete: function(){
                        // element.removeAttr('disabled');
                    }
                });

            });
            $('#atualizaScore').click(function(e){
                var cpf = $('#mepCpf').val();
                var idProcesso = $('#mepIdProcesso').val();
                $('#loadingCPF').removeAttr('hidden')
                localStorage.setItem('validaNumero', moment().format());
                $.ajax({
                    url: 'agenda/atualizaScore?cpf='+cpf.replace(/[^\d]+/g,'')+'&idProcesso='+idProcesso,
                    method: 'GET',
                    success: function(res){
                        $.each(res.telefones,function(index,val){
                            $('#tbodyTelefones').append('<tr>'+
                                '<td>'+val.telefone+'</td>'+
                                '<td><span class="badge badge-primary">Em Consulta</span></td>'+
                                '<td class="text-right">'+
                                    '<div class="dropdown dropdown-action">'+
                                        '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                            '<i class="material-icons">more_vert</i>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-right">'+
                                            '<a class="dropdown-item clickExcluirTelefone" href="#" data-id="'+val.id+'"><i class="fa fa-trash-o m-r-5"></i> Excluir</a>'+
                                            '<a class="dropdown-item clickAbrirWhatsapp" href="https://api.whatsapp.com/send?phone=55'+encodeURIComponent(res.telefone)+'" target="_blank" data-id="'+val.id+'"><i class="fa fa-whatsapp m-r-5"></i> Whatsapp Web</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>');
                        });
                        $('#score').html('SC: '+res.score);
                        $('#loadingCPF').attr('hidden',true);
                        Swal.fire({
                        icon: 'success',
                        title: 'Atualizado',
                        text: 'A lista de telefone e e-mail foi atualizada',
                    });
                    },error: function(){
                        $('#loadingCPF').attr('hidden',true);
                        Swal.fire({
                        icon: 'error',
                        title: 'Falha ao se comunicar com api!',
                        text: 'Por favor tente novamente!',
                    });
                    },complete: function(){
                        // element.removeAttr('disabled');
                    }
                });

            });
            $('body').on('click', '.mac_excluir_item', function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                var id = element.attr('data-id');

                $.ajax({
                    url: '/app/agenda/excluir-item/'+id,
                    method: 'GET',
                    success: function(res){
                        if(res.status == 'ok'){
                            element.parent().parent().remove();
                            $('#mac_mostra_alert').html('<div class="alert alert-success">Notificação excluida com sucesso</div>');
                        }else{
                            $('#mac_mostra_alert').html('<div class="alert alert-danger">Ocorreu um erro ao excluir. Tente novamente</div>');
                        }
                    },error: function(){
                        $('#mac_mostra_alert').html('<div class="alert alert-danger">Ocorreu um erro ao excluir. Tente novamente</div>');
                    },complete: function(){
                        element.removeAttr('disabled');
                    }
                });
            });
            $('.type-agenda').change(function(e){
                $('#mnpSubTipoProcesso').attr('disabled', 'disabled');
                $('#mnpSubTipoProcessoLoad').removeAttr('hidden');
                var typeAgenda = $('.tipo_agenda_select').val();
                console.log(typeAgenda)
                $('.appnd').remove();
                $.ajax({
                    url: '/app/agendas/recuperar-subtipo-ajax/'+typeAgenda,
                    method: 'GET'
                    ,success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function(val,i) {
                                $('#mnpSubTipoProcesso').append('<option class="appnd" value="'+val.id+'">&nbsp; '+val.titulo+'</option>');
                            });
                        }else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao recuperar os sub-tipos da agenda'
                        });
                        }
                    },error: function(){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao recuperar os sub-tipos da agenda'
                        });

                    },complete: function(){
                        $('#mnpSubTipoProcesso').removeAttr('disabled', 'disabled');
                        $('#mnpSubTipoProcessoLoad').attr('hidden',true);

                    }
                });
            });

            $('.type-change-agenda-disabled').change(function(e){
                $('#subTipoProcessoDisable').attr('disabled', 'disabled');
                $('#subTipoProcessoLoadDisable').removeAttr('hidden');
                var typeAgenda = $('select[name=tipoProcessoDisable] option:selected').val();
                var subtipo = $('#mccidsubAgenda').val();
                console.log(subtipo);
                $('.appnd').remove();
                $.ajax({
                    url: '/app/agendas/recuperar-subtipo-ajax/'+typeAgenda,
                    method: 'GET'
                    ,success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function(val,i) {
                                $('#subTipoProcessoDisable').append('<option class="appnd" value="'+val.id+'">&nbsp; '+val.titulo+'</option>');
                                $('#subTipoProcessoDisable').val(val.id);
                            });
                            $('#subTipoProcessoDisable').val(subtipo);

                        }else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao recuperar os sub-tipos da agenda'
                        });
                        }
                    },error: function(){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao recuperar os sub-tipos da agenda'
                        });

                    },complete: function(){
                        $('#subTipoProcessoLoadDisable').attr('hidden',true);

                    }
                });
            });
            function getSubAgenda(){
                $('#subTipoProcessoDisable').attr('disabled', 'disabled');
                $('#subTipoProcessoLoadDisable').removeAttr('hidden');
                var typeAgenda = $('select[name=tipoProcessoDisable] option:selected').val();
                var subtipo = $('#mccidsubAgenda').val();
                console.log(subtipo);

                $('.appnd').remove();
                $.ajax({
                    url: '/app/agendas/recuperar-subtipo-ajax/'+typeAgenda,
                    method: 'GET'
                    ,success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function(val,i) {
                                $('#subTipoProcessoDisable').append('<option class="appnd" value="'+val.id+'">&nbsp; '+val.titulo+'</option>');
                                $('#subTipoProcessoDisable').val(val.id);
                            });
                            $('#subTipoProcessoDisable').val(subtipo);

                        }else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao recuperar os sub-tipos da agenda'
                        });
                        }
                    },error: function(){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao recuperar os sub-tipos da agenda'
                        });

                    },complete: function(){
                        $('#subTipoProcessoLoadDisable').attr('hidden',true);

                    }
                });
            }
            $('.type-change-agenda').change(function(e){
                $('#subTipoProcesso').attr('disabled', 'disabled');
                $('#subTipoProcessoLoad').removeAttr('hidden');
                var typeAgenda = $('select[name=tipoProcesso] option:selected').val();

                $('.appnd').remove();
                $.ajax({
                    url: '/app/agendas/recuperar-subtipo-ajax/'+typeAgenda,
                    method: 'GET'
                    ,success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function(val,i) {
                                $('#subTipoProcesso').append('<option class="appnd" value="'+val.id+'">&nbsp; '+val.titulo+'</option>');
                            });
                        }else{
                            Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao recuperar os sub-tipos da agenda'
                        });
                        }
                    },error: function(){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao recuperar os sub-tipos da agenda'
                        });

                    },complete: function(){
                        $('#subTipoProcesso').removeAttr('disabled', 'disabled');
                        $('#subTipoProcessoLoad').attr('hidden',true);

                    }
                });
            });
            $('body').on('click', '.mac_submit', function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');

                $('#mac_mostra_alert').html('');

                $.ajax({
                    url: '/app/agenda/adicionar-lembrete',
                    method: 'POST',
                    data: {
                        data_agendamento: $('#mac_data').val(),
                        comentario: $('#mac_observacao').val(),
                        idprocesso: $('#mepIdProcesso').val()
                    },success: function(res){
                        if(res.status == 'ok'){
                            $('#mac_mostra_alert').html('<div class="alert alert-success">Notificação salva com sucesso</div>');

                            $('#mac_tbody').append('<tr><td>'+res.data_agendamento+'</td><td>'+res.comentario+'</td><td><a href="#!" class="btn btn-outline-danger btn-sm mac_excluir_item" data-id="'+res.id+'"><i class="fa fa-trash"></i>&nbsp;Excluir </a></td></tr>')
                        }else{
                            $('#mac_mostra_alert').html('<div class="alert alert-danger">Ocorreu um erro ao salvar. Verifique os dados digitados e tente novamente</div>');
                        }
                    },error: function(){
                        $('#mac_mostra_alert').html('<div class="alert alert-danger">Ocorreu um erro ao salvar. Tente novamente em alguns instantes</div>');
                    },complete: function(){
                        element.removeAttr('disabled', 'disabled');
                    }
                });
            });

            $('#enviarSms').attr('disabled', 'disabled');

            $('body').on('click', '#enviarSms', function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');

                var array = new Array();

                $('.sms_checks').each(function( index ) {
                    var id = $(this).val();
                    if( $(this).prop('checked') ){
                        array.push(id);
                    }
                });
                var isFlashSms = 0;
                if( $('#isFlashSms').prop('checked') ){
                    isFlashSms = 1;
                }

                $.ajax({
                    url: '/app/sms/dispara-sms',
                    method: 'POST',
                    data: {
                        mensagem: $('#sms_idMensagem').val(),
                        numeros: array,
                        isFlashSms: isFlashSms,
                        idprocesso: $('input[name=sms_idprocesso]').val()
                    },success: function(res){
                        if(res.status == 'ok'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: 'Mensagen enviada com sucesso'
                            });
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: res.mensagem
                            });
                        }
                    },error: function(err){
                    },complete: function(){
                        element.removeAttr('disabled')
                    }
                });
            });

            $('body').on('change', '.sms_checks', function(e){
                var selectedMensagem = $('#sms_idMensagem').val();
                var isPhoneSelected = false;

                $('#enviarSms').attr('disabled', 'disabled');

                $('.sms_checks').each(function(e){
                    if( $(this).is(':checked') ){
                        isPhoneSelected = true;
                    }
                });
                if(isPhoneSelected == true && selectedMensagem != ''){
                    $('#enviarSms').removeAttr('disabled');
                }
            });

            /* SMS */
            $('#abrirSms').click(function(e){
                var idprocesso = $('#mepIdProcesso').val();

                $('input[name=sms_idprocesso]').val(idprocesso);
                $('#sms_listaTelefones').html('');
                $.ajax({
                    url: '/app/sms/recupera-telefones-agenda/' + idprocesso,
                    method: 'GET',
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function(val,i) {
                                $('#sms_listaTelefones').append('<div class="checkbox"><label><input type="checkbox" name="sms_selected_phones[]" class="sms_checks" value="'+val.telefone+'">&nbsp; '+val.telefone+'</label></div>');
                            });
                        }
                    },error: function(err){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao recuperar os telefones'
                        });
                    }
                });
                $('#mySidepanel').css('width', '400px');
            });

            $('#closeSidepanel').click(function(e){
                $('#mySidepanel').css('width', '0px');
            });
            $('#atualizaCorrecao').click(function(e){
                moment.locale('pt-br');
                $('#mcIndiceCorrecaoAte').val(moment().format('DD/MM/YYYY'));
            });

            $('#sms_idMensagem').change(function(e){
                var element = $(this);
                $('#previewMensagem').html('');
                var selected = $(this).val();

                if(selected != ''){
                    $.ajax({
                        url: '/app/sms/get-sms/' + selected,
                        method: 'GET',
                        success: function(res){
                            if(res.status == 'ok'){
                                $('#previewMensagem').val(res.response.mensagem);
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro',
                                    text: res.mensagem,
                                });
                            }
                        },error: function(err){

                        },complete: function(){
                            var selectedMensagem = $('#sms_idMensagem').val();
                            var isPhoneSelected = false;

                            $('.sms_checks').each(function(e){
                                if( $(this).is(':checked') ){
                                    isPhoneSelected = true;
                                }
                            });

                            if(isPhoneSelected == true && selectedMensagem != ''){
                                $('#enviarSms').removeAttr('disabled');
                            }
                        }
                    });
                }else{
                    $('#enviarSms').attr('disabled', 'disabled');
                }
            })

            $('#divExcluirProcesso').css('opacity', '0');

            var notificationTimeout;
            var updateNotification = function(task, notificationText, newClass){
                var notificationPopup = $('.notification-popup ');
                notificationPopup.find('.task').text(task);
                notificationPopup.find('.notification-text').text(notificationText);
                notificationPopup.removeClass('hide success error info primary danger warning');

                if(newClass)
                    notificationPopup.addClass(newClass);

                if(notificationTimeout)
                    clearTimeout(notificationTimeout);

                notificationTimeout = setTimeout(function(){
                    notificationPopup.addClass('hide');
                }, 3000);
            };

            $('#toggleFiltrosTexto').click(function(e){
                $('#rowFiltros').toggle();
                var verificar = $('#rowFiltros').hasClass('colapse');
                if(!verificar){
                    $('#rowFiltros').addClass('colapse');
                    $('#containerBody').css('top', "150px")
                    $('#containerBody').css('position', "relative")
                }else{
                    $('#rowFiltros').removeClass('colapse');
                    $('#containerBody').css('top', "-150px")
                    $('#containerBody').css('position', "")

                }

            });
            $('#toggleEnvioLote').click(function(e){
                $('#mySidepanelFilter').css('width', '500px');
                $('#kabanhidden').css('width', '75%')
            });
            $('#toggleEnvioLoteClose').click(function(e){
                $('#mySidepanelFilter').css('width', '0px');
                $('#kabanhidden').css('width', '100%')

            });
            $('#filtroIdFuncionario').change(function(e){
                if( $(this).val() == '' ){
                    $('.divProcesso').each(function(e){
                        $(this).show();
                    });
                }else{
                    var id = $('#filtroIdFuncionario option:selected').val();

                    $('.divProcesso').each(function(e){
                        var datauserid = $(this).attr('data-userid');

                        if( datauserid == id ){
                           $(this).show();
                        }else{
                           $(this).hide();
                        }
                    })
                }
            });
            $('#filtroAbandono').change(function(e){
                if($(this).is(':checked')){
                    $('#labelfiltroAbandono').removeClass('btn btn-light');
                    $('#labelfiltroAbandono').addClass('btn btn-success');
                    $('.divProcesso').each(function(e){
                        var abandono = $(this).attr('data-abandono');
                        if( parseInt(abandono) <= 30 ){
                            $(this).show();
                        }else{
                            $(this).hide();
                        }
                    })
                }else{
                    $('#labelfiltroAbandono').removeClass('btn btn-success');
                    $('#labelfiltroAbandono').addClass('btn btn-light');
                    $('.divProcesso').each(function(e){
                        $(this).show();
                    });
                }
               
            });
            
            $("#filtroDataProcesso").on("change paste keyup", function() {
               var texto = $(this).val();
               var texto = texto.toUpperCase();

               if( texto == '' ){
                  $('.divProcesso').each(function (index, value) {
                     $(this).show();
                  });
               }else{
                  $('.divProcesso').each(function (index, value) {
                     var ordem_cronologica = $(this).attr('data-ordem_cronologica');

                     if ( ordem_cronologica.indexOf( texto ) > -1 ) {
                        $(this).show();
                     }else{
                        $(this).hide();
                     }
                  });
               }
            });
            $("#filtroDataBaseProcesso").on("change paste keyup", function() {
               var texto = $(this).val();
               var texto = texto.toUpperCase();

               if( texto == '' ){
                  $('.divProcesso').each(function (index, value) {
                     $(this).show();
                  });
               }else{
                  $('.divProcesso').each(function (index, value) {
                     var dataBase = $(this).attr('data-dataBase');

                     if ( dataBase.indexOf( texto ) > -1 ) {
                        $(this).show();
                     }else{
                        $(this).hide();
                     }
                  });
               }
            });

            $("#filtroDataTelefone").on("change paste keyup", function() {
               var texto = $(this).val();
               var texto = texto.toUpperCase();

               if( texto == '' ){
                  $('.divProcesso').each(function (index, value) {
                     $(this).show();
                  });
               }
            });
            $('#filtroDataTelefone').autocomplete({
                serviceUrl: '/app/autocomplete/filterTelefone',
                minChars:4,
                showNoSuggestionNotice:true,
                noSuggestionNotice: 'Nenhum Telefone associado a um Reqte encontrado!',
                onSelect: function (suggestion) {
                    if( $('#filtroDataTelefone').val() == '' ){
                        $('.divProcesso').each(function(e){
                            $(this).show();
                        });
                    }else{
                        $('.divProcesso').each(function(e){
                            var datauserid = $(this).attr('data-id');

                            if( datauserid == suggestion.data ){
                            $(this).show();
                            }else{
                            $(this).hide();
                            }
                        })
                    }
                }
            });
            $("#filtroDataCPF").on("change paste keyup", function() {
               var texto = $(this).val();
               var texto = texto.toUpperCase();

               if( texto == '' ){
                  $('.divProcesso').each(function (index, value) {
                     $(this).show();
                  });
               }
            });
            $('#filtroDataCPF').autocomplete({
                serviceUrl: '/app/autocomplete/filterCPF',
                minChars:4,
                showNoSuggestionNotice:true,
                noSuggestionNotice: 'Nenhum Telefone associado a um Reqte encontrado!',
                onSelect: function (suggestion) {
                    if( $('#filtroDataCPF').val() == '' ){
                        $('.divProcesso').each(function(e){
                            $(this).show();
                        });
                    }else{
                        $('.divProcesso').each(function(e){
                            var datauserid = $(this).attr('data-id');
                            if( datauserid == suggestion.data ){
                            $(this).show();
                            }else{
                            $(this).hide();
                            }
                        })
                    }
                }
            });

            $('#filtroIDProcesso').autocomplete({
                serviceUrl: '/app/autocomplete/filterID',
                minChars:1,
                showNoSuggestionNotice:true,
                noSuggestionNotice: 'ID não encontrado!',
                onSelect: function (suggestion) {
                    console.log(suggestion);
                    if( $('#filtroIDProcesso').val() == '' ){
                        $('.divProcesso').each(function(e){
                            $(this).show();
                        });
                    }else{
                        $('.divProcesso').each(function(e){
                            var datauserid = $(this).attr('data-id');
                            console.log(datauserid )
                            console.log(suggestion.data )
                            if( datauserid == suggestion.data ){
                                $(this).show();
                            }else{
                                $(this).hide();
                            }
                        })
                    }
                }
            });
            $('#nomeFuncionario').autocomplete({
                serviceUrl: '/app/autocomplete/filterFuncionario',
                minChars:3,
                showNoSuggestionNotice:true,
                noSuggestionNotice: 'Nenhum  um Colaborador encontrado!',
            });
            $('#reqteName').autocomplete({
                serviceUrl: '/app/autocomplete/filterReqte',
                minChars:3,
                showNoSuggestionNotice:true,
                noSuggestionNotice: 'Nenhum Reqte encontrado!',
                onSelect: function (suggestion) {
                    $('#reqteName').val('');
                    if(arrayLote.indexOf(suggestion.data) != -1){
                        Swal.fire({
                                icon: 'error',
                                title: 'Falha',
                                text: 'Você não pode adicionar o mesmo processo!',
                        });
                    }else{
                        arrayLote.push(suggestion.data)
                        $('#loteTable').append(
                            '<tr class="itemLote">'+
                                '<th scope="row">'+suggestion.data+'</th>'+
                                '<td>'+suggestion.value+'</td>'+
                                '+<td><button class="btn btn-dark removeProcessoLote" data-id="'+suggestion.data+'"><i class="la la-trash"></i></button></td>'+
                            '</tr>'
                        )

                    }

                }
            });
            $('body').on('click', '.removeProcessoLote', function(e){
                var element = $(this);
                var data_id = $(this).attr('data-id');
                if(arrayLote.pop(data_id)){
                    element.parent().parent().remove();
                }
            });
            $('#filtroTypeValorPrecatorio').change(function(e){
                if( $(this).val() == '' ){
                    $('.divProcesso').each(function(e){
                        $(this).show();
                    });
                }else{
                    var valor = $('#filtroValorPrecatorio option:selected').val();
                    var type = $('#filtroTypeValorPrecatorio option:selected').val();

                    $('.divProcesso').each(function(e){
                        var dataValorPrecatorio = $(this).attr('data-valorprecatorio');
                        var dataUserId = $(this).attr('data-userid');

                        dataValorPrecatorio = parseFloat(dataValorPrecatorio);
                        valor = parseFloat(valor);

                        if(type == 0){
                            if( dataValorPrecatorio > valor){
                                $(this).show();
                            }else{
                                $(this).hide();
                            }
                        }else{
                            if( dataValorPrecatorio <= valor){
                                $(this).show();
                            }else{
                                $(this).hide();
                            }
                        }

                    })
                }
            });
            $('#filtroValorPrecatorio').change(function(e){
                if( $(this).val() == '' ){
                    $('.divProcesso').each(function(e){
                        $(this).show();
                    });
                }else{
                    var valor = $('#filtroValorPrecatorio option:selected').val();
                    var type = $('#filtroTypeValorPrecatorio option:selected').val();

                    $('.divProcesso').each(function(e){
                        var dataValorPrecatorio = $(this).attr('data-valorprecatorio');
                        var dataUserId = $(this).attr('data-userid');

                        dataValorPrecatorio = parseFloat(dataValorPrecatorio);
                        valor = parseFloat(valor);

                            if(type == 0){
                                if( dataValorPrecatorio > valor ){
                                    $(this).show();
                                }else{
                                    $(this).hide();
                                }
                            }else{
                                if( dataValorPrecatorio <= valor ){
                                    $(this).show();
                                }else{
                                    $(this).hide();
                                }
                            }

                    })
                }
            });

            $('#btnFiltrar').click(function(e){
                var nome = $('input[name=filtroNome]').val();
                var numero_processo = $('input[name=filtroNumeroProcesso]').val();
                var filtroIdFuncionario = $('#filtroIdFuncionario option:selected').val();
                console.log(filtroIdFuncionario);
                var ordem_cronologica = $('input[name=filtroDataProcesso]').val();

                $('.divProcesso').each(function(e){
                    $(this).show();
                });

                if(nome == '' && numero_processo == ''  && filtroIdFuncionario == '' && ordem_cronologica == ''){
                    $('.divProcesso').each(function(e){
                        $(this).show();
                    });
                }
                $('.divProcesso').each(function(e){
                    var datanome = $(this).attr('data-nome');
                    var datanp = $(this).attr('data-np');
                    var user_id = $(this).attr('data-userid');
                    var od_crono = $(this).attr('data-ordem_cronologica');


                    if(nome != ''){
                        if (datanome.toLowerCase().indexOf(nome.toLowerCase()) < 0){
                            $(this).hide();
                        }
                    }
                    if(filtroIdFuncionario != ''){
                        if (user_id.indexOf(filtroIdFuncionario) < 0){
                            $(this).hide();
                        }
                    }

                    if(numero_processo != ''){
                        if (datanp.indexOf(numero_processo) < 0){
                            $(this).hide();
                        }
                    }

                    if(ordem_cronologica != ''){
                        if (od_crono.toLowerCase().indexOf(ordem_cronologica.toLowerCase()) < 0){
                            $(this).hide();
                        }
                    }
                })
            });
            $('#btnEnviarLote').click(function(e){
                if(arrayLote.length != 0){
                    var idFuncionario = $('#nomeFuncionario').val();
                    var agendaid = $('#filtroSubtipoProcessoLote').val();
                    var situacaoId = $('#situacaoLote').val();

                    $.ajax({
                        url: '/app/agenda/processos-lote',
                        method: 'POST',
                        data: {
                            'agendaid':agendaid,
                            'situacaoId': situacaoId,
                            'idFuncionario': idFuncionario,
                            'processos': arrayLote
                        },
                        success: function(res){
                            arrayLote = [];
                            $('.itemLote').remove();
                            $('#nomeFuncionario').val('');
                            $('#filtroTipoProcesso').val('');
                            $('#situacaoLote').val('');
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: res.message,
                            });
                        },error: function(err){
                            Swal.fire({
                                icon: 'error',
                                title: 'Falha',
                                text: 'Falha ao enviar o pacote',
                            });
                        }
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Falha',
                        text: 'Você precisa selecionar pelo menos um processo!',
                    });
                }
            });

            function somaTotais(){
                var totalBox0 = 0; var totalBox1 = 0; var totalBox2 = 0;
                var totalBox3 = 0; var totalBox5 = 0;
                var totalBox6 = 0; var totalBox7 = 0; var totalBox8 = 0;

                var somaBox0 = 0.00; var somaBox1 = 0.00; var somaBox2 = 0.00;
                var somaBox3 = 0.00; var somaBox5 = 0.00;
                var somaBox6 = 0.00; var somaBox7 = 0.00; var somaBox8 = 0.00;

                $('.ss0').html('('+totalBox0+') R$ '+(somaBox0.toFixed(2)).toLocaleString('pt-BR'));
                $('.ss1').html('('+totalBox1+') R$ '+(somaBox1.toFixed(2)).toLocaleString('pt-BR'));
                $('.ss2').html('('+totalBox2+') R$ '+(somaBox2.toFixed(2)).toLocaleString('pt-BR'));
                $('.ss3').html('('+totalBox3+') R$ '+(somaBox3.toFixed(2)).toLocaleString('pt-BR'));

                $('.ss5').html('('+totalBox5+') R$ '+(somaBox5.toFixed(2)).toLocaleString('pt-BR'));
                $('.ss6').html('('+totalBox6+') R$ '+(somaBox6.toFixed(2)).toLocaleString('pt-BR'));
                $('.ss7').html('('+totalBox7+') R$ '+(somaBox7.toFixed(2)).toLocaleString('pt-BR'));
                $('.ss8').html('('+totalBox8+') R$ '+(somaBox8.toFixed(2)).toLocaleString('pt-BR'));

                $('#box0 .card').each(function(e){
                    totalBox0 = totalBox0 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox0 = parseFloat(somaBox0);
                    if(!somaBox0){
                        somaBox0 = 0;
                    }
                    somaBox0 = somaBox0 + valor;
                    $('.ss0').html('('+totalBox0+') R$ '+(somaBox0).toLocaleString('pt-BR'));
                });

                $('#box1 .card').each(function(e){
                    totalBox1 = totalBox1 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox1 = parseFloat(somaBox1);
                    if(!somaBox1){
                        somaBox1 = 0;
                    }
                    somaBox1 = somaBox1 + valor;
                    $('.ss1').html('('+totalBox1+') R$ '+(somaBox1).toLocaleString('pt-BR'));
                });

                $('#box2 .card').each(function(e){
                    totalBox2 = totalBox2 + 1;

                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox2 = parseFloat(somaBox2);

                    if(!somaBox2){
                        somaBox2 = 0;
                    }
                    somaBox2 = somaBox2 + valor;
                    $('.ss2').html('('+totalBox2+') R$ '+(somaBox2).toLocaleString('pt-BR'));
                });

                $('#box3 .card').each(function(e){
                    totalBox3 = totalBox3 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox3 = parseFloat(somaBox3);
                    if(!somaBox3){
                        somaBox3 = 0;
                    }
                    somaBox3 = somaBox3 + valor;
                    $('.ss3').html('('+totalBox3+') R$ '+(somaBox3).toLocaleString('pt-BR'));
                });


                $('#box5 .card').each(function(e){
                    totalBox5 = totalBox5 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox5 = parseFloat(somaBox5);
                    if(!somaBox5){
                        somaBox5 = 0;
                    }
                    somaBox5 = somaBox5 + valor;
                    $('.ss5').html('('+totalBox5+') R$ '+(somaBox5).toLocaleString('pt-BR'));
                });

                $('#box6 .card').each(function(e){
                    totalBox6 = totalBox6 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox6 = parseFloat(somaBox6);
                    if(!somaBox6){
                        somaBox6 = 0;
                    }
                    somaBox6 = somaBox6 + valor;
                    $('.ss6').html('('+totalBox6+') R$ '+(somaBox6).toLocaleString('pt-BR'));
                });

                $('#box7 .card').each(function(e){
                    totalBox7 = totalBox7 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox7 = parseFloat(somaBox7);
                    if(!somaBox7){
                        somaBox7 = 0;
                    }
                    somaBox7 = somaBox7 + valor;
                    $('.ss7').html('('+totalBox7+') R$ '+(somaBox7).toLocaleString('pt-BR'));
                });

                $('#box8 .card').each(function(e){
                    totalBox8 = totalBox8 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox8 = parseFloat(somaBox8);
                    if(!somaBox8){
                        somaBox8 = 0;
                    }
                    somaBox8 = somaBox8 + valor;
                    $('.ss8').html('('+totalBox8+') R$ '+(somaBox8).toLocaleString('pt-BR'));
                });
            }

            var elemento;
            var id_origem;

            if($('.kanban-wrap').length > 0) {
        		$(".kanban-wrap").sortable({
        			connectWith: ".kanban-wrap",
        			handle: ".kanban-box",
        			placeholder: "drag-placeholder",
                    stop: function(event, ui){
                        var targetList = $(this);

        				if( targetList.attr('id') != 'divExcluirProcesso'){
                            $('#divExcluirProcesso').css('opacity', '0');
                        }
                    },
        			activate: function(event, ui){
                        $('#divExcluirProcesso').css('opacity', '1');
                        elemento = ui.item;
                        id_origem = ui.sender.attr('id');
        			},
        			receive: function( event, ui ) {
        				//origem
        				var element = ui.item;
        				//console.log(element.attr('data-id'));

        				//destino
                		var targetList = $(this);

        				if( targetList.attr('id') != 'divExcluirProcesso'){
                            $('#divExcluirProcesso').css('opacity', '0');

                            somaTotais();
        					$.ajax({
        						url: '/app/agenda/mudar-box-agenda',
        						method: 'GET',
        						data: {
        							'processo_id': element.attr('data-id'),
        							'novobox': targetList.attr('id')
        						},
        						success: function(res){

        						},error: function(err){
        						},complete: function(){
        						}
        					});
        				}else if( targetList.attr('id') == 'divExcluirProcesso'){

                            var processo_id = element.attr('data-id');

                            Swal.fire({
                                title: 'Excluir Processo?',
                                text: "Tem certeza que deseja excluir esse processo? Essa ação não pode ser desfeita",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sim, excluir!'
                            }).then((result) => {
                                if (result.value) {
                                    $('.divProcesso[data-id='+processo_id+']').remove();
                                    $('#divExcluirProcesso').css('opacity', '0');
                                }else{
                                    var html = $('.divProcesso[data-id='+processo_id+']')[0];
                                    $('.divProcesso[data-id='+processo_id+']').remove();

                                    $('#'+id_origem).append(html);
                                    $('#divExcluirProcesso').css('opacity', '0');
                                }
                            });

                        }else{
                            $('#divExcluirProcesso').css('opacity', '0');
                        }
        			}
        		});
        	}

            var tipoAgenda = '';
            var subtipoAgenda = '';

            var u_filtroTipoProcesso = $('input[name=u_filtroTipoProcesso]').val();
            var u_filtroSubtipoProcesso = $('input[name=u_filtroSubtipoProcesso]').val();
            $('#filtroTipoProcesso').change(function(e){
                tipoAgenda = $(this).val();
                $.ajax({
                    url: '/app/agendas/recuperar-subtipo-ajax/' + tipoAgenda,
                    method: 'GET',
                    success: function(res){
                        if( res.status == 'ok' ){
                            $("#filtroSubtipoProcesso").html('');
                            $("#filtroSubtipoProcesso").append($("<option />").val('').text('Todos'));

                            var $dropdown = $("#filtroSubtipoProcesso");
                            $.each(res.response, function() {
                                $dropdown.append($("<option />").val(this.id).text(this.titulo));
                            });

                            if( u_filtroSubtipoProcesso != '' ){
                               $("#filtroSubtipoProcesso").val(u_filtroSubtipoProcesso);
                               subtipoAgenda = u_filtroSubtipoProcesso;

                               $('#textoAgendaAtual').html( $('#filtroTipoProcesso option:selected').text() + ' - ' + $('#filtroSubtipoProcesso option:selected').text() );

                               u_filtroTipoProcesso = '';
                               u_filtroSubtipoProcesso = '';
                            }
                        }else{
                            updateNotification('Ocorreu um erro ao recuperar os dados', 'danger', 'danger');
                        }
                    },error: function(err){

                    }
                });
            });
            $('#filtroTipoProcessoLote').change(function(e){
                tipoAgenda = $(this).val();
                $.ajax({
                    url: '/app/agendas/recuperar-subtipo-ajax/' + tipoAgenda,
                    method: 'GET',
                    success: function(res){
                        if( res.status == 'ok' ){
                            $("#filtroSubtipoProcessoLote").html('');
                            $("#filtroSubtipoProcessoLote").append($("<option />").val('').text('Todos'));

                            var $dropdown = $("#filtroSubtipoProcessoLote");
                            $.each(res.response, function() {
                                $dropdown.append($("<option />").val(this.id).text(this.titulo));
                            });

                            if( u_filtroSubtipoProcesso != '' ){
                               $("#filtroSubtipoProcesso").val(u_filtroSubtipoProcesso);
                               subtipoAgenda = u_filtroSubtipoProcesso;

                               $('#textoAgendaAtual').html( $('#filtroTipoProcesso option:selected').text() + ' - ' + $('#filtroSubtipoProcessoLote option:selected').text() );

                               u_filtroTipoProcesso = '';
                               u_filtroSubtipoProcesso = '';
                            }
                        }else{
                            updateNotification('Ocorreu um erro ao recuperar os dados', 'danger', 'danger');
                        }
                    },error: function(err){

                    }
                });
            });

            if( u_filtroTipoProcesso != '' ){
               $('#filtroTipoProcesso').val(u_filtroTipoProcesso).trigger('change');
               tipoAgenda = u_filtroTipoProcesso;

            }

            $('#filtroSubtipoProcesso').change(function(e){
                subtipoAgenda = $(this).val();
            });

            $('#btnConfirmarFiltroAgenda').click(function(e){
                var element = $(this);
                $('#containerBody').removeAttr('hidden');
                element.attr('disabled', 'disabled');
                element.html('Aguarde! Carregandos dados');

                refiltrar();

                element.removeAttr('disabled');
                element.html('Filtrar');

                $('#modalFiltroTipoAgenda').modal('hide');
            })
            function refiltrar(){
                $('#loadingPagination').removeAttr('hidden')
                $('#box0').html('');
                $('#box1').html('');
                $('#box2').html('');
                $('#box3').html('');

                $('#box5').html('');
                $('#box6').html('');
                $('#box7').html('');
                $('#box8').html('');

                $('#textoAgendaAtual').html( $('#filtroTipoProcesso option:selected').text() + ' - ' + $('#filtroSubtipoProcesso option:selected').text() );

                axios({
                    method: 'get',
                    url: '/app/agenda/recupera-processos/1?subtipoAgenda='+subtipoAgenda+'+&tipoAgenda='+tipoAgenda,
                    responseType: 'stream',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    })
                    .then(function (response) {
                    if(response.data.status == 'ok'){
                        var str = '';
                        $.map( response.data.response, function( val, i ) {
                            str += '<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                '<div class="kanban-box">'+
                                    '<div class="task-board-header">'+
                                        '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                            '<span>'+val.nome+'</span>'+
                                        '</span>'+
                                        '<span class="status-subtitle">'+
                                            '<span>R$ '+val.valor+'</span>'+
                                        '</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                        });
                        somaTotais();
                        $('#box0').append(str)
                        $( ".task-board-body" ).each(function( index ) {
                            $(this).hide('500');
                            $(this).attr('data-ho', 'close');
                        });

                        }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                axios({
                    method: 'get',
                    url: '/app/agenda/recupera-processos/2?subtipoAgenda='+subtipoAgenda+'+&tipoAgenda='+tipoAgenda,
                    responseType: 'stream',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    })
                    .then(function (response) {
                    if(response.data.status == 'ok'){
                        var str = '';
                        $.map( response.data.response, function( val, i ) {
                            str += '<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                '<div class="kanban-box">'+
                                    '<div class="task-board-header">'+
                                        '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                            '<span>'+val.nome+'</span>'+
                                        '</span>'+
                                        '<span class="status-subtitle">'+
                                            '<span>R$ '+val.valor+'</span>'+
                                        '</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                        });
                        somaTotais();
                        $('#box1').append(str)
                        $( ".task-board-body" ).each(function( index ) {
                            $(this).hide('500');
                            $(this).attr('data-ho', 'close');
                        });

                        }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                axios({
                    method: 'get',
                    url: '/app/agenda/recupera-processos/3?subtipoAgenda='+subtipoAgenda+'+&tipoAgenda='+tipoAgenda,
                    responseType: 'stream',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    })
                    .then(function (response) {
                    if(response.data.status == 'ok'){
                        var str = '';
                        $.map( response.data.response, function( val, i ) {
                            str += '<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                '<div class="kanban-box">'+
                                    '<div class="task-board-header">'+
                                        '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                            '<span>'+val.nome+'</span>'+
                                        '</span>'+
                                        '<span class="status-subtitle">'+
                                            '<span>R$ '+val.valor+'</span>'+
                                        '</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                        });
                        somaTotais();
                        $('#box2').append(str)
                        $( ".task-board-body" ).each(function( index ) {
                            $(this).hide('500');
                            $(this).attr('data-ho', 'close');
                        });

                        }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                axios({
                    method: 'get',
                    url: '/app/agenda/recupera-processos/4?subtipoAgenda='+subtipoAgenda+'+&tipoAgenda='+tipoAgenda,
                    responseType: 'stream',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    })
                    .then(function (response) {
                    if(response.data.status == 'ok'){
                        var str = '';
                        $.map( response.data.response, function( val, i ) {
                            str += '<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif> '+
                                '<div class="kanban-box">'+
                                    '<div class="task-board-header">'+
                                        '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                            '<span>'+val.nome+'</span>'+
                                        '</span>'+
                                        '<span class="status-subtitle">'+
                                            '<span>R$ '+val.valor+'</span>'+
                                        '</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                        });
                        somaTotais();
                        $('#box3').append(str)
                        $( ".task-board-body" ).each(function( index ) {
                            $(this).hide('500');
                            $(this).attr('data-ho', 'close');
                        });

                        }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                axios({
                    method: 'get',
                    url: '/app/agenda/recupera-processos/6?subtipoAgenda='+subtipoAgenda+'+&tipoAgenda='+tipoAgenda,
                    responseType: 'stream',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    })
                    .then(function (response) {
                    if(response.data.status == 'ok'){
                        var str = '';
                        $.map( response.data.response, function( val, i ) {
                            str += '<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                '<div class="kanban-box">'+
                                    '<div class="task-board-header">'+
                                        '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                            '<span>'+val.nome+'</span>'+
                                        '</span>'+
                                        '<span class="status-subtitle">'+
                                            '<span>R$ '+val.valor+'</span>'+
                                        '</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                        });
                        somaTotais();
                        $('#box5').append(str)

                        $( ".task-board-body" ).each(function( index ) {
                            $(this).hide('500');
                            $(this).attr('data-ho', 'close');
                        });

                        }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                axios({
                    method: 'get',
                    url: '/app/agenda/recupera-processos/7?subtipoAgenda='+subtipoAgenda+'+&tipoAgenda='+tipoAgenda,
                    responseType: 'stream',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    })
                    .then(function (response) {
                    if(response.data.status == 'ok'){
                        var str = '';
                        $.map( response.data.response, function( val, i ) {
                            str += '<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                '<div class="kanban-box">'+
                                    '<div class="task-board-header">'+
                                        '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                            '<span>'+val.nome+'</span>'+
                                        '</span>'+
                                        '<span class="status-subtitle">'+
                                            '<span>R$ '+val.valor+'</span>'+
                                        '</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                        });
                        somaTotais();
                        $('#box6').append(str)

                        $( ".task-board-body" ).each(function( index ) {
                            $(this).hide('500');
                            $(this).attr('data-ho', 'close');
                        });

                        }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                axios({
                    method: 'get',
                    url: '/app/agenda/recupera-processos/8?subtipoAgenda='+subtipoAgenda+'+&tipoAgenda='+tipoAgenda,
                    responseType: 'stream',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    })
                    .then(function (response) {
                    if(response.data.status == 'ok'){
                        var str = '';
                        $.map( response.data.response, function( val, i ) {
                            str += '<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                '<div class="kanban-box">'+
                                    '<div class="task-board-header">'+
                                        '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                            '<span>'+val.nome+'</span>'+
                                        '</span>'+
                                        '<span class="status-subtitle">'+
                                            '<span>R$ '+val.valor+'</span>'+
                                        '</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                        });
                        somaTotais();
                        $('#box7').append(str)
                        $( ".task-board-body" ).each(function( index ) {
                            $(this).hide('500');
                            $(this).attr('data-ho', 'close');
                        });

                        }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                axios({
                    method: 'get',
                    url: '/app/agenda/recupera-processos/9?subtipoAgenda='+subtipoAgenda+'+&tipoAgenda='+tipoAgenda,
                    responseType: 'stream',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    })
                    .then(function (response) {
                    if(response.data.status == 'ok'){
                        var str = '';
                        $.map( response.data.response, function( val, i ) {
                            str += '<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                '<div class="kanban-box">'+
                                    '<div class="task-board-header">'+
                                        '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                            '<span>'+val.nome+'</span>'+
                                        '</span>'+
                                        '<span class="status-subtitle">'+
                                            '<span>R$ '+val.valor+'</span>'+
                                        '</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                        });
                        somaTotais();
                        $('#box8').append(str)

                        $( ".task-board-body" ).each(function( index ) {
                            $(this).hide('500');
                            $(this).attr('data-ho', 'close');
                        });
                        }
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                somaTotais();
                $('#kabanhidden').removeAttr('hidden');
                $('#loadingPagination').attr('hidden',true);

            }
            function paginationFilter(){
                $('#loadingPagination').removeAttr('hidden');

                $('#textoAgendaAtual').html( $('#filtroTipoProcesso option:selected').text() + ' - ' + $('#filtroSubtipoProcesso option:selected').text() );

                $.ajax({
                    url: '/app/agenda/recupera-processos/1?page='+page1,
                    method: 'GET',
                    async: true,
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){

                            $.map( res.response, function( val, i ) {

                                $('#box0').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                    '<div class="kanban-box">'+
                                        '<div class="task-board-header">'+
                                            '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                                '<span>'+val.nome+'</span>'+
                                            '</span>'+
                                            '<span class="status-subtitle">'+
                                                '<span>R$ '+val.valor+'</span>'+
                                            '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                                somaTotais();
                            });

                            $( ".task-board-body" ).each(function( index ) {
                                $(this).hide('500');
                                $(this).attr('data-ho', 'close');
                            });
                        }

                    }
                });

                $.ajax({
                    url: '/app/agenda/recupera-processos/2?page='+page2,
                    method: 'GET',
                    async: true,
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {

                                $('#box1').append('<div class="card panel  clickEditar divProcesso"  data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                    '<div class="kanban-box">'+
                                        '<div class="task-board-header">'+
                                            '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;" >'+
                                                '<span>'+val.nome+'</span>'+
                                            '</span>'+
                                            '<span class="status-subtitle">'+
                                                '<span>R$ '+val.valor+'</span>'+
                                            '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');

                                somaTotais();
                            });

                            $( ".task-board-body" ).each(function( index ) {
                                $(this).hide('500');
                                $(this).attr('data-ho', 'close');
                            });
                        }

                    }
                });

                $.ajax({
                    url: '/app/agenda/recupera-processos/3?page='+page3,
                    method: 'GET',
                    async: true,
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box2').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>  '+
                                    '<div class="kanban-box">'+
                                        '<div class="task-board-header">'+
                                            '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                                '<span>'+val.nome+'</span>'+
                                            '</span>'+
                                            '<span class="status-subtitle">'+
                                                '<span>R$ '+val.valor+'</span>'+
                                            '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                                somaTotais();
                            });

                            $( ".task-board-body" ).each(function( index ) {
                                $(this).hide('500');
                                $(this).attr('data-ho', 'close');
                            });
                        }

                    }
                });

                $.ajax({
                    url: '/app/agenda/recupera-processos/4?page='+page4,
                    method: 'GET',
                    async: true,
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box3').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                    '<div class="kanban-box">'+
                                        '<div class="task-board-header">'+
                                            '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                                '<span>'+val.nome+'</span>'+
                                            '</span>'+
                                            '<span class="status-subtitle">'+
                                                '<span>R$ '+val.valor+'</span>'+
                                            '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                                somaTotais();
                            });

                            $( ".task-board-body" ).each(function( index ) {
                                $(this).hide('500');
                                $(this).attr('data-ho', 'close');
                            });
                        }

                    }
                });



                $.ajax({
                    url: '/app/agenda/recupera-processos/6?page='+page6,
                    method: 'GET',
                    async: true,
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box5').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'"  data-dataBase="'+val.dataBase+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                    '<div class="kanban-box">'+
                                        '<div class="task-board-header">'+
                                            '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                                '<span>'+val.nome+'</span>'+
                                            '</span>'+
                                            '<span class="status-subtitle">'+
                                                '<span>R$ '+val.valor+'</span>'+
                                            '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                                somaTotais();
                            });

                            $( ".task-board-body" ).each(function( index ) {
                                $(this).hide('500');
                                $(this).attr('data-ho', 'close');
                            });
                        }

                    }
                });

                $.ajax({
                    url: '/app/agenda/recupera-processos/7?page='+page7,
                    method: 'GET',
                    async: true,
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box6').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'"  data-dataBase="'+val.dataBase+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                    '<div class="kanban-box">'+
                                        '<div class="task-board-header">'+
                                            '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                                '<span>'+val.nome+'</span>'+
                                            '</span>'+
                                            '<span class="status-subtitle">'+
                                                '<span>R$ '+val.valor+'</span>'+
                                            '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                                somaTotais();
                            });

                            $( ".task-board-body" ).each(function( index ) {
                                $(this).hide('500');
                                $(this).attr('data-ho', 'close');
                            });
                        }

                    }
                });

                $.ajax({
                    url: '/app/agenda/recupera-processos/8?page='+page8,
                    method: 'GET',
                    async: true,
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box7').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'"  data-dataBase="'+val.dataBase+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                    '<div class="kanban-box">'+
                                        '<div class="task-board-header">'+
                                            '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                                '<span>'+val.nome+'</span>'+
                                            '</span>'+
                                            '<span class="status-subtitle">'+
                                                '<span>R$ '+val.valor+'</span>'+
                                            '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                                somaTotais();
                            });

                            $( ".task-board-body" ).each(function( index ) {
                                $(this).hide('500');
                                $(this).attr('data-ho', 'close');
                            });
                        }

                    }
                });

                $.ajax({
                    url: '/app/agenda/recupera-processos/9?page='+page9,
                    method: 'GET',
                    async: true,
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box8').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'"  data-dataBase="'+val.dataBase+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-abandono="'+val.abandono+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 2) style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endif>'+
                                    '<div class="kanban-box">'+
                                        '<div class="task-board-header">'+
                                            '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                                '<span>'+val.nome+'</span>'+
                                            '</span>'+
                                            '<span class="status-subtitle">'+
                                                '<span>R$ '+val.valor+'</span>'+
                                            '</span>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                                somaTotais();
                            });

                            $( ".task-board-body" ).each(function( index ) {
                                $(this).hide('500');
                                $(this).attr('data-ho', 'close');
                            });
                        }
                        $('#loadingPagination').attr('hidden', true)

                    }
                });

            }
            $('input[name=mnpValorPrincipal]').mask('000.000.000.000.000,00', {reverse: true});
            $('input[name=mccProposta]').mask('000.000.000.000.000,00', {reverse: true});
            $('input[name=mnpValorJuros]').mask('000.000.000.000.000,00', {reverse: true});
            $('input[name=mnpCpf]').mask('000.000.000-00');
            $('input[name=mnpNumeroProcesso]').mask('0000000-00.0000.0.00.0000');
            $('input[name=mepAdicionarTelefoneText]').mask('(00) 00000-0000');
            $('input[name=filtroDataTelefone]').mask('(00) 00000-0000');
            $('input[name=mepAdicionarTelefoneParenteText]').mask('(00) 00000-0000');

            $('input[name=mcCessaoSemHonorarios]').mask('000,00%', {reverse: true});
            $('input[name=mcPagamentoCessao]').mask('000,00%', {reverse: true});
            $('input[name=mcPagamentosParciais]').mask('000.000.000.000.000,00', {reverse: true});
            $('input[name=mcValorJuros]').mask('000.000.000.000.000,00', {reverse: true});
            $('input[name=mcValorPrincipal]').mask('000.000.000.000.000,00', {reverse: true});


            $('#mnpBtnSalvar').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.html('Aguarde...');
                limparModalNovoProcesso();

                $.ajax({
                    url: '/app/agenda/cadastrar-novo-processo',
                    method: 'POST',
                    data: {
                        mnpEntidadeDevedora: $('input[name=mnpEntidadeDevedora]').val(),
                        mnpCabecaAcao: $('input[name=mnpCabecaAcao]').val(),
                        mnpRequerente: $('input[name=mnpRequerente]').val(),
                        mnpCpf: $('input[name=mnpCpf]').val(),
                        mnpNumeroProcesso: $('input[name=mnpNumeroProcesso]').val(),
                        mnpOrdemCronologica: $('input[name=mnpOrdemCronologica]').val(),
                        mnpExp: $('input[name=mnpExp]').val(),
                        mnpTipoProcesso: $('select[name=mnpTipoProcesso] option:selected').val(),
                        mnpSubTipoProcesso: $('select[name=mnpSubTipoProcesso] option:selected').val(),
                        mnpIndiceDataBase: $('input[name=mnpIndiceDataBase]').val(),
                        mnpValorPrincipal: $('input[name=mnpValorPrincipal]').val(),
                        mnpValorJuros: $('input[name=mnpValorJuros]').val(),
                        mnpColaborador: $('select[name=mnpColaborador] option:selected').val()
                    },
                    success: function(res){

                        if( res.status == 'ok' ){
                            $('input[name=mnpEntidadeDevedora]').val('');
                            $('input[name=mnpCabecaAcao]').val('');
                            $('input[name=mnpNumeroProcesso]').val('');
                            $('input[name=mnpValorPrincipal]').val('');
                            $('input[name=mnpValorJuros]').val('');
                            $('#modalNovoProcesso').modal('hide');

                            $('#box0').append('<div class="card panel clickEditar divProcesso" data-valor="'+res.response.valorBruto+'" data-id="'+res.response.id+'" data-nome="'+res.response.nome+'" data-np="'+res.response.numeroProcesso+'" data-userid="'+res.response.userid+'" data-valorprecatorio="'+res.response.valorPrecatorioTotal+'" data-ordem_cronologica="'+res.response.ordem_cronologica+'" data-abandono="'+res.response.abandono+'" style="background-color: #'+res.response.backgroundColor+'; color: #'+res.response.textColor+'">'+
                                '<div class="kanban-box">'+
                                    '<div class="task-board-header">'+
                                        '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
                                            '<span>'+res.response.nome+'</span>'+
                                        '</span>'+
                                        '<span class="status-subtitle">'+
                                            '<span>R$ '+res.response.valor+'</span>'+
                                        '</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>');

                            // <div class="card panel" data-id="'+res.response.id+'">'+
                            //     '<div class="kanban-box">'+
                            //         '<div class="task-board-header">'+
                            //             '<span class="status-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">'+
                            //                 '<span>'+
                            //                     res.response.nome+
                            //                 '</span>'+
                            //             '</span>'+
                            //             '<div class="dropdown kanban-task-action">'+
                            //                 '<a href="#" data-id="'+res.response.id+'" class="clickShowHide">'+
                            //                     '<i class="fa fa-angle-down"></i>'+
                            //                 '</a>'+
                            //             '</div>'+
                            //         '</div>'+
                            //         '<div class="task-board-body" data-id="'+res.response.id+'" data-ho="open">'+
                            //             '<div class="kanban-footer">'+
                            //                 '<span class="task-info-cont">'+
                            //                     '<span class="task-date"><i class="fa fa-clock-o"></i>'+res.response.valor+'</span>'+
                            //                     '<span class="task-priority badge bg-inverse-warning">Venda Avulsa</span>'+
                            //                 '</span>'+
                            //             '</div>'+
                            //             '<span class="botaoAcoes">'+
                            //                 '<span class="clickEditar" data-id="'+res.response.id+'"><i class="fa fa-edit"></i></span>'+
                            //                 '<span class="clickExcluir" data-id="'+res.response.id+'"><i class="fa fa-trash"></i></span>'+
                            //             '</span>'+
                            //         '</div>'+
                            //     '</div>'+
                            // '</div>');
                        }else{
                            if("mnpCabecaAcao" in res.error){
                                $('input[name=mnpCabecaAcao]').addClass('is-invalid');
                                $('input[name=mnpCabecaAcao]').parent().append('<div class="invalid-feedback">'+res.error.mnpCabecaAcao[0]+'</div>');
                            }
                            if("mnpNumeroProcesso" in res.error){
                                $('input[name=mnpNumeroProcesso]').addClass('is-invalid');
                                $('input[name=mnpNumeroProcesso]').parent().append('<div class="invalid-feedback">'+res.error.mnpNumeroProcesso[0]+'</div>');
                            }
                            if("mnpValorPrincipal" in res.error){
                                $('input[name=mnpValorPrincipal]').addClass('is-invalid');
                                $('input[name=mnpValorPrincipal]').parent().append('<div class="invalid-feedback">'+res.error.mnpValorPrincipal[0]+'</div>');
                            }
                            if("mnpValorJuros" in res.error){
                                $('input[name=mnpValorJuros]').addClass('is-invalid');
                                $('input[name=mnpValorJuros]').parent().append('<div class="invalid-feedback">'+res.error.mnpValorJuros[0]+'</div>');
                            }
                            if("mnpColaborador" in res.error){
                                $('select[name=mnpColaborador]').addClass('is-invalid');
                                $('select[name=mnpColaborador]').parent().append('<div class="invalid-feedback">'+res.error.mnpColaborador[0]+'</div>');
                            }
                            if("mnpColaborador" in res.error){
                                $('select[name=mnpColaborador]').addClass('is-invalid');
                                $('select[name=mnpColaborador]').parent().append('<div class="invalid-feedback">'+res.error.mnpColaborador[0]+'</div>');
                            }
                            if("mnpTipoProcesso" in res.error){
                                $('select[name=mnpTipoProcesso]').addClass('is-invalid');
                                $('select[name=mnpTipoProcesso]').parent().append('<div class="invalid-feedback">'+res.error.mnpTipoProcesso[0]+'</div>');
                            }
                            if("mnpSubTipoProcesso" in res.error){
                                $('select[name=mnpSubTipoProcesso]').addClass('is-invalid');
                                $('select[name=mnpSubTipoProcesso]').parent().append('<div class="invalid-feedback">'+res.error.mnpSubTipoProcesso[0]+'</div>');
                            }
                        }
                    },error: function(err){

                    },complete: function(){
                        element.removeAttr('disabled');
                        element.html('Salvar Processo');
                    }
                });

                function limparModalNovoProcesso(){
                    $('input[name=mnpCabecaAcao]').removeClass('is-invalid');
                    $('input[name=mnpCabecaAcao]').parent().find('.invalid-feedback').remove();
                    $('input[name=mnpNumeroProcesso]').removeClass('is-invalid');
                    $('input[name=mnpNumeroProcesso]').parent().find('.invalid-feedback').remove();
                    $('input[name=mnpValorPrincipal]').removeClass('is-invalid');
                    $('input[name=mnpValorPrincipal]').parent().find('.invalid-feedback').remove();
                    $('input[name=mnpValorJuros]').removeClass('is-invalid');
                    $('input[name=mnpValorJuros]').parent().find('.invalid-feedback').remove();
                    $('select[name=mnpColaborador]').removeClass('is-invalid');
                    $('select[name=mnpColaborador]').parent().find('.invalid-feedback').remove();
                }
            });

            $('#box0').css('padding-bottom', '20px');
            $('#box1').css('padding-bottom', '20px');
            $('#box2').css('padding-bottom', '20px');
            $('#box3').css('padding-bottom', '20px');
            $('#box5').css('padding-bottom', '20px');
            $('#box6').css('padding-bottom', '20px');
            $('#box7').css('padding-bottom', '20px');
            $('#box8').css('padding-bottom', '20px');

            $('#divExcluirProcesso').css('padding-bottom', '50px');
            //recupera processos
            //recupera Tipo 0
            // $.ajax({
            //     url: '/app/agenda/recupera-processos/1?page='+page1,
            //     method: 'GET',
            //     data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
            //     success: function(res){
            //         if(res.status == 'ok'){

            //             $.map( res.response, function( val, i ) {

            //                 $('#box0').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan>'+
            //                     '<div class="kanban-box">'+
            //                         '<div class="task-board-header">'+
            //                             '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
            //                                 '<span>'+val.nome+'</span>'+
            //                             '</span>'+
            //                             '<span class="status-subtitle">'+
            //                                 '<span>R$ '+val.valor+'</span>'+
            //                             '</span>'+
            //                         '</div>'+
            //                     '</div>'+
            //                 '</div>');
            //                 somaTotais();
            //             });

            //             $( ".task-board-body" ).each(function( index ) {
            //                 $(this).hide('500');
            //                 $(this).attr('data-ho', 'close');
            //             });
            //
            //         }
            //     }
            // });

            // $.ajax({
            //     url: '/app/agenda/recupera-processos/2?page='+page2,
            //     method: 'GET',
            //     data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
            //     success: function(res){
            //         if(res.status == 'ok'){
            //             $.map( res.response, function( val, i ) {
            //                 $('#box1').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan>'+
            //                     '<div class="kanban-box">'+
            //                         '<div class="task-board-header">'+
            //                             '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
            //                                 '<span>'+val.nome+'</span>'+
            //                             '</span>'+
            //                             '<span class="status-subtitle">'+
            //                                 '<span>R$ '+val.valor+'</span>'+
            //                             '</span>'+
            //                         '</div>'+
            //                     '</div>'+
            //                 '</div>');
            //                 somaTotais();
            //             });

            //             $( ".task-board-body" ).each(function( index ) {
            //                 $(this).hide('500');
            //                 $(this).attr('data-ho', 'close');
            //             });
            //             page2 += 1;
            //         }
            //     }
            // });

            // $.ajax({
            //     url: '/app/agenda/recupera-processos/3?page='+page3,
            //     method: 'GET',
            //     data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
            //     success: function(res){
            //         if(res.status == 'ok'){
            //             $.map( res.response, function( val, i ) {
            //                 $('#box2').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan>'+
            //                     '<div class="kanban-box">'+
            //                         '<div class="task-board-header">'+
            //                             '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
            //                                 '<span>'+val.nome+'</span>'+
            //                             '</span>'+
            //                             '<span class="status-subtitle">'+
            //                                 '<span>R$ '+val.valor+'</span>'+
            //                             '</span>'+
            //                         '</div>'+
            //                     '</div>'+
            //                 '</div>');
            //                 somaTotais();
            //             });

            //             $( ".task-board-body" ).each(function( index ) {
            //                 $(this).hide('500');
            //                 $(this).attr('data-ho', 'close');
            //             });
            //             page3 += 1;
            //         }
            //     }
            // });

            // $.ajax({
            //     url: '/app/agenda/recupera-processos/4?page='+page4,
            //     method: 'GET',
            //     data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
            //     success: function(res){
            //         if(res.status == 'ok'){
            //             $.map( res.response, function( val, i ) {
            //                 $('#box3').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan>'+
            //                     '<div class="kanban-box">'+
            //                         '<div class="task-board-header">'+
            //                             '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
            //                                 '<span>'+val.nome+'</span>'+
            //                             '</span>'+
            //                             '<span class="status-subtitle">'+
            //                                 '<span>R$ '+val.valor+'</span>'+
            //                             '</span>'+
            //                         '</div>'+
            //                     '</div>'+
            //                 '</div>');
            //                 somaTotais();
            //             });

            //             $( ".task-board-body" ).each(function( index ) {
            //                 $(this).hide('500');
            //                 $(this).attr('data-ho', 'close');
            //             });
            //             page4 += 1;
            //         }
            //     }
            // });


            // $.ajax({
            //     url: '/app/agenda/recupera-processos/6?page='+page6,
            //     method: 'GET',
            //     data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
            //     success: function(res){
            //         if(res.status == 'ok'){
            //             $.map( res.response, function( val, i ) {
            //                 $('#box5').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan>'+
            //                     '<div class="kanban-box">'+
            //                         '<div class="task-board-header">'+
            //                             '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
            //                                 '<span>'+val.nome+'</span>'+
            //                             '</span>'+
            //                             '<span class="status-subtitle">'+
            //                                 '<span>R$ '+val.valor+'</span>'+
            //                             '</span>'+
            //                         '</div>'+
            //                     '</div>'+
            //                 '</div>');
            //                 somaTotais();
            //             });

            //             $( ".task-board-body" ).each(function( index ) {
            //                 $(this).hide('500');
            //                 $(this).attr('data-ho', 'close');
            //             });
            //             page6 += 1;
            //         }
            //     }
            // });

            // $.ajax({
            //     url: '/app/agenda/recupera-processos/7?page='+page7,
            //     method: 'GET',
            //     data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
            //     success: function(res){
            //         if(res.status == 'ok'){
            //             $.map( res.response, function( val, i ) {
            //                 $('#box6').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan>'+
            //                     '<div class="kanban-box">'+
            //                         '<div class="task-board-header">'+
            //                             '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
            //                                 '<span>'+val.nome+'</span>'+
            //                             '</span>'+
            //                             '<span class="status-subtitle">'+
            //                                 '<span>R$ '+val.valor+'</span>'+
            //                             '</span>'+
            //                         '</div>'+
            //                     '</div>'+
            //                 '</div>');
            //                 somaTotais();
            //             });

            //             $( ".task-board-body" ).each(function( index ) {
            //                 $(this).hide('500');
            //                 $(this).attr('data-ho', 'close');
            //             });
            //             page7 += 1;
            //         }
            //     }
            // });

            // $.ajax({
            //     url: '/app/agenda/recupera-processos/8?page='+page8,
            //     method: 'GET',
            //     data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
            //     success: function(res){
            //         if(res.status == 'ok'){
            //             $.map( res.response, function( val, i ) {
            //                 $('#box7').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan>'+
            //                     '<div class="kanban-box">'+
            //                         '<div class="task-board-header">'+
            //                             '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
            //                                 '<span>'+val.nome+'</span>'+
            //                             '</span>'+
            //                             '<span class="status-subtitle">'+
            //                                 '<span>R$ '+val.valor+'</span>'+
            //                             '</span>'+
            //                         '</div>'+
            //                     '</div>'+
            //                 '</div>');
            //                 somaTotais();
            //             });

            //             $( ".task-board-body" ).each(function( index ) {
            //                 $(this).hide('500');
            //                 $(this).attr('data-ho', 'close');
            //             });
            //             page8 += 1;
            //         }
            //     }
            // });

            // $.ajax({
            //     url: '/app/agenda/recupera-processos/9?page='+page9,
            //     method: 'GET',
            //     data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
            //     success: function(res){
            //         if(res.status == 'ok'){
            //             $.map( res.response, function( val, i ) {
            //                 $('#box8').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-processoID="'+val.processoID+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" @can("isAdmin") style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'" @endcan>'+
            //                     '<div class="kanban-box">'+
            //                         '<div class="task-board-header">'+
            //                             '<span class="status-title" style="white-space: normal; overflow: hidden; text-overflow: ellipsis;">'+
            //                                 '<span>'+val.nome+'</span>'+
            //                             '</span>'+
            //                             '<span class="status-subtitle">'+
            //                                 '<span>R$ '+val.valor+'</span>'+
            //                             '</span>'+
            //                         '</div>'+
            //                     '</div>'+
            //                 '</div>');
            //                 somaTotais();
            //             });

            //             $( ".task-board-body" ).each(function( index ) {
            //                 $(this).hide('500');
            //                 $(this).attr('data-ho', 'close');
            //             });
            //             page9 += 1;
            //         }
            //     }
            // });

            $('body').on('click', '.clickShowHide', function(e){
                var id = $(this).attr('data-id');
                $('.task-board-body[data-id='+id+']').toggle(500);
            })

            $('#btnSalvarEdicao').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.html('Aguarde...');

                var id = $('#mepIdProcesso').val();
                var mepCabecaAcao = $('#mepCabecaAcao').val();
				var mepEntDevedora = $('#mepEntDevedora').val();
                var mepNomeCliente = $('#mepRequerente').val();
                var mepCpfCliente = $('#mepCpf').val();
                var mepCampoNumeroProcesso = $('#mepNumeroProcesso').val();
                var mepOrdemCronologica = $('#mepOrdemCronologica').val();
                var mepDataNascimento = $('#mepDataNascimento').val();
                var mepEp = $('#mepExp').val();
                var mepSituacao = $('#mepSituacao option:selected').val();
                var mepDataBase = $('#mepIndiceDataBase').val();
                var mepValorPrincipal = $('#mepValorPrincipal').val();
                var mepValorJuros = $('#mepValorJuros').val();
                var mepFuncionario = $('#mepFuncionario').val();

                $.ajax({
                    url: '/app/agenda/atualizar-dados-processo',
                    method: 'POST',
                    data: {
                        id: id,
                        mepCabecaAcao: mepCabecaAcao,
						mepEntDevedora: mepEntDevedora,
                        mepNomeCliente: mepNomeCliente,
                        mepCpfCliente: mepCpfCliente,
                        mepCampoNumeroProcesso: mepCampoNumeroProcesso,
                        mepOrdemCronologica: mepOrdemCronologica,
                        mepDataNascimento: mepDataNascimento,
                        mepEp: mepEp,
                        mepSituacao: mepSituacao,
                        mepDataBase: mepDataBase,
                        mepValorPrincipal: mepValorPrincipal,
                        mepValorJuros: mepValorJuros,
                        mepFuncionario: mepFuncionario
                    },
                    success: function(res){
                        if(res.status == 'ok'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: 'Dados do Processo foram atualizados com sucesso',
                            });
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Ocorreu um erro ao atualizar os calculos. Verifique os campos destacados e tente novamente',
                            });

                            if("mepCabecaAcao" in res.error){
                                $('input[name=mepCabecaAcao]').addClass('is-invalid');
                                $('input[name=mepCabecaAcao]').parent().append('<div class="invalid-feedback">'+res.error.mepCabecaAcao[0]+'</div>');
                            }
							if("mepEntDevedora" in res.error){
                                $('input[name=mepEntDevedora]').addClass('is-invalid');
                                $('input[name=mepEntDevedora]').parent().append('<div class="invalid-feedback">'+res.error.mepEntDevedora[0]+'</div>');
                            }
                            if("mepCampoNumeroProcesso" in res.error){
                                $('input[name=mepNumeroProcesso]').addClass('is-invalid');
                                $('input[name=mepNumeroProcesso]').parent().append('<div class="invalid-feedback">'+res.error.mepCampoNumeroProcesso[0]+'</div>');
                            }
                            if("mepValorPrincipal" in res.error){
                                $('input[name=mepValorPrincipal]').addClass('is-invalid');
                                $('input[name=mepValorPrincipal]').parent().append('<div class="invalid-feedback">'+res.error.mepValorPrincipal[0]+'</div>');
                            }
                            if("mepValorJuros" in res.error){
                                $('input[name=mnpValorJuros]').addClass('is-invalid');
                                $('input[name=mnpValorJuros]').parent().append('<div class="invalid-feedback">'+res.error.mnpValorJuros[0]+'</div>');
                            }
                            if("mepFuncionario" in res.error){
                                $('select[name=mepFuncionario]').addClass('is-invalid');
                                $('select[name=mepFuncionario]').parent().append('<div class="invalid-feedback">'+res.error.mepFuncionario[0]+'</div>');
                            }
                        }
                    },error: function(err){

                    },complete: function(){
                        element.removeAttr('disabled');
                        element.html('Salvar Edição');
                    }
                });

            });


            $('body').on('click', '.clickEditar', function(e){
                var id = $(this).attr('data-id');

                $('#modalEditarProcesso').modal('show');
                $('.chats').html('');
                $('#tbodyTelefones').html('');
                $('#tbodyTelefonesParente').html('');
                $('#tbodyEmails').html('');
                $('#bodyArquivosEnviados').html('');


                $.ajax({
                    url: '/app/agenda/recupera-dados-e-comentarios/' + id,
                    method: 'GET',
                    success: function(result){
                        console.log(result);
                        $('#mepDataUltimaAbertura').html( 'Ultima Abertura: ' + result.data_ultima_abertura );
                        $('#mepIdProcesso').val( result.id );
                        $('#mepIdProcesso2').val( result.id );
                        $('#mccidProcessoCarta').val( result.id );
                        $('#mccidProcessoChangeAgenda').val( result.id );
                        $('select[name=tipoProcessoDisable] option[value='+result.idTipo+']').attr('selected','selected');
                        $('#mccidsubAgenda').val(result.idSubtipoAgenda);

                        getSubAgenda();
                        
                        $('.type-change-agenda-disabled').attr('disabled', 'disabled' ),
                        $('#mepNumeroProcesso').html( result.processo_de_origem );
                        $('#mepCabecaAcao').val( result.cabeca_de_acao );
						$('#mepEntDevedora').val(result.entidade_devedora );
                        $('#mepRequerente').val( result.reqte );
                        $('#mepCpf').val( result.cpf );
                        $('#score').html( 'SC: '+result.score );
                        $('#mepNumeroProcesso').val( result.processo_de_origem );
                        $('#mepDataNascimento').val(result.data_nascimento);
                        var Splitproccess = result.processo_de_origem.trim().split('/');
                        var numero_processo = Splitproccess[0].split('.8.26.');
                        var proccessSP = Splitproccess[0].split('.');
                        $('#mepexternallink').attr("href",
                        "https://esaj.tjsp.jus.br/cpopg/search.do?conversationId=&dadosConsulta.localPesquisa.cdLocal=-1&cbPesquisa=NUMPROC&dadosConsulta.tipoNuProcesso=UNIFICADO&numeroDigitoAnoUnificado="+numero_processo[0]+"&foroNumeroUnificado="+proccessSP[4]+"&dadosConsulta.valorConsultaNuUnificado="+numero_processo[0]+"8.26."+numero_processo[1]+"&dadosConsulta.valorConsulta=&uuidCaptcha=''");

                        $('#mepOrdemCronologica').val( result.ordem_cronologica );
                        $('#mepExp').val( result.exp );
                        $('#mepSituacao').val( result.status_id );
                        $('#mepIndiceDataBase').val( result.data_base );
                        $('#mepValorPrincipal').val( result.principal_bruto_format );
                        $('#mepValorJuros').val( result.juros_moratorio_format );
                        $('#mepFuncionario').val( result.user_id );
                        $('.clickRemoverAgenda').attr('data-id', result.id);

                        $.map( result.arrayNotificacoes, function(res, i){
                            $('#mac_tbody').append('<tr><td>'+res.data_agendamento+'</td><td>'+res.comentario+'</td><td><a href="#!" class="btn btn-outline-danger btn-sm mac_excluir_item" data-id="'+res.id+'"><i class="fa fa-trash"></i>&nbsp;Excluir </a></td></tr>')
                        } )
                        $.map( result.cedentes, function(res, i){
                            $('#tbodyCedentesCadastros').prepend('<tr><td>'+res.nome+'</td><td>'+res.cpf+'</td><td>'+res.rg+'</td><td>'+res.localizacao+'</td><td><button type="button" class="btn btn-danger clickExcluirCedente" data-id="'+res.id+'"><i class="fa fa-trash"></i></button></td></tr>');
                        } )
                        /*Arquivos */
                        $.map( result.arrayDocumentos, function(val, i){
                            $('#bodyArquivosEnviados').append('<div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">'+
									'<div class="card card-file">'+
										'<div class="dropdown-file">'+
											'<a href="#" class="dropdown-link" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>'+
											'<div class="dropdown-menu dropdown-menu-right">'+
												'<a href="#" class="dropdown-item clickDownloadArquivo" data-id="'+val.id+'">Download</a>'+
												'<a href="#" class="dropdown-item clickExcluirArquivo" data-id="'+val.id+'">Excluir</a>'+
											'</div>'+
										'</div>'+
										'<div class="card-file-thumb">'+
											'<i class="fa fa-file-text-o"></i>'+
										'</div>'+
										'<div class="card-body">'+
											'<h6><a href="#">'+val.tituloDocumento+'</a></h6>'+
											'<span></span>'+
										'</div>'+
										'<div class="card-footer">Enviado em '+val.dataEnvio+'</div>'+
									'</div>'+
								'</div>');
                        } );

                        /* Chat */
                        $.map( result.arrayChat, function( val, i ) {
                            $('.chats').append('<div class="chat chat-left">'+
    							'<div class="chat-body">'+
    								'<div class="chat-bubble">'+
    									'<div class="chat-content" style="">'+
                                            '<h5>'+val.name+'</h5>'+
    										'<p>'+val.mensagem+'</p>'+
    										'<span class="chat-time">'+val.dataEnvio+'</span>'+
    									'</div>'+
    								'</div>'+
    							'</div>'+
    						'</div>');
                        });

                        $.map( result.arrayEmails, function(val, i){
                            $('#tbodyEmails').append('<tr><td>'+val.email+'</td>'+
                            '<td class="text-right">'+
                                '<div class="dropdown dropdown-action">'+
                                    '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                        '<i class="material-icons">more_vert</i>'+
                                    '</a>'+
                                    '<div class="dropdown-menu dropdown-menu-right">'+
                                        '<a class="dropdown-item clickExcluirEmail" href="#" data-id="'+val.id+'"><i class="fa fa-trash-o m-r-5"></i> Excluir</a>'+

                                    '</div>'+
                                '</div>'+
                            '</td>'+
                            '</tr>');
                        });

                        $.map( result.arrayTelefones, function(val,i) {
                            var returnStatus = '';

                            if(val.returnStatus == 'em consulta'){
                                returnStatus = '<span class="badge badge-warning">'+val.returnStatus+'</span>';
                            }else if(val.returnStatus == 'atendida' ){
                                returnStatus = '<span class="badge badge-success">'+val.returnStatus+'</span>';
                            }else if( val.returnStatus == 'sem resposta' ||  val.returnStatus == 'desconhecido'){
                                returnStatus = '<span class="badge badge-danger">'+val.returnStatus+'</span>';
                            }else{
                                returnStatus = '<span class="badge badge-info">'+val.returnStatus+'</span>';
                            }

                            $('#tbodyTelefones').append('<tr>'+
                                '<td>'+val.telefone+'</td>'+
                                '<td>'+returnStatus+'</td>'+
                                '<td class="text-right">'+
                                    '<div class="dropdown dropdown-action">'+
                                        '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                            '<i class="material-icons">more_vert</i>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-right">'+
                                            '<a class="dropdown-item clickExcluirTelefone" href="#" data-id="'+val.id+'"><i class="fa fa-trash-o m-r-5"></i> Excluir</a>'+
                                            '<a class="dropdown-item clickAbrirWhatsapp" href="https://api.whatsapp.com/send?phone=55'+encodeURIComponent(val.telefone)+'" target="_blank" data-id="'+val.id+'"><i class="fa fa-whatsapp m-r-5"></i> Whatsapp Web</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>');

                        });

                        $.map( result.arrayTelefonesParente, function(val,i) {
                            var returnStatus = '';

                            if(val.returnStatus == 'em consulta'){
                                returnStatus = '<span class="badge badge-warning">'+val.returnStatus+'</span>';
                            }else if(val.returnStatus == 'atendida' ){
                                returnStatus = '<span class="badge badge-success">'+val.returnStatus+'</span>';
                            }else if( val.returnStatus == 'sem resposta' ||  val.returnStatus == 'desconhecido'){
                                returnStatus = '<span class="badge badge-danger">'+val.returnStatus+'</span>';
                            }else{
                                returnStatus = '<span class="badge badge-info">'+val.returnStatus+'</span>';
                            }

                            $('#tbodyTelefonesParente').append('<tr>'+
                                '<td>'+val.telefone+'</td>'+
                                '<td>'+returnStatus+'</td>'+
                                '<td class="text-right">'+
                                    '<div class="dropdown dropdown-action">'+
                                        '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                            '<i class="material-icons">more_vert</i>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-right">'+
                                            '<a class="dropdown-item clickExcluirTelefone" href="#" data-id="'+val.id+'"><i class="fa fa-trash-o m-r-5"></i> Excluir</a>'+
                                            '<a class="dropdown-item clickAbrirWhatsapp" href="https://api.whatsapp.com/send?phone=55'+encodeURIComponent(val.telefone)+'" target="_blank" data-id="'+val.id+'"><i class="fa fa-whatsapp m-r-5"></i> Whatsapp Web</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>');

                        });
                    },error: function(err){
                    },complete: function(){

                    }
                });

                $.ajax({
                    url: '/app/agenda/recupera-dados-processo/' + id,
                    method: 'GET',
                    success: function(result){
                        console.log(result)
                        $('#mcAutor').html( result.cabeca_de_acao );
                        $('#mcCedente').html( result.reqte );
                        $('#mcNumeroProcesso').html( result.processo_de_origem );
                        $('#mcExecucaoCronologica').html('');
                        $('#mcExecucaoPrecatorio').html('');
                        $('#mcOrdemCronologica').html( result.ordem_cronologica );
                        $('#mcIndiceDataBase').val( result.data_base );
                        $('#mcResultado1').html( result.inicio_data_base_taxa );
                        $('#mcIndiceCorrecaoAte').val( result.correcao_ate );
                        $('#mcResultado2').html( result.inicio_correcao_taxa );
                        $('#mcDias').val( result.dias_juros );
                        $('#mcResultado3').html(result.diffDias);
                        $('#mcDataVencimento').val('540 dias');
                        $('#mepDataNascimento').val(result.data_nascimento);
                        $('#mcDataEmissaoPrecatorio').val('540 dias');

                        if(result.desconto17 == 1){
                            $('#desconto17').prop('checked', true);
                        }else{
                            $('#desconto17').prop('checked', false);
                        }

                        $('#mcValorPrincipal').val(  );

                        $('#mcValorPrincipal').val( result.principal_bruto_format )

                        $('#mcResultadoValorPrincipal').html('');
                        $('#mcValorJuros').val( result.juros_moratorio );
                        $('#mcValorJuros').val( result.juros_moratorio_format )

                        $('#mcResultadoValorJuros').html('');

                        $('#mcPercentualAM').val( result.percentual_ass_med );
                        $('#mcPagamentosParciais').val( result.pagamento_parcias );
                        $('#mcTotalBruto').html( result.principal_bruto );

                        $('#mcCessaoSemHonorarios').val( result.cessao_sem_honorario );
                        $('#mcCessaoSemHonorarios').val( result.cessao_sem_honorario );

                        $('#mcPagamentoCessao').val( result.pagamento_cessao );
                        $('#mcPagamentoCessao').val( result.pagamento_cessao );

                        $('#mcSpprev').html( result.spprev_format );

                        $('#mcHonorarios').html(result.honorarios_format);
                        $('#mcSaldoAtualizado').html(result.saldo_atualizado_format);
                        $('#mcCessaoSemHonorariosResultado').html(result.valor_csh_format);
                        $('#mcPagamentoCessaoResultado').html(result.valor_pagamento_cessao_format);
                        $('#mcJurosPrincipalAtualizado').html( result.juros_sobre_principal );
                        //$('#mcPagamentosParciais').val( result.valor_pagamento_parciais )

                        $('#mcTotalBruto').html( result.total_bruto );
                    },error: function(err){

                    }
                });
            });

            $('#btnAtualizarCalculos').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.html('Aguarde...');

                var id = $('#mepIdProcesso').val();
                var desconto17 = 0;

                if($('#desconto17').is(':checked')){
                    desconto17 = 1;
                }

                $.ajax({
                    url: '/app/agenda/atualizar-calculos',
                    method: 'POST',
                    data: {
                        mcIndiceDataBase: $('#mcIndiceDataBase').val(),
                        mcIndiceCorrecaoAte: $('#mcIndiceCorrecaoAte').val(),
                        mcValorPrincipal: $('#mcValorPrincipal').val(),
                        mcValorJuros: $('#mcValorJuros').val(),
                        mcPercentualAM: $('#mcPercentualAM option:selected').val(),
                        mcPagamentosParciais: $('#mcPagamentosParciais').val(),
                        mcCessaoSemHonorarios: $('#mcCessaoSemHonorarios').val(),
                        mcPagamentoCessao: $('#mcPagamentoCessao').val(),
                        mcDataEmissaoPrecatorio: $('#mcDataEmissaoPrecatorio').val(),
                        mcDataVencimento: $('#mcDataVencimento').val(),
                        desconto17: desconto17,
                        id: id
                    },
                    success: function(result){


                        if(result.status == 'ok'){
                            $('#mcResultado1').html(result.taxaBase);
                            $('#mcResultado2').html(result.taxaAte);
                            $('#mcResultado3').html(result.diffDias);
                            $('#mcDias').val(result.dias);
                            $('#mcResultadoValorPrincipal').html(result.result1Format);
                            $('#mcResultadoValorJuros').html(result.result2Format);
                            $('#mcJurosPrincipalAtualizado').html(result.jurosSobrePrincipalFormat);
                            $('#mcPercentualAM').val(result.mcPercentualAm);
                            $('#mcSaldoAtualizado').html(result.saldoAtualizado);
                            $('#mcTotalBruto').html(result.totalBruto);
                            $('#mcSpprev').html(result.totalSpprev);
                            $('#mcHonorarios').html(result.totalHonorarios);
                            $('#mcCessaoSemHonorariosResultado').html(result.valorCessaoSemHonorarios);
                            $('#mcPagamentoCessaoResultado').html(result.valorPagamentoCesso);

                            if(result.desconto17 == 1){
                                $('#desconto17').prop('checked', true);
                            }else{
                                $('#desconto17').prop('checked', false);
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Sucesso',
                                text: 'Calculos atualizados com sucesso',
                            });
                        }
                    },error: function(result){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao atualizar os calculos. Atualize a página e tente novamente',
                        });
                    },
                    complete: function(){
                        element.removeAttr('disabled');
                        element.html('Atualizar Calculos');
                    }
                });
            });
            $('#btnAlterarAgenda').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                $.ajax({
                    url: '/app/agenda/alterar',
                    method: 'POST',
                    data: {
                        tipoProcesso: $('select[name=tipoProcesso]').val(),
                        subTipoProcesso: $('#subTipoProcesso').val(),
                        mccidProcessoChangeAgenda: $('#mccidProcessoChangeAgenda').val()
                    },success: function(res){
                        refiltrar();
                        Swal.fire({
                            icon: 'success',
                            title: 'Cadastrado com sucesso',
                            text: 'Agenda alterada com sucesso',
                        });
                        
                    },error: function(err){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao altera a sua agenda. Atualize a página e tente novamente',
                        });
                    },complete: function(){
                        element.removeAttr('disabled');
                    }
                });
                $(this).removeAttr("disabled");
            });
            $('#mensagemChat').on('keypress', function (e) {
                if(e.which === 13){
                    //Disable textbox to prevent multiple submit
                    $(this).attr("disabled", "disabled");

                    var element = $(this);
                    element.attr('disabled', 'disabled');

                    $.ajax({
                        url: '/app/agenda/enviar-chat',
                        method: 'POST',
                        data: {
                            idprocesso: $('#mepIdProcesso').val(),
                            mensagem: $('#mensagemChat').val()
                        },success: function(res){
                            if(res.status == 'ok'){
                                $('#mensagemChat').val('');
                                $('.chats').prepend('<div class="chat chat-left">'+
                                    '<div class="chat-body">'+
                                        '<div class="chat-bubble">'+
                                            '<div class="chat-content">'+
                                                '<h5>'+res.response.name+'</h5>'+
                                                '<p>'+res.response.mensagem+'</p>'+
                                                '<span class="chat-time">'+res.response.dataEnvio+'</span>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                            }else{

                            }
                        },error: function(err){

                        },complete: function(){
                            element.removeAttr('disabled');
                        }
                    });
                    $(this).removeAttr("disabled");
                }
            })
            $('#btnEnviarChat').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');

                $.ajax({
                    url: '/app/agenda/enviar-chat',
                    method: 'POST',
                    data: {
                        idprocesso: $('#mepIdProcesso').val(),
                        mensagem: $('#mensagemChat').val()
                    },success: function(res){
                        if(res.status == 'ok'){
                            $('#mensagemChat').val('');
                            $('.chats').prepend('<div class="chat chat-left">'+
								'<div class="chat-body">'+
									'<div class="chat-bubble">'+
										'<div class="chat-content">'+
                                            '<h5>'+res.response.name+'</h5>'+
											'<p>'+res.response.mensagem+'</p>'+
											'<span class="chat-time">'+res.response.dataEnvio+'</span>'+
										'</div>'+
									'</div>'+
								'</div>'+
							'</div>');
                        }else{

                        }
                    },error: function(err){

                    },complete: function(){
                        element.removeAttr('disabled');
                    }
                });
            });

            $('#btnEnviarArquivo').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.html('Aguarde... Enviando Documento');

                $.ajax({
                    url:"/app/agenda/enviar-documento",
                    method:"POST",
                    data:new FormData($('#formEnviarArquivo')[0]),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(res){

                        if(res.status == 'ok'){
                            //$('#tbodyDocumentos').append('<tr><td><a href="/uploads/'+data.arquivo+'" target="_blank">'+data.tituloDocumento+'</a></td><td><button data-id="'+data.id+'" class="btn btn-danger btnExcluirDocumento"><i class="fa fa-trash"></i></button></td></tr>');
                            $('#bodyArquivosEnviados').append('<div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-3">'+
									'<div class="card card-file">'+
										'<div class="dropdown-file">'+
											'<a href="#" class="dropdown-link" data-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>'+
											'<div class="dropdown-menu dropdown-menu-right">'+
												'<a href="#" class="dropdown-item clickDownloadArquivo" data-id="'+res.id+'">Download</a>'+
												'<a href="#" class="dropdown-item clickExcluirArquivo" data-id="'+res.id+'">Excluir</a>'+
											'</div>'+
										'</div>'+
										'<div class="card-file-thumb">'+
											'<i class="fa fa-file-text-o"></i>'+
										'</div>'+
										'<div class="card-body">'+
											'<h6><a href="#">'+res.tituloDocumento+'</a></h6>'+
											'<span></span>'+
										'</div>'+
										'<div class="card-footer">Enviado em '+res.dataEnvio+'</div>'+
									'</div>'+
								'</div>');
                        }
                    },error: function(err){
                    },complete: function(data){
                        $('#btnEnviarArquivo').removeAttr('disabled');
                        $('#btnEnviarArquivo').html('Enviar Documento');
                    }
                });
            });

            $('#clickAddTelefone').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.hide();

                var telefone = $('input[name=mepAdicionarTelefoneText]').val();

                if(telefone.length < 14){
                    Swal.fire({
                        icon: 'error',
                        title: 'Telefone inválido',
                        text: 'Digite corretamente o numero do telefone',
                    });

                    element.removeAttr('disabled');
                    element.show();
                    return false;
                }
                localStorage.setItem('validaNumero', moment().format());
                $.ajax({
                    url: '/app/agenda/salvar-telefone',
                    method: 'POST',
                    data: {
                        idprocesso: $('#mepIdProcesso').val(),
                        isParente: 0,
                        telefone: telefone
                    },success: function(res){
                        if(res.status == 'ok'){
                            $('input[name=mepAdicionarTelefoneText]').val('');

                            $('#tbodyTelefones').append('<tr>'+
                                '<td>'+res.telefone+'</td>'+
                                '<td><span class="badge badge-primary">Em Consulta</span></td>'+
                                '<td class="text-right">'+
                                    '<div class="dropdown dropdown-action">'+
                                        '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                            '<i class="material-icons">more_vert</i>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-right">'+
                                            '<a class="dropdown-item clickExcluirTelefone" href="#" data-id="'+res.id+'"><i class="fa fa-trash-o m-r-5"></i> Excluir</a>'+
                                            '<a class="dropdown-item clickAbrirWhatsapp" href="https://api.whatsapp.com/send?phone=55'+encodeURIComponent(res.telefone)+'" target="_blank" data-id="'+res.id+'"><i class="fa fa-whatsapp m-r-5"></i> Whatsapp Web</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>');
                        }else{
                            $('input[name=mepAdicionarTelefoneText]').val('');
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: res.mensagem
                            });
                        }
                    },error: function(err){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao cadastrar o telefone. Atualize a página e tente novamente',
                        });
                    },complete: function(){
                        element.removeAttr('disabled');
                        element.show();
                    }
                });
            });
            $('#clickAddTelefoneParente').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.hide();

                var telefone = $('input[name=mepAdicionarTelefoneParenteText]').val();

                if(telefone.length < 14){
                    Swal.fire({
                        icon: 'error',
                        title: 'Telefone inválido',
                        text: 'Digite corretamente o numero do telefone',
                    });

                    element.removeAttr('disabled');
                    element.show();
                    return false;
                }
                localStorage.setItem('validaNumero', moment().format());
                $.ajax({
                    url: '/app/agenda/salvar-telefone',
                    method: 'POST',
                    data: {
                        idprocesso: $('#mepIdProcesso').val(),
                        telefone: telefone,
                        isParente: 1,
                    },success: function(res){
                        if(res.status == 'ok'){
                            $('input[name=mepAdicionarTelefoneParenteText]').val('');

                            $('#tbodyTelefonesParente').append('<tr>'+
                                '<td>'+res.telefone+'</td>'+
                                '<td><span class="badge badge-primary">Em Consulta</span></td>'+
                                '<td class="text-right">'+
                                    '<div class="dropdown dropdown-action">'+
                                        '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                            '<i class="material-icons">more_vert</i>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-right">'+
                                            '<a class="dropdown-item clickExcluirTelefone" href="#" data-id="'+res.id+'"><i class="fa fa-trash-o m-r-5"></i> Excluir</a>'+
                                            '<a class="dropdown-item clickAbrirWhatsapp" href="https://api.whatsapp.com/send?phone=55'+encodeURIComponent(res.telefone)+'" target="_blank" data-id="'+res.id+'"><i class="fa fa-whatsapp m-r-5"></i> Whatsapp Web</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>');
                        }else{
                            $('input[name=mepAdicionarTelefoneParenteText]').val('');
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: res.mensagem
                            });
                        }
                    },error: function(err){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao cadastrar o telefone. Atualize a página e tente novamente',
                        });
                    },complete: function(){
                        element.removeAttr('disabled');
                        element.show();
                    }
                });
            });
            $('#clickAddEmail').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.hide();

                var email = $('input[name=mepAdicionarEmailText]').val();

                if(email.length < 5){
                    Swal.fire({
                        icon: 'error',
                        title: 'Email inválido',
                        text: 'Digite corretamente o email a ser adicionado',
                    });

                    element.removeAttr('disabled');
                    element.show();
                    return false;
                }

                $.ajax({
                    url: '/app/agenda/salvar-email',
                    method: 'POST',
                    data: {
                        idprocesso: $('#mepIdProcesso').val(),
                        email: email
                    },success: function(res){
                        if(res.status == 'ok'){
                            $('input[name=mepAdicionarEmailText]').val('');

                            $('#tbodyEmails').append('<tr>'+
                                '<td>'+res.email+'</td>'+
                                '<td class="text-right">'+
                                    '<div class="dropdown dropdown-action">'+
                                        '<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'+
                                            '<i class="material-icons">more_vert</i>'+
                                        '</a>'+
                                        '<div class="dropdown-menu dropdown-menu-right">'+
                                            '<a class="dropdown-item clickExcluirEmail" href="#" data-id="'+res.id+'"><i class="fa fa-trash-o m-r-5"></i> Excluir</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>');
                        }else{
                            $('input[name=mepAdicionarEmailText]').val('')
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: res.mensagem
                            });
                        }
                    },error: function(err){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao cadastrar o email. Atualize a página e tente novamente',
                        });
                    },complete: function(){
                        element.removeAttr('disabled');
                        element.show();
                    }
                });
            });

            $('body').on('click', '.clickDownloadArquivo', function(e){
                var id = $(this).attr('data-id');

                window.open('/app/agenda/download-arquivo/'+id, '_blank');
            });

            $('body').on('click', '.clickExcluirArquivo', function(e){
                var id = $(this).attr('data-id');
                var element = $(this);

                Swal.fire({
                    title: 'Excluir Arquivo?',
                    text: "Tem certeza que deseja excluir o arquivo desse processo?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '/app/agenda/excluir-documento/'+id,
                            method: 'GET',
                            success: function(res){
                                if(res.status == 'ok'){
                                    element.parent().parent().parent().remove();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sucesso',
                                        text: 'O arquivo foi removido com sucesso',
                                    });
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro ao excluir',
                                        text: 'Ocorreu um erro ao excluir o arquivo. Atualize a página e tente novamente',
                                    });
                                }
                            },error: function(err){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro ao excluir',
                                    text: 'Ocorreu um erro ao excluir o arquivo. Atualize a página e tente novamente',
                                });
                            },complete: function(){

                            }
                        });
                    }
                });
            });

            $('body').on('click', '.clickExcluirEmail', function(e){
                var id = $(this).attr('data-id');
                var element = $(this);

                Swal.fire({
                    title: 'Excluir Email?',
                    text: "Tem certeza que deseja excluir esse email?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '/app/agenda/excluir-email/'+id,
                            method: 'GET',
                            success: function(res){
                                if(res.status == 'ok'){
                                    element.parent().parent().parent().parent().remove();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sucesso',
                                        text: 'O email foi removido com sucesso',
                                    });
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro ao excluir',
                                        text: 'Ocorreu um erro ao excluir o email. Atualize a página e tente novamente',
                                    });
                                }
                            },error: function(err){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro ao excluir',
                                    text: 'Ocorreu um erro ao excluir o email. Atualize a página e tente novamente',
                                });
                            },complete: function(){

                            }
                        });
                    }
                });
            });

            $('body').on('click', '.clickExcluirTelefone', function(e){
                var id = $(this).attr('data-id');
                var element = $(this);

                Swal.fire({
                    title: 'Excluir Telefone?',
                    text: "Tem certeza que deseja excluir esse telefone?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '/app/agenda/excluir-telefone/'+id,
                            method: 'GET',
                            success: function(res){
                                if(res.status == 'ok'){
                                    element.parent().parent().parent().parent().remove();

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sucesso',
                                        text: 'O telefone foi removido com sucesso',
                                    });
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Erro ao excluir',
                                        text: 'Ocorreu um erro ao excluir o telefone. Atualize a página e tente novamente',
                                    });
                                }
                            },error: function(err){
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro ao excluir',
                                    text: 'Ocorreu um erro ao excluir o telefone. Atualize a página e tente novamente',
                                });
                            },complete: function(){

                            }
                        });
                    }
                });
            });

            $('body').on('click', '.clickExcluirCedente', function(e){
                var id = $(this).attr('data-id');

                $.ajax({
                    url: '/app/ajax/excluir-cedente/' + id,
                    method: 'GET',
                    complete: function(e){
                        $('.clickExcluirCedente[data-id='+id+']').parent().parent().remove();
                    }
                });
            });

            somaTotais();

            $('#btnGerarContratoCedentes').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');

                //pega os cedentes selecionados
                var array = new Array();

                $('input[name=mgcCheckbox]').each(function( index ) {
                    var id = $(this).val();
                    if( $(this).prop('checked') ){
                        array.push(id);
                    }
                });

                if( array.length == 0 ){
                    Swal.fire(
                        'Erro',
                        'Selecione ao menos 1 cedente',
                        'error'
                    );

                    element.removeAttr('disabled');
                    return false;
                }

                var id = $('#mepIdProcesso').val();
                var tipo = $('select[name=mgcTipoContrato] option:selected').val();

                var dataAtualizacao = $('input[name=gcDataAtualizacao2]').val();
                var dataLocal = $('input[name=gcDataLocalAssinatura2]').val();
                var valorEfetivoPago = $('input[name=gcValorEfetivoPago2]').val();
                var percHonorario = $('input[name=gcPercentualHonorarios2]').val();
                var campoNomesAdvs = $('input[name=gcNomeAdvs2]').val();
                var dataAssinatura = $('input[name=gcDataAssinatura2]').val();
                var campoEndAdv = $('input[name=gcEndrecosAdvs2]').val();

                window.open('http://novoapp.fairconsultoria.com.br/app/gerar-pdf-contrato/?idprocesso='+id+'&tipo='+tipo+'&cedentes='+array+'&dataAtualizacao='+dataAtualizacao+'&dataLocal='+dataLocal+'&valorEfetivoPago='+valorEfetivoPago+'&percHonorario='+percHonorario+'&campoNomesAdvs='+campoNomesAdvs+'&dataAssinatura='+dataAssinatura+'&campoEndAdv='+campoEndAdv+' ', '_blank');
            });

            $('#btnGerarContratoNormal').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');

                //pega os cedentes selecionados
                var array = new Array();

                $('input[name=mgcCheckbox]').each(function( index ) {
                    var id = $(this).val();
                    if( $(this).prop('checked') ){
                        array.push(id);
                    }
                });

                if( array.length != 1 ){
                    Swal.fire(
                        'Erro',
                        'Selecione apenas 1 cedente',
                        'error'
                    );

                    element.removeAttr('disabled');
                    return false;
                }

                var id = $('#mepIdProcesso').val();
                var tipo = $('select[name=mgcTipoContrato] option:selected').val();

                var dataAtualizacao = $('input[name=gcDataAtualizacao]').val();
                var dataLocal = $('input[name=gcDataLocalAssinatura]').val();
                var valorEfetivoPago = $('input[name=gcValorEfetivoPago]').val();
                var percHonorario = $('input[name=gcPercentualHonorarios]').val();
                var campoNomesAdvs = $('input[name=gcNomeAdvs]').val();
                var dataAssinatura = $('input[name=gcDataAssinatura]').val();
                var campoEndAdv = $('input[name=gcEndrecosAdvs]').val();

                window.open('http://novoapp.fairconsultoria.com.br/app/gerar-pdf-contrato/?idprocesso='+id+'&tipo='+tipo+'&cedentes='+array+'&dataAtualizacao='+dataAtualizacao+'&dataLocal='+dataLocal+'&valorEfetivoPago='+valorEfetivoPago+'&percHonorario='+percHonorario+'&campoNomesAdvs='+campoNomesAdvs+'&dataAssinatura='+dataAssinatura+'&campoEndAdv='+campoEndAdv+' ', '_blank');
            });

            $('select[name=mgcTipoContrato]').change(function(e){
                var valor = $(this).val();

                if(valor == 1){
                    $('#mgcMostraGerarNormal').show();
                    $('#mgcMostraGerarCedentes').hide();
                }else if(valor == 2){
                    $('#mgcMostraGerarNormal').show();
                    $('#mgcMostraGerarCedentes').hide();
                }else if(valor == 3){
                    $('#mgcMostraGerarNormal').hide();
                    $('#mgcMostraGerarCedentes').show();
                }else if(valor == 4){
                    $('#mgcMostraGerarNormal').hide();
                    $('#mgcMostraGerarCedentes').show();
                }else{
                    $('#mgcMostraGerarNormal').hide();
                    $('#mgcMostraGerarCedentes').hide();
                }
            });

            /* Cadastrar Cedente */
            $('#btnCadastrarCedenteProcesso').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');

                $.ajax({
                    url: '/app/ajax/cadastrar-cedente',
                    method: 'POST',
                    data: {
                        mccNomeCedente: $('input[name=mccNomeCedente]').val(),
                        mccCpfCedente: $('input[name=mccCpfCedente]').val(),
                        mccRgCedente: $('input[name=mccRgCedente]').val(),
                        mccOrgaoEmissorRgCedente: $('input[name=mccOrgaoEmissorRgCedente]').val(),
                        mccNacionalidade: $('input[name=mccNacionalidade]').val(),
                        mccEstadoCivil: $('input[name=mccEstadoCivil]').val(),
                        mccCep: $('input[name=mccCep]').val(),
                        mccLogradouro: $('input[name=mccLogradouro]').val(),
                        mccNumero: $('input[name=mccNumero]').val(),
                        mccComplemento: $('input[name=mccComplemento]').val(),
                        mccBairro: $('input[name=mccBairro]').val(),
                        mccEstado: $('input[name=mccEstado]').val(),
                        mccCidade: $('input[name=mccCidade]').val(),
                        mccProfissao: $('input[name=mccProfissao]').val(),
                        mccBanco: $('input[name=mccBanco]').val(),
                        mccTipoConta: $('select[name=mccTipoConta]').val(),
                        mccAgencia: $('input[name=mccAgencia]').val(),
                        mccNumeroConta: $('input[name=mccNumeroConta]').val(),
                        idProcesso: $('#mepIdProcesso').val(),
                    },
                    success: function(res){
                        if(res.status == 'ok'){
                            $('#tbodyCedentesCadastros').prepend('<tr><td>'+res.nome+'</td><td>'+res.cpf+'</td><td>'+res.rg+'</td><td>'+res.localizacao+'</td><td><button type="button" class="btn btn-danger clickExcluirCedente" data-id="'+res.id+'"><i class="fa fa-trash"></i></button></td></tr>');
                            $('.tbodyCedentesCadastros2').prepend('<tr><td>'+res.nome+'</td><td>'+res.cpf+'</td><td>'+res.rg+'</td><td>'+res.localizacao+'</td><td><input type="checkbox" name="mgcCheckbox" value="'+res.id+'" data-id="'+res.id+'"></td></tr>');

                            $('input[name=mccNomeCedente]').val('');
                            $('input[name=mccCpfCedente]').val('');
                            $('input[name=mccRgCedente]').val('');
                            $('input[name=mccOrgaoEmissorRgCedente]').val('');
                            $('input[name=mccNacionalidade]').val('');
                            $('input[name=mccEstadoCivil]').val('');
                            $('input[name=mccCep]').val('');
                            $('input[name=mccLogradouro]').val('');
                            $('input[name=mccNumero]').val('');
                            $('input[name=mccComplemento]').val('');
                            $('input[name=mccBairro]').val('');
                            $('input[name=mccEstado]').val('');
                            $('input[name=mccCidade]').val('');
                        }else{
                            Swal.fire(
                                'Erro',
                                'Ocorreu um erro ao salvar os dados do cedente. Tente novamente',
                                'error'
                            );
                        }
                    },error: function(err){
                        Swal.fire(
                            'Erro',
                            'Ocorreu um erro ao salvar os dados do cedente. Tente novamente',
                            'error'
                        );
                    },complete: function(){
                        element.removeAttr('disabled');
                    }
                });
            });
        });
    </script>
</body>
</html>
