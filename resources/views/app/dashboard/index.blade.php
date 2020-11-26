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
    </style>
</head>
<body>
    @include('app.include')
	<!-- Main Wrapper -->
    <div class="main-wrapper">

		@yield('header')

		<!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">

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
                <div class="row board-view-header" style="margin-bottom: 10px !important;">

					<div class="col-12 text-left">
                        <div style="display: flex; flex-direction: row; justify-content: flex-start;">
                            @if ($role_id == 1)
        						<!-- <a href="#" class="btn btn-white float-left ml-2" data-toggle="modal" data-target="#modalNovoProcesso">
                                    <i class="fa fa-plus"></i> Criar novo processo
                                </a> -->
                            @endif

                            <a style="background-color: #FFFFFF; border: 1px solid #000; color: #000 !important" href="#" class="btn btn-warning text-white float-left" id="abre_filtros_agenda" data-toggle="modal" data-target="#modalFiltroTipoAgenda">
                                <i class="la la-filter"></i> Alterar Tipo de Agenda
                            </a>

                            <a style="background-color: #FFFFFF; border: 1px solid #000; color: #000 !important" href="#" class="btn btn-info text-white float-left ml-4" id="toggleFiltrosTexto">
                                <i class="la la-filter"></i> Filtrar por dados do processo
                            </a>

                            <a style="background-color: #FFFFFF; border: 1px solid #000; color: #000 !important" href="#" class="btn btn-info text-white float-left ml-4" id="agendaAtual">
                                Agenda Atual: <span id="textoAgendaAtual"></span>
                            </a>
                        </div>


                    </div>
                </div>

            <div class="row filter-row" id="rowFiltros" style="margin-top: 20px; display: none;">
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
               <div class="col-sm-6 col-md-3">
                  <div class="form-group form-focus focused">
                     <select name="filtroIdFuncionario" id="filtroIdFuncionario" class="form-control floating">
                        <option value=""># Selecione um funcionário para filtrar</option>
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
               <div class="col-sm-6 col-md-3">
                  <div class="form-group form-focus focused">
                     <select name="filtroValorPrecatorio" id="filtroValorPrecatorio" class="form-control floating">
                        <option value=""># Selecione o valor do precatório</option>
                        <option value="100000.00">Acima de R$ 100.000,00</option>
                        <option value="200000.00">Acima de R$ 200.000,00</option>
                        <option value="300000.00">Acima de R$ 300.000,00</option>
                        <option value="400000.00">Acima de R$ 400.000,00</option>
                        <option value="500000.00">Acima de R$ 500.000,00</option>
                        <option value="750000.00">Acima de R$ 700.000,00</option>
                        <option value="1000000.00">Acima de R$ 1.000.000,00</option>
                        <option value="1250000.00">Acima de R$ 1.250.000,00</option>
                        <option value="1500000.00">Acima de R$ 1.500.000,00</option>
                        <option value="1750000.00">Acima de R$ 1.750.000,00</option>
                        <option value="2000000.00">Acima de R$ 2.000.000,00</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-6 col-md-3">
                  <div class="form-group form-focus">
                     <input class="form-control floating" type="text" name="filtroDataProcesso" id="filtroDataProcesso">
                     <label class="focus-label">Data do Processo</label>
                  </div>
               </div>

               <div class="col-sm-6 col-md-3">
                  <a href="#" class="btn btn-success btn-block" id="btnFiltrar"><i class="la la-search"></i> Procurar </a>
               </div>
            </div>


							<div class="kanban-cont">
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

                            <div class="mb-3 mt-3"><button type="button" id="enviarSms" class="btn btn-success">Enviar SMS</button></div>
                        </div>
                    </div>
                    <div class="content-full tab-pane" id="tab2">
                        <p>Ligações</p>
                    </div>
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
                z-index: 10000;
                top: 0;
                right: 0;
                background-color: #FFFFFF;
                overflow-x: hidden;
                padding-top: 60px;
                transition: 0.5s;
            }
            .sidepanel .closebtn {
                position: absolute;
                top: 10px;
                right: 25px;
                font-size: 36px;
                margin-left: 50px;
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
<div id="modalEditarProcesso" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-fair" style="">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title">Visualizar Processo</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">

                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified">
                    <li class="nav-item"><a class="nav-link active" href="#tabDadosProcesso" data-toggle="tab">Dados do Processo</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabCalculadora" data-toggle="tab">Calculadora</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabAgendamentoContato" data-toggle="tab">Agendamento de Contato</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabDocumentos" data-toggle="tab">Documentos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabContratos" data-toggle="tab">Gerar Contratos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabCedentes" data-toggle="tab">Cadastrar Cedentes</a></li>
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
                        							<input class="form-control" type="text" name="mepCabecaAcao" id="mepCabecaAcao" readonly="readonly">
                        						</div>
                        					</div>
                                        </div>

										<div class="row">
                                            <div class="col-sm-12">
                        						<div class="form-group">
                        							<label>Entidade Devedora</label>
                        							<input class="form-control" type="text" name="mepEntidade" id="" readonly="readonly">
                        						</div>
                        					</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Nome do Cliente</label>
                        							<input class="form-control" type="text" name="mepRequerente" id="mepRequerente" readonly="readonly">
                        						</div>
                        					</div>
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>CPF</label>
                        							<input class="form-control" type="text" name="mepCpf" id="mepCpf" readonly="readonly">
                        						</div>
                        					</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Número do Processo</label>
                        							<input class="form-control" type="text" name="mepNumeroProcesso" id="mepNumeroProcesso" readonly="readonly">
                                                    <a href="" id="mepexternallink" target="_blank" ><i class="fa fa-external-link" aria-hidden="true"></i></a>
                        						</div>
                        					</div>
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Ordem Cronológica</label>
                        							<input class="form-control" type="text" name="mepOrdemCronologica" id="mepOrdemCronologica" readonly="readonly">
                        						</div>
                        					</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>EP do Processo</label>
                        							<input class="form-control" type="text" name="mepExp" id="mepExp" readonly="readonly">
                        						</div>
                        					</div>
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Indice de Data Base</label>
                        							<div class="cal-icon">
                        								<input class="form-control datetimepicker" type="text" name="mepIndiceDataBase" id="mepIndiceDataBase" readonly="readonly">
                        							</div>
                        						</div>
                        					</div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Valor Principal</label>
                        							<input class="form-control" type="text" name="mepValorPrincipal" id="mepValorPrincipal" readonly="readonly">
                        						</div>
                        					</div>
                                            <div class="col-sm-6">
                        						<div class="form-group">
                        							<label>Valor Juros</label>
                        							<input class="form-control" type="text" name="mepValorJuros" id="mepValorJuros" readonly="readonly">
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
                                                    '5' => 'Negociação',
                                                    '6' => 'Cliente Avaliando',
                                                    '7' => 'Parecer',
                                                    '8' => 'Cessão Agendada',
                                                    '9' => 'Pagamento Realizado'
                                                ], null, ['class' => 'custom-select', 'id' => 'mepSituacao', 'readonly' => 'readonly']) }}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <button type="button" name="btnSalvarEdicao" id="btnSalvarEdicao" class="btn btn-primary submit-btn" style="display: none;">Salvar Edição</button>
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
                            					<div class="chat-contents" style="background-color: #426a75">
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
                            								<div class="message-area">
                            									<div class="input-group">
                            										<textarea class="form-control" placeholder="Digite sua mensagem aqui..." id="mensagemChat"></textarea>
                            										<span class="input-group-append">
                            											<button class="btn  btn-outline-dark" type="button" id="btnEnviarChat"><i class="fa fa-send"></i></button>
                            										</span>
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
										<h5 class="card-title mb-0">Telefones</h5>
									</div>
									<div class="card-body">
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
                        						<div class="form-group">
                        							<label>Data de Emissão do Precatório</label>
                        							<div class="cal-icon">
                        								<input class="form-control datetimepicker" type="text" name="mcDataEmissaoPrecatorio" id="mcDataEmissaoPrecatorio">
                        							</div>
                        						</div>
                                                <div class="form-group">
                        							<label>Data de Vencimento</label>
                        							<div class="cal-icon">
                        								<input class="form-control datetimepicker" type="text" name="mcDataVencimento" id="mcDataVencimento">
                        							</div>
                        						</div>
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
                                            <div class="col-md-3">
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
                                            </div>
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
                        							<label>Total Cedido</label>
                        							<input class="form-control" type="text" name="mcCessaoSemHonorarios" id="mcCessaoSemHonorarios">
                        						</div>
                        					</div>
                                            <div class="col-sm-6">
                                                <div class="card">
                									<div class="card-body">
                										<div class="d-flex justify-content-between mb-3">
                											<div>
                												<span class="d-block">Total Cedido</span>
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
                                                <button type="button" name="btnAtualizarCalculos" id="btnAtualizarCalculos" class="btn btn-primary submit-btn">Atualizar Calculos</button>
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
                                                <button type="button" class="btn  btn-outline-info mac_submit" id="mac_submit">Salvar Lembrete</button>
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
                                                <button type="button" name="btnEnviarArquivo" id="btnEnviarArquivo" class="btn btn-primary submit-btn">Enviar Arquivo</button>
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
                                        <button type="button" class="btn btn-primary" id="btnCadastrarCedenteProcesso">Cadastrar Cedente</button>
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
                                    class="btn btn-primary">Gerar Contrato Selecionado</button>
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
                                    class="btn btn-info">Gerar Contrato com cedentes selecionados</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer" style="justify-content: flex-end;">
                <button type="button" id="abrirSms" class="btn  btn-outline-dark btn-sm">Guia SMS</button>
                <button type="button" id="abrirSms" class="btn btn-secondary btn-sm"><span id="mepDataUltimaAbertura"></span></button>

            </div>
        </div>
    </div>
