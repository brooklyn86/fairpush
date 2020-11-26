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
							<h3 class="page-title">Gerênciar Setores</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="/">Administração</a></li>
								<li class="breadcrumb-item active">Gerênciar Setores</li>
							</ul>
						</div>
						<div class="col-auto float-right ml-auto">
							<a href="/app/setores/cadastrar" class="btn add-btn btnCadastrarNovo"><i class="fa fa-plus"></i> Cadastrar novo setor</a>
						</div>
					</div>
				</div>


				<!-- /Page Header -->

				<!-- Content Starts -->
                <div class="row">
					<div class="col-sm-12">
						<div class="card mb-0">
							<div class="card-header">
								<h4 class="card-title mb-0">Setores</h4>
								<p class="card-text">
									Utilize esse página para gerênciar todos os setores cadastrados
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
												<th>Setor</th>
												<th>Status</th>
												<th>Ações</th>
											</tr>
										</thead>
                                        <tbody>
                                            <?php
                                                if(count($sql) > 0){
                                                    foreach($sql as $dados){
                                                        if($dados->status == 1){
                                                            $status = '<span class="badge bg-inverse-success">Ativo</span>';
                                                        }else{
                                                            $status = '<span class="badge bg-inverse-warning">Inativo</span>';
                                                        }

                                                        echo '
                                                            <tr>
                                                                <td>'.$dados->nome.'</td>
                                                                <td>'.$status.'</td>
                                                                <td>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ações</button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item clickEditar" data-id="'.$dados->id.'" href="#">Editar</a>
                                                                        <a class="dropdown-item clickExcluir" data-id="'.$dados->id.'" href="#">Excluir</a>
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script type="text/javascript">
        $(document).ready(function(e){
            $('.clickEditar').click(function(e){
                window.location.href = '/app/setores/editar/' + $(this).attr('data-id');
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
