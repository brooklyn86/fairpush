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
    <link rel="stylesheet" type="text/css" href="https://adminlte.io/themes/AdminLTE/dist/css/AdminLTE.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="/css/util.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">  -->
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
							<h3 class="page-title">Estatística </h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="/">Administração</a></li>
								<li class="breadcrumb-item active">Estatística </li>
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
                    <div class="col-md-12">
                        <div class="card box-danger">
                            <div class="card-body">
                                <h5 class="card-title">Movimentação Etapas</h5>
                                <form name="formFiltro" action="/app/estatisticas" method="get">

                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Data Inicio</label>
                                            <input type="date" name="datainicio" class="form-control datepicker2" value="{{ $data['datainicio'] }}">
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Data Final</label>
                                            <input type="date" name="datafinal" class="form-control datepicker2" value="{{ $data['datafinal'] }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" name="btnFiltrar" class="btn btn-dark">Filtrar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="card box-primary">
                            <div class="card-body">
                            <h5 class="card-title">Movimentação Etapas</h5>

                            <?php
                                if(count($data['melhores01']) > 0){
                                    foreach($data['melhores01'] as $dados){
                                        if($data['total01'] > 0)
                                        $width = (100 * $dados['soma']) / $data['total01'];
                                        else
                                        $width = 0;

                                        echo '
                                        <p>'.$dados['nomeFuncionario'].'</p>

                                        <div class="progress active">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="'.$dados['soma'].'" aria-valuemin="0" aria-valuemax="'.$data['total01'].'" style="width: '.$width.'%;background:#'.$dados['cor'].';">
                                                <span class="">Total: '.$dados['soma'].'</span>
                                            </div>
                                        </div>
                                        ';
                                    }
                                }else{
                                    echo '<p class="card-text"><span class=""></span>Nenhuma Informação Encontrada</p>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card card-primary">

                            <div class="card-body">
                            <h5 class="card-title">Lembrete Adicionado</h5>

                            <?php
                                if(count($data['melhores02']) > 0){
                                    foreach($data['melhores02'] as $dados){
                                        if($data['total02'] > 0)
                                        $width = (100 * $dados['soma']) / $data['total02'];
                                        else
                                        $width = 0;

                                        echo '
                                        <p>'.$dados['nomeFuncionario'].'</p>

                                        <div class="progress active">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="'.$dados['soma'].'" aria-valuemin="0" aria-valuemax="'.$data['total02'].'" style="width: '.$width.'%;background:#'.$dados['cor'].';">
                                                <span class="">Total: '.$dados['soma'].'</span>
                                            </div>
                                        </div>
                                        ';
                                    }
                                }else{
                                    echo '<p class="card-text"><span class=""></span>Nenhuma Informação Encontrada</p>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card box-primary">

                            <div class="card-body">
                            <h5 class="card-title">Telefone Adicionado</h5>

                            <?php
                                if(count($data['melhores03']) > 0){
                                    foreach($data['melhores03'] as $dados){
                                        if($data['total03'] > 0)
                                        $width = (100 * $dados['soma']) / $data['total03'];
                                        else
                                        $width = 0;

                                        echo '
                                        <p>'.$dados['nomeFuncionario'].'</p>

                                        <div class="progress active">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="'.$dados['soma'].'" aria-valuemin="0" aria-valuemax="'.$data['total03'].'" style="width: '.$width.'%; background:#'.$dados['cor'].';" >
                                                <span class="">Total: '.$dados['soma'].'</span>
                                            </div>
                                        </div>
                                        ';
                                    }
                                }else{
                                    echo '<p class="card-text"><span class=""></span>Nenhuma Informação Encontrada</p>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-md-4">
                        <div class="card box-primary">
                            <div class="card-body">
                            <h5 class="card-title">Tipo de Movimentação</h5>


                            <?php
                                if(count($data['melhores04']) > 0){
                                    foreach($data['melhores04'] as $dados){

                                        if($data['total04'] > 0)
                                        $width = (100 * $dados['soma']) / $data['total04'];
                                        else
                                        $width = 0;

                                        echo '
                                        <p>'.$dados['nomeFuncionario'].'</p>

                                        <div class="progress active">
                                            <div class="progress-bar '.$dados['cor'].' " role="progressbar" aria-valuenow="'.$dados['soma'].'" aria-valuemin="0" aria-valuemax="'.$data['total04'].'" style="width: '.$width.'%">
                                                <span class="">Total: '.$dados['soma'].'</span>
                                            </div>
                                        </div>
                                        ';
                                    }
                                }else{
                                    echo '<p class="card-text"><span class=""></span>Nenhuma Informação Encontrada</p>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card box-primary">

                            <div class="card-body">
                            <h5 class="card-title">Tipo de Movimentação</h5>

                            <?php
                                if(count($data['melhores05']) > 0){
                                    foreach($data['melhores05'] as $dados){
                                        if($data['total05'] > 0)
                                        $width = (100 * $dados['soma']) / $data['total05'];
                                        else
                                        $width = 0;

                                        echo '
                                        <p>'.$dados['nomeFuncionario'].'</p>

                                        <div class="progress active">
                                            <div class="progress-bar '.$dados['cor'].'" role="progressbar" aria-valuenow="'.$dados['soma'].'" aria-valuemin="0" aria-valuemax="'.$data['total05'].'" style="width: '.$width.'%">
                                                <span class="">Total: '.$dados['soma'].'</span>
                                            </div>
                                        </div>
                                        ';
                                    }
                                }else{
                                    echo '<p class="card-text"><span class=""></span>Nenhuma Informação Encontrada</p>';
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <?php
                        if(count($data['arrayResultados']) > 0){
                            foreach($data['arrayResultados'] as $dados){
                            echo '
                            <div class="col-md-4">
                                <div class="box box-widget widget-user-2">
                                    <div class="widget-user-header">
									<!-- <div class="widget-user-header"  style="background-color: #'.$dados['cor'].'; color:#'.trim($dados['textColor']).'"> -->
                                        <div class="widget-user-image">
                                        <img class="img-circle img-fluid"  src="'.Storage::url($dados['foto']).'">
                                        </div>
                                        <h3 class="widget-user-username">'.$dados['nomeFuncionario'].'</h3>
                                        <h5 class="widget-user-desc">'.$dados['nomeFuncao'].'</h5>
                                        </div>
                                        <div class="box-footer no-padding">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Movimentação Etapas 
                                                <span class="badge text-secondary">Total: '.$dados['soma1'].'</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Lembrete Adicionado 
                                                <span class="badge text-secondary">Total: '.$dados['soma2'].'</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Completed Telefone Adicionado
                                                <span class="badge text-secondary">Total: '.$dados['soma3'].'</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Email Adicionado 
                                                <span class="badge text-secondary">Total: '.$dados['soma4'].'</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Calculo Alterado 
                                                <span class="badge text-secondary">Total: '.$dados['soma5'].'</span>
												<!-- <span class="badge bg-primary rounded-pill bg-orange">Total: '.$dados['soma5'].'</span> -->
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>';
                            }
                        }
                    ?>
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
            $('.datepicker2').mask('00/00/0000');
        });
    </script>
</body>
</html>
