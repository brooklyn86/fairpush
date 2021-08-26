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
							<h3 class="page-title">Processos da Agenda</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="/">Administração</a></li>
								<li class="breadcrumb-item active">Processos da Agenda</li>
							</ul>
						</div>
					</div>
				</div>


				<!-- /Page Header -->

                <div class="row">
                    <div class="col-md-12">
                        
                    </div>
                </div>
				<!-- Content Starts -->
                <div class="row">
					<div class="col-sm-12">
						<div class="card mb-0">
							<div class="card-header">
								<h4 class="card-title mb-0">Processos da Agenda</h4>
								<p class="card-text">
									Log de Atividade de todos os usuarios.
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
									<table class="table table-stripped mb-0" id="getLog">
										<thead>
											<tr>
												<th>Processo</th>
												<th>Ordem Cronológica</th>
                                                <th>Situação</th>
                                                <th>Responsavel</th>
												<th>Valor</th>
												<th>Juros</th>
												<th>Cendente</th>
												<th>Advogado</th>
												<th>Ent. Devedora</th>
												<th>CPF</th>
											</tr>
										</thead>
                                        <tbody>
                                            
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

    <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
	<script src="/assets/js/jquery.slimscroll.min.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
	<script src="/assets/js/dataTables.bootstrap4.min.js"></script>
	<script src="/assets/js/app.js"></script>
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> -->
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script type="text/javascript">
        $(document).ready(function(e){
            $('#getLog').DataTable({
                    "dom": 'Bfrtip',
                    "processing": true,
                    "serverSide": true,
                    "searching": false,
                    "lengthChange": false,
                    "paging": true,
                    "lengthMenu": true,
                    "bInfo": false,
                    "pageLength": 100,
                    "ordering": true,
                    "buttons": [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5'
                    ],
                    "ajax": {
                    "url":  '{{ route("app.agendas.processos.lista") }}'
                    },
                    "columns": [
                        { "data": "processo_de_origem" },
                        { "data": "ordem_cronologica" },
                        { "data": "titulo" },
                        { "data": "name" },
                        { "data": "principal_bruto" },
                        { "data": "juros_moratorio" },      
                        { "data": "advogado" },      
                        { "data": "advogado" },    
                        { "data": "entidade_devedora" },    
                        { "data": "cpf" }      

                    ],
                });

            $('.clickEditar').click(function(e){
                window.location.href = '/app/usuarios/editar/' + $(this).attr('data-id');
            });
            $('.clickExcluir').click(function(e){
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Excluir Setor?',
                    text: "Tem certeza que deseja excluir esse setor!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = '/app/setores/excluir/' + id;
                    }
                });
            });
        });
    </script>
</body>
</html>