</div>
<!-- Fim do Editar Processo -->

<!-- Modal Filtro de Tipo de Agenda -->
<div id="modalFiltroTipoAgenda" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Selecionar o Tipo de Agenda</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">

                <form name="formFiltroTipoProcesso">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Selecione o tipo de processo</label>
                            <select name="filtroTipoProcesso" id="filtroTipoProcesso" class="form-control">
                                <option value=""># Todos os tipos</option>
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
                                <option value=""># Todos</option>
                            </select>
                        </div>
                    </div>

                    <div class="submit-section">
    					<button class="btn btn-info submit-btn" type="button" id="btnConfirmarFiltroAgenda">Filtrar</button>
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
                <h4 class="modal-title">Adicionar Processo manualmente</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
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

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label>Colaborador Responsável</label>
                        {{ Form::select('mnpColaborador', $arrayColaboradores, null, ['class' => 'custom-select']) }}

                    </div>
                </div>

                <div class="submit-section">
					<button class="btn btn-primary submit-btn" type="button" id="mnpBtnSalvar">Salvar Processo</button>
				</div>

            </div>
        </div>
    </div>
</div>

<div id="modalListaNotificacoes" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Notificações de Hoje - {{ date('d/m/Y') }}</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">

                <table class="table">
                    <thead>
                        <th>Colaborador</th>
                        <th>Comentário</th>
                        <th>Numero do Processo</th>
                        <th>Cabeça da Ação</th>
                    </thead>
                    <tbody id="mln_tbody">

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
   <script src="/assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
   <script src="/assets/js/app.js"></script>

   <script type="text/javascript">
        $(document).ready(function(e){
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
                            $('#mln_tbody').append('<tr><td>'+val.nome+'</td><td>'+val.comentario+'</td><td>'+val.processo_de_origem+'</td><td>'+val.cabeca_de_acao+'</td></tr>');

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
                        console.log(res);
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
                        isFlashSms: isFlashSms
                    },success: function(res){
                        console.log('sucesso');
                        console.log(res);

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
                        console.log('erro');
                        console.log(err);
                    },complete: function(){
                        console.log('complete');
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

                console.log(isPhoneSelected);
                console.log(selectedMensagem);

                if(isPhoneSelected == true && selectedMensagem != ''){
                    $('#enviarSms').removeAttr('disabled');
                }
            });

            /* SMS */
            $('#abrirSms').click(function(e){
                var idprocesso = $('#mepIdProcesso').val();
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
                $('#mySidepanel').css('width', '500px');
            });

            $('#closeSidepanel').click(function(e){
                $('#mySidepanel').css('width', '0px');
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
                $('#rowFiltros').toggle(200);
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

            $('#filtroValorPrecatorio').change(function(e){
                if( $(this).val() == '' ){
                    $('.divProcesso').each(function(e){
                        $(this).show();
                    });
                }else{
                    var valor = $('#filtroValorPrecatorio option:selected').val();

                    $('.divProcesso').each(function(e){
                        var dataValorPrecatorio = $(this).attr('data-valorprecatorio');

                        dataValorPrecatorio = parseFloat(dataValorPrecatorio);
                        valor = parseFloat(valor);

                        /*console.log(dataValorPrecatorio);
                        console.log(valor);*/
                        if( dataValorPrecatorio > valor ){
                           $(this).show();
                        }else{
                           $(this).hide();
                        }
                    })
                }
            });

            $('#btnFiltrar').click(function(e){
                var nome = $('input[name=filtroNome]').val();
                var numero_processo = $('input[name=filtroNumeroProcesso]').val();

                $('.divProcesso').each(function(e){
                    $(this).show();
                });

                if(nome == '' && numero_processo == ''){
                    $('.divProcesso').each(function(e){
                        $(this).show();
                    });
                }
                $('.divProcesso').each(function(e){
                    var datanome = $(this).attr('data-nome');
                    var datanp = $(this).attr('data-np');


                    if(nome != ''){
                        if (datanome.toLowerCase().indexOf(nome.toLowerCase()) < 0){
                            $(this).hide();
                        }
                    }

                    if(numero_processo != ''){
                        if (datanp.indexOf(numero_processo) < 0){
                            $(this).hide();
                        }
                    }
                })
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
                    somaBox0 = somaBox0 + valor;
                    $('.ss0').html('('+totalBox0+') R$ '+(somaBox0).toLocaleString('pt-BR'));
                });

                $('#box1 .card').each(function(e){
                    totalBox1 = totalBox1 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox1 = parseFloat(somaBox1);
                    somaBox1 = somaBox1 + valor;
                    $('.ss1').html('('+totalBox1+') R$ '+(somaBox1).toLocaleString('pt-BR'));
                });

                $('#box2 .card').each(function(e){
                    totalBox2 = totalBox2 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox2 = parseFloat(somaBox2);
                    somaBox2 = somaBox2 + valor;
                    $('.ss2').html('('+totalBox2+') R$ '+(somaBox2).toLocaleString('pt-BR'));
                });

                $('#box3 .card').each(function(e){
                    totalBox3 = totalBox3 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox3 = parseFloat(somaBox3);
                    somaBox3 = somaBox3 + valor;
                    $('.ss3').html('('+totalBox3+') R$ '+(somaBox3).toLocaleString('pt-BR'));
                });


                $('#box5 .card').each(function(e){
                    totalBox5 = totalBox5 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox5 = parseFloat(somaBox5);
                    somaBox5 = somaBox5 + valor;
                    $('.ss5').html('('+totalBox5+') R$ '+(somaBox5).toLocaleString('pt-BR'));
                });

                $('#box6 .card').each(function(e){
                    totalBox6 = totalBox6 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox6 = parseFloat(somaBox6);
                    somaBox6 = somaBox6 + valor;
                    $('.ss6').html('('+totalBox6+') R$ '+(somaBox6).toLocaleString('pt-BR'));
                });

                $('#box7 .card').each(function(e){
                    totalBox7 = totalBox7 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox7 = parseFloat(somaBox7);
                    somaBox7 = somaBox7 + valor;
                    $('.ss7').html('('+totalBox7+') R$ '+(somaBox7).toLocaleString('pt-BR'));
                });

                $('#box8 .card').each(function(e){
                    totalBox8 = totalBox8 + 1;
                    var valor = $(this).attr('data-valor');
                    valor = parseFloat(valor);
                    somaBox8 = parseFloat(somaBox8);
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
        				console.log('Target ID: ' + targetList.attr('id'));

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
        				console.log('RECEIVE' + targetList.attr('id'));

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
        							console.log('sucesso');
        							console.log(res)
        						},error: function(err){
        							console.log('erro');
        							console.log(err)
        						},complete: function(){
        							console.log('complete');
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

            console.log(u_filtroTipoProcesso);
            console.log(u_filtroSubtipoProcesso);

            $('#filtroTipoProcesso').change(function(e){
                tipoAgenda = $(this).val();

                $.ajax({
                    url: '/app/agendas/recuperar-subtipo-ajax/' + tipoAgenda,
                    method: 'GET',
                    success: function(res){
                        if( res.status == 'ok' ){
                            $("#filtroSubtipoProcesso").html('');
                            $("#filtroSubtipoProcesso").append($("<option />").val('').text('# Todos'));

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

            if( u_filtroTipoProcesso != '' ){
               $('#filtroTipoProcesso').val(u_filtroTipoProcesso).trigger('change');
               tipoAgenda = u_filtroTipoProcesso;

               console.log('TipoAgenda = ' + tipoAgenda);
            }

            $('#filtroSubtipoProcesso').change(function(e){
                subtipoAgenda = $(this).val();

                console.log(tipoAgenda);
                console.log(subtipoAgenda);
            });

            $('#btnConfirmarFiltroAgenda').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.html('Aguarde! Carregandos dados');

                refiltrar();

                element.removeAttr('disabled');
                element.html('Filtrar');

                $('#modalFiltroTipoAgenda').modal('hide');
            })

            function refiltrar(){
                $('#box0').html('');
                $('#box1').html('');
                $('#box2').html('');
                $('#box3').html('');

                $('#box5').html('');
                $('#box6').html('');
                $('#box7').html('');
                $('#box8').html('');

                $('#textoAgendaAtual').html( $('#filtroTipoProcesso option:selected').text() + ' - ' + $('#filtroSubtipoProcesso option:selected').text() );

                $.ajax({
                    url: '/app/agenda/recupera-processos/1',
                    method: 'GET',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){

                            $.map( res.response, function( val, i ) {

                                $('#box0').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                    url: '/app/agenda/recupera-processos/2',
                    method: 'GET',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {

                                $('#box1').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                    url: '/app/agenda/recupera-processos/3',
                    method: 'GET',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box2').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                    url: '/app/agenda/recupera-processos/4',
                    method: 'GET',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box3').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                    url: '/app/agenda/recupera-processos/6',
                    method: 'GET',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box5').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                    url: '/app/agenda/recupera-processos/7',
                    method: 'GET',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box6').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                    url: '/app/agenda/recupera-processos/8',
                    method: 'GET',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box7').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                    url: '/app/agenda/recupera-processos/9',
                    method: 'GET',
                    data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                    success: function(res){
                        if(res.status == 'ok'){
                            $.map( res.response, function( val, i ) {
                                $('#box8').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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

            }


            $('input[name=mnpValorPrincipal]').mask('000.000.000.000.000,00', {reverse: true});
            $('input[name=mnpValorJuros]').mask('000.000.000.000.000,00', {reverse: true});
            $('input[name=mnpCpf]').mask('000.000.000-00');
            $('input[name=mnpNumeroProcesso]').mask('0000000-00.0000.0.00.0000');
            $('input[name=mepAdicionarTelefoneText]').mask('(00) 00000-0000');

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
                        mnpCabecaAcao: $('input[name=mnpCabecaAcao]').val(),
                        mnpRequerente: $('input[name=mnpRequerente]').val(),
                        mnpCpf: $('input[name=mnpCpf]').val(),
                        mnpNumeroProcesso: $('input[name=mnpNumeroProcesso]').val(),
                        mnpOrdemCronologica: $('input[name=mnpOrdemCronologica]').val(),
                        mnpExp: $('input[name=mnpExp]').val(),
                        mnpIndiceDataBase: $('input[name=mnpIndiceDataBase]').val(),
                        mnpValorPrincipal: $('input[name=mnpValorPrincipal]').val(),
                        mnpValorJuros: $('input[name=mnpValorJuros]').val(),
                        mnpColaborador: $('select[name=mnpColaborador] option:selected').val()
                    },
                    success: function(res){
                        if( res.status == 'ok' ){
                            $('input[name=mnpCabecaAcao]').val('');
                            $('input[name=mnpNumeroProcesso]').val('');
                            $('input[name=mnpValorPrincipal]').val('');
                            $('input[name=mnpValorJuros]').val('');
                            $('#modalNovoProcesso').modal('hide');

                            $('#box0').append('<div class="card panel" data-id="'+res.response.id+'">'+
                                '<div class="kanban-box">'+
                                    '<div class="task-board-header">'+
                                        '<span class="status-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">'+
                                            '<span>'+
                                                res.response.nome+
                                            '</span>'+
                                        '</span>'+
                                        '<div class="dropdown kanban-task-action">'+
                                            '<a href="#" data-id="'+res.response.id+'" class="clickShowHide">'+
                                                '<i class="fa fa-angle-down"></i>'+
                                            '</a>'+
                                        '</div>'+
                                    '</div>'+
                                    '<div class="task-board-body" data-id="'+res.response.id+'" data-ho="open">'+
                                        '<div class="kanban-footer">'+
                                            '<span class="task-info-cont">'+
                                                '<span class="task-date"><i class="fa fa-clock-o"></i> R$ '+res.response.valor+'</span>'+
                                                '<span class="task-priority badge bg-inverse-warning">Venda Avulsa</span>'+
                                            '</span>'+
                                        '</div>'+
                                        '<span class="botaoAcoes">'+
                                            '<span class="clickEditar" data-id="'+res.response.id+'"><i class="fa fa-edit"></i></span>'+
                                            '<span class="clickExcluir" data-id="'+res.response.id+'"><i class="fa fa-trash"></i></span>'+
                                        '</span>'+
                                    '</div>'+
                                '</div>'+
                            '</div>');
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
            $.ajax({
                url: '/app/agenda/recupera-processos/1',
                method: 'GET',
                data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                success: function(res){
                    if(res.status == 'ok'){

                        $.map( res.response, function( val, i ) {
                           console.log(val);
                            $('#box0').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                url: '/app/agenda/recupera-processos/2',
                method: 'GET',
                data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                success: function(res){
                    if(res.status == 'ok'){
                        $.map( res.response, function( val, i ) {
                            $('#box1').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                url: '/app/agenda/recupera-processos/3',
                method: 'GET',
                data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                success: function(res){
                    if(res.status == 'ok'){
                        $.map( res.response, function( val, i ) {
                            $('#box2').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                url: '/app/agenda/recupera-processos/4',
                method: 'GET',
                data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                success: function(res){
                    if(res.status == 'ok'){
                        $.map( res.response, function( val, i ) {
                            $('#box3').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                url: '/app/agenda/recupera-processos/6',
                method: 'GET',
                data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                success: function(res){
                    if(res.status == 'ok'){
                        $.map( res.response, function( val, i ) {
                            $('#box5').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                url: '/app/agenda/recupera-processos/7',
                method: 'GET',
                data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                success: function(res){
                    if(res.status == 'ok'){
                        $.map( res.response, function( val, i ) {
                            $('#box6').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                url: '/app/agenda/recupera-processos/8',
                method: 'GET',
                data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                success: function(res){
                    if(res.status == 'ok'){
                        $.map( res.response, function( val, i ) {
                            $('#box7').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                url: '/app/agenda/recupera-processos/9',
                method: 'GET',
                data: { subtipoAgenda: subtipoAgenda, tipoAgenda: tipoAgenda },
                success: function(res){
                    if(res.status == 'ok'){
                        $.map( res.response, function( val, i ) {
                            $('#box8').append('<div class="card panel clickEditar divProcesso" data-valor="'+val.valorBruto+'" data-id="'+val.id+'" data-nome="'+val.nome+'" data-np="'+val.numeroProcesso+'" data-userid="'+val.userid+'" data-valorprecatorio="'+val.valorPrecatorioTotal+'" data-ordem_cronologica="'+val.ordem_cronologica+'" style="background-color: #'+val.backgroundColor+'; color: #'+val.textColor+'">'+
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
                var mepNomeCliente = $('#mepRequerente').val();
                var mepCpfCliente = $('#mepCpf').val();
                var mepCampoNumeroProcesso = $('#mepNumeroProcesso').val();
                var mepOrdemCronologica = $('#mepOrdemCronologica').val();
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
                        mepNomeCliente: mepNomeCliente,
                        mepCpfCliente: mepCpfCliente,
                        mepCampoNumeroProcesso: mepCampoNumeroProcesso,
                        mepOrdemCronologica: mepOrdemCronologica,
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
                        console.log('err');
                        console.log(err);
                    },complete: function(){
                        element.removeAttr('disabled');
                        element.html('Salvar Edição');
                    }
                });

            });

            $('body').on('click', '.clickLigarApi', function(e){
                var telefone = $(this).attr('data-telefone');

                window.open('https://novoapp.fairconsultoria.com.br/app/dispara-ligacao?telefone='+telefone, '_blank');
            });


            $('body').on('click', '.clickEditar', function(e){
                var id = $(this).attr('data-id');

                $('#modalEditarProcesso').modal('show');
                $('.chats').html('');
                $('#tbodyTelefones').html('');
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
                        $('#mepNumeroProcesso').html( result.processo_de_origem );
                        $('#mepCabecaAcao').val( result.cabeca_de_acao );
                        $('#mepRequerente').val( result.reqte );
                        $('#mepCpf').val( result.cpf );
                        $('#mepNumeroProcesso').val( result.processo_de_origem );

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

                        $.map( result.arrayNotificacoes, function(res, i){
                            $('#mac_tbody').append('<tr><td>'+res.data_agendamento+'</td><td>'+res.comentario+'</td><td><a href="#!" class="btn btn-outline-danger btn-sm mac_excluir_item" data-id="'+res.id+'"><i class="fa fa-trash"></i>&nbsp;Excluir </a></td></tr>')
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
                                            '<a class="dropdown-item clickAbrirWhatsapp" href="#" data-id="'+val.id+'"><i class="fa fa-whatsapp m-r-5"></i> Whatsapp Web</a>'+
                                            '<a class="dropdown-item clickLigarApi" href="#" data-id="'+val.id+'" data-telefone="'+val.telefone+'"><i class="fa fa-phone m-r-5"></i> Ligar Jive</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>');
                        });
                    },error: function(err){
                        console.log(err);
                    },complete: function(){

                    }
                });

                $.ajax({
                    url: '/app/agenda/recupera-dados-processo/' + id,
                    method: 'GET',
                    success: function(result){
                        console.log(result);
                        console.log('sucesso');

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
                        $('#mcDataVencimento').val(result.dataVencimento);
                        $('#mcDataEmissaoPrecatorio').val(result.dataEmissaoPrecatorios);

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
                        console.log(err);

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
                        console.log(result);

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
                        console.log('sucesso envio arquivo');
                        console.log(res);

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
                        console.log('erro envio arquivo');
                        console.log(err);
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

                $.ajax({
                    url: '/app/agenda/salvar-telefone',
                    method: 'POST',
                    data: {
                        idprocesso: $('#mepIdProcesso').val(),
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
                                            '<a class="dropdown-item clickAbrirWhatsapp" href="#" data-id="'+res.id+'"><i class="fa fa-whatsapp m-r-5"></i> Whatsapp Web</a>'+
                                            '<a class="dropdown-item clickLigarApi" href="#" data-id="'+res.id+'" data-telefone="'+res.telefone+'"><i class="fa fa-phone m-r-5"></i> Ligar Jive</a>'+
                                        '</div>'+
                                    '</div>'+
                                '</td>'+
                            '</tr>');
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Ocorreu um erro ao cadastrar o telefone. Atualize a página e tente novamente'
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
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: 'Ocorreu um erro ao cadastrar o email. Atualize a página e tente novamente'
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
