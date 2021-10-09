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
							<h3 class="page-title">Listagem de Taxas</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="/">Administração</a></li>
								<li class="breadcrumb-item active">Listagem de Taxas</li>
							</ul>
						</div>
                        <div class="col-auto float-right ml-auto">
							<button class="btn add-btn btnCadastrarNovo" data-toggle="modal" data-target="#cadastrarTaxa"><i class="fa fa-plus"></i>Cadastrar novas Taxas</button>
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
								<h4 class="card-title mb-0">Taxas</h4>
								<p class="card-text">
									Utilize esse página para consultar todas as taxas cadastradas
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
									<table class="datatables  table table-stripped mb-0" id="getTaxas">
										<thead>
											<tr>
												<th>ID</th>
												<th>DATA</th>
                                                <th>IPCA</th>
                                                <th>TR</th>
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

    <div class="modal fade" id="cadastrarTaxa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro de Taxas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="staticEmail" class="col-sm-2 col-form-label">DATA</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="dataTaxa" name="dataTaxa" placeholder="DATA">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">IPCA</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="ipcaTaxa" name="ipcaTaxa" placeholder="IPCA">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-2 col-form-label">TR</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="trTaxa" name="trTaxa" placeholder="TR">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-dark" id="cadastroTxa">Cadastrar</button>
                </div>
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
    <script src="/assets/js/jquery.mask.min.js"></script>
	<script src="/assets/js/app.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script type="text/javascript">
        $(document).ready(function(e){

        var table = $('#getTaxas').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("taxa.get") }}',
            columns: [
                { "data": "id" },
                { "data": "data" },
                { "data": "IPCA" },
                { "data": "TR" },
            ]	 
        });

        setInterval( function () {
            table.ajax.reload( null, false ); // user paging is not reset on reload
        }, 60000 );
        $('input[name=dataTaxa]').mask('AAA/00');
        $('input[name=ipcaTaxa]').mask('00.000000');
        $('input[name=trTaxa]').mask('00.000000');

        $('#cadastroTxa').on('click',function(e){
            var dataTaxa = $('#dataTaxa').val();
            var ipcaTaxa = $('#ipcaTaxa').val();
            var trTaxa = $('#trTaxa').val();
            
            $.ajax({
                    url: '/app/taxas/cadastro',
                    data: {dataTaxa,ipcaTaxa, trTaxa},
                    method: 'get',
                    success: function(result){
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: 'Nova Taxa Cadastrada com sucesso',
                        });

                        table.reload(null,false);
                    },error: function(err){
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Ocorreu um erro ao cadaastrar a nova taxa. Atualize a página e tente novamente',
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
