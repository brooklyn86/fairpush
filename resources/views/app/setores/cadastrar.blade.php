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
							<h3 class="page-title">Cadastrar Setor</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="/">Administração</a></li>
								<li class="breadcrumb-item active">Cadastrar Setor</li>
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
								<h4 class="card-title mb-0">Setores</h4>
								<p class="card-text">
								      Digite os dados do novo setor no formulário abaixo
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

								{{ Form::open(['url' => 'app/setores/cadastrar', 'id' => 'form1']) }}
                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label>Título do Setor</label>
                                            {{ Form::text('nome', null, ['class' => 'form-control', 'placeholder' => 'Digite o título do setor']) }}
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12 mb-3">
                                            <label>Status</label>
                                            {{ Form::select('status', [
                                                '1' => 'Ativo',
                                                '0' => 'Inativo'
                                            ], null, ['class' => 'form-control']) }}
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-dark" id="btn1">Enviar</button>
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
        });
    </script>
</body>
</html>
