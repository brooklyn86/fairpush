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
    <link rel="stylesheet" href="/assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/bootstrap-datetimepicker.min.css">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
    @include('app.include')
	<!-- Main Wrapper -->
    <div class="main-wrapper">

		@yield('header')

		@yield('sidebar')

		<!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid">

				<!-- Page Header -->
                <div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title">Processos Avulsos</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="/">Robo</a></li>
								<li class="breadcrumb-item active">Lista de Processos Avulsos</li>
							</ul>
						</div>
						<div class="col-auto float-right ml-auto">
							<!--<a href="/app/setores/cadastrar" class="btn add-btn btnCadastrarNovo"><i class="fa fa-plus"></i> Cadastrar novo setor</a> -->
						</div>
					</div>
				</div>


				<!-- /Page Header -->

				<!-- Content Starts -->
                <div class="row">
                <div class="row">
					<div class="col-sm-12">
						<div class="card mb-0">
							<div class="card-header">
								<h4 class="card-title mb-0">Processos Avulsos</h4>
								<p class="card-text">
									Lista de Processos cadastrados
								</p>
							</div>
							<div class="card-body">
                                <?php
                                    if(Session::has('sucesso')){
                                        echo '<div class="alert alert-success">'.Session::get('sucesso').'</div>';
                                    }
                                    if(Session::has('erro')){
                                        echo '<div class="alert alert-danger">'.Session::get('erro').'</div>';
                                    }
                                ?>
								<div class="table-responsive">
									<table class="datatable table table-stripped mb-0">
										<thead>
											<tr>
												<th>Id</th>
												<th>Processo de Origem</th>
                                                <th>Ordem cronológica</th>
                                                <th>Req</th>
                                                <th>Entidade Devedora</th>
                                                <th>CPF</th>
                                                <th>Valor Principal</th>
                                                <th>Juros</th>
                                                <th>Condenação</th>
                                                <th>Data Base</th>
                                                <th>Ações</th>
											</tr>
										</thead>
                                        <tbody>
                                            @foreach($sql as $p)
                                            <tr>
                                              <td>{{$p->id}}</td>
                                              <td>{{$p->processo_de_origem}}</td>
                                              <td>{{$p->ordem_cronologica}}</td>
                                              <td>{{$p->reqte}}</td>
                                              <td>{{$p->entidade_devedora}}</td>
                                              <td>@if(isset($p->cpf)) {{$p->cpf}} @else Processo com cnpj </br>   @endif </td>
                                              <td>@if(isset($p->principal_bruto))
                                               R$ {{number_format($p->principal_bruto,2,',','.')}} @else Não informado! </br>  @endif </td>
                                              <td>@if(isset($p->juros_moratorio)) R$ {{number_format($p->juros_moratorio,2,',','.')}}
                                               @else Não informado! </br>  @endif </td>
                                              <?php $total_condenacao =preg_split('/\s+/',$p->total_condenacao);?>
                                              @if(isset($total_condenacao[1]))
                                              <td>R$ {{number_format($total_condenacao[1],2,',','.')}}</td>
                                              @else
                                              <td>R$ {{number_format($p->total_condenacao,2,',','.')}}</td>

                                              @endif
                                              <td><?php echo date('d/m/Y', strtotime($p->data_base));?></td>

                                              <td>
                                                  <?php
                                                    if( $p->is_enviado_agenda == 1 ){
                                                        $class = 'btn btn-outline-dark dropdown-toggle';
                                                    }else{
                                                        $class = 'btn btn-primary dropdown-toggle';
                                                    }
                                                  ?>
                                                  <div class="btn-group">
                                                      <button type="button" class="{{ $class }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações</button>
                                                      <div class="dropdown-menu">
                                                            <?php
                                                                if( $p->is_enviado_agenda == 1 ){
                                                                    echo '<a class="dropdown-item clickEnviarAgenda" data-id="'.$p->id.'" href="#">Enviar Agenda / Editar</a>';
                                                                }else{
                                                                    echo '<a class="dropdown-item clickEnviarAgenda" data-id="'.$p->id.'" href="#">Enviar Agenda / Editar</a>';
                                                                }
                                                            ?>
                                                            
                                                            <a class="dropdown-item clickRemoverAgenda" data-id="{{$p->id}}" href="#">Remover da agenda</a>

                                                        </ul>
                                                      </div>
                                                  </div>
                                              </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
				<!-- /Content End -->
            </div>
        </div>
    </div>
	<!-- /Main Wrapper -->

    <div id="modal_caderno_detalhes" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-fair" style="">
            <div class="modal-content" >
                <div class="modal-header">
                    <h4 class="modal-title">Prévia do Processo</h4>
    				<button type="button" class="close" data-dismiss="modal">&times;</button>
    			</div>
    			<div class="modal-body">


                    {{ Form::open(['url' => 'app/robo/envia-agenda', 'id' => 'formEnviaAgenda']) }}

                    <input type="hidden" name="hidden_id">

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Processo de Origem</label>
                            {{ Form::text('processo_de_origem', null, ['class' => 'form-control campo_txt', 'placeholder' => 'Numero do Processo de Origem']) }}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Ordem Cronológica</label>
                            {{ Form::text('campo3', null, ['class' => 'form-control campo_txt', 'placeholder' => 'Ordem Cronológica']) }}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Vara</label>
                            {{ Form::text('campo4', null, ['class' => 'form-control campo_txt', 'placeholder' => 'Ordem Cronológica']) }}
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Nome Requerente</label>
                            {{ Form::text('campo5', null, ['class' => 'form-control campo_txt', 'placeholder' => 'Nome do Requerente']) }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>CPF Requerente</label>
                            {{ Form::text('cpf', null, ['class' => 'form-control campo_txt', 'placeholder' => 'CPF do Requerente']) }}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label>Advogados</label>
                            {{ Form::text('campo6', null, ['class' => 'form-control campo_txt', 'placeholder' => 'Advogados']) }}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Entidade Devedora</label>
                            {{ Form::text('campo7', null, ['class' => 'form-control campo_txt', 'placeholder' => 'Entidade Devedora']) }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>CD Processo</label>
                            {{ Form::text('cdProcesso', null, ['class' => 'form-control campo_txt', 'placeholder' => '']) }}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Natureza</label>
                            {{ Form::text('natureza', null, ['class' => 'form-control campo_txt', 'placeholder' => 'Natureza']) }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Data Base</label>
                            {{ Form::text('data_base', null, ['class' => 'form-control campo_txt', 'placeholder' => '']) }}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Requisitado</label>
                            {{ Form::text('requisitado', null, ['class' => 'form-control campo_txt', 'placeholder' => 'Requisitado']) }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Principal Bruto</label>
                            {{ Form::text('principal_bruto', null, ['class' => 'form-control campo_txt', 'placeholder' => '']) }}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Total Condenação</label>
                            {{ Form::text('total_condenacao', null, ['class' => 'form-control campo_txt', 'placeholder' => '']) }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Juros Moratório</label>
                            {{ Form::text('juros_moratorio', null, ['class' => 'form-control campo_txt', 'placeholder' => '']) }}
                        </div>
                    </div>

                    <div id="escolheAgenda" style="display: none;">
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

                                </select>
                            </div>
                        </div>
                    </div>

                    {{ Form::close() }}

                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-outline-dark mr-3" type="button" id="btnEnviarAgenda"><i class="fa fa-send"></i> Enviar Agenda</button>

                            <button class="btn btn-success" type="button" id="btnSalvarAlteracoes"><i class="fa fa-save"></i> Salvar Alteracoes</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
	<script src="/assets/js/jquery.slimscroll.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
	<script src="/assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/js/moment.min.js"></script>
    <script src="/assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/assets/js/jquery.mask.min.js"></script>
	<script src="/assets/js/app.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script type="text/javascript">
        $(document).ready(function(e){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('input[name=juros_moratorio]').mask('999.999.999.999,99');
            $('input[name=principal_bruto]').mask('999.999.999.999,99');
            $('input[name=requisitado]').mask('999.999.999.999,99');
            $('input[name=total_condenacao]').mask('999.999.999.999,99');

            $('#btnEnviarAgenda').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.html('Aguarde... ');

                $('#formEnviaAgenda').attr('action', 'https://novoapp.fairconsultoria.com.br/app/robo/envia-agenda');
                $('#formEnviaAgenda').submit()
            });

            $('#btnSalvarAlteracoes').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.html('Aguarde... ');

                $('#formEnviaAgenda').attr('action', 'https://novoapp.fairconsultoria.com.br/app/robo/salvar-alteracoes');
                $('#formEnviaAgenda').submit()
            });

            $('#btn1').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.html('Aguarde... ');

                $('#form1').submit();
            });

            $('.clickEnviarAgenda').click(function(e){
                var id = $(this).attr('data-id');

                $('#modal_caderno_detalhes').modal('show');

                $.ajax({
                    url: '/app/robo/previa-agenda/' + id,
                    method: 'GET',
                    success: function(res){
                        if(res.status == 'ok'){
                            $('input[name=hidden_id]').val(res.response.id);
                            $('input[name=campo2]').val(res.response.vara);
                            $('input[name=campo3]').val(res.response.ordem_cronologica);
                            $('input[name=campo4]').val(res.response.vara);
                            $('input[name=campo5]').val(res.response.reqte);
                            $('input[name=campo6]').val(res.response.advogado);
                            $('input[name=campo7]').val(res.response.entidade_devedora);
                            $('input[name=cdProcesso]').val(res.response.cdProcesso);
                            $('input[name=cpf]').val(res.response.cpf);
                            $('input[name=data]').val(res.response.data);
                            $('input[name=data_base]').val(res.response.data_base);
                            $('input[name=juros_moratorio]').val(res.response.juros_moratorio);
                            $('input[name=natureza]').val(res.response.natureza);
                            $('input[name=principal_bruto]').val(res.response.principal_bruto);
                            $('input[name=processo_de_origem]').val(res.response.processo_de_origem);
                            $('input[name=requisitado]').val(res.response.requisitado);
                            $('input[name=total_condenacao]').val(res.response.total_condenacao);

                            if(res.response.is_enviado_agenda == 1){
                                $('#btnEnviarAgenda').hide();
                                $('#escolheAgenda').hide();
                            }else{
                                $('#btnEnviarAgenda').show();
                                $('#escolheAgenda').show();
                            }
                        }else{
                            $('#modal_caderno_detalhes').modal('hide');
                        }
                    },error: function(err){
                        $('#modal_caderno_detalhes').modal('hide');
                    },complete: function(){

                    }
                });
            });
                $('.clickRemoverAgenda').click(function(e){
                var id = $(this).attr('data-id');
                $.ajax({
                    url: '/app/robo/remover-agenda/' + id,
                    method: 'GET',
                    success: function(res){
                        if(res.status == 'ok'){
                            $(this).remove();
                        }else{
                            $('#modal_caderno_detalhes').modal('hide');
                        }
                    },error: function(err){
                        $('#modal_caderno_detalhes').modal('hide');
                    },complete: function(){

                    }
                });
                /*Swal.fire({
                    title: 'Enviar Processo Agenda?',
                    text: "Tem certeza que deseja enviar esse processo para agenda?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = '/app/robo/enviar-agenda/' + id;
                    }
                });*/
           
            });
            $('#filtroTipoProcesso').change(function(e){
               tipoAgenda = $(this).val();

               $.ajax({
                  url: '/app/agendas/recuperar-subtipo-ajax/' + tipoAgenda,
                  method: 'GET',
                  success: function(res){
                     console.log(res);
                     if( res.status == 'ok' ){
                        $("#filtroSubtipoProcesso").html('');


                        var $dropdown = $("#filtroSubtipoProcesso");
                        $.each(res.response, function() {
                           $dropdown.append($("<option />").val(this.id).text(this.titulo));
                        });
                     }else{
                        updateNotification('Ocorreu um erro ao recuperar os dados', 'danger', 'danger');
                     }
                  },error: function(err){
                     console.log(err);
                  }
               });
            });

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

            $('.click_roda_robo').click(function(e){
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Iniciar o Crawler?',
                    text: "Tem certeza que deseja iniciar o crawler nesse grupo de processos?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = '/app/robo/iniciar-crawler/' + id;
                    }
                });
            });

            $('.click_processos_lido').click(function(e){
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Iniciar a leitura de processos?',
                    text: "Tem certeza que deseja iniciar a leitura dos processos?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = '/app/robo/iniciar-leitura/' + id;
                    }
                });
            });
        });
    </script>
</body>
</html>
