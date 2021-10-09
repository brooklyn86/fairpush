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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

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
							<h3 class="page-title">Envio de Arquivo para extração de certidão</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="/">Inicio</a></li>
								<li class="breadcrumb-item active">Envio de Arquivo para extração de certidão</li>
							</ul>
						</div>
						<div class="col-auto float-right ml-auto">
							<!--<a href="/app/setores/cadastrar" class="btn add-btn btnCadastrarNovo"><i class="fa fa-plus"></i> Cadastrar novo setor</a> -->
						</div>
					</div>
				</div>


                <div class="row">
					<div class="col-sm-12">
						<div class="card mb-0">
							<div class="card-header">
								<h4 class="card-title mb-0">Extração de certidão</h4>
								<p class="card-text">
									Envie um arquivo no formato excel para a extração de certidão
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
                                    <div class="input-group mb-3">
                                        <form action="/app/certificacao" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <input type="file" name="file" class="form-control" id="inputGroupFile02">
                                            </div>
                                            <input type="submit" class="btn btn-dark" id="inputGroupFile02" />

                                        </form>
                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
					<div class="col-sm-12">
						<div class="card mb-0">
							<div class="card-header">
								<h4 class="card-title mb-0">Captura de certidão</h4>
								<p class="card-text">
									Informe o CPF para recuperar os arquivos da ação anterior
								</p>
							</div>
							<div class="card-body">
                                <div class="form-group">
                                    <input type="text" name="cpf" class="form-control" id="cpfCertificado">
                                </div>
                                <input style="margin-bottom:20px;" type="button" class="btn btn-dark" id="cpfCertificadoSubmit" value="Recuperar Certidões"/>

								<div class="table-responsive">

                                <table class="table">
                                    <thead>
                                        <tr>
                                        <th scope="col">Arquivo</th>
                                        <th scope="col">Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody id="certificados">
                                    </tbody>
                                </table>    
                            </div>
                        </div>
                    </div>
                </div>
                
				<!-- /Content End -->
            </div>
        </div>
    </div>
	<!-- /Main Wrapper -->

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

            $('.clickEditarAgenda').click(function(e){
                var id = $(this).attr('data-id');

                $('#modal_caderno_detalhes').modal('show');

                $.ajax({
                    url: '/app/robo/previa-agenda-federais/' + id,
                    method: 'GET',
                    success: function(res){
                        if(res.status == 'ok'){
                            console.log(res);
                            $('input[name=hidden_id]').val(res.response.id);
                            $('input[name=ordem_cronologica]').val(res.response.ordem_cronologica);
                            $('input[name=entidade_devedora]').val(res.response.entidadeDevedora);
                            $('input[name=vara]').val(res.response.vara);
                            $('input[name=reqte]').val(res.response.reqte);
                            $('input[name=advogado]').val(res.response.advogado);
                            $('input[name=campo7]').val(res.response.campo7);
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

            $('#cpfCertificadoSubmit').click(function(e){

                $('#certificados').html('');
                var cpfCertificado = $('#cpfCertificado').val()
                $.ajax({
                    url: '/app/getcertificacao/?cpf=' + cpfCertificado,
                    method: 'GET',
                    success: function(res){
                        var render = '';
                        res.map((item) => {
                            render += '<tr><td>'+item.name+'</td><td><a href="'+item.url+'" target="_blank">Baixar</a></tr>';
                        });
                        $('#certificados').append(render);
                    },error: function(err){
                        $('#modal_caderno_detalhes').modal('hide');
                    },complete: function(){

                    }
                });
            });
            $('.clickEnviarAgenda').click(function(e){
                var element = $(this);
                var id = element.attr('data-id');
                $.ajax({
                    url: '/app/robo/enviar-agenda-federais/' + id,
                    method: 'GET',
                    success: function(res){
                        if(res.error){
                            swal.fire({
                                    title: "Falha!",
                                    text: res.message,
                                    icon: "error",
                                    button: "Ok",
                                });
                        }else{
                            element.hide();
                        }
                    },error: function(err){
                       
                    },complete: function(){

                    }
                });
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
