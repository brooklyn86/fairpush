<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="">
	<meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <title>FairConsultoria</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">

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
							<h3 class="page-title">Tipo de Agenda</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="/">Agenda</a></li>
								<li class="breadcrumb-item active">Selecionar tipo de agenda</li>
							</ul>
						</div>
					</div>
				</div>


				<!-- /Page Header -->

				<!-- Content Starts -->
            <div class="row">
				   <div class="col-sm-12">
						<div class="card mb-0">
							<div class="card-header">
								<h4 class="card-title mb-0">Tipo de Agenda</h4>
								<p class="card-text">
								                   Selecione o tipo de Agenda
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

                     @if ($errors->any())
                        <div class="alert alert-danger">
                            <h4><strong>Ocorreu um erro ao cadastrar. Verifique os campos abaixo e tente novamente</strong></h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                     @endif

								{{ Form::open(['url' => 'app/dashboard', 'id' => 'form1', 'method' => 'GET']) }}
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

                           <div class="form-row">
                               <div class="col-md-12">
                                   <button type="button" class="btn btn-primary" id="btn1">Enviar</button>
                               </div>
                           </div>
                                {{ Form::close() }}
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
   <script src="/assets/js/app.js"></script>

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

   <script type="text/javascript">
      $(document).ready(function(e){
         $('#btn1').click(function(e){
            $(this).attr('disabled', 'disabled');
            $('#form1').submit();
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
                     $("#filtroSubtipoProcesso").append($("<option />").val('').text('# Todos'));

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
      });
   </script>
</body>
</html>
