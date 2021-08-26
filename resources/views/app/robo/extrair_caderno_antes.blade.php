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
							<h3 class="page-title">Extrair Cadernos</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="/">Robo</a></li>
								<li class="breadcrumb-item active">Extrair Cadernos</li>
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
					<div class="col-sm-12">
						<div class="card mb-0">
							<div class="card-header">
								<h4 class="card-title mb-0">Realizar Nova Extração</h4>
								<p class="card-text">
									Selecione uma data no campo abaixo, para realizar uma extração
								</p>
							</div>
							<div class="card-body">
                                {{ Form::open(['url' => '/app/robo/extrair-cadernos', 'id' => 'form1']) }}

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label>Selecione uma data para realizar a extração</label>
                                            {{ Form::text('data', null, ['class' => 'form-control datetimepicker', 'placeholder' => 'Digite a data para extração']) }}
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-primary" id="btn1">Extrair Dados</button>
                                        </div>
                                    </div>

                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
					<div class="col-sm-12">
						<div class="card mb-0">
							<div class="card-header">
								<h4 class="card-title mb-0">Cadernos</h4>
								<p class="card-text">
									Lista de tarefas já executadas
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
									<table class="table table-stripped mb-0">
										<thead>
											<tr>
												<th>Data</th>
                                                <th>Açoes</th>
											</tr>
										</thead>
                                        <tbody>
                                            <?php
                                                if(count($sql) > 0){
                                                    foreach($sql as $dados){
                                                        echo '
                                                            <tr>
                                                                <td>'.$dados->data_format.'</td>
                                                                <td>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações</button>
                                                                    <div class="dropdown-menu">';

                                                                        echo '<a class="dropdown-item" data-id="'.$dados->id.'" href="/app/robo/antes-expedir/'.$dados->id.'">Visualizar antes de expedir</a>';
      
                                                
                                                                    echo '
                                                                    </div>
                                                                </div>
                                                                </td>
                                                            </tr>
                                                        ';
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    {{$sql->links()}}
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
    <script src="/assets/js/moment.min.js"></script>
    <script src="/assets/js/bootstrap-datetimepicker.min.js"></script>
	<script src="/assets/js/app.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script type="text/javascript">
        $(document).ready(function(e){
            $('#btn1').click(function(e){
                var element = $(this);
                element.attr('disabled', 'disabled');
                element.html('Aguarde... ');

                $('#form1').submit();
            });

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
